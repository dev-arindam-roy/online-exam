<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Languages;
use App\Models\Subjects;
use App\Models\Questions;
use App\Models\EaxmSettings;
use App\Models\ExamLinks;
use App\Models\LinkQuestionMap;
use App\Models\Users;
use Image;
use Auth;
use DB;

class QuestionController extends Controller
{
    public function index() {

    	$dataBag = array();
    	$dataBag['parentMenu'] = "questM";
    	$dataBag['childMenu'] = "allSub";
    	$dataBag['allSubs'] = Subjects::with('languageInfo')->where('status', '!=', '3')->orderBy('created_at', 'desc')->get();
    	return view('dashboard.subjects.index', $dataBag);
    }

    public function addSubject() {

    	$dataBag = array();
    	$dataBag['parentMenu'] = "questM";
    	$dataBag['childMenu'] = "addSub";
    	$dataBag['languages'] = Languages::where('status', '=', '1')->orderBy('name', 'asc')->get();
    	return view('dashboard.subjects.create', $dataBag);
    }

    public function saveSubject(Request $request) {

    	$Subjects = new Subjects;
    	$Subjects->language_id = trim( $request->input('language_id') );
    	$Subjects->name = htmlentities( trim( $request->input('name') ), ENT_QUOTES);
    	$Subjects->description = htmlentities( trim( $request->input('description') ), ENT_QUOTES);
    	$Subjects->status = trim( $request->input('status') );

    	if( $Subjects->save() ) {

    		return back()->with('msg_class', 'alert alert-success')->with('msg', 'Subject Added Successfully.');
    	}
    	return back()->with('msg_class', 'alert alert-danger')->with('msg', 'Something Went Wrong.');
    }

    public function editSubject($sub_id) {

    	$dataBag = array();
    	$dataBag['parentMenu'] = "questM";
    	$dataBag['childMenu'] = "addSub";
    	$dataBag['subject'] = Subjects::findOrFail($sub_id);
    	$dataBag['languages'] = Languages::where('status', '=', '1')->orderBy('name', 'asc')->get();
    	return view('dashboard.subjects.create', $dataBag);
    }

    public function updateSubject(Request $request, $sub_id) {

    	$Subjects = Subjects::find($sub_id);
    	$Subjects->language_id = trim( $request->input('language_id') );
    	$Subjects->name = htmlentities( trim( $request->input('name') ), ENT_QUOTES);
    	$Subjects->description = htmlentities( trim( $request->input('description') ), ENT_QUOTES);
    	$Subjects->status = trim( $request->input('status') );

    	if( $Subjects->save() ) {

    		return back()->with('msg_class', 'alert alert-success')->with('msg', 'Subject Updated Successfully.');
    	}
    	return back()->with('msg_class', 'alert alert-danger')->with('msg', 'Something Went Wrong.');	
    }

    public function deleteSubject($sub_id) {

    	$ck = Subjects::findOrFail($sub_id);
    	$ck->status = '3';
    	if( $ck->save() ) {
    		return back()->with('msg_class', 'alert alert-success')->with('msg', 'Subject Deleted Successfully.');	
    	}
    	return back()->with('msg_class', 'alert alert-danger')->with('msg', 'Something Went Wrong.');
    }

    public function allQuestions() {

    	$dataBag = array();
    	$dataBag['parentMenu'] = "questM";
    	$dataBag['childMenu'] = "allQues";
    	$dataBag['allQues'] = Questions::where('status', '!=', '3')->orderBy('created_at', 'desc')->paginate( 25 );
    	return view('dashboard.questions.index', $dataBag);	
    }

    public function addQuestion() {

    	$dataBag = array();
    	$dataBag['parentMenu'] = "questM";
    	$dataBag['childMenu'] = "addQues";
    	$dataBag['languages'] = Languages::where('status', '=', '1')->orderBy('name', 'asc')->get();
    	$dataBag['subjects'] = Subjects::where('status', '=', '1')->orderBy('name', 'asc')->get();
    	return view('dashboard.questions.create', $dataBag);
    }

