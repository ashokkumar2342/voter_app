<?php
namespace App\Http\Controllers\Admin;
use App\Admin;
use App\Events\SmsEvent;
use App\Http\Controllers\Controller;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\History;
use App\Model\Voter;
use App\Model\VoterImage;
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
            return view('admin.DatabaseConnection.form');    
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
              $data=['hostname'=>$request->ip,'database'=>$request->database,'username'=>$request->user_name,'password'=>$request->password];
            Storage::put('file.json',json_encode($data)); 

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
         $contents = Storage::get('file.json');
         $conn =(array) json_decode($contents);
         $datas = DB::connection('sqlsrv')->select('SELECT * FROM information_schema.tables order BY [TABLE_NAME]'); 
         return view('admin.DatabaseConnection.table',compact('datas')); 
             
    } 
    public function tableRecordStore(Request $request)
    {   
      foreach ($request->table as $key => $val) {
       $assemblyCode=substr($val, -7, 3); 
       $assemblyPartCode=substr($val,4);
       $assembly=Assembly::where('code',$assemblyCode)->first();  
       $assemblyPart=AssemblyPart::where('part_no',$assemblyPartCode)->where('assembly_id',$assembly->id)->first();
       $history=History::where('table_name',$val)->where('status',2)->first(); 
       if (empty($assembly)) {
         $response=['status'=>0,'msg'=>$val.' Assembly code does not exist'];
          return response()->json($response);   
        }
        elseif (empty($assemblyPart)) {
         $response=['status'=>0,'msg'=>$val.' Assembly Part code does not exist'];
          return response()->json($response);   
        }
        elseif (!empty($history)) {
         $response=['status'=>0,'msg'=>$val.' This Table Record Already Import'];
          return response()->json($response);   
        }
      }

        foreach ($request->table as $key => $val) { 
        $Oldcount = DB::connection('sqlsrv')->table($val)->count();
        $History=new History();
       $History->old_count=$Oldcount;
       $History->count=0;
       $History->database_name=$request->database_name;
       $History->table_name=$val;
       $History->status=0;
       $History->save(); 
      \Artisan::queue('data:transfer',['database'=>$request->database_name,'table'=>$val]);

      }
       $response=['status'=>1,'msg'=>'Transfer Process Start'];
          return response()->json($response); 
    } 

     public function process(){
      $history=History::where('status',1)->first();
      if (empty($history)) {
         return '';
      }
      return view('admin.DatabaseConnection.progres_page',compact('history'));    
     }
     public function processDelete($table)
     {
        // $datas = DB::connection('sqlsrv')->table($table)->pluck('SLNOINPART')->toArray();
        // $voters=Voter::whereIn('sr_no',$datas)->get();
        // set_time_limit(7200);
        // foreach ($voters as $value) {
        //  $value->delete();    
        // }
       DB::select(DB::raw("call up_delete_part_port_voter ('$table')"));
        return redirect()->back()->with(['message'=>'Delete Successfully','class'=>'success']);  
     }  
     
    
        
}
