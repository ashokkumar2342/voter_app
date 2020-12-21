<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Assembly;
use App\Model\AssemblyPart;
use App\Model\BlocksMc;
use App\Model\DeleteVoterDetail;
use App\Model\District;
use App\Model\Gender;
use App\Model\Relation;
use App\Model\State;
use App\Model\UserActivity;
use App\Model\Village;
use App\Model\Voter;
use App\Model\VoterImage;
use App\Model\VoterListMaster;
use App\Model\VoterListProcessed;
use App\Model\VoterListModify;
use App\Model\WardVillage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Imagick;
use PDF;
use TCPDF;
class VoterDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 

      $genders= Gender::orderBy('id','ASC')->get();  
      $Relations= Relation::orderBy('id','ASC')->get();  
      $Districts= District::orderBy('name_e','ASC')->get();  
      return view('admin.voterDetails.index',compact('Districts','genders','Relations'));   
    }

    public function districtWiseAssembly(Request $request)
    {
       $assemblys=Assembly::where('district_id',$request->id)->orderBy('code','ASC')->get(); 
       return view('admin.master.assembly.assembly_value_select_box',compact('assemblys'));
    }
    public function districtWiseVillage(Request $request)
    {
       $villages=Village::where('districts_id',$request->id)->orderBy('code','ASC')->get();
       return view('admin.voterDetails.village_value',compact('villages'));
    }
    public function AssemblyWisePartNo(Request $request)
    {
       $Parts= AssemblyPart::where('assembly_id',$request->id)->orderBy('part_no','ASC')->get();  
       return view('admin.voterDetails.select_part_no',compact('Parts')); 
    }
    public function VillageWiseWard(Request $request)
    {
     
      $WardVillages= WardVillage::where('village_id',$request->id)->get(['id','ward_no']);
      return view('admin.voterDetails.select_ward_no',compact('WardVillages')); 
    }
    public function VillageWiseVoterList(Request $request)
    {
       $voterlists=Voter::where('village_id',$request->village_id)->where('status',1)->get();
       return view('admin.voterDetails.voter_list_table',compact('voterlists'));
    }
    public function voterListEdit($voter_id)
    {
      $genders= Gender::orderBy('id','ASC')->get();  
      $Relations= Relation::orderBy('id','ASC')->get();
      $voterlist=Voter::find($voter_id);
       return view('admin.voterDetails.voter_list_edit',compact('voterlist','genders','Relations')); 
    }
    public function calculateAge(Request $request)
     { 
        $date1=date_create($request->id);
        $date2=date_create(date('Y-m-d'));
        $diff=date_diff($date1,$date2);
        return view('admin.voterDetails.age_value',compact('diff')); 
     }
     public function NameConvert(Request $request,$condition_type)
    { 
      if ($condition_type==3) {
       $name_english= DB::select(DB::raw("select uf_house_convert_e_2_h ('$request->name_english') as 'name_l'"));   
       }
       else{  
       $name_english= DB::select(DB::raw("select uf_name_convert_e_2_h ('$request->name_english') as 'name_l'")); 
       }
       
      $name_l = preg_replace('/[\x00]/', '', $name_english[0]->name_l); 
      return view('admin.voterDetails.name_hindi_value',compact('name_l','condition_type'));   
    } 
    public function store(Request $request)
    {    
        $rules=[            
            'district' => 'required', 
            'block' => 'required', 
            'village' => 'required', 
            'ward_no' => 'required', 
            'assembly' => 'required', 
            'part_no' => 'required', 
            'name_english' => 'required', 
            'name_local_language' => 'required', 
            'relation' => 'required', 
            'f_h_name_english' => 'required', 
            'f_h_name_local_language' => 'required', 
            'house_no_english' => 'required', 
            'house_no_local_language' => 'required', 
            'gender' => 'required', 
            'age' => 'required', 
            'voter_id_no' => 'required',  
            'image' => 'required|max:500', 
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
            $voterListMaster=VoterListMaster::where('status',1)->first();
            $house_no=DB::select(DB::raw("Select `uf_converthno`('$request->house_no_english') as 'hno_int';")); 
            $voter=new Voter(); 
            $voter->district_id = $request->district;
            $voter->assembly_id = $request->block;
            $voter->village_id = $request->village;
            $voter->ward_id = $request->ward_no;
            $voter->assembly_id = $request->assembly;
            $voter->assembly_part_id = $request->part_no;
            $voter->booth_id = $request->booth_id;
            $voter->name_e = $request->name_english;
            $voter->name_l = $request->name_local_language;
            $voter->father_name_e = $request->f_h_name_english;
            $voter->father_name_l = $request->f_h_name_local_language;
            $voter->voter_card_no = $request->voter_id_no;
            $voter->house_no = $house_no[0]->hno_int;
            $voter->house_no_e = $request->house_no_english;
            $voter->house_no_l = $request->house_no_local_language; 
            $voter->relation = $request->relation;
            $voter->gender_id = $request->gender;
            $voter->age = $request->age;
            $voter->mobile_no = $request->mobile_no;
            $voter->aadhar_no = $request->Aadhaar_no;
            $voter->source ='N';
            $voter->suppliment_no =$voterListMaster->id;
            $voter->status =1;
            $voter->save();
            //--start-image-save
            $dirpath = Storage_path() . '/app/vimage/'.$request->assembly.'/'.$request->part_no;
            $vpath = '/vimage/'.$request->assembly.'/'.$request->part_no;
            @mkdir($dirpath, 0755, true);
            $file =$request->image;
            $imagedata = file_get_contents($file);
            $encode = base64_encode($imagedata);
            $image=base64_decode($encode); 
            $name =$voter->id;
            $image= \Storage::disk('local')->put($vpath.'/'.$name.'.jpg',$image);
            //--end-image-save 
            $response=['status'=>1,'msg'=>'Submit Successfully'];
            return response()->json($response);
      }
     

    }
    public function voterUpdate(Request $request,$id)
    {    
        $rules=[            
             
            'name_english' => 'required', 
            'name_local_language' => 'required', 
            'relation' => 'required', 
            'f_h_name_english' => 'required', 
            'f_h_name_local_language' => 'required', 
            'house_no_english' => 'required', 
            'house_no_local_language' => 'required', 
            'gender' => 'required', 
            'age' => 'required', 
            'voter_id_no' => 'required',  
             
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
            $house_no=DB::select(DB::raw("Select `uf_converthno`('$request->house_no_english') as 'hno_int';")); 
            $voter=Voter::find($id);  
            $voter->name_e = $request->name_english;
            $voter->name_l = $request->name_local_language;
            $voter->father_name_e = $request->f_h_name_english;
            $voter->father_name_l = $request->f_h_name_local_language;
            $voter->voter_card_no = $request->voter_id_no;
            $voter->house_no = $house_no[0]->hno_int;
            $voter->house_no_e = $request->house_no_english;
            $voter->house_no_l = $request->house_no_local_language; 
            $voter->relation = $request->relation;
            $voter->gender_id = $request->gender;
            $voter->age = $request->age;
            $voter->mobile_no = $request->mobile_no;
            $voter->status =1;
            $voter->save();             
            $response=['status'=>1,'msg'=>'Update Successfully'];
            return response()->json($response);
      }
     

    }
    public function voterDelete($voter_id)
    {
       $voter=Voter::find($voter_id);   
       $voter->delete();
       $response=['status'=>1,'msg'=>'Delete Successfully'];
            return response()->json($response);   
    }

    
     
    public function DeteleAndRestore()
    {
      $Districts= District::orderBy('name_e','ASC')->get();  
      return view('admin.DeteleAndRestore.index',compact('Districts','genders','voters')); 
    }
    public function DeteleAndRestoreShow(Request $request)
    {
        $rules=[ 
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
        $voters =Voter:: 
                 where('village_id',$request->village)
               ->where(function($query) use($request){ 
                if (!empty($request->print_sr_no)) {
                $query->where('print_sr_no', 'like','%'.$request->print_sr_no.'%'); 
                }
                if (!empty($request->name)) {
                $query->where('name_e', 'like','%'.$request->name.'%'); 
                }
                if (!empty($request->father_name)) {
                $query->where('father_name_e', 'like','%'.$request->father_name.'%'); 
                } 
               }) 
               ->get(); 
        $response= array();                       
        $response['status']= 1;                       
        $response['data']=view('admin.DeteleAndRestore.search_table',compact('voters'))->render();
        return $response;
         
       
    } 
    public function DeteleAndRestoreDetele($id)
    {
      $voter=Voter::find($id);
      $DeleteVoterDetail= new DeleteVoterDetail();
      $DeleteVoterDetail->voter_id=$id;
      $DeleteVoterDetail->voter_list_master_id=$voter->suppliment_no;
      $DeleteVoterDetail->voter_list_master_id=$voter->suppliment_no;
      $DeleteVoterDetail->previous_status=$voter->status;
      $DeleteVoterDetail->status=2;
      $DeleteVoterDetail->save();
      $voter->status=2;
      $voter->save();
      $response=['status'=>1,'msg'=>'Delete Successfully'];
      return response()->json($response);
    }
    public function DeteleAndRestoreRestore($id)
    {
      $DeleteVoterDetail=DeleteVoterDetail::where('voter_id',$id)->first();  
      $voter=Voter::find($id);
      $voter->status=$DeleteVoterDetail->previous_status;
      $voter->save();
      $DeleteVoterDetail->delete();
      $response=['status'=>1,'msg'=>'Restore Successfully'];
      return response()->json($response);
    }
    

  //--modify------modify-------------  
    public function VoterDetailsModify($value='')
    {
       $Districts= District::orderBy('name_e','ASC')->get();  
      return view('admin.modify.index',compact('Districts')); 
    }
    public function VoterDetailsModifyShow(Request $request)
    {
        $rules=[ 
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
        $voters =Voter:: 
                 where('village_id',$request->village)
               ->where(function($query) use($request){ 
                if (!empty($request->print_sr_no)) {
                $query->where('print_sr_no', 'like','%'.$request->print_sr_no.'%'); 
                }
                if (!empty($request->name)) {
                $query->where('name_e', 'like','%'.$request->name.'%'); 
                }
                if (!empty($request->father_name)) {
                $query->where('father_name_e', 'like','%'.$request->father_name.'%'); 
                } 
               }) 
               ->get(); 
        $response= array();                       
        $response['status']= 1;                       
        $response['data']=view('admin.modify.table',compact('voters'))->render();
        return $response;
         
       
    }
    public function VoterDetailsModifyEdit($voter_id)
    {
      $genders= Gender::orderBy('id','ASC')->get();  
      $Relations= Relation::orderBy('id','ASC')->get(); 
      $voter=Voter::find($voter_id); 
     return view('admin.modify.edit',compact('voter','genders','Relations'));
    }
    public function VoterDetailsModifyStore(Request $request,$id)
    { 
      $voter=Voter::find($id);
      $VoterListModify= new VoterListModify();
      $VoterListModify->voter_id=$id;
      $VoterListModify->name_e=$voter->name_e;
      $VoterListModify->name_l=$voter->name_l;
      $VoterListModify->father_name_e=$voter->father_name_e;
      $VoterListModify->father_name_l=$voter->father_name_l;
      $VoterListModify->house_no_e=$voter->house_no_e;
      $VoterListModify->house_no_l=$voter->house_no_l;
      $VoterListModify->age=$voter->age;
      $VoterListModify->mobile_no=$voter->mobile_no;
      $VoterListModify->relation=$voter->relation;
      $VoterListModify->gender_id=$voter->gender_id; 
      $VoterListModify->previous_status=$voter->status;
      $VoterListModify->status=3; 
      $VoterListModify->save(); 
       
      $voter->name_e=$request->name_english;
      $voter->name_l=$request->name_local_language;
      $voter->father_name_e=$request->f_h_name_english;
      $voter->father_name_l=$request->f_h_name_local_language;
      $voter->house_no_e=$request->house_no_english;
      $voter->house_no_l=$request->house_no_local_language;
      $voter->age=$request->age;
      $voter->mobile_no=$request->mobile_no;
      $voter->relation=$request->relation;
      $voter->gender_id=$request->gender;  
      $voter->status=3; 
      $voter->save();
      //--start-image-save
      if ($request->hasFile('image')) {
          $dirpath = Storage_path() . '/app/vimage/'.$voter->assembly_id.'/'.$voter->assembly_part_id;
          $vpath = '/vimage/'.$voter->assembly_id.'/'.$voter->assembly_part_id;
          @mkdir($dirpath, 0755, true);
          $file =$request->image;
          $imagedata = file_get_contents($file);
          $encode = base64_encode($imagedata);
          $image=base64_decode($encode); 
          $name =$voter->id;
          $image= \Storage::disk('local')->put($vpath.'/'.$name.'.jpg',$image);
      }
      //--end-image-save 
      $response=['status'=>1,'msg'=>'Modify Successfully'];
      return response()->json($response);
    }
    public function VoterDetailsModifyReset($id)
    {
      $VoterListModify=VoterListModify::where('voter_id',$id)->first();
      $voter=Voter::find($id); 
      $voter->name_e=$VoterListModify->name_e;
      $voter->name_l=$VoterListModify->name_l;
      $voter->father_name_e=$VoterListModify->father_name_e;
      $voter->father_name_l=$VoterListModify->father_name_l;
      $voter->house_no_e=$VoterListModify->house_no_e;
      $voter->house_no_l=$VoterListModify->house_no_l;
      $voter->age=$VoterListModify->age;
      $voter->mobile_no=$VoterListModify->mobile_no;
      $voter->relation=$VoterListModify->relation;
      $voter->gender_id=$VoterListModify->gender_id; 
      $voter->status=$VoterListModify->previous_status; 
      $voter->save();
      $VoterListModify->delete(); 
      $response=['status'=>1,'msg'=>'Modify Successfully'];
      return response()->json($response);
    }

    //--------Prepare-----Voter--------List-------PrepareVoterList----------

    public function PrepareVoterListPanchayat()
    {
      $Districts= District::orderBy('name_e','ASC')->get();
      return view('admin.master.PrepareVoterList.index',compact('Districts'));     
    }
    public function VillageWiseWardMultiple(Request $request)
    { 
      $WardVillages = DB::select(DB::raw("call up_fetch_ward_village_access ('$request->id','0')")); 
     
      return view('admin.master.PrepareVoterList.select_ward_value',compact('WardVillages'));     
    }
    public function PrepareVoterListGenerate(Request $request)
    {  
      $rules=[            
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
    if ($request->proses_by==1) {
        $voterListMaster=VoterListMaster::where('status',1)->first();
        $voterlistprocessed=new VoterListProcessed(); 
        $voterlistprocessed->district_id=$request->district; 
        $voterlistprocessed->block_id=$request->block; 
        $voterlistprocessed->village_id=$request->village; 
        $voterlistprocessed->voter_list_master_id=$voterListMaster->id; 
        $voterlistprocessed->report_type='panchayat'; 
        $voterlistprocessed->submit_date=date('Y-m-d'); 
        $voterlistprocessed->save();   
        \Artisan::queue('voterlistpanchayat:generate',['district_id'=>$request->district,'block_id'=>$request->block,'village_id'=>$request->village]);
      }
      else if($request->proses_by==2) {
      $unlock_village_voterlist = DB::select(DB::raw("call up_unlock_village_voterlist ('$request->village')"));
       $response=['status'=>1,'msg'=>'Unlock Successfully'];
            return response()->json($response);
      }
    }
     
    
    public function PrepareVoterListMunicipal()
    {
      $Districts= District::orderBy('name_e','ASC')->get();
      return view('admin.master.PrepareVoterList.municipal.index',compact('Districts'));     
    }

    public function PrepareVoterListMunicipalGenerate(Request $request)
    {  
      $rules=[            
            'district' => 'required', 
            'block' => 'required', 
            'village' => 'required', 
            'ward' => 'required', 
      ];
      $validator = Validator::make($request->all(),$rules);
      if ($validator->fails()) {
          $errors = $validator->errors()->all();
          $response=array();
          $response["status"]=0;
          $response["msg"]=$errors[0];
          return response()->json($response);// response as json
      }  
    if ($request->proses_by==1) {
        $voterListMaster=VoterListMaster::where('status',1)->first();
        $voterlistprocessed=new VoterListProcessed(); 
        $voterlistprocessed->district_id=$request->district; 
        $voterlistprocessed->block_id=$request->block; 
        $voterlistprocessed->village_id=$request->village; 
        $voterlistprocessed->ward_id=$request->ward; 
        $voterlistprocessed->voter_list_master_id=$voterListMaster->id; 
        $voterlistprocessed->report_type='mc'; 
        $voterlistprocessed->submit_date=date('Y-m-d'); 
        $voterlistprocessed->save(); 
          
        \Artisan::queue('voterlistmc:generate',['district_id'=>$request->district,'block_id'=>$request->block,'village_id'=>$request->village,'ward_id'=>$request->ward]);  
      }
      else if($request->proses_by==2) {
      $voterReports = DB::select(DB::raw("call up_unlock_voterlist ('$request->ward')"));
       $response=['status'=>1,'msg'=>'Unlock Successfully'];
            return response()->json($response);
      }      
    } 
 //-------------------Prepare-Voter-List-Booth-Wise---------------------
    public function PrepareVoterListBoothWise()
    {
      $Districts= District::orderBy('name_e','ASC')->get();
      return view('admin.master.PrepareVoterList.booth.index',compact('Districts'));
    }
 //-------------------VoterListDownload---------------------
    public function VoterListDownload($value='')
    {
        $States= State::orderBy('name_e','ASC')->get();    
        $voterListMasters= VoterListMaster::orderBy('id','ASC')->get();    
        return view('admin.master.voterlistdownload.index',compact('States','voterListMasters'));
    }
    public function BlockWiseDownloadTable(Request $request)
    { 
      $voterlistprocesseds=VoterListProcessed::where('state_id',$request->state_id)->where('district_id',$request->district_id)->where('block_id',$request->block_id)->where('voter_list_master_id',$request->voter_list_master_id)->orderBy('file_path_p','ASC')->get();
      return view('admin.master.voterlistdownload.download_table',compact('voterlistprocesseds')); 
    }
    public function VoterListDownloadPDF($id,$condition)
     {  
        $voterlistprocessed=VoterListProcessed::find($id); 
        if ($condition=='p') {
        $documentUrl = Storage_path().$voterlistprocessed->folder_path.$voterlistprocessed->file_path_p; 
        }
        elseif ($condition=='w') {
        $documentUrl = Storage_path().$voterlistprocessed->folder_path.$voterlistprocessed->file_path_w; 
        }
        elseif ($condition=='h') {
        $documentUrl = Storage_path().$voterlistprocessed->folder_path.$voterlistprocessed->file_path_h; 
        }   
        return response()->file($documentUrl);
         
         
         
              
     }  
}
