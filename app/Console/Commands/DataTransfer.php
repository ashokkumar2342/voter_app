<?php

namespace App\Console\Commands;

use App\Admin;
 
use App\Model\Voter;
use App\Model\VoterImage;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\History;
use Illuminate\Console\Command;
use DB;
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
      return $condition=substr($table,0,-9);
       if ($condition=='A') {
       $datas = DB::connection('sqlsrv')->table($table)->where('STATUSTYPE','<>','D')->select('SLNOINPART','HOUSE_NO_V1','HOUSE_NO_EN','FM_NAME_V1','RLN_TYPE','RLN_FM_NM_V1','MOBILE','RLN_fm_NMen','IDCARD_NO','SEX','AGE','FM_NAMEEN','JPGIMAGE')->get(); 
          
        }
        elseif ($condition=='S') {
        $datas = DB::connection('sqlsrv')->table($table)->get(); 
          \Log::info($datas);
        } 
       $countTotal=0;
       $assemblyCode=substr($table, -7, 3); 
       $assemblyPartCode=substr($table,4);
       $assembly=Assembly::where('code',$assemblyCode)->first();  
       $assemblyPart=AssemblyPart::where('part_no',$assemblyPartCode)->where('assembly_id',$assembly->id)->first(); 
       if (empty($assembly)) {
         $response=['status'=>0,'msg'=>'assembly code does not exist'];
          return response()->json($response);   
        }
        elseif (empty($assemblyPart)) {
         $response=['status'=>0,'msg'=>'assembly Part code does not exist'];
          return response()->json($response);   
        }
      foreach ($datas as $key => $value) { 
       $AssemblyPart=new Voter();
       $AssemblyPart->assembly_id=$assembly->id;
       $AssemblyPart->assembly_part_id=$assemblyPart->id;
       $AssemblyPart->village_id=0;
       $AssemblyPart->ward_id=0;
       $AssemblyPart->print_sr_no=0;
       $AssemblyPart->source='v';
       $AssemblyPart->suppliment_no=0;
       $AssemblyPart->sr_no=$value->SLNOINPART;
       $AssemblyPart->house_no=trim($value->HOUSE_NO_EN,"abcdefghijklmnopqrstuvwxyz!");
       $AssemblyPart->house_no_l=$value->HOUSE_NO_V1; 
       $AssemblyPart->house_no_e=$value->HOUSE_NO_EN; 
       $AssemblyPart->name_l=str_replace('਍', '', $value->FM_NAME_V1);
       $AssemblyPart->name_e=str_replace('਍', '', $value->FM_NAMEEN);
       $AssemblyPart->father_name_e=str_replace('਍', '', $value->RLN_fm_NMen);
       $AssemblyPart->father_name_l=str_replace('਍', '', $value->RLN_FM_NM_V1);
       $AssemblyPart->relation=$value->RLN_TYPE;
       $AssemblyPart->voter_card_no=$value->IDCARD_NO;
       $AssemblyPart->gender_id=$value->SEX;
       $AssemblyPart->age=$value->AGE;
       $AssemblyPart->save();
       $countTotal++; 
       $VoterImage=new VoterImage();
       $VoterImage->voter_id=1; 
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
