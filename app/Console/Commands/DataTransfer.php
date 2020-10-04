<?php

namespace App\Console\Commands;

use App\Admin;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\History;
use App\Model\Voter;
use App\Model\VoterImage;
use App\Model\VoterListMaster;
use DB;
use Illuminate\Console\Command;

class DataTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:transfer {database} {table}';


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
      
       $database = $this->argument('database'); 
       $table = $this->argument('table');
      
       $HistoryUpdatefirst=History::where('database_name',$database)->where('table_name',$table)->first();
      
       $HistoryUpdatefirst->status=1; 
       $HistoryUpdatefirst->save();
       $condition=substr($table,0,-9);
       
       // if ($condition=='A') {
       $datas = DB::connection('sqlsrv')->table($table)->where('STATUSTYPE','<>','D')->select('SLNOINPART','HOUSE_NO_V1','HOUSE_NO_EN','FM_NAME_V1','RLN_TYPE','RLN_FM_NM_V1','MOBILE','RLN_fm_NMen','IDCARD_NO','SEX','AGE','FM_NAMEEN','JPGIMAGE')->get(); 
          
        // }
        // elseif ($condition=='S') {
        // $datas = DB::connection('sqlsrv')->table($table)->get(); 
        //   \Log::info($datas);
        // } 
       $countTotal=0;
       $assemblyCode=substr($table, -7, 3); 
       $assemblyPartCode=substr($table,4);
       $assembly=Assembly::where('code',$assemblyCode)->first();  
       $assemblyPart=AssemblyPart::where('part_no',$assemblyPartCode)->where('assembly_id',$assembly->id)->first();
       $voterlistmaster=VoterListMaster::where('status',1)->first();  
       if (empty($assembly)) {
         $response=['status'=>0,'msg'=>'assembly code does not exist'];
          return response()->json($response);   
        }
        elseif (empty($assemblyPart)) {
         $response=['status'=>0,'msg'=>'assembly Part code does not exist'];
          return response()->json($response);   
        }
      foreach ($datas as $key => $value) {
       $houseno = DB::select(DB::raw("select uf_converthno('$value->HOUSE_NO_EN')")); 
       $voterImport=new Voter();
       $voterImport->assembly_id=$assembly->id;
       $voterImport->assembly_part_id=$assemblyPart->id;
       $voterImport->village_id=0;
       $voterImport->ward_id=0;
       $voterImport->print_sr_no=0;
       $voterImport->source='v';
       $voterImport->suppliment_no=$voterlistmaster->id;
       $voterImport->sr_no=$value->SLNOINPART; 
       $voterImport->house_no=$houseno;
       $voterImport->house_no_l=$value->HOUSE_NO_V1; 
       $voterImport->house_no_e=$value->HOUSE_NO_EN; 
       $voterImport->name_l=str_replace('਍', '', $value->FM_NAME_V1);
       $voterImport->name_e=str_replace('਍', '', $value->FM_NAMEEN);
       $voterImport->father_name_e=str_replace('਍', '', $value->RLN_fm_NMen);
       $voterImport->father_name_l=str_replace('਍', '', $value->RLN_FM_NM_V1);
       $voterImport->relation=$value->RLN_TYPE;
       $voterImport->voter_card_no=$value->IDCARD_NO;
       if ($value->SEX=='M') {
        $voterImport->gender_id=1;  
       }
       elseif ($value->SEX=='F') {
        $voterImport->gender_id=2;  
       } 
       $voterImport->age=$value->AGE;
       $voterImport->save();
       $countTotal++; 
       $VoterImage=new VoterImage();
       $VoterImage->voter_id=$voterImport->id; 
       $VoterImage->image=$value->JPGIMAGE;
       $VoterImage->save();
       $HistoryUpdate=History::where('status',1)->first();
       $HistoryUpdate->count=$countTotal; 
       $HistoryUpdate->save(); 
      } 
      $History=History::where('table_name',$table)->where('status',1)->first(); 
       $History->status=2;
       $History->save();
     
       $response=['status'=>1,'msg'=>'Transfer Process start Successfully'];
          return response()->json($response); 
      
      
      

    }
       
}
