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
      // set_time_limit(7200);
      //\Log::info(date('Y-m-d H:i:s'));
       $voterlistmaster=VoterListMaster::where('status',1)->first(); 
       $ac_code = $this->argument('ac_code');
       $part_no = $this->argument('part_no'); 
       $assembly=Assembly::where('code',$ac_code)->first();
       $assemblyPart=AssemblyPart::where('assembly_id',$assembly->id)->where('part_no',$part_no)->first();
        
       $totalImport=DB::select(DB::raw("select ifnull(max(`sr_no`),0) as `maxid` from `voters` where `assembly_id` =$assembly->id and `assembly_part_id` =$assemblyPart->id;"));
       $maxid=$totalImport[0]->maxid;
       $datas = DB::connection('sqlsrv')->select("select SlNoInPart, C_House_no, C_House_No_V1, FM_Name_EN + ' ' + LastName_EN as name_en, FM_Name_V1 + ' ' + LastName_V1 as name_l, RLN_Type, RLN_FM_NM_EN + ' ' + RLN_L_NM_EN as fname_en, RLN_FM_NM_V1 + ' ' + RLN_L_NM_V1 as FName_L, EPIC_No, STATUS_TYPE, GENDER, AGE, EMAIL_ID, MOBILE_NO, PHOTO from data where ac_no =$ac_code and part_no =$part_no and SlNoInPart > $maxid order by SlNoInPart");
      foreach ($datas as $key => $value) { 
       // $voterImport=new Voter();
       // $voterImport->assembly_id=$assembly->id;
       // $voterImport->assembly_part_id=$assemblyPart->id;
       // $voterImport->village_id=0;
       // $voterImport->ward_id=0;
       // $voterImport->print_sr_no=0;
       // $voterImport->source='v';
       // $voterImport->suppliment_no=$voterlistmaster->id;
       // $voterImport->sr_no=$value->SlNoInPart; 
       // $voterImport->house_no_l=$value->C_House_No_V1; 
       // $voterImport->house_no_e=$value->C_House_no; 
       // $voterImport->name_l=str_replace('਍', '', $value->name_l);
       // $voterImport->name_e=str_replace('਍', '', $value->name_en);
       // $voterImport->father_name_e=str_replace('਍', '', $value->fname_en);
       // $voterImport->father_name_l=str_replace('਍', '', $value->FName_L);
       // if ($value->RLN_Type=='F') {
       //  $voterImport->relation=1;  
       // }
       // elseif ($value->RLN_Type=='G') {
       //  $voterImport->relation=2;  
       // } 
       // elseif ($value->RLN_Type=='H') {
       //  $voterImport->relation=3;  
       // } 
       // elseif ($value->RLN_Type=='M') {
       //  $voterImport->relation=4;  
       // } 
       // elseif ($value->RLN_Type=='O') {
       //  $voterImport->relation=5;  
       // } 
       // elseif ($value->RLN_Type=='W') {
       //  $voterImport->relation=6;  
       // } 
       // $voterImport->voter_card_no=$value->EPIC_No;
       // if ($value->GENDER=='M') {
       //  $voterImport->gender_id=1;  
       // }
       // elseif ($value->GENDER=='F') {
       //  $voterImport->gender_id=2;  
       // }else{
       //  $voterImport->gender_id=3;  
       // } 
       // $voterImport->age=$value->AGE;
       // $voterImport->mobile_no=$value->MOBILE_NO;
       // $voterImport->save(); 
       // $VoterImage=new VoterImage();
       // $VoterImage->voter_id=$voterImport->id; 
       // $VoterImage->image=$value->PHOTO;
       // $VoterImage->save();
       $name_l=str_replace('਍', '', $value->name_l);
       $name_e=str_replace('਍', '', $value->name_en);
       $f_name_e=str_replace('਍', '', $value->fname_en);
       $f_name_l=str_replace('਍', '', $value->FName_L);
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
       $newId=DB::select(DB::raw("call up_save_voter_detail('0','$assembly->id','$assemblyPart->id','$value->SlNoInPart','$value->EPIC_No','$value->C_House_no','$value->C_House_No_V1','','$name_e','$name_l','$f_name_e','$f_name_l','$relation','$gender_id','$value->AGE','$value->MOBILE_NO','v','$voterlistmaster->id','0');"));
        //dd($newId[0]->newid);
        $VoterImage=new VoterImage();
        $VoterImage->voter_id=$newId[0]->newid; 
        $VoterImage->image=$value->PHOTO;
        $VoterImage->save();

      } 
      $updateDatas = DB::connection('sqlsrv')->select("select SlNoInPart, C_House_no, C_House_No_V1, FM_Name_EN + ' ' + IsNULL(LastName_EN,'') as name_en, FM_Name_V1 + ' ' + IsNull(LastName_V1,'') as name_l, RLN_Type, RLN_FM_NM_EN + ' ' + IsNull(RLN_L_NM_EN,'') as fname_en, RLN_FM_NM_V1 + ' ' + IsNUll(RLN_L_NM_V1,'') as FName_L, EPIC_No, '' as STATUS_TYPE, GENDER, AGE, '' as EMAIL_ID, MOBILE_NO, PHOTO from for6_form8a_form8_66_to_90 where ac_no = $ac_code and part_no =$part_no union all select SlNoInPart, C_House_no, C_House_No_V1, FM_Name_EN + ' ' + IsNULL(LastName_EN,'') as name_en, FM_Name_V1 + ' ' + IsNull(LastName_V1,'') as name_l, RLN_Type, RLN_FM_NM_EN + ' ' + IsNull(RLN_L_NM_EN,'') as fname_en, RLN_FM_NM_V1 + ' ' + IsNUll(RLN_L_NM_V1,'') as FName_L, EPIC_No, '' as STATUS_TYPE, GENDER, AGE, '' as EMAIL_ID, MOBILE_NO, PHOTO from for6_form8a_form8_1_to_65 where ac_no =$ac_code and part_no =$part_no and form_type <> 'form7' order by SlNoInPart");
      foreach ($updateDatas as $key => $value) { 
       // $voterupdate=new Voter();
       // $voterupdate->assembly_id=$assembly->id;
       // $voterupdate->assembly_part_id=$assemblyPart->id;
       // $voterupdate->village_id=0;
       // $voterupdate->ward_id=0;
       // $voterupdate->print_sr_no=0;
       // $voterupdate->source='s';
       // $voterupdate->suppliment_no=$voterlistmaster->id;
       // $voterupdate->sr_no=$value->SlNoInPart; 
       // $voterupdate->house_no_l=$value->C_House_No_V1; 
       // $voterupdate->house_no_e=$value->C_House_no; 
       // $voterupdate->name_l=str_replace('਍', '', $value->name_l);
       // $voterupdate->name_e=str_replace('਍', '', $value->name_en);
       // $voterupdate->father_name_e=str_replace('਍', '', $value->fname_en);
       // $voterupdate->father_name_l=str_replace('਍', '', $value->FName_L);
       // if ($value->RLN_Type=='F') {
       //  $voterupdate->relation=1;  
       // }
       // elseif ($value->RLN_Type=='G') {
       //  $voterupdate->relation=2;  
       // } 
       // elseif ($value->RLN_Type=='H') {
       //  $voterupdate->relation=3;  
       // } 
       // elseif ($value->RLN_Type=='M') {
       //  $voterupdate->relation=4;  
       // } 
       // elseif ($value->RLN_Type=='O') {
       //  $voterupdate->relation=5;  
       // } 
       // elseif ($value->RLN_Type=='W') {
       //  $voterupdate->relation=6;  
       // }  
       // $voterupdate->voter_card_no=$value->EPIC_No;
       // if ($value->GENDER=='M') {
       //  $voterupdate->gender_id=1;  
       // }
       // elseif ($value->GENDER=='F') {
       //  $voterupdate->gender_id=2;  
       // }else{
       //  $voterupdate->gender_id=3;  
       // } 
       // $voterupdate->age=$value->AGE;
       // $voterupdate->mobile_no=$value->MOBILE_NO;
       // $voterupdate->save(); 
       // $VoterImageUpdate=new VoterImage(); 
       // $VoterImageUpdate->voter_id=$voterupdate->id;
       // $VoterImageUpdate->image=$value->PHOTO;
       // $VoterImageUpdate->save();
       $name_l=str_replace('਍', '', $value->name_l);
       $name_e=str_replace('਍', '', $value->name_en);
       $f_name_e=str_replace('਍', '', $value->fname_en);
       $f_name_l=str_replace('਍', '', $value->FName_L);
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
       $updateId=DB::select(DB::raw("call up_save_voter_detail('0','$assembly->id','$assemblyPart->id','$value->SlNoInPart','$value->EPIC_No','$value->C_House_no','$value->C_House_No_V1','','$name_e','$name_l','$f_name_e','$f_name_l','$relation','$gender_id','$value->AGE','$value->MOBILE_NO','v','$voterlistmaster->id','0');"));
        $VoterImage=new VoterImage();
        $VoterImage->voter_id=$updateId[0]->newid; 
        $VoterImage->image=$value->PHOTO;
        $VoterImage->save(); 
      }
      $DeleteData = DB::connection('sqlsrv')->select("select SlNoInPart from deletions where ac_no = $ac_code and part_no =$part_no union select SlNoInPart from for6_form8a_form8_1_to_65  where ac_no = $ac_code and part_no =$part_no and form_type = 'form7'");
       foreach ($DeleteData  as $k => $sr_no) {
         // $delete=Voter::where('sr_no',$sr_no->SlNoInPart)->where('assembly_id',$assembly->id)->where('assembly_part_id',$assemblyPart->id)->delete(); 
         DB::select(DB::raw("Delete From `voters` where `assembly_id` =$assembly->id and `assembly_part_id` =$assemblyPart->id and `sr_no` =$sr_no->SlNoInPart"));
       }
     } 
     
   
  
     
       
}
