<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Image;
use Auth;
use DB;

class UserController extends Controller
{
    
    public function index() {
    	$dataBag = array();
    	$dataBag['parentMenu'] = 'userManagement';
    	$dataBag['childMenu'] = 'usersList';
    	$dataBag['userList'] = Users::where('status', '!=', '3')->orderBy('first_name', 'asc')->paginate( 30 );
    	return view('dashboard.users.index', $dataBag);
    }

    public function createUser() {
    	$dataBag = array();
    	$dataBag['parentMenu'] = 'userManagement';
    	$dataBag['childMenu'] = 'createUser';
    	$dataBag['roles'] = DB::table('roles')->where('status', '=', '1')
    	->orderBy('role_name', 'asc')->get();
    	return view('dashboard.users.create', $dataBag);	
    }

    public function saveUser(Request $request) {

    	$request->validate([
			
            'email_id' => 'required|email|unique:users,email_id'
		],[
		
			'email_id.unique' => 'This Email-id Already Exist, Try Another.'
		]);

    	$Users = new Users;
    	$Users->timestamp_id = md5(microtime(TRUE));
    	$Users->first_name = trim($request->input('first_name'));
    	$Users->last_name = trim($request->input('last_name'));
    	$Users->email_id = trim($request->input('email_id'));
    	$Users->contact_no = trim($request->input('contact_no'));
    	$Users->password = md5(trim($request->input('password')));
    	$Users->role_id = trim($request->input('role_id'));
        $Users->created_by = Auth::user()->id;
    	$res = $Users->save();

    	if( $res ) {
    		return back()->with('msg_class', 'alert alert-success')
    		->with('msg', 'New User Created Succesfully.');
    	} else {
    		return back()->with('msg_class', 'alert alert-danger')
    		->with('msg', 'Something Went Wrong.');
    	}
    }

    public function editUser($user_timestamp_id) {
    	$dataBag = array();
    	$dataBag['parentMenu'] = 'userManagement';
    	$dataBag['roles'] = DB::table('roles')->where('status', '=', '1')
    	->orderBy('role_name', 'asc')->get();
    	$dataBag['user_data'] = Users::where('timestamp_id', '=', $user_timestamp_id)->first();
    	return view('dashboard.users.edit', $dataBag);
    }

    public function updateUser(Request $request, $user_timestamp_id) {

    	$ck = Users::where('timestamp_id', '=', $user_timestamp_id)->first();
    	if( !empty($ck) ) {

            $request->validate([
            
            'email_id' => 'required|email|unique:users,email_id,'.$ck->id
            ],[
            
                'email_id.unique' => 'This Email-id Already Exist, Try Another.'
            ]);

    		$updateData = array();
    		$updateData['first_name'] = trim($request->input('first_name'));
    		$updateData['last_name'] = trim($request->input('last_name'));
    		$updateData['email_id'] = trim($request->input('email_id'));
    		$updateData['contact_no'] = trim($request->input('contact_no'));
    		$updateData['sex'] = trim($request->input('sex'));
    		$updateData['address'] = trim($request->input('address'));
    		$updateData['role_id'] = trim($request->input('role_id'));
    		$updateData['status'] = trim($request->input('status'));
    		$updateData['updated_by'] = Auth::user()->id;
    		$updateData['updated_at'] = date('Y-m-d H:i:s');
    		if( $request->hasFile('image') ) {

	    		$image = $request->file('image');
	    		$real_path = $image->getRealPath();
	            $file_orgname = $image->getClientOriginalName();
	            $file_size = $image->getClientSize();
	            $file_ext = strtolower($image->getClientOriginalExtension());
	            $file_newname = "user"."_".time().".".$file_ext;

	            $destinationPath = public_path('/uploads/user_images');
	            $original_path = $destinationPath."/original";
	            $thumb_path = $destinationPath."/thumb";
	            
	            $img = Image::make($real_path);
	        	$img->resize(150, 150, function ($constraint) {
			    	$constraint->aspectRatio();
				})->save($thumb_path.'/'.$file_newname);

	        	$image->move($original_path, $file_newname);
	        	$updateData['image'] = $file_newname;
	    	}
	    	$res = Users::where('timestamp_id', '=', $user_timestamp_id)->update($updateData);
	    	if( $res ) {
	    		return back()->with('msg_class', 'alert alert-success')
    			->with('msg', 'User Updated Succesfully.');
	    	} else {
	    		return back()->with('msg_class', 'alert alert-danger')
    			->with('msg', 'Something Went Wrong.');
	    	}
    	} else {
    		return back()->with('msg_class', 'alert alert-danger')
    		->with('msg', 'Something Went Wrong. User Missmatch');
    	}
    }

