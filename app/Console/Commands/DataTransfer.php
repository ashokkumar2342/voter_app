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


      $totalImport=DB::select(DB::raw("select ifnull(max(`sr_no`),0) as `maxid` from `voters` where `assembly_id` =$assembly->id and `assembly_part_id` =$assemblyPart->id;"));
      $maxid=$totalImport[0]->maxid;

      $datas = DB::connection('sqlsrv')->select("select SlNoInPart, C_House_no, C_House_No_V1, FM_Name_EN + ' ' + IsNULL(LastName_EN,'') as name_en, FM_Name_V1 + ' ' + isNULL(LastName_V1,'') as name_l, RLN_Type, RLN_FM_NM_EN + ' ' + IsNULL(RLN_L_NM_EN,'') as fname_en, RLN_FM_NM_V1 + ' ' + IsNULL(RLN_L_NM_V1,'') as FName_L, EPIC_No, STATUS_TYPE, GENDER, AGE, EMAIL_ID, MOBILE_NO, PHOTO from data where ac_no =$ac_code and part_no =$part_no and SlNoInPart > $maxid order by SlNoInPart");
      foreach ($datas as $key => $value) { 
       
       $name_l=str_replace('਍', '', $value->name_l);
       $name_e=substr(str_replace('਍', '', $value->name_en),0,49);
       $f_name_e=substr(str_replace('਍', '', $value->fname_en),0,49);
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
       $house_e = substr(str_replace('\\',' ', $value->C_House_no),0,49);
       $house_l = str_replace('\\',' ', $value->C_House_No_V1);
       
       $newId=DB::select(DB::raw("call up_save_voter_detail('0','$assembly->id','$assemblyPart->id','$value->SlNoInPart','$value->EPIC_No','$house_e','$house_l','','$name_e','$name_l','$f_name_e','$f_name_l','$relation','$gender_id','$value->AGE','$value->MOBILE_NO','v','$voterlistmaster->id','0');"));
        
        $image=$value->PHOTO;
        $name =$newId[0]->newid;
        $image= \Storage::disk('local')->put($vpath.'/'.$name.'.jpg', $image);
      } 
      
     }     
       
}
