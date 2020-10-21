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
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VoterListGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voterlist:generate {district_id} {block_id} {village_id} {ward_id}';


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
    ini_set("pcre.backtrack_limit", "5000000");
    $district_id = $this->argument('district_id');
    $block_id = $this->argument('block_id'); 
    $village_id = $this->argument('village_id'); 
    $ward_id = $this->argument('ward_id');

    $voterListMaster=VoterListMaster::where('status',1)->first(); 
    $blockcode=BlocksMc::find($block_id);
    $wardno=WardVillage::find($ward_id); 
    $villagename=Village::find($village_id);
    
    $VoterListProcessed=VoterListProcessed::where('district_id',$district_id)->where('block_id',$block_id)->where('village_id',$village_id)->where('ward_id',$ward_id)->where('voter_list_master_id',$voterListMaster->id)->first();


    $dirpath = Storage_path() . $VoterListProcessed->folder_path;
    @mkdir($dirpath, 0755, true);

    $path=Storage_path('fonts/');
    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir']; 
    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata']; 
    $mpdf = new \Mpdf\Mpdf([
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
    

    $htmlphoto ='';
    $htmlwithoutphoto ='';
    $htmmainpage = '';


    if ($ward_id==0) {$WardVillages=WardVillage::where('village_id',$village_id)->get();$pagetype=1;}
    else{$WardVillages=WardVillage::where('id',$ward_id)->get();$pagetype=2;}  
      
    $html = view('admin.master.PrepareVoterList.voter_list_section.start_pdf');
    

    // foreach ($WardVillages as $WardVillage) {
    //     $main_page=$this->prepareHeaderFooter($voterListMaster,$WardVillage->id);
    //     $html= $html.$main_page;
    //     }

    $html = $html.'</style></head><body>';

    // foreach ($WardVillages as $WardVillage) {
    //     $main_page=$this->prepareHeaderFooterbody($voterListMaster,$WardVillage->id);
    //     $html= $html.$main_page; 
    //     }    

    $htmlphoto =$html;
    $htmlwithoutphoto =$html;
    $htmmainpage = $html;

    $mpdf_photo->WriteHTML($html);
    
    if ($voterListMaster->is_supplement==0) {
        $wardcount = 1;
        foreach ($WardVillages as $WardVillage) {
            if ($wardcount>1){
                $htmlphoto= $htmlphoto.'<pagebreak>';
                $htmlwithoutphoto= $htmlwithoutphoto.'<pagebreak>';
                $mpdf_photo->WriteHTML('<pagebreak>');
                if(fmod($totalpage, 2)==1){
                   $htmlphoto= $htmlphoto.'<pagebreak>';
                   $htmlwithoutphoto= $htmlwithoutphoto.'<pagebreak>';
                   $mpdf_photo->WriteHTML('<pagebreak>'); 
                }    
            }
            $wardcount++;

            $voterReports = DB::select(DB::raw("select `v`.`id`, `v`.`print_sr_no`, `v`.`voter_card_no`, case `source` when 'V' then concat('*', `v`.`sr_no`, '/', `ap`.`part_no`) Else 'New' End as `part_srno`, `v`.`name_l`, `r`.`relation_l` as `vrelation`, `v`.`father_name_l`, `v`.`house_no_l`, `v`.`age`, `g`.`genders_l`, `v`.`image` From `voters` `v` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `v`.`gender_id` Inner Join `relation` `r` on `r`.`id` = `v`.`relation` where `v`.`ward_id` =$WardVillage->id And `v`.`status` in (0,1,3) Order By `v`.`print_sr_no`;"));
            
            $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$WardVillage->id;"));
            
            $voterssrnodetails = DB::select(DB::raw("Select * From `voters_srno_detail` where `voter_list_master_id` =$voterListMaster->id and `wardid` = $WardVillage->id;"));

            $votercount = count($voterReports);
            $totalpage = (int)($votercount/30);
            if ($totalpage*30<$votercount){$totalpage++;}
            $totalpage++;

            $main_page=$this->prepareMainPage($mainpagedetails, $voterssrnodetails, $totalpage, $pagetype);
            $htmlphoto =$htmlphoto.$main_page;
            $htmlwithoutphoto =$htmlwithoutphoto.$main_page;
            $htmmainpage = $htmmainpage.$main_page;
            $mpdf_photo->WriteHTML($main_page);

            // $html= $html.$main_page;

            $printphoto = 1;
            $main_page=$this->prepareVoterDetail($voterReports, $mainpagedetails, $totalpage, $printphoto);
            $htmlphoto =$htmlphoto.$main_page;
            $mpdf_photo->WriteHTML($main_page);
            
            $printphoto = 0;
            $main_page=$this->prepareVoterDetail($voterReports, $mainpagedetails, $totalpage, $printphoto);
            $htmlwithoutphoto =$htmlwithoutphoto.$main_page;

            // $html= $html.$main_page;

            // $main_page=$this->prepareMainPage($voterListMaster,$WardVillage->id,$pagetype);
            // $html= $html.$main_page;

            // $printphoto = 1;
            // $main_page=$this->prepareVoterDetail($voterListMaster, $WardVillage->id,$printphoto);
            // $html= $html.$main_page;            

            // $html= $html.'</div>';
        }
    }
    
         
    $htmlphoto =$htmlphoto.'</body></html>';
    $htmlwithoutphoto =$htmlwithoutphoto.'</body></html>';
    $htmmainpage = $htmmainpage.'</body></html>';
    $mpdf_photo->WriteHTML('</body></html>');
    
    // $html= $html.'</body></html>';   
    
    

    

    // $mpdf = new \Mpdf\Mpdf();
    // $mpdf->useOddEven = 1;


    
    // $filepath = Storage_path() . $VoterListProcessed->folder_path . $VoterListProcessed->file_path_p;
    // $mpdf->WriteHTML($htmlphoto);    
    // $mpdf->Output($filepath, 'F');

    // $filepath = Storage_path() . $VoterListProcessed->folder_path . $VoterListProcessed->file_path_w;
    // $mpdf->WriteHTML($htmlwithoutphoto);    
    // $mpdf->Output($filepath, 'F');

    $filepath = Storage_path() . $VoterListProcessed->folder_path . $VoterListProcessed->file_path_h;
    $mpdf->WriteHTML($htmmainpage);    
    $mpdf->Output($filepath, 'F');

    $filepath = Storage_path() . $VoterListProcessed->folder_path . $VoterListProcessed->file_path_p;
    $mpdf_photo->Output($filepath, 'F');

    // $mpdf->WriteHTML($html);
    // if ($ward_id==0) {
    //     $documentUrl = Storage_path() . '/app/voter/'.$voterListMaster->id.'/'.'panchayat';   
    //     @mkdir($documentUrl, 0755, true);  
    //     $mpdf->Output($documentUrl.'/'.'p_'.$blockcode->code.'_'.$villagename->name_e.'.pdf', 'F');
    // }
    //  else{
    //     $documentUrl = Storage_path() . '/app/voter/'.$voterListMaster->id.'/'.'mc';   
    //     @mkdir($documentUrl, 0755, true);  
    //     $mpdf->Output($documentUrl.'/'.'p_'.$blockcode->name_e.'_'.$wardno->ward_no.'.pdf', 'F');  

    // } 
       
      
    }

    public function prepareVoterDetail($voterReports, $mainpagedetails, $totalpage,$printphoto)
    {
        
        return $main_page=view('admin.master.PrepareVoterList.voter_list_section.voter_detail',compact('voterReports', 'mainpagedetails', 'totalpage', 'printphoto'));    
    }

    // public function prepareVoterDetail($voterListMaster,$ward_id,$printphoto)
    // {
    //     $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$ward_id;"));

    //     $voterReports = DB::select(DB::raw("select `v`.`id`, `v`.`print_sr_no`, `v`.`voter_card_no`, case `source` when 'V' then concat('*', `ap`.`part_no`, '/', `v`.`sr_no`) Else 'New' End as `part_srno`, `v`.`name_l`, `r`.`relation_l` as `vrelation`, `v`.`father_name_l`, `v`.`house_no_l`, `v`.`age`, `g`.`genders_l`, `v`.`image` From `voters` `v` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `v`.`gender_id` Inner Join `relation` `r` on `r`.`id` = `v`.`relation` where `v`.`ward_id` =$ward_id And `v`.`status` in (0,1,3) Order By `v`.`print_sr_no`;"));

    //     return $main_page=view('admin.master.PrepareVoterList.voter_list_section.voter_detail',compact('voterReports', 'mainpagedetails', 'printphoto'));    
    // }

    public function prepareHeaderFooterbody($voterListMaster,$ward_id)
    {
        $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$ward_id;"));

        return $main_page=view('admin.master.PrepareVoterList.voter_list_section.header_footer_body',compact('mainpagedetails'));    
    }

    public function prepareHeaderFooter($voterListMaster,$ward_id)
    {
        $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$ward_id;"));

        return $main_page=view('admin.master.PrepareVoterList.voter_list_section.header_footer',compact('mainpagedetails'));
    }

    public function prepareMainPage($mainpagedetails, $voterssrnodetails, $totalpage, $main_page_type)
    {
        return $main_page=view('admin.master.PrepareVoterList.voter_list_section.main_page',compact('mainpagedetails','voterssrnodetails', 'totalpage', 'main_page_type'));    
    }

    // public function prepareMainPage($voterListMaster,$ward_id,$main_page_type)
    // {
    //     $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$ward_id;"));

    //     $voterssrnodetails = DB::select(DB::raw("Select * From `voters_srno_detail` where `voter_list_master_id` =$voterListMaster->id and `wardid` = $ward_id;"));
    //     return $main_page=view('admin.master.PrepareVoterList.voter_list_section.main_page',compact('mainpagedetails','voterssrnodetails','main_page_type'));    
    // }
    
       
}
