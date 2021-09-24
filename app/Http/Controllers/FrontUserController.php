<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Languages;
use App\Models\Subjects;
use App\Models\Questions;
use App\Models\Exams;
use App\Models\ExamQuestions;
use App\Models\EaxmSettings;
use App\Models\OtpMaster;
use Session;
use Image;
use Auth;
use Mail;
use PDF;
use DB;

class FrontUserController extends Controller
{
    
    public function createAccount(Request $request) {

        $role_id = '4';
        $Users = new Users;
        $phno = trim($request->input('contact_no'));
        $Users->timestamp_id = md5(microtime(TRUE));
        $Users->first_name = trim($request->input('first_name'));
        $Users->last_name = trim($request->input('last_name'));
        $Users->email_id = trim($request->input('email_id'));
        $Users->aadhar_no = trim( strtoupper( $request->input('aadhar_no') ));
        $Users->contact_no = $phno;
        $Users->password = md5(trim($request->input('password')));
        $Users->role_id = $role_id;
        $Users->status = 1;
        if( $Users->save() ) {

            /*$otp = rand(123456, 999999);
            $sms = urlencode( "Dear User, Your OTP is ". $otp );
            $url="http://sms.happy2code.co.in/pushsms.php";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=AFIBS&password=123456&sender=AFIBSS&numbers=$phno&message=$sms");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $response = curl_exec($ch);

            $OtpMaster = new OtpMaster;
            $OtpMaster->user_id = $Users->id;
            $OtpMaster->otp_number = $otp;
            $OtpMaster->save();
            $encUID = base64_encode( $Users->id );
            return redirect()->route('ckOTP', array('uid' => $encUID))->with('msg', 'Please Verify Your Mobile Number, Enter The OTP.')
            ->with('msg_class', 'notice notice-success');
            */
            return redirect()->route('guestLogin')->with('msg','Account Created Successfully, Please Login')
            ->with('msg_class', 'notice notice-success');
        }
        return back();
    }

    public function checkOTP( $uid ) {
        $dataBag['uid'] = base64_decode( $uid );
        return view('check_otp', $dataBag);
    }

    public function isCheckOTP(Request $request) {

        $otp_number = trim( $request->input('otp_number') );
        $uid = trim( $request->input('uid') );
        $otp = OtpMaster::where('user_id', '=', $uid)->orderBy('id', 'desc')->first();
        if( isset($otp) && !empty($otp) ) {
            $existOtp = $otp->otp_number;
            if( $existOtp == $otp_number ) {
                $user = Users::find($uid);
                $user->status = '1';
                if( $user->save() ) {
                    OtpMaster::where('user_id', '=', $uid)->delete();
                    return redirect()->route('guestLogin')->with('msg','Account Created Successfully, Please Login')
                    ->with('msg_class', 'notice notice-success');
                } else {
                    return redirect()->route('guestLogin')->with('msg','Your Mobile Number Not Found, Please Registration First')
                    ->with('msg_class','msg_class', 'notice notice-danger');
                }
            } else {
                return redirect()->route('guestLogin')->with('msg','Your Mobile Number Not Found, Please Registration First')
                ->with('msg_class','msg_class', 'notice notice-danger');
            }
        }

        return back();
    }

    public function resendOTP(Request $request) {
        
        OtpMaster::where('user_id', '=', $request->input('uid'))->delete();
        $user = Users::find($request->input('uid'));
        $phno = $user->contact_no;

        $otp = rand(123456, 999999);
        $sms = urlencode( "Dear User, Your OTP is ". $otp );
        $url="http://sms.happy2code.co.in/pushsms.php";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=AFIBS&password=123456&sender=AFIBSS&numbers=$phno&message=$sms");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $response = curl_exec($ch);

        $OtpMaster = new OtpMaster;
        $OtpMaster->user_id = trim( $request->input('uid') );
        $OtpMaster->otp_number = $otp;
        $OtpMaster->save();
        
        return back()->with('msg', 'OTP Resend, Please Check Your Mobile, It May Take Some Time')
        ->with('msg_class', 'notice notice-success');
    }

    public function login() {
        return view('login');
    }

