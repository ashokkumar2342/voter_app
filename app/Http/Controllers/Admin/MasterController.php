<?php

namespace App\Http\Controllers\Admin;

use App\Helper\MyFuncs;
use App\Http\Controllers\Controller;
use App\Model\BlockMc;
use App\Model\BlocksMc;
use App\Model\District;
use App\Model\Gender;
use App\Model\Village;
use App\Model\Tahsil;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use PDF;

class MasterController extends Controller
{ 
   
   public function districts(Request $request)
   {
      try {
          $Districts= District::orderBy('name_e','ASC')->get();
          return view('admin.master.districts.index',compact('Districts'));
        } catch (Exception $e) {
            
        }
   }
   public function districtsStore(Request $request,$id=null)
   {  
       $rules=[
             
            'code' => 'required|unique:districts,code,'.$id, 
            'name_english' => 'required', 
            'name_local_language' => 'required', 
             
      ];

      $validator = Validator::make($request->all(),$rules);
      if ($validator->fails()) {
          $errors = $validator->errors()->all();
          $response=array();
          $response["status"]=0;
          $response["msg"]=$errors[0];
          return response()->json($response);// response as json
      }
      else {
         
      $district=District::firstOrNew(['id'=>$id]); 
      $district->code=$request->code;
      $district->name_e=$request->name_english;
      $district->name_l=$request->name_local_language;
      $district->save(); 
      $response=['status'=>1,'msg'=>'Submit Successfully'];
      return response()->json($response);
      }
    }
    public function DistrictsTable(Request $request)
    {
      $Districts= District::where('state_id',$request->id)->orderBy('name_e','ASC')->get();
      return view('admin.master.districts.district_table',compact('Districts'));
    }
    public function districtsEdit($id)
    {
       try {
          $Districts= District::find($id); 
          return view('admin.master.districts.edit',compact('Districts'));
        } catch (Exception $e) {
            
        }
    }
    
    public function districtsDelete($id)
    {
       $District= District::find(Crypt::decrypt($id));  
       $District->delete();
       return redirect()->back()->with(['message'=>'Delete Successfully','class'=>'success']);  
    }  

