<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('public/assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/ar_style.css') }}">
  <!-- jQuery 3 -->
  <script src="{{ asset('public/assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{ asset('public/assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <link href="https://fonts.googleapis.com/css?family=Convergence" rel="stylesheet">
  <style type="text/css">
  .navbar {
    border-radius: 0px;
    background-color: #003366;
    border-color: #003366;
  }
  .form-control {
    border-radius: 1px;
    border-color: #003366;
  }
  .input-group-addon {
    background-color: #003366;
    color: #ffffff;
    border-color: #003366;
  }
  .navbar-brand {
    font-family: 'Convergence', sans-serif;
    font-weight: 600;
    letter-spacing: 1px;
  }    
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('index') }}"><span style="color: #ffffff;">Shree Career Academy</span></a>
    </div>
    <ul class="nav navbar-nav">
      <!--li class="active"><a href="#">Home</a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Page 1-1</a></li>
          <li><a href="#">Page 1-2</a></li>
          <li><a href="#">Page 1-3</a></li>
        </ul>
      </li>
      <li><a href="#">Page 2</a></li-->
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="{{ route('index') }}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="{{ route('guestLogin') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  @if( Session::has('msg') && Session::has('msg_class') )
  <div class="{{ Session::get('msg_class') }}" style="text-align: center;"><h4><strong>{{ Session::get('msg') }}</strong></h4></div>
  @endif
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        
      </div>
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4" style="background-color: #d6d6c2; padding: 10px; margin-top: 50px;">
          <form name="frm" id="frm" action="{{ route('isckOTP') }}" method="post">
          {{ csrf_field() }}
            <div class="form-group">
              <label>Verify Your Mobile Number :</label>
              <input type="text" name="otp_number" class="form-control" placeholder="Enter Your OTP" required="required">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Verify OTP">
              <input type="hidden" name="uid" value="{{ $uid }}">
            </div> 
          </form>
        </div>
        <div class="col-md-4" style="text-align: right;">
          <form name="frmxxx" action="{{ route('resendOTP') }}" method="post">
            {{ csrf_field() }}
            <input type="submit" class="btn btn-danger" value="If OTP Not Received, Re-Send OTP" style="margin-top: 100px;">
            <input type="hidden" name="uid" value="{{ $uid }}">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Select2 -->
<script src="{{ asset('public/assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/jquery_validator/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/jquery_validator/additional-methods.min.js') }}"></script>
<script type="text/javascript">
$( function() {
  $('.select2').select2();
});
$('#frm').validate({
  errorElement: 'span',
  errorClass : 'roy-vali-error',
  ignore: [],
  normalizer: function( value ) {
    return $.trim( value );
  },
  rules: {

    
  },
  messages: {

    
  }
});
</script>
</body>
</html>