    public function saveQuestion(Request $request) {

    	$Questions = new Questions;

    	$language_id = trim( $request->input('language_id') );
    	$subject_id = trim( $request->input('subject_id') );
    	$is_image = 0;

    	$Questions->language_id = $language_id;
    	$Questions->subject_id = $subject_id;
    	$Questions->name = htmlentities( trim( $request->input('name') ), ENT_QUOTES);
    	$Questions->op1 = htmlentities( trim( $request->input('op1') ), ENT_QUOTES);
    	$Questions->op2 = htmlentities( trim( $request->input('op2') ), ENT_QUOTES);
    	$Questions->op3 = htmlentities( trim( $request->input('op3') ), ENT_QUOTES);
    	$Questions->op4 = htmlentities( trim( $request->input('op4') ), ENT_QUOTES);
    	$Questions->op5 = htmlentities( trim( $request->input('op5') ), ENT_QUOTES);
    	$Questions->op6 = htmlentities( trim( $request->input('op6') ), ENT_QUOTES);
    	$Questions->answer = trim( $request->input('answer') );
    	$Questions->status = trim( $request->input('status') );
    	
    	if( $request->has('is_image') && $request->input('is_image') == '1' ) {
    		$is_image = 1;
    	}
    	
    	$Questions->is_image = $is_image;

    	if( $request->hasFile('image') ) {
    		$image = $request->file('image');
    		$real_path = $image->getRealPath();
            $file_orgname = $image->getClientOriginalName();
            $file_size = $image->getClientSize();
            $file_ext = strtolower($image->getClientOriginalExtension());
            $file_newname = "image"."_".time().".".$file_ext;

            $destinationPath = public_path('/uploads/question_images');
            $thumb_path = $destinationPath."/thumb";
            
            $img = Image::make($real_path);
        	$img->resize(200, 150, function ($constraint) {
		    	$constraint->aspectRatio();
			})->save($thumb_path.'/'.$file_newname);

        	$image->move($destinationPath, $file_newname);
        	$Questions->image = $file_newname;
    	}

    	if( $Questions->save() ) {

    		$url = route('add_ques').'?lng='.base64_encode($language_id).'&sub='.base64_encode($subject_id);
    		
    		return redirect($url)->with('msg_class', 'alert alert-success')->with('msg', 'Question Added Successfully.');	
    	}
    	return back()->with('msg_class', 'alert alert-danger')->with('msg', 'Something Went Wrong.');
    }

    public function editQuestion($ques_id) {

    	$dataBag = array();
    	$dataBag['parentMenu'] = "questM";
    	$dataBag['childMenu'] = "addQues";
    	$dataBag['question'] = Questions::findOrFail($ques_id);
    	$dataBag['languages'] = Languages::where('status', '=', '1')->orderBy('name', 'asc')->get();
    	$dataBag['subjects'] = Subjects::where('status', '=', '1')->orderBy('name', 'asc')->get();
    	return view('dashboard.questions.create', $dataBag);	
    }

    public function updateQuestion(Request $request, $ques_id) {

    	$is_image = 0;
    	
    	$Questions = Questions::find($ques_id);
    	$Questions->language_id = trim( $request->input('language_id') );
    	$Questions->subject_id = trim( $request->input('subject_id') );
    	$Questions->name = htmlentities( trim( $request->input('name') ), ENT_QUOTES);
    	$Questions->op1 = htmlentities( trim( $request->input('op1') ), ENT_QUOTES);
    	$Questions->op2 = htmlentities( trim( $request->input('op2') ), ENT_QUOTES);
    	$Questions->op3 = htmlentities( trim( $request->input('op3') ), ENT_QUOTES);
    	$Questions->op4 = htmlentities( trim( $request->input('op4') ), ENT_QUOTES);
    	$Questions->op5 = htmlentities( trim( $request->input('op5') ), ENT_QUOTES);
    	$Questions->op6 = htmlentities( trim( $request->input('op6') ), ENT_QUOTES);
    	$Questions->answer = trim( $request->input('answer') );
    	$Questions->status = trim( $request->input('status') );

    	if( $request->has('is_image') && $request->input('is_image') == '1' ) {
    		$is_image = 1;
    	}
    	
    	$Questions->is_image = $is_image;

    	if( $request->hasFile('image') ) {
    		$image = $request->file('image');
    		$real_path = $image->getRealPath();
            $file_orgname = $image->getClientOriginalName();
            $file_size = $image->getClientSize();
            $file_ext = strtolower($image->getClientOriginalExtension());
            $file_newname = "image"."_".time().".".$file_ext;

            $destinationPath = public_path('/uploads/question_images');
            $thumb_path = $destinationPath."/thumb";
            
            $img = Image::make($real_path);
        	$img->resize(200, 150, function ($constraint) {
		    	$constraint->aspectRatio();
			})->save($thumb_path.'/'.$file_newname);

        	$image->move($destinationPath, $file_newname);
        	$Questions->image = $file_newname;
    	}

    	if( $Questions->save() ) {
    		return back()->with('msg_class', 'alert alert-success')->with('msg', 'Question Updated Successfully.');	
    	}
    	return back()->with('msg_class', 'alert alert-danger')->with('msg', 'Something Went Wrong.');	
    }

