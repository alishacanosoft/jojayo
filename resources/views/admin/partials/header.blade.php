<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description"
          content="attendance, client management, finance, freelance, freelancer, goal tracking, Income Managment, lead management, payroll, project management, project manager, support ticket, task management, timecard">
    <meta name="keywords"
          content="	attendance, client management, finance, freelance, freelancer, goal tracking, Income Managment, lead management, payroll, project management, project manager, support ticket, task management, timecard">
    <title>Ecommerce Website</title>
            <link rel="icon" href="/frontend/img/logo.png" type="image/png">
        <!-- =============== VENDOR STYLES ===============-->
    <!-- FONT AWESOME-->
    <link rel="stylesheet" href="/admin/css/font-awesome.min.css">
    <!-- SIMPLE LINE ICONS-->
    <link rel="stylesheet" href="/admin/css/simple-line-icons.css">
    <!-- ANIMATE.CSS-->
    <link rel="stylesheet" href="/admin/css/animate.min.css">
    <!-- =============== PAGE VENDOR STYLES ===============-->

    <!-- =============== APP STYLES ===============-->
                <!-- =============== BOOTSTRAP STYLES ===============-->
        <link rel="stylesheet" href="/admin/css/bootstrap.min.css" id="bscss">
        <link rel="stylesheet" href="/admin/css/app.css" id="maincss">
            <link id="autoloaded-stylesheet" rel="stylesheet"
              href="/admin/css/bg-danger-dark.css">


    <!-- SELECT2-->

    <link rel="stylesheet" href="/admin/css/select2.min.css">
    <link rel="stylesheet"
          href="/admin/css/select2-bootstrap.min.css">

    <!-- Datepicker-->
    <link rel="stylesheet" href="/admin/css/datepicker.min.css">

    <link rel="stylesheet" href="/admin/css/timepicker.min.css">

    <!-- Toastr-->
    <link rel="stylesheet" href="/admin/css/toastr.min.css">
    <!-- Data Table  CSS -->
    <link rel="stylesheet" href="/admin/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/admin/css/dataTables.colVis.min.css">
    <link rel="stylesheet" href="/admin/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/admin/css/responsive.dataTables.min.css">
    <!-- summernote Editor -->

    <link href="/admin/css/summernote.min.css" rel="stylesheet"
          type="text/css">

    <!-- bootstrap-slider -->
    <link href="/admin/css/bootstrap-slider.min.css" rel="stylesheet">
    <!-- chartist -->
    <link href="/admin/css/morris.min.css" rel="stylesheet">

    <!--- bootstrap-select ---->
    <link href="/admin/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/admin/css/chat.min.css" rel="stylesheet">

    <!-- JQUERY-->
    <script src="/admin/js/jquery.min.js"></script>
    <!-- =============== Toastr ===============-->
    <script src="/admin/js/toastr.min.js"></script>
    <!-- =============== Toastr ===============-->

    <link href="/admin/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/vendor/fancybox/jquery.fancybox.css') }}" media="screen">
    <link rel="stylesheet" href="{{ asset('/admin/css/style.css') }}" media="screen">
    @yield('styles')
    <script src="/admin/js/bootstrap-toggle.min.js"></script>

