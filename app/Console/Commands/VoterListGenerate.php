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

class VoterListGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voterlist:generate {district_id} {block_id} {village_id} {ward_id} {booth_id}';


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

    $voterListMaster=VoterListMaster::where('status',1)->first(); 
    $blockcode=BlocksMc::find($block_id);
    $wardno=WardVillage::find($ward_id); 
    $villagename=Village::find($village_id);
    $pollingboothdetail=PollingBooth::find($booth_id);


    $VoterListProcessed=VoterListProcessed::where('district_id',$district_id)->where('block_id',$block_id)->where('village_id',$village_id)->where('ward_id',$ward_id)->where('voter_list_master_id',$voterListMaster->id)->where('booth_id',$booth_id)->first();


    $dirpath = Storage_path() . $VoterListProcessed->folder_path;
    @mkdir($dirpath, 0755, true);

    $path=Storage_path('fonts/');
    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir']; 
    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata']; 
    $mpdf_mainpage = new \Mpdf\Mpdf([
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

    $mpdf_wp = new \Mpdf\Mpdf([
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
      
    $html = view('admin.master.PrepareVoterList.voter_list_section.start_pdf');

    $html = $html.'</style></head><body>';

    
    $mpdf_photo->WriteHTML($html);
    $mpdf_mainpage->WriteHTML($html);
    $mpdf_wp->WriteHTML($html);
    
    if ($voterListMaster->is_supplement==0) {
        $wardcount = 1;
        $totalpage=0;
        foreach ($WardVillages as $WardVillage) {
            if ($wardcount>1){
                $mpdf_photo->WriteHTML('<pagebreak>');
                $mpdf_wp->WriteHTML('<pagebreak>');
                if(fmod($totalpage, 2)==1){
                    $mpdf_photo->WriteHTML('<pagebreak>');
                    $mpdf_wp->WriteHTML('<pagebreak>'); 
                }    
            }
            $wardcount++;

            if ($booth_id==0){$booth_condition = "";}else{$booth_condition = " And `v`.`booth_id` = $booth_id";}

            $voterReports = DB::select(DB::raw("select `v`.`id`, `v`.`assembly_id`, `v`.`assembly_part_id`, `v`.`print_sr_no`, `v`.`voter_card_no`, case `source` when 'V' then concat('*', `v`.`sr_no`, '/', `ap`.`part_no`) Else 'New' End as `part_srno`, `v`.`name_l`, `r`.`relation_l` as `vrelation`, `v`.`father_name_l`, `v`.`house_no_l`, `v`.`age`, `g`.`genders_l` From `voters` `v` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `v`.`gender_id` Inner Join `relation` `r` on `r`.`id` = `v`.`relation` where `v`.`ward_id` =$WardVillage->id And `v`.`status` in (0,1,3) $booth_condition Order By `v`.`print_sr_no`;"));
            
            

            $mainpagedetails=MainPageDetails::where('voter_list_master_id',$voterListMaster->id)->where('ward_id',$WardVillage->id)->where('booth_id',$booth_id)->count();
            if ($mainpagedetails>0){
                $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$WardVillage->id and `booth_id` = $booth_id;"));
                
                $voterssrnodetails = DB::select(DB::raw("Select * From `voters_srno_detail` where `voter_list_master_id` =$voterListMaster->id and `wardid` = $WardVillage->id And booth_id = $booth_id;"));

                $votercount = count($voterReports);
                $totalpage = (int)($votercount/30);
                if ($totalpage*30<$votercount){$totalpage++;}
                $totalpage++;
                $main_page=$this->prepareMainPage($mainpagedetails, $voterssrnodetails, $totalpage, $pagetype, 0);
                $mpdf_photo->WriteHTML($main_page);
                $mpdf_mainpage->WriteHTML($main_page);
                $mpdf_wp->WriteHTML($main_page);

            
                $printphoto = 1;
                $main_page=$this->prepareVoterDetail($voterReports, $mainpagedetails, $totalpage, $printphoto);
                $mpdf_photo->WriteHTML($main_page);
            
                $printphoto = 0;
                $main_page=$this->prepareVoterDetail($voterReports, $mainpagedetails, $totalpage, $printphoto);
                $mpdf_wp->WriteHTML($main_page);
            }
        }
    }else{ //Code For Print Suppliment
        $wardcount = 1;
        $totalpage=0;
        foreach ($WardVillages as $WardVillage) {
            if ($booth_id==0){$booth_condition = "";}else{$booth_condition = " And `v`.`booth_id` = $booth_id";}

            $mainpagedetails=MainPageDetails::where('voter_list_master_id',$voterListMaster->id)->where('ward_id',$WardVillage->id)->where('booth_id',$booth_id)->count();

            
            if ($mainpagedetails>0){

                if ($wardcount>1){
                    $mpdf_photo->WriteHTML('<pagebreak>');
                    $mpdf_wp->WriteHTML('<pagebreak>');
                    if(fmod($totalpage, 2)==1){
                        $mpdf_photo->WriteHTML('<pagebreak>');
                        $mpdf_wp->WriteHTML('<pagebreak>'); 
                    }    
                }
                $wardcount++;

                $voterReports = DB::select(DB::raw("select `v`.`id`, `v`.`assembly_id`, `v`.`assembly_part_id`, `v`.`print_sr_no`, `v`.`voter_card_no`, case `source` when 'V' then concat('*', `v`.`sr_no`, '/', `ap`.`part_no`) Else 'New' End as `part_srno`, `v`.`name_l`, `r`.`relation_l` as `vrelation`, `v`.`father_name_l`, `v`.`house_no_l`, `v`.`age`, `g`.`genders_l` From `voters` `v` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `v`.`gender_id` Inner Join `relation` `r` on `r`.`id` = `v`.`relation` where `v`.`ward_id` =$WardVillage->id And `v`.`status` = 1 and `v`.`suppliment_no` = $voterListMaster->id  $booth_condition Order By `v`.`print_sr_no`;"));

                $votermodifiedReports = DB::select(DB::raw("select `v`.`id`, `v`.`assembly_id`, `v`.`assembly_part_id`, `v`.`print_sr_no`, `v`.`voter_card_no`, case `source` when 'V' then concat('*', `v`.`sr_no`, '/', `ap`.`part_no`) Else 'New' End as `part_srno`, `v`.`name_l`, `r`.`relation_l` as `vrelation`, `v`.`father_name_l`, `v`.`house_no_l`, `v`.`age`, `g`.`genders_l` From `voters` `v` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `v`.`gender_id` Inner Join `relation` `r` on `r`.`id` = `v`.`relation` where `v`.`ward_id` =$WardVillage->id And `v`.`status` = 3 and `v`.`suppliment_no` = $voterListMaster->id  $booth_condition Order By `v`.`print_sr_no`;"));

                $voterDeletedReports = DB::select(DB::raw("select `v`.`id`, `v`.`assembly_id`, `v`.`assembly_part_id`, `v`.`print_sr_no`, `v`.`voter_card_no`, case `source` when 'V' then concat('*', `v`.`sr_no`, '/', `ap`.`part_no`) Else 'New' End as `part_srno`, `v`.`name_l`, `r`.`relation_l` as `vrelation`, `v`.`father_name_l`, `v`.`house_no_l`, `v`.`age`, `g`.`genders_l` From `voters` `v` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `v`.`gender_id` Inner Join `relation` `r` on `r`.`id` = `v`.`relation` where `v`.`ward_id` =$WardVillage->id And `v`.`status` = 2 and `v`.`suppliment_no` = $voterListMaster->id  $booth_condition Order By `v`.`print_sr_no`;"));

                $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$WardVillage->id and `booth_id` = $booth_id;"));
                
                $voterssrnodetails = DB::select(DB::raw("Select * From `voters_srno_detail` where `voter_list_master_id` =$voterListMaster->id and `wardid` = $WardVillage->id And booth_id = $booth_id;"));

                $votercount = count($voterReports);
                $votermodifiedcount = count($votermodifiedReports);
                $voterdeletedcount = count($voterDeletedReports);

                $totalnewrows = (int)($votercount/3);
                if ($totalnewrows*3<$votercount){$totalnewrows++;}

                $totalmodifiedrows = (int)($votermodifiedcount/3);
                if ($totalmodifiedrows*3<$votermodifiedcount){$totalmodifiedrows++;}

                $totaldeletedrows = (int)($voterdeletedcount/3);
                if ($totaldeletedrows*3<$voterdeletedcount){$totaldeletedrows++;}
                
                $totalRows = $totalnewrows + $totalmodifiedrows + $totaldeletedrows;
                $totalpage = (int)($totalRows/9);
                if ($totalpage*9<$totalRows){$totalpage++;}
                $totalpage++;

                $main_page=$this->prepareMainPage($mainpagedetails, $voterssrnodetails, $totalpage, $pagetype, 1);
                $mpdf_photo->WriteHTML($main_page);
                $mpdf_mainpage->WriteHTML($main_page);
                $mpdf_wp->WriteHTML($main_page);

            
                $printphoto = 1;
                if ($votercount>0){
                    $SuchiType = 'परिवर्धन सूचि';
                    $PrintedRows = 0;
                    $main_page=$this->prepareVoterDetailSuppliment($voterReports, $mainpagedetails, $totalpage, $printphoto, $SuchiType, $PrintedRows);
                    $mpdf_photo->WriteHTML($main_page);
                }

                if ($votermodifiedcount>0){
                    $SuchiType = 'संसोधन सूचि';
                    $PrintedRows = $totalnewrows;
                    $main_page=$this->prepareVoterDetailSuppliment($votermodifiedReports, $mainpagedetails, $totalpage, $printphoto, $SuchiType, $PrintedRows);
                    $mpdf_photo->WriteHTML($main_page);
                }

                if ($voterdeletedcount>0){
                    $SuchiType = 'विलोपन सूचि';
                    $PrintedRows = $totalnewrows + $totalmodifiedrows;
                    $main_page=$this->prepareVoterDetailSuppliment($voterDeletedReports, $mainpagedetails, $totalpage, $printphoto, $SuchiType, $PrintedRows);
                    $mpdf_photo->WriteHTML($main_page);
                }

                // $mpdf_photo->WriteHTML('<pagebreak>');

                $printphoto = 0;
                if ($votercount>0){
                    $SuchiType = 'परिवर्धन सूचि';
                    $PrintedRows = 0;
                    $main_page=$this->prepareVoterDetailSuppliment($voterReports, $mainpagedetails, $totalpage, $printphoto, $SuchiType, $PrintedRows);
                    $mpdf_wp->WriteHTML($main_page);
                }

                if ($votermodifiedcount>0){
                    $SuchiType = 'संसोधन सूचि';
                    $PrintedRows = $totalnewrows;
                    $main_page=$this->prepareVoterDetailSuppliment($votermodifiedReports, $mainpagedetails, $totalpage, $printphoto, $SuchiType, $PrintedRows);
                    $mpdf_wp->WriteHTML($main_page);
                }

                if ($voterdeletedcount>0){
                    $SuchiType = 'विलोपन सूचि';
                    $PrintedRows = $totalnewrows + $totalmodifiedrows;
                    $main_page=$this->prepareVoterDetailSuppliment($voterDeletedReports, $mainpagedetails, $totalpage, $printphoto, $SuchiType, $PrintedRows);
                    $mpdf_wp->WriteHTML($main_page);
                }

                if ($totalRows>0){
                    $main_page=$this->prepareWardEndSuppliment($mainpagedetails, $totalpage, $votercount, $votermodifiedcount, $voterdeletedcount, $totalnewrows, $totalmodifiedrows, $totaldeletedrows);
                    $mpdf_photo->WriteHTML($main_page);
                    $mpdf_wp->WriteHTML($main_page);
                }
                // $mpdf_wp->WriteHTML('<pagebreak>');
            }
        }
    }

    $mpdf_photo->WriteHTML('</body></html>');
    $mpdf_mainpage->WriteHTML('</body></html>');
    $mpdf_wp->WriteHTML('</body></html>');
    
    
    $filepath = Storage_path() . $VoterListProcessed->folder_path . $VoterListProcessed->file_path_h;
    $mpdf_mainpage->Output($filepath, 'F');

    $filepath = Storage_path() . $VoterListProcessed->folder_path . $VoterListProcessed->file_path_p;
    $mpdf_photo->Output($filepath, 'F');

    $filepath = Storage_path() . $VoterListProcessed->folder_path . $VoterListProcessed->file_path_w;
    $mpdf_wp->Output($filepath, 'F');


    $newId=DB::select(DB::raw("Update `voter_list_processeds` set `status` = 1 where `id` = $VoterListProcessed->id;"));

      
    }


    public function prepareWardEndSuppliment($mainpagedetails, $totalpage, $votercount, $votermodifiedcount, $voterdeletedcount, $totalnewrows, $totalmodifiedrows, $totaldeletedrows)
    {
        
        return $main_page=view('admin.master.PrepareVoterList.voter_list_section.ward_end_suppliment',compact('mainpagedetails', 'totalpage', 'votercount', 'votermodifiedcount', 'voterdeletedcount', 'totalnewrows', 'totalmodifiedrows', 'totaldeletedrows'));    
    }

    public function prepareVoterDetail($voterReports, $mainpagedetails, $totalpage,$printphoto)
    {
        
        return $main_page=view('admin.master.PrepareVoterList.voter_list_section.voter_detail',compact('voterReports', 'mainpagedetails', 'totalpage', 'printphoto'));    
    }

    public function prepareVoterDetailSuppliment($voterReports, $mainpagedetails, $totalpage,$printphoto, $SuchiType, $PrintedRows)
    {
        
        return $main_page=view('admin.master.PrepareVoterList.voter_list_section.voter_detail_suppliment',compact('voterReports', 'mainpagedetails', 'totalpage', 'printphoto', 'SuchiType', 'PrintedRows'));    
    }

    
    public function prepareMainPage($mainpagedetails, $voterssrnodetails, $totalpage, $main_page_type, $is_suppliment)
    {
        return $main_page=view('admin.master.PrepareVoterList.voter_list_section.main_page',compact('mainpagedetails','voterssrnodetails', 'totalpage', 'main_page_type', 'is_suppliment'));    
    }
    
       
}