    public function BlockMCS(Request $request)
   {
      try {
          
          $Districts= District::orderBy('name_e','ASC')->get(); 
          $BlocksMcs= BlocksMc::orderBy('name_e','ASC')->get();   
          return view('admin.master.block.index',compact('Districts','BlocksMcs'));
        } catch (Exception $e) {
            
        }
   } 
   public function BlockMCSStore(Request $request,$id=null)
   {   
       $rules=[
             
            'district' => 'required', 
            'code' => 'required|unique:blocks_mcs,code,'.$id, 
            'name_english' => 'required', 
            'name_local_language' => 'required', 
             
      ];

      $validator = Validator::make($request->all(),$rules);
      if ($validator->fails()) {
          $errors = $validator->errors()->all();
          $response=array();
          $response["status"]=0;
          $response["msg"]=$errors[0];
          return response()->json($response);// response as json
      }
      else {
       $BlocksMc= BlocksMc::firstOrNew(['id'=>$id]); 
       $BlocksMc->districts_id=$request->district; 
       $BlocksMc->code=$request->code;
       $BlocksMc->name_e=$request->name_english;
       $BlocksMc->name_l=$request->name_local_language; 
       $BlocksMc->save(); 
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function BlockMCSTable(Request $request)
    {  
       $BlocksMcs= BlocksMc::where('districts_id',$request->id)->orderBy('name_e','ASC')->get(); 
       return view('admin.master.block.block_table',compact('Districts','States','BlocksMcs'));
    }
    public function BlockMCSEdit($id)
    {
       try { 
          $Districts= District::orderBy('name_e','ASC')->get(); 
          $BlocksMcs= BlocksMc::find($id);  
          return view('admin.master.block.edit',compact('Districts','BlocksMcs'));
        } catch (Exception $e) {
            
        }
    }
    public function BlockMCSDelete($id)
    {
       $BlocksMc= BlocksMc::find(Crypt::decrypt($id));  
       $BlocksMc->delete();
       return redirect()->back()->with(['message'=>'Delete Successfully','class'=>'success']);  
    }
     

    public function village(Request $request)
   {
      try {
          $Districts= District::orderBy('name_e','ASC')->get(); 
          $BlocksMcs= BlocksMc::orderBy('name_e','ASC')->get();   
          $Villages= Village::orderBy('name_e','ASC')->get(); 
          return view('admin.master.village.index',compact('Districts','States','BlocksMcs','Villages'));
        } catch (Exception $e) {
            
        }
   }
   public function villageStore(Request $request,$id=null)
   {  
       $rules=[
            'states' => 'required', 
            'district' => 'required', 
            'block_mcs' => 'required', 
            'code' => 'required|unique:villages,code,'.$id, 
            'name_english' => 'required', 
            'name_local_language' => 'required', 
            // 'syllabus' => 'required', 
      ];

      $validator = Validator::make($request->all(),$rules);
      if ($validator->fails()) {
          $errors = $validator->errors()->all();
          $response=array();
          $response["status"]=0;
          $response["msg"]=$errors[0];
          return response()->json($response);// response as json
      }
      else {
        $user=Auth::guard('admin')->user();
        DB::select(DB::raw("call up_create_village_excel ('$user->id','$request->states','$request->district','$request->block_mcs','$request->code','$request->name_english','$request->name_local_language','$request->ward')")); 
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function villageTable(Request $request)
    {
      $Villages= Village::where('blocks_id',$request->id)->orderBy('states_id','ASC')->orderBy('districts_id','ASC')->orderBy('blocks_id','ASC')->orderBy('code','ASC')->get();
      return view('admin.master.village.village_table',compact('Villages')); 
    }
    public function villageEdit($id)
    {
       try { 
          
          $village=Village::find($id); 
          return view('admin.master.village.edit',compact('Districts','States','BlocksMcs','village'));
        } catch (Exception $e) {
            
        }
    }
    public function villageUpdate(Request $request,$id=null)
   {  
       $rules=[
             
            'code' => 'required|unique:villages,code,'.$id, 
            'name_english' => 'required', 
            'name_local_language' => 'required', 
            // 'syllabus' => 'required', 
      ];

      $validator = Validator::make($request->all(),$rules);
      if ($validator->fails()) {
          $errors = $validator->errors()->all();
          $response=array();
          $response["status"]=0;
          $response["msg"]=$errors[0];
          return response()->json($response);// response as json
      }
      else {
        $village=Village::find($id); 
        $village->code=$request->code; 
        $village->name_e=$request->name_english; 
        $village->name_l=$request->name_local_language; 
        $village->save(); 
       $response=['status'=>1,'msg'=>'Update Successfully'];
       return response()->json($response);
      }
    }
    public function villageDelete($id)
    {
       $Village= Village::find($id); 
       $Village->Delete();
       $response=['status'=>1,'msg'=>'Delete Successfully'];
       return response()->json($response);
    }

    public function tahsil($value='')
    {
       try {
          
          $Districts= District::orderBy('name_e','ASC')->get(); 
          $Tahsils= Tahsil::orderBy('name_e','ASC')->get();   
          return view('admin.master.tahsil.index',compact('Districts','BlocksMcs'));
        } catch (Exception $e) {
            
        }
    }
    public function tahsilStore(Request $request,$id=null)
   {   
       $rules=[
             
            'district' => 'required', 
            'code' => 'required|unique:tahsils,code,'.$id, 
            'name_english' => 'required', 
            'name_local_language' => 'required', 
             
      ];

      $validator = Validator::make($request->all(),$rules);
      if ($validator->fails()) {
          $errors = $validator->errors()->all();
          $response=array();
          $response["status"]=0;
          $response["msg"]=$errors[0];
          return response()->json($response);// response as json
      }
      else {
       $Tahsil= Tahsil::firstOrNew(['id'=>$id]); 
       $Tahsil->district_id=$request->district; 
       $Tahsil->code=$request->code;
       $Tahsil->name_e=$request->name_english;
       $Tahsil->name_l=$request->name_local_language; 
       $Tahsil->save(); 
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function tahsilTable(Request $request)
    {  
       $Tahsils= Tahsil::where('district_id',$request->id)->orderBy('name_e','ASC')->get(); 
       return view('admin.master.tahsil.table',compact('Tahsils'));
    }
     
     
    
   
     
    public function DistrictWiseBlock(Request $request,$print_condition=null)
    {
       try{
          $admin=Auth::guard('admin')->user();
          if (empty($print_condition)) {
           $BlocksMcs=DB::select(DB::raw("call up_fetch_block_access ($admin->id, '$request->id')")); 
           } 
          return view('admin.master.block.value_select_box',compact('BlocksMcs'));
        } catch (Exception $e) {
            
        }
    }
    
    public function BlockWiseVillage(Request $request)
    {
       try{  
          $admin=Auth::guard('admin')->user(); 
          $Villages=DB::select(DB::raw("call up_fetch_village_access ($admin->id, '$request->district_id','$request->id','0')"));  
          return view('admin.master.village.value_select_box',compact('Villages'));
        } catch (Exception $e) {
            
        }
    }
    public function gender()
    {  
      $genders=Gender::all();   
      return view('admin.master.gender.index',compact('genders'));
    }
    public function genderEdit($id)
    {
       $gender=Gender::find($id);
       return view('admin.master.gender.edit',compact('gender'));     
    }
    public function genderUpdate(Request $request,$id)
   { 
     
       $rules=[
            'gender_english' => 'required', 
            'gender_local_language' => 'required', 
            'code_english' => 'required', 
            'code_local_language' => 'required',  
      ];

      $validator = Validator::make($request->all(),$rules);
      if ($validator->fails()) {
          $errors = $validator->errors()->all();
          $response=array();
          $response["status"]=0;
          $response["msg"]=$errors[0];
          return response()->json($response);// response as json
      }
      else { 
       $gender=Gender::firstOrNew(['id'=>$id]);          
       $gender->genders=$request->gender_english;          
       $gender->genders_l=$request->gender_local_language;          
       $gender->code=$request->code_english;          
       $gender->code_l=$request->code_local_language;          
       $gender->save();          
       $response=['status'=>1,'msg'=>'Update Successfully'];
       return response()->json($response);
      }
     

    }
    
}
