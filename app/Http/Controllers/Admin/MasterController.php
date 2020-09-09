<?php

namespace App\Http\Controllers\Admin;

use App\Helper\MyFuncs;
use App\Http\Controllers\Controller;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\BlockMc;
use App\Model\BlocksMc;
use App\Model\District;
use App\Model\Gender;
use App\Model\State;
use App\Model\TmpImportAssembly;
use App\Model\TmpImportVillage;
use App\Model\Village;
use App\Model\WardVillage;
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
        $user=Auth::guard('admin')->user(); 
        $zpWard = DB::select(DB::raw("call up_create_district_excel ('$user->id','$request->states','$request->code','$request->name_english','$request->name_local_language','$request->zp_ward')")); 
        
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
     
    //------------block-mcs----------------------------//

    public function BlockMCS(Request $request)
   {
      try {
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::orderBy('name_e','ASC')->get();   
          return view('admin.master.block.index',compact('Districts','States','BlocksMcs'));
        } catch (Exception $e) {
            
        }
   }
   public function BlockMCSStore(Request $request,$id=null)
   {  
       $rules=[
            'states' => 'required', 
            'district' => 'required', 
            'code' => 'required|unique:blocks_mcs,code,'.$id, 
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
       $States= BlocksMc::firstOrNew(['id'=>$id]);
       $States->states_id=$request->states;
       $States->districts_id=$request->district;
       $States->code=$request->code;
       $States->name_e=$request->name_english;
       $States->name_l=$request->name_local_language; 
       $States->save();
       $response=['status'=>1,'msg'=>'Submit Successfully'];
       return response()->json($response);
      }
    }
    public function BlockMCSEdit($id)
    {
       try {
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::find($id);  
          return view('admin.master.block.edit',compact('Districts','States','BlocksMcs'));
        } catch (Exception $e) {
            
        }
    }
    public function BlockMCSDelete($id)
    {
       $BlocksMc= BlocksMc::find(Crypt::decrypt($id));  
       $BlocksMc->delete();
       return redirect()->back()->with(['message'=>'Delete Successfully','class'=>'success']);  
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
       $States= Village::firstOrNew(['id'=>$id]);
       $States->states_id=$request->states;
       $States->districts_id=$request->district;
       $States->blocks_id=$request->block_mcs;
       $States->code=$request->code;
       $States->name_e=$request->name_english;
       $States->name_l=$request->name_local_language; 
       $States->draft_processed=0; 
       $States->final_processed=0; 
       $States->print_prepared=0; 
       $States->is_locked=0; 
       $States->save();
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
        
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::find($id); 
          $village=Village::find($id); 
          return view('admin.master.village.edit',compact('Districts','States','BlocksMcs','village'));
        } catch (Exception $e) {
            
        }
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
          $wards= WardVillage::orderBy('ward_no','ASC')->get();    
          return view('admin.master.wards.index',compact('Districts','States','BlocksMcs','Villages','wards'));
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
       DB::select(DB::raw("call up_create_assembly_part ('$Assembly->id','$request->part_no','0')"));
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
   public function AssemblyPartStore(Request $request,$id=null)
   {    
       $rules=[
            
            'Assembly' => 'required', 
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
       DB::select(DB::raw("call up_create_assembly_part ('$request->Assembly','$request->part_no','0')"));
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
          $assembly_id=$id;  
          return view('admin.master.assemblypart.edit',compact('assembly_id'));
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
          $Districts= District::orderBy('name_e','ASC')->get();   
          $States= State::orderBy('name_e','ASC')->get();   
          $BlocksMcs= BlocksMc::orderBy('name_e','ASC')->get();   
          $Villages= Village::orderBy('name_e','ASC')->get();  
          return view('admin.master.mappingvillageassemblypart.index',compact('Districts','States','Villages','BlocksMcs'));
        } catch (Exception $e) {
            
        }
    }
    public function MappingVillageAssemblyPartFilter(Request $request)
    {
       try {
          $assemblys= Assembly::orderBy('name_e','ASC')->get();  
          $Parts= AssemblyPart::orderBy('part_no','ASC')->get();  
          $assemblyParts= AssemblyPart::where('village_id',$request->id)->get();   
             
          return view('admin.master.mappingvillageassemblypart.value',compact('assemblys','Parts','assemblyParts','OldParts'));
        } catch (Exception $e) {
            
        }
    }
    public function MappingAssemblyWisePartNo(Request $request)
    { 
       $Parts= AssemblyPart::where('assembly_id',$request->id)->get();
       $OldParts= AssemblyPart::where('village_id',$request->village_id)->pluck('id')->toArray();
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
  //------------ward-bandi----------WardBandi-------//
    public function WardBandi()
    {
       try {
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
          $WardVillages= WardVillage::where('village_id',$request->id)->get();   
          return view('admin.master.wardbandi.value',compact('assemblyParts','WardVillages'));
        } catch (Exception $e) {
            
        }
    }
    public function WardBandiFilterAssemblyPart(Request $request)
    {
       try{ 
           $voterLists=DB::select(DB::raw("select `v`.`sr_no`, `v`.`name_l`, `v`.`father_name_l`, `vil`.`name_l` as `vil_name`, `wv`.`ward_no`from `voters` `v`Left Join `villages` `vil` on `vil`.`id` = `v`.`village_id`Left Join `ward_villages` `wv` on `wv`.`id` = `v`.`ward_id`Where `v`.`assembly_part_id` =$request->id;"));  
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
            'from_sr_no' => 'required', 
            'to_sr_no' => 'required', 
            
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
        DB::select(DB::raw("call up_ward_bandi_voters ('$request->assembly_part','$request->ward','$request->from_sr_no','$request->to_sr_no','$forcefully')")); 
       $response=['status'=>1,'msg'=>'Submit Successfully'];
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
           from `voters` `v`Left Join `villages` `vil` on `vil`.`id` = `v`.`village_id`Left Join `ward_villages` `wv` on `wv`.`id` = `v`.`ward_id`Where `v`.`assembly_part_id` =$request->assembly_part;")); 
       }
      elseif ($request->report==2) {
      $assemblyPart=AssemblyPart::find($request->assembly_part);
      $assembly=Assembly::find($assemblyPart->assembly_id);
      $voterReports=DB::select(DB::raw("select `v`.`sr_no`, `v`.`name_l`, `v`.`father_name_l`from `voters` `v`Where `v`.`assembly_part_id` =$request->assembly_part and `v`.`village_id` = 0 ;")); 
      }
      elseif ($request->report==3) {
      $village=Village::find($request->village);  
      $wardVillage=WardVillage::find($request->ward);  
      $voterReports= DB::select(DB::raw("select `a`.`code`, `ap`.`part_no`, `v`.`sr_no`, `v`.`name_l`, `v`.`father_name_l`from `voters` `v`Left Join `assemblys` `a` on `a`.`id` = `v`.`assembly_id`Left Join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id`Where `v`.`ward_id` =$request->ward ;"));
      } 
      
      $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->setPrintHeader(FALSE); 
      $pdf->SetCreator(PDF_CREATOR); 
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA)); 
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER); 
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
      $pdf->setFontSubsetting(true); 
      $pdf->SetFont('freesans', '', 11, '', true); 
      $pdf->AddPage();
      if ($request->report==1) {
      $html = view('admin.master.wardbandi.report_list',compact('voterReports','assemblyPart','assembly'));
      }
      elseif ($request->report==2) {
      $html = view('admin.master.wardbandi.report_list2',compact('voterReports','assemblyPart','assembly'));
      }
      elseif ($request->report==3) {
      $html = view('admin.master.wardbandi.report_list3',compact('voterReports','village','wardVillage'));
      } 
      $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='',$html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      ob_end_clean(); 
      $pdf->Output(); 





    }


    //---------onchange---------onchange-----------onchange---------------onchange-----------onchange

    public function stateWiseDistrict(Request $request)
    {
       try{ 
          $admin=Auth::guard('admin')->user(); 
          $Districts=DB::select(DB::raw("call up_fetch_district_access ($admin->id, '$request->id')"));   
          return view('admin.master.districts.value_select_box',compact('Districts'));
        } catch (Exception $e) {
            
        }
    }
    
    public function DistrictWiseBlock(Request $request)
    {
       try{
          $admin=Auth::guard('admin')->user(); 
          $BlocksMcs=DB::select(DB::raw("call up_fetch_block_access ($admin->id, '$request->id')"));  
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
