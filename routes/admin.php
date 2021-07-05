<?php

use App\Http\Controllers\Admin\reportGenerateBarcode;
//registration start
Route::prefix('resitration')->group(function () {
    Route::get('form', 'AccountController@firststep')->name('student.resitration.firststep');
     Route::post('form', 'AccountController@studentStore')->name('student.resitration.firststep.store');
     Route::get('verification/{id}', 'AccountController@verification')->name('student.resitration.verification');
     Route::post('mobile-verify', 'AccountController@verifyMobile')->name('student.resitration.verifyMobile');
     Route::post('email-verify', 'AccountController@verifyEmail')->name('student.resitration.verifyEmail');
     Route::get('resend-otp/{id?}/{otp_type}', 'AccountController@resendOTP')->name('student.resitration.resend.otp');
     Route::get('resitration-form', 'AccountController@resitrationForm')->name('student.resitration.resitrationForm'); 
 Route::get('resitration-form1', 'AccountController@resitrationForm')->name('student.resitration.resitrationForm'); 
});
//registration end 
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
	    Route::get('/', 'MasterController@index')->name('admin.Master.index');	   
	    Route::post('Store/{id?}', 'MasterController@store')->name('admin.Master.store');	   
	    Route::get('Edit{id}', 'MasterController@edit')->name('admin.Master.edit');
	    Route::get('Delete{id}', 'MasterController@delete')->name('admin.Master.delete');
        //-districts-//
	    Route::get('Districts', 'MasterController@districts')->name('admin.Master.districts');	   
	    Route::post('Districts-Store{id?}', 'MasterController@districtsStore')->name('admin.Master.districtsStore');	   
	    Route::get('DistrictsTable', 'MasterController@DistrictsTable')->name('admin.Master.DistrictsTable');
	    Route::get('Districts-Edit/{id}', 'MasterController@districtsEdit')->name('admin.Master.districtsEdit');
	    Route::get('Districts-delete/{id}', 'MasterController@districtsDelete')->name('admin.Master.districtsDelete');
	    Route::get('DistrictsZpWard/{id}', 'MasterController@DistrictsZpWard')->name('admin.Master.DistrictsZpWard');
	    Route::post('DistrictsZpWardStore', 'MasterController@DistrictsZpWardStore')->name('admin.Master.DistrictsZpWardStore');
	    //-z-p-ward//
        Route::get('ZilaParishad', 'MasterController@ZilaParishad')->name('admin.Master.ZilaParishad');
        Route::post('ZilaParishadStore', 'MasterController@ZilaParishadStore')->name('admin.Master.ZilaParishadStore');
        Route::get('ZilaParishadTable', 'MasterController@ZilaParishadTable')->name('admin.Master.ZilaParishadTable');
        Route::get('ZilaParishadEdit/{id}', 'MasterController@ZilaParishadEdit')->name('admin.Master.ZilaParishadEdit');
        Route::post('ZilaParishadUpdate/{id}', 'MasterController@ZilaParishadUpdate')->name('admin.Master.ZilaParishadUpdate');
        Route::get('ZilaParishadDelete/{id}', 'MasterController@ZilaParishadDelete')->name('admin.Master.ZilaParishadDelete');
        //-p-s-ward//
        Route::get('PanchayatSamiti', 'MasterController@PanchayatSamiti')->name('admin.Master.PanchayatSamiti');
        Route::post('PanchayatSamitiStore', 'MasterController@PanchayatSamitiStore')->name('admin.Master.PanchayatSamitiStore');
        Route::get('PanchayatSamitiTable', 'MasterController@PanchayatSamitiTable')->name('admin.Master.PanchayatSamitiTable');
        Route::get('PanchayatSamitiEdit/{id}', 'MasterController@PanchayatSamitiEdit')->name('admin.Master.PanchayatSamitiEdit');
        Route::post('PanchayatSamitiUpdate/{id}', 'MasterController@PanchayatSamitiUpdate')->name('admin.Master.PanchayatSamitiUpdate');
        Route::get('PanchayatSamitiDelete/{id}', 'MasterController@PanchayatSamitiDelete')->name('admin.Master.PanchayatSamitiDelete');
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
	    Route::get('BlockMCSpsWard/{id}', 'MasterController@BlockMCSpsWard')->name('admin.Master.BlockMCSpsWard');
	    Route::post('BlockMCSpsWardStore', 'MasterController@BlockMCSpsWardStore')->name('admin.Master.BlockMCSpsWardStore');
	    //-village--//
	    Route::get('village', 'MasterController@village')->name('admin.Master.village');	   
	    Route::post('village-store{id?}', 'MasterController@villageStore')->name('admin.Master.village.store');	   
	    Route::get('BtnClickByvillageForm', 'MasterController@BtnClickByvillageForm')->name('admin.Master.BtnClickByvillageForm');
	    Route::get('villageTable', 'MasterController@villageTable')->name('admin.Master.villageTable');
	    Route::get('village-edit/{id}', 'MasterController@villageEdit')->name('admin.Master.village.edit');
	    Route::post('villageUpdate/{id}', 'MasterController@villageUpdate')->name('admin.Master.village.villageUpdate');
	    Route::get('village-delete/{id}', 'MasterController@villageDelete')->name('admin.Master.village.delete');
	    Route::get('village-ward-add/{id}', 'MasterController@villageWardAdd')->name('admin.Master.village.ward.add');
	    Route::get('villageexportsampale', 'MasterController@villageSampleExport')->name('admin.Master.villageexportsampale'); 
	    //-village--//
	    Route::get('ward', 'MasterController@ward')->name('admin.Master.ward');	   
	    Route::post('ward-store{id?}', 'MasterController@wardStore')->name('admin.Master.ward.store');	 
	    Route::get('wardTable', 'MasterController@wardTable')->name('admin.Master.ward.table');	 
	    //-Assembly--//
	    Route::get('Assembly', 'MasterController@Assembly')->name('admin.Master.Assembly');	   
	    Route::post('Assembly-store{id?}', 'MasterController@AssemblyStore')->name('admin.Master.Assembly.store');	   
	    Route::get('AssemblyTable', 'MasterController@AssemblyTable')->name('admin.Master.AssemblyTable');
	    Route::get('Assembly-edit/{id}', 'MasterController@AssemblyEdit')->name('admin.Master.Assembly.edit');
	    Route::get('Assembly-delete/{id}', 'MasterController@AssemblyDelete')->name('admin.Master.Assembly.delete'); 
	    //-Assembly--//
	    Route::get('AssemblyPart', 'MasterController@AssemblyPart')->name('admin.Master.AssemblyPart');	   
	    Route::get('AssemblyPartbtnclickBypartNo', 'MasterController@AssemblyPartbtnclickBypartNo')->name('admin.Master.AssemblyPartbtnclickBypartNo');	   
	    Route::post('AssemblyPart-store{id?}', 'MasterController@AssemblyPartStore')->name('admin.Master.AssemblyPart.store');	   
	    Route::get('AssemblyPartTable', 'MasterController@AssemblyPartTable')->name('admin.Master.AssemblyPartTable');
	    Route::get('AssemblyPart-edit/{id}', 'MasterController@AssemblyPartEdit')->name('admin.Master.AssemblyPart.edit');
	    Route::get('AssemblyPart-delete/{id}', 'MasterController@AssemblyPartDelete')->name('admin.Master.AssemblyPart.delete');
	    //-Mapping---//
	    Route::get('MappingVillageAssemblyPart', 'MasterController@MappingVillageAssemblyPart')->name('admin.Master.MappingVillageAssemblyPart');	   
	    Route::get('MappingVillageAssemblyPartFilter', 'MasterController@MappingVillageAssemblyPartFilter')->name('admin.Master.MappingVillageAssemblyPartFilter');
	    Route::get('MappingAssemblyWisePartNo', 'MasterController@MappingAssemblyWisePartNo')->name('admin.Master.MappingAssemblyWisePartNo');
	    Route::post('MappingVillageAssemblyPartStore', 'MasterController@MappingVillageAssemblyPartStore')->name('admin.Master.MappingVillageAssemblyPartStore');
	    Route::get('MappingVillageAssemblyPartRemove/{id}', 'MasterController@MappingVillageAssemblyPartRemove')->name('admin.Master.MappingVillageAssemblyPartRemove');
	    //-mapping-zp-ward---//
	    Route::get('MappingVillageToZPWard', 'MasterController@MappingVillageToZPWard')->name('admin.Master.MappingVillageToZPWard');
	    Route::get('districtwiseZPWard', 'MasterController@districtwiseZPWard')->name('admin.Master.districtwiseZPWard');
	    Route::get('districtOrZpwardWiseVillage', 'MasterController@districtOrZpwardWiseVillage')->name('admin.Master.districtOrZpwardWiseVillage');
	    Route::post('MappingVillageToZPWardStore', 'MasterController@MappingVillageToZPWardStore')->name('admin.Master.MappingVillageToZPWardStore');
	    //mapping-zp-ward////
	    Route::get('MappingVillageToPSWard', 'MasterController@MappingVillageToPSWard')->name('admin.Master.MappingVillageToPSWard');
	    Route::get('blockwisePsWard', 'MasterController@blockwisePsWard')->name('admin.Master.blockwisePsWard');
	    Route::get('BlockOrPSwardWiseVillage', 'MasterController@BlockOrPSwardWiseVillage')->name('admin.Master.BlockOrPSwardWiseVillage');
	    Route::post('MappingVillageToPSWardStore', 'MasterController@MappingVillageToPSWardStore')->name('admin.Master.MappingVillageToPSWardStore');
	    //mapping-booth-ward////
	    Route::get('MappingBoothWard', 'MasterController@MappingBoothWard')->name('admin.Master.MappingBoothWard');
	    Route::get('MappingVillageWiseBooth', 'MasterController@MappingVillageWiseBooth')->name('admin.Master.MappingVillageWiseBooth');
	    Route::get('MappingVillageOrBoothWiseWard', 'MasterController@MappingVillageOrBoothWiseWard')->name('admin.Master.MappingVillageOrBoothWiseWard');
	    Route::post('MappingBoothWardStore', 'MasterController@MappingBoothWardStore')->name('admin.Master.MappingBoothWardStore');
        //mapping-ward-booth////
	    Route::get('MappingWardBooth', 'MasterController@MappingWardBooth')->name('admin.Master.MappingWardBooth');
	    Route::get('MappingWardBoothTable', 'MasterController@MappingWardBoothTable')->name('admin.Master.MappingWardBoothTable');
	    Route::get('MappingWardBoothSelectBooth', 'MasterController@MappingWardBoothSelectBooth')->name('admin.Master.MappingWardBoothSelectBooth');
	    Route::post('MappingWardBoothStore', 'MasterController@MappingWardBoothStore')->name('admin.Master.MappingWardBoothStore');
	    Route::get('MappingWardBoothEdit/{id}', 'MasterController@MappingWardBoothEdit')->name('admin.Master.MappingWardBoothEdit');
	    //mapping-ward-with-multiple-booth////
	  	Route::get('MappingWardWithMultipleBooth', 'MasterController@MappingWardWithMultipleBooth')->name('admin.Master.MappingWardWithMultipleBooth');
	  	Route::get('MappingWardWithMultipleBoothWardWiseBooth', 'MasterController@MappingWardWithMultipleBoothWardWiseBooth')->name('admin.Master.MappingWardWithMultipleBoothWardWiseBooth');
	  	Route::post('MappingWardWithMultipleBoothStore', 'MasterController@MappingWardWithMultipleBoothStore')->name('admin.Master.MappingWardWithMultipleBoothStore');
	     //mapping-village-ward////
	    Route::get('WardBandi', 'MasterController@WardBandi')->name('admin.Master.WardBandi');	   
	    Route::get('WardBandiFilter', 'MasterController@WardBandiFilter')->name('admin.Master.WardBandiFilter');	   
	    Route::get('WardBandiFilterAssemblyPart', 'MasterController@WardBandiFilterAssemblyPart')->name('admin.Master.WardBandiFilterAssemblyPart');	   
	    Route::get('WardBandiFilterward', 'MasterController@WardBandiFilterward')->name('admin.Master.WardBandiFilterward');	   
	    Route::post('WardBandiStore', 'MasterController@WardBandiStore')->name('admin.Master.WardBandiStore');	   
	    Route::get('WardBandiReport', 'MasterController@WardBandiReport')->name('admin.Master.WardBandiReport');	   
	    Route::post('WardBandiReportGenerate', 'MasterController@WardBandiReportGenerate')->name('admin.Master.WardBandiReportGenerate');	   
	    Route::get('DeleteVoter/{id}', 'MasterController@DeleteVoter')->name('admin.Master.DeleteVoter');
	    //-----------------ward-bandi-with-booth--------------------------//
	    Route::get('WardBandiWithBooth', 'MasterController@WardBandiWithBooth')->name('admin.Master.WardBandiWithBooth');	   
	    Route::get('VillageWiseAssemblyWard', 'MasterController@VillageWiseAssemblyWard')->name('admin.Master.VillageWiseAssemblyWard');	   
	    Route::get('WardWiseBooth', 'MasterController@WardWiseBooth')->name('admin.Master.WardWiseBooth');	   
	    Route::get('BoothWiseTotalMappedWard', 'MasterController@BoothWiseTotalMappedWard')->name('admin.Master.BoothWiseTotalMappedWard');	   
	    Route::get('AssemblywisevoterMapped', 'MasterController@AssemblywisevoterMapped')->name('admin.Master.AssemblywisevoterMapped');	   
	    Route::post('WardBandiWithBoothStore', 'MasterController@WardBandiWithBoothStore')->name('admin.Master.WardBandiWithBoothStore');	   
	     
	     	   
	    //-----------------onchange-----------------------------//
	    Route::get('stateWiseDistrict', 'MasterController@stateWiseDistrict')->name('admin.Master.stateWiseDistrict');   
	    

	    Route::get('DistrictWiseBlock/{print_condition?}', 'MasterController@DistrictWiseBlock')->name('admin.Master.DistrictWiseBlock');
	     

	    Route::get('BlockWiseVillage', 'MasterController@BlockWiseVillage')->name('admin.Master.BlockWiseVillage');




	    //-----------------gender-----------------------------//
	    Route::get('gender', 'MasterController@gender')->name('admin.Master.gender');   
	    Route::get('gender-edit/{id}', 'MasterController@genderEdit')->name('admin.Master.gender.edit');   
	    Route::post('gender-update/{id}', 'MasterController@genderUpdate')->name('admin.Master.gender.update'); 


	    //-----------------gender-----------------------------//
	    Route::get('booth', 'MasterController@booth')->name('admin.Master.booth');   
	    Route::post('boothStore/{id?}', 'MasterController@boothStore')->name('admin.Master.boothStore');   
	    Route::get('boothTable', 'MasterController@boothTable')->name('admin.Master.boothTable');   
	    Route::get('boothEdit/{id}', 'MasterController@boothEdit')->name('admin.Master.boothEdit');   
	    Route::get('boothDelete/{id}', 'MasterController@boothDelete')->name('admin.Master.boothDelete');   
	 
	       
	    Route::get('pollingDayTime', 'MasterController@pollingDayTime')->name('admin.Master.pollingDayTime');
	    Route::post('pollingDayTimeStore', 'MasterController@pollingDayTimeStore')->name('admin.Master.pollingDayTimeStore');
	    Route::get('pollingDayTimeList', 'MasterController@pollingDayTimeList')->name('admin.Master.pollingDayTimeList');
	     
	});
    Route::group(['prefix' => 'VoterDetails'], function() {
           Route::get('/', 'VoterDetailsController@index')->name('admin.voter.details');
           Route::get('districtWiseAssembly', 'VoterDetailsController@districtWiseAssembly')->name('admin.voter.districtWiseAssembly');
           Route::get('districtWiseVillage', 'VoterDetailsController@districtWiseVillage')->name('admin.voter.districtWiseVillage');
           Route::get('AssemblyWisePartNo', 'VoterDetailsController@AssemblyWisePartNo')->name('admin.voter.AssemblyWisePartNo');
           Route::get('VillageWiseWard', 'VoterDetailsController@VillageWiseWard')->name('admin.voter.VillageWiseWard');
           Route::get('VillageWiseVoterList', 'VoterDetailsController@VillageWiseVoterList')->name('admin.voter.VillageWiseVoterList');
           Route::get('calculateAge', 'VoterDetailsController@calculateAge')->name('admin.voter.calculateAge');
           Route::get('NameConvert/{condition_type}', 'VoterDetailsController@NameConvert')->name('admin.voter.NameConvert');
           Route::post('store', 'VoterDetailsController@store')->name('admin.voter.details.store');
           Route::get('voterEdit/{id}', 'VoterDetailsController@voterListEdit')->name('admin.voter.voteredit');
           Route::post('voterUpdate/{id}', 'VoterDetailsController@voterUpdate')->name('admin.voter.voterUpdate');
           Route::get('voterDelete/{id}', 'VoterDetailsController@voterDelete')->name('admin.voter.voterDelete');

    //--------------------Delete----------Delete--------delete----------------------------//       
           Route::get('DeteleAndRestore', 'VoterDetailsController@DeteleAndRestore')->name('admin.voter.DeteleAndRestore');
            Route::post('DeteleAndRestoreShow', 'VoterDetailsController@DeteleAndRestoreShow')->name('admin.voter.DeteleAndRestoreShow');
           Route::get('DeteleAndRestoreDetele/{id}', 'VoterDetailsController@DeteleAndRestoreDetele')->name('admin.voter.DeteleAndRestoreDetele');
           Route::get('DeteleAndRestoreRestore/{id}', 'VoterDetailsController@DeteleAndRestoreRestore')->name('admin.voter.DeteleAndRestoreRestore');
    //-
           Route::get('VoterDetailsModify', 'VoterDetailsController@VoterDetailsModify')->name('admin.voter.VoterDetailsModify');
           Route::post('VoterDetailsModifyShow', 'VoterDetailsController@VoterDetailsModifyShow')->name('admin.voter.VoterDetailsModifyShow');
           Route::get('VoterDetailsModifyEdit/{id}', 'VoterDetailsController@VoterDetailsModifyEdit')->name('admin.voter.VoterDetailsModifyEdit');
           Route::post('VoterDetailsModifyStore/{id}', 'VoterDetailsController@VoterDetailsModifyStore')->name('admin.voter.VoterDetailsModifyStore');
           Route::get('VoterDetailsModifyReset/{id}', 'VoterDetailsController@VoterDetailsModifyReset')->name('admin.voter.VoterDetailsModifyReset');
            


    //-------prepare-voter-list--------------prepare-voter-list-----///
           
           Route::get('PrepareVoterListPanchayat', 'VoterDetailsController@PrepareVoterListPanchayat')->name('admin.voter.PrepareVoterListPanchayat');
           Route::get('VillageWiseWardMultiple', 'VoterDetailsController@VillageWiseWardMultiple')->name('admin.voter.VillageWiseWardMultiple');

           Route::post('PrepareVoterListGenerate', 'VoterDetailsController@PrepareVoterListGenerate')->name('admin.voter.PrepareVoterListGenerate');

           Route::post('PrepareVoterListGenerate', 'PrepareVoterListController@PrepareVoterListGenerate')->name('admin.voter.GenerateVoterListAll'); 
             
            

           Route::get('PrepareVoterListMunicipal', 'VoterDetailsController@PrepareVoterListMunicipal')->name('admin.voter.PrepareVoterListMunicipal');
           Route::post('PrepareVoterListMunicipalGenerate', 'VoterDetailsController@PrepareVoterListMunicipalGenerate')->name('admin.voter.PrepareVoterListMunicipalGenerate');

           Route::get('PrepareVoterListBoothWise', 'VoterDetailsController@PrepareVoterListBoothWise')->name('admin.voter.PrepareVoterListBoothWise');
            
            


           Route::get('VoterListDownload', 'VoterDetailsController@VoterListDownload')->name('admin.voter.VoterListDownload');
           Route::get('BlockWiseDownloadTable', 'VoterDetailsController@BlockWiseDownloadTable')->name('admin.voter.BlockWiseDownloadTable');
           Route::get('VoterListDownloadPDF/{path}/{condition}', 'VoterDetailsController@VoterListDownloadPDF')->name('admin.voter.VoterListDownloadPDF');
            
    });
	Route::group(['prefix' => 'BoothVoterList'], function() {
           Route::get('/', 'BoothVoterListController@index')->name('admin.booth.voter.list');
           Route::get('block-wise-booth-list', 'BoothVoterListController@blockWiseBoothList')->name('admin.booth.voter.list.block.wise.booth.list');
           Route::post('booth-voter-list-process', 'BoothVoterListController@BoothVoterListProcess')->name('admin.booth.voter.list.process');
           Route::get('booth-voter-list-download/{id}', 'BoothVoterListController@boothVoterListDownload')->name('admin.booth.voter.list.download');
    });
    Route::group(['prefix' => 'PrepareVoterSlip'], function() {
           Route::get('/', 'PrepareVoterSlipController@index')->name('admin.prepare.voter.slip'); 
           
           Route::get('village-wise-ward', 'PrepareVoterSlipController@villageWiseWard')->name('admin.prepare.voter.slip.village.wise.ward');
           Route::get('village-wise-booth', 'PrepareVoterSlipController@villageWiseBooth')->name('admin.prepare.voter.slip.village.wise.booth');

           Route::post('PrepareVoterSlipGenerate', 'PrepareVoterSlipController@PrepareVoterSlipGenerate')->name('admin.prepare.voter.slip.generate');
           Route::get('PrepareVoterSlipDownload', 'PrepareVoterSlipController@PrepareVoterSlipDownload')->name('admin.prepare.voter.slip.download');
           Route::get('PrepareVoterSlipDownloadResult', 'PrepareVoterSlipController@PrepareVoterSlipDownloadResult')->name('admin.prepare.voter.slip.download.result');
           Route::get('PrepareVoterSlipResultDownload/{id}', 'PrepareVoterSlipController@PrepareVoterSlipResultDownload')->name('admin.prepare.voter.slip.result.download');
    });
    Route::group(['prefix' => 'Report'], function() {
           Route::get('PrintVoterList', 'ReportController@PrintVoterList')->name('admin.report.PrintVoterList');
           Route::post('PrintVoterListGenerate', 'ReportController@PrintVoterListGenerate')->name('admin.report.PrintVoterListGenerate');

           Route::get('Report', 'ReportController@Report')->name('admin.report.Report');
           Route::get('ReportGenerateExcel', 'ReportController@ReportGenerateExcel')->name('admin.report.ReportGenerate');
           Route::get('ReportGeneratePDF', 'ReportController@ReportGeneratePDF')->name('admin.report.ReportGeneratePDF');
//----card-----print-----------card----print-----------card-print-----           
           Route::get('voterCardPrint', 'ReportController@voterCardPrint')->name('admin.report.voterCardPrint');
           Route::post('voterCardPrintGenerate', 'ReportController@voterCardPrintGenerate')->name('admin.report.voterCardPrintGenerate');
	 	 
    });
    Route::group(['prefix' => 'VoterListMaster'], function() {
           Route::get('/', 'VoterListMasterController@index')->name('admin.VoterListMaster.index');
           Route::post('store/{id?}', 'VoterListMasterController@store')->name('admin.VoterListMaster.store');
           Route::get('default/{id}', 'VoterListMasterController@default')->name('admin.VoterListMaster.default'); 
           Route::get('edit/{id}', 'VoterListMasterController@edit')->name('admin.VoterListMaster.edit');

           Route::get('VoterListDefaultValue', 'VoterListMasterController@VoterListDefaultValue')->name('admin.VoterListMaster.VoterListDefaultValue');           
           Route::post('VoterListDefaultValueStore/{id?}', 'VoterListMasterController@VoterListDefaultValueStore')->name('admin.VoterListMaster.VoterListDefaultValueStore');           
	 	 
    });
    Route::group(['prefix' => 'import'], function() {
           Route::get('', 'ImportExportController@index')->name('admin.import.index');

           Route::post('importVote', 'ImportExportController@importVote')->name('admin.import.importVote');

           Route::get('DistrictExportSample', 'ImportExportController@DistrictExportSample')->name('admin.import.DistrictExportSample');
           Route::get('DistrictImportForm', 'ImportExportController@DistrictImportForm')->name('admin.import.DistrictImportForm');
           Route::post('DistrictImportStore', 'ImportExportController@DistrictImportStore')->name('admin.import.DistrictImportStore');

           Route::get('AssemblyExportSample', 'ImportExportController@AssemblyExportSample')->name('admin.import.AssemblyExportSample');
           Route::get('AssemblyImportForm', 'ImportExportController@AssemblyImportForm')->name('admin.import.AssemblyImportForm');
           Route::post('AssemblyImportStore', 'ImportExportController@AssemblyImportStore')->name('admin.import.AssemblyImportStore');

           Route::get('BlockExportSample', 'ImportExportController@BlockExportSample')->name('admin.import.BlockExportSample');
           Route::get('BlockImportForm', 'ImportExportController@BlockImportForm')->name('admin.import.BlockImportForm');
           Route::post('BlockImportStore', 'ImportExportController@BlockImportStore')->name('admin.import.BlockImportStore');

           Route::get('VillageExportSample', 'ImportExportController@VillageExportSample')->name('admin.import.VillageExportSample');
           Route::get('VillageImportForm', 'ImportExportController@VillageImportForm')->name('admin.import.VillageImportForm');
           Route::post('VillageImportStore', 'ImportExportController@VillageImportStore')->name('admin.import.VillageImportStore');
                     
	 	  Route::get('VillageWardExportSample', 'ImportExportController@VillageWardExportSample')->name('admin.import.VillageWardExportSample');
	 	  Route::get('VillageWardImportForm', 'ImportExportController@VillageWardImportForm')->name('admin.import.VillageWardImportForm');
	 	  Route::post('VillageWardImportStore', 'ImportExportController@VillageWardImportStore')->name('admin.import.VillageWardImportStore');
    });       
    Route::group(['prefix' => 'Database'], function() {
               Route::get('Connection', 'DatabaseConnectionController@DatabaseConnection')->name('admin.database.connection');
               Route::post('ConnectionStore', 'DatabaseConnectionController@ConnectionStore')->name('admin.database.conection.store');
               Route::get('getdata', 'DatabaseConnectionController@getData')->name('admin.database.conection.getData');

               Route::get('getTable', 'DatabaseConnectionController@getTable')->name('admin.database.conection.getTable');
               Route::get('assemblyWisePartNo', 'DatabaseConnectionController@assemblyWisePartNo')->name('admin.database.conection.assemblyWisePartNo');
               Route::post('tableRecordStore', 'DatabaseConnectionController@tableRecordStore')->name('admin.database.conection.tableRecordStore');
                Route::get('imagestore', 'DatabaseConnectionController@imageStore')->name('admin.database.conection.imagestore');
                Route::get('process', 'DatabaseConnectionController@process')->name('admin.database.conection.process');
                Route::get('processDelete/{ac_id}/{part_id}', 'DatabaseConnectionController@processDelete')->name('admin.database.conection.processDelete');


                Route::get('MysqlDataTransfer', 'DatabaseConnectionController@MysqlDataTransfer')->name('admin.database.conection.MysqlDataTransfer');
                Route::get('MysqlDataTransferDistrictWiseBlock', 'DatabaseConnectionController@MysqlDataTransferDistrictWiseBlock')->name('admin.database.conection.MysqlDataTransferDistrictWiseBlock');
                Route::get('MysqlDataTransferBlockWiseVillage', 'DatabaseConnectionController@MysqlDataTransferBlockWiseVillage')->name('admin.database.conection.MysqlDataTransferBlockWiseVillage');
                Route::get('MysqlDataTransferVillageWiseWard', 'DatabaseConnectionController@MysqlDataTransferVillageWiseWard')->name('admin.database.conection.MysqlDataTransferVillageWiseWard');
                Route::post('MysqlDataTransferStore', 'DatabaseConnectionController@MysqlDataTransferStore')->name('admin.database.conection.MysqlDataTransferStore');
        });
    Route::group(['prefix' => 'PDFFileUpload'], function() {
               Route::get('/', 'PDFFileUploadController@index')->name('admin.PDFFileUpload.index');
               Route::post('Upload', 'PDFFileUploadController@Upload')->name('admin.PDFFileUpload.Upload');

 	});
 });