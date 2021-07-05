<?php
namespace App\Http\Controllers\Admin;
use App\Admin;
use App\Events\SmsEvent;
use App\Helper\MyFuncs;
use App\Http\Controllers\Controller;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\BlocksMc;
use App\Model\District;
use App\Model\History;
use App\Model\Village;
use App\Model\Voter;
use App\Model\VoterImage;
use App\Model\VoterListMaster;
use App\Model\WardVillage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DatabaseConnectionController extends Controller
{
    
    public function DatabaseConnection()
    {
        try {
            $serverName=getenv('DB_HOST_2');
            $database=getenv('DB_DATABASE_2');
            $username=getenv('DB_USERNAME_2');
            $passward=getenv('DB_PASSWORD_2'); 
            return view('admin.DatabaseConnection.form',compact('serverName','database','username','passward'));    
        } catch (Exception $e) {
           return $e; 
        }
       
    }

       public static function changeEnvironmentVariable($key,$value)
      {
        $path = base_path('.env');

        if(is_bool(env($key)))
        {
            $old = env($key)? 'true' : 'false';
        }
        elseif(env($key)===null){
            $old = 'null';
        }
        else{
            $old = env($key);
        }

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                "$key=".$old, "$key=".$value, file_get_contents($path)
            ));
        }
     } 

    public function ConnectionStore(Request $request)
    {
        try {   
            //   $data=['hostname'=>$request->ip,'database'=>$request->database,'username'=>$request->user_name,'password'=>$request->password];
            // Storage::put('file.json',json_encode($data)); 

              $this->changeEnvironmentVariable('DB_HOST_2',$request->ip);
              $this->changeEnvironmentVariable('DB_DATABASE_2',$request->database);
              $this->changeEnvironmentVariable('DB_USERNAME_2',$request->user_name);
              $this->changeEnvironmentVariable('DB_PASSWORD_2',$request->password);
              
     
             \Artisan::call('config:cache');
            \Artisan::call('config:clear');
            \Artisan::call('cache:clear'); 
            // Config::set('database.connections.sqlsrv.database', 'A067');

            //     DB::purge('A067');
            //     DB::reconnect('A067');

            // $ipinfoAPI="http://localhost:8001/api/datastore/".$request->ip.'/'.$request->database.'/'.$request->user_name.'/'.$request->password;
            // $json =file_get_contents($ipinfoAPI);
            // $data= (array) json_decode($json);
           $response=['status'=>1,'msg'=>'Connection Successfully'];
          return response()->json($response);
        } catch (Exception $e) {
           return $e; 
        } 
    }
    public function getTable()
    {
         // $contents = Storage::get('file.json');
         // $conn =(array) json_decode($contents);
         // $datas = DB::connection('sqlsrv')->select('SELECT * FROM information_schema.tables order BY [TABLE_NAME]'); 
         $assemblys=Assembly::orderBy('code','ASC')->get(); 
         return view('admin.DatabaseConnection.table',compact('assemblys')); 
             
    }
    public function assemblyWisePartNo(Request $request)
    {  
        $partnos=DB::select(DB::raw("select `ap`.`id`, `ap`.`part_no`, `ap`.`assembly_id`, count(`v`.`id`) as `rtotal` from `assembly_parts` `ap` Left Join `voters` `v` on `v`.`assembly_part_id` = `ap`.`id` Where `ap`.`assembly_id` =$request->id Group by `ap`.`id`, `ap`.`part_no`, `ap`.`assembly_id` Order By `ap`.`part_no`")); 
        return view('admin.DatabaseConnection.part_no_value',compact('partnos')); 
    } 
    public function tableRecordStore(Request $request)
    {   
        
      $assembly=Assembly::find($request->ac_code);
      foreach ($request->part_no as $key => $part_no) {
      \Artisan::queue('data:transfer',['ac_code'=>$assembly->code,'part_no'=>$part_no]); 
      }
       
     $response=['status'=>1,'msg'=>'Submit Successfully'];
          return response()->json($response);
    } 

      
   public function processDelete($ac_id,$part_id)
   {  
     DB::select(DB::raw("call up_delete_part_port_voter ('$ac_id','$part_id')"));
      return redirect()->back()->with(['message'=>'Delete Successfully','class'=>'success']);  
   }  
     
    
   public function MysqlDataTransfer()
   {
     $Districts=District::orderBy('name_e','ASC')->get();
     return view('admin.DatabaseConnection.mysqldatatransfer.index',compact('Districts'));      
   }
   public function MysqlDataTransferDistrictWiseBlock(Request $request)
   {
     $blocks=BlocksMc::where('districts_id',$request->id)->orderBy('name_e','ASC')->get();
     return view('admin.DatabaseConnection.mysqldatatransfer.block_select_box',compact('blocks'));     
   }
   public function MysqlDataTransferBlockWiseVillage(Request $request)
   {
     $villages=Village::where('blocks_id',$request->id)->orderBy('name_e','ASC')->get();
     return view('admin.DatabaseConnection.mysqldatatransfer.village_select_box',compact('villages'));     
   }
   public function MysqlDataTransferVillageWiseWard(Request $request)
   {
     $wards=WardVillage::where('village_id',$request->id)->orderBy('ward_no','ASC')->get();
     return view('admin.DatabaseConnection.mysqldatatransfer.ward_select_box',compact('wards'));     
   }
   public function MysqlDataTransferStore(Request $request)
  {   
      \Artisan::queue('mysqldata:transfer',['district_id'=>$request->district_id,'block_id'=>$request->block_id,'village_id'=>$request->village_id,'ward_id'=>$request->ward_id]);

      $response=['status'=>1,'msg'=>'Submit Successfully'];
          return response()->json($response);
  }      
}
