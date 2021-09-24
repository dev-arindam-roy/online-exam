@extends('app')

@push('page_css')
<style type="text/css">
.tabs-left, .tabs-right {
  border-bottom: none;
  padding-top: 2px;
}
.tabs-left {
  border-right: 1px solid #ddd;
}
.tabs-right {
  border-left: 1px solid #ddd;
}
.tabs-left>li, .tabs-right>li {
  float: none;
  margin-bottom: 2px;
}
.tabs-left>li {
  margin-right: -1px;
}
.tabs-right>li {
  margin-left: -1px;
}
.tabs-left>li.active>a,
.tabs-left>li.active>a:hover,
.tabs-left>li.active>a:focus {
  border-bottom-color: #ddd;
  border-right-color: transparent;
}

.tabs-right>li.active>a,
.tabs-right>li.active>a:hover,
.tabs-right>li.active>a:focus {
  border-bottom: 1px solid #ddd;
  border-left-color: transparent;
}
.tabs-left>li>a {
  border-radius: 4px 0 0 4px;
  margin-right: 0;
  display:block;
}
.tabs-right>li>a {
  border-radius: 0 4px 4px 0;
  margin-right: 0;
}
.vertical-text {
  margin-top:50px;
  border: none;
  position: relative;
}
.vertical-text>li {
  height: 20px;
  width: 120px;
  margin-bottom: 100px;
}
.vertical-text>li>a {
  border-bottom: 1px solid #ddd;
  border-right-color: transparent;
  text-align: center;
  border-radius: 4px 4px 0px 0px;
}
.vertical-text>li.active>a,
.vertical-text>li.active>a:hover,
.vertical-text>li.active>a:focus {
  border-bottom-color: transparent;
  border-right-color: #ddd;
  border-left-color: #ddd;
}
.vertical-text.tabs-left {
  left: -50px;
}
.vertical-text.tabs-right {
  right: -50px;
}
.vertical-text.tabs-right>li {
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
}
.vertical-text.tabs-left>li {
  -webkit-transform: rotate(-90deg);
  -moz-transform: rotate(-90deg);
  -ms-transform: rotate(-90deg);
  -o-transform: rotate(-90deg);
  transform: rotate(-90deg);
}
.jst-hours {
  float: left;
}
.jst-minutes {
  float: left;
}
.jst-seconds {
  float: left;
}
.jst-clearDiv {
  clear: both;
}
.jst-timeout {
  color: red;
}
#exam_time {
  font-size: 20px;
  font-weight: bold;
}
.tqinfo, .eqinfo, .tninfo {
	font-size: 15px;
	font-weight: 700;
}
</style>
@endpush

@section('page_content')

