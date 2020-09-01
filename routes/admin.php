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
		Route::get('class-all', 'AccountController@classAllSelect')->name('admin.account.classAllSelect'); 
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
	//---------------master-----------------------------------------	
	Route::prefix('master-minu')->group(function () {
		Route::prefix('academic-year')->group(function () {
		    Route::get('list', 'AcademicYearController@index')->name('admin.academicYear.list');
		    Route::post('store', 'AcademicYearController@store')->name('admin.academicYear.store');
		    Route::get('edit/{id?}', 'AcademicYearController@edit')->name('admin.academicYear.edit');
		    Route::get('default-value/{id}', 'AcademicYearController@defaultValue')->name('admin.academicYear.default.value');
		    Route::get('pdf-generate', 'AcademicYearController@pdfGenerate')->name('admin.academicYear.pdf.generate');
		    Route::post('update/{id?}', 'AcademicYearController@update')->name('admin.academicYear.update');
		    Route::get('delete/{id}', 'AcademicYearController@destroy')->name('admin.academicYear.delete');
		    Route::get('document-type', 'DocumentTypeController@index')->name('admin.document.type');
		    Route::post('document-store', 'DocumentTypeController@store')->name('admin.document.store');
		    Route::get('document-edit/{id?}', 'DocumentTypeController@edit')->name('admin.document.type.edit');
		    Route::post('document-update/{id?}', 'DocumentTypeController@update')->name('admin.document.type.update');
		    Route::get('document-delete/{id}', 'DocumentTypeController@destroy')->name('admin.document.type.delete');
		    Route::get('report', 'DocumentTypeController@report')->name('admin.document.type.report');
		     
		});
		Route::prefix('payment-mode')->group(function () {
		    Route::get('list', 'PaymentModeController@index')->name('admin.paymentMode.list');
		    Route::post('store', 'PaymentModeController@store')->name('admin.paymentMode.store');
		    Route::get('edit/{id?}', 'PaymentModeController@edit')->name('admin.paymentMode.edit');
		    Route::post('update/{id?}', 'PaymentModeController@update')->name('admin.paymentMode.update');
		    Route::get('delete/{id}', 'PaymentModeController@destroy')->name('admin.paymentMode.delete');
		    Route::get('pdf-generate', 'PaymentModeController@pdfGenerate')->name('admin.paymentMode.pdf.generate');
		     
		});
	 
	     
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
	//---------------Class create----------------------------------------
	 
		// ---------------User with class----------------------------------------
	Route::group(['prefix' => 'user-class'], function() {
	    Route::get('/', 'AccountController@userClass')->name('admin.userClass.list');	   
	    Route::post('add', 'AccountController@userClassStore')->name('admin.userClass.add');
	    // Route::get('{manageSectionEdit}/edit', 'SectionController@edit')->name('admin.manageSection.edit');
	    // Route::post('{manageSection}/update', 'SectionController@update')->name('admin.manageSection.update');
	    // Route::get('{manageSection}/delete', 'SectionController@destroy')->name('admin.manageSection.delete');        
	});
	//---------------Class fee----------------------------------------
	 
    });
	//---------------Student--------------------------------------------------------------------
	 Route::group(['prefix' => 'student'], function() {
	     Route::get('add', 'StudentController@create')->name('admin.student.form');	
	     Route::get('view/{student}', 'StudentController@show')->name('admin.student.view');	   
	     Route::get('preview/{id}', 'StudentController@previewshow')->name('admin.student.preview');	   
	     Route::get('pdf/{id}', 'StudentController@pdfGenerate')->name('admin.student.pdf.generate');	   
	     Route::get('{student}/edit', 'StudentController@edit')->name('admin.student.edit');
	     Route::get('{student}/delete', 'StudentController@destroy')->name('admin.student.delete');
	     Route::get('{student}/profileedit', 'StudentController@profileedit')->name('admin.student.profileedit');
	     Route::get('{student}/totalfeeedit', 'StudentController@totalfeeedit')->name('admin.student.totalfeeedit');
	     Route::post('{student}/totalfeeupdate', 'StudentController@totalfeeupdate')->name('admin.student.totalfeeupdate');
	     Route::post('add', 'StudentController@store')->name('admin.student.post');
	     Route::post('{student}/update', 'StudentController@update')->name('admin.student.update');
	     Route::post('{student}/view-update', 'StudentController@viewUpdate')->name('admin.student.view-update');
	     Route::post('{student}/profileupdate', 'StudentController@profileupdate')->name('admin.student.profileupdate');
	     Route::post('list/{menuPermission}', 'StudentController@index')->name('admin.student.list'); 
	     Route::get('show-form', 'StudentController@showForm')->name('admin.student.show');
	     Route::get('student-image-upload', 'StudentController@studentImageUpload')->name('admin.student.image.upload');
	     Route::get('student-image-upload-list/{id?}', 'StudentController@studentImageUploadList')->name('admin.student.image.upload.list');
	     Route::post('student-image-upload-store/{id}', 'StudentController@studentImageUploadStore')->name('admin.student.image.upload.store');
	     Route::get('student-document-verify', 'StudentController@studentDocumentVerify')->name('admin.student.document.verify');
	     Route::get('student-document-verify-list/{id}', 'StudentController@studentDocumentVerifyList')->name('admin.student.document.verify.list');
	     Route::get('student-document-verify-view/{id}', 'StudentController@studentDocumentVerifyView')->name('admin.student.document.verify.view');
	     Route::get('student-document-verify-print/{id}', 'StudentController@studentDocumentVerifyPrint')->name('admin.student.document.verify.print');
	    
	     Route::get('{student}/password-reset', 'StudentController@passwordReset')->name('admin.student.passwordreset'); 
	     Route::get('image/{image}', 'StudentController@image')->name('admin.student.image');
	     Route::post('image/{student}/update', 'StudentController@imageUpdate')->name('admin.student.profilepic.update');
	     Route::post('imageweb', 'StudentController@imageWebUpdate')->name('admin.student.profilepic.webupdate');
	     Route::get('camera/{id}', 'StudentController@camera')->name('admin.student.camera');
	     Route::get('export', 'StudentController@excelData')->name('admin.student.excel');
	     Route::get('import-view', 'StudentController@importview')->name('admin.student.excel.import');	      
	     Route::get('import-show', 'StudentController@importshow')->name('admin.student.excel.show');	      
	     Route::get('birthday', 'StudentController@birthday')->name('admin.student.birthday.list');	      
	     Route::post('birthday-search', 'StudentController@birthdaySearch')->name('admin.birthday.search'); 
	     Route::get('birthday-card/{id}', 'StudentController@birthdayPrint')->name('admin.birthday.card.pdf'); 
	     Route::get('birthday-sms-send/{student_id}{id}', 'StudentController@birthdaySmsSend')->name('admin.birthday.card.sms.send'); 
	     Route::post('birthday-card-all', 'StudentController@birthdayPrintAll')->name('admin.birthday.card.pdfAll');   
	     Route::post('import', 'StudentController@importStudent')->name('admin.student.excel.store');	      
	     Route::get('birthday-dashboard', 'StudentController@birthdayDashboard')->name('admin.student.birthday.dashboard');	      
	     Route::get('birthday-upcoming', 'StudentController@birthdayDashboardUpcoming')->name('admin.student.birthday.dashboard.upcoming');	      
	     
		 Route::get('new-admission', 'StudentController@newAdmission')->name('admin.student.new.adminssion');
		 Route::get('new-admission-status-change/{id}', 'StudentController@newAdmissionStatusChange')->name('admin.new.student.status.change');
		 Route::get('reset-admission', 'StudentController@resetAdmission')->name('admin.student.reset.adminssion');
		 Route::post('reset-admission-student-show', 'StudentController@resetAdmissionStudentShow')->name('admin.student.reset.adminssion.student.show');	      
		 
		Route::get('reset-roll-no', 'StudentController@resetRollNo')->name('admin.student.reset.roll');
		Route::post('reset-roll-no-show', 'StudentController@resetRollNoshow')->name('admin.student.reset.roll.no.show');
		Route::post('reset-roll-no-show-update', 'StudentController@resetRollNoshowUpdate')->name('admin.student.reset.roll.no.show.update');
		Route::post('reset-roll-no-update', 'StudentController@resetRollNoUpdate')->name('admin.student.reset.roll.no.update');
		Route::get('student-request-update', 'StudentController@studentRequestUpdate')->name('admin.student.request.update');
		Route::get('student-serach/{menu_id}', 'StudentController@studentSearch')->name('admin.student.view.search');
		Route::get('student-serach-by-register-no/', 'StudentController@studentSearchByRegisterNo')->name('admin.student.details.show');
		//----------student role url -------------------
		Route::get('registration-form', 'StudentController@registrationForm')->name('admin.student.registration.form');	
		Route::get('admission-class-avalval', 'StudentController@academicYearOnchange')->name('admin.student.registration.academicYear'); 
		Route::post('registration-store', 'StudentController@registrationStore')->name('admin.student.registration.store');	
		Route::get('registration-list', 'StudentController@registrationList')->name('admin.student.registration.list'); 
		Route::get('registration-list-filter/{id?}', 'StudentController@registrationListFilter')->name('admin.student.registration.list.filter'); 
		Route::get('final-submit/{id?}', 'StudentController@registrationFinalSubmit')->name('admin.student.registration.final.submit'); 
		Route::get('profile-view/{id?}', 'StudentController@registrationProfileView')->name('admin.student.registration.profile.view'); 
        //-----------student school wise admission-------- 
        Route::get('school-wise-admission', 'StudentController@schoolWiseAdmission')->name('admin.student.school.wise.admission');	
        Route::post('school-wise-admission-store', 'StudentController@schoolWiseAdmissionStore')->name('admin.student.school.wise.admission.store');
        //-----------admission-test-marks-------- 
        Route::get('admission-test-marks', 'StudentController@admissionTestMarks')->name('admin.student.admission.test.marks');	 
        Route::post('admission-test-marks-search', 'StudentController@admissionTestMarksSearch')->name('admin.student.admission.test.marks.search'); 
        Route::get('admission-test-marks-filter/{class_id}/{academicYear_id}/{condition_id}', 'StudentController@admissionTestMarksfilter')->name('admin.student.admission.test.marks.filter');	 
        Route::post('admission-test-marks-store', 'StudentController@admissionTestMarksStore')->name('admin.student.admission.test.marks.store');	 
        //-----------admission-test-marks-------- 
        Route::get('take-admission', 'StudentController@takeAdmission')->name('admin.student.take.admission'); 
        Route::post('take-admission-store', 'StudentController@takeAdmissionStore')->name('admin.student.take.admission.store'); //-----------new-application-report-------- 
        Route::get('new-application-report', 'StudentController@newApplicationReport')->name('admin.student.new.application.report'); 
        Route::post('new-application-filter', 'StudentController@newApplicationReportFilter')->name('admin.student.new.application.report.filter'); 
		});


    Route::group(['prefix' => 'Master'], function() {
    	//-states-//
	    Route::get('/', 'MasterController@index')->name('admin.Master.index');	   
	    Route::post('Store/{id?}', 'MasterController@store')->name('admin.Master.store');	   
	    Route::get('Edit{id}', 'MasterController@edit')->name('admin.Master.edit');
	    Route::get('Delete{id}', 'MasterController@delete')->name('admin.Master.delete');
        //-districts-//
	    Route::get('Districts', 'MasterController@districts')->name('admin.Master.districts');	   
	    Route::post('Districts-Store{id?}', 'MasterController@districtsStore')->name('admin.Master.districtsStore');	   
	    Route::get('Districts-Edit/{id}', 'MasterController@districtsEdit')->name('admin.Master.districtsEdit');
	    Route::get('Districts-delete/{id}', 'MasterController@districtsDelete')->name('admin.Master.districtsDelete');
	    //-block-mcs-//
	    Route::get('BlockMCS', 'MasterController@BlockMCS')->name('admin.Master.blockmcs');	   
	    Route::post('BlockMCSStore{id?}', 'MasterController@BlockMCSStore')->name('admin.Master.BlockMCSStore');	   
	    Route::get('BlockMCSEdit/{id}', 'MasterController@BlockMCSEdit')->name('admin.Master.BlockMCSEdit');
	    Route::get('BlockMCSDelete/{id}', 'MasterController@BlockMCSDelete')->name('admin.Master.BlockMCSDelete');
	    //-village--//
	    Route::get('village', 'MasterController@village')->name('admin.Master.village');	   
	    Route::post('village-store{id?}', 'MasterController@villageStore')->name('admin.Master.village.store');	   
	    Route::get('village-edit/{id}', 'MasterController@villageEdit')->name('admin.Master.village.edit');
	    Route::get('village-delete/{id}', 'MasterController@villageDelete')->name('admin.Master.village.delete');
	    Route::get('village-ward-add/{id}', 'MasterController@villageWardAdd')->name('admin.Master.village.ward.add');
	    //-village--//
	    Route::get('ward', 'MasterController@ward')->name('admin.Master.ward');	   
	    Route::post('ward-store{id?}', 'MasterController@wardStore')->name('admin.Master.ward.store');	 
	    //-Assembly--//
	    Route::get('Assembly', 'MasterController@Assembly')->name('admin.Master.Assembly');	   
	    Route::post('Assembly-store{id?}', 'MasterController@AssemblyStore')->name('admin.Master.Assembly.store');	   
	    Route::get('Assembly-edit/{id}', 'MasterController@AssemblyEdit')->name('admin.Master.Assembly.edit');
	    Route::get('Assembly-delete/{id}', 'MasterController@AssemblyDelete')->name('admin.Master.Assembly.delete');
	    //-Assembly--//
	    Route::get('AssemblyPart', 'MasterController@AssemblyPart')->name('admin.Master.AssemblyPart');	   
	    Route::post('AssemblyPart-store{id?}', 'MasterController@AssemblyPartStore')->name('admin.Master.AssemblyPart.store');	   
	    Route::get('AssemblyPart-edit/{id}', 'MasterController@AssemblyPartEdit')->name('admin.Master.AssemblyPart.edit');
	    Route::get('AssemblyPart-delete/{id}', 'MasterController@AssemblyPartDelete')->name('admin.Master.AssemblyPart.delete');
	    //-Mapping---//
	    Route::get('MappingVillageAssemblyPart', 'MasterController@MappingVillageAssemblyPart')->name('admin.Master.MappingVillageAssemblyPart');	   
	    Route::get('MappingVillageAssemblyPartFilter', 'MasterController@MappingVillageAssemblyPartFilter')->name('admin.Master.MappingVillageAssemblyPartFilter');
	    Route::get('MappingAssemblyWisePartNo', 'MasterController@MappingAssemblyWisePartNo')->name('admin.Master.MappingAssemblyWisePartNo');
	    Route::post('MappingVillageAssemblyPartStore', 'MasterController@MappingVillageAssemblyPartStore')->name('admin.Master.MappingVillageAssemblyPartStore');
	    Route::get('MappingVillageAssemblyPartRemove/{id}', 'MasterController@MappingVillageAssemblyPartRemove')->name('admin.Master.MappingVillageAssemblyPartRemove');
	    //-Mapping---//
	    Route::get('WardBandi', 'MasterController@WardBandi')->name('admin.Master.WardBandi');	   
	    Route::get('WardBandiFilter', 'MasterController@WardBandiFilter')->name('admin.Master.WardBandiFilter');	   
	    Route::get('WardBandiFilterAssemblyPart', 'MasterController@WardBandiFilterAssemblyPart')->name('admin.Master.WardBandiFilterAssemblyPart');	   
	    Route::get('WardBandiFilterward', 'MasterController@WardBandiFilterward')->name('admin.Master.WardBandiFilterward');	   
	    Route::post('WardBandiStore', 'MasterController@WardBandiStore')->name('admin.Master.WardBandiStore');	   
	    Route::get('WardBandiReport', 'MasterController@WardBandiReport')->name('admin.Master.WardBandiReport');	   
	    Route::post('WardBandiReportGenerate', 'MasterController@WardBandiReportGenerate')->name('admin.Master.WardBandiReportGenerate');	   
	     	   
	    //-----------------onchange-----------------------------//
	    Route::get('stateWiseDistrict', 'MasterController@stateWiseDistrict')->name('admin.Master.stateWiseDistrict');   
	    Route::get('DistrictWiseBlock', 'MasterController@DistrictWiseBlock')->name('admin.Master.DistrictWiseBlock');   
	    Route::get('BlockWiseVillage', 'MasterController@BlockWiseVillage')->name('admin.Master.BlockWiseVillage');




	    //-----------------onchange-----------------------------//
	    Route::get('gender', 'MasterController@gender')->name('admin.Master.gender');   
	    Route::get('gender-edit/{id}', 'MasterController@genderEdit')->name('admin.Master.gender.edit');   
	    Route::post('gender-update/{id}', 'MasterController@genderUpdate')->name('admin.Master.gender.update');   
	       
	    
	     
	});
    Route::group(['prefix' => 'VoterDetails'], function() {
           Route::get('/', 'VoterDetailsController@index')->name('admin.voter.details');
           Route::get('districtWiseAssembly', 'VoterDetailsController@districtWiseAssembly')->name('admin.voter.districtWiseAssembly');
           Route::get('districtWiseVillage', 'VoterDetailsController@districtWiseVillage')->name('admin.voter.districtWiseVillage');
           Route::get('AssemblyWisePartNo', 'VoterDetailsController@AssemblyWisePartNo')->name('admin.voter.AssemblyWisePartNo');
           Route::get('VillageWiseWard', 'VoterDetailsController@VillageWiseWard')->name('admin.voter.VillageWiseWard');
           Route::get('calculateAge', 'VoterDetailsController@calculateAge')->name('admin.voter.calculateAge');
           Route::post('store', 'VoterDetailsController@store')->name('admin.voter.details.store');

    //--------------------Delete----------Delete--------delete----------------------------//       
           Route::get('DeteleAndRestore', 'VoterDetailsController@DeteleAndRestore')->name('admin.voter.DeteleAndRestore');
            Route::get('DeteleAndRestoreForm', 'VoterDetailsController@DeteleAndRestoreForm')->name('admin.voter.DeteleAndRestoreForm');
           Route::get('DeteleAndRestore', 'VoterDetailsController@DeteleAndRestore')->name('admin.voter.DeteleAndRestore');
           Route::get('DeteleAndRestoreSearch', 'VoterDetailsController@DeteleAndRestoreSearch')->name('admin.voter.DeteleAndRestoreSearch');
           Route::get('DeteleAndRestoreSearchFilter', 'VoterDetailsController@DeteleAndRestoreSearchFilter')->name('admin.voter.DeteleAndRestoreSearchFilter');


    //-------prepare-voter-list--------------prepare-voter-list-----///
           
           Route::get('PrepareVoterList', 'VoterDetailsController@PrepareVoterList')->name('admin.voter.PrepareVoterList');
           Route::get('VillageWiseWardMultiple', 'VoterDetailsController@VillageWiseWardMultiple')->name('admin.voter.VillageWiseWardMultiple');
           Route::post('PrepareVoterListGenerate', 'VoterDetailsController@PrepareVoterListGenerate')->name('admin.voter.PrepareVoterListGenerate');
           Route::get('imageShow', 'VoterDetailsController@imageShow')->name('admin.voter.imageShow');
    });
    Route::group(['prefix' => 'Report'], function() {
           Route::get('/', 'ReportController@index')->name('admin.report.index');
           Route::post('reportGenerate', 'ReportController@reportGenerate')->name('admin.report.reportGenerate');
	 	 
    });
    Route::group(['prefix' => 'VoterListMaster'], function() {
           Route::get('/', 'VoterListMasterController@index')->name('admin.VoterListMaster.index');
           Route::post('store', 'VoterListMasterController@store')->name('admin.VoterListMaster.store');
           Route::get('default/{id}', 'VoterListMasterController@default')->name('admin.VoterListMaster.default');           
	 	 
    });       

 