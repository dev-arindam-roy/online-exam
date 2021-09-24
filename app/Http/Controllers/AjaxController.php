<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CmsLinks;
use Image;
use Auth;
use DB;

class AjaxController extends Controller
{
    
    public function checkSlugUrl(Request $request) {

        $slug_url = trim( $request->input('slug_url') );
        $table_id = trim( $request->input('id') );
        $ck = CmsLinks::where('slug_url', '=', $slug_url)->where('table_id', '!=', $table_id)->count();
        if( $ck > 0 ) {
            return "false";
        } else {
            return "true";
        }
    }
}
