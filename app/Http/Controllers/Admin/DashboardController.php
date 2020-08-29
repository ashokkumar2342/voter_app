<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Model\AcademicYear;
use App\Model\Cashbook;
use App\Model\ClassType;
use App\Model\Event\EventDetails;
use App\Model\Exam\ClassTest;
use App\Model\Homework;
use App\Model\ParentRegistration;
use App\Model\StudentAttendance;
use App\Model\StudentFeeDetail;
use App\Model\StudentRemark;
use App\Model\StudentUserMap;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\createToken;
use Storage;
class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:admin');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
         
        return view('admin.dashboard.dashboard'); 
    }  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showStudentDetails(Request $request)
    {
        $classes = ClassType::all();
        $students = Student::all(); 
        return view('admin/dashboard/studentDetails',compact('classes','students'))->render();
    }
    //show Student Registration Details 
    public function showStudentRegistrationDetails(Request $request)
    {
        $classes = ClassType::all();
       $students = ParentRegistration::all(); 
        return view('admin/dashboard/studentRegistrationDetails',compact('classes','students'))->render();
    }

    public function passportTokenCreate(){
        $user = Admin::find(1);
        // Creating a token without scopes...
        $token = $user->createToken('Student')->accessToken;

        // Creating a token with scopes...
       // $token = $user->createToken('My Token', ['place-orders'])->accessToken;
        return $token;
    }

    public function proFile()
    {
        $admins = Auth::guard('admin')->user();
         return view('admin/dashboard/profile/view',compact('admins'));
    }
    public function proFileShow()
    {
        $admins = Auth::guard('admin')->user();
         return view('admin/dashboard/profile/profile_show',compact('admins'));
    }
    public function profileUpdate(Request $request)
    {
           
        $admins = Auth::guard('admin')->user();
         $rules=[
          
            'first_name' => 'required',
            'mobile' => 'required|digits:10',
            'email' => 'required',
            'dob' => 'required',
          
            
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
                $admins=Admin::find($admins->id);
                $admins->first_name=$request->first_name;
                $admins->email=$request->email;
                $admins->mobile=$request->mobile;
                $admins->dob=$request->dob; 
                $admins->save(); 
                $response=['status'=>1,'msg'=>'Upload Successfully'];
                return response()->json($response); 
            } 
          
    }
    public function profilePhoto()
    {
         
         return view('admin/dashboard/profile/profile_upload',compact('admins'));
    } 
    public function profilePhotoUpload(Request $request)
    {
        $admins = Auth::guard('admin')->user();
         $rules=[
          
             // 'image' => 'required|mimes:jpeg,jpg,png,gif|max:5000'          
            
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
                $data = $request->image; 
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $image_name= time().'.jpg';       
                $path = Storage_path() . "/app/student/profile/admin/" . $image_name; 
                @mkdir(Storage_path() . "/app/student/profile/admin/", 0755, true);     
                file_put_contents($path, $data); 
                $admins->profile_pic = $image_name;
                $admins->save();
                return response()->json(['success'=>'done']);
            
            
          }
    }
     public function proFilePhotoShow(Request $request,$profile_pic)
     {
         $profile_pic = Storage::disk('student')->get('profile/admin/'.$profile_pic);           
         return  response($profile_pic)->header('Content-Type', 'image/jpeg');
     }
     public function profilePhotoRefrash()
      {
          return view('admin.dashboard.profile.photo_refrash');
      } 
     public function passwordChange(Request $request)
    {
        $rules=[
          'old_password' => 'required', 
          'password' => 'required|min:6|max:50', 
          'confirm_password' => 'required|min:6|max:50', 
        ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $response=array();
            $response["status"]=0;
            $response["msg"]=$errors[0];
            return response()->json($response);// response as json
        }
        if ($request->confirm_password!=$request->password) {
            $response =array();
            $response['status'] =0;
            $response['msg'] ='Password Not Match';
            return $response;
        }
       $admin=Auth::guard('admin')->user();
        if (Hash::check($request->old_password, $admin->password))
        {
           $newPasswrod = Hash::make($request->password);
            $st=Admin::find($admin->id);
            $st->password =$newPasswrod ;
            $st->save();
            $response =array();
            $response['status'] =1;
            $response['msg'] ='Password Updated Successfully';
            return $response;
        }else{
           return 'not fond';
        }

    }
   
}