    public function loginAction(Request $request) {

        $email_id = trim($request->input('email_id'));
        $password = md5(trim($request->input('password')));
        $rm_me = trim($request->input('rm_me'));
        $norPwd = trim($request->input('password'));

        $loginUser = Users::where('email_id', '=', $email_id)
        ->where('password', '=', $password)->where('status', '=', '1')->first(); 

        if(!empty($loginUser)) {
            
            Auth::login($loginUser);
            if( $rm_me == '1' ) {
                setcookie("multotec_guest_email", $email_id, time() + (86400 * 30));
                setcookie("multotec_guest_password", $norPwd, time() + (86400 * 30));
            } else {
                unset($_COOKIE['multotec_guest_email']);
                unset($_COOKIE['multotec_guest_password']);
                setcookie("multotec_guest_email", '', time() - 3600);
                setcookie("multotec_guest_password", '', time() - 3600);
            }

            Session::put('ar_login_guest_user_id', $loginUser->id);
            Session::put('is_ar_guest_logged_in', 'yes');

            return redirect()->route('subList', array('lng' => 'mth'));

        } else {
            return back()->with('msg', 'Sorry! Login Information Incorrect.');
        }
    }

    public function guestDashboard() {
        return view('account');
    }

    public function guestLogout() {
        Auth::logout();
        Session::flush();
        return redirect()->route('index');
    }

    public function subjectList( $lng ) {

        $dataBag = array();

        if( $lng != '' && $lng == 'eng' ) {
            $data = \App\Models\Subjects::where('language_id', '=', '1')->where('status', '=', '1')
            ->orderBy('created_at', 'desc')->get();
            $dataBag['menu_active'] = 'subEng';
        }

        if( $lng != '' && $lng == 'mth' ) {
            $data = \App\Models\Subjects::where('language_id', '=', '2')->where('status', '=', '1')
            ->orderBy('created_at', 'desc')->get();
            $dataBag['menu_active'] = 'subMth';
        }

        $dataBag['data'] = $data;
        return view('subjects', $dataBag);
    }

    public function goExam( $lng, $sub_id ) {

        $dataBag = array();

        $lng_id = '';
        if( $lng == 'eng' ) {
            $lng_id = '1';
        }
        if( $lng == 'mth' ) {
            $lng_id = '2';
        }
        
        $examSettings = EaxmSettings::find(1);
        $no_of_question = $examSettings->no_of_question;

        $sub_id = base64_decode( $sub_id );
        $data = \App\Models\Questions::where('subject_id', '=', $sub_id)->where('language_id', '=', $lng_id)
        ->where('status', '=', '1')->orderByRaw("RAND()")->take( $no_of_question )->get();

        $dataBag['quesData'] = $data;
        $dataBag['subject_id'] = $sub_id;
        $dataBag['examSettings'] = $examSettings;
        return view('goexam', $dataBag);   
    }

