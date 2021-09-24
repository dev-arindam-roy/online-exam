<?php

function getGeneralSettings() {
	$arr = DB::table('general_settings')->where('id', '=', '1')->first();
	return $arr;
}

function getAllParentEventsByCategory($category_id) {
	$arr = array();
	if( $category_id != '' && $category_id != null) {
		$arr = DB::table('event_category_map as ecm')->where('ecm.event_category_id', '=', $category_id)
		->join('events', 'events.id', '=', 'ecm.event_id')->where('events.parent_event_id', '=', '0')
		->where('events.status', '!=', '3')->get();
	}
	return $arr;
}

function sizeFilter( $bytes ) {
	if( $bytes != '' && $bytes != null ) {
    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
    return( round( $bytes, 2 ) . " " . $label[$i] );
	} else {
		return "0";
	}
}

function fileInfo( $fileId ) {
	$dataArr = array();
	if( $fileId != null && $fileId != '' ) {
		$dataArr = DB::table('files_master')->where('id', '=', $fileId)->first();
	}
	return $dataArr;
}

function imageInfo( $imgId ) {
	$dataArr = array();
	if( $imgId != null && $imgId != '' ) {
		$dataArr = DB::table('image')->where('id', '=', $imgId)->first();
	}
	return $dataArr;
}

function isAddToLink ( $link_id , $question_id ) {

	if( $link_id != '' && $question_id != '' ) {

		$ck = DB::table('link_question_map')->where('link_id', '=', $link_id)->where('question_id', '=', $question_id)->first();
		if( !empty( $ck ) ) {
			return true;
		} else {
			return false;
		}
	}

	return false;
}

function linkQuestionCount ( $link_id ) {

	if( $link_id != '' ) {
		$c = DB::table('link_question_map')->where('link_id', '=', $link_id)->count();
		return $c;
	}

	return 0;
}

function isTimeExpire( $link_id ) {

	if( $link_id != '' ) {

		$data = DB::table('links')->where('id', '=', $link_id)->first();

		if( !empty($data) ) {
			$stime = strtotime( $data->start_time );
			$etime = strtotime( $data->end_time );
		}
	}
}
?>