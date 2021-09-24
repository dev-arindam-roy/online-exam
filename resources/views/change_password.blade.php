@extends('app')

@push('page_css')
@endpush

@section('page_content')
<div class="row">
	<div class="col-md-3">
		@include('includes.sidebar')
	</div>
	<div class="col-md-9">
		<h3>Change Your Password</h3>
		<hr/>
		<div class="row">
			<div class="col-md-8">
			@if( Session::has('msg') && Session::has('msg_class') )
			<div class="{{ Session::get('msg_class') }}">{{ Session::get('msg') }}</div>
			@endif
			<form name="frm" id="frm" action="{{ route('guestProfileCngPwdAct') }}" method="post">
			{{ csrf_field() }}
				<div class="form-group">
					<label>New Password : <em>*</em></label>
					<input type="password" name="password" id="password" class="form-control">
				</div>
				<div class="form-group">
					<label>Confirm Password : <em>*</em></label>
					<input type="password" name="confirm_password" id="confirm_password" class="form-control">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Chnage Password">
				</div>	
			</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('page_js')
<script type="text/javascript">
$('#frm').validate({
  errorElement: 'span',
  errorClass : 'roy-vali-error',
  ignore: [],
  normalizer: function( value ) {
    return $.trim( value );
  },
  rules: {

    password: {
      required: true,
      minlength: 6
    },
    confirm_password: {
      required: true,
      equalTo: "#password"
    }
  },
  messages: {

    password: {
      required: 'Please enter password.',
      minlength: 'Please enter minimum 6 charset.'
    },
    confirm_password: {
      required: 'Please enter confirm password.',
      equalTo: 'Password not match.'
    }
  },
  errorPlacement: function(error, element) {
    element.parent().addClass('has-error');
    if (element.attr("data-error-container")) { 
      error.appendTo(element.attr("data-error-container"));
    } else {
      error.insertAfter(element); 
    }
  }
});
</script>
@endpush