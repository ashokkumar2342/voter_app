<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\AdminOtp;
use App\Events\SmsEvent;
use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Model\BlocksMc;
use App\Model\ClassType;
use App\Model\DefaultRoleMenu;
use App\Model\DefaultRoleQuickMenu;
use App\Model\District;
use App\Model\HotMenu;
use App\Model\Minu;
use App\Model\MinuType;
use App\Model\Role;
use App\Model\Section;
use App\Model\State;
use App\Model\SubMenu;
use App\Model\UserBlockAssign;
use App\Model\UserClass;
use App\Model\UserClassType;
use App\Model\UserDistrictAssign;
use App\Model\UserVillageAssign;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Mail;
use PDF;
use Symfony\Component\HttpKernel\DataCollector\collect;
class AccountController extends Controller
{
    Public function index(){
    $admin=Auth::guard('admin')->user();	
    $accounts = DB::select(DB::raw("select `a`.`id`, `a`.`first_name`, `a`.`last_name`, `a`.`email`, `a`.`mobile`, `a`.`status`, `r`.`name`
             from `admins` `a`Inner Join `roles` `r` on `a`.`role_id` = `r`.`id`where`a`.`status` = 1 and `a`.`role_id` >= (Select `role_id` from `admins` where `id` = $admin->id)Order By `a`.`first_name`;")); 
    	return view('admin.account.list',compact('accounts'));
    }

    Public function form(Request $request){
        $admin=Auth::guard('admin')->user();       
    	$roles =DB::select(DB::raw("select `id`, `name` from `roles` where `id`  >= (Select `role_id` from `admins` where `id` =$admin->id) Order By `name`;"));
    	return view('admin.account.form',compact('roles'));
    }
    public function listUserGenerate(Request $request)
     {
       $accounts = Admin::whereIn('id',$request->user_id)->get(); 
        $pdf=PDF::setOptions([
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])
        ->loadView('admin.account.user_list_pdf_generate',compact('accounts'));
        return $pdf->stream('user_list.pdf');
     } 

    Public function store(Request $request){ 
        $rules=[
        'first_name' => 'required|string|min:3|max:50',             
        'email' => 'required|email|unique:admins',
        "mobile" => 'required|unique:admins|numeric|digits:10',
        "role_id" => 'required',
        "password" => 'required|min:6|max:15', 
        
        ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $response=array();
            $response["status"]=0;
            $response["msg"]=$errors[0];
            return response()->json($response);// response as json
        }
         
    	$accounts = new Admin();
    	$accounts->first_name = $request->first_name;
    	$accounts->last_name = $request->last_name;
    	$accounts->role_id = $request->role_id;
    	$accounts->email = $request->email;
    	$accounts->password = bcrypt($request['password']);
    	$accounts->mobile = $request->mobile; 
    	$accounts->password_plain=$request->password;          
        $accounts->status=1;          
        $accounts->save();
        $userNewId=$accounts->id;
        DB::select(DB::raw("call up_AssignPermission_NewUser ('$userNewId')"));      
        $response=['status'=>1,'msg'=>'Account Created Successfully'];
            return response()->json($response);   
    }

    

    Public function edit(Request $request, Admin $account){
        $admin=Auth::guard('admin')->user();       
        $roles =DB::select(DB::raw("select `id`, `name` from `roles` where `id`  >= (Select `role_id` from `admins` where `id` =$admin->id) Order By `name`;"));
        
        
      
        return view('admin.account.edit',compact('account','roles')); 
    }

    Public function update(Request $request, Admin $account){

       $this->validate($request,[
           'first_name' => 'required|string|min:3|max:50',
               
               
               "mobile" => 'required|numeric|digits:10',
               "role_id" => 'required',
               "password" => 'nullable|min:6|max:15',             
                     
           ]);          
        
        
        $account->first_name = $request->first_name;
        $account->last_name = $request->last_name;
        $account->role_id = $request->role_id; 
        if ($request['password']!=null) {
            $account->password = bcrypt($request['password']);
        } 
        $account->mobile = $request->mobile;
        
        if ($account->save())
         {
          return redirect()->route('admin.account.list')->with(['message'=>'Account Updated Successfully.','class'=>'success']);        
        }
        else{
            return redirect()->back()->with(['class'=>'error','message'=>'Whoops ! Look like somthing went wrong ..']);
            }
    }

    Public function destroy($account){
         
      $admins=Admin::find(Crypt::decrypt($account));     
      $admins->delete();     
      return redirect()->back()->with(['message'=>'accoount deleted','class'=>'success']);
      
    }

    Public function status(Admin $account){

        $data = ($account->status == 1)?['status' => 0]:['status' => 1 ]; 
        $account->status = $data['status'];
        if( $account->save()){
            return redirect()->back()->with(['class'=>'success','message'=>'status change  successfully ...']);   
        }
        else{
            return response()->json(['status'=>'error','message'=>'Whoops, looks like something went wrong ! Try again ...']);
        }
    }
     Public function rstatus(Admin $account){
        
        $data = ($account->r_status == 1)?['r_status' => 0]:['r_status' => 1 ]; 
        $account->r_status = $data['r_status'];
        if( $account->save()){
            return redirect()->back()->with(['class'=>'success','message'=>'status change  successfully ...']);   
        }
        else{
            return response()->json(['status'=>'error','message'=>'Whoops, looks like something went wrong ! Try again ...']);
        }
    }

    Public function wstatus(Admin $account){
        
        $data = ($account->w_status == 1)?['r_status' => 0]:['r_status' => 1 ]; 
        $account->w_status = $data['r_status'];
        if( $account->save()){
            return redirect()->back()->with(['class'=>'success','message'=>'status change  successfully ...']);   
        }
        else{
            return response()->json(['status'=>'error','message'=>'Whoops, looks like something went wrong ! Try again ...']);
        }
    }

    Public function dstatus(Admin $account){
        
        $data = ($account->d_status == 1)?['r_status' => 0]:['r_status' => 1 ]; 
        $account->d_status = $data['r_status'];
        if( $account->save()){
            return redirect()->back()->with(['class'=>'success','message'=>'status change  successfully ...']);   
        }
        else{
            return response()->json(['status'=>'error','message'=>'Whoops, looks like something went wrong ! Try again ...']);
        }
    }

    Public function minu(Request $request, Admin $account){
        $roles = Role::all();
        $minus = Minu::where('admin_id',$account->id)->get();  
        return view('admin.account.minu',compact('account','roles','minus')); 
    }

    Public function access(Request $request, Admin $account){
     $admin=Auth::guard('admin')->user(); 
     $menus = MinuType::all();
     $users = DB::select(DB::raw("select `id`, `first_name`, `last_name`, `email`, `mobile` from `admins`where `status` = 1 and `role_id` >= (Select `role_id` from `admins` where `id` =$admin->id)Order By `first_name`")); 
        return view('admin.account.access',compact('menus','users')); 
    } 

    Public function accessHotMenu(Request $request, Admin $account){
    $admin=Auth::guard('admin')->user();    
    $menus = MinuType::all();
    $users = DB::select(DB::raw("select `id`, `first_name`, `last_name`, `email`, `mobile` from `admins`where `status` = 1 and `role_id` >= (Select `role_id` from `admins` where `id` =$admin->id)Order By `first_name`")); 
       
        return view('admin.account.accessHotMenu',compact('menus','users')); 
    } 
    Public function accessHotMenuShow(Request $request){  
      $id = $request->id;    
      $usersmenusType= Minu::where('admin_id',$id)->where('status',1)->get(['sub_menu_id']);
      $menusType = Minu::where('admin_id',$id)->where('status',1)->get(['minu_id']);
      $menus = MinuType::whereIn('id',$menusType)->get();  
      $subMenus = SubMenu::whereIn('id',$usersmenusType)->where('status',1)->get();
      $usersmenus = array_pluck(HotMenu::where('admin_id',$id)->where('status',1)->get(['sub_menu_id'])->toArray(), 'sub_menu_id'); 
      $data= view('admin.account.hotmenuTable',compact('menus','subMenus','id','usersmenus'))->render(); 
      return response($data);
    }  

    Public function menuTable(Request $request){

                $id = $request->id;
            $menus = MinuType::all();
            $subMenus = SubMenu::all();
           $usersmenus = array_pluck(Minu::where('admin_id',$id)->where('status',1)->get(['sub_menu_id'])->toArray(), 'sub_menu_id'); 
        $data= view('admin.account.menuTable',compact('menus','subMenus','usersmenus','id'))->render(); 
        return response($data);
    }
    public function defaultUserMenuAssignReport($id)
    {
     $id=Crypt::decrypt($id); 
     $previousRoute= app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
     if ($previousRoute=='admin.account.access') {
         $usersmenus = array_pluck(Minu::where('admin_id',$id)->where('status',1)->get(['sub_menu_id'])->toArray(), 'sub_menu_id'); 
         $menus = MinuType::all();
         $subMenus = SubMenu::all(); 
     }elseif ($previousRoute=='admin.account.access.hotmenu'){ 
      $usersmenusType= Minu::where('admin_id',$id)->where('status',1)->get(['sub_menu_id']);
      $menusType = Minu::where('admin_id',$id)->where('status',1)->get(['minu_id']);
      $menus = MinuType::whereIn('id',$menusType)->get();  
      $subMenus = SubMenu::whereIn('id',$usersmenusType)->where('status',1)->get();
      $usersmenus = array_pluck(HotMenu::where('admin_id',$id)->where('status',1)->get(['sub_menu_id'])->toArray(), 'sub_menu_id');
     }
      
     $pdf = PDF::setOptions([
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])
        ->loadView('admin.account.report.user_menu_assign_repot',compact('menus','subMenus','usersmenus','id'));
        return $pdf->stream('menu_report.pdf');
    }


    Public function DistrictsAssign(){
        $admin=Auth::guard('admin')->user(); 
        $users=DB::select(DB::raw("select `id`, `first_name`, `last_name`, `email`, `mobile` from `admins`where `status` = 1 and `role_id` = 2 and `role_id` >= (Select `role_id` from `admins` where `id` =$admin->id)Order By `first_name`")); 
        return view('admin.account.assign.district.index',compact('users','classes','userClass'));
       
    }

    Public function StateDistrictsSelect(Request $request){  
     $States = State::all();   
     $DistrictBlockAssigns = UserDistrictAssign::where('user_id',$request->id)->where('status',1)->get();
     $data= view('admin.account.assign.district.select_box',compact('DistrictBlockAssigns','States'))->render(); 
    return response($data);

    }

     

     Public function DistrictsAssignStore(Request $request){    
        $rules=[
         'district' => 'required', 
         'user' => 'required',  
        ]; 
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $response=array();
            $response["status"]=0;
            $response["msg"]=$errors[0];
            return response()->json($response);// response as json
        }
          
       $UserDistrictAssign =UserDistrictAssign::firstOrNew(['user_id'=>$request->user,'district_id'=>$request->district]); 
       $UserDistrictAssign->district_id = $request->district;  
       $UserDistrictAssign->user_id = $request->user;   
       $UserDistrictAssign->status = 1; 
       $UserDistrictAssign->save(); 
        $response['msg'] = 'Save Successfully';
        $response['status'] = 1;
        return response()->json($response);  
    }

     public function DistrictsAssignDelete($id)
     {
         $UserDistrictAssign =UserDistrictAssign::find(Crypt::decrypt($id));
         $UserDistrictAssign->delete();
         $response['msg'] = 'Delete Successfully';
         $response['status'] = 1;
         return response()->json($response);   
     }
    //-----------block-assign----------------------------------//

    Public function BlockAssign(){
        $admin=Auth::guard('admin')->user(); 
        $users=DB::select(DB::raw("select `id`, `first_name`, `last_name`, `email`, `mobile` from `admins`where `status` = 1 and `role_id` = 3 and `role_id` >= (Select `role_id` from `admins` where `id` =$admin->id)Order By `first_name`")); 
        return view('admin.account.assign.block.index',compact('users','classes','userClass'));
       
    }
    Public function DistrictBlockAssign(Request $request){ 
     $States = State::all();   
     $DistrictBlockAssigns = UserBlockAssign::where('user_id',$request->id)->where('status',1)->get();
     $data= view('admin.account.assign.block.select_box',compact('DistrictBlockAssigns','States'))->render(); 
    return response($data);

    }
    Public function DistrictBlockAssignStore(Request $request){     
        $rules=[
         'district' => 'required', 
         'block' => 'required', 
         'user' => 'required',  
        ]; 
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $response=array();
            $response["status"]=0;
            $response["msg"]=$errors[0];
            return response()->json($response);// response as json
        }
          
       $UserBlockAssign =UserBlockAssign::firstOrNew(['user_id'=>$request->user,'district_id'=>$request->district,'block_id'=>$request->block]); 
       $UserBlockAssign->district_id = $request->district;  
       $UserBlockAssign->user_id = $request->user;   
       $UserBlockAssign->block_id = $request->block;   
       $UserBlockAssign->status = 1; 
       $UserBlockAssign->save(); 
        $response['msg'] = 'Save Successfully';
        $response['status'] = 1;
        return response()->json($response);  
    }