    public function deleteQuestion($ques_id) {

    	$ck = Questions::findOrFail($ques_id);
    	$ck->status = '3';
    	if( $ck->save() ) {
    		return back()->with('msg_class', 'alert alert-success')->with('msg', 'Question Deleted Successfully.');	
    	}
    	return back()->with('msg_class', 'alert alert-danger')->with('msg', 'Something Went Wrong.');	
    }

    public function examSettings() {
        $dataBag = array();
        $dataBag['parentMenu'] = "questM";
        $dataBag['childMenu'] = "settQues";
        $dataBag['settings'] = EaxmSettings::first();
        return view('dashboard.questions.settings', $dataBag);
    }

    public function examSettingsSave(Request $request) {

        $EaxmSettings = EaxmSettings::find(1);
        $EaxmSettings->no_of_question = trim( $request->input('no_of_question') );
        $EaxmSettings->each_marks = trim( $request->input('each_marks') );
        $EaxmSettings->total_time = trim( $request->input('total_time') );
        if( $EaxmSettings->save() ) {
            return back()->with('msg', 'Settings Saved')->with('msg_class', 'alert alert-success');
        }
        return back();
    }

    public function links() {
        $dataBag = array();
        $dataBag['parentMenu'] = "quesLink";
        $dataBag['childMenu'] = "allLinks";
        $dataBag['allLinks'] = ExamLinks::orderBy('created_at', 'desc')->get();
        return view('dashboard.question_links.index', $dataBag);
    }

    public function addLinks() {
        $dataBag = array();
        $dataBag['parentMenu'] = "quesLink";
        $dataBag['childMenu'] = "addLink";
        return view('dashboard.question_links.add', $dataBag);   
    }

    public function saveLinks(Request $request) {

        $ExamLinks = new ExamLinks;
        $ExamLinks->link = trim( $request->input('link') );
        $ExamLinks->username = trim( $request->input('username') );
        $ExamLinks->password = trim( $request->input('password') );
        $ExamLinks->start_date = date( 'Y-m-d', strtotime(trim($request->input('start_date'))) );
        $ExamLinks->start_time = date( 'H:i:s', strtotime(trim($request->input('start_time'))) );
        $ExamLinks->end_time = date( 'H:i:s', strtotime(trim($request->input('end_time'))) );
        if( $ExamLinks->save() ) {
            return back()->with('msg', 'Exam Link Created Successfully')->with('msg_class', 'alert alert-success');
        }
        return back();
    }

    public function deleteLink($id) {

        $r = ExamLinks::findOrFail($id)->delete();

        if( $r ){
            LinkQuestionMap::where('link_id', '=', $id)->delete();
            return back()->with('msg', 'Exam Link Deleted Successfully')->with('msg_class', 'alert alert-success');   
        }
        return back();
    }

    public function editLink($id) {
        $dataBag = array();
        $dataBag['parentMenu'] = "quesLink";
        $dataBag['childMenu'] = "addLink";
        $dataBag['link'] = ExamLinks::findOrFail($id);
        return view('dashboard.question_links.add', $dataBag);   
    }

