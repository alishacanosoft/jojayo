<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    @csrf
    <title>Seller Login</title>
    <link rel="icon" href="favicon" type="image/png">
    <link rel="stylesheet" href="/admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/admin/css/toastr.min.css">
    <link rel="stylesheet" href="/admin/css/bootstrap.min.css" id="bscss">
    <link rel="stylesheet" href="/admin/css/app.min.css" id="maincss">
    <script src="/admin/js/jquery.min.js"></script>
</head>
<style>
    body {
        background-color: #ffffff;
    }

    .left-login {
        height: auto;
        min-height: 100%;
        background: #fff;
        -webkit-box-shadow: 2px 0px 7px 1px rgba(0, 0, 0, 0.08);
        -moz-box-shadow: 2px 0px 7px 1px rgba(0, 0, 0, 0.08);
        box-shadow: 2px 0px 7px 1px rgba(0, 0, 0, 0.08);
    }

    .left-login-panel {
        -webkit-box-shadow: 0px 0px 28px -9px rgba(0, 0, 0, 0.74);
        -moz-box-shadow: 0px 0px 28px -9px rgba(0, 0, 0, 0.74);
        box-shadow: 0px 0px 28px -9px rgba(0, 0, 0, 0.74);
    }

    .login-center {
        background: #fff;
        width: 400px;
        margin: 0 auto;
    }

    @media only screen and (max-width: 380px) {
        .login-center {
            width: 320px;
            padding: 10px;
        }

        .wd-xl {
            width: 260px;
        }
    }
</style>
<body >
<div class="col-lg-4 col-sm-6 left-login">
        <div class="wrapper" style="margin: 20% 0 0 auto">
        <div class="block-center mt-xl wd-xl">
            <div class="text-center" style="margin-bottom: 20px">
                <img src="/images/login_logo.png" class="m-r-sm">
            </div>
            <div class="error_login"></div>
            <!-- START panel-->
            <div class="panel panel-dark panel-flat left-login-panel">
                <div class="panel-heading text-center">
                    <a href="#" style="color: #ffffff">
                   <span style="font-size: 15px;">Login and start selling</a>
                </div>

                <div class="panel-body">
                <p class="text-center pv">SIGN IN TO CONTINUE.</p>
                <form data-parsley-validate="" novalidate="" action="{{ route('login') }}" method="post">
                  @csrf
                    <div class="form-group has-feedback">
                        <input type="text" id="email" name="email" value="" required="true" class="form-control" placeholder="Username" />
                        <span class="fa fa-envelope form-control-feedback text-muted"></span>
                        @if ($errors->has('email'))
                        <span class="validation-errors text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" id="password" value="" name="password" required="true" class="form-control" placeholder="Password" />
                        <span class="fa fa-lock form-control-feedback text-muted"></span>
                        @if ($errors->has('password'))
                        <span class="validation-errors text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="clearfix">
                        <div class="checkbox c-checkbox pull-left mt0">
                            <label>
                                <input type="checkbox" value="" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="fa fa-check"></span>Remember Me
                            </label>
                        </div>
                        <div class="pull-right"><a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                        </div>
                    </div>
                    <button  class="btn btn-block btn btn-primary "><i class="fa fa-sign-in"></i> Login</button>
                  </form>
                </div>
              </div>
        </div>
    </div>
</div>
<div class="col-lg-8 col-sm-6 hidden-xs" style="background: url('/images/e-commerce-banner.jpg') no-repeat center center fixed;
 -webkit-background-size: cover;
 -moz-background-size: cover;
 -o-background-size: cover;
 background-size: cover;min-height: 100%;">
    </div>

<!-- =============== VENDOR SCRIPTS ===============-->

<!-- =============== Toastr ===============-->
<script src="/admin/js/toastr.min.js"></script>
<!-- BOOTSTRAP-->
<script src="/admin/js/bootstrap.min.js"></script>
<!-- STORAGE API-->
<script src="/admin/js/jquery.storageapi.min.js"></script>
<script src="/admin/js/parsley.min.js"></script>

</body>


<!-- Mirrored from ultimate.codexcube.com/login by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 01 Jun 2020 05:25:06 GMT -->
</html>
