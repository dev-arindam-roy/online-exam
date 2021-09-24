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
  ul.exl li{
    padding: 10px;
    background-color: yellow;
    color: blue;
    font-size: 24px;
    font-weight: bold;
  }
  ul.exl li span{
    background-color: red;
    color: #fff;
    padding: 5px;
  }

  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('index') }}"><span style="color: #ffffff;">Online Exam Portal</span></a>
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
        <a href=""><span class="glyphicon glyphicon-link"></span> Exam Links</a>
      </li>
      <li><a href="{{ route('index') }}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="{{ route('guestLogin') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  @if( isset($link) )
  <div class="row">
    <div class="col-md-12">
    <h3>Please Fillup The Below Form For The Exam<br/><small>{{ route('exLinksReg', array('slug' => $link)) }}</small></h3>
    </div>
    <div class="col-md-4">
      <form name="frm" id="frm" action="{{ route('ckLink', array('link' => $link)) }}" method="post">
      {{ csrf_field() }}
        <div class="form-group">
          <label>Your Name : <em>*</em></label>
          <input type="text" name="name" class="form-control" placeholder="Full Name" required="required">
        </div>
        <div class="form-group">
          <label>Mobile Number : <em>*</em> <br/><small><i>(Note: Provide active valid number)</i></small></label>
          <input type="text" name="contact_no" class="form-control" placeholder="Contact Number" required="required">
        </div>
        <div class="form-group">
          <label>Email-id : <em>*</em> <br/><small><i>(Note: Provide active valid email because after exam you get the exam details with all question & answers in this email-id)</i></small></label>
          <input type="email" name="email_id" class="form-control" placeholder="Email-ID" required="required">
        </div>
        <div class="form-group">
          <label>Link Access Username : <em>*</em></label>
          <input type="text" name="username" class="form-control" placeholder="Username" required="required">
        </div>
        <div class="form-group">
          <label>Link Access Password : <em>*</em></label>
          <input type="password" name="password" class="form-control" placeholder="Password" required="required">
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-success" value="Go To Exam Room" style="width: 100%;">
        </div>
      </form>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-6">
      @if( Session::has('msg') && Session::has('msg_class') )
        <div class="{{ Session::get('msg_class') }}">{{ Session::get('msg') }}</div>
      @endif
    </div>
  </div>
  @endif
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

    name: {
      required: true
    },
    contact_no: {
      required: true,
      digits: true,
      maxlength: 12,
      minlength: 10
    },
    email_id: {
      email: true,
      required: true
    },
    password: {
      required: true
    },
    username: {
      required: true
    }
  },
  messages: {

    name: {
      required: 'Please enter name'
    },
    contact_no: {
      required: 'Please enter valid mobile number'
    },
    email_id: {
      email: 'Please enter valid email id',
      required: 'Please enter email id'
    },
    password: {
      required: 'Please enter password.'
    },
    username: {
      required: 'Please enter username'
    }
  }
});
</script>
</body>
</html>
