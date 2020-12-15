<?php

namespace App\Http\Controllers\Admin; 
use App\Http\Controllers\Controller;
use App\Model\TmpImportAssembly;
use App\Model\TmpImportBlock;
use App\Model\TmpImportDistrict;
use App\Model\TmpImportMapVillageWard;
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
    $blocks= DB::select(DB::raw("call up_fetch_import_assembly_sample ('$user->id')"));
   	$villages= DB::select(DB::raw("call up_fetch_import_village_sample ('$user->id')"));
    $villagewards=DB::select(DB::raw("call up_fetch_import_map_wards_sample ('$user->id')")); 
      return view('admin.import.index',compact('Districts','assemblys','blocks','villages','villagewards'));
   }

   public function importVote(Request $request)
   {
     if($request->hasFile('import_file')){  
        $path = $request->file('import_file')->getRealPath();
        $results = Excel::load($path, function($reader) {})->get(); 
        foreach ($results as $key => $value) {
          if (!empty($value->part_no)) { 
            $saveVote= DB::select(DB::raw("call up_import_wardbandi_booth ('$value->ac_no','$value->part_no','$value->from_sr_no','$value->to_sr_no','$value->district_code','$value->block_code','$value->village_code','$value->ward_no','$value->booth_no')"));
          }
        } 
        $response=['status'=>1,'msg'=>'Import Successfully'];
            return response()->json($response);
      }
        $response=['status'=>0,'msg'=>'File Not Select'];
            return response()->json($response); 
   }





   public function DistrictExportSample($value='')
   {
    $user=Auth::guard('admin')->user(); 
    $Districts= DB::select(DB::raw("call up_fetch_import_district_sample ('$user->id')"));
    return view('admin.import.district_sample',compact('Districts'));  
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
             $SaveResult=DB::select(DB::raw("call up_create_district_excel ('$user->id','$value->state_id','$value->district_code','$value->district_name_eng','$value->district_name_hindi','$value->total_zp_wards')"));      
            } 
        }
        $disImportedDatas=TmpImportDistrict::all();
        $response = array();
        $response['status'] = 1;
        // $response['msg'] = 'Import Successfully';
        $response['data'] =view('admin.import.district_import_data',compact('disImportedDatas'))->render();
        return response()->json($response);  
      }
      
     $response=['status'=>0,'msg'=>'File Not Select'];
            return response()->json($response);  
   }
   public function AssemblyExportSample()
   {
    $user=Auth::guard('admin')->user();  
    $assemblys= DB::select(DB::raw("call up_fetch_import_assembly_sample ('$user->id')"));
    return view('admin.import.assembly_sample',compact('assemblys'));  
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

     $response=['status'=>0,'msg'=>'File Not Select'];
            return response()->json($response);  
   }
   public function BlockExportSample()
   {
    $user=Auth::guard('admin')->user();  
    $blocks= DB::select(DB::raw("call up_fetch_import_assembly_sample ('$user->id')"));
    return view('admin.import.block_sample',compact('blocks'));  
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
             $SaveResult=DB::select(DB::raw("call up_create_block_excel ('$user->id','0','$value->district_id','$value->block_code','$value->block_name_eng','$value->block_name_hindi','$value->total_wards','$value->block_mc_type_id')"));      
            } 
        }
        $BloImportedDatas=TmpImportBlock::all();
        $response = array();
        $response['status'] = 1;
        $response['data'] =view('admin.import.block_import_data',compact('BloImportedDatas'))->render();
        return response()->json($response);  
      }

     $response=['status'=>0,'msg'=>'File Not Select'];
            return response()->json($response);  
   }
   public function VillageExportSample()
   {
    $user=Auth::guard('admin')->user();  
    $villages= DB::select(DB::raw("call up_fetch_import_village_sample ('$user->id')"));
    return view('admin.import.village_sample',compact('villages'));  
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

     $response=['status'=>0,'msg'=>'File Not Select'];
            return response()->json($response);  
   }

   public function VillageWardExportSample()
   {
    $user=Auth::guard('admin')->user();  
    $villagewards=DB::select(DB::raw("call up_fetch_import_map_wards_sample ('$user->id')"));
    return view('admin.import.village_ward_sample',compact('villagewards'));  
   }
   public function VillageWardImportForm($value='')
   {
     return view('admin.import.village_ward_form');
   }
   public function VillageWardImportStore(Request $request)
   {
     if($request->hasFile('import_file')){  
        $path = $request->file('import_file')->getRealPath();
        $results = Excel::load($path, function($reader) {})->get();
        $user = Auth::guard('admin')->user();
        $TmpImportMapVillageWard=TmpImportMapVillageWard::where('userid',$user->id)->pluck('userid')->toArray();
        $Old_TmpImportMapVillageWard=TmpImportMapVillageWard::whereIn('userid',$TmpImportMapVillageWard)->delete();
       foreach ($results as $key => $value) {
          if(empty($value->village_id)){       
           $SaveResult=DB::select(DB::raw("call up_imp_map_village_wards_excel ('$user->id','$value->state_id','$value->district_id','$value->block_id','$value->village_id','$value->total_wards','$value->zp_ward_no','$value->ps_ward_no')"));      
           } 
        }
        $villageSamples=TmpImportMapVillageWard::all();
        $response = array();
        $response['status'] = 1;
        $response['data'] =view('admin.import.village_ward_data',compact('villageSamples'))->render();
        return response()->json($response);  
      }

     $response=['status'=>0,'msg'=>'File Not Select'];
            return response()->json($response);  
   }
}
