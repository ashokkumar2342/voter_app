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
use App\Model\VoterImage;
use App\Model\VoterListMaster;
use App\Model\VoterListProcessed;
use App\Model\WardVillage;
use App\Model\MainPageDetails;
use App\Model\PollingBooth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BoothVoterList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boothvotelist:generate {district_id} {block_id} {booth_id}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'boothvotelist generate';

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
    $booth_id = $this->argument('booth_id');

    $processMainPage = DB::select(DB::raw(" call `up_print_voterlist_booth`($booth_id);"));

    $VoterListProcessed=DB::select(DB::raw("Select * From `booth_voter_list` where `booth_id` = $booth_id;"));

    $dirpath = Storage_path() . $VoterListProcessed[0]->folder_path;
    @mkdir($dirpath, 0755, true);

    $path=Storage_path('fonts/');
    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir']; 
    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf_photo = new \Mpdf\Mpdf([
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

    // $voterListMaster=VoterListMaster::where('status',1)->first(); 
    // $blockcode=BlocksMc::find($block_id);
    // $wardno=WardVillage::find($ward_id); 
    // $villagename=Village::find($village_id);
    // $pollingboothdetail=PollingBooth::find($booth_id); 

    
    // if ($ward_id==0) {$WardVillages=WardVillage::where('village_id',$village_id)->get();$pagetype=1;}
    // elseif ($booth_id==0) {$WardVillages=WardVillage::where('id',$ward_id)->get();$pagetype=2;}
    // else {$WardVillages=WardVillage::where('id',$ward_id)->get();$pagetype=3;} 

    $pagetype=3;
    $WardVillages=DB::select(DB::raw("select distinct `ward_id` from `voters` where `booth_id` = $booth_id order by `ward_id`;")); 
      
    $html = view('admin.master.PrepareVoterList.voter_list_section.start_pdf');

    $html = $html.'</style></head><body>';

    
    $mpdf_photo->WriteHTML($html);
    
    
    $wardcount = 1;
    $totalpage=0;
    foreach ($WardVillages as $WardVillage) {
        if ($wardcount>1){
            $mpdf_photo->WriteHTML('<pagebreak>');
            if(fmod($totalpage, 2)==1){
                $mpdf_photo->WriteHTML('<pagebreak>');
            }    
        }
        $wardcount++;

        $booth_condition = " And `v`.`booth_id` = $booth_id";

        $voterReports = DB::select(DB::raw("select `v`.`id`, `v`.`assembly_id`, `v`.`assembly_part_id`, `v`.`print_sr_no`, `v`.`voter_card_no`, case `source` when 'V' then concat('*', `v`.`sr_no`, '/', `ap`.`part_no`) Else 'New' End as `part_srno`, `v`.`name_l`, `r`.`relation_l` as `vrelation`, `v`.`father_name_l`, `v`.`house_no_l`, `v`.`age`, `g`.`genders_l` From `voters` `v` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `v`.`gender_id` Inner Join `relation` `r` on `r`.`id` = `v`.`relation` where `v`.`ward_id` =$WardVillage->ward_id And `v`.`status` in (0,1,3) $booth_condition Order By `v`.`print_sr_no`;"));
        
        

        $mainpagedetails=MainPageDetails::where('voter_list_master_id',0)->where('ward_id',$WardVillage->ward_id)->where('booth_id',$booth_id)->count();
        if ($mainpagedetails>0){
            $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =0 and `ward_id` =$WardVillage->ward_id and `booth_id` = $booth_id;"));
            
            $voterssrnodetails = DB::select(DB::raw("Select * From `voters_srno_detail` where `id` = 0;"));

            $block_type = DB::select(DB::raw("select * From `blocks_mcs` where `id` = $block_id;"));

            $main_page_type = 0;
            if ($block_type[0]->block_mc_type_id == 1){
                $main_page_type = 1;    
            }else{
                $main_page_type = 2;
            }
            
            $votercount = count($voterReports);
            $totalpage = (int)($votercount/30);
            if ($totalpage*30<$votercount){$totalpage++;}
            $totalpage++;
            $main_page=$this->prepareMainPage($mainpagedetails, $voterssrnodetails, $totalpage, $main_page_type, 0);
            $mpdf_photo->WriteHTML($main_page);
            
        
            $printphoto = 1;
            $main_page=$this->prepareVoterDetail($voterReports, $mainpagedetails, $totalpage, $printphoto);
            $mpdf_photo->WriteHTML($main_page);
        
        }
    }

    $mpdf_photo->WriteHTML('</body></html>');
    
    
    $filepath = Storage_path() . $VoterListProcessed[0]->folder_path . $VoterListProcessed[0]->file_name;
    $mpdf_photo->Output($filepath, 'F');

    $newId=DB::select(DB::raw("Update `booth_voter_list` set `status` = 1 where `booth_id` = $booth_id;"));
    
    }


    
    public function prepareVoterDetail($voterReports, $mainpagedetails, $totalpage,$printphoto)
    {
        
        return $main_page=view('admin.master.PrepareVoterList.voter_list_section.voter_detail',compact('voterReports', 'mainpagedetails', 'totalpage', 'printphoto'));    
    }

    
    public function prepareMainPage($mainpagedetails, $voterssrnodetails, $totalpage, $main_page_type, $is_suppliment)
    {
        return $main_page=view('admin.master.PrepareVoterList.voter_list_section.main_page',compact('mainpagedetails','voterssrnodetails', 'totalpage', 'main_page_type', 'is_suppliment'));    
    }
           
}
