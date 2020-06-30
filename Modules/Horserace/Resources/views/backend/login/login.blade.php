<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <title>Admin - Login </title>
  <!-- GLOBAL MAINLY STYLES-->
  <link href="{{ asset('backend/lib/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('backend/lib/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet"/>
  <!-- PLUGINS STYLES-->
  <!-- THEME STYLES-->
  <link href="{{ asset('backend/css/main.min.css') }}" rel="stylesheet"/>
  <!-- PAGE LEVEL STYLES-->
  <style>
    body {
      background-repeat: no-repeat;
      background-size: cover;
    }

    .cover {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(117, 54, 230, .1);
    }

    .login-content {
      max-width: 400px;
      margin: 100px auto 50px;
    }

    .auth-head-icon {
      position: relative;
      height: 60px;
      width: 60px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 30px;
      background-color: #fff;
      color: #5c6bc0;
      box-shadow: 0 5px 20px #d6dee4;
      border-radius: 50%;
      transform: translateY(-50%);
      z-index: 2;
    }
  </style>
</head>

<body>
<div class="cover"></div>
<div class="ibox login-content">
  <div class="text-center">
    <span class="auth-head-icon"><i class="la la-user"></i></span>
  </div>
  <form class="ibox-body" id="login-form" action="{{ route("admin.login.submit") }}" method="POST">
    {{ csrf_field() }}
    <h1 class="text-center">競輪チャンネル</h1>
    <h4 class="font-strong text-center mb-5">LOG IN</h4>

    @if (Session::has('flash_message'))
      <div class="alert alert-{!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message') !!}
      </div>
    @endif

    <div class="form-group mb-4">
      <input class="form-control form-control-line" type="text"
             name="login_id" placeholder="Login id" required>
    </div>
    <div class="form-group mb-4">
      <input class="form-control form-control-line"
             type="password" name="password" placeholder="Password" required>
    </div>
    <div class="text-center mb-4">
      <button class="btn btn-primary btn-rounded btn-block">LOGIN</button>
    </div>
  </form>
</div>
<!-- BEGIN PAGA BACKDROPS-->
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
  <div class="page-preloader">Loading</div>
</div>
<!-- CORE PLUGINS-->
<script src="{{ asset('backend/lib/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('backend/lib/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('backend/lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/lib/metisMenu/dist/metisMenu.min.js') }}"></script>
<script src="{{ asset('backend/lib/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<!-- PAGE LEVEL PLUGINS-->
<!-- CORE SCRIPTS-->
<script src="{{ asset('backend/js/app.min.js') }}"></script>
</body>

</html>