@if( isset($quesData) && count($quesData) > 0 )
<div class="col-md-12">
<form name="frm" action="{{ route('goExamFinish') }}" method="post" id="quesFrm">
{{ csrf_field() }}
	<div class="row">
		<div class="col-md-3">
			<input type="button" id="startBtn" class="btn btn-success" value="Start The Exam">
			<input type="submit" class="btn btn-danger" value="Complete Exam" id="completeExam" style="display: none;">
			<input type="hidden" name="subject_id" value="{{ $subject_id }}">
			<input type="hidden" name="total_question" value="{{ count($quesData) }}">
			<input type="hidden" name="each_marks" value="{{ $examSettings->each_marks }}">
			<input type="hidden" name="total_time" value="{{ $examSettings->total_time }}">
		</div>
		<div class="col-md-6">
			@if( isset($examSettings) )
			<span class="tqinfo base-green">Total Question : {{ count($quesData) }}</span> |
			<span class="eqinfo base-blue">
				Each Question Have {{ $examSettings->each_marks }} Marks
			</span> |
			<span class="tninfo base-red">Total Marks : @php echo count($quesData) * $examSettings->each_marks; @endphp</span>
			@endif
		</div>
		<div class="col-md-2">
			@if( isset($examSettings) )
			<div id="exam_time" data-minutes-left="{{ $examSettings->total_time }}"></div>
			@endif
		</div>
	</div>
	<div class="row" id="qsBox" style="margin-top: 30px;">
	    <div class="col-md-2" style="max-height: 500px; overflow-y: auto; background-color : #e6ffcc;">
	      <ul class="nav nav-tabs tabs-left">
	      	  @php $i = 1; @endphp
	      	  @foreach( $quesData as $li )
	      	  	<li @if( $i == '1' ) class="active" @endif>
	      	  		<a href="#box{{ $i }}" data-toggle="tab">
	      	  			<i class="glyphicon glyphicon-paste"></i>
	      	  			Q. No #{{ $i }}
	      	  		</a>
	      	  	</li>
	      	  	@php $i++; @endphp
	      	  @endforeach
	      </ul>
	    </div>
	    <div class="col-md-8">
	       <div class="tab-content">
	       		@php $j = 1; @endphp
	       		@foreach( $quesData as $v )
	       			<div class="tab-pane @if( $j == '1' ) active @endif" id="box{{ $j }}" style="margin-bottom: 60px;">
	       				<div>
	       					<label><i class="glyphicon glyphicon-question-sign"></i> Question :</label>
	       					<p>{!! html_entity_decode( $v->name, ENT_QUOTES ) !!}</p>
	       					@if( $v->is_image == '1' && $v->image != '' && $v->image != null )
	       						<img src="{{ asset('public/uploads/question_images/'. $v->image) }}" class="img-thumbnail">
	       					@endif
	       				</div>
	       				<hr/>
	       				<div class="wmark">
	       					<div class="row">
	       						<div class="col-md-12">
	       							<label>
	       								Answers - 
	       								<span style="color: #ccc;">
	       									<small><i>Choose your correct answer</i></small>
	       								</span>
	       							</label>
	       						</div>
	       					</div>
	       					<div class="row">
	       						<div class="col-md-6">
	       							<input type="radio" class="opans" id="{{ $j }}" name="ans_{{ $v->id }}_{{ $v->answer }}" value="1"> <span>{{ $v->op1 }}</span>
	       						</div>
	       						<div class="col-md-6">
	       							<input type="radio" class="opans" id="{{ $j }}" name="ans_{{ $v->id }}_{{ $v->answer }}" value="2"> <span>{{ $v->op2 }}</span>
	       						</div>
	       					</div>
	       					<div class="row">
	       						@if( $v->op3 != null && $v->op3 != '' )
	       						<div class="col-md-6">
	       							<input type="radio" class="opans" id="{{ $j }}" name="ans_{{ $v->id }}_{{ $v->answer }}" value="3"> <span>{{ $v->op3 }}</span>
	       						</div>
	       						@endif
	       						@if( $v->op4 != null && $v->op4 != '' )
	       						<div class="col-md-6">
	       							<input type="radio" class="opans" id="{{ $j }}" name="ans_{{ $v->id }}_{{ $v->answer }}" value="4"> <span>{{ $v->op4 }}</span>
	       						</div>
	       						@endif
	       					</div>
	       					<div class="row">
	       						@if( $v->op5 != null && $v->op5 != '' )
	       						<div class="col-md-6">
	       							<input type="radio" class="opans" id="{{ $j }}" name="ans_{{ $v->id }}_{{ $v->answer }}" value="5"> <span>{{ $v->op5 }}</span>
	       						</div>
	       						@endif
	       						@if( $v->op6 != null && $v->op6 != '' )
	       						<div class="col-md-6">
	       							<input type="radio" class="opans" id="{{ $j }}" name="ans_{{ $v->id }}_{{ $v->answer }}" value="6"> <span>{{ $v->op6 }}</span>
	       						</div>
	       						@endif
	       					</div>
	       				</div>
	       			</div>
	       			@php $j++; @endphp
	       		@endforeach
	       		<input type="button" class="btn btn-default btnPrevious" value="Previous">
	       		&nbsp;&nbsp;
	       		<input type="button" class="btn btn-primary btnNext" value="Next">
	        </div>
	    </div>
	    <div class="col-md-2">
	    	<?php
	    	for($i = 1; $i <= count($quesData); $i++) {
	    		echo '<span class="badge" id="mark_'. $i .'" style="background-color: #ccc;">'. $i .'</span>';
	    	}
	    	?>
	    </div>
  	</div>
</form>
</div>
@else
	<div class="alert alert-danger">
		<h3><strong>Sorry, This Subject Have No Question Yet!!</strong></h3>
	</div>
@endif

@endsection

@push('page_js')
<script src="{{ asset('public/assets/jquery.simple.timer.js') }}"></script>
<script type="text/javascript">
$( function() {
	$('#qsBox').block({ 
      message: '<h4>Want To Start Exam ?</h4>', 
      css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
      } 
  	});
  	$('#startBtn').on('click', function() {
  		$(this).val('Exam Started').attr('disabled', 'disabled');
  		$('#completeExam').show();
  		$('#qsBox').unblock();
  		$('#exam_time').startTimer( {
	      onComplete: function() {
	      	$('#qsBox').block({ 
		      message: '<h4>!! Time Over !!</h4>', 
		      css: { 
		        border: 'none', 
		        padding: '15px', 
		        backgroundColor: '#ff3333', 
		        '-webkit-border-radius': '10px', 
		        '-moz-border-radius': '10px', 
		        opacity: .5, 
		        color: '#fff' 
		      } 
		  	});
	        $('#quesFrm').submit();
	      }
	    } );
  	} );
  	$('body').on('click', '.opans', function() {
  		$('#mark_' + $(this).attr('id')).css('background-color', 'green');
  	});
  	$('.btnNext').click(function(){
	  $('.nav-tabs > .active').next('li').find('a').trigger('click');
	});
  	$('.btnPrevious').click(function(){
	  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
	});
} );
</script>
@endpush