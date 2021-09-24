@extends('app')

@push('page_css')
<style type="text/css">
button.cancel.btn.btn-lg.btn-default {
    background-color: #ff3333;
    color: #fff;
}
</style>
@endpush

@section('page_content')
	<div class="row">
		<div class="col-md-3">
			@include('includes.sidebar')
		</div>
		<div class="col-md-9">
			<table class="table table-bordered table-striped table-hover ardata_table">
				<thead>
					<tr>
						<th style="width:30px;">SL.</th>
						<th>Subject Name or Title</th>
						<th>Language</th>
						<th style="width: 80px;">Exam</th>
					</tr>
				</thead>
				<tbody>
					@if( isset($data) )
						@php $sl = 1; @endphp
						@foreach($data as $v)
						<tr>
							<td>{{ $sl }}</td>
							<td>{!! html_entity_decode( $v->name, ENT_QUOTES ) !!}</td>
							<td>
								@php $lng = 'unknown'; @endphp
								@if( $v->language_id == '1')
									English
									@php $lng = 'eng'; @endphp
								@elseif( $v->language_id == '2' )
									Marathi (मराठी)
									@php $lng = 'mth'; @endphp
								@endif
							</td>
							<td>
								<a href="javascript:void(0);" class="btn btn-sm btn-primary goExamBtn" id="{{ base64_encode( $v->id ) }}" data="{{ $lng }}">
									<i class="glyphicon glyphicon-time"></i>
									Go Exam
								</a>
							</td>
						</tr>
						@php $sl++ @endphp
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
@endsection

@push('page_js')
<script type="text/javascript">
$( function() {
	$('.goExamBtn').on('click', function() {
		var SubID = $(this).attr('id');
		var Lng = $(this).attr('data');
		var URL = "{{ url('/') }}";
		URL = URL + '/goexam/' + Lng + '/' + SubID;
		swal({
		  title: "Are You Sure To Go For Exam ?",
		  text: "Please Confirm Us",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-success",
		  confirmButtonText: "Yes, I Want To Give Exam",
		  cancelButtonText: "No, Not Now",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
		    swal("Please Wait...", "Question Preparing", "success");
		    setTimeout( function() { 
		    	window.location.replace( URL ); 
		    }, 3000 );
		  } else {
		    swal("Cancelled", "Ok, Ready For Next Time :)", "error");
		  }
		});
	});	
} );
</script>
@endpush