</head>
<script type="text/javascript">
    function startTime() {
        var c_time = new Date();
        var time = new Date(c_time.toLocaleString('en-US', {timeZone: 'Asia/Kathmandu'}));
        var date = time.getDate();
        var month = time.getMonth() + 1;
        var years = time.getFullYear();
        var hr = time.getHours();
        var hour = time.getHours();
        var min = time.getMinutes();
        var minn = time.getMinutes();
        var sec = time.getSeconds();
        var secc = time.getSeconds();
        if (date <= 9) {
            var dates = "0" + date;
        } else {
            dates = date;
        }
        if (month <= 9) {
            var months = "0" + month;
        } else {
            months = month;
        }
                var ampm = ' ';

        if (hr < 10) {
            hr = " " + hr
        }
        if (min < 10) {
            min = "0" + min
        }
        if (sec < 10) {
            sec = "0" + sec
        }
        document.getElementById('txt').innerHTML = hr + ":" + min + ":" + sec + ampm;
        var t = setTimeout(function () {
            startTime()
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }
        ;  // add zero in front of numbers < 10
        return i;
    }

</script>
<body onload="startTime();" class="">
<div class="wrapper">
    <!-- top navbar-->

<header class="topnavbar-wrapper">
    <!-- START Top Navbar-->
    <nav role="navigation" class="navbar topnavbar">
        <!-- START navbar header-->
                <div class="navbar-header">
                            <a href="{{ url('/auth/dashboard') }}" class="navbar-brand">
                    <div class="brand-logo">
                        <img src="/images/admin_logo.png" alt="App Logo"
                             class="img-responsive">
                    </div>
                    <div class="brand-logo-collapsed">
                        <img src="/images/favicon.png" alt="App Logo"
                             class="img-responsive">
                    </div>
                </a>
                    </div>
        <!-- END navbar header-->
        <!-- START Nav wrapper-->
        <div class="nav-wrapper">
            <!-- START Left navbar-->
            <ul class="nav navbar-nav">
                <li>
                    <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                    <a href="#" data-toggle-state="aside-collapsed" class="hidden-xs">
                        <em class="fa fa-navicon"></em>
                    </a>
                    <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                    <a href="#" data-toggle-state="aside-toggled" data-no-persist="true"
                       class="visible-xs sidebar-toggle">
                        <em class="fa fa-navicon"></em>
                    </a>
                </li>
                <!-- END User avatar toggle-->
                <!-- START lock screen-->
                <li class="hidden-xs">
                    <a href="" class="text-center" style="vertical-align: middle;font-size: 20px;">E-commerce Website</a>
                </li>
                <!-- END lock screen-->
            </ul>
            <!-- END Left navbar-->
            <!-- START Right Navbar-->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                    <ul class="dropdown-menu animated zoomIn">
                        <li>
                            <a href="{{ route('products.create') }}">New Product</a>
                        </li>
                        <li>
                            <a href="{{ route('sales.create') }}">New Sale</a>
                        </li>
                        <li>
                            <a href="{{ route('orders.index') }}">View Order</a>
                        </li>
                        <li>
                            <a href="{{ url('/auth/finance/account-statement') }}">Finance</a>
                        </li>
                        @if(Auth::user()->admin())
                        <li>
                            <a href="{{ route('blogs.create') }}">New Blog</a>
                        </li>
                        <li>
                            <a href="{{ route('category.index') }}">New Category</a>
                        </li>
                        <li>
                            <a href="{{ route('users.create') }}">New User</a>
                        </li>
                        <li>
                            <a href="{{ route('ads.create') }}">New Ad</a>
                        </li>
                        <li>
                            <a href="{{ route('sales.create') }}">New Sale</a>
                        </li>
                        <li>
                            <a href="{{ route('cities.create') }}">New City</a>
                        </li>
                        <li>
                            <a href="{{ route('areas.create') }}">New Area</a>
                        </li>
                        <li>
                            <a href="#">New Advertisement</a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/uploads/users/{{ \Auth::user()->image }}" class="img-xs user-image"
                             alt="User Image"/>
                        <span class="hidden-xs">{{ \Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu animated zoomIn">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/uploads/users/{{ \Auth::user()->image }}" class="img-circle" alt="User Image"/>
                            <p>
                                {{ \Auth::user()->name }}
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('users.show', \Auth::user()->id) }}"
                                   class="btn btn-default btn-flat">Update Profile</a>
                            </div>
                            <form method="post" action="{{ route('logout') }}"  class="form-horizontal">
                              @csrf
                                <input type="hidden" name="clock_time" value="" id="time">
                                <div class="pull-right">
                                    <button type="submit"
                                            class="btn btn-default btn-flat">Log Out</button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- END Right Navbar-->
        </div>
        <!-- END Nav wrapper-->
    </nav>
    <!-- END Top Navbar-->
</header>
@include('admin.partials.aside')
