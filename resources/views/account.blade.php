@extends('app')

@push('page_css')
@endpush

@section('page_content')
<div class="row">
	<div class="col-md-3">
		@include('includes.sidebar')
	</div>
	<div class="col-md-9">
		
	</div>
</div>
@endsection

@push('page_js')
@endpush