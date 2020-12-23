@extends('admin.layouts.master')
@section('styles')
<style>
.dropbtn { background-color: transparent; color: black; padding: 16px; border: none; }
.dropdown { position: relative; display: inline-block; }
.dropdown-content { display: none; position: absolute; background-color: #f1f1f1; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; }
.dropdown-content a { color: black; padding: 12px 16px; text-decoration: none; display: block; }
.dropdown-content a:hover {background-color: #ddd;}
.dropdown:hover .dropdown-content {display: block; z-index:9}
.dropdown-content ul li{ list-style: none;padding: 2px 0;cursor:pointer}

.thumbnail-order{
    position: relative;
    z-index: 0;
}

.thumbnail-order:hover{
    background-color: transparent;
    z-index: 50;
}

.thumbnail-order span{ /*CSS for enlarged image*/
    position: absolute;
    background-color: transparent;
    padding: 5px;
    left: -1000px;
    box-shadow: 1px 1px 3px rgba(0,0,0,.45);
    visibility: hidden;
    color: black;
    text-decoration: none;
}

.thumbnail-order span img{ /*CSS for enlarged image*/
    border-width: 0;
    padding: 2px;
}

.thumbnail-order:hover span{ /*CSS for enlarged image on hover*/
    visibility: visible;
    top: 15%;
    left: -230px; /*position where enlarged image should offset horizontally */
}
td.details-controls {
    text-align:center;
    cursor: pointer;
}
tr.shown td.details-controls {
    text-align:center;
}

.fill{
    width: 100% !important;
}
.btn-transparent{
    background: transparent;
    border: none;
    outline: none;
    color: #5d9cec;
}
.auto{
    padding-left: 0;
    width: 110%;
    text-align: center;
}
</style>
<link rel="stylesheet" type="text/css" href="{{asset('/css/jquery-ui.min.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <?php
    $currentroles = \Auth::user()->roles;

    if($currentroles === "vendor"){
        $currentid = \Auth::user()->id;
        $vendor  = \App\Models\Vendor::where('user_id',$currentid)->first();
        $vendorid = $vendor->id;
    }
    ?>
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-sm-12">
            <div class="nav-tabs-custom">
               <ul class="nav nav-tabs">
                  <li class="@if($active_tab == 'manage') active @endif"><a href="#manage" id="amanage" data-toggle="tab">All Orders</a></li>
                  <li class="@if($active_tab == 'verified') active @endif"><a href="#verified" id="averified" data-toggle="tab">Verified Orders</a></li>
                  <li class="@if($active_tab == 'packed') active @endif"><a href="#packed" id="apacked" data-toggle="tab">Packed Orders</a></li>
                  <li class="@if($active_tab == 'shipped') active @endif"><a href="#shipped" id="ashipped" data-toggle="tab">Shipped Orders</a></li>
                  <li class="@if($active_tab == 'delivered') active @endif"><a href="#delivered" id="adelivered" data-toggle="tab">Delivered Orders</a></li>
                  <input type="hidden" id="base" value="{{ route('ajax.categories') }}">
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane @if($active_tab == 'manage') active @endif" id="manage">
                       <span class="btn btn-link-inline text-primary btn-filter collapsed" type="button" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                          <i class="fa fa-sliders"></i>
                          <span>Show Filter</span><p>Hide Filter</p>
                       </span>
                      <div class="collapse table-responsive " id="collapseFilter">
                          <div class="card card-body">
                              {{--start--}}
                              <div class="row">
                                  <div class="col-md-12">
                                      <!-- left column -->
                                      <div class="box box-primary">
                                          {!! Form::open(['method'=>'post',"id"=>"pdfdownloadForm","target"=>""]) !!}
                                          <div class="box-body">
                                              <div class="row">
                                                  <div class="input-daterange">
                                                      <div class="col-xs-2">
                                                          <div class="input-container">
                                                              <input class="input-field" id="start" type="text" placeholder="Start date" name="start" required>
                                                              <i class="fa fa-calendar icon"></i>
                                                          </div>
                                                      </div>
                                                      <div class="col-xs-2">
                                                          <div class="input-container">
                                                              <input class="input-field" type="text" id="end" placeholder="End date" name="end" required>
                                                              <i class="fa fa-calendar icon"></i>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="col-xs-2">
                                                      <div class="input-container">
                                                          <!-- For defining autocomplete -->
                                                          <input class="input-field auto" type="text" id="order_id" placeholder="Order ID" name="order_id" required>
                                                      </div>
                                                  </div>
                                                  <div class="col-xs-2">
                                                      <div class="input-container">
                                                          <button type="button" id="filter" name="filter" class="btn btn-primary m-b-0 m-r-5 filter-btn" value="active"> Search </button>
                                                          <button type="button" id="refresh" name="refresh" class="btn btn-info m-b-0 m-r-5 filter-btn" value="active"> Refresh </button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          {!! Form::close() !!}
                                      </div>
                                  </div>
                              </div>
                              {{--end--}}
                          </div>
                      </div>
                      <br/>
                      {{--for filters--}}
                     <div class="table-responsive">
                     <table id="all-orders" class="table table-striped table-bordered nowrap" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Order No</th>
                                <th>Purchased by</th>
                                <th>Area</th>
                                <th>Delivery Type</th>
                                <th>Delivery Charge</th>
                                <th>Total Amount</th>
                                <th>Order Created At</th>
                                <th>Update Status</th>
                            </tr>
                        </thead>

                    </table>
                     </div>
                  </div>
                    {{--verified tab--}}
                   <div class="tab-pane @if($active_tab == 'verified') active @endif" id="verified">
                       <span class="btn btn-link-inline text-primary btn-filter collapsed" type="button" data-toggle="collapse" data-target="#collapseVerified" aria-expanded="false" aria-controls="collapseVerified">
                          <i class="fa fa-sliders"></i>
                          <span>Show Filter</span><p>Hide Filter</p>
                       </span>
                       <div class="collapse table-responsive " id="collapseVerified">
                           <div class="card card-body">
                               {{--start--}}
                               <div class="row">
                                   <div class="col-md-12">
                                       <!-- left column -->
                                       <div class="box box-primary">
                                           <form>
                                           <div class="box-body">
                                               <div class="row">
                                                   <div class="input-daterange">
                                                       <div class="col-xs-2">
                                                           <div class="input-container">
                                                               <input class="input-field" id="start_verified" type="text" placeholder="Start date" name="start_verified" required>
                                                               <i class="fa fa-calendar icon"></i>
                                                           </div>
                                                       </div>
                                                       <div class="col-xs-2">
                                                           <div class="input-container">
                                                               <input class="input-field" type="text" id="end_verified" placeholder="End date" name="end_verified" required>
                                                               <i class="fa fa-calendar icon"></i>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="col-xs-2">
                                                       <div class="input-container">
                                                           <!-- For defining autocomplete -->
                                                           <input class="input-field auto" type="text" id="order_ver_id" placeholder="Order ID" name="order_id_verified" required>
                                                       </div>
                                                   </div>
                                                   <div class="col-xs-2">
                                                       <div class="input-container">
                                                           <button type="button" id="filter_verified" name="filter_verified" class="btn btn-primary m-b-0 m-r-5 filter-btn" value="active"> Search </button>
                                                           <button type="button" id="refresh_verified" name="refresh_verified" class="btn btn-info m-b-0 m-r-5 filter-btn" value="active"> Refresh </button>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                           {!! Form::close() !!}
                                       </div>
                                   </div>
                               </div>
                               {{--end--}}
                           </div>
                       </div>
                       <br/>
                       {{--for filters--}}
                     <div class="table-responsive">
                     <table id="verified-table" class="table table-striped table-bordered nowrap fill" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Order No</th>
                                <th>Purchased By</th>
                                <th>Area</th>
                                <th>Delivery Charge</th>
                                <th>Total Amount<sub>(with delivery charge)</sub></th>
                                <th>Order Created At</th>
                                <th>Verified At</th>
                                <th>Update Status</th>
                            </tr>
                        </thead>
                    </table>
                     </div>
                  </div>
                   {{--packed tab--}}
                  <div class="tab-pane @if($active_tab == 'packed') active @endif" id="packed">
                      <span class="btn btn-link-inline text-primary btn-filter collapsed" type="button" data-toggle="collapse" data-target="#collapsePacked" aria-expanded="false" aria-controls="collapsePacked">
                          <i class="fa fa-sliders"></i>
                          <span>Show Filter</span><p>Hide Filter</p>
                       </span>
                      <div class="collapse table-responsive " id="collapsePacked">
                          <div class="card card-body">
                              {{--start--}}
                              <div class="row">
                                  <div class="col-md-12">
                                      <!-- left column -->
                                      <div class="box box-primary">
                                          <form>
                                              <div class="box-body">
                                                  <div class="row">
                                                      <div class="input-daterange">
                                                          <div class="col-xs-2">
                                                              <div class="input-container">
                                                                  <input class="input-field" id="start_packed" type="text" placeholder="Start date" name="start_packed" required>
                                                                  <i class="fa fa-calendar icon"></i>
                                                              </div>
                                                          </div>
                                                          <div class="col-xs-2">
                                                              <div class="input-container">
                                                                  <input class="input-field" type="text" id="end_packed" placeholder="End date" name="end_packed" required>
                                                                  <i class="fa fa-calendar icon"></i>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-xs-2">
                                                          <div class="input-container">
                                                              <!-- For defining autocomplete -->
                                                              <input class="input-field auto" type="text" id="order_id_packed" placeholder="Order ID" name="order_id_packed" required>
                                                          </div>
                                                      </div>
                                                      <div class="col-xs-2">
                                                          <div class="input-container">
                                                              <button type="button" id="filter_packed" name="filter_packed" class="btn btn-primary m-b-0 m-r-5 filter-btn" value="active"> Search </button>
                                                              <button type="button" id="refresh_packed" name="refresh_packed" class="btn btn-info m-b-0 m-r-5 filter-btn" value="active"> Refresh </button>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          {!! Form::close() !!}
                                      </div>
                                  </div>
                              </div>
                              {{--end--}}
                          </div>
                      </div>
                      <br/>
                      {{--for filters--}}
                     <div class="table-responsive">
                     <table id="packed-tables" class="table table-striped table-bordered nowrap fill" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Order No</th>
                                <th>Purchased By</th>
                                <th>Area</th>
                                <th>Delivery Charge</th>
                                <th>Total Amount <sub> (with delivery charge)</sub></th>
                                <th>Order Created At</th>
                                <th>Packed At</th>
                                <th>Update Status</th>
                            </tr>
                        </thead>
                    </table>
                     </div>
                  </div>
                   {{--shipped tab--}}
                  <div class="tab-pane @if($active_tab == 'shipped') active @endif" id="shipped">
                      <span class="btn btn-link-inline text-primary btn-filter collapsed" type="button" data-toggle="collapse" data-target="#collapseShipped" aria-expanded="false" aria-controls="collapseShipped">
                          <i class="fa fa-sliders"></i>
                          <span>Show Filter</span><p>Hide Filter</p>
                       </span>
                      <div class="collapse table-responsive" id="collapseShipped">
                          <div class="card card-body">
                              {{--start--}}
                              <div class="row">
                                  <div class="col-md-12">
                                      <!-- left column -->
                                      <div class="box box-primary">
                                          <form>
                                              <div class="box-body">
                                                  <div class="row">
                                                      <div class="input-daterange">
                                                          <div class="col-xs-2">
                                                              <div class="input-container">
                                                                  <input class="input-field" id="start_shipped" type="text" placeholder="Start date" name="start_shipped" required>
                                                                  <i class="fa fa-calendar icon"></i>
                                                              </div>
                                                          </div>
                                                          <div class="col-xs-2">
                                                              <div class="input-container">
                                                                  <input class="input-field" type="text" id="end_shipped" placeholder="End date" name="end_shipped" required>
                                                                  <i class="fa fa-calendar icon"></i>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-xs-2">
                                                          <div class="input-container">
                                                              <!-- For defining autocomplete -->
                                                              <input class="input-field auto" type="text" id="order_id_shipped" placeholder="Order ID" name="order_id_shipped" required>
                                                          </div>
                                                      </div>
                                                      <div class="col-xs-2">
                                                          <div class="input-container">
                                                              <button type="button" id="filter_shipped" name="filter_shipped" class="btn btn-primary m-b-0 m-r-5 filter-btn" value="active"> Search </button>
                                                              <button type="button" id="refresh_shipped" name="refresh_shipped" class="btn btn-info m-b-0 m-r-5 filter-btn" value="active"> Refresh </button>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          {!! Form::close() !!}
                                      </div>
                                  </div>
                              </div>
                              {{--end--}}
                          </div>
                      </div>
                      <br/>
                      {{--for filters--}}
                     <div class="table-responsive">
                     <table id="shipped-tables" class="table table-striped table-bordered nowrap fill" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Order No</th>
                                <th>Purchased By</th>
                                <th>Area</th>
                                <th>Delivery Charge</th>
                                <th>Total Amount <sub> (with delivery charge)</sub></th>
                                <th>Order Created At</th>
                                <th>Shipped At</th>
                                <th>Update Status</th>
                            </tr>
                        </thead>
                    </table>
                     </div>
                  </div>
                {{--delivered tab--}}
                  <div class="tab-pane @if($active_tab == 'delivered') active @endif" id="delivered">
                      <span class="btn btn-link-inline text-primary btn-filter collapsed" type="button" data-toggle="collapse" data-target="#collapseDelivered" aria-expanded="false" aria-controls="collapseDelivered">
                          <i class="fa fa-sliders"></i>
                          <span>Show Filter</span><p>Hide Filter</p>
                       </span>
                      <div class="collapse table-responsive" id="collapseDelivered">
                          <div class="card card-body">
                              {{--start--}}
                              <div class="row">
                                  <div class="col-md-12">
                                      <!-- left column -->
                                      <div class="box box-primary">
                                          <form>
                                              <div class="box-body">
                                                  <div class="row">
                                                      <div class="input-daterange">
                                                          <div class="col-xs-2">
                                                              <div class="input-container">
                                                                  <input class="input-field" id="start_delivered" type="text" placeholder="Start date" name="start_delivered" required>
                                                                  <i class="fa fa-calendar icon"></i>
                                                              </div>
                                                          </div>
                                                          <div class="col-xs-2">
                                                              <div class="input-container">
                                                                  <input class="input-field" type="text" id="end_delivered" placeholder="End date" name="end_delivered" required>
                                                                  <i class="fa fa-calendar icon"></i>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-xs-2">
                                                          <div class="input-container">
                                                              <!-- For defining autocomplete -->
                                                              <input class="input-field auto" type="text" id="order_id_delivered" placeholder="Order ID" name="order_id_delivered" required>
                                                          </div>
                                                      </div>
                                                      <div class="col-xs-2">
                                                          <div class="input-container">
                                                              <button type="button" id="filter_delivered" name="filter_delivered" class="btn btn-primary m-b-0 m-r-5 filter-btn" value="active"> Search </button>
                                                              <button type="button" id="refresh_delivered" name="refresh_delivered" class="btn btn-info m-b-0 m-r-5 filter-btn" value="active"> Refresh </button>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          {!! Form::close() !!}
                                      </div>
                                  </div>
                              </div>
                              {{--end--}}
                          </div>
                      </div>
                      <br/>
                      {{--for filters--}}
                     <div class="table-responsive">
                     <table id="delivered-tables" class="table table-striped table-bordered nowrap fill" role="grid" aria-describedby="basic-col-reorder_info">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Order No</th>
                                <th>Purchased By</th>
                                <th>Area</th>
                                <th>Delivery Charge</th>
                                <th>Total Amount <sub> (with delivery charge)</sub></th>
                                <th>Order Created At</th>
                                <th>Delivered At</th>
                                <th>Update Status</th>
                            </tr>
                        </thead>
                    </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
    <script src="/js/jquery-ui.js" ></script>
    <script>
        $(document).ready(function() {
            $('.input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                calendarWeeks: true,
                clearBtn: true,
                disableTouchKeyboard: true,
            });
        });

        load_extraopt();
        function load_extraopt() {
            $(document).ready(function () {
                $.extend($.fn.dataTable.defaults, {
                    columnDefs: [
                        {orderable: false, targets: '_all'}
                    ],
                    'dom': 'lBfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            text: "<i class='fa fa-print'> </i>",
                            className: 'btn btn-danger btn-xs ml mr',
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fa fa-file-excel-o"> </i>',
                            className: 'btn btn-purple mr btn-xs',
                        },
                        {
                            extend: 'csv',
                            text: '<i class="fa fa-file-excel-o"> </i>',
                            className: 'btn btn-primary mr btn-xs',
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fa fa-file-pdf-o"> </i>',
                            className: 'btn btn-info mr btn-xs',
                        },
                        {
                            text: "Bulk Delete",
                            className: 'btn btn-danger bulk-delete btn-xs mr',
                            action: function (e, dt, node, config) {
                                var ids = [];
                                var count = '';
                                var url = $('#base').val();
                                $.each($("input[name='delete_items']:checked"), function () {
                                    ids.push($(this).val());
                                });
                                count = ids.length;
                                if (confirm("You are about to delete " + count + " record(s). This cannot be undone. Are you sure?")) {
                                    var before = ids;
                                    ids = ids.toString();
                                    $.ajax(
                                        {
                                            method: "POST",
                                            url: url,
                                            dataType: 'json',
                                            data: {_token: "{{ csrf_token() }}", _method: "DELETE", ids: ids},
                                            success: function (response) {
                                                $.each(before, function (key, value) {
                                                    $('#' + value).remove();
                                                });
                                                toastr.success(response);
                                            }
                                        });
                                }
                            }
                        }

                    ],
                });
            });
        }

    $(document).on('click', '.dropdown-content', function(e){
       let status = e.target.innerHTML;
       let id = e.target.value;
       let url = "{{ route('order_status') }}";
       $.ajax(url, {
          type: 'POST',
          data: { _token:"{{ csrf_token() }}", _method:"POST", id:id, status:status },
          success: function (data, status, xhr) {
             //location.reload(true);
             javaAlert(data);
          },
          error: function (jqXhr, textStatus, errorMessage) {
          $('p').append('Error' + errorMessage);
          }
       });
    })