    public function DistrictBlockAssignDelete($id)
     {
         $UserBlockAssign =UserBlockAssign::find(Crypt::decrypt($id));
         $UserBlockAssign->delete();
         $response['msg'] = 'Delete Successfully';
         $response['status'] = 1;
         return response()->json($response);   
     }


///------village-Assign-----------------------------------
   Public function VillageAssign(){
        $admin=Auth::guard('admin')->user(); 
        $users=DB::select(DB::raw("select `id`, `first_name`, `last_name`, `email`, `mobile` from `admins`where `status` = 1 and `role_id` = 4 and `role_id` >= (Select `role_id` from `admins` where `id` =$admin->id)Order By `first_name`")); 
        return view('admin.account.assign.village.index',compact('users'));
       
    }
    Public function DistrictBlockVillageAssign(Request $request){ 
     $States = State::all();   
     $DistrictBlockAssigns = UserVillageAssign::where('user_id',$request->id)->where('status',1)->get();
     $data= view('admin.account.assign.village.select_box',compact('DistrictBlockAssigns','States'))->render(); 
    return response($data);

    }
    Public function DistrictBlockVillageAssignStore(Request $request){   
        $rules=[
         'district' => 'required', 
         'block' => 'required', 
         'village' => 'required', 
         'user' => 'required',  
        ]; 
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $response=array();
            $response["status"]=0;
            $response["msg"]=$errors[0];
            return response()->json($response);// response as json
        }
          
