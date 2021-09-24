<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\Models\Users;
use App\Models\Exams;
use App\Models\ExamQuestions;
use App\Models\EaxmSettings;

use Session;
use Auth;


class DashboardController extends Controller
{
    
    public function login() {
    	
    	return view('dashboard_login');
    }

    public function loginAction(Request $request) {

    	$request->validate([
			
            'email_id' => 'required',
            'password' => 'required'
		],[
		
			'email_id.required' => 'Please enter email-id.',
			'password.required' => 'Please enter password.'
		]);

    	$email_id = trim($request->input('email_id'));
    	$password = md5(trim($request->input('password')));
    	$rm_me = trim($request->input('rm_me'));
    	$norPwd = trim($request->input('password'));

    	$loginUser = Users::where('email_id', '=', $email_id)
    	->where('password', '=', $password)->where('status', '=', '1')->first(); 

    	if(!empty($loginUser)) {
    		
    		Auth::login($loginUser);
    		if( $rm_me == '1' ) {
    			setcookie("multotec_admin_email", $email_id, time() + (86400 * 30));
                setcookie("multotec_admin_password", $norPwd, time() + (86400 * 30));
    		} else {
    			unset($_COOKIE['multotec_admin_email']);
                unset($_COOKIE['multotec_admin_password']);
                setcookie("multotec_admin_email", '', time() - 3600);
                setcookie("multotec_admin_password", '', time() - 3600);
    		}

    		Session::put('ar_login_user_id', $loginUser->id);
            Session::put('is_ar_admin_logged_in', 'yes');

    		return redirect()->route('dashboard');

    	} else {
    		return back()->with('msg', 'Sorry! Login Information Incorrect.');
    	}
    }

    public function logout() {

    	if(Session::has('ar_login_user_id')) { Session::forget('ar_login_user_id'); }
    	if(Session::has('is_ar_admin_logged_in')) { Session::forget('is_ar_admin_logged_in'); }
    	Auth::logout();
    	Session::flush();
    	return redirect()->route('dashboard_login');
    }

    public function index() {
        $dataBag = array();
        $data = Exams::orderBy('created_at', 'desc')->paginate( 30 );
        $dataBag['data'] = $data;
    	return view('dashboard.index', $dataBag);
    }
}