// datatables with child row for all orders list
/* Formatting function for row details - modify as you need */
    function formats ( d ) {
        console.log(d);
        var currentrole = "<?php echo $currentroles; ?>";
        var currentid = <?php
            if($currentroles ==="vendor"){
                echo $vendorid;
            }else{
                echo "-1";
            }
            ?>;
        var inner_table = '<table class="child_row-verified table-responsive table table-striped table-bordered nowrap"><thead><tr><th>Send To</th><th>Sold by</th><th>Product</th><th>Specification</th><th>Order Detail</th><th>Shipping Info</th><th>Product Image</th></tr></thead><tbody>'
        console.log(currentid);
        inner_table += '<tr><td rowspan="'+ d.user_d.length +'">'+d.user_id + '</b><br/> '+ d.user_region + ', <br/> ' + d.user_city + ', <br/> '+ d.user_area + ', '+ d.user_address +'</td>' ;
        $.each(d.user_d, function( index, value ) {
            var color;
            var size;
            var imageid;
            var imagename;
            if(currentrole ==="vendor") {
                if (value.products.vendor_id === currentid) {

                    $.each(d.colors, function (index, v) {
                        if (v.id === value.color_id) {
                            color = "Color: " + v.name;
                        }
                    });
                    $.each(d.size, function (index, siz) {
                        if (siz.id === value.size_id) {
                            size = ", <br/> Size: " + siz.name;
                        }
                    });
                    $.each(d.image_data, function (index, i) {
                        if (i.product_id === value.product_id && i.color_id === value.color_id) {
                            imageid = i.id;
                        }
                    });
                    $.each(d.images, function (index, img) {
                        if (img.imageable_id === imageid) {
                            imagename = '<a class="thumbnail-order" href="#thumb">' +
                                '<img src="/uploads/products/' + img.image + '" style="height:10rem;" alt=""/>' +
                                '<span><img src="/uploads/products/' + img.image + '" style="height:20rem;" /><br />' +
                                "Price: " + value.price +
                                '</span>' +
                                '</a>';
                        }
                    });
                    inner_table += '<td>' + value.products.vendor_id + '</td><td>'
                        + value.products.name + '</td><td>'
                        + value.products.specification + '</td><td>'
                        + color + size + ",<br/>Quantity: " + value.quantity
                        + '</td><td>'
                        + d.delivery_type.charAt(0).toUpperCase() + d.delivery_type.slice(1) + ' delivery, <br/>' + d.status + '</td><td style=" text-align: center;">'
                        + imagename + '</td></tr>'
                    ;
                }
            }else{
                $.each(d.colors, function (index, v) {
                    if (v.id === value.color_id) {
                        color = "Color: " + v.name;
                    }
                });
                $.each(d.size, function (index, siz) {
                    if (siz.id === value.size_id) {
                        size = ", <br/> Size: " + siz.name;
                    }
                });
                $.each(d.image_data, function (index, i) {
                    if (i.product_id === value.product_id && i.color_id === value.color_id) {
                        imageid = i.id;
                    }
                });
                $.each(d.images, function (index, img) {
                    if (img.imageable_id === imageid) {
                        imagename = '<a class="thumbnail-order" href="#thumb">' +
                            '<img src="/uploads/products/' + img.image + '" style="height:10rem;" alt=""/>' +
                            '<span><img src="/uploads/products/' + img.image + '" style="height:20rem;" /><br />' +
                            "Price: " + value.price +
                            '</span>' +
                            '</a>';
                    }
                });
                inner_table += '<td>' + value.products.vendor_id + '</td><td>'
                    + value.products.name + '</td><td>'
                    + value.products.specification + '</td><td>'
                    + color + size + ",<br/>Quantity: " + value.quantity
                    + '</td><td>'
                    + d.delivery_type.charAt(0).toUpperCase() + d.delivery_type.slice(1) + ' delivery, <br/>' + d.status + '</td><td style=" text-align: center;">'
                    + imagename + '</td></tr>'
                ;
            }
        });
        inner_table += '</tbody></table>';
        return inner_table;
    }

    //function to load all orders of users
    allOrders();
    function allOrders(start,end,orderid){
        $(document).ready(function () {
            load_extraopt();
            $( "#order_id" ).autocomplete({
                source: function( request, response ) {
                    // Fetch data
                    $.ajax({
                        url:"{{route('ajaxRequest.getorderID')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    $('#order_id').val(ui.item.value); // display the selected text
                    return false;
                }
            });

            var table = $('#all-orders').DataTable( {
                processing: true,
                paging: true,
                ajax: {
                    url: "{{route('ajaxRequest.orders')}}",
                    data: {start:start,end:end,orderid:orderid}
                },
                "columns": [
                    {
                        "className": 'details-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        "render": function () {
                            return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                        },
                    },
                    { "data": "order_no" },
                    { "data": "user_id" },
                    { "data": "area_id" },
                    { "data": "delivery_type" },
                    { "data": "delivery_charge" },
                    { "data": "total_amount" },
                    { "data": "created_at" },
                    {
                        "data":"action"
                    },
                ],
                "lengthMenu": [[10, 50, 100, 150, 200, -1], [10, 50, 100, 150, 200, "All"]],
            } );

            // Add event listener for opening and closing details
            $('#all-orders tbody').off('click', 'td.details-control');
            $('#all-orders tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var tdi = tr.find("i.fa");
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    tdi.first().removeClass('fa-minus-square');
                    tdi.first().addClass('fa-plus-square');
                }
                else {
                    // Open this row
                    row.child(formats(row.data())).show();
                    tr.addClass('shown');
                    tdi.first().removeClass('fa-plus-square');
                    tdi.first().addClass('fa-minus-square');
                }
            });
        });
    }
        //filter and refresh button click for all orders table
        $("#filter").click(function(e){
            e.preventDefault();
            var start = $("input[name=start]").val();
            var end = $("input[name=end]").val();
            var orderid = $("input[name=order_id]").val();
            if(start !== '' && end !=='' && orderid !==''){
                $('#all-orders').DataTable().destroy();
                allOrders(start,end,orderid);
            }else if(start !== '' && end !=='') {
                $('#all-orders').DataTable().destroy();
                allOrders(start,end);
            }else{
                alert("Please select the date fields to filter data");
            }
        });

        $('#refresh').click(function(){
            $('#start').val('');
            $('#end').val('');
            $('#order_id').val('');
            $('#all-orders').DataTable().destroy();
            allOrders();
        });
        //filter and refresh button end click for all orders table


        //function to load all orders of users
    verified_orders();
    function verified_orders(start,end,orderid){
        load_extraopt();
        $(document).ready(function() {
            var verify = $('#verified-table').DataTable({
                processing: true,
                paging: true,
                ajax: {
                    url: "{{route('ajaxRequest.multiorder')}}",
                    data: {ret: 'verified',start:start,end:end,orderid:orderid}
                },
                "columns": [
                    {
                        "className": 'details-controls',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        "render": function () {
                            return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                        },
                    },
                    {"data": "order_no"},
                    {"data": "user_id"},
                    {"data": "area_id"},
                    {"data": "delivery_charge"},
                    {"data": "total_amount"},
                    {"data": "created_at"},
                    {"data": "verify"},
                    {
                        "data": "action"
                    },
                ],
                "lengthMenu": [[10, 50, 100, 150, 200, -1], [10, 50, 100, 150, 200, "All"]],
            });

            // Add event listener for opening and closing details
            $('#verified-table tbody').off('click', 'td.details-controls');
            $('#verified-table tbody').on('click', 'td.details-controls', function () {
                var tr = $(this).closest('tr');
                var tdi = tr.find("i.fa");
                var row = verify.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    tdi.first().removeClass('fa-minus-square');
                    tdi.first().addClass('fa-plus-square');
                } else {
                    // Open this row
                    row.child(formats(row.data())).show();
                    tr.addClass('shown');
                    tdi.first().removeClass('fa-plus-square');
                    tdi.first().addClass('fa-minus-square');
                }
            });
        });
    }
        //filter and refresh button click for verified table
        $("#filter_verified").click(function(e){
            e.preventDefault();
            var start = $("input[name=start_verified]").val();
            var end = $("input[name=end_verified]").val();
            var orderid = $("input[name=order_id_verified]").val();
            if(start !== '' && end !=='' && orderid !==''){
                $('#verified-table').DataTable().destroy();
                verified_orders(start,end,orderid);
            }else if(start !== '' && end !=='') {
                $('#verified-table').DataTable().destroy();
                verified_orders(start,end);
            }else{
                alert("Please select the date fields to filter data");
            }
        });

        $('#refresh_verified').click(function(){
            $("input[name=start_verified]").val('');
            $("input[name=end_verified]").val('');
            $('input[name=order_id_verified]').val('');
            $('#verified-table').DataTable().destroy();
            verified_orders();
        });
        //filter and refresh button end for verified table


        packed_orders();
        function packed_orders(start,end,orderid){
            load_extraopt();
            $(document).ready(function() {
                var packed = $('#packed-tables').DataTable( {
                    processing: true,
                    paging: true,
                    ajax: {
                        url: "{{route('ajaxRequest.multiorder')}}",
                        data:{ret:'packed',start:start,end:end,orderid:orderid}
                    },
                    "columns": [
                        {
                            "className": 'details-controls',
                            "orderable": false,
                            "data": null,
                            "defaultContent": '',
                            "render": function () {
                                return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                            },
                        },
                        { "data": "order_no" },
                        { "data": "user_id" },
                        { "data": "area_id" },
                        { "data": "delivery_charge" },
                        { "data": "total_amount" },
                        { "data": "created_at" },
                        { "data": "pack" },
                        {
                            "data":"action"
                        },
                    ],
                    "lengthMenu": [[10, 50, 100, 150, 200, -1], [10, 50, 100, 150, 200, "All"]],
                } );

                $('#packed-tables tbody').off('click', 'td.details-controls');
                $('#packed-tables tbody').on('click', 'td.details-controls', function () {
                    var tr = $(this).closest('tr');
                    var tdi = tr.find("i.fa");
                    var row = packed.row(tr);

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                        tdi.first().removeClass('fa-minus-square');
                        tdi.first().addClass('fa-plus-square');
                    }
                    else {
                        // Open this row
                        row.child(formats(row.data())).show();
                        tr.addClass('shown');
                        tdi.first().removeClass('fa-plus-square');
                        tdi.first().addClass('fa-minus-square');
                    }
                });
            });
        }

        $("#filter_packed").click(function(e){
            e.preventDefault();
            var start = $("input[name=start_packed]").val();
            var end = $("input[name=end_packed]").val();
            var orderid = $("input[name=order_id_packed]").val();
            if(start !== '' && end !=='' && orderid !==''){
                $('#packed-tables').DataTable().destroy();
                packed_orders(start,end,orderid);
            }else if(start !== '' && end !=='') {
                $('#packed-tables').DataTable().destroy();
                packed_orders(start,end);
            }else{
                alert("Please select the date fields to filter data");
            }
        });

        $('#refresh_packed').click(function(){
            $("input[name=start_packed]").val('');
            $("input[name=end_packed]").val('');
            $('input[name=order_id_packed]').val('');
            $('#packed-tables').DataTable().destroy();
            packed_orders();
        });
        //filter and refresh button end for packed table

        shipped_orders();
        function shipped_orders(start,end,orderid){
            load_extraopt();
            $(document).ready(function() {
                var ship = $('#shipped-tables').DataTable({
                    processing: true,
                    paging: true,
                    ajax: {
                        url: "{{route('ajaxRequest.multiorder')}}",
                        data: {ret: 'shipped', start: start, end: end, orderid: orderid}
                    },
                    "columns": [
                        {
                            "className": 'details-controls',
                            "orderable": false,
                            "data": null,
                            "defaultContent": '',
                            "render": function () {
                                return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                            },
                        },
                        {"data": "order_no"},
                        {"data": "user_id"},
                        {"data": "area_id"},
                        {"data": "delivery_charge"},
                        {"data": "total_amount"},
                        {"data": "created_at"},
                        {"data": "ship"},
                        {
                            "data": "action"
                        },
                    ],
                    "lengthMenu": [[10, 50, 100, 150, 200, -1], [10, 50, 100, 150, 200, "All"]],
                });


                $('#shipped-tables tbody').off('click', 'td.details-controls');
                $('#shipped-tables tbody').on('click', 'td.details-controls', function () {
                    var tr = $(this).closest('tr');
                    var tdi = tr.find("i.fa");
                    var row = ship.row(tr);

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                        tdi.first().removeClass('fa-minus-square');
                        tdi.first().addClass('fa-plus-square');
                    } else {
                        // Open this row
                        row.child(formats(row.data())).show();
                        tr.addClass('shown');
                        tdi.first().removeClass('fa-plus-square');
                        tdi.first().addClass('fa-minus-square');
                    }
                });
            });
        }

        $("#filter_shipped").click(function(e){
            e.preventDefault();
            var start = $("input[name=start_shipped]").val();
            var end = $("input[name=end_shipped]").val();
            var orderid = $("input[name=order_id_shipped]").val();
            if(start !== '' && end !=='' && orderid !==''){
                $('#shipped-tables').DataTable().destroy();
                shipped_orders(start,end,orderid);
            }else if(start !== '' && end !=='') {
                $('#shipped-tables').DataTable().destroy();
                shipped_orders(start,end);
            }else{
                alert("Please select the date fields to filter data");
            }
        });

        $('#refresh_shipped').click(function(){
            $("input[name=start_shipped]").val('');
            $("input[name=end_shipped]").val('');
            $('input[name=order_id_shipped]').val('');
            $('#shipped-tables').DataTable().destroy();
            shipped_orders();
        });
        //filter and refresh button end for shipped table


        delivered_orders();
    function delivered_orders(start,end,orderid) {
        load_extraopt();
        $(document).ready(function () {
            var deliver = $('#delivered-tables').DataTable({
                processing: true,
                paging: true,
                ajax: {
                    url: "{{route('ajaxRequest.multiorder')}}",
                    data: {ret: 'delivered',start:start,end:end,orderid:orderid}
                },
                "columns": [
                    {
                        "className": 'details-controls',
                        "orderable": false,
                        "data": null,
                        "defaultContent": '',
                        "render": function () {
                            return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                        },
                    },
                    {"data": "order_no"},
                    {"data": "user_id"},
                    {"data": "area_id"},
                    {"data": "delivery_charge"},
                    {"data": "total_amount"},
                    {"data": "created_at"},
                    {"data": "deliver"},
                    {
                        "data": "action"
                    },
                ],
                "lengthMenu": [[10, 50, 100, 150, 200, -1], [10, 50, 100, 150, 200, "All"]],
            });

            $('#delivered-tables tbody').off('click', 'td.details-controls');
            $('#delivered-tables tbody').on('click', 'td.details-controls', function () {
                var tr = $(this).closest('tr');
                var tdi = tr.find("i.fa");
                var row = deliver.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    tdi.first().removeClass('fa-minus-square');
                    tdi.first().addClass('fa-plus-square');
                } else {
                    // Open this row
                    row.child(formats(row.data())).show();
                    tr.addClass('shown');
                    tdi.first().removeClass('fa-plus-square');
                    tdi.first().addClass('fa-minus-square');
                }
            });
        });
    }
        $("#filter_delivered").click(function(e){
            e.preventDefault();
            var start = $("input[name=start_delivered]").val();
            var end = $("input[name=end_delivered]").val();
            var orderid = $("input[name=order_id_delivered]").val();
            if(start !== '' && end !=='' && orderid !==''){
                $('#delivered-tables').DataTable().destroy();
                delivered_orders(start,end,orderid);
            }else if(start !== '' && end !=='') {
                $('#delivered-tables').DataTable().destroy();
                delivered_orders(start,end);
            }else{
                alert("Please select the date fields to filter data");
            }
        });

        $('#refresh_delivered').click(function(){
            $("input[name=start_delivered]").val('');
            $("input[name=end_delivered]").val('');
            $('input[name=order_id_delivered]').val('');
            $('#delivered-tables').DataTable().destroy();
            delivered_orders();
        });
        //filter and refresh button end for shipped table






//end of the datatables for all order list

    // CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    auto_complete();
    function auto_complete() {
        $(document).ready(function () {
            $("#order_ver_id").autocomplete({
                source: function (request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{route('ajaxRequest.getorderID')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    $('#order_ver_id').val(ui.item.value); // display the selected text
                    return false;
                }
            });


            $("#order_id_packed").autocomplete({
                source: function (request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{route('ajaxRequest.getorderID')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    $('#order_id_packed').val(ui.item.value); // display the selected text
                    return false;
                }
            });

            $("#order_id_shipped").autocomplete({
                source: function (request, response) {
                    // Fetch data
                    $.ajax({
                        url: "{{route('ajaxRequest.getorderID')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    $('#order_id_shipped').val(ui.item.value); // display the selected text
                    return false;
                }
            });
        });

        $("#order_id_delivered").autocomplete({
            source: function (request, response) {
                // Fetch data
                $.ajax({
                    url: "{{route('ajaxRequest.getorderID')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                // Set selection
                $('#order_id_delivered').val(ui.item.value); // display the selected text
                return false;
            }
        });
    }

</script>
@endsection