    public function updateLink(Request $request, $id) {
        $ExamLinks = ExamLinks::findOrFail( $id );
        $ExamLinks->username = trim( $request->input('username') );
        $ExamLinks->password = trim( $request->input('password') );
        $ExamLinks->start_date = date( 'Y-m-d', strtotime(trim($request->input('start_date'))) );
        $ExamLinks->start_time = date( 'H:i:s', strtotime(trim($request->input('start_time'))) );
        $ExamLinks->end_time = date( 'H:i:s', strtotime(trim($request->input('end_time'))) );
        if( $ExamLinks->save() ) {
            return back()->with('msg', 'Exam Link Updated Successfully')->with('msg_class', 'alert alert-success');
        }
        return back();   
    }

    public function addEditQuestion( $link_id ) {

        if( $link_id != '' && $link_id != null ) {
            
            $dataBag = array();
            $dataBag['parentMenu'] = "quesLink";
            $dataBag['childMenu'] = "allQuesx";
            $dataBag['addToLink'] = "OK";
            $dataBag['link_id'] = $link_id;
            $dataBag['allQues'] = Questions::where('status', '!=', '3')->orderBy('created_at', 'desc')->paginate( 25 );
            $dataBag['total_question'] = LinkQuestionMap::where('link_id', '=', $link_id)->count();
            return view('dashboard.questions.index', $dataBag);            
        } else {
            abort( 404 );
            return redirect()->route('links')->with('msg', 'Something Went Wrong!')->with('msg_class', 'alert alert-danger');
        }
    }

    public function SaveAddEditQuestion( Request $request, $link_id ) {
        $insArr = array();
        if( $request->has('quesIds') && !empty( $request->input('quesIds') ) ) {

            $action_btn = trim( $request->input('action_btn') );

            if( $action_btn == 'add' ) {
                $ckArr = LinkQuestionMap::where( 'link_id', '=', $link_id )->get()->pluck('question_id')->toArray();
                foreach( $request->input('quesIds') as $k => $v ) {
                    if( ! in_array( $v, $ckArr ) ) {
                        $arr = array();
                        $arr['link_id'] = $link_id;
                        $arr['question_id'] = $v;
                        array_push( $insArr, $arr );
                    }
                }
                if( !empty($insArr) ) {
                    LinkQuestionMap::insert( $insArr );
                }
            }

            if( $action_btn == 'remove' ) {
                foreach( $request->input('quesIds') as $k => $v ) {
                    LinkQuestionMap::where('link_id', '=', $link_id)->where('question_id', '=', $v)->delete();
                }
            }
        } else { 
            return back()->with('msg', 'Please Select Questions')->with('msg_class', 'alert alert-danger');            
        }

        return back()->with('msg', 'Question List Updated Successfully')->with('msg_class', 'alert alert-success');
    }

    public function viewLinkCandidates( $link_id ) {

        $dataBag = array();
        $dataBag['parentMenu'] = "quesLink";
        $linkInfo = \App\Models\ExamLinks::findOrFail( $link_id );
        $candidateExamInfo = \App\Models\Exams::with(['userInfo'])->where('exam_link_id', '=', $link_id)
        ->orderBy('created_at', 'desc')->get();

        $dataBag['linkInfo'] = $linkInfo;
        $dataBag['candidateExamInfo'] = $candidateExamInfo;
        return view('dashboard.question_links.candidate', $dataBag);
    }

    public function runningCandidates($id)
    {
        $dataBag = array();
        $dataBag['parentMenu'] = "quesLink";
        $dataBag['childMenu'] = "allLinks";
        $dataBag['link_id'] = $id;
        $dataBag['userList'] = Users::where('link_id', '=', $id)
        ->orderBy('created_at', 'desc')->get();
        return view('dashboard.question_links.running_candidates', $dataBag);
    }

    public function runningCandidatesDel($link_id, $user_id)
    {
        Users::where('id', '=', $user_id)->where('link_id', '=', $link_id)->delete();
        return back()->with('msg', 'Candidate Deleted')->with('msg_class', 'alert alert-danger');            
    }

    public function isLiveCandidate(Request $request)
    {
        $user_id = trim($request->input('user_id'));
        $ck = Users::find($user_id);
        if (empty($ck)) {
            return 1;
        }
        return 0;
    }
}
