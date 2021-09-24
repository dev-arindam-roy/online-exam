<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title></title>
  
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
  .btn {
    background-color: #003366;
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
      <li>
        <a href="{{ route('exLinks') }}"><span class="glyphicon glyphicon-link"></span> Exam Links</a>
      </li>
      <li><a href="{{ route('index') }}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="{{ route('guestLogin') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12" style="background-color: #d6d6c2; padding: 0; margin: 0;">
          <img src="{{ asset('public/images/logo1.jpg') }}" style="width: 100%;">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" style="background-color: #d6d6c2;">
          <form name="frm" id="frm" action="{{ route('crteAcc') }}" method="post">
          {{ csrf_field() }}
            <div class="form-group" style="margin-top: 10px;">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-user"></span>
                </div>
                <input type="text" name="first_name" class="form-control" placeholder="Enter Your First Name" required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-user"></span>
                </div>
                <input type="text" name="last_name" class="form-control" placeholder="Enter Your Last Name" required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-envelope"></span>
                </div>
                <input type="email" name="email_id" class="form-control" placeholder="Enter Your Email Id" required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-credit-card"></span>
                </div>
                <input type="text" name="aadhar_no" class="form-control" placeholder="Enter Your Aadhar No">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-phone"></span>
                </div>
                <input type="text" name="contact_no" class="form-control" placeholder="Enter Your Contact Number">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-lock"></span>
                </div>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="glyphicon glyphicon-lock"></span>
                </div>
                <input type="password" name="re_password" id="re_password" class="form-control" placeholder="Enter Confirm Password">
              </div>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Create Account">
              <a href="{{ route('guestLogin') }}" class="pull-right">Already have Account ?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active">
            <img src="{{ asset('public/images/img1.jpg') }}" style="width: 100%; height: 500px;">
          </div>

          <div class="item">
            <img src="{{ asset('public/images/img2.jpg') }}" style="width: 100%; height: 500px;">
          </div>

          <div class="item">
            <img src="{{ asset('public/images/img3.jpg') }}" style="width: 100%; height: 500px;">
          </div>

          
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>
  <div class="row" style="margin-top: 20px;">
	<div class="col-md-12">
		<span style="color: #ccc;">copyright and developed by  www.webworldtech.in</span>
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

    first_name: {
      required: true
    },
    last_name: {
      required: true
    },
    contact_no: {
      required: true,
      digits: true,
      maxlength: 12,
      minlength: 10
    },
    aadhar_no: {
    	required: true,
    	minlength: 12
    },
    email_id: {
      email: true,
      required: true
    },
    password: {
      required: true,
      minlength: 6
    },
    re_password: {
      required: true,
      equalTo: "#password"
    }
  },
  messages: {

    first_name: {
      required: 'Please enter first name'
    },
    last_name: {
      required: 'Please enter last name'
    },
    contact_no: {
      required: 'Please enter valid mobile number'
    },
    aadhar_no: {
    	required: 'Please enter aadhar no'
    },
    email_id: {
      email: 'Please enter valid email id',
      required: 'Please enter email id'
    },
    password: {
      required: 'Please enter password.',
      minlength: 'Please enter minimum 6 charset.'
    },
    re_password: {
      required: 'Please enter confirm password.',
      equalTo: 'Password not match.'
    }
  },
  errorPlacement: function(error, element) {
    element.parent().addClass('has-error');
    if (element.attr("data-error-container")) { 
      error.appendTo(element.attr("data-error-container"));
    } else {
      error.insertAfter(element.parent()); 
    }
  }
});
</script>
</body>
</html>
