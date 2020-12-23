@extends('admin.layouts.master')
@section('styles')
    <style type="text/css">
        .mt-sm {
            font-size: 14px;
        }

        .close-btn {
            font-weight: 100;
            position: absolute;
            right: 10px;
            top: -10px;
            display: none;
        }

        .close-btn i {
            font-weight: 100;
            color: #89a59e;
        }

        .report:hover .close-btn {
            display: block;
        }

        .mt-lg:hover .close-btn {
            display: block;
        }
        .flex{
            display: flex;
        }
        .card {
            margin-bottom: 1.875rem;
            border: none;
            -webkit-box-shadow: 0 2px 1px rgba(0,0,0,.05);
            box-shadow: 0 2px 1px rgb(0 0 0 / 45%);
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-clip: border-box;
            border-radius: .27rem;
            background: #fff;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgb(0 0 0 / 25%);
        }
        .card-header, .card-subtitle, .card-text:last-child {
            margin-bottom: 0;
        }
        .card, .card-footer, .card-header {
            background-color: #FFF;
        }
        .card-header .card-title {
            margin-bottom: 0;
        }

        .card .card-title {
            font-weight: 500;
            letter-spacing: .05rem;
            font-size: 1.5rem;
            line-height: 1.2;
            color: #373A3C;
            margin-top: 0.5px;
        }
        .card-body {
            flex: 1 1 auto;
            padding: 1.5rem;
        }

        .card-row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-for-vendor{
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 33.33333%;
            -moz-box-flex: 0;
            -ms-flex: 0 0 33.33333%;
            flex: 0 0 33.33333%;
            max-width: 33.33333%;
        }

        .vendorcard {
            margin-bottom: 1.875rem;
            border: none;
            box-shadow: 0 2px 1px rgba(0,0,0,.05);
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            background-clip: border-box;
            border-radius: .27rem;
            background-color: #FFF;
        }
        .d-flex {
            display: flex!important;
        }

        .media {
            display: flex;
            align-items: flex-start;
            overflow: inherit !important;
        }

        .text-muted {
            color: #55595C !important;
        }
        .vendorcard-body {
            flex: 1 1 auto;
            padding: 0 10px 17px 25px;
        }

        card .card-title-text {
            font-weight: 500;
            letter-spacing: .05rem;
            font-size: 2.5rem;
            line-height: 1.2;
            color: #373A3C;
            margin-top: 0.5px;
        }
        .card-box-body {
            flex: 1 1 auto;
            padding: 1.5rem;
        }

        .align-self-center {
            align-self: center !important;
            margin: 20px 40px 0 0;
        }
        .icon-action-redo, .icon-action-undo, .icon-anchor, .icon-arrow-down, .icon-arrow-down-circle, .icon-arrow-left, .icon-arrow-left-circle, .icon-arrow-right, .icon-arrow-right-circle, .icon-arrow-up, .icon-arrow-up-circle, .icon-badge, .icon-bag, .icon-ban, .icon-basket, .icon-basket-loaded, .icon-bell, .icon-book-open, .icon-briefcase, .icon-bubble, .icon-bubbles, .icon-bulb, .icon-calculator, .icon-calendar, .icon-call-end, .icon-call-in, .icon-call-out, .icon-camera, .icon-camrecorder, .icon-chart, .icon-check, .icon-chemistry, .icon-clock, .icon-close, .icon-cloud-download, .icon-cloud-upload, .icon-compass, .icon-control-end, .icon-control-forward, .icon-control-pause, .icon-control-play, .icon-control-rewind, .icon-control-start, .icon-credit-card, .icon-crop, .icon-cup, .icon-cursor, .icon-cursor-move, .icon-diamond, .icon-direction, .icon-directions, .icon-disc, .icon-dislike, .icon-doc, .icon-docs, .icon-drawer, .icon-drop, .icon-earphones, .icon-earphones-alt, .icon-emotsmile, .icon-energy, .icon-envelope, .icon-envelope-letter, .icon-envelope-open, .icon-equalizer, .icon-event, .icon-exclamation, .icon-eye, .icon-eyeglass, .icon-feed, .icon-film, .icon-fire, .icon-flag, .icon-folder, .icon-folder-alt, .icon-frame, .icon-game-controller, .icon-ghost, .icon-globe, .icon-globe-alt, .icon-graduation, .icon-graph, .icon-grid, .icon-handbag, .icon-heart, .icon-home, .icon-hourglass, .icon-info, .icon-key, .icon-layers, .icon-like, .icon-link, .icon-list, .icon-location-pin, .icon-lock, .icon-lock-open, .icon-login, .icon-logout, .icon-loop, .icon-magic-wand, .icon-magnet, .icon-magnifier, .icon-magnifier-add, .icon-magnifier-remove, .icon-map, .icon-menu, .icon-microphone, .icon-minus, .icon-mouse, .icon-music-tone, .icon-music-tone-alt, .icon-mustache, .icon-note, .icon-notebook, .icon-options, .icon-options-vertical, .icon-organization, .icon-paper-clip, .icon-paper-plane, .icon-paypal, .icon-pencil, .icon-people, .icon-phone, .icon-picture, .icon-pie-chart, .icon-pin, .icon-plane, .icon-playlist, .icon-plus, .icon-power, .icon-present, .icon-printer, .icon-puzzle, .icon-question, .icon-refresh, .icon-reload, .icon-rocket, .icon-screen-desktop, .icon-screen-smartphone, .icon-screen-tablet, .icon-settings, .icon-share, .icon-share-alt, .icon-shield, .icon-shuffle, .icon-size-actual, .icon-size-fullscreen, .icon-social-behance, .icon-social-dribbble, .icon-social-dropbox, .icon-social-facebook, .icon-social-foursqare, .icon-social-github, .icon-social-google, .icon-social-instagram, .icon-social-linkedin, .icon-social-pinterest, .icon-social-reddit, .icon-social-skype, .icon-social-soundcloud, .icon-social-spotify, .icon-social-steam, .icon-social-stumbleupon, .icon-social-tumblr, .icon-social-twitter, .icon-social-vkontakte, .icon-social-youtube, .icon-speech, .icon-speedometer, .icon-star, .icon-support, .icon-symbol-female, .icon-symbol-male, .icon-tag, .icon-target, .icon-trash, .icon-trophy, .icon-umbrella, .icon-user, .icon-user-female, .icon-user-follow, .icon-user-following, .icon-user-unfollow, .icon-vector, .icon-volume-1, .icon-volume-2, .icon-volume-off, .icon-wallet, .icon-wrench {
            font-family: simple-line-icons;
            speak: none;
            font-style: normal;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .danger {
            color: #DA4453!important;
        }
        .font-large-2 {
            font-size: 4rem!important;
        }
        .icon-heart:before {
            content: "\e08a";
        }

        /*.inner-body{*/
        /*    flex: 1;*/
        /*}*/
        .success {
            color: #37BC9B!important;
        }
        .info {
            color: #2692b8 !important;
        }
        @media only screen and (width: 768px) {
            .align-self-center {
                align-self: center !important;
                margin: 20px 8px 0 0;
            }
            .font-large-2 {
                font-size: 3rem!important;
            }
        }


    </style>
@endsection
@section('content')
    <?php $currentrole = \Auth::user()->roles;
    $currentname = \Auth::user()->name;?>
<div class="row">
   <div class="col-lg-12">
       @if($currentrole == "admin")
           <div class="dashboard">
               <!--        ******** transactions ************** -->
               <div id="report_menu" class="row">
                   <div class="col-sm-4 report" id="1">
                       <strong data-toggle="tooltip" data-placement="top" style="cursor:pointer" class="close-btn" title="Inactive" data-fade-out-on-success="#1" data-act="ajax-request" data-action-url="admin/settings/save_dashboard/1/0"><i class='fa fa-times-circle'></i></strong>
                       <div class="panel report_menu">
                           <div class="row row-table row-flush">
                               <div class="col-xs-6 bb br">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center text-info">
                                           <a href="{{ route('orders.create') }}"><em class="fa fa-plus fa-2x"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('products.create') }}">Add Product</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xs-6 bb">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center text-danger">
                                           <a href="{{ route('products.index') }}"><em class="fa fa-list fa-2x text-danger"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('products.index') }}">Total Products ({{ count(\App\Models\Product::get()) }})</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="row row-table row-flush">
                               <div class="col-xs-6 br">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center">
                                           <a href="{{ route('users.create') }}"><em class="fa fa-plus fa-2x text-info"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('users.create') }}">Add User</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xs-6">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center text-danger">
                                           <a href="{{ route('users.index') }}"><em class="fa fa-list fa-2x text-danger"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('users.index') }}">Total Users ({{ count(\App\User::get()) }})</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <!--        ******** Sales ************** -->
                   <div class="col-sm-4 report" id="2">
                       <strong data-toggle="tooltip" data-placement="top" style="cursor:pointer" class="close-btn" title="Inactive" data-fade-out-on-success="#2" data-act="ajax-request" data-action-url="admin/settings/save_dashboard/2/0"><i class='fa fa-times-circle'></i></strong>
                       <div class="panel report_menu">
                           <div class="row row-table row-flush">
                               <div class="col-xs-6 bb br">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center ">
                                           <a href="{{ route('page.create') }}"><em class="fa fa-plus fa-2x"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('page.create') }}">Add Page</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xs-6 bb">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center">
                                           <a href="{{ route('page.index') }}"><em class="fa fa-list fa-2x text-purple"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('page.index') }}"> List Page ({{ count(\App\Models\Page::get()) }})</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="row row-table row-flush">
                               <div class="col-xs-6 br">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center">
                                           <a href="{{ route('blogs.create') }}"><em class="fa fa-plus fa-2x text-purple"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('blogs.create') }}">Add Blog</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xs-6">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center">
                                           <a href="{{ route('blogs.index') }}"><em class="fa fa-list fa-2x text-danger"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('blogs.index') }}"> List Blog ({{ count(\App\Models\Blog::get()) }})</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <!--        ******** Ticket ************** -->
                   <div class="col-sm-4 report" id="3">
                       <strong data-toggle="tooltip" data-placement="top" style="cursor:pointer" class="close-btn" title="Inactive" data-fade-out-on-success="#3" data-act="ajax-request" data-action-url="admin/settings/save_dashboard/3/0"><i class='fa fa-times-circle'></i></strong>
                       <div class="panel report_menu">
                           <div class="row row-table row-flush">
                               <div class="col-xs-6 bb br">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center">
                                           <a href="{{ route('cities.create') }}"><em class="fa fa-plus fa-2x text-danger"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('cities.create') }}">Add Location</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xs-6 bb">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center">
                                           <a href="{{ route('cities.index') }}"><em class="fa fa-list fa-2x text-danger"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('cities.index') }}"> List Cities ({{ count(\App\Models\City::get()) }})</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="row row-table row-flush">
                               <div class="col-xs-6 br">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center">
                                           <a href="{{ route('ads.create') }}"><em class="fa fa-plus fa-2x text-purple"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('ads.create') }}">Add Ads</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xs-6">
                                   <div class="row row-table row-flush">
                                       <div class="col-xs-2 text-center">
                                           <a href="{{ route('ads.index') }}"><em class="fa fa-list fa-2x text-purple"></em></a>
                                       </div>
                                       <div class="col-xs-10">
                                           <div class="text-center">
                                               <h4 class="mt-sm mb0"><a href="{{ route('ads.index') }}">List Ads ({{ count(\App\Models\Ads::get()) }})</a></h4>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- Simple Pie Chart -->
               <div class="row flex table-responsive">
                   <div class="col-sm-6">
                       <div class="card">
                           <div class="card-content">
                               <div class="card-header">
                                   <h4 class="card-title">Users Pie Chart</h4>
                               </div>
                               <div class="card-body">
                                   <div id="basic-pie" style="width: 500px; height: 400px;"></div>
                               </div>
                           </div>
                       </div>
                   </div>


                   <!-- Simple Doughnut Chart -->
                   <div class="col-sm-6">
                       <div class="card">
                           <div class="card-header">
                               <h4 class="card-title">Order's Doughnut Chart</h4>
                           </div>
                           <div class="card-content">
                               <div class="card-body">
                                   <div id="doughnut" style="width: 500px; height: 400px;"></div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <div class="row">
                   <div class="col-sm-12">
                       <div class="card">
                           <div class="card-header">
                               <h4 class="card-title">Ordered Recieved vs. Delivered Bar Graph</h4>
                           </div>
                           <div class="card-content collapse show">
                               <div class="card-body">
                                   <div id="stacked-column" style="height: 400px"></div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <div class="clearfix visible-sm-block "></div>
               <div id="menu" class="row">

                   <script type="text/javascript">
                       // Function to slug string
                       function slugify(string) {
                           return string
                               .toString()
                               .trim()
                               .toLowerCase()
                               .replace(/\s+/g, "-")
                               .replace(/[^\w\-]+/g, "")
                               .replace(/\-\-+/g, "-")
                               .replace(/^-+/, "")
                               .replace(/-+$/, "");
                       }
                   </script>
               </div>
           </div>
       @elseif($currentrole == "vendor")
{{--                $array_length = count($vendorChart->categoryAssigned);--}}
{{--           --}}
           <div class="dashboard">
               <div class="row">
                   <div class="col-sm-4">
                       <div class="card">
                           <div class="vendorcard-body">
                               <div class="medias d-flex">
                                   <div class="align-self-center">
                                       <i class="icon-wallet success font-large-2"></i>
                                   </div>
                                   <div class="inner-body">
                                       <h3>$15,678</h3>
                                       <span class="text-muted">Total Cost</span>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="col-sm-4">
                       <div class="card">
                           <div class="vendorcard-body">
                               <div class="medias d-flex">
                                   <div class="align-self-center">
                                       <i class="icon-heart danger font-large-2"></i>
                                   </div>
                                   <div class="inner-body">
                                       <h3>$15,678</h3>
                                       <span class="text-muted">Total Revenue Generated</span>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="col-sm-4">
                       <div class="card">
                           <div class="vendorcard-body">
                               <div class="medias d-flex">
                                   <div class="align-self-center">
                                       <i class="icon-star info font-large-2"></i>
                                   </div>
                                   <div class="inner-body">
                                       <h3>$15,678</h3>
                                       <span class="text-muted">Total Profits generated</span>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
{{--                   <!-- Simple Doughnut Chart -->--}}
               <div class="row flex table-responsive">
                   <div class="col-sm-12">
                       <div class="card">
                           <div class="card-header">
                               <h4 class="card-title">Product status Doughnut Chart</h4>
                           </div>
                           <div class="card-content">
                               <div class="card-body">
                                   <div id="doughnut" style="width: 1050px; height: 400px;"></div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       @endif
   </div>
