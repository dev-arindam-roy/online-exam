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
        <a href="{{ route('exLinks') }}"><span class="glyphicon glyphicon-link"></span> Exam Links</a>
      </li>
      <li><a href="{{ route('index') }}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="{{ route('guestLogin') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  
  <div class="row">
    <div class="col-md-12">
    	@if( Session::has('msg') && Session::has('msg_class') )
    	<div class="{{ Session::get('msg_class') }}">{{ Session::get('msg') }}</div>
    	@endif
      @if( isset($links) && !Session::has('msg') && !Session::has('msg_class') )

        <ul class="exl">
          @foreach( $links as $lk )
            @php
              $today = date('Y-m-d');
              $examDate = $lk->start_date;
              $stime = strtotime( $lk->start_time );
              $etime = strtotime( $lk->end_time );
              $ctime = strtotime( date('g:i A') );
              $now = strtotime( date('Y-m-d H:i:s') );
              $examDateTime = strtotime( $lk->start_date .' '.$lk->start_time );
              $beforeTwoHr = strtotime( date("Y-m-d H:i:s", strtotime('-2 hours', $examDateTime)) );
            @endphp

            @if( $today == $examDate )
              @if( $ctime < $stime )
              <li>
                Today Exam Link Comming Soon....<br/>
                Link Open At <span>{{ date( 'g:i A', strtotime( $lk->start_time ) ) }}</span> And 
                Valid Upto <span>{{ date( 'g:i A', strtotime( $lk->end_time ) ) }}</span><br/>
                Please Wait....
              </li>
              @elseif( ($ctime >= $stime) && ($ctime <= $etime) )
              <li>
                <a href="{{ route('exLinksReg', array('slug' => $lk->link)) }}">
                  Click Here !!! & Start The Exam <br/>{{ route('exLinksReg', array('slug' => $lk->link)) }}<br/>
                  Valid Upto <span>{{ date( 'g:i A', strtotime( $lk->end_time ) ) }}</span>
                </a>
              </li>
              @else
              <li>
                <span>EXAM LINK EXPIRED</span>
              </li>
              @endif
            @endif
          @endforeach
        </ul>
      @endif
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
