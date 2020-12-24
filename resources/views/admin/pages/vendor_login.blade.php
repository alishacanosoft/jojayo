<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="JoJayo">
    <meta name="description" content="JOJAYO" />
    <meta name="keywords" content="jojayo, shopping, e-commerce" />
    <link rel="canonical" href="https://jojayo.com/" />

    <link rel="icon" href="{{asset('images/favicon.ico')}}" />
    <link rel="apple-touch-icon" href="{{asset('images/apple-touch-icon.png')}}" />
    <link rel="android-chrome-192x192" href="{{asset('images/android-chrome-192x192.png')}}" />
    <link rel="android-chrome-512x512" href="{{asset('images/android-chrome-512x512.png')}}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('images/site.webmanifest')}}">


    <meta property="og:type" content="ecommerce-website" />
    <meta property="og:title" content="JOJAYO" />
    <meta property="og:description" content="JOJAYO" />
    <meta property="og:url" content="https://jojayo.com/" />
    <meta property="og:site_name" content="JOJAYO" />
    <meta property="og:image" content="{{asset('images/jojayo_logo.png')}}" />


    @csrf
    <title>Seller Login | JoJaYo</title>
    <link rel="icon" href="favicon" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="/admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/admin/css/bootstrap.min.css" id="bscss">
    <script src="/admin/js/jquery.min.js"></script>
