<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSettings;
use Image;
use Auth;
use DB;

class SettingsController extends Controller
{
    public function generalSettings() {

    	$dataBag = array();
    	$dataBag['parentMenu'] = "settings";
    	$dataBag['childMenu'] = "genSett";
    	$dataBag['settings'] = GeneralSettings::where('id', '=', '1')->first();

    	return view('dashboard.settings.general_settings', $dataBag);
    }

    public function saveGeneralSettings(Request $request) {

    	$isExist = GeneralSettings::where('id', '=', '1')->first();
    	if( empty($isExist) ) {
	    	$GeneralSettings = new GeneralSettings;
	    	$GeneralSettings->site_name = trim($request->input('site_name'));
	    	$GeneralSettings->site_tagline = trim($request->input('site_tagline'));
	    	$GeneralSettings->site_description = trim($request->input('site_description'));
	    	$GeneralSettings->site_footer_text = trim($request->input('site_footer_text'));

	    	if( $request->hasFile('site_logo') ) {

	    		$site_logo = $request->file('site_logo');
	    		$real_path = $site_logo->getRealPath();
	            $file_orgname = $site_logo->getClientOriginalName();
	            $file_size = $site_logo->getClientSize();
	            $file_ext = strtolower($site_logo->getClientOriginalExtension());
	            $file_newname = "site_logo"."_".time().".".$file_ext;

	            $destinationPath = public_path('/uploads/site_logo');
	            $original_path = $destinationPath."/original";
	            $thumb_path = $destinationPath."/thumb";
	            
	            $img = Image::make($real_path);
	        	$img->resize(150, 150, function ($constraint) {
			    	$constraint->aspectRatio();
				})->save($thumb_path.'/'.$file_newname);

	        	$site_logo->move($original_path, $file_newname);
	        	$GeneralSettings->site_logo = $file_newname;
	    	}

	    	if( $request->hasFile('site_favicon') ) {
	    		
	    		$site_favicon = $request->file('site_favicon');
	    		$real_path = $site_favicon->getRealPath();
	            $file_orgname = $site_favicon->getClientOriginalName();
	            $file_size = $site_favicon->getClientSize();
	            $file_ext = strtolower($site_favicon->getClientOriginalExtension());
	            $file_newname = "site_favicon"."_".time().".".$file_ext;

	            $destinationPath = public_path('/uploads/site_favicon');
	            $original_path = $destinationPath."/original";
	            $resize_path = $destinationPath."/24_24";
	            
	            $img = Image::make($real_path);
	        	$img->resize(24, 24, function ($constraint) {
			    	$constraint->aspectRatio();
				})->save($resize_path.'/'.$file_newname);

	        	$site_favicon->move($original_path, $file_newname);
	        	$GeneralSettings->site_favicon = $file_newname;
	    	}

	    	$GeneralSettings->created_by = 0;

	    	$res = $GeneralSettings->save();
	    	if( $res ) {
	    		return back()->with('msg_class', 'alert alert-success')
	    		->with('msg', 'General Settings Saved Successfully.');
	    	} else {
	    		return back()->with('msg_class', 'alert alert-danger')
	    		->with('msg', 'Something Went Wrong!!!');
	    	}
    	} else {
    		$updateData = array();
    		$updateData['site_name'] = trim($request->input('site_name'));
	    	$updateData['site_tagline'] = trim($request->input('site_tagline'));
	    	$updateData['site_description'] = trim($request->input('site_description'));
	    	$updateData['site_footer_text'] = trim($request->input('site_footer_text'));

	    	if( $request->hasFile('site_logo') ) {

	    		$site_logo = $request->file('site_logo');
	    		$real_path = $site_logo->getRealPath();
	            $file_orgname = $site_logo->getClientOriginalName();
	            $file_size = $site_logo->getClientSize();
	            $file_ext = strtolower($site_logo->getClientOriginalExtension());
	            $file_newname = "site_logo"."_".time().".".$file_ext;

	            $destinationPath = public_path('/uploads/site_logo');
	            $original_path = $destinationPath."/original";
	            $thumb_path = $destinationPath."/thumb";
	            
	            $img = Image::make($real_path);
	        	$img->resize(150, 150, function ($constraint) {
			    	$constraint->aspectRatio();
				})->save($thumb_path.'/'.$file_newname);

	        	$site_logo->move($original_path, $file_newname);
	        	$updateData['site_logo'] = $file_newname;
	    	}

	    	if( $request->hasFile('site_favicon') ) {
	    		
	    		$site_favicon = $request->file('site_favicon');
	    		$real_path = $site_favicon->getRealPath();
	            $file_orgname = $site_favicon->getClientOriginalName();
	            $file_size = $site_favicon->getClientSize();
	            $file_ext = strtolower($site_favicon->getClientOriginalExtension());
	            $file_newname = "site_favicon"."_".time().".".$file_ext;

	            $destinationPath = public_path('/uploads/site_favicon');
	            $original_path = $destinationPath."/original";
	            $resize_path = $destinationPath."/24_24";
	            
	            $img = Image::make($real_path);
	        	$img->resize(24, 24, function ($constraint) {
			    	$constraint->aspectRatio();
				})->save($resize_path.'/'.$file_newname);

	        	$site_favicon->move($original_path, $file_newname);
	        	$updateData['site_favicon'] = $file_newname;
	    	}

	    	$updateData['updated_by'] = 0;
	    	$updateData['updated_at'] = date('Y-m-d H:i:s');

	    	$res = GeneralSettings::where('id', '=', '1')->update($updateData);
	    	if( $res ) {
	    		return back()->with('msg_class', 'alert alert-success')
	    		->with('msg', 'General Settings All Changes Saved Successfully.');
	    	} else {
	    		return back()->with('msg_class', 'alert alert-danger')
	    		->with('msg', 'Something Went Wrong!!!');
	    	}
    	}
    }
}