    public function resetPassword( $user_timestamp_id ) {
    	$dataBag = array();
    	$dataBag['parentMenu'] = 'userManagement';
    	$dataBag['user_data'] = Users::where('timestamp_id', '=', $user_timestamp_id)->first();
    	return view('dashboard.users.reset_password', $dataBag);
    }

    public function updatePassword(Request $request, $user_timestamp_id) {

    	$ck = Users::where('timestamp_id', '=', $user_timestamp_id)->first();
    	if( !empty($ck) ) {
    		$updateData = array();
    		$updateData['password'] = md5(trim($request->input('password')));
    		$res = Users::where('timestamp_id', '=', $user_timestamp_id)->update($updateData);
	    	if( $res ) {
	    		return back()->with('msg_class', 'alert alert-success')
    			->with('msg', 'User Password Updated Succesfully.');
	    	} else {
	    		return back()->with('msg_class', 'alert alert-danger')
    			->with('msg', 'Something Went Wrong.');
	    	}
    	} else {
    		return back()->with('msg_class', 'alert alert-danger')
    		->with('msg', 'Something Went Wrong. User Missmatch');
    	}
    }

    public function deleteUser( $user_timestamp_id ) {

    	$res = Users::where('timestamp_id', '=', $user_timestamp_id)->update(['status' => '3']);
    	if( $res ) {
    		return back()->with('msg_class', 'alert alert-success')
			->with('msg', 'User Deleted Succesfully.');
    	} else {
    		return back()->with('msg_class', 'alert alert-danger')
			->with('msg', 'Something Went Wrong.');
    	}
    }

    public function profile() {
        $dataBag = array();
        $dataBag['parentMenu'] = 'settings';
        $dataBag['childMenu'] = 'profile';
        return view('dashboard.users.profile', $dataBag);
    }

    public function profileUpdate(Request $request) {

        $user_id = Auth::user()->id;
        $request->validate([
            
        'email_id' => 'required|email|unique:users,email_id,'.$user_id
        ],[
        
            'email_id.unique' => 'This Email-id Already Exist, Try Another.'
        ]);

        $updateData = array();
        $updateData['first_name'] = trim($request->input('first_name'));
        $updateData['last_name'] = trim($request->input('last_name'));
        $updateData['email_id'] = trim($request->input('email_id'));
        $updateData['contact_no'] = trim($request->input('contact_no'));
        $updateData['sex'] = trim($request->input('sex'));
        $updateData['address'] = trim($request->input('address'));
        $updateData['updated_by'] = $user_id;
        $updateData['updated_at'] = date('Y-m-d H:i:s');
        if( $request->hasFile('image') ) {

            $image = $request->file('image');
            $real_path = $image->getRealPath();
            $file_orgname = $image->getClientOriginalName();
            $file_size = $image->getClientSize();
            $file_ext = strtolower($image->getClientOriginalExtension());
            $file_newname = "user"."_".time().".".$file_ext;

            $destinationPath = public_path('/uploads/user_images');
            $original_path = $destinationPath."/original";
            $thumb_path = $destinationPath."/thumb";
            
            $img = Image::make($real_path);
            $img->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumb_path.'/'.$file_newname);

            $image->move($original_path, $file_newname);
            $updateData['image'] = $file_newname;
        }
        $res = Users::where('id', '=', $user_id)->update($updateData);
        if( $res ) {
            return back()->with('msg_class', 'alert alert-success')
            ->with('msg', 'Profile Updated Succesfully.');
        } else {
            return back()->with('msg_class', 'alert alert-danger')
            ->with('msg', 'Something Went Wrong.');
        }
    }

    public function changePassword() {
        $dataBag = array();
        $dataBag['parentMenu'] = 'settings';
        $dataBag['childMenu'] = 'cngPwd';
        return view('dashboard.users.change_password', $dataBag);
    }

    public function changePasswordSave(Request $request) {

        $current_password = md5(trim($request->input('current_password')));
        $new_password = md5(trim($request->input('new_password')));
        $ck = Users::where('id', '=', Auth::user()->id)
        ->where('password', '=', $current_password)->first();
        if( !empty($ck) ) {
            $res = Users::where('id', '=', Auth::user()->id)->update(['password' => $new_password]);
            if( $res ) {
                return back()->with('msg_class', 'alert alert-success')
                ->with('msg', 'Password Changed Succesfully.');
            } else {
                return back()->with('msg_class', 'alert alert-danger')
                ->with('msg', 'Something Went Wrong.');
            }
        } else {
            return back()->with('msg_class', 'alert alert-danger')
            ->with('msg', 'Current Password Not Match.');
        }
    }
}
