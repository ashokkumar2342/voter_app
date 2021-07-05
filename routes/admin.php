<?php

use App\Http\Controllers\Admin\reportGenerateBarcode;

Route::get('/', 'Auth\LoginController@index')->name('admin.home');
Route::get('search-voter', 'Auth\LoginController@searchVoter')->name('admin.search.voter'); 
Route::get('search-voter-form/{id}', 'Auth\LoginController@searchVoterform')->name('admin.search.voter.form'); 
Route::get('search-dis-block', 'Auth\LoginController@searchDisBlock')->name('admin.search.dis.block'); 
Route::get('search-block-village', 'Auth\LoginController@searchBlockVillage')->name('admin.search.block.village'); 
Route::post('search-voter-filter/{id}', 'Auth\LoginController@searchVoterFilter')->name('admin.search.voter.folter'); 
Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login'); 
Route::get('admin-password/reset', 'Auth\ForgetPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('passwordreset/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout.get');
Route::post('login', 'Auth\LoginController@login');
Route::get('forget-password', 'Auth\LoginController@forgetPassword')->name('admin.forget.password');
Route::post('forget-password-send-link', 'Auth\LoginController@forgetPasswordSendLink')->name('admin.forget.password.send.link');
Route::post('reset-password', 'Auth\LoginController@resetPassword')->name('admin.reset.password');
Route::get('refreshcaptcha', 'Auth\LoginController@refreshCaptcha')->name('admin.refresh.captcha');
Route::group(['middleware' => 'admin'], function() {
	Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard'); 
	Route::get('show-details', 'DashboardController@showStudentDetails')->name('admin.student.show.details');
	Route::get('registration-show-details', 'DashboardController@showStudentRegistrationDetails')->name('admin.student.Registration.details');
	Route::get('token', 'DashboardController@passportTokenCreate')->name('admin.token');
	Route::get('profile', 'DashboardController@proFile')->name('admin.profile');
	Route::get('profile-show', 'DashboardController@proFileShow')->name('admin.profile.show');
	Route::get('profile-show/{profile_pic}', 'DashboardController@proFilePhotoShow')->name('admin.profile.photo.show'); 
	Route::post('profile-update', 'DashboardController@profileUpdate')->name('admin.profile.update');
	Route::post('password-change', 'DashboardController@passwordChange')->name('admin.password.change');
	Route::get('profile-photo', 'DashboardController@profilePhoto')->name('admin.profile.photo');
	Route::post('upload-photo', 'DashboardController@profilePhotoUpload')->name('admin.profile.photo.upload');
	Route::get('photo-refrash', 'DashboardController@profilePhotoRefrash')->name('admin.profile.photo.refrash');
	//---------------account-----------------------------------------	
	Route::prefix('account')->group(function () {
	    Route::get('form', 'AccountController@form')->name('admin.account.form');
	    Route::post('store', 'AccountController@store')->name('admin.account.post');
		Route::get('list', 'AccountController@index')->name('admin.account.list');
		Route::post('list-user-generate', 'AccountController@listUserGenerate')->name('admin.account.list.user.generate');
		Route::get('access', 'AccountController@access')->name('admin.account.access');
		Route::get('hot-menu', 'AccountController@accessHotMenu')->name('admin.account.access.hotmenu');
		Route::get('menuTable', 'AccountController@menuTable')->name('admin.account.menuTable');
		Route::get('access/hotmenu', 'AccountController@accessHotMenuShow')->name('admin.account.access.hotmenuTable');
		Route::post('access-store', 'AccountController@accessStore')->name('admin.userAccess.add');
		Route::post('access-hot-menu-store', 'AccountController@accessHotMenuStore')->name('admin.userAccess.hotMenuAdd');
		Route::get('edit/{account}', 'AccountController@edit')->name('admin.account.edit');
		Route::post('update/{account}', 'AccountController@update')->name('admin.account.edit.post');
		Route::get('delete/{account}', 'AccountController@destroy')->name('admin.account.delete');
		Route::get('status/{account}', 'AccountController@status')->name('admin.account.status');	 
		Route::get('r--status/{account}', 'AccountController@rstatus')->name('admin.account.r_status');	 
		Route::get('w-status/{account}', 'AccountController@wstatus')->name('admin.account.w_status');	 
		Route::get('d-status/{account}', 'AccountController@dstatus')->name('admin.account.d_status');
		Route::get('minu/{account}', 'AccountController@minu')->name('admin.account.minu');				
		Route::get('role', 'AccountController@role')->name('admin.account.role');				
		Route::get('role-menu', 'AccountController@roleMenuTable')->name('admin.account.roleMenuTable'); 
		Route::post('role-menu-store', 'AccountController@roleMenuStore')->name('admin.roleAccess.subMenu');
		Route::get('role-quick-menu-view', 'AccountController@quickView')->name('admin.roleAccess.quick.view');
		Route::get('defult-role-menu-show', 'AccountController@defultRoleMenuShow')->name('admin.account.role.default.menu');
		Route::post('default-role-quick-menu-store', 'AccountController@defaultRoleQuickStore')->name('admin.roleAccess.quick.role.menu.store');
		Route::get('class-access', 'AccountController@classAccess')->name('admin.account.classAccess');

		Route::get('DistrictsAssign', 'AccountController@DistrictsAssign')->name('admin.account.DistrictsAssign'); 
		Route::get('StateDistrictsSelect', 'AccountController@StateDistrictsSelect')->name('admin.account.StateDistrictsSelect'); 
		 Route::post('DistrictsAssignStore', 'AccountController@DistrictsAssignStore')->name('admin.Master.DistrictsAssignStore');
		 Route::get('DistrictsAssignDelete/{id}', 'AccountController@DistrictsAssignDelete')->name('admin.Master.DistrictsAssignDelete');


		 Route::get('BlockAssign', 'AccountController@BlockAssign')->name('admin.account.BlockAssign'); 
		Route::get('DistrictBlockAssign', 'AccountController@DistrictBlockAssign')->name('admin.account.DistrictBlockAssign'); 
		 Route::post('DistrictBlockAssignStore', 'AccountController@DistrictBlockAssignStore')->name('admin.Master.DistrictBlockAssignStore');
		 Route::get('DistrictBlockAssignDelete/{id}', 'AccountController@DistrictBlockAssignDelete')->name('admin.Master.DistrictBlockAssignDelete');

		 Route::get('VillageAssign', 'AccountController@VillageAssign')->name('admin.account.VillageAssign'); 
		Route::get('DistrictBlockVillageAssign', 'AccountController@DistrictBlockVillageAssign')->name('admin.account.DistrictBlockVillageAssign'); 
		 Route::post('DistrictBlockVillageAssignStore', 'AccountController@DistrictBlockVillageAssignStore')->name('admin.Master.DistrictBlockVillageAssignStore');
		 Route::get('DistrictBlockVillageAssignDelete/{id}', 'AccountController@DistrictBlockVillageAssignDelete')->name('admin.Master.DistrictBlockVillageAssignDelete');




		Route::get('reset-password', 'AccountController@resetPassWord')->name('admin.account.reset.password'); 
		Route::post('reset-password-change', 'AccountController@resetPassWordChange')->name('admin.account.reset.password.change'); 
		Route::get('menu-ordering', 'AccountController@menuOrdering')->name('admin.account.menu.ordering'); 
		Route::get('menu-ordering-store', 'AccountController@menuOrderingStore')->name('admin.account.menu.ordering.store'); 
		Route::get('submenu-ordering-store', 'AccountController@subMenuOrderingStore')->name('admin.account.submenu.ordering.store'); 
		Route::get('menu-filter/{id}', 'AccountController@menuFilter')->name('admin.account.menu.filte'); 
		Route::post('menu-report', 'AccountController@menuReport')->name('admin.account.menu.report'); 
		Route::get('user-menu-assign-report/{id}', 'AccountController@defaultUserMenuAssignReport')->name('admin.account.user.menu.assign.report'); 
		Route::post('default-user-role-report-generate/{id}', 'AccountController@defaultUserRolrReportGenerate')->name('admin.account.default.user.role.report.generate'); 
		Route::get('class-user-assign-report-generate/{user_id}', 'AccountController@ClassUserAssignReportGenerate')->name('admin.account.class.user.assign.report.generate'); 
		
						
		// Route::get('status/{minu}', 'AccountController@minustatus')->name('admin.minu.status'); 
	});
	Route::prefix('user-report')->group(function () {
		    Route::get('/', 'UserReportController@index')->name('admin.user.report');
		    Route::get('report-type-filter', 'UserReportController@reportTypeFilter')->name('admin.user.report.type.filter');
		    Route::post('filter', 'UserReportController@filter')->name('admin.user.report.filter'); 
		});
	 
		//---------------minu-----------------------------------------	
	Route::prefix('minu')->group(function () {
	    
		Route::get('status/{minu}', 'MinuController@status')->name('admin.minu.status');	 
		Route::get('r--status/{minu}', 'MinuController@rstatus')->name('admin.minu.r_status');	 
		Route::get('w-status/{minu}', 'MinuController@wstatus')->name('admin.minu.w_status');	 
		Route::get('d-status/{minu}', 'MinuController@dstatus')->name('admin.minu.d_status');
		Route::get('minu/{minu}', 'MinuController@minu')->name('admin.minu.minu');
		Route::post('menu-permission-check', 'MinuController@menuPermissionCheck')->name('admin.account.menu.permission.check'); 	 
	});
	 
	 // 

    Route::group(['prefix' => 'Master'], function() {
    	//-states-//
	    // Route::get('/', 'MasterController@index')->name('admin.Master.index');	   
	    // Route::post('Store/{id?}', 'MasterController@store')->name('admin.Master.store');	   
	    // Route::get('Edit{id}', 'MasterController@edit')->name('admin.Master.edit');
	    // Route::get('Delete{id}', 'MasterController@delete')->name('admin.Master.delete');
        //-districts-//
	    Route::get('Districts', 'MasterController@districts')->name('admin.Master.districts');	   
	    Route::post('Districts-Store{id?}', 'MasterController@districtsStore')->name('admin.Master.districtsStore');  
	    Route::get('Districts-Edit/{id}', 'MasterController@districtsEdit')->name('admin.Master.districtsEdit');
	    Route::get('Districts-delete/{id}', 'MasterController@districtsDelete')->name('admin.Master.districtsDelete');
	     
	    
	    //-block-mcs-type//
	    Route::get('BlockMCSType', 'MasterController@BlockMCSType')->name('admin.Master.BlockMCSType');
	    Route::get('BlockMCSTypeEdit/{id}', 'MasterController@BlockMCSTypeEdit')->name('admin.Master.BlockMCSTypeEdit');  
	    Route::post('BlockMCSTypeUpdate/{id}', 'MasterController@BlockMCSTypeUpdate')->name('admin.Master.BlockMCSTypeUpdate');  
	    //-block-mcs-//
	    Route::get('BlockMCS', 'MasterController@BlockMCS')->name('admin.Master.blockmcs');  
	    Route::post('BlockMCSStore{id?}', 'MasterController@BlockMCSStore')->name('admin.Master.BlockMCSStore');	   
	    Route::get('BlockMCSEdit/{id}', 'MasterController@BlockMCSEdit')->name('admin.Master.BlockMCSEdit');
	    Route::get('BlockMCSTable', 'MasterController@BlockMCSTable')->name('admin.Master.BlockMCSTable');
	    Route::get('BlockMCSDelete/{id}', 'MasterController@BlockMCSDelete')->name('admin.Master.BlockMCSDelete');
	    
	    //-village--//
	    Route::get('village', 'MasterController@village')->name('admin.Master.village');	   
	    Route::post('village-store{id?}', 'MasterController@villageStore')->name('admin.Master.village.store');	   
	     
	    Route::get('villageTable', 'MasterController@villageTable')->name('admin.Master.villageTable');
	    Route::get('village-edit/{id}', 'MasterController@villageEdit')->name('admin.Master.village.edit');
	    Route::post('villageUpdate/{id}', 'MasterController@villageUpdate')->name('admin.Master.village.villageUpdate');
	    Route::get('village-delete/{id}', 'MasterController@villageDelete')->name('admin.Master.village.delete');
	     
	      
	    Route::get('tahsil', 'MasterController@tahsil')->name('admin.Master.tahsil');
	    Route::post('tahsil-store{id?}', 'MasterController@tahsilStore')->name('admin.Master.tahsil.store');
	    Route::get('tahsilTable', 'MasterController@tahsilTable')->name('admin.Master.tahsilTable'); 
	     	   
	    //-----------------onchange-----------------------------//
	    Route::get('stateWiseDistrict', 'MasterController@stateWiseDistrict')->name('admin.Master.stateWiseDistrict');   
	    

	    Route::get('DistrictWiseBlock/{print_condition?}', 'MasterController@DistrictWiseBlock')->name('admin.Master.DistrictWiseBlock');
	     

	    Route::get('BlockWiseVillage', 'MasterController@BlockWiseVillage')->name('admin.Master.BlockWiseVillage');




	    //-----------------gender-----------------------------//
	    Route::get('gender', 'MasterController@gender')->name('admin.Master.gender');   
	    Route::get('gender-edit/{id}', 'MasterController@genderEdit')->name('admin.Master.gender.edit');   
	    Route::post('gender-update/{id}', 'MasterController@genderUpdate')->name('admin.Master.gender.update'); 
	     
	});
     

      
    Route::group(['prefix' => 'Report'], function() {
           Route::get('PrintVoterList', 'ReportController@PrintVoterList')->name('admin.report.PrintVoterList');
           Route::post('PrintVoterListGenerate', 'ReportController@PrintVoterListGenerate')->name('admin.report.PrintVoterListGenerate');

           Route::get('Report', 'ReportController@Report')->name('admin.report.Report');
           Route::get('ReportGenerateExcel', 'ReportController@ReportGenerateExcel')->name('admin.report.ReportGenerate');
           Route::get('ReportGeneratePDF', 'ReportController@ReportGeneratePDF')->name('admin.report.ReportGeneratePDF');
//----card-----print-----------card----print-----------card-print-----           
           Route::get('voterCardPrint', 'ReportController@voterCardPrint')->name('admin.report.voterCardPrint');
           Route::get('voterCardPrintGenerate', 'ReportController@cameraTesting')->name('admin.camera.test');
	 	 
    });
          
     
 });