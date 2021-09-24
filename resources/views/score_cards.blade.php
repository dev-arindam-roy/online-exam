@extends('app')

@push('page_css')
<style type="text/css">
.scd {
	padding: 5px;
	text-align: center;
	border: 1px solid #1a53ff;
	margin-right: 10px;
	margin-top: 10px;
}
.schead {
	background-color: #ffbf00;
	font-weight: bold;
	padding: 2px;
}
.scbody {
	font-size: 24px;
	font-weight: bold;
}
.scfoot {
	background-color: #009933;
	color: #fff;
	font-size: 18px;
}
.scd a:hover {
	text-decoration: none;
}
</style>
@endpush

@section('page_content')
<div class="row">
	<div class="col-md-3">
		@include('includes.sidebar')
	</div>
	<div class="col-md-9">
		<h3>My Score Cards</h3>
		<hr/>
		<div class="row">
			@if( isset($data) )
				@foreach( $data as $v )
					
					<div class="col-md-3 scd">
						<a href="{{ route('exmDet', ['tok' => $v->exam_token]) }}">
						<div class="schead">GRADE</div>
						<div class="scbody">
							@if( $v->grade_obtain == 'F' )
							<span style="font-size: 48px;" class="base-red"> {{ $v->grade_obtain }}</span>
							@else
							<span style="font-size: 48px;" class="base-green"> {{ $v->grade_obtain }}</span>
							@endif
							<br/>
							<span>Marks : {{ $v->marks_obtain }}</span>
						</div>
						<div class="scfoot">
							{{ date('d-m-Y', strtotime($v->created_at)) }}
						</div>
						</a>
					</div>

				@endforeach
			@endif
		</div>
	</div>
</div>
@endsection

@push('page_js')
@endpush