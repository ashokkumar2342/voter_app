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
use App\Model\WardVillage; 
use App\Model\VoterListMaster; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Imagick;
use PDF;
use TCPDF;
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo_example.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $footertext='hello';
        $this->writeHTML($footertext, false, true, false, true);
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
class VoterDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 

      $genders= Gender::all();  
      $Districts= District::orderBy('name_e','ASC')->get();  
      return view('admin.voterDetails.index',compact('Districts','genders'));   
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
    public function calculateAge(Request $request)
     { 
        $date1=date_create($request->id);
        $date2=date_create(date('Y-m-d'));
        $diff=date_diff($date1,$date2);
        return view('admin.voterDetails.age_value',compact('diff')); 
     } 
    public function store(Request $request)
    { 
        $rules=[
            
            'district' => 'required', 
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
            $file =$request->image;
            $imagedata = file_get_contents($file);
            $base64 = base64_encode($imagedata);
            $voter=new Voter(); 
            $voter->district_id = $request->district;
            $voter->assembly_id = $request->assembly;
            $voter->village_id = $request->village;
            $voter->assembly_part_id = $request->part_no;
            $voter->ward_id = $request->ward_no;
            $voter->voter_card_no = $request->voter_id_no;
            $voter->mobile_no = $request->mobile_no;
            $voter->house_no = $request->house_no;
            $voter->house_no_e = $request->house_no;
            $voter->house_no_l = $request->house_no;
            $voter->name_e = $request->voter_name;
            $voter->name_l = $request->voter_name;
            $voter->father_name_e = $request->father_name;
            $voter->relation = $request->relation;
            $voter->gender_id = $request->gender;
            $voter->save();
            $voterimage =new VoterImage();  
            $voterimage->voter_id = $voter->id;  
            $voterimage->image = $base64;  
            $voterimage->save();  
            $response=['status'=>1,'msg'=>'Submit Successfully'];
            return response()->json($response);
      }
     

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\UserActivity  $userActivity
     * @return \Illuminate\Http\Response
     */
    public function show(UserActivity $userActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\UserActivity  $userActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(UserActivity $userActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\UserActivity  $userActivity
     * @return \Illuminate\Http\Response
     */
    public function DeteleAndRestore()
    {
       
      return view('admin.DeteleAndRestore.index',compact('Districts','genders','voters')); 
    }
    public function DeteleAndRestoreForm()
    {
      $genders= Gender::all();  
      $Districts= District::orderBy('name_e','ASC')->get(); 
      $voterNews=Voter::orderBy('id','DESC')->first(); 
      $voterDeletes=Voter::where('status',1)->get(); 
      return view('admin.DeteleAndRestore.form',compact('Districts','genders','voterNews','voterDeletes')); 
    } 
    public function DeteleAndRestoreSearch()
    {
      return view('admin.DeteleAndRestore.search_model');    
    }
    public function DeteleAndRestoreSearchFilter(Request $request)
    {
      $voters=Voter::where('name_e', 'like','%'.$request->id.'%')->orWhere('voter_card_no', 'like','%'.$request->id.'%')->orWhere('house_no', 'like','%'.$request->id.'%')->get(); 
      return view('admin.DeteleAndRestore.search_table',compact('voters'));    
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
       $WardVillages=WardVillage::where('village_id',$request->village)->first(); 
       $PrepareVoterListSave= DB::select(DB::raw("call up_process_village_voterlist ('$request->village')"));  
       $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$WardVillages->id;")); 
       $voterssrnodetails = DB::select(DB::raw("Select * From `voters_srno_detail` where `voter_list_master_id` =$voterListMaster->id and `wardid` = $WardVillages->id;"));
      $voterReports = DB::select(DB::raw("select `hpsn`.`print_sr_no`,`v`.`voter_card_no`, case `source` when 'V' then concat('*', `ap`.`part_no`, '/', `v`.`sr_no`) Else 'New' End as `part_srno`, `v`.`name_l`, case `v`.`relation` When 'F' then 'पिता' When 'H' Then 'पति' End as `vrelation`, `v`.`father_name_l`, `v`.`house_no_l`, `v`.`age`, `g`.`genders_l`, `vi`.`image` from `history_print_sr_no` `hpsn` inner join `voters` `v` on `v`.`id` = `hpsn`.`voter_id` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `hpsn`.`gender_id` LEFT JOIN `voter_image` `vi` on `vi`.`voter_id` = `v`.`id` 
         where `hpsn`.`supliment_no` = 1 And `hpsn`.`ward_id` =$WardVillages->id And `hpsn`.`status` in (0,1,3) Order By `hpsn`.`print_sr_no`; "));        
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
         $html = view('admin.master.PrepareVoterList.report_photo',compact('mainpagedetails','voterssrnodetails','voterReports')); 
         $mpdf->WriteHTML($html); 
         $documentUrl = Storage_path() . '/app/voter/Prepare/village/'.$request->district.'/'.$request->block;   
        @mkdir($documentUrl, 0755, true);  
        $mpdf->Output($documentUrl.'/'.$request->village.'_photo'.'.pdf', 'F');
        return  $this->SavePhoth($request->district,$request->block,$request->village,$mainpagedetails,$voterssrnodetails,$voterReports); 
      }
      else if($request->proses_by==2) {
      $unlock_village_voterlist = DB::select(DB::raw("call up_unlock_village_voterlist ('$request->village')"));
       $response=['status'=>1,'msg'=>'Unlock Successfully'];
            return response()->json($response);
      }
    }
    public function SavePhoth($district,$block,$village,$mainpagedetails,$voterssrnodetails,$voterReports)
    {
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
         $html = view('admin.master.PrepareVoterList.report_without_photo',compact('mainpagedetails','voterssrnodetails','voterReports')); 
         $mpdf->WriteHTML($html); 
         $documentUrl = Storage_path() . '/app/voter/Prepare/village/'.$district.'/'.$block;   
        @mkdir($documentUrl, 0755, true);  
        $mpdf->Output($documentUrl.'/'.$village.'_without_photo'.'.pdf', 'F'); 
        $response=['status'=>1,'msg'=>'Process And Lock Successfully'];
            return response()->json($response); 
    }
    public function PrepareVoterListPanchayatDownload(Request $request,$id)
     {  
        if ($id==1) {
        $documentUrl = Storage_path() . '/app/voter/Prepare/village/'.$request->district_id.'/'.$request->block_id.'/'.$request->village_id.'_photo.pdf'; 
        return response()->file($documentUrl);
        }
        elseif ($id==2) {
         $documentUrl = Storage_path() . '/app/voter/Prepare/village/'.$request->district_id.'/'.$request->block_id.'/'.$request->village_id.'_without_photo.pdf';
        return response()->file($documentUrl);
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
       $PrepareVoterListSave= DB::select(DB::raw("call up_process_voterlist ('$request->ward')"));  
       $mainpagedetails= DB::select(DB::raw("Select * From `main_page_detail` where `voter_list_master_id` =$voterListMaster->id and `ward_id` =$request->ward;")); 
       $voterssrnodetails = DB::select(DB::raw("Select * From `voters_srno_detail` where `voter_list_master_id` =$voterListMaster->id and `wardid` = $request->ward;"));
      $voterReports = DB::select(DB::raw("select `hpsn`.`print_sr_no`,`v`.`voter_card_no`, case `source` when 'V' then concat('*', `ap`.`part_no`, '/', `v`.`sr_no`) Else 'New' End as `part_srno`, `v`.`name_l`, case `v`.`relation` When 'F' then 'पिता' When 'H' Then 'पति' End as `vrelation`, `v`.`father_name_l`, `v`.`house_no_l`, `v`.`age`, `g`.`genders_l`, `vi`.`image` from `history_print_sr_no` `hpsn` inner join `voters` `v` on `v`.`id` = `hpsn`.`voter_id` inner join `assembly_parts` `ap` on `ap`.`id` = `v`.`assembly_part_id` Inner Join `genders` `g` on `g`.`id` = `hpsn`.`gender_id` LEFT JOIN `voter_image` `vi` on `vi`.`voter_id` = `v`.`id` 
         where `hpsn`.`supliment_no` = 1 And `hpsn`.`ward_id` =$request->ward And `hpsn`.`status` in (0,1,3) Order By `hpsn`.`print_sr_no`; ")); 
        
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
         $html = view('admin.master.PrepareVoterList.municipal.report_with_photo',compact('mainpagedetails','voterssrnodetails','voterReports')); 
         $mpdf->WriteHTML($html); 
         $documentUrl = Storage_path() . '/app/voter/Prepare/ward/'.$request->district.'/'.$request->block.'/'.$request->village;   
        @mkdir($documentUrl, 0755, true);  
        $mpdf->Output($documentUrl.'/'.$request->ward.'_photo'.'.pdf', 'F'); 
        return  $this->SaveMunicipal($request->district,$request->block,$request->village,$request->ward,$mainpagedetails,$voterssrnodetails,$voterReports);  
      }
      else if($request->proses_by==2) {
      $voterReports = DB::select(DB::raw("call up_unlock_voterlist ('$request->ward')"));
       $response=['status'=>1,'msg'=>'Unlock Successfully'];
            return response()->json($response);
      }      
    }
    public function SaveMunicipal($district,$block,$village,$ward,$mainpagedetails,$voterssrnodetails,$voterReports)
    {
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
         $html = view('admin.master.PrepareVoterList.municipal.report_without_photo',compact('mainpagedetails','voterssrnodetails','voterReports')); 
         $mpdf->WriteHTML($html); 
         $documentUrl = Storage_path() . '/app/voter/Prepare/ward/'.$district.'/'.$block.'/'.$village;   
        @mkdir($documentUrl, 0755, true);  
        $mpdf->Output($documentUrl.'/'.$ward.'_without_photo'.'.pdf', 'F'); 
        $response=['status'=>1,'msg'=>'Process And Lock Successfully'];
            return response()->json($response); 
    }
    public function PrepareVoterListMunicipalDownload(Request $request,$id)
     {  
        if ($id==1) {
        $documentUrl = Storage_path() . '/app/voter/Prepare/ward/'.$request->district_id.'/'.$request->block_id.'/'.$request->village_id.'/'.$request->ward_id.'_photo'.'.pdf'; 
        return response()->file($documentUrl);
        }
        elseif ($id==2) {
        $documentUrl = Storage_path() . '/app/voter/Prepare/ward/'.$request->district_id.'/'.$request->block_id.'/'.$request->village_id.'/'.$request->ward_id.'_without_photo'.'.pdf'; 
        return response()->file($documentUrl);
        }
         
              
     } 
}
