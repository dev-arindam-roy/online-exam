@extends('app')

@push('page_css')
<style type="text/css">
.fsBig {
	font-size: 20px;
	text-align: center;
}
</style>
@endpush

@section('page_content')
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6" style="text-align: center;">
		@if( isset($data) && !empty($data) )
		<h1>
			<p>
				<span class="base-green"><b>Congratulations!</b></span><br/> 
				<span class="base-blue">Your Exam Completed Successfully.</span><br/>Thankyou!<br/>
			</p>
		</h1>
		<table class="table table-striped table-bordered">
			<tr>
				<th>Exam Token :</th>
				<td>{{ $data['exam_token'] }} <br/> <a href="{{ asset('public/pdfs/' . $data['exam_token'] . '.pdf') }}" download>Download Exam PDF<a>
				<br/><br/><small style="color: #5d5b5b;">You have received a PDF copy in your registered email. <br/>Please check your Inbox & Spam folder.<small>
				</td>
			</tr>
			<tr>
				<th>Attempts :</th>
				<th class="fsBig">{{ $data['attempts'] }}/{{ $data['total_question'] }}</th>
			</tr>
			<tr>
				<th>Marks Obtain :</th>
				<th class="fsBig">{{ $data['marks_obtain'] }}/{{ $data['total_marks'] }}</th>
			</tr>
			<tr>
				<th>Percentage :</th>
				<th class="fsBig">{{ round( $data['percent_obtain'], 2 ) }}%</th>
			</tr>
		</table>
		<a href="{{ route('exmHis') }}" class="btn btn-primary"> My Account </a>
		<a href="{{ route('guest_logout') }}" class="btn btn-danger"> Logout </a>
		@else
		<div class="alert alert-danger">
			<h3>SERVER ERROR</h3>
			<a href="{{ route('exmHis') }}" class="btn btn-primary"> My Account </a>
			<a href="{{ route('guest_logout') }}" class="btn btn-danger"> Logout </a>
		</div>
		@endif
	</div>
	<div class="col-md-3"></div>
</div>
@endsection

@push('page_js')
@endpush