<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\BlocksMc;
use App\Model\District;
use App\Model\Gender;
use App\Model\State;
use App\Model\UserActivity;
use App\Model\Village;
use App\Model\Voter;
use App\Model\VoterImage;
use App\Model\VoterListMaster;
use App\Model\VoterListProcessed;
use App\Model\WardVillage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Imagick;
use PDF;
use TCPDF;

class PrepareVoterListController extends Controller
{
    public function PrepareVoterListGenerate(Request $request)
    {   
        $rules=[            
            'district' => 'required', 
            'block' => 'required', 
            'village' => 'required',            
            'ward' => 'required',            
            'booth' => 'required',            
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $response=array();
            $response["status"]=0;
            $response["msg"]=$errors[0];
        return response()->json($response);// response as json
       }
       $village=Village::find($request->village); 
      if ($request->proses_by==1) {
            if ($village->is_locked==1) {
              $response=array();
              $response["status"]=0;
              $response["msg"]='village is locked';
              return response()->json($response);  
            }
            if ($request->ward==0) {
              $PrepareVoterListSave= DB::
              select(DB::raw("call up_process_village_voterlist ('$request->village')"));
            }
            elseif ($request->booth == 0){
              $PrepareVoterListSave= DB::
              select(DB::raw("call up_process_voterlist ('$request->ward')")); 
            }
            else{
              $PrepareVoterListSave= DB::
              select(DB::raw("call up_process_voterlist_booth ('$request->ward', '$request->booth')")); 
            } 
          \Artisan::queue('voterlist:generate',['district_id'=>$request->district,'block_id'=>$request->block,'village_id'=>$request->village,'ward_id'=>$request->ward,'booth_id'=>$request->booth]);
           }
      else if($request->proses_by==2) {
           if ($request->ward==0) {
              $unlock_village_voterlist = DB::
              select(DB::raw("call up_unlock_village_voterlist ('$request->village')"));
           }
           elseif ($request->booth == 0){
              $unlock_village_voterlist = DB::
              select(DB::raw("call up_unlock_voterlist ('$request->ward')"));
            }
            else{
              $unlock_village_voterlist = DB::
              select(DB::raw("call up_unlock_voterlist_booth ('$request->ward', '$request->booth')"));  
            }
      
     $response=['status'=>1,'msg'=>'Unlock Successfully'];
     return response()->json($response);
     }
     $response=['status'=>1,'msg'=>'Submit Successfully'];
     return response()->json($response);
    }  
}
