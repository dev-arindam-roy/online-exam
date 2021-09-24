<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title></title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('public/assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/sweet_alert/sweetalert.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/ar_style.css') }}">
  <!-- jQuery 3 -->
  <script src="{{ asset('public/assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{ asset('public/assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

  <link href="https://fonts.googleapis.com/css?family=Convergence" rel="stylesheet">
  @stack('page_css')
  <style type="text/css">
  .bfoot {
    color: #ccc;
    letter-spacing: 1px;
    word-spacing: 2px;
    font-size: 14px;
    font-weight: 600;
  }
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
  .btn-primary {
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
      <a class="navbar-brand" href="{{ route('index') }}"><span style="color: #ffffff;">Online Exam Portal by WWT</span></a>
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
      @if( Auth::check() )
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> {{ ucfirst( Auth::user()->first_name ) }}</a></li>
      <li><a href="{{ route('guest_logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
      @else
      <li><a href="{{ route('index') }}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="{{ route('guestLogin') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      @endif
    </ul>
  </div>
</nav>