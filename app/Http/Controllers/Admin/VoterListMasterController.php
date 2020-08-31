<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\VoterListMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VoterListMasterController extends Controller
{
	public function index()
	{

		return view('admin.voterlistmaster.index');
	}
	public function store(Request $request)
	{  
		$rules=[

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
	$voterlistmaster=new VoterListMaster();
	$voterlistmaster->voter_list_name=$request->voter_list_name;
	$voterlistmaster->voter_list_type=$request->voter_list_type;
	$voterlistmaster->year_publication=$request->year_publication;
	$voterlistmaster->year_base=$request->year_base;
	$voterlistmaster->date_publication=$request->date_publication;
	$voterlistmaster->date_base=$request->date_base;
	$voterlistmaster->remarks1=$request->remarks1;
	$voterlistmaster->remarks2=$request->remarks2;
	$voterlistmaster->remarks3=$request->remarks3;
	if (empty($request->is_supplement)) {
	 $voterlistmaster->is_supplement=0;  
	 }
	 elseif (!empty($request->is_supplement)) {
	 $voterlistmaster->is_supplement=$request->is_supplement;  
	 } 
	$voterlistmaster->save();
	$response=['status'=>1,'msg'=>'Submit Successfully'];
	return response()->json($response);
}
}

}