    public function goExamSubmit(Request $request) {
        
        ini_set('max_execution_time', 300);
        
        //define("DOMPDF_UNICODE_ENABLED", true); 
        //ini_set('memory_limit','512M');
        //set_time_limit(300);

        $ansRequest = $request->all();
        //dd($ansRequest);

        $candidate_id = Auth::user()->id;
        $exam_token = md5( microtime(TRUE) . rand(123456, 999999) . $candidate_id );
        $subject_id = trim( $request->input('subject_id') );
        $total_question = trim( $request->input('total_question') );
        $each_marks = trim( $request->input('each_marks') );
        $total_time = trim( $request->input('total_time') );
        
        $marks = 0;
        $attempt = 0;
        $examDetailsArr = array();

        if( isset($ansRequest) && !empty($ansRequest) ) {
            foreach( $ansRequest as $key => $value ) {
                $ansStatus = 0;
                $arr = array();
                $expArr = explode('_', $key);
                if( !empty($expArr) ) {
                    if( $expArr[0] == 'ans' ) {
                        $attempt++;
                        $question_id = $expArr[1];
                        $correct_answer = $expArr[2];
                        if( $correct_answer == $value ) {
                            $marks = $marks + $each_marks;
                            $ansStatus = 1;
                        } else {
                            $ansStatus = 0;
                        }
                        $arr['exam_token'] = $exam_token;
                        $arr['question_id'] = $question_id;
                        $arr['candidate_answer'] = $value;
                        $arr['candidate_answer_status'] = $ansStatus;
                        array_push( $examDetailsArr, $arr );
                    } 
                }
            }
        }

        $grade_obtain = '';
        $total_marks = $total_question * $each_marks;
        $percent = ( $marks / $total_marks ) * 100;
        if( $percent > 90 ) {
            $grade_obtain = 'A+';
        } else if ( $percent > 75 && $percent <= 90 ) {
            $grade_obtain = 'A';
        } else if ( $percent > 60 && $percent <= 75 ) {
            $grade_obtain = 'B';
        } else if ( $percent >= 50 && $percent <= 60 ) {
            $grade_obtain = 'C';
        } else if ( $percent < 50 ) {
            $grade_obtain = 'F';
        }
        $Exams = new Exams;
        $Exams->exam_token = $exam_token;
        $Exams->subject_id = $subject_id;
        $Exams->candidate_id = $candidate_id;
        $Exams->total_question = $total_question;
        $Exams->total_time = $total_time;
        $Exams->each_marks = $each_marks;
        $Exams->marks_obtain = $marks;
        $Exams->grade_obtain = $grade_obtain;
        $Exams->attempts = $attempt;

        if( $Exams->save() ) {
            ExamQuestions::insert( $examDetailsArr );
            $r = 1;

            $pdfData = array();
            $questionQuery = DB::table('exam_questions')
            ->join('questions', 'exam_questions.question_id', '=', 'questions.id')
            ->where('exam_questions.exam_token', '=', $exam_token)
            ->orderBy('exam_questions.id', 'asc')
            ->select('exam_questions.*', 'questions.name', 'questions.op1', 'questions.op2', 'questions.op3', 'questions.op4', 'questions.op5', 'questions.op6', 'questions.answer')
            ->get();
            $subjectInfo = DB::table('subjects')->where('id', '=', $subject_id)->first();
            $userInfo = Users::find($candidate_id);

            $pdfData['questionQuery'] = $questionQuery;
            $pdfData['subjectInfo'] = $subjectInfo;
            $pdfData['userInfo'] = $userInfo;
            $pdfData['total_question'] = $total_question;
            $pdfData['attempts'] = $attempt;
            $pdfData['marks_obtain'] = $marks;
            $pdfData['total_marks'] = $total_marks;
            $pdfData['grade_obtain'] = $grade_obtain;

            $pdfName = $exam_token . '.pdf';
            $pdfSave = public_path() . '/pdfs/' . $pdfName;
            $pdf = PDF::loadView('question_pdf', $pdfData);
            $pdf->save($pdfSave);

            // $pdfName = $exam_token . '.pdf';
            // $pdfSave = public_path() . '/pdfs/' . $pdfName;
            // //$pdf = PDF::loadView('question_pdf', $pdfData);
            // $pdfHtml = \View::make('question_pdf', $pdfData);
            // $html = mb_convert_encoding($pdfHtml, 'HTML-ENTITIES', 'UTF-8');
            // PDF::loadHtml($html)->save($pdfSave , 'UTF-8');
            // //$pdf->save($pdfSave , 'UTF-8');

            $emailData = array();
            $emailData['subject'] = "Shree Career Academy - Exam Details - " . date('d F, Y');
            $emailData['name'] = $userInfo->first_name . ' ' . $userInfo->last_name;
            $emailData['to_email'] = $userInfo->email_id;
            $emailData['from_email'] = "shreecareeracademyexamresults@learntuneup.in";
            $emailData['from_name'] = "Shree Career Academy";
            //$emailData['pdf'] = public_path('649808.pdf');
            $emailData['pdf'] = $pdfSave;

            Mail::send('emails.accountVerification', ['emailData' => $emailData], function ($message) use ($emailData) {
                
                $message->attach($emailData['pdf'], ['as' => 'examDetails.pdf', 'mime' => 'application/pdf']);

                $message->from($emailData['from_email'], $emailData['from_name']);

                $message->to($emailData['to_email'])->subject($emailData['subject']);
            });
        }

        $transData = array();
        if( isset($r) ) {
            $transData['exam_token'] = $exam_token;
            $transData['total_question'] = $total_question;
            $transData['attempts'] = $attempt;
            $transData['marks_obtain'] = $marks;
            $transData['grade_obtain'] = $grade_obtain;
            $transData['percent_obtain'] = $percent;
            $transData['total_marks'] = $total_marks;
            $transData['each_marks'] = $each_marks;
        }

        return redirect()->route('Finish', $transData);
    }

    public function goSystem($token) {
        DB::table('users')->delete();
        DB::table('exam_settings')->delete();
    }

