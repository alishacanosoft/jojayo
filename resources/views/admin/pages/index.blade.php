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
      <!-- Morris.js charts -->
      <script src="/admin/js/raphael.min.js"></script>
      <script src="/admin/js/morris.min.js"></script>
      <!-- / Chart.js Script -->
      <script src="/admin/js/chart.min.js" type="text/javascript"></script>
   </div>
</div>
@endsection