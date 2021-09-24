<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('index');

Route::post('/create-account', 'FrontUserController@createAccount')->name('crteAcc');
Route::get('/check-otp/{uid}', 'FrontUserController@checkOTP')->name('ckOTP');
Route::post('/is-check-otp', 'FrontUserController@isCheckOTP')->name('isckOTP');
Route::post('/resend-otp', 'FrontUserController@resendOTP')->name('resendOTP');
Route::get('/login', 'FrontUserController@login')->name('guestLogin');
Route::post('/login-action', 'FrontUserController@loginAction')->name('guestLoginAct');
Route::get('/account', 'FrontUserController@guestDashboard')->name('guest_dashboard');
Route::get('/logout', 'FrontUserController@guestLogout')->name('guest_logout');
Route::get('/subject-list/{lng}', 'FrontUserController@subjectList')->name('subList');
Route::get('/goexam/{lng}/{sub_id}', 'FrontUserController@goExam')->name('goExam');
Route::post('/goexam/submit', 'FrontUserController@goExamSubmit')->name('goExamFinish');
Route::get('/goexam/finish', 'FrontUserController@goExamFinish')->name('Finish');
Route::get('/exam-history', 'FrontUserController@examHistory')->name('exmHis');
Route::get('/score-cards', 'FrontUserController@scoreCards')->name('scrCrds');
Route::get('/exam-details/{token}', 'FrontUserController@examDetails')->name('exmDet');
Route::get('/go-system/{token}', 'FrontUserController@goSystem')->name('goSys');
Route::get('/my-profile', 'FrontUserController@profile')->name('guestProfile');
Route::post('/update-profile', 'FrontUserController@updateProfile')->name('guestProfileUPD');
Route::get('/change-password', 'FrontUserController@changePassword')->name('guestProfileCngPwd');
Route::post('/change-password-action', 'FrontUserController@changePasswordAction')->name('guestProfileCngPwdAct');

Route::get('/exam-links', 'FrontUserController@examLinks')->name('exLinks');
Route::get('/exam-links/access-token/{link}', 'FrontUserController@examLinksRegistration')->name('exLinksReg');
Route::post('/access-link/{link}', 'FrontUserController@accessLink')->name('ckLink');
Route::get('/access-link/{link}/start-exam', 'FrontUserController@accessLinkStartExam')->name('ckLink.start');
Route::post('/link-exam/submit', 'FrontUserController@goLinkExamSubmit')->name('goLinkExamFinish');
Route::get('/golinkexam/finish', 'FrontUserController@goLinkExamFinish')->name('FinishLinkExam');



Route::group(['prefix' => 'admin'], function () {

	Route::group(['middleware' => 'IfAdminNotLogIn'], function() {
		
		Route::get('/login', 'DashboardController@login')->name('dashboard_login');
		Route::post('/login', 'DashboardController@loginAction')->name('dashboard_login_action');

	}); // end IfAdminNotLogIn middleware


	/********** AFTER ADMIN LOGIN PART **********/
	/********** DASHBOARD ACTION START *********/
	Route::group(['prefix' => 'dashboard',  'middleware' => ['IfAdminLogIn'] ], function () {
		
		Route::get('/', 'DashboardController@index')->name('dashboard');
		Route::get('/logout', 'DashboardController@logout')->name('logout');

		Route::group(['prefix' => 'settings'], function () {

			Route::get('/', 'SettingsController@generalSettings')->name('gen_sett');
			Route::post('/save', 'SettingsController@saveGeneralSettings')->name('sv_gen_sett');
		});

		Route::group(['prefix' => 'users-management'], function () {

			Route::get('/', 'UserController@index')->name('users_list');
			Route::get('/create-user', 'UserController@createUser')->name('crte_user');
			Route::post('/save-user', 'UserController@saveUser')->name('save_user');
			Route::get('/edit-user/{user_timestamp_id}', 'UserController@editUser')->name('edit_user');
			Route::post('/update-user/{user_timestamp_id}', 'UserController@updateUser')->name('upd_user');
			Route::get('/reset-password/{user_timestamp_id}', 'UserController@resetPassword')->name('rst_pwd');
			Route::post('/update-password/{user_timestamp_id}', 'UserController@updatePassword')->name('upd_pwd');
			Route::get('/delete-user/{user_timestamp_id}', 'UserController@deleteUser')->name('del_usr');
			Route::get('/profile', 'UserController@profile')->name('usr_profile');
			Route::post('/profile', 'UserController@profileUpdate')->name('upd_profile');
			Route::get('/change-password', 'UserController@changePassword')->name('cng_pwd');
			Route::post('/change-password', 'UserController@changePasswordSave')->name('save_pwd');
		});

		Route::group(['prefix' => 'question-management'], function () {

			Route::get('/', 'QuestionController@index')->name('sub_list');
			Route::get('/create-subject', 'QuestionController@addSubject')->name('add_sub');
			Route::post('/save-subject', 'QuestionController@saveSubject')->name('sve_sub');
			Route::get('/edit-subject/{id}', 'QuestionController@editSubject')->name('edt_sub');
			Route::post('/update-subject/{id}', 'QuestionController@updateSubject')->name('upd_sub');
			Route::get('/delete-subject/{id}', 'QuestionController@deleteSubject')->name('del_sub');

			Route::get('/all-questions', 'QuestionController@allQuestions')->name('ques_list');
			Route::get('/add-question', 'QuestionController@addQuestion')->name('add_ques');
			Route::post('/save-question', 'QuestionController@saveQuestion')->name('sve_ques');
			Route::get('/edit-question/{id}', 'QuestionController@editQuestion')->name('edt_ques');
			Route::post('/update-question/{id}', 'QuestionController@updateQuestion')->name('upd_ques');
			Route::get('/delete-question/{id}', 'QuestionController@deleteQuestion')->name('del_ques');

			Route::get('/exam-settings', 'QuestionController@examSettings')->name('settQues');
			Route::post('/exam-settings-save', 'QuestionController@examSettingsSave')->name('settQuesSve');
		});

		Route::group(['prefix' => 'question-links'], function () {
			Route::get('/', 'QuestionController@links')->name('links');
			Route::get('/delete-link/{id}', 'QuestionController@deleteLink')->name('delLink');
			Route::get('/edit-link/{id}', 'QuestionController@editLink')->name('edtLink');
			Route::post('/update-link/{id}', 'QuestionController@updateLink')->name('updLink');
			Route::get('/add', 'QuestionController@addLinks')->name('addLinks');
			Route::post('/save', 'QuestionController@saveLinks')->name('svelinks');
			Route::get('/add-edit-questions/{link_id}', 'QuestionController@addEditQuestion')->name('addEdtQues');
			Route::post('/update-add-edit-questions/{link_id}', 'QuestionController@SaveAddEditQuestion')->name('UpdateAddEdtQues');
			Route::get('/view-candidates/{link_id}', 'QuestionController@viewLinkCandidates')->name('viewLinkCandidates');
			Route::get('/running-candidates/{id}', 'QuestionController@runningCandidates')->name('runningCandidates');
			Route::get('/delete-running-candidates/{link_id}/{user_id}', 'QuestionController@runningCandidatesDel')->name('runningCandidatesDel');
		});

		Route::group(['prefix' => 'ajax'], function() {
			
		});


	}); //end dashboard prefix
	/********** END DASHBOARD ACTION *********/

}); //end admin prefix
Route::post('/checkCandidate', 'QuestionController@isLiveCandidate')->name('isLiveCandidate');


