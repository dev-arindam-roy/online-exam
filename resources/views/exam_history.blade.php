@extends('app')

@push('page_css')
@endpush

@section('page_content')
<div class="row">
	<div class="col-md-3">
		@include('includes.sidebar')
	</div>
	<div class="col-md-9">
		<h3>My Exam History</h3>
		<hr/>
		<table class="table table-bordered table-striped table-hover ardata_table">
			<thead>
				<tr>
					<th>Subject</th>
					<th>Date</th>
					<th>Questions</th>
					<th>Attempts</th>
					<th>Marks</th>
					<th>Grade</th>
				</tr>
			</thead>
			<tbody>
				@if( isset($data) )
					@foreach( $data as $v )
					<tr>
						<td>
							@if( isset($v->subjectInfo) )
							{!! html_entity_decode($v->subjectInfo->name, ENT_QUOTES) !!}
							@endif
						</td>
						<td>{{ date('d-m-Y', strtotime($v->created_at)) }}</td>
						<td>{{ $v->total_question }}</td>
						<td>{{ $v->attempts }}</td>
						<td>{{ $v->marks_obtain }}</td>
						<td>
							<a href="{{ route('exmDet', ['tok' => $v->exam_token]) }}">
							<span class="@if( $v->grade_obtain == 'F' ) base-red @endif">
								<strong>
									{{ $v->grade_obtain }}
								</strong>
								<small>[...]</small>
							</span>
							</a>
						</td>
					</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
@endsection

@push('page_js')
@endpush