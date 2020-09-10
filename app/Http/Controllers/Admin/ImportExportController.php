<?php

namespace App\Http\Controllers\Admin; 
use App\Http\Controllers\Controller;
use App\Model\TmpImportAssembly;
use App\Model\TmpImportBlock;
use App\Model\TmpImportDistrict;
use App\Model\TmpImportVillage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
   public function index()
   {
   	$user=Auth::guard('admin')->user(); 
   	$Districts= DB::select(DB::raw("call up_fetch_import_district_sample ('$user->id')"));
   	$assemblys= DB::select(DB::raw("call up_fetch_import_assembly_sample ('$user->id')"));
    $blocks= DB::select(DB::raw("call up_fetch_import_assembly_sample ('$user->id')"));
   	$villages= DB::select(DB::raw("call up_fetch_import_village_sample ('$user->id')"));
      return view('admin.import.index',compact('Districts','assemblys','blocks','villages'));
   }
   public function DistrictImportForm($value='')
   { 
   	 return view('admin.import.district_import_form'); 
   }
   public function DistrictImportStore(Request $request)
   {
   	 if($request->hasFile('import_file')){  
        $path = $request->file('import_file')->getRealPath();
        $results = Excel::load($path, function($reader) {})->get();
        $user = Auth::guard('admin')->user();
        $tmp_import_districts=TmpImportDistrict::where('userid',$user->id)->pluck('userid')->toArray();
        $Old_tmp_import_districts=TmpImportDistrict::whereIn('userid',$tmp_import_districts)->delete();
       foreach ($results as $key => $value) {         
             if (!empty($value->state_id)) {
             $SaveResult=DB::select(DB::raw("call up_create_district_excel ('$user->id','$value->state_id','$value->district_code','$value->district_name_eng','$value->district_name_hindi','$value->total_wards')"));      
            } 
        }
        $disImportedDatas=TmpImportDistrict::all();
        $response = array();
        $response['status'] = 1;
        $response['data'] =view('admin.import.district_import_data',compact('disImportedDatas'))->render();
        return response()->json($response);  
      }

     return back()->with('error','Please Check your file, Something is wrong there.'); 
   }

   public function AssemblyImportForm($value='')
   {
   	 return view('admin.import.assembly_import_form');
   }
   public function AssemblyImportStore(Request $request)
   {
   	 if($request->hasFile('import_file')){  
        $path = $request->file('import_file')->getRealPath();
        $results = Excel::load($path, function($reader) {})->get();
        $user = Auth::guard('admin')->user();
        $TmpImportAssembly=TmpImportAssembly::where('userid',$user->id)->pluck('userid')->toArray();
        $Old_TmpImportAssembly=TmpImportAssembly::whereIn('userid',$TmpImportAssembly)->delete();
       foreach ($results as $key => $value) {    
             if (!empty($value->district_id)) {
             $SaveResult=DB::select(DB::raw("call up_create_assembly_excel ('$user->id','$value->district_id','$value->assembly_code','$value->assembly_name_eng','$value->assembly_name_hindi','$value->total_parts')"));      
            } 
        }
        $AssImportedDatas=TmpImportAssembly::all();
        $response = array();
        $response['status'] = 1;
        $response['data'] =view('admin.import.assembly_import_data',compact('AssImportedDatas'))->render();
        return response()->json($response);  
      }

     return back()->with('error','Please Check your file, Something is wrong there.'); 
   }
   public function BlockImportForm($value='')
   {
     return view('admin.import.block_import_form');
   }
   public function BlockImportStore(Request $request)
   {
     if($request->hasFile('import_file')){  
        $path = $request->file('import_file')->getRealPath();
        $results = Excel::load($path, function($reader) {})->get();
        $user = Auth::guard('admin')->user();
        $TmpImportBlock=TmpImportBlock::where('userid',$user->id)->pluck('userid')->toArray();
        $Old_TmpImportBlock=TmpImportBlock::whereIn('userid',$TmpImportBlock)->delete();
       foreach ($results as $key => $value) {    
             if (!empty($value->district_id)) {
             $SaveResult=DB::select(DB::raw("call up_create_block_excel ('$user->id','0','$value->district_id','$value->block_code','$value->block_name_eng','$value->block_name_hindi','$value->total_wards')"));      
            } 
        }
        $BloImportedDatas=TmpImportBlock::all();
        $response = array();
        $response['status'] = 1;
        $response['data'] =view('admin.import.assembly_import_data',compact('BloImportedDatas'))->render();
        return response()->json($response);  
      }

     return back()->with('error','Please Check your file, Something is wrong there.'); 
   }
   public function VillageImportForm($value='')
   {
   	 return view('admin.import.village_import_form');
   }
   public function VillageImportStore(Request $request)
   {
   	 if($request->hasFile('import_file')){  
        $path = $request->file('import_file')->getRealPath();
        $results = Excel::load($path, function($reader) {})->get();
        $user = Auth::guard('admin')->user();
        $TmpImportVillage=TmpImportVillage::where('userid',$user->id)->pluck('userid')->toArray();
        $Old_TmpImportVillage=TmpImportVillage::whereIn('userid',$TmpImportVillage)->delete();
       foreach ($results as $key => $value) {    
             if (!empty($value->district_id)) {
             $SaveResult=DB::select(DB::raw("call up_create_village_excel ('$user->id','$value->state_id','$value->district_id','$value->block_id','$value->village_code','$value->village_name_eng','$value->village_name_hindi','$value->total_wards')"));      
            } 
        }
        $VillImportedDatas=TmpImportVillage::all();
        $response = array();
        $response['status'] = 1;
        $response['data'] =view('admin.import.village_import_data',compact('VillImportedDatas'))->render();
        return response()->json($response);  
      }

     return back()->with('error','Please Check your file, Something is wrong there.'); 
   }
}