</head>
<style>
    body {
        font-family: "Ubuntu";
        /*background-image: linear-gradient(to left, #74ebd54a, #9face66e);*/
        background: url('/images/ecommerce.png')no-repeat fixed;
    }

    body::before{
        content: "";
        display: block;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background: #7f8ca273;
        z-index: -1;
    }

    .container {
        max-width: 1100px;
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
        color: #fff;
        min-height: 555px;
        position: relative;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.7);
        transition: all 0.6s cubic-bezier(1, -0.375, 0.285, 0.995);
        z-index: 9999;
        background-size: 150px;
        background: url('/images/evendor.jpg') 50% 50% no-repeat;
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
        background: #09091075;
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
        width: 100%;
        transform: translate(-50%, -50%);
        text-align: center;
        transition: all 0.6s;
    }
    .brand .heading.active {
        top: -400px;
        left: -430px;
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
        font-family: "Ubuntu";
    }
    .brand .success-msg {
        width: 100%;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin-top: 60px;
    }
    .brand .success-msg p {
        font-size: 25px;
        font-weight: 400;
        font-family: "Ubuntu";
    }
    .brand .success-msg a {
        font-size: 15px;
        font-weight: bold;
        text-transform: uppercase;
        padding: 8px 30px;
        background-image: linear-gradient(to left, #74ebd5, #9face6);
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

    .image-descp{
        width: 90%;
    }
    .form {
        position: relative;
    }
    .form .form-peice {
        background: #fff;
        min-height: 520px;
        margin-top: 15px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.6);
        color: #bbbbbb;
        padding: 30px 0 60px;
        transition: all 0.9s cubic-bezier(1, -0.375, 0.285, 0.995);
        position: absolute;
        top: 0;
        left: -30%;
        width: 130%;
        overflow-x: hidden;
        overflow-y: hidden;

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
        margin-bottom: 4px;
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
        font-family: "Ubuntu";
        transform: translateY(36px);
        transition: all 0.4s;
        cursor: text;
        z-index: -1;
        color: #2f2929;
        margin-left: 10px;
    }
    .form form label.active {
        transform: translateY(5px);
        font-size: 11px;
    }
    .form form label.fontSwitch {
        font-family: "Ubuntu";
        font-weight: 600;
    }

    .dotted-section h6:before, .dotted-section h6{
        color: #2f2929;
    }
    .dotted-section h6:before, .dotted-section h6:after {
        display: inline-block;
        margin: 0 6px 4px 6px;
        content: " ";
        text-shadow: none;
        border: 1px dashed #afaaaa;
        width: 80px;
        }

    .form form input:not([type=submit]) {
        width: 100%;
        border: 1px solid #ccc3c3;
        border-radius: 5px;
        padding: 10px 20px;
        box-sizing: border-box;
        font-size: 14px;
        font-weight: 500;
        color: #5a606f;
    }

    .form form input:not([type=submit]):focus {
        border: 2px solid #9face6;
    }

    .form form input:not([type=submit]).hasError {
        border-color: #f95959;
    }
    .form form span.error {
        color: #f95959;
        font-family: "Ubuntu";
        font-size: 10px;
        position: absolute;
        bottom: -13px;
        right: 0;
        display: none;
    }

    .form form .CTA {
        margin-top: 25px;
        text-align: center;
    }
    .form form .CTA input {
        font-size: 14px;
        text-transform: uppercase;
        padding: 8px 30px;
        font-weight: bold;
        background-image: linear-gradient(to left, #55ab9b, #9face6);
        color: #fff;
        border-radius: 30px;
        margin-right: 20px;
        border: none;
        font-family: "Ubuntu";
    }
    .form form .CTA a.switch {
        font-size: 13px;
        font-weight: 400;
        font-family: "Ubuntu";
        color: #bbbbbb;
        text-decoration: underline;
        transition: all 0.3s;
    }
    .form form .CTA a.switch:hover {
        color: #f95959;
    }

    .center{
        text-align: center;
        display: block;
        padding: 20px;
    }

    @media (max-width: 768px) {

        .brand .heading {
            position: absolute;
            top: 65%;
            left: 50%;
            width: 100%;
            transform: translate(-50%, -50%);
            text-align: center;
            transition: all 0.6s;
        }
        .image-descp {
            width: 50%;
        }

        .container {
            overflow: hidden;
        }

        .center{
            padding: 0;
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

        .image-descp {
            width: 90%;
        }

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
        border: 1px solid #ccc3c3;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
    }

    .txt1 {
        font-size: 12px;
        line-height: 1.4;
        color: #2f2929;
        transform: translateY(12px);
    }

    .header-form{
        text-align: center;
    }

    /*.signup-form{*/
    /*    text-align: center;*/
    /*    padding-top: 10px;*/
    /*}*/

    .header-form span{
        color: #2f2929;
    }

    .create-account{
        padding-top: 15px;
        text-align: center;
        color: #5a606f;
    }

    .access-login{
        padding-top: 15px;
        text-align: center;
        color:#5a606f;
    }


    /****** CODE ******/

    .file-upload {
        display: block;
        text-align: center;
        font-family: "Ubuntu";
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

    .form-row{
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 4px;
    }

    .form-row .col{
        position: relative;
        width: 100%;
        min-height: 1px;
        flex: 0 0 33.333333%;
        flex-grow: 1;
    }
    .form-row .col .input{
        border: 1px solid #ebebeb;
        border-radius: 5px;
        padding: 10px 20px;
        box-sizing: border-box;
        font-size: 14px;
        font-weight: 500;
        color: #5a606f;
    }
    .padding-lt-5{
        padding-left: 5px;
    }


</style>
<body>
<div class="container">
    <section id="formHolder">

        <div class="row">

            <!-- Brand Box -->
            <div class="col-sm-6 brand">
                <div class="center">
                    <a href="#" class="logo"><img src="/images/admin_logo.png" class="m-r-sm"></a>
                </div>

                <div class="heading">
                    <p>Vendor Selling Point</p>
                    <img src="/images/jojayo-descp.png" class="m-r-sm image-descp">
                </div>

                <div class="success-msg">
                    <p>Congratulations! You are registered as a vendor now !</p>
                    <a href="#" class="profile"> Get Started here </a>
                </div>
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
                            @if ($errors->has('email'))
                            <span class="validation-errors text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="loginPassword">Password</label>
                            <input type="password" name="password" id="loginPassword" required>
                            @if ($errors->has('password'))
                            <span class="validation-errors text-danger">{{ $errors->first('password') }}</span>
                            @endif
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
                        <div class="dotted-section text-center">
                            <h6 class="font-15">Want to sign up as Vendor?</h6>
                            <a href="#" class="switch font-15">Click here !</a>
                        </div>
                    </form>
                </div><!-- End Login Form -->


                <!-- Signup Form -->
                <div class="signup form-peice switched">
                <form class="signup-form" action="{{ route('users.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="header-form signup">
                            <span>CREATE YOUR VENDOR ACCOUNT</span>
                        </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" class="name">
                            <span class="error"></span>
                        </div>
                        <div class="col padding-lt-5">
                            <label for="email">Email Adderss</label>
                            <input type="email" name="email" id="email" class="email">
                            <span class="error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company">Company Name</label>
                        <input type="text" name="company" id="company" class="company_name">
                        <span class="error"></span>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="company_address">Company Address</label>
                            <input type="text" name="company_address" id="company_address" class="company_address">
                            <span class="error"></span>
                        </div>
                        <div class="col padding-lt-5">
                            <label for="phone">Contact </label>
                            <input type="text" name="contact" class="contact" id="phone">
                            <span class="error"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <label for="pannum">Pan/VAT Number</label>
                            <input type="text" name="pannum" id="pannum" class="pannum">
                            <span class="error"></span>
                        </div>
                        <div class="col padding-lt-5">
                            <div class="file-upload">
                                <div class="file-select">
                                    <div class="file-select-button" id="fileName">Choose</div>
                                    <div class="file-select-name" id="noFile">Vendor Profile...</div>
                                    <input type="hidden" name="roles" value="vendor">
                                    <input type="file" name="logo" id="chooseFile">
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="pass">
                            <span class="error"></span>
                        </div>

                        <div class="CTA">
                            <input type="submit" value="Signup Now" id="submit"/>
                        </div>
                        <div class="dotted-section text-center">
                            <h6 class="font-15">Already have an account?</h6>
                            <a href="#" class="switch font-15">Sign In !</a>
                        </div>
                    </form>
                </div><!-- End Signup Form -->
            </div>
        </div>
    </section>
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

        var usernameError    = true,
            emailError       = true,
            passwordError    = true,
            panNum           = true,
            company_name     = true,
            contact          = true,
            company_address  = true;

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

            // Panvat
            if ($(this).hasClass('pannum')) {
                if ($(this).val().length == '') {
                    $(this).siblings('span.error').text('Please type your Pan/VAT number').fadeIn().parent('.form-group').addClass('hasError');
                    panNum = true;
                } else {
                    $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                    panNum = false;
                }
            }

            // company name
            if ($(this).hasClass('company_name')) {
                if ($(this).val().length == '') {
                    $(this).siblings('span.error').text('Please type your company name').fadeIn().parent('.form-group').addClass('hasError');
                    company_name = true;
                } else {
                    $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                    company_name = false;
                }
            }

            // company address
            if ($(this).hasClass('company_address')) {
                if ($(this).val().length == '') {
                    $(this).siblings('span.error').text('Please type your company address').fadeIn().parent('.form-group').addClass('hasError');
                    company_name = true;
                } else {
                    $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                    company_name = false;
                }
            }

            // company address
            if ($(this).hasClass('company_address')) {
                if ($(this).val().length == '') {
                    $(this).siblings('span.error').text('Please type your company address').fadeIn().parent('.form-group').addClass('hasError');
                    company_address = true;
                } else {
                    $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                    company_address = false;
                }
            }

            // company address
            if ($(this).hasClass('contact')) {
                if ($(this).val().length == '') {
                    $(this).siblings('span.error').text('Please type your company number').fadeIn().parent('.form-group').addClass('hasError');
                    contact = true;
                } else {
                    $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                    contact = false;
                }
            }
            //PassWord confirmation
            // if ($('.pass').val() !== $('.passConfirm').val()) {
            //     $('.passConfirm').siblings('.error').text('Passwords don\'t match').fadeIn().parent('.form-group').addClass('hasError');
            //     passConfirm = false;
            // } else {
            //     $('.passConfirm').siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
            //     passConfirm = false;
            // }

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
            // $("input[name='roles']").attr('type','text');
            event.preventDefault();
            $.ajax({
                url: "{{ route('users.store') }}",
                type: 'post',
                data:$('.signup-form').serialize(),
                success:function(response){
                    alert('hehehe')
                }
            });
            if (usernameError == true || emailError == true || passwordError == true) {
                $('.name, .email, .pass').blur();
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
