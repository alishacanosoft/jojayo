@extends('admin.layouts.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
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

      </style>
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

   </div>
</div>
@endsection

@section('scripts')

    <script>
        // Simple pie char - jojayo user types display and track
        // ------------------------------
        $(window).on("load", function () {
            require.config({ paths: { echarts: "../../../app-assets/vendors/js/charts/echarts" } }),
                require(["echarts", "echarts/chart/pie", "echarts/chart/funnel"], function (e) {
                    var t = e.init(document.getElementById("basic-pie"));
                    (chartOptions = {
                        title: { text: "Jojayo User Types", subtext: "Jojayo current registered users", x: "center" },
                        tooltip: { trigger: "item", formatter: "{a} <br/>{b}: {c} ({d}%)" },
                        legend: { orient: "vertical", x: "left", data: ["Vendor", "Admin", "Customer"] },
                        color: ["#FF7D4D", "#FF4558", "#28D094"],
                        toolbox: {
                            show: !0,
                            orient: "vertical",
                            feature: {
                                restore: { show: !0, title: "Restore" },
                                dataView: { show: !0, readOnly: 1, title: "View data", lang: ["View chart data", "Close", "Update"] },
                                magicType: { show: !0, title: { funnel: "Switch to funnel" ,pie: "Switch to pies" }, type: ["funnel", "pie"], option: { funnel: { x: "25%", y: "20%", width: "50%", height: "70%", funnelAlign: "left", max: 1548 } } },
                                saveAsImage: { show: !0, title: "Same as image", lang: ["Save"] },
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
                                    { value:   {!! $vendor; !!} , name: "Vendor" },
                                    { value: {!! $admin; !!}, name: "Admin" },
                                    { value: {!! $customer; !!}, name: "Customer" },
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
        });

        // Simple doughnut chart - all current order status
        // ------------------------------
        $(window).on("load", function () {
            require.config({ paths: { echarts: "../../../app-assets/vendors/js/charts/echarts" } }),
                require(["echarts", "echarts/chart/pie", "echarts/chart/funnel"], function (e) {
                    var t = e.init(document.getElementById("doughnut"));
                    (chartOptions = {
                        title: { text: "Current Order Status", subtext: "All current Jojayo order status", x: "center" },
                        tooltip: { trigger: "item", formatter: "{a} <br/>{b}: {c} ({d}%)" },
                        legend: { orient: "vertical", x: "left", data: ["Verified", "Packed", "Shipped", "Delivered"] },
                        color: ["#626E82", "#FF7D4D", "#FF4558", "#28D094"],
                        toolbox: {
                            show: !0,
                            orient: "vertical",
                            feature: {
                                restore: { show: !0, title: "Restore" },
                                dataView: { show: !0, readOnly: 1, title: "View data", lang: ["View chart data", "Close", "Update"] },
                                magicType: { show: !0, title: { funnel: "Switch to funnel", pie: "Switch to doughnut" }, type: ["funnel", "pie"], option: { funnel: { x: "25%", y: "20%", width: "50%", height: "70%", funnelAlign: "left", max: 1548 } } },
                                saveAsImage: { show: !0, title: "Same as image", lang: ["Save"] },
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
                                    { value: {!! $verified; !!}, name: "Verified" },
                                    { value: {!! $packed; !!}, name: "Packed" },
                                    { value: {!! $shipped; !!}, name: "Shipped" },
                                    { value: {!! $delivered; !!}, name: "Delivered" },
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
        });



        // Stacked column chart - ordered vs delivered per months
        // ------------------------------
        $(window).on("load", function(){

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
                        tooltip : {
                            trigger: 'axis',
                            axisPointer : {            // Axis indicator axis trigger effective
                                type : 'shadow'        // The default is a straight line, optionally: 'line' | 'shadow'
                            }
                        },

                        toolbox: {
                            show: !0,
                            orient: "vertical",
                            feature: {
                                restore: { show: !0, title: "Restore" },
                                saveAsImage: { show: !0, title: "Same as image", lang: ["Save"] },
                            },
                        },

                        // Add legend
                        legend: {
                            data: [ 'Ordered', 'Delivered']
                        },

                        // Add custom colors
                        color: ['#c23731', '#2f4554'],

                        // Enable drag recalculate
                        calculable: true,

                        // Horizontal axis
                        xAxis: [{
                            type: 'category',
                            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July','Aug', 'Sept','Oct', 'Nov', 'Dec']
                        }],

                        // Vertical axis
                        yAxis: [{
                            type: 'value',
                        }],

                        // Add series
                        series : [
                            {
                                name:'Ordered',
                                type:'bar',
                                itemStyle : { normal: {label : {show: true, position: 'inside'}}},
                                data:[<?php foreach($allorders as $all){echo $all;} ?>]
                            },
                            {
                                name:'Delivered',
                                type:'bar',
                                itemStyle : { normal: {label : {show: true, position: 'inside'}}},
                                data:[<?php foreach($alldelivered as $alld){echo $alld;} ?>],
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
                            setTimeout(function() {

                                // Resize chart
                                myChart.resize();
                            }, 200);
                        }
                    });
                }
            );
        });

    </script>


    <!-- Morris.js charts -->
    <script src="/admin/js/raphael.min.js"></script>
    <script src="/admin/js/morris.min.js"></script>
    <!-- / Chart.js Script -->
    <script src="/admin/js/chart.min.js" type="text/javascript"></script>
@endsection
