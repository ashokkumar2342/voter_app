<?php

namespace App\Console\Commands;

use App\Admin;
use App\Helper\MyFuncs;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\DefaultValue;
use App\Model\History;
use App\Model\Voter;
use App\Model\VoterImage;
use App\Model\VoterListMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class DataTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:transfer {ac_code} {part_no}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data Transfer ';

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
    public function handle()
    { 
      
      $voterlistmaster=VoterListMaster::where('status',1)->first(); 
      $ac_code = $this->argument('ac_code');
      $part_no = $this->argument('part_no'); 
      $assembly=Assembly::where('code',$ac_code)->first();
      $assemblyPart=AssemblyPart::where('assembly_id',$assembly->id)->where('part_no',$part_no)->first();
      
      $dirpath = Storage_path() . '/app/vimage/'.$assembly->id.'/'.$assemblyPart->id;
      $vpath = '/vimage/'.$assembly->id.'/'.$assemblyPart->id;
      @mkdir($dirpath, 0755, true);

      $truncate_tmp=DB::select(DB::raw("truncate table `tmp_voters_old`;"));

      $tmp_insert=DB::select(DB::raw("insert into `tmp_voters_old` select `district_id`, `voter_card_no`, `village_id`, `ward_id`, `print_sr_no`, `suppliment_no`, `booth_id`, `status` from `voters_old` where  `assembly_part_id` =$assemblyPart->id;"));

      $totalImport=DB::select(DB::raw("select ifnull(max(`sr_no`),0) as `maxid` from `voters` where `assembly_id` =$assembly->id and `assembly_part_id` =$assemblyPart->id;"));
      $maxid=$totalImport[0]->maxid;

      $datas = DB::connection('sqlsrv')->select("select SlNoInPart, C_House_no, C_House_No_V1, FM_Name_EN + ' ' + IsNULL(LastName_EN,'') as name_en, FM_Name_V1 + ' ' + isNULL(LastName_V1,'') as name_l, RLN_Type, RLN_FM_NM_EN + ' ' + IsNULL(RLN_L_NM_EN,'') as fname_en, RLN_FM_NM_V1 + ' ' + IsNULL(RLN_L_NM_V1,'') as FName_L, EPIC_No, STATUS_TYPE, GENDER, AGE, EMAIL_ID, MOBILE_NO, PHOTO from eroll where ac_no =$ac_code and part_no =$part_no and SlNoInPart > $maxid order by SlNoInPart");
      foreach ($datas as $key => $value) { 
        $name = $value->EPIC_No;
        $o_village_id = 0;
        $o_ward_id = 0;
        $o_print_srno = 0;
        $o_suppliment = $voterlistmaster->id;
        $o_booth_id = 0;
        $o_district_id = 0;
        $o_status = 0;
        if(strlen($name)>2){
          $mappinf_info=DB::select(DB::raw("select ifnull(`district_id`,0) as `districtid`, `village_id`, `ward_id`, ifnull(`print_sr_no`, 0) as `printsrno`, `suppliment_no`, `booth_id`, `status` from `tmp_voters_old` where `voter_card_no` = '$name' limit 1;"));
          if(empty($mappinf_info)){
            $o_village_id = 0;
          }else{
            $o_village_id = $mappinf_info[0]->village_id;
            $o_ward_id = $mappinf_info[0]->ward_id;
            $o_print_srno = $mappinf_info[0]->printsrno;
            $o_suppliment = $mappinf_info[0]->suppliment_no;
            $o_booth_id = $mappinf_info[0]->booth_id;
            $o_district_id = $mappinf_info[0]->districtid;
            $o_status = $mappinf_info[0]->status;
          }  
        }
        

        $name_l=str_replace('਍', '', $value->name_l);
        $name_l=str_replace('\'', '', $value->name_l);

        $name_e=substr(str_replace('਍', '', $value->name_en),0,49);
        $name_e=substr(str_replace('\'', '', $value->name_en),0,49);
       
        $f_name_e=substr(str_replace('਍', '', $value->fname_en),0,49);
        $f_name_e=substr(str_replace('\'', '', $value->fname_en),0,49);

        $f_name_l=str_replace('਍', '', $value->FName_L);
        $f_name_l=str_replace('\'', '', $value->FName_L);

        if ($value->RLN_Type=='F') {
          $relation=1;  
        }
        elseif ($value->RLN_Type=='G') {
          $relation=2;  
        } 
        elseif ($value->RLN_Type=='H') {
          $relation=3;  
        } 
        elseif ($value->RLN_Type=='M') {
          $relation=4;  
        } 
        elseif ($value->RLN_Type=='O') {
          $relation=5;  
        } 
        elseif ($value->RLN_Type=='W') {
          $relation=6;  
        }
        if ($value->GENDER=='M') {
          $gender_id=1;  
        }
        elseif ($value->GENDER=='F') {
          $gender_id=2;  
        }else{
          $gender_id=3;  
        }  
        $house_e = substr(str_replace('\\',' ', $value->C_House_no),0,49);
        $house_e = substr(str_replace('\'',' ', $house_e),0,49);

        $house_l = str_replace("\\",' ', $value->C_House_No_V1);
        $house_l = str_replace('\'',' ', $house_l);
        
        $newId=DB::select(DB::raw("call up_save_voter_detail($o_district_id, $assembly->id, $assemblyPart->id, $value->SlNoInPart, '$value->EPIC_No', '$house_e', '$house_l','','$name_e','$name_l','$f_name_e','$f_name_l', $relation, $gender_id, $value->AGE, '$value->MOBILE_NO', 'v', $o_suppliment, $o_status, $o_village_id, $o_ward_id, '$o_print_srno', $o_booth_id);"));
        
        $image=$value->PHOTO;
        $name = $newId[0]->newid;
        $image= \Storage::disk('local')->put($vpath.'/'.$name.'.jpg', $image);
        
        
      }


      // //Code To Modify suppliment data
      // $datas = DB::connection('sqlsrv')->select("select SlNoInPart, C_House_no, C_House_No_V1, FM_Name_EN + ' ' + IsNULL(LastName_EN,'') as name_en, FM_Name_V1 + ' ' + isNULL(LastName_V1,'') as name_l, RLN_Type, RLN_FM_NM_EN + ' ' + IsNULL(RLN_L_NM_EN,'') as fname_en, RLN_FM_NM_V1 + ' ' + IsNULL(RLN_L_NM_V1,'') as FName_L, EPIC_No, STATUS_TYPE, GENDER, AGE, EMAIL_ID, MOBILE_NO, PHOTO from data where ac_no =$ac_code and part_no =$part_no and SlNoInPart <= $maxid order by SlNoInPart");
      // foreach ($datas as $key => $value) { 
       
      //   $name_l=str_replace('਍', '', $value->name_l);
      //   $name_e=substr(str_replace('਍', '', $value->name_en),0,49);
      //   $f_name_e=substr(str_replace('਍', '', $value->fname_en),0,49);
      //   $f_name_l=str_replace('਍', '', $value->FName_L);
      //   if ($value->RLN_Type=='F') {
      //     $relation=1;  
      //   }
      //   elseif ($value->RLN_Type=='G') {
      //     $relation=2;  
      //   } 
      //   elseif ($value->RLN_Type=='H') {
      //     $relation=3;  
      //   } 
      //   elseif ($value->RLN_Type=='M') {
      //     $relation=4;  
      //   } 
      //   elseif ($value->RLN_Type=='O') {
      //     $relation=5;  
      //   } 
      //   elseif ($value->RLN_Type=='W') {
      //     $relation=6;  
      //   }
      //   if ($value->GENDER=='M') {
      //     $gender_id=1;  
      //   }
      //   elseif ($value->GENDER=='F') {
      //     $gender_id=2;  
      //   }else{
      //     $gender_id=3;  
      //   }  
      //   $house_e = substr(str_replace('\\',' ', $value->C_House_no),0,49);
      //   $house_l = str_replace('\\',' ', $value->C_House_No_V1);
         
      //   $newId=DB::select(DB::raw("call up_modify_voter_detail('$assembly->id','$assemblyPart->id','$value->SlNoInPart','$value->EPIC_No','$house_e','$house_l','','$name_e','$name_l','$f_name_e','$f_name_l','$relation','$gender_id','$value->AGE','$value->MOBILE_NO','v','$voterlistmaster->id','3');"));
        
      //   $image=$value->PHOTO;
      //   $name =$newId[0]->newid;
      //   $image= \Storage::disk('local')->put($vpath.'/'.$name.'.jpg', $image);
      // } 
      
      // //Code To Delete suppliment data
      // $datas = DB::connection('sqlsrv')->select("Select ac_no, Part_No, SlNoInPart from deletion where ac_no =$ac_code and part_no =$part_no");
      // foreach ($datas as $key => $value) { 
       
              
      //   $newId=DB::select(DB::raw("call up_delete_voter_detail('$assembly->id','$assemblyPart->id','$value->SlNoInPart','$voterlistmaster->id','2');"));
        
      // }

     }     
       
}