       $UserVillageAssign =UserVillageAssign::firstOrNew(['user_id'=>$request->user,'district_id'=>$request->district,'block_id'=>$request->block,'village_id'=>$request->village]); 
       $UserVillageAssign->district_id = $request->district;  
       $UserVillageAssign->user_id = $request->user;   
       $UserVillageAssign->village_id = $request->village;   
       $UserVillageAssign->block_id = $request->block;   
       $UserVillageAssign->status = 1; 
       $UserVillageAssign->save(); 
        $response['msg'] = 'Save Successfully';
        $response['status'] = 1;
        return response()->json($response);  
    }

    public function DistrictBlockVillageAssignDelete($id)
     {
         $UserVillageAssign =UserVillageAssign::find(Crypt::decrypt($id));
         $UserVillageAssign->delete();
         $response['msg'] = 'Delete Successfully';
         $response['status'] = 1;
         return response()->json($response);   
     }
    

    public function ClassUserAssignReportGenerate($user_id)
    {
       $usersName = Admin::find($user_id);
       $userClassTypes = UserClassType::where('admin_id',$user_id)->where('status',1)->orderBy('class_id','ASC')->orderBy('section_id','ASC')->get();
        $pdf=PDF::setOptions([
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])
        ->loadView('admin.account.report.class_assign_pdf',compact('userClassTypes','usersName'));
        return $pdf->stream('academicYear.pdf');
    }

    // User access Store
    Public function accessStore(Request $request){
 
            $rules=[
            'sub_menu' => 'required|max:1000',             
            'user' => 'required|max:1000',  
            ]; 
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }     
        $menuId= implode(',',$request->sub_menu); 
        DB::select(DB::raw("call up_setuserpermission ($request->user, '$menuId')")); 
        $response['msg'] = 'Access Save Successfully';
        $response['status'] = 1;
        return response()->json($response);  

        
        
    }
    // User access hot menu Store
    Public function accessHotMenuStore(Request $request){

            $rules=[
            'sub_menu' => 'required|max:1000',             
            'user' => 'required|max:199',  
            ]; 
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            } 
            $menuId= implode(',',$request->sub_menu); 
            DB::select(DB::raw("call up_setuserquickpermission ($request->user, '$menuId')")); 
            
          $response['msg'] = 'Access Save Successfully';
           $response['status'] = 1;
           return response()->json($response);  

        
        
    }

    public function role(){
        $admin=Auth::guard('admin')->user();       
        $roles =DB::select(DB::raw("select `id`, `name` from `roles` where `id`  >= (Select `role_id` from `admins` where `id` =$admin->id) Order By `name`;"));
        return view('admin.account.roleList',compact('roles'));
    }

    Public function roleMenuTable(Request $request){

                $id = $request->id;
            $menus = MinuType::all();
            $subMenus = SubMenu::all();
            $datas  = DefaultRoleMenu::where('role_id',$id)->where('status',1)->pluck('sub_menu_id')->toArray(); 
        $data= view('admin.account.roleMenuTable',compact('menus','subMenus','datas','id'))->render(); 
        return response($data);
    }

    public function roleMenuStore(Request $request){
           $rules=[
           'sub_menu' => 'required|max:1000',             
           'role' => 'required|max:199',  
           ]; 
           $validator = Validator::make($request->all(),$rules);
           if ($validator->fails()) {
               $errors = $validator->errors()->all();
               $response=array();
               $response["status"]=0;
               $response["msg"]=$errors[0];
               return response()->json($response);// response as json
           } 

           $sub_menu= implode(',',$request->sub_menu); 
           DB::select(DB::raw("call up_set_default_role_permission ($request->role, '$sub_menu')")); 

          //  $data = $request->except('_token');        
          //  $user_count = count($data['sub_menu']);
          // $menuOldDatas =  DefaultRoleMenu::where('role_id',$data['role'])->get();  
          //  if ($menuOldDatas->count()!=0) { 
          //    foreach ($menuOldDatas as $key => $menuOldData) { 
          //      $menu =  DefaultRoleMenu::find($menuOldData->id); 
          //      $menu->status = 0;
          //      $menu->save();
          //    } 
          //  } 
          //  for ($i=0; $i < $user_count; $i++) {  
          //      $menu =  DefaultRoleMenu::firstOrNew(['role_id'=>$request->role,'sub_menu_id'=>$data['sub_menu'][$i]]);
               
          //      $menu->sub_menu_id = $data['sub_menu'] [$i];
                 
          //      $menu->role_id = $data['role'];
          //      $menu->status = 1;

          //      $menu->save();             
          //  }  
          
        $response['msg'] = 'Save Successfully';
        $response['status'] = 1;
        return response()->json($response);  
      }
         
    


 
    public function resetPassWord($value='')
    {
       $admins=Admin::orderBy('email','ASC')->get();
       return view('admin.account.reset_password',compact('admins'));
    }
    public function resetPassWordChange(Request $request)
    {
      
      
       if ($request->new_pass!=$request->con_pass) {
          $response=['status'=>0,'msg'=>'Password Not Match'];
            return response()->json($response);
        }
         $resetPassWordChange=bcrypt($request['new_pass']);
         $accounts=Admin::find($request->email); 
         $accounts->password=$resetPassWordChange;
        $accounts->save(); 
        $response=['status'=>1,'msg'=>'Password Change Successfully'];
        return response()->json($response); 
    }
    public function menuOrdering()
    {
      $menuTypes=MinuType::orderBy('sorting_id','ASC')->get();
      return view('admin.account.menu_sorting_order',compact('menuTypes'));
    }

    public function menuOrderingStore(Request $request)
        {  
           
          $MinuTypes = MinuType::orderBy('sorting_id', 'ASC')->get();
                $id = Input::get('id');
                $sorting = Input::get('sorting');
                foreach ($MinuTypes as $item) {
                    return MinuType::where('id', '=', $id)->update(array('sorting_id' => $sorting));
                } 
        }
   public function subMenuOrderingStore(Request $request)
   {  

       $MinuTypes = SubMenu::orderBy('sorting_id', 'ASC')->get();
       $id = Input::get('id');
       $sorting = Input::get('sorting');
       foreach ($MinuTypes as $item) {
            SubMenu::where('id', '=', $id)->update(array('sorting_id' => $sorting));
       } 
      
       $response=array();
       $response['msg'] = 'Save Successfully';
       $response['status'] = 1;
       return response()->json($response); 
   }     
  public function menuFilter(Request $request,$id)
  {
     
    $submenus=SubMenu::where('menu_type_id',$id)->orderBy('sorting_id', 'ASC')->get();
     return view('admin.account.sub_menu_ordering',compact('submenus'));

  } 
  public function menuReport(Request $request)
  {
     $optradio=$request->optradio;
     $menus = MinuType::all();
     $subMenus=SubMenu::all();
     $pdf=PDF::setOptions([
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])
        ->loadView('admin.account.report.menu_order_report',compact('menus','subMenus','optradio'));
        return $pdf->stream('menu_report.pdf');
    

  } 
  public function defaultUserRolrReportGenerate(Request $request,$id)
  {
     $id=Crypt::decrypt($id);  
     $previousRoute= app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
     if ($previousRoute=='admin.account.role') {
         $datas  = DefaultRoleMenu::where('role_id',$id)->where('status',1)->pluck('sub_menu_id')->toArray();
         if ($request->optradio=='selected') {
         $subMenus = SubMenu::whereIn('id',$datas)->get();
         $menuTypeArrId = SubMenu::whereIn('id',$datas)->pluck('menu_type_id')->toArray();
         $menus = MinuType::whereIn('id',$menuTypeArrId)->get();  
         }elseif($request->optradio=='all'){
          $menus = MinuType::all();
          $subMenus = SubMenu::all();      
         }
     }elseif($previousRoute=='admin.roleAccess.quick.view'){
             $datas  = DefaultRoleQuickMenu::where('role_id',$id)->where('status',1)->pluck('sub_menu_id')->toArray();
             if ($request->optradio=='selected') {
             $subMenus = SubMenu::whereIn('id',$datas)->get();
             $menuTypeArrId = SubMenu::whereIn('id',$datas)->pluck('menu_type_id')->toArray();
             $menus = MinuType::whereIn('id',$menuTypeArrId)->get();  
             }elseif($request->optradio=='all'){
              $subMenuArrId  = DefaultRoleMenu::where('role_id',$id)->where('status',1)->pluck('sub_menu_id')->toArray();
              $menuTypeArrId = Minu::whereIn('sub_menu_id',$subMenuArrId)->pluck('minu_id')->toArray();
              $subMenus = SubMenu::whereIn('id',$subMenuArrId)->get();
              $menus = MinuType::whereIn('id',$menuTypeArrId)->get();

             // $menus = MinuType::all();
             // $subMenus = SubMenu::all();      
             }
     }
     $roles = Role::find($id);
     $pdf = PDF::setOptions([
            'logOutputFile' => storage_path('logs/log.htm'),
            'tempDir' => storage_path('logs/')
        ])
        ->loadView('admin.account.report.result',compact('menus','subMenus','roles','datas','id'));
        return $pdf->stream('menu_report.pdf');
    
  }
  public function quickView()
  {
    $admin=Auth::guard('admin')->user();       
    $roles =DB::select(DB::raw("select `id`, `name` from `roles` where `id`  >= (Select `role_id` from `admins` where `id` =$admin->id) Order By `name`;"));
     return view('admin.account.quick_view',compact('roles'));
  } 

  Public function defultRoleMenuShow(Request $request){

    $role_id = $request->id;
    $id = $request->id;  
   $subMenuArrId  = DefaultRoleMenu::where('role_id',$role_id)->where('status',1)->pluck('sub_menu_id')->toArray();
    $menuTypeArrId = Minu::whereIn('sub_menu_id',$subMenuArrId)->pluck('minu_id')->toArray();
    $subMenus = SubMenu::whereIn('id',$subMenuArrId)->get();

    $menus = MinuType::whereIn('id',$menuTypeArrId)->get();
       $datas  = DefaultRoleQuickMenu::where('role_id',$role_id)->where('status',1)->pluck('sub_menu_id')->toArray(); 
     $data= view('admin.account.roleMenuTable',compact('menus','subMenus','datas','id'))->render(); 
     return response($data);
  }
  public function defaultRoleQuickStore(Request $request){  
         $rules=[
         'sub_menu' => 'required|max:1000',             
         'role' => 'required|max:199',  
         ]; 
         $validator = Validator::make($request->all(),$rules);
         if ($validator->fails()) {
             $errors = $validator->errors()->all();
             $response=array();
             $response["status"]=0;
             $response["msg"]=$errors[0];
             return response()->json($response);// response as json
         }  

         $sub_menu= implode(',',$request->sub_menu); 
         DB::select(DB::raw("call up_set_default_role_quick_permission ($request->role, '$sub_menu')")); 
          
      $response['msg'] = 'Save Successfully';
      $response['status'] = 1;
      return response()->json($response);  
    }
    //registration parent-----------
    public function firststep()
    {
        return view('front.registration.firststep');
    }
    public function studentStore(Request $request)
    {  
       
        $this->validate($request,[
            'first_name' => 'required',             
            'email' => 'required|email|max:50|unique:admins',             
            'mobile' => 'required|numeric|digits:10|unique:admins',             
            'password' => 'required|min:6',
            'password_confirm' => 'required_with:password|same:password|min:6',
            'captcha' => 'required|captcha'             
            ]);
 
        $accounts = new Admin(); 
        $accounts->first_name = $request->first_name;
        $accounts->email = $request->email; 
        $accounts->password = bcrypt($request['password']);
        $accounts->mobile = $request->mobile; 
        $accounts->role_id =12;
        $accounts->password_plain =$request->password;  
        $accounts->status =2; 
     
        if ($accounts->save())
         {   
          return redirect()->route('student.resitration.verification',Crypt::encrypt($accounts->id))->with(['message'=>'Account created Successfully.','class'=>'success']);        
        }
        else{
            return redirect()->back()->with(['class'=>'error','message'=>'Whoops ! Look like somthing went wrong ..']);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ParentRegistration  $parentRegistration
     * @return \Illuminate\Http\Response
     */
    public function verification($id)
    {
       $parentRegistration= Admin::find(Crypt::decrypt($id));
       $adminOtpMobile= AdminOtp::where('admin_id',$parentRegistration->id)->where('otp_type',1)->first();
       $adminOtpemail= AdminOtp::where('admin_id',$parentRegistration->id)->where('otp_type',2)->first();
         return view('front.registration.verification',compact('parentRegistration','adminOtpMobile','adminOtpemail'));
    }

    public function verifyMobile(Request $request)
    {  
        $this->validate($request,[
                      
            'mobile_otp' => 'required|numeric',  
            ]);
         
        $parentRegistration= Admin::where('mobile',$request->mobile)->first();
        $adminOtpMobile= AdminOtp::where('admin_id',$parentRegistration->id)->where('otp_type',1)->first(); 
        $adminOtpEmail= AdminOtp::where('admin_id',$parentRegistration->id)->where('otp_type',2)->first(); 
        if ($adminOtpMobile->otp!=$request->mobile_otp) {
            return redirect()->back()->with(['class'=>'error','message'=>'Mobile Otp Not Match']);      
        }else{
             $adminOtpMobile->otp_verified=1;                                        
             $adminOtpMobile->save();
             }
            if ($adminOtpEmail->otp_verified==1 && $adminOtpMobile->otp_verified==1) { 
               return redirect()->route('admin.login')->with(['class'=>'success','message'=>'Mobile Otp Verify']);  
            }else{
             return redirect()->back()->with(['class'=>'success','message'=>'Mobile Otp Verify']);
            } 
        // return redirect()->back()->with(['class'=>'success','message'=>'Email Otp Verify']);
        

    }
    public function verifyEmail(Request $request)
    {

       $this->validate($request,[
                     
           'email_otp' => 'required|numeric',  
           ]);
        
       $parentRegistration= Admin::where('email',$request->email)->first(); 
        $adminOtpEmail= AdminOtp::where('admin_id',$parentRegistration->id)->where('otp_type',2)->first();
        $adminOtpMobile= AdminOtp::where('admin_id',$parentRegistration->id)->where('otp_type',1)->first();

        if ($adminOtpEmail->otp!=$request->email_otp) {
            return redirect()->back()->with(['class'=>'error','message'=>'Email Otp Not Match']);      
        }else{
             $adminOtpEmail->otp_verified=1;                                        
             $adminOtpEmail->save();
           }
           if ($adminOtpEmail->otp_verified==1 && $adminOtpMobile->otp_verified==1) { 
               return redirect()->route('admin.login')->with(['class'=>'success','message'=>'Email Otp Verify']);  
            }else{
             return redirect()->back()->with(['class'=>'success','message'=>'Email Otp Verify']);
            } 
    }
    public function resendOTP(Request $request,$user_id,$otp_type)
    {
       DB::select(DB::raw("call up_generate_otp_newuser ($user_id, '$otp_type')"));
       \Artisan::call('send:sms');
       return redirect()->back()->with(['message'=>'Resend OTP Successfully.','class'=>'success']); 
    }

}
