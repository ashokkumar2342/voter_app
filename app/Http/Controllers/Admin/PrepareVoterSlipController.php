<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\BlocksMc;
use App\Model\District;
use App\Model\Gender;
use App\Model\PollingBooth;
use App\Model\State;
use App\Model\UserActivity;
use App\Model\Village;
use App\Model\Voter;
use App\Model\VoterImage;
use App\Model\VoterListMaster;
use App\Model\VoterListProcessed;
use App\Model\VoterSlipProcessed;
use App\Model\WardVillage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Imagick;
use PDF;
use TCPDF;

class PrepareVoterSlipController extends Controller
{ 
    public function index($value='')
    {   
      $Districts= District::orderBy('name_e','ASC')->get();
      return view('admin.master.PrepareVoterSlip.index',compact('Districts'));
    }
    public function villageWiseWard(Request $request)
    {
      $wards=WardVillage::where('village_id',$request->village_id)->orderBy('ward_no','ASC')->get();
      return view('admin.master.PrepareVoterSlip.ward_select_box',compact('wards'));   
    }
    public function villageWiseBooth(Request $request)
    {
        if ($request->ward_id!=0) { 
            $booths=PollingBooth::where('village_id',$request->village_id)->orderBy('booth_no','ASC')->get();
        }else{
           $booths=[]; 
        }
        return view('admin.master.PrepareVoterSlip.booth_select_box',compact('booths'));   
    }
    public function PrepareVoterSlipGenerate(Request $request)
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
       $PrepareVoterSlipSave= DB::
              select(DB::raw("call up_process_voter_slip ($request->district, $request->block, $request->village, $request->ward, $request->booth)"));

        \Artisan::queue('preparevoterslip:generate',['district_id'=>$request->district,'block_id'=>$request->block,'village_id'=>$request->village,'ward_id'=>$request->ward,'booth_id'=>$request->booth]);
        $response=['status'=>1,'msg'=>'Submit Successfully'];
        return response()->json($response);
    }
    public function PrepareVoterSlipDownload( )
    {
      $States= State::orderBy('name_e','ASC')->get();    
      $voterListMasters= VoterListMaster::orderBy('id','ASC')->get();    
        return view('admin.master.PrepareVoterSlip.download',compact('States','voterListMasters'));    
    }
    public function PrepareVoterSlipDownloadResult(Request $request)
    {
        $VoterSlipProcesseds=VoterSlipProcessed::where('state_id',$request->state_id)->where('district_id',$request->district_id)->where('block_id',$request->block_id)->orderBy('file_path','ASC')->get();
        return view('admin.master.PrepareVoterSlip.download_result',compact('VoterSlipProcesseds'));
    }
    public function PrepareVoterSlipResultDownload($id)
     {  
        $VoterSlipProcessed=VoterSlipProcessed::find($id); 
        $documentUrl = Storage_path().$VoterSlipProcessed->folder_path.'/'.$VoterSlipProcessed->file_path;  
        return response()->file($documentUrl); 
     }   
}