</div>
@endsection

@section('scripts')
    <script>
        $(window).on("load", function () {
            var currentrole = "{!! $currentrole !!}";
            var currentname = "{!! $currentname !!}";

            if (currentrole ==="admin") {
                // Simple pie char - jojayo user types display and track
                // ------------------------------
                require.config({paths: {echarts: "../../../app-assets/vendors/js/charts/echarts"}}),
                    require(["echarts", "echarts/chart/pie", "echarts/chart/funnel"], function (e) {
                        var t = e.init(document.getElementById("basic-pie"));
                        (chartOptions = {
                            title: {text: "Jojayo User Types", subtext: "Jojayo current registered users", x: "center"},
                            tooltip: {trigger: "item", formatter: "{a} <br/>{b}: {c} ({d}%)"},
                            legend: {orient: "vertical", x: "left", data: ["Vendor", "Admin", "Customer"]},
                            color: ["#FF7D4D", "#FF4558", "#28D094"],
                            toolbox: {
                                show: !0,
                                orient: "vertical",
                                feature: {
                                    restore: {show: !0, title: "Restore"},
                                    dataView: {
                                        show: !0,
                                        readOnly: 1,
                                        title: "View data",
                                        lang: ["View chart data", "Close", "Update"]
                                    },
                                    magicType: {
                                        show: !0,
                                        title: {funnel: "Switch to funnel", pie: "Switch to pies"},
                                        type: ["funnel", "pie"],
                                        option: {
                                            funnel: {
                                                x: "25%",
                                                y: "20%",
                                                width: "50%",
                                                height: "70%",
                                                funnelAlign: "left",
                                                max: 1548
                                            }
                                        }
                                    },
                                    saveAsImage: {show: !0, title: "Same as image", lang: ["Save"]},
                                },
                            },
                            calculable: !0,
                            series: [
                                {
                                    name: "Jojayo Users",
                                    type: "pie",
                                    radius: "70%",
                                    center: ["50%", "57.5%"],
                                    data: [
                                        {value:   {!! $vendor; !!} , name: "Vendor"},
                                        {value: {!! $admin; !!}, name: "Admin"},
                                        {value: {!! $customer; !!}, name: "Customer"},
                                    ],
                                },
                            ],
                        }),
                            t.setOption(chartOptions),
                            $(function () {
                                function e() {
                                    setTimeout(function () {
                                        t.resize();
                                    }, 200);
                                }

                                $(window).on("resize", e), $(".menu-toggle").on("click", e);
                            });
                    });

                // Simple doughnut chart - all current order status
                // ------------------------------
                require.config({paths: {echarts: "../../../app-assets/vendors/js/charts/echarts"}}),
                    require(["echarts", "echarts/chart/pie", "echarts/chart/funnel"], function (e) {
                        var t = e.init(document.getElementById("doughnut"));
                        (chartOptions = {
                            title: {
                                text: "Current Order Status",
                                subtext: "All current Jojayo order status",
                                x: "center"
                            },
                            tooltip: {trigger: "item", formatter: "{a} <br/>{b}: {c} ({d}%)"},
                            legend: {
                                orient: "vertical",
                                x: "left",
                                data: ["Verified", "Packed", "Shipped", "Delivered"]
                            },
                            color: ["#626E82", "#FF7D4D", "#FF4558", "#28D094"],
                            toolbox: {
                                show: !0,
                                orient: "vertical",
                                feature: {
                                    restore: {show: !0, title: "Restore"},
                                    dataView: {
                                        show: !0,
                                        readOnly: 1,
                                        title: "View data",
                                        lang: ["View chart data", "Close", "Update"]
                                    },
                                    magicType: {
                                        show: !0,
                                        title: {funnel: "Switch to funnel", pie: "Switch to doughnut"},
                                        type: ["funnel", "pie"],
                                        option: {
                                            funnel: {
                                                x: "25%",
                                                y: "20%",
                                                width: "50%",
                                                height: "70%",
                                                funnelAlign: "left",
                                                max: 1548
                                            }
                                        }
                                    },
                                    saveAsImage: {show: !0, title: "Same as image", lang: ["Save"]},
                                },
                            },
                            calculable: !0,
                            series: [
                                {
                                    name: "Order Status",
                                    type: "pie",
                                    radius: ["50%", "70%"],
                                    center: ["50%", "57.5%"],
                                    data: [
                                        {value: {!! $verified; !!}, name: "Verified"},
                                        {value: {!! $packed; !!}, name: "Packed"},
                                        {value: {!! $shipped; !!}, name: "Shipped"},
                                        {value: {!! $delivered; !!}, name: "Delivered"},
                                    ],
                                },
                            ],
                        }),
                            t.setOption(chartOptions),
                            $(function () {
                                function e() {
                                    setTimeout(function () {
                                        t.resize();
                                    }, 200);
                                }

                                $(window).on("resize", e), $(".menu-toggle").on("click", e);
                            });
                    });

                // Stacked column chart - ordered vs delivered per months
                // ------------------------------

                // Set paths
                // ------------------------------
                require.config({
                    paths: {
                        echarts: '../../../app-assets/vendors/js/charts/echarts'
                    }
                });


                // Configuration
                // ------------------------------

                require(
                    [
                        'echarts',
                        'echarts/chart/bar',
                        'echarts/chart/line'
                    ],


                    // Charts setup
                    function (ec) {
                        // Initialize chart
                        // ------------------------------
                        var myChart = ec.init(document.getElementById('stacked-column'));

                        // Chart Options
                        // ------------------------------
                        chartOptions = {

                            // Setup grid
                            grid: {
                                x: 40,
                                x2: 40,
                                y: 45,
                                y2: 25
                            },

                            // Add tooltip
                            tooltip: {
                                trigger: 'axis',
                                axisPointer: {            // Axis indicator axis trigger effective
                                    type: 'shadow'        // The default is a straight line, optionally: 'line' | 'shadow'
                                }
                            },

                            toolbox: {
                                show: !0,
                                orient: "vertical",
                                feature: {
                                    restore: {show: !0, title: "Restore"},
                                    saveAsImage: {show: !0, title: "Same as image", lang: ["Save"]},
                                },
                            },

                            // Add legend
                            legend: {
                                data: ['Ordered', 'Delivered']
                            },

                            // Add custom colors
                            color: ['#c23731', '#2f4554'],

                            // Enable drag recalculate
                            calculable: true,

                            // Horizontal axis
                            xAxis: [{
                                type: 'category',
                                data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec']
                            }],

                            // Vertical axis
                            yAxis: [{
                                type: 'value',
                            }],

                            // Add series
                            series: [
                                {
                                    name: 'Ordered',
                                    type: 'bar',
                                    itemStyle: {normal: {label: {show: true, position: 'inside'}}},
                                    data: [<?php foreach ($allorders as $all) {
                                        echo $all;
                                    } ?>]
                                },
                                {
                                    name: 'Delivered',
                                    type: 'bar',
                                    itemStyle: {normal: {label: {show: true, position: 'inside'}}},
                                    data: [<?php foreach ($alldelivered as $alld) {
                                        echo $alld;
                                    } ?>],
                                },
                            ]
                        };

                        // Apply options
                        // ------------------------------

                        myChart.setOption(chartOptions);


                        // Resize chart
                        // ------------------------------

                        $(function () {

                            // Resize chart on menu width change and window resize
                            $(window).on('resize', resize);
                            $(".menu-toggle").on('click', resize);

                            // Resize function
                            function resize() {
                                setTimeout(function () {

                                    // Resize chart
                                    myChart.resize();
                                }, 200);
                            }
                        });
                    }
                );
            }else if(currentrole ==="vendor"){
                // Simple doughnut chart - vendor's product verifications status
                // ------------------------------
                require.config({paths: {echarts: "../../../app-assets/vendors/js/charts/echarts"}}),
                    require(["echarts", "echarts/chart/pie", "echarts/chart/funnel"], function (e) {
                        var t = e.init(document.getElementById("doughnut"));
                        (chartOptions = {
                            title: {
                                text: currentname+"'s product status",
                                subtext: "Jojayo vendor product approval status for sales",
                                x: "center"
                            },
                            tooltip: {trigger: "item", formatter: "{a} <br/>{b}: {c} ({d}%)"},
                            legend: {
                                orient: "vertical",
                                x: "left",
                                data: ["Active", "Inactive", "Verified"]
                            },
                            color: ["#FF7D4D", "#FF4558", "#28D094"],
                            toolbox: {
                                show: !0,
                                orient: "vertical",
                                feature: {
                                    restore: {show: !0, title: "Restore"},
                                    dataView: {
                                        show: !0,
                                        readOnly: 1,
                                        title: "View data",
                                        lang: ["View chart data", "Close", "Update"]
                                    },
                                    magicType: {
                                        show: !0,
                                        title: {funnel: "Switch to funnel", pie: "Switch to doughnut"},
                                        type: ["funnel", "pie"],
                                        option: {
                                            funnel: {
                                                x: "25%",
                                                y: "20%",
                                                width: "50%",
                                                height: "70%",
                                                funnelAlign: "left",
                                                max: 1548
                                            }
                                        }
                                    },
                                    saveAsImage: {show: !0, title: "Same as image", lang: ["Save"]},
                                },
                            },
                            calculable: !0,
                            series: [
                                {
                                    name: "Order Status",
                                    type: "pie",
                                    radius: ["50%", "70%"],
                                    center: ["50%", "57.5%"],
                                    data: [
                                        {value: {!! $productactive; !!}, name: "Active"},
                                        {value: {!! $productinactive; !!}, name: "Inactive"},
                                        {value: {!! $productVerified; !!}, name: "Verified"},
                                    ],
                                },
                            ],
                        }),
                            t.setOption(chartOptions),
                            $(function () {
                                function e() {
                                    setTimeout(function () {
                                        t.resize();
                                    }, 200);
                                }

                                $(window).on("resize", e), $(".menu-toggle").on("click", e);
                            });
                    });
            }
        });
    </script>

@endsection
