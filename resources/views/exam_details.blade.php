@extends('app')

@push('page_css')
@endpush

@section('page_content')
<div class="row">
	<div class="col-md-3">
		@include('includes.sidebar')
	</div>
	<div class="col-md-9">
		@if( isset($exam) && isset($exam_questions) )
		<h3>Exam Details</h3>
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Exam Information</strong></div>
			<div class="panel-body">
				<table class="table table-bordered table-striped">
					<tr>
						<th>Subject :</th>
						<td>
							@if( isset($exam->subjectInfo) )
							{!! html_entity_decode($exam->subjectInfo->name, ENT_QUOTES) !!}
							@endif				
						</td>
					</tr>
					<tr>
						<th>Exam Token :</th>
						<td>
							{{ $exam->exam_token }}				
						</td>
					</tr>
					<tr>
						<th>Total Question :</th>
						<td>
							{{ $exam->total_question }}				
						</td>
					</tr>
					<tr>
						<th>Question Attempts :</th>
						<td>
							{{ $exam->attempts }}				
						</td>
					</tr>
					<tr>
						<th>Total Time :</th>
						<td>
							{{ $exam->total_time }}	Minutes			
						</td>
					</tr>
					<tr>
						<th>Total Marks :</th>
						<td>
							@php echo $exam->total_question * $exam->each_marks; @endphp				
						</td>
					</tr>
					<tr>
						<th>Marks Obtain :</th>
						<td>
							{{ $exam->marks_obtain }}				
						</td>
					</tr>
					<tr>
						<th>Grade Obtain :</th>
						<td>
							{{ $exam->grade_obtain }}				
						</td>
					</tr>
					<tr>
						<th>Exam Date :</th>
						<td>
							{{ date('d-m-Y', strtotime($exam->created_at)) }}				
						</td>
					</tr>
				</table>
			</div>
		</div>
		@endif
	</div>
</div>
@endsection

@push('page_js')
@endpush