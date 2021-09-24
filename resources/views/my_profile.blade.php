@extends('app')

@push('page_css')
@endpush

@section('page_content')
<div class="row">
	<div class="col-md-3">
		@include('includes.sidebar')
	</div>
	<div class="col-md-9">
		<h3>My Profile</h3>
		<hr/>
		<div class="row">
			<div class="col-md-8">
			@if( Session::has('msg') && Session::has('msg_class') )
			<div class="{{ Session::get('msg_class') }}">{{ Session::get('msg') }}</div>
			@endif
			<form name="frm" id="frm" action="{{ route('guestProfileUPD') }}" method="post">
			{{ csrf_field() }}
				<div class="form-group">
					<label>First Name : <em>*</em></label>
					<input type="text" name="first_name" class="form-control" value="{{ Auth::user()->first_name }}">
				</div>
				<div class="form-group">
					<label>Last Name : <em>*</em></label>
					<input type="text" name="last_name" class="form-control" value="{{ Auth::user()->last_name }}">
				</div>
				<div class="form-group">
					<label>Email-id : <em>*</em></label>
					<input type="text" name="email_id" class="form-control" value="{{ Auth::user()->email_id }}">
				</div>
				<div class="form-group">
					<label>Mobile Number : </label>
					<input type="text" name="contact_no" class="form-control" value="{{ Auth::user()->contact_no }}">
				</div>
				<div class="form-group">
					<label>Aadhar Number : </label>
					<input type="text" name="aadhar_no" class="form-control" value="{{ Auth::user()->aadhar_no }}">
				</div>
				<div class="form-group">
					<label>Address : </label>
					<textarea name="address" class="form-control">{{ Auth::user()->address }}</textarea>
				</div>
				<div class="form-group">
					<label>Sex : </label>
					<input type="radio" name="sex" value="Male" @if( Auth::user()->sex == 'Male' ) checked="checked" @endif> Male
					<input type="radio" name="sex" value="Female"@if( Auth::user()->sex == 'Female' ) checked="checked" @endif> Female
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Save Changes">
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

    first_name: {
      required: true
    },
    last_name: {
      required: true
    },
    email_id: {
      email: true,
      required: true
    }
  },
  messages: {

    first_name: {
      required: 'Please enter first name'
    },
    last_name: {
      required: 'Please enter last name'
    },
    email_id: {
      email: 'Please enter valid email id',
      required: 'Please enter email id'
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