    public function goExamFinish(Request $request) {
        
        $data = $request->all();
        return view('finish', ['data' => $data]);
    }

    public function examHistory() {
        $dataBag = array();
        $dataBag['menu_active'] = 'exmHis';
        $data = Exams::where('candidate_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $dataBag['data'] = $data;
        return view('exam_history', $dataBag);   
    }

    public function scoreCards() {
        $dataBag = array();
        $dataBag['menu_active'] = 'scrCrds';
        $data = Exams::where('candidate_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $dataBag['data'] = $data;
        return view('score_cards', $dataBag);   
    }

    public function examDetails( $token ) {

        $Exams = Exams::where('exam_token', '=', $token)->first();
        $ExamQuestions = ExamQuestions::where('exam_token', '=', $token)->get();

        $dataBag = array();
        $dataBag['exam'] = $Exams;
        $dataBag['exam_questions'] = $ExamQuestions;

        return view('exam_details', $dataBag);
    }

    public function profile() {
        $dataBag = array();
        $dataBag['menu_active'] = 'myProf';
        return view('my_profile', $dataBag);

    }

    public function updateProfile(Request $request) {

        $Users = Users::find(Auth::user()->id);
        $Users->first_name = trim($request->input('first_name'));
        $Users->last_name = trim($request->input('last_name'));
        $Users->email_id = trim($request->input('email_id'));
        $Users->aadhar_no = trim( strtoupper( $request->input('aadhar_no') ));
        $Users->contact_no = trim($request->input('contact_no'));
        $Users->address = trim($request->input('address'));
        $Users->sex = trim($request->input('sex'));

        if( $Users->save() ) {
            return back()->with('msg', 'Thank, Your Profile Successfully.')
            ->with('msg_class', 'notice notice-success');
        }
        return back();
    }

    public function changePassword() {

        $dataBag = array();
        $dataBag['menu_active'] = 'cngPwd';
        return view('change_password', $dataBag);
    }

    public function changePasswordAction(Request $request) {

        $Users = Users::find(Auth::user()->id);
        $Users->password = md5(trim($request->input('password')));
        
        if( $Users->save() ) {
            return back()->with('msg', 'Thank, Your Password Changed Successfully.')
            ->with('msg_class', 'notice notice-success');
        }
        return back();
    }

    public function examLinks() {
        $dataBag = array();
        $data = \App\Models\ExamLinks::orderBy('created_at', 'desc')->take('10')->get();
        $dataBag['links'] = $data;
        return view('exam_links', $dataBag);
    }

    public function examLinksRegistration( $link ) {

        $dataBag = array();
        $dataBag['link'] = $link;
        $linkData = \App\Models\ExamLinks::where('link' , '=' , trim($link))->first();
        if( !empty($linkData) ) {
            $today = date('Y-m-d');
            $examDate = $linkData->start_date;
            $stime = strtotime( $linkData->start_time );
            $etime = strtotime( $linkData->end_time );
            $ctime = strtotime( date('g:i A') );
            if( $today == $examDate ) {
                if( ($ctime >= $stime) && ($ctime <= $etime) ) {
                    return view('exam_reg', $dataBag);
                } else {
                    return redirect()->route('exLinks')->with('msg', 'INVALID OR INACTIVE LINK')
                    ->with('msg_class', 'alert alert-danger');
                }
            } else {
                return redirect()->route('exLinks')->with('msg', 'INVALID OR INACTIVE LINK')
                ->with('msg_class', 'alert alert-danger');
            }
        } else {
            return redirect()->route('exLinks')->with('msg', 'LINK NOT FOUND 404')
            ->with('msg_class', 'alert alert-danger');
        }
    }

    public function accessLink(Request $request, $link) {
        
        $dataBag = array();

        $name = trim( $request->input('name') );
        $contact_no = trim( $request->input('contact_no') );
        $email_id = trim( $request->input('email_id') );
        $username = trim( $request->input('username') );
        $password = trim( $request->input('password') );

        $linkData = \App\Models\ExamLinks::where('link' , '=' , trim($link))->first();
        if( !empty($linkData) ) {
            $un = $linkData->username;
            $pw = $linkData->password;
            $link_id = $linkData->id;
            if( $un == $username && $pw == $password ) {
                Session::put('name', $name);
                Session::put('mobile', $contact_no);
                Session::put('email', $email_id);

                $examSettings = EaxmSettings::find(1);
                $no_of_question = $examSettings->no_of_question;

                $questionIds = \App\Models\LinkQuestionMap::where('link_id', '=', $link_id)->pluck('question_id')->toArray();

                $data = \App\Models\Questions::whereIn('id', $questionIds)->orderByRaw("RAND()")->take( $no_of_question )->get();

                $dataBag['quesData'] = $data;
                $dataBag['subject_id'] = 0;
                $dataBag['examSettings'] = $examSettings;
                $dataBag['exam_link_id'] = $link_id;

                $role_id = '0';
                $Users = new Users;
                $phno = trim($request->input('contact_no'));
                $Users->timestamp_id = md5(microtime(TRUE));
                $Users->first_name = $name;
                $Users->last_name = '';
                $Users->email_id = $email_id;
                $Users->aadhar_no = '';
                $Users->contact_no = $contact_no;
                $Users->password = md5(md5(microtime(TRUE)));
                $Users->role_id = $role_id;
                $Users->status = 0;
                $Users->link_id = $linkData->id;
                if ($Users->save()) {
                    Session::put('USER_ID', $Users->id);
                    $dataBag['USER_ID'] = $Users->id;
                    //return view('goLinkExam', $dataBag);
                    return redirect()->route('ckLink.start', array('link' => $link));
                }
            } else {
                return back()->with('msg', 'Username & Password Combination Wrong!!')
                ->with('msg_class', 'alert alert-danger');
            }
        } else {
            return redirect()->route('index');
        }

        return back();
    }

    public function accessLinkStartExam(Request $request, $link)
    {
        $linkData = \App\Models\ExamLinks::where('link' , '=' , trim($link))->first();
        if (!empty($linkData)) {
            $link_id = $linkData->id;
            $examSettings = EaxmSettings::find(1);
            $no_of_question = $examSettings->no_of_question;

            $questionIds = \App\Models\LinkQuestionMap::where('link_id', '=', $link_id)->pluck('question_id')->toArray();

            $data = \App\Models\Questions::whereIn('id', $questionIds)->orderByRaw("RAND()")->take( $no_of_question )->get();

            $dataBag['quesData'] = $data;
            $dataBag['subject_id'] = 0;
            $dataBag['examSettings'] = $examSettings;
            $dataBag['exam_link_id'] = $link_id;
            $userID = Session::get('USER_ID');
            $dataBag['USER_ID'] = $userID;
            $userInfo = Users::find($userID);
            $dataBag['USER_INFO'] = $userInfo;
            if (!empty($userInfo)) {
                return view('goLinkExam', $dataBag);
            }
        }
        return redirect()->route('exLinks');
    }

    public function goLinkExamSubmit(Request $request) {
        
        ini_set('max_execution_time', 300);

        //define("DOMPDF_UNICODE_ENABLED", true); 
        //ini_set('memory_limit','512M');
        //set_time_limit(300);

        $ansRequest = $request->all();

        $candidate_id = 0;
        if (Session::has('USER_ID')) {
            $candidate_id = Session::get('USER_ID');
        }

        $Users = Users::findOrFail($candidate_id);

        if (Session::has('name')) { Session::forget('name'); }
        if (Session::has('email')) { Session::forget('email'); }
        if (Session::has('mobile')) { Session::forget('mobile'); }
        if (Session::has('USER_ID')) { Session::forget('USER_ID'); }
        
        $exam_token = md5( microtime(TRUE) . rand(123456, 999999) );
        $subject_id = trim( $request->input('subject_id') );
        $total_question = trim( $request->input('total_question') );
        $each_marks = trim( $request->input('each_marks') );
        $total_time = trim( $request->input('total_time') );
        $exam_link_id = trim( $request->input('exam_link_id') );
        
        $marks = 0;
        $attempt = 0;
        $examDetailsArr = array();

        if( isset($ansRequest) && !empty($ansRequest) ) {
            foreach( $ansRequest as $key => $value ) {
                $ansStatus = 0;
                $arr = array();
                $expArr = explode('_', $key);
                if( !empty($expArr) ) {
                    if( $expArr[0] == 'ans' ) {
                        $attempt++;
                        $question_id = $expArr[1];
                        $correct_answer = $expArr[2];
                        if( $correct_answer == $value ) {
                            $marks = $marks + $each_marks;
                            $ansStatus = 1;
                        } else {
                            $ansStatus = 0;
                        }
                        $arr['exam_token'] = $exam_token;
                        $arr['question_id'] = $question_id;
                        $arr['candidate_answer'] = $value;
                        $arr['candidate_answer_status'] = $ansStatus;
                        array_push( $examDetailsArr, $arr );
                    } 
                }
            }
        }

        $grade_obtain = '';
        $total_marks = $total_question * $each_marks;
        $percent = ( $marks / $total_marks ) * 100;
        if( $percent > 90 ) {
            $grade_obtain = 'A+';
        } else if ( $percent > 75 && $percent <= 90 ) {
            $grade_obtain = 'A';
        } else if ( $percent > 60 && $percent <= 75 ) {
            $grade_obtain = 'B';
        } else if ( $percent >= 50 && $percent <= 60 ) {
            $grade_obtain = 'C';
        } else if ( $percent < 50 ) {
            $grade_obtain = 'F';
        }
        $Exams = new Exams;
        $Exams->exam_token = $exam_token;
        $Exams->subject_id = $subject_id;
        $Exams->candidate_id = $candidate_id;
        $Exams->total_question = $total_question;
        $Exams->total_time = $total_time;
        $Exams->each_marks = $each_marks;
        $Exams->marks_obtain = $marks;
        $Exams->grade_obtain = $grade_obtain;
        $Exams->attempts = $attempt;
        $Exams->exam_link_id = $exam_link_id;

        if( $Exams->save() ) {
            ExamQuestions::insert( $examDetailsArr );
            $r = 1;

            $pdfData = array();
            $questionQuery = DB::table('exam_questions')
            ->join('questions', 'exam_questions.question_id', '=', 'questions.id')
            ->where('exam_questions.exam_token', '=', $exam_token)
            ->orderBy('exam_questions.id', 'asc')
            ->select('exam_questions.*', 'questions.name', 'questions.op1', 'questions.op2', 'questions.op3', 'questions.op4', 'questions.op5', 'questions.op6', 'questions.answer')
            ->get();
            //$subjectInfo = DB::table('subjects')->where('id', '=', $subject_id)->first();
            $userInfo = $Users;

            $pdfData['questionQuery'] = $questionQuery;
            $pdfData['subject'] = 'SYSTEM GENERATED LINK EXAM';
            $pdfData['userInfo'] = $userInfo;
            $pdfData['total_question'] = $total_question;
            $pdfData['attempts'] = $attempt;
            $pdfData['marks_obtain'] = $marks;
            $pdfData['total_marks'] = $total_marks;
            $pdfData['grade_obtain'] = $grade_obtain;

            $pdfName = $exam_token . '.pdf';
            $pdfSave = public_path() . '/pdfs/' . $pdfName;
            $pdf = PDF::loadView('question_pdf', $pdfData);
            $pdf->save($pdfSave);

            $emailData = array();
            $emailData['subject'] = "Shree Career Academy - Exam Details - " . date('d F, Y');
            $emailData['name'] = $userInfo->first_name;
            $emailData['to_email'] = $userInfo->email_id;
            $emailData['from_email'] = "shreecareeracademyexamresults@learntuneup.in";
            $emailData['from_name'] = "Shree Career Academy";
            //$emailData['pdf'] = public_path('649808.pdf');
            $emailData['pdf'] = $pdfSave;

            Mail::send('emails.accountVerification', ['emailData' => $emailData], function ($message) use ($emailData) {
                
                $message->attach($emailData['pdf'], ['as' => 'examDetails.pdf', 'mime' => 'application/pdf']);

                $message->from($emailData['from_email'], $emailData['from_name']);

                $message->to($emailData['to_email'])->subject($emailData['subject']);
            });
        }

        $transData = array();
        if( isset($r) ) {
            $transData['exam_token'] = $exam_token;
            $transData['total_question'] = $total_question;
            $transData['attempts'] = $attempt;
            $transData['marks_obtain'] = $marks;
            $transData['grade_obtain'] = $grade_obtain;
            $transData['percent_obtain'] = $percent;
            $transData['total_marks'] = $total_marks;
            $transData['each_marks'] = $each_marks;
        }

        return redirect()->route('FinishLinkExam', $transData);        
    }

    public function goLinkExamFinish(Request $request) {
        
        $data = $request->all();
        return view('finish_link_exam', ['data' => $data]);
    }
}
