<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    @csrf
    <title>Seller Login</title>
    <link rel="icon" href="favicon" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/admin/css/toastr.min.css">
    <link rel="stylesheet" href="/admin/css/bootstrap.min.css" id="bscss">
    <link rel="stylesheet" href="/admin/css/app.min.css" id="maincss">
    <script src="/admin/js/jquery.min.js"></script>
</head>
<style>
    body {
        font-family: "Ubuntu", sans-serif;
        background-image: linear-gradient(to left, #74ebd54a, #9face66e);
    }
    ::-webkit-scrollbar{
        width: 1px
    }
    .container {
        max-width: 1000px;
    }

    a {
        display: inline-block;
        text-decoration: none;
    }

    input {
        outline: none !important;
    }

    h1 {
        text-align: center;
        text-transform: uppercase;
        margin-bottom: 40px;
        font-weight: 700;
    }

    section#formHolder {
        padding: 40px 0;
    }

    .brand {
        padding: 20px;
        background-size: cover;
        color: #fff;
        min-height: 540px;
        position: relative;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.7);
        transition: all 0.6s cubic-bezier(1, -0.375, 0.285, 0.995);
        z-index: 9999;
        background: url('/images/e-commerce-banner.jpg') no-repeat center center fixed;
    }
    .brand.active {
        width: 100%;
    }
    .brand::before {
        content: "";
        display: block;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background: #4343657a;
        z-index: -1;
    }
    .brand a.logo {
        color: #f95959;
        font-size: 20px;
        font-weight: 700;
        text-decoration: none;
        line-height: 1em;
    }
    .brand a.logo span {
        font-size: 30px;
        color: #fff;
        transform: translateX(-5px);
        display: inline-block;
    }
    .brand .heading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        transition: all 0.6s;
    }
    .brand .heading.active {
        top: 100px;
        left: 100px;
        transform: translate(0);
    }
    .brand .heading h2 {
        font-size: 70px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 0;
    }
    .brand .heading p {
        font-size: 15px;
        padding-top: 15px;
        font-weight: 300;
        text-transform: uppercase;
        letter-spacing: 2px;
        white-space: 4px;
        font-family: "Ubuntu", sans-serif;
    }
    .brand .success-msg {
        width: 100%;
        text-align: center;
        position: absolute;
        top: 22%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin-top: 50px;
        padding: 8px;
    }
    .brand .success-msg p {
        font-size:15px;
        font-weight: 400;
        font-family: "Ubuntu", sans-serif;
    }
    .brand .success-msg a {
        font-size: 12px;
        text-transform: uppercase;
        padding: 8px 30px;
        background: #f95959;
        text-decoration: none;
        color: #fff;
        border-radius: 30px;
    }
    .brand .success-msg p, .brand .success-msg a {
        transition: all 0.9s;
        transform: translateY(20px);
        opacity: 0;
    }
    .brand .success-msg p.active, .brand .success-msg a.active {
        transform: translateY(0);
        opacity: 1;
    }

    .form {
        position: relative;
    }
    .form .form-peice {
        background: #fff;
        min-height: 505px;
        margin-top: 15px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.6);
        color: #bbbbbb;
        padding: 30px 0 60px;
        transition: all 0.9s cubic-bezier(1, -0.375, 0.285, 0.995);
        position: absolute;
        top: 0;
        left: -30%;
        width: 130%;
        overflow: scroll;
    }
    .form .form-peice.switched {
        transform: translateX(-100%);
        width: 100%;
        left: 0;
    }
    .form form {
        padding: 0 40px;
        margin: 0;
        width: 70%;
        position: absolute;
        top: 50%;
        left: 60%;
        transform: translate(-50%, -50%);
    }
    .form form .form-group {
        margin-bottom: 0px;
        position: relative;
    }
    .form form .form-group.hasError input {
        border-color: #f95959 !important;
    }
    .form form .form-group.hasError label {
        color: #f95959 !important;
    }
    .form form label {
        font-size: 12px;
        font-weight: 400;
        text-transform: uppercase;
        font-family: "Ubuntu", sans-serif;
        transform: translateY(36px);
        transition: all 0.4s;
        cursor: text;
        z-index: -1;
        color: #838a9a;
        margin-left: 10px;
    }
    .form form label.active {
        transform: translateY(13px);
        font-size: 10px;
    }
    .form form label.fontSwitch {
        font-family: "Ubuntu", sans-serif !important;
        font-weight: 600;
    }
    .form form input:not([type=submit]) {
        width: 100%;
        border: none;
        border-bottom: 1px solid #ebebeb;
        padding: 10px 20px;
        box-sizing: border-box;
        font-size: 14px;
        font-weight: 500;
        color: #584a4a;
    }

    .form form input:not([type=submit]):focus {
        border: none;
        border-bottom: 2px solid #9face6;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
    }

    .form form input:not([type=submit]).hasError {
        border-color: #f95959;
    }
    .form form span.error {
        color: #f95959;
        font-family: "Ubuntu", sans-serif;
        font-size: 12px;
        position: absolute;
        bottom: -20px;
        right: 0;
        display: none;
    }
    /*.form form input[type=password] {*/
    /*    color: #f95959;*/
    /*}*/
    .form form .CTA {
        margin-top: 25px;
        text-align: center;
    }
    .form form .CTA input {
        font-size: 14px;
        text-transform: uppercase;
        padding: 8px 30px;
        background-image: linear-gradient(to left, #74ebd5, #9face6);
        color: #fff;
        border-radius: 30px;
        margin-right: 20px;
        border: none;
        font-family: "Ubuntu", sans-serif;
    }
    .form form .CTA a.switch {
        font-size: 13px;
        font-weight: 400;
        font-family: "Ubuntu", sans-serif;
        color: #bbbbbb;
        text-decoration: underline;
        transition: all 0.3s;
    }
    .form form .CTA a.switch:hover {
        color: #f95959;
    }

    @media (max-width: 768px) {
        .container {
            overflow: hidden;
        }

        section#formHolder {
            padding: 0;
        }
        section#formHolder div.brand {
            min-height: 200px !important;
            width: 100%;
        }
        section#formHolder div.brand.active {
            min-height: 100vh !important;
        }
        section#formHolder div.brand .heading.active {
            top: 200px;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        section#formHolder div.brand .success-msg p {
            font-size: 16px;
        }
        section#formHolder div.brand .success-msg a {
            padding: 5px 30px;
            font-size: 10px;
        }
        section#formHolder .form {
            width: 80vw;
            min-height: 500px;
            margin-left: 10vw;
        }
        section#formHolder .form .form-peice {
            margin: 0;
            top: 0;
            left: 0;
            width: 100% !important;
            transition: all 0.5s ease-in-out;
        }
        section#formHolder .form .form-peice.switched {
            transform: translateY(-100%);
            width: 100%;
            left: 0;
        }
        section#formHolder .form .form-peice > form {
            width: 100% !important;
            padding: 40px;
            left: 50%;
        }
    }

    .form-input {
        width: 100%;
        border: 1px solid #ebebeb;
        border-radius: 5px;
        padding: 17px 20px;
        box-sizing: border-box;
        font-size: 14px;
        font-weight: 500;
        color: #222;
    }

    @media (max-width: 480px) {
        section#formHolder .form {
            width: 100vw;
            margin-left: 0;
        }

        h2 {
            font-size: 50px !important;
        }
    }

    .flex-sb-m {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .w-full {
        width: 100%;
    }
    .p-b-30 {
        padding-bottom: 30px;
    }

    input[type=checkbox], input[type=radio] {
        box-sizing: border-box;
        padding: 0;
    }

    .input-checkbox100 {
        display: none;
    }


    div.contact100-form-checkbox .label-checkbox100 {
        font-size: 12px;
        color: #999999;
        line-height: 1.4;
        display: block;
        position: relative;
        margin-left: 0;
        text-transform:none;
        padding-left: 26px;
        cursor: pointer;
        transform: translateY(15px);
    }

    .input-checkbox100:checked + .label-checkbox100::before {
        color: #57b846;
    }

    div.contact100-form-checkbox .label-checkbox100::before {
        content: "\f00c";
        font-family: FontAwesome;
        font-size: 13px;
        color: transparent;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 2px;
        background: #fff;
        border: 1px solid #e6e6e6;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
    }

    .txt1 {
        font-size: 12px;
        line-height: 1.4;
        color: #999999;
        transform: translateY(12px);
    }

    .header-form{
        text-align: center;
        padding-top: 10px;
    }
    .header-form span{
        color: #838a9a;
    }

    .access-login{
        padding-top: 15px;
        text-align: center;
    }


    /****** CODE ******/

    .file-upload {
        display: block;
        text-align: center;
        font-family: "Ubuntu", sans-serif;
        font-size: 12px;
        padding-top: 25px;
    }
    .file-upload .file-select {
        display: block;
        border: 2px solid #dce4ec;
        color: #34495e;
        cursor: pointer;
        height: 42px;
        line-height: 40px;
        text-align: left;
        background: #ffffff;
        overflow: hidden;
        position: relative;
    }
    .file-upload .file-select .file-select-button {
        background: #dce4ec;
        padding: 0 10px;
        display: inline-block;
        height: 40px;
        line-height: 40px;
    }
    .file-upload .file-select .file-select-name {
        line-height: 40px;
        display: inline-block;
        padding: 0 10px;
    }
    .file-upload .file-select:hover {
        border-color: #34495ee8;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload .file-select:hover .file-select-button {
        background: #34495ee8;
        color: #ffffff;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload.active .file-select {
        border-color: #8aabda;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload.active .file-select .file-select-button {
        background: #8aabda;
        color: #ffffff;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload .file-select input[type="file"] {
        z-index: 100;
        cursor: pointer;
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        filter: alpha(opacity=0);
    }
    .file-upload .file-select.file-select-disabled {
        opacity: 0.65;
    }
    .file-upload .file-select.file-select-disabled:hover {
        cursor: default;
        display: block;
        border: 2px solid #dce4ec;
        color: #34495e;
        cursor: pointer;
        height: 40px;
        line-height: 40px;
        margin-top: 5px;
        text-align: left;
        background: #ffffff;
        overflow: hidden;
        position: relative;
    }
    .file-upload .file-select.file-select-disabled:hover .file-select-button {
        background: #dce4ec;
        color: #666666;
        padding: 0 10px;
        display: inline-block;
        height: 40px;
        line-height: 40px;
    }
    .file-upload .file-select.file-select-disabled:hover .file-select-name {
        line-height: 40px;
        display: inline-block;
        padding: 0 10px;
    }

    .account-social h6:before, .account-social h6:after {
    display: inline-block;
    margin: 0 6px 4px 6px;
    content: " ";
    text-shadow: none;
    border: 1px dashed #dedede;
    width: 80px;
    }
    .font-15{
        font-size:15px
    }
</style>
<body>
<div class="container">
    <section id="formHolder">

        <div class="row">

            <!-- Brand Box -->
            <div class="col-sm-6 brand">
                <div class="heading">
                    <a href="#" class="logo"><img src="/images/admin_logo.png" class="m-r-sm"></a>
                    <p>Vendor Selling Point</p>
                </div>
             
                @if(!empty($notification))
                <div class="success-msg">
                    <p class="active">Congratulations! You are registered as a vendor now! You should receive a call soon.</p>                    
                </div>
                @endif
            </div>


            <!-- Form Box -->
            <div class="col-sm-6 form">

                <!-- Login Form -->
                <div class="login form-peice">
                    <form class="login-form" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="header-form">
                            <span>SIGN IN TO CONTINUE.</span>
                        </div>
                        <div class="form-group">
                            <label for="loginemail">Email Adderss</label>
                            <input type="email" name="email" id="loginemail" required>
                        </div>

                        <div class="form-group">
                            <label for="loginPassword">Password</label>
                            <input type="password" name="password" id="loginPassword" required>
                        </div>

                        <div class="flex-sb-m w-full">
                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                                <label class="label-checkbox100" for="ckb1">
                                    Remember me
                                </label>
                            </div>
                            <div>
                                <a href="#" class="txt1">
                                    Forgot Password?
                                </a>
                            </div>
                        </div>

                        <div class="CTA">
                            <input type="submit" value="Login">
                        </div>
                        <br>
                        <div class="account-social text-center">
                            <h6 class="font-15">Want to sign up as Vendor?</h6>
                            <a href="#" class="switch font-15">Click here !</a>
                        </div>
                    </form>
                </div><!-- End Login Form -->


                <!-- Signup Form -->
                <div class="signup form-peice switched">
                    <form class="signup-form" action="{{ route('users.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf  
                        <br><br><br>                      
                        <div class="header-form">
                            <span>CREATE YOUR VENDOR ACCOUNT.</span>
                        </div>
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" class="name">
                            <span class="error"></span>
                        </div>

                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="text" name="company" id="company" class="company">
                            <span class="error"></span>
                        </div>

                        <div class="form-group">
                            <label for="company_address">Company Address</label>
                            <input type="text" name="company_address" id="company_address" class="company_address">
                            <span class="error"></span>
                        </div>

                        <div class="form-group">
                            <label for="phone">Contact </label>
                            <input type="text" name="contact" id="phone">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Adderss</label>
                            <input type="email" name="email" id="email" class="email">
                            <span class="error"></span>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="pass">
                            <span class="error"></span>
                        </div>
                        <div class="file-upload">
                            <div class="file-select">
                                    <div class="file-select-button" id="fileName">Choose Profile Image</div>
                                <div class="file-select-name" id="noFile">No Image chosen...</div>
                                <input type="hidden" name="roles" value="vendor">
                                <input type="file" name="image" id="chooseFile">
                            </div>
                        </div>

                        <div class="CTA">                            
                            <input type="submit" value="Signup Now" id="submit"/>
                        </div>
                        <br>
                        <div class="account-social text-center">
                            <h6 class="font-15">Or Already have an account?</h6>
                            <a href="#" class="switch font-15">Sign In !</a>
                        </div>                        
                        <br>
                    </form>
                </div><!-- End Signup Form -->
            </div>
        </div>
    </section>
{{--    <footer>--}}
{{--        <p>--}}
{{--            ALl rights reserved by: <a href="/">Jojayo</a>--}}
{{--        </p>--}}
{{--    </footer>--}}
</div>



</body>
<!-- =============== Toastr ===============-->
<script src="/admin/js/toastr.min.js"></script>
<!-- BOOTSTRAP-->
<script src="/admin/js/bootstrap.min.js"></script>
<!-- STORAGE API-->
<script src="/admin/js/jquery.storageapi.min.js"></script>
<script src="/admin/js/parsley.min.js"></script>

<script>
    /*global $, document, window, setTimeout, navigator, console, location*/
    $(document).ready(function () {

        'use strict';

        var usernameError = true,
            emailError    = true,
            passwordError = true,
            passConfirm   = true;

        // Detect browser for css purpose
        if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
            $('.form form label').addClass('fontSwitch');
        }

        // Label effect
        $('input').focus(function () {

            $(this).siblings('label').addClass('active');
        });

        // Form validation
        $('input').blur(function () {

            // User Name
            if ($(this).hasClass('name')) {
                if ($(this).val().length === 0) {
                    $(this).siblings('span.error').text('Please type your full name').fadeIn().parent('.form-group').addClass('hasError');
                    usernameError = true;
                } else if ($(this).val().length > 1 && $(this).val().length <= 6) {
                    $(this).siblings('span.error').text('Please type at least 6 characters').fadeIn().parent('.form-group').addClass('hasError');
                    usernameError = true;
                } else {
                    $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                    usernameError = false;
                }
            }
            // Email
            if ($(this).hasClass('email')) {
                if ($(this).val().length == '') {
                    $(this).siblings('span.error').text('Please type your email address').fadeIn().parent('.form-group').addClass('hasError');
                    emailError = true;
                } else {
                    $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                    emailError = false;
                }
            }

            // PassWord
            if ($(this).hasClass('pass')) {
                if ($(this).val().length < 8) {
                    $(this).siblings('span.error').text('Please type at least 8 charcters').fadeIn().parent('.form-group').addClass('hasError');
                    passwordError = true;
                } else {
                    $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                    passwordError = false;
                }
            }


            // label effect
            if ($(this).val().length > 0) {
                $(this).siblings('label').addClass('active');
            } else {
                $(this).siblings('label').removeClass('active');
            }
        });


        // form switch
        $('a.switch').click(function (e) {
            $(this).toggleClass('active');
            e.preventDefault();

            if ($('a.switch').hasClass('active')) {
                $(this).parents('.form-peice').addClass('switched').siblings('.form-peice').removeClass('switched');
            } else {
                $(this).parents('.form-peice').removeClass('switched').siblings('.form-peice').addClass('switched');
            }
        });


        // Form submit
        $('form.signup-form').submit(function (event) {
            //event.preventDefault();

            if (usernameError == true || emailError == true || passwordError == true || passConfirm == true) {
                $('.name, .email, .pass, .passConfirm').blur();
            } else {
                $('.signup, .login').addClass('switched');

                setTimeout(function () { $('.signup, .login').hide(); }, 700);
                setTimeout(function () { $('.brand').addClass('active'); }, 300);
                setTimeout(function () { $('.heading').addClass('active'); }, 600);
                setTimeout(function () { $('.success-msg p').addClass('active'); }, 900);
                setTimeout(function () { $('.success-msg a').addClass('active'); }, 1050);
                setTimeout(function () { $('.form').hide(); }, 700);
            }
        });

        // Reload page
        $('a.profile').on('click', function () {
            location.reload(true);
        });



        $('#chooseFile').bind('change', function () {
            var filename = $("#chooseFile").val();
            if (/^\s*$/.test(filename)) {
                $(".file-upload").removeClass('active');
                $("#noFile").text("No file chosen...");
            }
            else {
                $(".file-upload").addClass('active');
                $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
            }
        });
    });
</script>
</html>