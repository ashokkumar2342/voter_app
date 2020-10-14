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
       foreach ($part_no as $key => $val) { 
       $assembly=Assembly::where('code',$ac_code)->first();
       $assemblyPart=AssemblyPart::where('assembly_id',$assembly->id)->where('part_no',$val)->first();
       $datas = DB::connection('sqlsrv')->select("select SlNoInPart, C_House_no, C_House_No_V1, FM_Name_EN + ' ' + LastName_EN as name_en, FM_Name_V1 + ' ' + LastName_V1 as name_l, RLN_Type, RLN_FM_NM_EN + ' ' + RLN_L_NM_EN as fname_en, RLN_FM_NM_V1 + ' ' + RLN_L_NM_V1 as FName_L, EPIC_No, STATUS_TYPE, GENDER, AGE, EMAIL_ID, MOBILE_NO, PHOTO from data where ac_no =$ac_code and part_no =$val");
       $totalImport=Voter::where('assembly_id',$assembly->id)->where('assembly_part_id',$assemblyPart->id)->count();
    if ($totalImport==0) {  
      foreach ($datas as $key => $value) { 
       $voterImport=new Voter();
       $voterImport->assembly_id=$assembly->id;
       $voterImport->assembly_part_id=$assemblyPart->id;
       $voterImport->village_id=0;
       $voterImport->ward_id=0;
       $voterImport->print_sr_no=0;
       $voterImport->source='v';
       $voterImport->suppliment_no=$voterlistmaster->id;
       $voterImport->sr_no=$value->SlNoInPart; 
       $voterImport->house_no_l=$value->C_House_No_V1; 
       $voterImport->house_no_e=$value->C_House_no; 
       $voterImport->name_l=str_replace('਍', '', $value->name_l);
       $voterImport->name_e=str_replace('਍', '', $value->name_en);
       $voterImport->father_name_e=str_replace('਍', '', $value->fname_en);
       $voterImport->father_name_l=str_replace('਍', '', $value->FName_L);
       if ($value->RLN_Type=='F') {
        $voterImport->relation=1;  
       }
       elseif ($value->RLN_Type=='G') {
        $voterImport->relation=2;  
       } 
       elseif ($value->RLN_Type=='H') {
        $voterImport->relation=3;  
       } 
       elseif ($value->RLN_Type=='M') {
        $voterImport->relation=4;  
       } 
       elseif ($value->RLN_Type=='O') {
        $voterImport->relation=5;  
       } 
       elseif ($value->RLN_Type=='W') {
        $voterImport->relation=6;  
       } 
       $voterImport->voter_card_no=$value->EPIC_No;
       if ($value->GENDER=='M') {
        $voterImport->gender_id=1;  
       }
       elseif ($value->GENDER=='F') {
        $voterImport->gender_id=2;  
       }else{
        $voterImport->gender_id=3;  
       } 
       $voterImport->age=$value->AGE;
       $voterImport->mobile_no=$value->MOBILE_NO;
       $voterImport->save(); 
       $VoterImage=new VoterImage();
       $VoterImage->voter_id=$voterImport->id; 
       $VoterImage->image=$value->PHOTO;
       $VoterImage->save(); 
      }
    }
      $updateDatas = DB::connection('sqlsrv')->select("select SlNoInPart, C_House_no, C_House_No_V1, FM_Name_EN + ' ' + IsNULL(LastName_EN,'') as name_en, FM_Name_V1 + ' ' + IsNull(LastName_V1,'') as name_l, RLN_Type, RLN_FM_NM_EN + ' ' + IsNull(RLN_L_NM_EN,'') as fname_en, RLN_FM_NM_V1 + ' ' + IsNUll(RLN_L_NM_V1,'') as FName_L, EPIC_No, '' as STATUS_TYPE, GENDER, AGE, '' as EMAIL_ID, MOBILE_NO, PHOTO from for6_form8a_form8_66_to_90 where ac_no = $ac_code and part_no =$val union all select SlNoInPart, C_House_no, C_House_No_V1, FM_Name_EN + ' ' + IsNULL(LastName_EN,'') as name_en, FM_Name_V1 + ' ' + IsNull(LastName_V1,'') as name_l, RLN_Type, RLN_FM_NM_EN + ' ' + IsNull(RLN_L_NM_EN,'') as fname_en, RLN_FM_NM_V1 + ' ' + IsNUll(RLN_L_NM_V1,'') as FName_L, EPIC_No, '' as STATUS_TYPE, GENDER, AGE, '' as EMAIL_ID, MOBILE_NO, PHOTO from for6_form8a_form8_1_to_65 where ac_no =$ac_code and part_no =$val and form_type <> 'form7'");
      foreach ($updateDatas as $key => $value) { 
       $voterupdate=Voter::firstOrNew(['sr_no'=>$value->SlNoInPart,'assembly_id'=>$assembly->id,'assembly_part_id'=>$assemblyPart->id]);
       $voterupdate->assembly_id=$assembly->id;
       $voterupdate->assembly_part_id=$assemblyPart->id;
       $voterupdate->village_id=0;
       $voterupdate->ward_id=0;
       $voterupdate->print_sr_no=0;
       $voterupdate->source='v';
       $voterupdate->suppliment_no=$voterlistmaster->id;
       $voterupdate->sr_no=$value->SlNoInPart; 
       $voterupdate->house_no_l=$value->C_House_No_V1; 
       $voterupdate->house_no_e=$value->C_House_no; 
       $voterupdate->name_l=str_replace('਍', '', $value->name_l);
       $voterupdate->name_e=str_replace('਍', '', $value->name_en);
       $voterupdate->father_name_e=str_replace('਍', '', $value->fname_en);
       $voterupdate->father_name_l=str_replace('਍', '', $value->FName_L);
       if ($value->RLN_Type=='F') {
        $voterupdate->relation=1;  
       }
       elseif ($value->RLN_Type=='G') {
        $voterupdate->relation=2;  
       } 
       elseif ($value->RLN_Type=='H') {
        $voterupdate->relation=3;  
       } 
       elseif ($value->RLN_Type=='M') {
        $voterupdate->relation=4;  
       } 
       elseif ($value->RLN_Type=='O') {
        $voterupdate->relation=5;  
       } 
       elseif ($value->RLN_Type=='W') {
        $voterupdate->relation=6;  
       } 
       

       
       $voterupdate->voter_card_no=$value->EPIC_No;
       if ($value->GENDER=='M') {
        $voterupdate->gender_id=1;  
       }
       elseif ($value->GENDER=='F') {
        $voterupdate->gender_id=2;  
       }else{
        $voterupdate->gender_id=3;  
       } 
       $voterupdate->age=$value->AGE;
       $voterupdate->mobile_no=$value->MOBILE_NO;
       $voterupdate->save(); 
       $VoterImageUpdate=VoterImage::firstOrNew(['voter_id'=>$voterupdate->id]); 
       $VoterImageUpdate->voter_id=$voterupdate->id;
       $VoterImageUpdate->image=$value->PHOTO;
       $VoterImageUpdate->save(); 
      }
      $DeleteData = DB::connection('sqlsrv')->select("select SlNoInPart from deletions where ac_no = $ac_code and part_no =$val union select SlNoInPart from for6_form8a_form8_1_to_65  where ac_no = $ac_code and part_no =$val");
       foreach ($DeleteData  as $k => $sr_no) {
         $delete=Voter::where('sr_no',$sr_no->SlNoInPart)->where('assembly_id',$assembly->id)->where('assembly_part_id',$assemblyPart->id)->delete(); 
       } 
    }
    DB::select(DB::raw("call up_process_converthno();")); 
  }
     
       
}
