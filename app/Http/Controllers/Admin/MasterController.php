<?php

namespace App\Http\Controllers\Admin;

use App\Helper\MyFuncs;
use App\Http\Controllers\Admin\PanchayatSamiti;
use App\Http\Controllers\Controller;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\BlockMCType;
use App\Model\BlockMc;
use App\Model\BlocksMc;
use App\Model\BoothWardVoterMapping;
use App\Model\District;
use App\Model\Gender;
use App\Model\PollingBooth;
use App\Model\PollingDayTime;
use App\Model\State;
use App\Model\TmpImportAssembly;
use App\Model\TmpImportMapVillageWard;
use App\Model\TmpImportVillage;
use App\Model\Village;
use App\Model\Voter;
use App\Model\VoterListMaster;
use App\Model\WardPanchayat;
use App\Model\WardVillage;
use App\Model\ZilaParishad;
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
   public function index()
   { 
     try {
          $States= State::orderBy('name_e','ASC')->get();   
          return view('admin.master.states.index',compact('States'));
        } catch (Exception $e) {
            
        }
     
   }
   public function store(Request $request,$id=null)
   {  
       $rules=[
            'code' => 'required|unique:states,code,'.$id, 
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
       $States= State::firstOrNew(['id'=>$id]);
       $States->code=$request->code;
       $States->name_e=$request->name_english;
       $States->name_l=$request->name_local_language; 
       $States->save();
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function edit($id)
     { 
       try {  
            $States= State::find($id);   
            return view('admin.master.states.edit',compact('States'));
          } catch (Exception $e) {
              
          }
       
     }

    public function delete($id)
    {
       $States= State::find(Crypt::decrypt($id));  
       $States->delete();
       return redirect()->back()->with(['message'=>'Delete Successfully','class'=>'success']);  
    }
//-------districts--------------districts--------------districts---------------districts----//



   public function districts(Request $request)
   {
      try {             
          $States= State::orderBy('name_e','ASC')->get();   
          return view('admin.master.districts.index',compact('States'));
        } catch (Exception $e) {
            
        }
   }
   public function districtsStore(Request $request,$id=null)
   {  
       $rules=[
            'states' => 'required', 
            'code' => 'required|unique:districts,code,'.$id, 
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
        if (!empty($id)) {
        $district=District::firstOrNew(['id'=>$id]);
        $district->state_id=$request->states;
        $district->code=$request->code;
        $district->name_e=$request->name_english;
        $district->name_l=$request->name_local_language;
        $district->save(); 
        }
        elseif (empty($id)) {
        $user=Auth::guard('admin')->user(); 
        $zpWard = DB::select(DB::raw("call up_create_district_excel ('$user->id','$request->states','$request->code','$request->name_english','$request->name_local_language','$request->zp_ward')")); 
        }
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
          $States= State::orderBy('name_e','ASC')->get();   
          return view('admin.master.districts.edit',compact('Districts','States'));
        } catch (Exception $e) {
            
        }
    }
    
    public function districtsDelete($id)
    {
       $District= District::find(Crypt::decrypt($id));  
       $District->delete();
       return redirect()->back()->with(['message'=>'Delete Successfully','class'=>'success']);  
    }
    public function DistrictsZpWard($districts_id)
    { 
      $DistrictName= District::find($districts_id);
      return view('admin.master.districts.zp_ward',compact('DistrictName')); 
    }
    public function DistrictsZpWardStore(Request $request)
   { 
       $rules=[ 
            'district_id' => 'required',  
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
        DB::select(DB::raw("call up_create_zp_ward ('$request->district_id','$request->zp_ward','0')")); 
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
     
    //------------z-p-ward---------------------------//

    public function ZilaParishad($value='')
    {
      try {             
          $States= State::orderBy('name_e','ASC')->get();   
          return view('admin.master.zpward.index',compact('States'));
        } catch (Exception $e) {
            
        }
    }
    public function ZilaParishadStore(Request $request)
   {  
       $rules=[ 
            'district' => 'required',  
            'zp_ward_no' => 'required',  
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
        DB::select(DB::raw("call up_create_zp_ward ('$request->district','$request->zp_ward_no','0')")); 
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function ZilaParishadTable(Request $request)
    {
      try {             
          $ZilaParishads= ZilaParishad::where('districts_id',$request->district_id)->orderBy('states_id','ASC')->orderBy('districts_id','ASC')->orderBy('ward_no','ASC')->get();   
          return view('admin.master.zpward.table',compact('ZilaParishads'));
        } catch (Exception $e) {
            
        }
    }
    public function ZilaParishadEdit($id)
    {
      $ZilaParishad= ZilaParishad::find($id);
      return view('admin.master.zpward.edit',compact('ZilaParishad'));
    }
    public function ZilaParishadUpdate(Request $request,$id)
   {    
       $rules=[ 
        // 'zp_ward_no' => 'required|unique:ward_zp,ward_no,'.$id, 
            'zp_ward_no' => 'required',  
            'zp_ward_name_english' => 'required',  
            'zp_ward_name_local_language' => 'required',  
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
       $ZilaParishad= ZilaParishad::find($id);
       $ZilaParishad->ward_no=$request->zp_ward_no;
       $ZilaParishad->name_e=$request->zp_ward_name_english;
       $ZilaParishad->name_l=$request->zp_ward_name_local_language;
       $ZilaParishad->save();
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function ZilaParishadDelete($id)
    {
       $ZilaParishad= ZilaParishad::find($id); 
       $ZilaParishad->Delete();
       $response=['status'=>1,'msg'=>'Delete Successfully'];
       return response()->json($response);
    }
    //------------block-mcs----------------------------//

    public function PanchayatSamiti($value='')
    {
       $States= State::orderBy('name_e','ASC')->get(); 
       return view('admin.master.psward.index',compact('States'));
    }
    public function PanchayatSamitiTable(Request $request)
    { 
      try {             
          $PanchayatSamitis= WardPanchayat::where('blocks_id',$request->id)->orderBy('states_id','ASC')->orderBy('districts_id','ASC')->orderBy('ward_no','ASC')->get();   
          return view('admin.master.psward.table',compact('PanchayatSamitis'));
        } catch (Exception $e) {
            
        }
    }
    public function PanchayatSamitiStore(Request $request)
   {   
       $rules=[ 
            'block' => 'required',  
            'ps_ward' => 'required',  
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
        DB::select(DB::raw("call up_create_ps_ward ('$request->block','$request->ps_ward','0')")); 
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function PanchayatSamitiEdit($id)
    {
      $PanchayatSamiti= WardPanchayat::find($id); 
      return view('admin.master.psward.edit',compact('PanchayatSamiti'));
    }
    public function PanchayatSamitiUpdate(Request $request,$id)
   {    
       $rules=[ 
        // 'zp_ward_no' => 'required|unique:ward_zp,ward_no,'.$id, 
            'ps_ward_no' => 'required',  
            'ps_ward_name_english' => 'required',  
            'ps_ward_name_local_language' => 'required',  
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
       $ZilaParishad= WardPanchayat::find($id);
       $ZilaParishad->ward_no=$request->ps_ward_no;
       $ZilaParishad->name_e=$request->ps_ward_name_english;
       $ZilaParishad->name_l=$request->ps_ward_name_local_language;
       $ZilaParishad->save();
       $response=['status'=>1,'msg'=>'Update Successfully'];
       return response()->json($response);
      }
    }
    public function PanchayatSamitiDelete($id)
    {
       $WardPanchayat= WardPanchayat::find($id); 
       $WardPanchayat->Delete();
       $response=['status'=>1,'msg'=>'Delete Successfully'];
       return response()->json($response);
    }
    //------------block-mcs-type---------------------------//
    public function BlockMCSType()
    {
      $BlockMCTypes=BlockMCType::orderBy('id','ASC')->get();
      return view('admin.master.blockmctype.index',compact('BlockMCTypes'));
    }
    public function BlockMCSTypeEdit($id)
    {
      $BlockMCType=BlockMCType::find($id);
      return view('admin.master.blockmctype.edit',compact('BlockMCType'));
    }
    public function BlockMCSTypeUpdate(Request $request,$id)
   { 
      
       $rules=[
            'block_mc_type_e' => 'required', 
            'block_mc_type_l' => 'required', 
            
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
       $BlockMCType=BlockMCType::firstOrNew(['id'=>$id]);          
       $BlockMCType->block_mc_type_e=$request->block_mc_type_e;          
       $BlockMCType->block_mc_type_l=$request->block_mc_type_l;  
       $BlockMCType->save();          
       $response=['status'=>1,'msg'=>'Update Successfully'];
       return response()->json($response);
      }
     

    }
    //------------block-mcs----------------------------//

    public function BlockMCS(Request $request)
   {
      try {
          $BlockMCTypes=BlockMCType::orderBy('id','ASC')->get();
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::orderBy('name_e','ASC')->get();   
          return view('admin.master.block.index',compact('Districts','States','BlocksMcs','BlockMCTypes'));
        } catch (Exception $e) {
            
        }
   }
   public function BlockbtnClickByForm($value='')
   {
     return view('admin.master.block.block_form_div');
   }
   public function BlockMCSStore(Request $request,$id=null)
   {   
       $rules=[
            'states' => 'required', 
            'district' => 'required', 
            'code' => 'required|unique:blocks_mcs,code,'.$id, 
            'name_english' => 'required', 
            'name_local_language' => 'required', 
            'block_mc_type_id' => 'required', 
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
       $BlocksMc= BlocksMc::firstOrNew(['id'=>$id]);
       $BlocksMc->states_id=$request->states;
       $BlocksMc->districts_id=$request->district;
       $BlocksMc->block_mc_type_id=$request->block_mc_type_id;
       $BlocksMc->code=$request->code;
       $BlocksMc->name_e=$request->name_english;
       $BlocksMc->name_l=$request->name_local_language; 
       $BlocksMc->stamp_l1=$request->stamp_l1; 
       $BlocksMc->stamp_l2=$request->stamp_l2; 
       $BlocksMc->save();
       if (empty($id)) { 
       $psWard = DB::select(DB::raw("call up_create_ps_ward ('$BlocksMc->id','$request->ps_ward','0')")); 
       }
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function BlockMCSTable(Request $request)
    {  
       $BlocksMcs= BlocksMc::where('districts_id',$request->district_id)->orderBy('name_e','ASC')->get(); 
       return view('admin.master.block.block_table',compact('Districts','States','BlocksMcs'));
    }
    public function BlockMCSEdit($id)
    {
       try {
          $BlockMCTypes=BlockMCType::orderBy('id','ASC')->get();
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::find($id);  
          return view('admin.master.block.edit',compact('Districts','States','BlocksMcs','BlockMCTypes'));
        } catch (Exception $e) {
            
        }
    }
    public function BlockMCSDelete($id)
    {
       $BlocksMc= BlocksMc::find(Crypt::decrypt($id));  
       $BlocksMc->delete();
       return redirect()->back()->with(['message'=>'Delete Successfully','class'=>'success']);  
    }
     public function BlockMCSpsWard($block_id)
     {
       $Block= BlocksMc::find($block_id);  
       return view('admin.master.block.ps_ward',compact('Block'));  
     }
     public function BlockMCSpsWardStore(Request $request)
     {  
       $rules=[ 
            'block_id' => 'required',  
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
        DB::select(DB::raw("call up_create_ps_ward ('$request->block_id','$request->ps_ward','0')")); 
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    //
    //------------village----------------------------//

    public function village(Request $request)
   {
      try {
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::orderBy('name_e','ASC')->get();   
          $Villages= Village::orderBy('name_e','ASC')->get(); 
          return view('admin.master.village.index',compact('Districts','States','BlocksMcs','Villages'));
        } catch (Exception $e) {
            
        }
   }
   public function BtnClickByvillageForm()
   {
     return view('admin.master.village.form_div'); 
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
    public function villageWardAdd($village_id)
    {
        $Village= Village::find($village_id);
        return view('admin.master.village.add_ward',compact('Village'));
    }
     
     //------------ward-village----------------------------//

    public function ward(Request $request)
   {
      try {
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::orderBy('name_e','ASC')->get();   
          $Villages= Village::orderBy('name_e','ASC')->get(); 
          return view('admin.master.wards.index',compact('Districts','States','BlocksMcs','Villages'));
        } catch (Exception $e) {
            
        }
   }
   public function wardStore(Request $request,$id=null)
   { 
       $rules=[
            'states' => 'required', 
            'district' => 'required', 
            'block' => 'required', 
            'village' => 'required', 
            
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
        DB::select(DB::raw("call up_create_village_ward ('$request->village','$request->ward','0')"));

        
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function wardTable(Request $request)
    {
      $wards= WardVillage::where('village_id',$request->id)->orderBy('ward_no','ASC')->get();
      return view('admin.master.wards.ward_table',compact('wards'));
    }
    //------------Assembly----------------------------//

    public function Assembly(Request $request)
   {
      try {
          $Districts= District::orderBy('name_e','ASC')->get();  
          $assemblys= Assembly::orderBy('name_e','ASC')->get();   
          return view('admin.master.assembly.index',compact('Districts','assemblys'));
        } catch (Exception $e) {
            
        }
   }
   public function AssemblyStore(Request $request,$id=null)
   {    
       $rules=[
            
            'district' => 'required', 
            'code' => 'required|unique:assemblys,code,'.$id, 
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
       $Assembly= Assembly::firstOrNew(['id'=>$id]); 
       $Assembly->district_id=$request->district; 
       $Assembly->code=$request->code;
       $Assembly->name_e=$request->name_english;
       $Assembly->name_l=$request->name_local_language; 
       $Assembly->save();
       if (empty($id)) { 
       DB::select(DB::raw("call up_create_assembly_part ('$Assembly->id','$request->part_no','0')"));
       }
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function AssemblyTable(Request $request)
    {
      $assemblys=Assembly::where('district_id',$request->id)->orderBy('district_id','ASC')->get();
      return view('admin.master.assembly.assembly_table',compact('assemblys')); 
    }
    public function AssemblyEdit($id)
    {
       try {
          $Districts= District::orderBy('name_e','ASC')->get();  
          $assembly= Assembly::find($id);  
          return view('admin.master.assembly.edit',compact('Districts','States','assembly'));
        } catch (Exception $e) {
            
        }
    }

    public function AssemblyDelete($id)
    {
       $assembly= Assembly::find($id);   
       $assembly->delete();
       return redirect()->back()->with(['message'=>'Delete Successfully','class'=>'success']);     
    } 
    
    //------------AssemblyPart----------------------------//

    public function AssemblyPart(Request $request)
   {
      try {
          $Districts= District::orderBy('name_e','ASC')->get();
          $assemblys= Assembly::orderBy('name_e','ASC')->get();  
          return view('admin.master.assemblypart.index',compact('Districts','assemblys'));
        } catch (Exception $e) {
            
        }
   }
   public function AssemblyPartbtnclickBypartNo($value='')
   {
     return view('admin.master.assemblypart.part_no_div');
   }
   public function AssemblyPartStore(Request $request,$id=null)
   {    
       $rules=[
            
            'assembly' => 'required', 
            'part_no' => 'required', 
           
            
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
       DB::select(DB::raw("call up_create_assembly_part ('$request->assembly','$request->part_no','0')"));
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function AssemblyPartTable(Request $request)
    {  
       $assemblyParts= AssemblyPart::where('assembly_id',$request->assembly_id)->orderBy('assembly_id','ASC')->orderBy('part_no','ASC')->get();  
       return view('admin.master.assemblypart.part_table',compact('assemblyParts'));
    }
    public function AssemblyPartEdit($id)
    {
       try {
          $assembly= Assembly::find($id);  
          return view('admin.master.assemblypart.edit',compact('assembly'));
        } catch (Exception $e) {
            
        }
    }
    public function AssemblyPartDelete($id)
    {
       $assembly= AssemblyPart::find($id);   
       $assembly->delete();
       return redirect()->back()->with(['message'=>'Delete Successfully','class'=>'success']);     
    }
    //-----MappingVillageAssemblyPart-----------------
    public function MappingVillageAssemblyPart()
    {
       try {
           
          $States= State::orderBy('name_e','ASC')->get();  
          return view('admin.master.mappingvillageassemblypart.index',compact('States'));
        } catch (Exception $e) {
            
        }
    }
    public function MappingVillageAssemblyPartFilter(Request $request)
    {
       try {  
          $assemblys= Assembly::where('district_id',$request->district_id)->orderBy('name_e','ASC')->get();  
          $Parts= AssemblyPart::orderBy('part_no','ASC')->get();  
          $assemblyParts= AssemblyPart::where('village_id',$request->id)->get();   
             
          return view('admin.master.mappingvillageassemblypart.value',compact('assemblys','Parts','assemblyParts','OldParts'));
        } catch (Exception $e) {
            
        }
    }
    public function MappingAssemblyWisePartNo(Request $request)
    { 
       $Parts= AssemblyPart::where('village_id',0)->where('assembly_id',$request->id)->get();
       $OldParts= AssemblyPart::where('village_id',0)->pluck('id')->toArray();
       return view('admin.master.assemblypart.part_no_select_box',compact('Parts','OldParts'));  
    }
    public function MappingVillageAssemblyPartStore(Request $request)
    {
        $rules=[
             
            'village' => 'required', 
            'assembly' => 'required', 
            'part_no' => 'required', 
             
            
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
          $assemblyPart=AssemblyPart::where('assembly_id',$request->assembly)->where('id',$request->part_no)->first();
          $assemblyPart->village_id=$request->village; 
          $assemblyPart->save();
        
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function MappingVillageAssemblyPartRemove($assemblyPart_id)
     {
          $assemblyPart=AssemblyPart::find($assemblyPart_id);
          $assemblyPart->village_id=0; 
          $assemblyPart->save();
        
          $response=['status'=>1,'msg'=>'Remove Successfully'];
          return response()->json($response);
     }

  //-----MappingVillageAssemblyPart-------------------------------------------------------------
     public function MappingVillageToZPWard()
     {
        $States= State::orderBy('name_e','ASC')->get();   
        return view('admin.master.mappingvillageTozpward.index',compact('States'));  
     }
     public function districtwiseZPWard(Request $request)
     { 
       $zpwards= ZilaParishad::where('districts_id',$request->district_id)->orderBy('ward_no','ASC')->get();   
        return view('admin.master.zpward.value_select_box',compact('zpwards'));    
     }
     public function districtOrZpwardWiseVillage(Request $request)
     {   
       $villages=DB::select(DB::raw("select `id`, `name_e` from `villages`where `is_locked` = 0 and `districts_id` =$request->district_id and `zp_ward_id` not in (Select `id` from `ward_zp` where `districts_id` =$request->district_id)Union select `id`, `name_e` from `villages`where `is_locked` = 0 and `districts_id` =$request->district_id and `zp_ward_id` =$request->id Order By `name_e`;"));

       $selectedvillage=DB::select(DB::raw("select `id`, `name_e` from `villages`where `is_locked` = 0 and `districts_id` =$request->district_id and `zp_ward_id` =$request->id Order By `name_e`;"));
       if (empty($selectedvillage)) {
         $village_id[]=0;
       }elseif(!empty($selectedvillage)) {
         foreach ($selectedvillage as $key => $value) {
           $village_id[]=$value->id;
        }
       } 
        
        
       return view('admin.master.mappingvillageTozpward.village_move_select_box',compact('villages','selectedvillage','village_id'));    
     }
     public function MappingVillageToZPWardStore(Request $request)
     { 
        if (!empty($request->village)) {
         $village_id=implode(',',$request->village);  
        }
        elseif (empty($request->village)) {
           $village_id=0;  
         } 
       
       DB::select(DB::raw("call up_map_villages_zpward ('$request->zp_ward','$village_id')"));
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response); 
     } 
  //------------------------Mapping-Village-To-PS-p-s-Ward----------------------------------//
    public function MappingVillageToPSWard($value='')
    {
       $States= State::orderBy('name_e','ASC')->get();   
        return view('admin.master.mappingvillageTopsward.index',compact('States')); 
    }
    public function blockwisePsWard(Request $request)
    { 
       $pswards= WardPanchayat::where('blocks_id',$request->id)->orderBy('ward_no','ASC')->get();   
        return view('admin.master.psward.value_select_box',compact('pswards'));
    }
    public function BlockOrPSwardWiseVillage(Request $request)
     {   
       $villages=DB::select(DB::raw("(Select `wv`.`id`, concat(`v`.`name_e`, '-', `wv`.`ward_no`) as `ps_ward_name` From `ward_villages` `wv`
          Inner Join `villages` `v` on `v`.`id` = `wv`.`village_id`
          Where `wv`.`is_locked` = 0 and `wv`.`blocks_id` =$request->block_id and (`wv`.`ps_ward_id` =0 Or `wv`.`ps_ward_id` is null))
          Union (Select `wv`.`id`,  concat(`v`.`name_e`, '-', `wv`.`ward_no`) as `ps_ward_name` From `ward_villages` `wv`
          Inner Join `villages` `v` on `v`.`id` = `wv`.`village_id`
          Where `wv`.`is_locked` = 0 and `wv`.`blocks_id` =$request->block_id and `wv`.`ps_ward_id` =$request->id)
           Order By `ps_ward_name`;"));

       $selectedvillage=DB::select(DB::raw("Select `wv`.`id`,  concat(`v`.`name_e`, '-', `wv`.`ward_no`) as `ps_ward_name` From `ward_villages` `wv`
          Inner Join `villages` `v` on `v`.`id` = `wv`.`village_id`
          Where `wv`.`is_locked` = 0 and `wv`.`blocks_id` =$request->block_id and `wv`.`ps_ward_id` =$request->id
          Order By `v`.`name_e`, `wv`.`ward_no`;
          "));
       if (empty($selectedvillage)) {
         $village_id[]=0;
       }elseif(!empty($selectedvillage)) {
         foreach ($selectedvillage as $key => $value) {
           $village_id[]=$value->id;
        }
       } 
       return view('admin.master.mappingvillageTopsward.ward_move_select_box',compact('villages','selectedvillage','village_id'));    
     }
     public function MappingVillageToPSWardStore(Request $request)
     { 
        if (!empty($request->village)) {
         $village_id=implode(',',$request->village);  
        }
        elseif (empty($request->village)) {
           $village_id=0;  
         } 
       
       DB::select(DB::raw("call up_map_villages_psward ('$request->ps_ward','$village_id')"));
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response); 
     } 
   //---------MappingBoothWard----------MappingBoothWard-----------------MappingBoothWard
    public function MappingBoothWard($value='')
    {
        $States= State::orderBy('name_e','ASC')->get();  
        return view('admin.master.mappingBoothWard.index',compact('States'));
    }
    public function MappingVillageWiseBooth(Request $request)
     {
       $booths=PollingBooth::where('village_id',$request->village_id)->orderBy('states_id','ASC')->orderBy('districts_id','ASC')->orderBy('blocks_id','ASC')->orderBy('village_id','ASC')->orderBy('booth_no','ASC')->get(); 
       return view('admin.master.booth.booth_select_box',compact('booths'));
     }
     public function MappingVillageOrBoothWiseWard(Request $request)
     {  
        $wards=DB::select(DB::raw("select `id`, `ward_no` from `ward_villages` where `village_id` =$request->village_id and `id` not in (Select `wardId` from `booth_ward_voter_mapping`)Union select `id`, `ward_no` from `ward_villages` where `village_id` =$request->village_id and `id` in (Select `wardId` from `booth_ward_voter_mapping` where `boothid` =$request->id) Order By `ward_no`;"));

        $selecdetwardId=DB::select(DB::raw("select `id`, `ward_no` from `ward_villages` where `village_id` =$request->village_id and `id` in (Select `wardId` from `booth_ward_voter_mapping` where `boothid` =$request->id) Order By `ward_no`;"));
        if (empty($selecdetwardId)) {
         $wardId[]=0;
       }elseif(!empty($selecdetwardId)) {
         foreach ($selecdetwardId as $key => $value) {
           $wardId[]=$value->id;
        }
       }  
        return view('admin.master.mappingBoothWard.ward_select_box',compact('wards','wardId'));
     }
     public function MappingBoothWardStore(Request $request)
      {  
        if (!empty($request->ward)) {
         $ward=implode(',',$request->ward);  
        }
        elseif (empty($request->ward)) {
           $ward=0;  
         } 
       
       
       DB::select(DB::raw("call up_process_booth_ward_voters ('$request->booth','$ward', $request->village)"));

       DB::select(DB::raw("call up_map_booth_ward ('$request->booth','$ward')"));
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response); 
      }
   //------MappingWardBooth-----------------MappingWardBooth--------MappingWardBooth
   
   public function MappingWardBooth()
   {
        $States= State::orderBy('name_e','ASC')->get();  
        return view('admin.master.mappingWardBooth.index',compact('States'));     
   }
   public function MappingWardBoothTable(Request $request)
   {
      $booths=DB::select(DB::raw("select `bwm`.`id`, `pb`.`booth_no`,`pb`.`booth_no_c`,`pb`.`name_e`, `pb`.`name_l`, `bwm`.`fromsrno`, `bwm`.`tosrno` from `booth_ward_voter_mapping` `bwm` Inner Join `polling_booths` `pb` on `pb`.`id` = `bwm`.`boothid` Where `bwm`.`wardId` =$request->id Order By `bwm`.`fromsrno`;"));
      return view('admin.master.mappingWardBooth.table',compact('booths'));   
   }
   public function MappingWardBoothSelectBooth(Request $request)
   {
      $booths=DB::select(DB::raw("select `id`, `booth_no`,`booth_no_c`,`name_e` from `polling_booths` Where `village_id` =$request->village_id And `id` not in (Select `boothid` from `booth_ward_voter_mapping`  Where `wardId` =$request->id) Order By `booth_no`;"));
      return view('admin.master.booth.booth_select_box',compact('booths'));
   }
   public function MappingWardBoothStore(Request $request)
   {  
      if (empty($request->from_sr_no)) {
        $from_sr_no=0;
        $to_sr_no=0; 
      }
      elseif (!empty($request->from_sr_no)) {
        $from_sr_no=$request->from_sr_no;
        $to_sr_no=$request->to_sr_no;
      }
      if (empty($request->id)) {
         $id=0;
      }
      else if (!empty($request->id)) {
         $id=$request->id;
      }
       $message=DB::select(DB::raw("call up_process_ward_booth_voters ('$request->booth','$request->ward','$from_sr_no','$to_sr_no')"));

       $message=DB::select(DB::raw("call up_map_ward_booth_voters ('$id','$request->ward','$from_sr_no','$to_sr_no','$request->booth')"));
       if ($message[0]->Save_Result!='Save Successfully') {
         $response=['status'=>0,'msg'=>$message[0]->Save_Result];
         return response()->json($response); 
        }
        elseif ($message[0]->Save_Result=='Save Successfully') {
         $response=['status'=>1,'msg'=>$message[0]->Save_Result];
         return response()->json($response); 
        } 
       
   }
   public function MappingWardBoothEdit($id)
   {
    $BoothWardVoterMapping=BoothWardVoterMapping::find($id);
    return view('admin.master.mappingWardBooth.edit',compact('BoothWardVoterMapping'));      
   }
//--------MappingWardWithMultipleBooth---------
   public function MappingWardWithMultipleBooth()
   {
        $States= State::orderBy('name_e','ASC')->get();  
        return view('admin.master.MappingWardWithMultipleBooth.index',compact('States'));     
   }
   public function MappingWardWithMultipleBoothWardWiseBooth(Request $request)
   {

   $booths = DB::select(DB::raw("Select `id`, concat(`booth_no`, `booth_no_c`,' - ', `name_e`) as `booth_name` From `polling_booths` Where `village_id` =$request->village_id and `id` not in (select `boothid` from `booth_ward_voter_mapping` where  `is_complete_booth` = 1) Union 
      Select `id`, concat(`booth_no`, ' - ', `name_e`) as `booth_name` From `polling_booths` Where `village_id` = $request->village_id and `id` in (select `boothid` from `booth_ward_voter_mapping` where `wardId` =$request->ward_id and `is_complete_booth` = 1) Order by `booth_name`;"));

   $selectbooth= DB::select(DB::raw("Select `id`, concat(`booth_no`, `booth_no_c`,' - ', `name_e`) as `booth_name` From `polling_booths` Where `village_id` = $request->village_id and `id` in (select `boothid` from `booth_ward_voter_mapping` where `wardId` =$request->ward_id and `is_complete_booth` = 1) Order by `booth_name`;"));
   if (empty($selectbooth)) {
         $booth_id[]=0;
       }elseif(!empty($selectbooth)) {
         foreach ($selectbooth as $key => $value) {
           $booth_id[]=$value->id;
        }
       }         
    return view('admin.master.MappingWardWithMultipleBooth.select_box',compact('booths','booth_id'));     
   }
   public function MappingWardWithMultipleBoothStore(Request $request)
  {   
     if (!empty($request->booth)) {
         $booth_id=implode(',',$request->booth);  
        }
        elseif (empty($request->booth)) {
           $booth_id=0;  
         }
    
    $saveBooth = DB::select(DB::raw("call up_map_ward_booths('$request->ward','$booth_id')"));

   $response=['status'=>1,'msg'=>'Submit Successfully']; 
   return response()->json($response); 
  }    
  //----------ward-bandi----------WardBandi----------------------------------------------------//
    public function WardBandi()
    {
       try {
          $VoterListMaster=VoterListMaster::where('status',1)->first();
         if (empty($VoterListMaster)) {
          return 'Voter List Not Selected Contact Your Admin';  
         }
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::orderBy('name_e','ASC')->get();   
          $Villages= Village::orderBy('name_e','ASC')->get();  
          return view('admin.master.wardbandi.index',compact('Districts','States','Villages','BlocksMcs'));
        } catch (Exception $e) {
            
        }
    }
    public function WardBandiFilter(Request $request)
    {
       try{ 
          $assemblyParts= AssemblyPart::where('village_id',$request->id)->get();   
          $WardVillages = DB::select(DB::raw("call up_fetch_ward_village_access ('$request->id','0')"));   
          return view('admin.master.wardbandi.value',compact('assemblyParts','WardVillages'));
        } catch (Exception $e) {
            
        }
    }
    public function WardBandiFilterAssemblyPart(Request $request)
    {
       try{ 
           $voterLists=DB::select(DB::raw("select `v`.`id`, `v`.`sr_no`, `v`.`name_l`, `v`.`father_name_l`, `vil`.`name_l` as `vil_name`, `wv`.`ward_no`from `voters` `v`Left Join `villages` `vil` on `vil`.`id` = `v`.`village_id`Left Join `ward_villages` `wv` on `wv`.`id` = `v`.`ward_id`Where `v`.`assembly_part_id` =$request->id;"));  
          return view('admin.master.wardbandi.voter_list',compact('voterLists'));
        } catch (Exception $e) {
            
        }
    } 
    public function WardBandiFilterward(Request $request)
    {
       try{ 
          $total_mapped=DB::select(DB::raw("select count(*) as `total_mapped` from `voters` where `ward_id` = $request->id;"));   
          return view('admin.master.wardbandi.sr_no_form',compact('total_mapped'));
        } catch (Exception $e) {
            
        }
    }
    public function WardBandiStore(Request $request)
   { 
      
       $rules=[
            'states' => 'required', 
            'district' => 'required', 
            'block' => 'required', 
            'village' => 'required', 
            'assembly_part' => 'required', 
             
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
        if ($request->forcefully==1) {
         $forcefully=1; 
        }else{
         $forcefully=0; 
        }
        if ($request->from_sr_no==null) {
           $from_sr_no=0;
         }
         else if ($request->from_sr_no!=null) {
           $from_sr_no=$request->from_sr_no;
         }
         if ($request->to_sr_no==null) {
           $to_sr_no=0;
         }
         else if ($request->to_sr_no!=null) {
           $to_sr_no=$request->to_sr_no;
         } 
        $message=DB::select(DB::raw("call up_ward_bandi_voters ('$request->assembly_part','$request->ward','0','$from_sr_no','$to_sr_no','$forcefully')"));
        if ($message[0]->save_status=='Saved Successfully') {
          $response=['status'=>1,'msg'=>$message[0]->save_status];  
         }else{ 
          $response=['status'=>0,'msg'=>$message[0]->save_status];
         } 
       return response()->json($response);
      }
     

    } 

    
    public function WardBandiReport(Request $request)
    { 
       $village=$request->village;
       $assembly_part=$request->assembly_part;
       $ward=$request->ward;
       return view('admin.master.wardbandi.report',compact('village','assembly_part','ward')); 
    }
    public function WardBandiReportGenerate(Request $request)
    { 
      if ($request->report==1) {
        $assemblyPart=AssemblyPart::find($request->assembly_part);
        $assembly=Assembly::find($assemblyPart->assembly_id); 
        $voterReports=DB::select(DB::raw("select `v`.`sr_no`, `v`.`name_l`, `v`.`father_name_l`, `vil`.`name_l` as `vil_name`, `wv`.`ward_no` 
           from `voters` `v`Left Join `villages` `vil` on `vil`.`id` = `v`.`village_id`Left Join `ward_villages` `wv` on `wv`.`id` = `v`.`ward_id`Where `v`.`assembly_part_id` =$request->assembly_part order By `v`.`sr_no`;")); 
       
       }
      elseif ($request->report==2) {
      $assemblyPart=AssemblyPart::find($request->assembly_part);
      $assembly=Assembly::find($assemblyPart->assembly_id);
      $voterReports=DB::select(DB::raw("select `v`.`sr_no`, `v`.`name_l`, `v`.`father_name_l`from `voters` `v`Where `v`.`assembly_part_id` =$request->assembly_part and `v`.`village_id` = 0 order By `v`.`sr_no` ;")); 
      }
      elseif ($request->report==3) {
      $village=Village::find($request->village);  
      $wardVillage=WardVillage::find($request->ward);  
      $voterReports= DB::select(DB::raw("select `a`.`code`, `ap`.`part_no`, `v`.`sr_no`, `v`.`name_l`, `v`.`father_name_l`from `voters` `v`Left Join `assemblys` `a` on `a`.`id` = `v`.`assembly_id`Left Join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id`Where `v`.`ward_id` =$request->ward order By `v`.`sr_no`;"));
      } 
      
      $path=Storage_path('fonts/');
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir']; 
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata']; 
         $mpdf = new \Mpdf\Mpdf([
             'fontDir' => array_merge($fontDirs, [
                 __DIR__ . $path,
             ]),
             'fontdata' => $fontData + [
                 'frutiger' => [
                     'R' => 'FreeSans.ttf',
                     'I' => 'FreeSansOblique.ttf',
                 ]
             ],
             'default_font' => 'freesans',
             'pagenumPrefix' => '',
            'pagenumSuffix' => '',
            'nbpgPrefix' => ' कुल ',
            'nbpgSuffix' => ' पृष्ठों का पृष्ठ'
         ]); 
         
         
      if ($request->report==1) {
      $html = view('admin.master.wardbandi.report_list',compact('voterReports','assemblyPart','assembly'));
      }
      elseif ($request->report==2) {
      $html = view('admin.master.wardbandi.report_list2',compact('voterReports','assemblyPart','assembly'));
      }
      elseif ($request->report==3) {
      $html = view('admin.master.wardbandi.report_list3',compact('voterReports','village','wardVillage'));
      }
      $mpdf->WriteHTML($html); 
      $mpdf->Output(); 





    }

    public function DeleteVoter($id)
    {
      $voterDelete=Voter::find($id); 
      $voterDelete->village_id=0;
      $voterDelete->ward_id=0;
      $voterDelete->booth_id=0;
      $voterDelete->save();
      $response=['status'=>1,'msg'=>'Updated Successfully'];
      return response()->json($response);
    }
    //---------onchange---------onchange-----------onchange--------
    
    public function WardBandiWithBooth()
    {
       try {
          $VoterListMaster=VoterListMaster::where('status',1)->first();
         if (empty($VoterListMaster)) {
          return 'Voter List Not Selected Contact Your Admin';  
         }
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::orderBy('name_e','ASC')->get();   
          $Villages= Village::orderBy('name_e','ASC')->get();  
          return view('admin.master.wardbandiwithbooth.index',compact('Districts','States','Villages','BlocksMcs'));
        } catch (Exception $e) {
            
        }
    }
    public function VillageWiseAssemblyWard(Request $request)
    {
        
       try{ 
          $assemblyParts= AssemblyPart::where('village_id',$request->id)->get();   
          $WardVillages = DB::select(DB::raw("call up_fetch_ward_village_access ('$request->id','0')"));   
          return view('admin.master.wardbandiwithbooth.assembly_ward_select_box',compact('assemblyParts','WardVillages'));
        } catch (Exception $e) {
            
        }
    }
    public function WardWiseBooth(Request $request)
    { 
      $selectbooths= DB::select(DB::raw("Select `id`, concat(`booth_no`,ifnull(`booth_no_c`,''),' - ',`name_e`) as `booth_name` From `polling_booths` Where `village_id` = $request->village_id and `id` in (select `boothid` from `booth_ward_voter_mapping` where `wardId` =$request->ward_id ) Order by `booth_name`;"));
      return view('admin.master.wardbandiwithbooth.booth_select_box',compact('selectbooths'));
    }
    public function WardBandiWithBoothStore(Request $request)
    {  
      $rules=[
            'states' => 'required', 
            'district' => 'required', 
            'block' => 'required', 
            'village' => 'required', 
            'assembly_part' => 'required', 
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
      else {
        if ($request->forcefully==1) {
         $forcefully=1; 
        }else{
         $forcefully=0; 
        }
        if ($request->from_sr_no==null) {
           $from_sr_no=0;
         }
         else if ($request->from_sr_no!=null) {
           $from_sr_no=$request->from_sr_no;
         }
         if ($request->to_sr_no==null) {
           $to_sr_no=0;
         }
         else if ($request->to_sr_no!=null) {
           $to_sr_no=$request->to_sr_no;
         } 
        $message=DB::select(DB::raw("call up_ward_bandi_voters ('$request->assembly_part','$request->ward','$request->booth','$from_sr_no','$to_sr_no','$forcefully')"));
        if ($message[0]->save_status=='Saved Successfully') {
          $response=['status'=>1,'msg'=>$message[0]->save_status];  
         }else{ 
          $response=['status'=>0,'msg'=>$message[0]->save_status];
         } 
       return response()->json($response);
      }
    }
    public function BoothWiseTotalMappedWard(Request $request)
    {
       try{ 
          $total_mapped=DB::select(DB::raw("select count(*) as `total_mapped` from `voters` where `booth_id` = $request->id;"));   
          return view('admin.master.wardbandiwithbooth.sr_no_form',compact('total_mapped'));
        } catch (Exception $e) {
            
        }
    }
    public function AssemblywisevoterMapped(Request $request)
    {  
       try{ 
           $voterLists=DB::select(DB::raw("Select `v`.`id`, `v`.`sr_no`, `v`.`name_l`, `v`.`father_name_l`, `wv`.`ward_no`, `po`.`Booth_No`
              From `Voters` `v`
              Left join `ward_villages` `wv` on `wv`.`id` = `v`.`ward_id`
              Left Join `polling_booths` `po` on `po`.`id` = `v`.`Booth_Id`
              Where `v`.`assembly_part_id` =$request->id
              Order By `v`.`sr_no`;"));  
          return view('admin.master.wardbandiwithbooth.voter_list',compact('voterLists'));
        } catch (Exception $e) {
            
        }
    }
//----------------------------------------------
    public function stateWiseDistrict(Request $request)
    {
       try{ 
          $admin=Auth::guard('admin')->user(); 
          $Districts=DB::select(DB::raw("call up_fetch_district_access ($admin->id, '$request->id')"));   
          return view('admin.master.districts.value_select_box',compact('Districts'));
        } catch (Exception $e) {
            
        }
    }
    
    public function DistrictWiseBlock(Request $request,$print_condition=null)
    {
       try{
          $admin=Auth::guard('admin')->user();
          if (empty($print_condition)) {
           $BlocksMcs=DB::select(DB::raw("call up_fetch_block_access ($admin->id, '$request->id')")); 
           }
           if (!empty($print_condition)) {
           $BlocksMcs=DB::select(DB::raw("call up_fetch_block_access_voterlistprint ($admin->id, '$request->id','$print_condition')")); 
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
    public function booth($value='')
    {
      try {
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::orderBy('name_e','ASC')->get();   
          $Villages= Village::orderBy('name_e','ASC')->get(); 
          return view('admin.master.booth.index',compact('Districts','States','BlocksMcs','Villages'));
        } catch (Exception $e) {
            
        }
    }
    public function boothStore(Request $request,$id=null)
   { 
       $rules=[
            'states' => 'required', 
            'district' => 'required', 
            'block' => 'required', 
            'village' => 'required', 
            'booth_no' => 'required|numeric', 
            
            'booth_name_english' => 'required', 
            'booth_name_local' => 'required', 
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
        $booths=PollingBooth::firstOrNew(['id'=>$id]);
        $booths->states_id=$request->states;
        $booths->districts_id=$request->district;
        $booths->blocks_id=$request->block;
        $booths->village_id=$request->village;
        $booths->booth_no=$request->booth_no;
        $booths->booth_no_c=$request->booth_no_c;
        $booths->name_e=$request->booth_name_english;
        $booths->name_l=$request->booth_name_local;
        $booths->save(); 
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function boothTable(Request $request)
    {
       $booths=PollingBooth::where('village_id',$request->id)->orderBy('states_id','ASC')->orderBy('districts_id','ASC')->orderBy('blocks_id','ASC')->orderBy('village_id','ASC')->orderBy('booth_no','ASC')->get();
       return view('admin.master.booth.table',compact('booths'));     
    }
    public function boothEdit($id)
    {
       $booth=PollingBooth::find($id);
       return view('admin.master.booth.edit',compact('booth'));     
    }
    public function boothDelete($id)
    {
       $booth=PollingBooth::find($id);
       $booth->delete();
       $response=['status'=>1,'msg'=>'Delete Successfully'];
       return response()->json($response);
           
    }
    public function pollingDayTime()
    {
      try {
          $Districts= District::orderBy('name_e','ASC')->get(); 
          return view('admin.master.pollingDayTime.index',compact('Districts'));
        } catch (Exception $e) {
            
        }      
    }
    public function pollingDayTimeStore(Request $request,$id=null)
   { 
       $rules=[ 
            'block' => 'required',  
            'polling_day_time_english' => 'required', 
            'polling_day_time_local' => 'required', 
            'signature' => 'required', 
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
        $PollingDayTime=PollingDayTime::firstOrNew(['block_id'=>$request->block]); 
        $PollingDayTime->block_id=$request->block; 
        $PollingDayTime->polling_day_time_e=$request->polling_day_time_english;
        $PollingDayTime->polling_day_time_l=$request->polling_day_time_local;
        
        //--start-image-save
        $dirpath = Storage_path() . '/app/voterslip';
        $vpath = '/voterslip';
        @mkdir($dirpath, 0755, true);
        $file =$request->signature;
        $imagedata = file_get_contents($file);
        $encode = base64_encode($imagedata);
        $image=base64_decode($encode); 
        $name =$request->block;
        $image= \Storage::disk('local')->put($vpath.'/'.$name.'.jpg',$image);
        //--end-image-save
        $PollingDayTime->signature=$vpath.'/'.$name.'.jpg'; 
        $PollingDayTime->save(); 
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function pollingDayTimeList(Request $request)
    {
      $PollingDayTimes= PollingDayTime::where('block_id',$request->id)->orderBy('polling_day_time_e','ASC')->get(); 
      return view('admin.master.pollingDayTime.list',compact('PollingDayTimes'));      
    }     
}
