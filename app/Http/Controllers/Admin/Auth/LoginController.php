<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Admin;
use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Model\BlocksMc;
use App\Model\District;
use App\Model\Village;
use App\Student;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest')->except('logout');
    }

    public function index(){
        return redirect()->route('admin.login');
        
    }
    
    
    public function searchVoter(){
        return view('admin.auth.search');
    }
    public function searchVoterform($id)
    {
      $Districts=District::orderBy('name_e','ASC')->get();
      if ($id==1) {
      return view('admin.auth.search_form_epic',compact('Districts')); 
      }
      elseif ($id==2) {
      return view('admin.auth.search_form',compact('Districts')); 
      }
      
    }
    public function searchDisBlock(Request $request)
    {
       try{
           
          $BlocksMcs=BlocksMc::where('districts_id',$request->id)->get(); 
          return view('admin.master.block.value_select_box',compact('BlocksMcs'));
        } catch (Exception $e) {
            
        }
    }
    public function searchBlockVillage(Request $request)
    {
       try{ 
           
          $Villages=Village::where('blocks_id',$request->id)->get(); 
          return view('admin.master.village.value_select_box',compact('Villages'));
        } catch (Exception $e) {
            
        }
    }
    public function searchVoterFilter(Request $request)
    {
      $rules=[ 
              // 'village' => 'required', 
        ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $response=array();
            $response["status"]=0;
            $response["msg"]=$errors[0];
            return response()->json($response);// response as json
        }
        // $voters =Voter:: 
        //          where('village_id',$request->village)
        //        ->where(function($query) use($request){ 
        //         if (!empty($request->print_sr_no)) {
        //         $query->where('print_sr_no', 'like','%'.$request->print_sr_no.'%'); 
        //         }
        //         if (!empty($request->name)) {
        //         $query->where('name_e', 'like','%'.$request->name.'%'); 
        //         }
        //         if (!empty($request->father_name)) {
        //         $query->where('father_name_e', 'like','%'.$request->father_name.'%'); 
        //         } 
        //        }) 
        //        ->get(); 
        $response= array();                       
        $response['status']= 1;                       
        $response['data']=view('admin.auth.result',compact('voters'))->render();
        return $response;
       
    }
    public function showLoginForm(){
        return view('admin.auth.login');
    }
    public function login(Request $request){ 
     
          $this->validate($request, [
              'email' => 'required', 
              'password' => 'required',
              'captcha' => 'required|captcha' 
          ]);
          $admins=Admin::where('email',$request->email)->first();
          if (!empty($admins)) { 
            if ($admins->status==2) {
            return redirect()->route('student.resitration.verification',Crypt::encrypt($admins->id)); 
            }
          }
          $credentials = [
                     'email' => $request['email'],
                     'password' => $request['password'],
                     'status' => 1,
                 ]; 
            if(auth()->guard('admin')->attempt($credentials)) {
                if (Auth::guard('admin')->user()->user_type==1) {
                    return redirect()->route('admin.dashboard');
                }else{
                    return redirect()->route('admin.dashboard');
                }
                   
            } 

            // $student = Student::orWhere('username',$request->email)->first();
            //  if (!empty($student)) {
            //      if (Hash::check($request->password, $student->password)) {
            //          auth()->guard('student')->loginUsingId($student->id);
            //          return redirect()->route('student.dashboard');

            //      } else {
            //          return Redirect()->back()->with(['message'=>'Invalid User or Password','class'=>'error']);
            //      }
            //  }
            
            // if (auth()->guard('student')->attempt($credentials)) {
            //   return redirect()->route('student.dashboard');
            // }
            return Redirect()->back()->with(['message'=>'Invalid User or Password','class'=>'error']); 
        
       
    }
     public function refreshCaptcha()
    {  
        return  captcha_img('math');
    }
    // protected function credentials(Request $request)
    // {
    //     // return $request->only($this->username(), 'password');
    //     return ['email'=>$request->{$this->username()},'password'=>$request->password,'status'=>'1'];
    // }
  

    // Logout method with guard logout for admin only
 public function logout()
    {
        $this->guard()->logout();
        return redirect()->route('admin.login');
    }
    
    // defining auth  guard
    protected function guard()
    {
        return Auth::guard('admin');
    }
    public function forgetPassword()
    {
        return view('admin.auth.forget_password');
    }
    public function forgetPasswordSendLink(Request $request)
    {
        $AppUsers=new Admin();
        $u_detail=$AppUsers->getdetailbyemail($request->email);
        $up_u=array();
        $up_u['token'] = str_random(64);        
        $AppUsers->updateuserdetail($up_u,$u_detail->user_id);      
        $up_u['name']=$u_detail->name;
        $up_u['email']=$u_detail->email;
        $user=$u_detail->email;
        // $up_u['otp']=$up_u['otp'];
        $up_u['logo']=url("img/logo.png");
        $up_u['link']=url("passwordreset/reset/".$up_u['token']);


        Mail::send('emails.forgotPassword', $up_u, function($message){
                   $message->to('ashok@gmail.com')->subject('Password Reset');
               });
                       
        // $mailHelper = new MailHelper();
        // $mailHelper->forgetmail($request->email); 
        $response=array();
        $response['status']=1;
        $response['msg']='Reset Link Sent successfully';
        return $response;

    }
    
}
