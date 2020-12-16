<?php

namespace App\Console\Commands;

use App\Admin;
use App\Helper\MyFuncs;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\BlocksMc;
use App\Model\DefaultValue;
use App\Model\History;
use App\Model\Village;
use App\Model\Voter;
use App\Model\VoterSlipProcessed;
use App\Model\WardVillage;
use App\Model\PollingBooth;
use App\Model\PollingDayTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrepareVoterSlip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'preparevoterslip:generate {district_id} {block_id} {village_id} {ward_id} {booth_id}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'voterlist generate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    //\Log::info(date('Y-m-d H:i:s'));
    public function handle()
    { 
    ini_set('max_execution_time', '3600');
    ini_set('memory_limit','999M');
    ini_set("pcre.backtrack_limit", "100000000");
    $district_id = $this->argument('district_id');
    $block_id = $this->argument('block_id'); 
    $village_id = $this->argument('village_id'); 
    $ward_id = $this->argument('ward_id');
    $booth_id = $this->argument('booth_id');

    $blockcode=BlocksMc::find($block_id);
    $wardno=WardVillage::find($ward_id); 
    $villagename=Village::find($village_id);
    $pollingboothdetail=PollingBooth::find($booth_id);
    
    $VoterSlipProcessed=VoterSlipProcessed::where('district_id',$district_id)->where('block_id',$block_id)->where('village_id',$village_id)->where('ward_id',$ward_id)->where('booth_id',$booth_id)->first();


    $dirpath = Storage_path() . $VoterSlipProcessed->folder_path;
    @mkdir($dirpath, 0755, true);

    $path=Storage_path('fonts/');
    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir']; 
    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata']; 
    $mpdf_slip = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
                 __DIR__ . $path,
             ]),
             'fontdata' => $fontData + [
                 'frutiger' => [
                     'R' => 'FreeSans.ttf',
                     'I' => 'FreeSansOblique.ttf',
                 ]
             ],
             'default_font' => 'freesans',
         ]);

    

    if ($ward_id==0) {$WardVillages=WardVillage::where('village_id',$village_id)->get();$pagetype=1;}
    elseif ($booth_id==0) {$WardVillages=WardVillage::where('id',$ward_id)->get();$pagetype=2;}
    else {$WardVillages=WardVillage::where('id',$ward_id)->get();$pagetype=3;}  
    
    $query = "select * from `voter_list_master` where `status` = 1;";
    $voterListMaster = DB::select(DB::raw("$query"));

    $query = "select * from `blocks_mcs` where `id` = $block_id;";
    $blockMcs = DB::select(DB::raw("$query"));

    if ($blockMcs[0]->block_mc_type_id==1){
        $slipheader = 'पंचायत ('.$blockMcs[0]->name_l.') '.$voterListMaster[0]->remarks1.' - '.$voterListMaster[0]->year_base;
    }else{
        $slipheader = $blockMcs[0]->name_l.' '.$voterListMaster[0]->remarks1.' - '.$voterListMaster[0]->year_base;
    }


    $html = view('admin.master.PrepareVoterList.voter_list_section.start_pdf');

    $html = $html.'</style></head><body>';

    
    $mpdf_slip->WriteHTML($html);
    
    $wardcount = 1;
    foreach ($WardVillages as $WardVillage) {
        if ($wardcount>1){
            $mpdf_slip->WriteHTML('<pagebreak>');    
        }
        $wardcount++;
        $ward_no = $WardVillage->ward_no;

        if ($booth_id==0){$booth_condition = "";}else{$booth_condition = " And `v`.`booth_id` = $booth_id";}

        // $booth_condition = "";
        $query = "select `v`.`id`, `v`.`assembly_id`, `v`.`assembly_part_id`, `v`.`print_sr_no`, `v`.`voter_card_no`, `ap`.`part_no`, `v`.`name_l`, `r`.`relation_l` as `vrelation`, `v`.`father_name_l`, `g`.`genders_l`, concat(`pb`.`booth_no`, `pb`.`booth_no_c`) as `boothno`, `pb`.`name_l` as `pb_name` From `voters` `v` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `v`.`gender_id` Inner Join `relation` `r` on `r`.`id` = `v`.`relation` left join `polling_booths` `pb` on `pb`.`id` = `v`.`booth_id` where `v`.`ward_id` =$WardVillage->id And `v`.`status` in (0,1,3) $booth_condition Order By `v`.`print_sr_no`;";
        // dd($query);
        $voterReports = DB::select(DB::raw("$query"));
        
        $polldatetime = PollingDayTime::where('block_id',$block_id)->first();

        $main_page=$this->prepareVoterSlip($voterReports, $ward_no, $polldatetime, $slipheader, $blockMcs);
        $mpdf_slip->WriteHTML($main_page);
    
    }
    
         
    $mpdf_slip->WriteHTML('</body></html>');
    
    
    $filepath = Storage_path() . $VoterSlipProcessed->folder_path .'/'. $VoterSlipProcessed->file_path;
    $mpdf_slip->Output($filepath, 'F');

    
    $newId=DB::select(DB::raw("Update `voter_slip_processed` set `status` = 1 where `id` = $VoterSlipProcessed->id;"));

      
    }

    public function prepareVoterSlip($voterReports, $wardno, $polldatetime, $slipheader, $blockMcs)
    {
        
        return $main_page=view('admin.master.PrepareVoterSlip.slip',compact('voterReports', 'wardno', 'polldatetime', 'slipheader', 'blockMcs'));    
    }
       
}


