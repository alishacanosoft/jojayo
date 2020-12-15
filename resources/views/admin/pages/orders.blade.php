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
</style>
@endsection
@section('content')
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
                  <div class="tab-pane @if($active_tab == 'delivered') active @endif" id="delivered">
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
<script>
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
        //console.log(d);
        var inner_table = '<table class="child_row-verified  table table-striped table-bordered nowrap"><thead><tr><th>Send To</th><th>Product</th><th>Specification</th><th>Order Detail</th><th>Shipping Info</th><th>Product Image</th></tr></thead><tbody>'
        inner_table += '<tr><td rowspan="'+ d.user_d.length +'">'+d.user_id + '</b><br/> '+ d.user_region + ', <br/> ' + d.user_city + ', <br/> '+ d.user_area + ', '+ d.user_address +'</td>' ;
        $.each(d.user_d, function( index, value ) {
            var color;
            var size;
            var imageid;
            var imagename;
            $.each(d.colors, function( index, v ) {
                if(v.id ===  value.color_id){
                    color = "Color: " + v.name;
                }
            });
            $.each(d.size, function( index, siz ) {
                if(siz.id ===  value.size_id){
                    size = ", <br/> Size: " + siz.name;
                }
            });
            $.each(d.image_data, function( index, i ) {
                if(i.product_id ===  value.product_id && i.color_id ===  value.color_id ){
                    imageid = i.id;
                }
            });
            $.each(d.images, function( index, img ) {
                if(img.imageable_id ===  imageid ){
                    imagename = '<a class="thumbnail-order" href="#thumb">' +
                        '<img src="/uploads/products/'+  img.image +'" style="height:10rem;" alt=""/>' +
                        '<span><img src="/uploads/products/'+  img.image +'" style="height:20rem;" /><br />' +
                        "Price: "+ value.price +
                        '</span>' +
                        '</a>' ;
                }
            });
            inner_table += '<td>'+value.products.name+'</td><td>'
                +  value.products.specification +'</td><td>'
                + color + size + ",<br/>Quantity: "+ value.quantity
                +'</td><td>'
                +d.delivery_type.charAt(0).toUpperCase() + d.delivery_type.slice(1)+' delivery, <br/>'+ d.status +'</td><td style=" text-align: center;">'
                + imagename +'</td></tr>'
            ;
        });
        inner_table += '</tbody></table>';
        return inner_table;
    }

    $(document).ready(function() {
        $.extend($.fn.dataTable.defaults, {
            columnDefs: [
                { orderable: false, targets: '_all' }
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
                    action: function ( e, dt, node, config ) {
                        var ids = [];
                        var count = '';
                        var url = $('#base').val();
                        $.each($("input[name='delete_items']:checked"), function(){
                            ids.push($(this).val());
                        });
                        count = ids.length;
                        if(confirm("You are about to delete "+count+" record(s). This cannot be undone. Are you sure?"))
                        {
                            var before = ids;
                            ids = ids.toString();
                            $.ajax(
                                {
                                    method: "POST",
                                    url: url,
                                    dataType: 'json',
                                    data: { _token:"{{ csrf_token() }}", _method:"DELETE", ids: ids},
                                    success: function (response)
                                    {
                                        $.each(before, function(key, value){
                                            $('#'+value).remove();
                                        });
                                        toastr.success(response);
                                    }
                                });
                        }
                    }
                }

            ],
        });

        var table = $('#all-orders').DataTable( {
            processing: true,
            paging: true,
            ajax: {
                url: "{{route('ajaxRequest.orders')}}",
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


        var verify = $('#verified-table').DataTable( {
            processing: true,
            paging: true,
            ajax: {
                url: "{{route('ajaxRequest.multiorder')}}",
                data:{ret:'verified'}
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
                { "data": "verify" },
                {
                    "data":"action"
                },
            ],
            "lengthMenu": [[10, 50, 100, 150, 200, -1], [10, 50, 100, 150, 200, "All"]],
        } );

        // Add event listener for opening and closing details
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
            }
            else {
                // Open this row
                row.child(formats(row.data())).show();
                tr.addClass('shown');
                tdi.first().removeClass('fa-plus-square');
                tdi.first().addClass('fa-minus-square');
            }
        });


        var packed = $('#packed-tables').DataTable( {
            processing: true,
            paging: true,
            ajax: {
                url: "{{route('ajaxRequest.multiorder')}}",
                data:{ret:'packed'}
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


        var deliver = $('#delivered-tables').DataTable( {
            processing: true,
            paging: true,
            ajax: {
                url: "{{route('ajaxRequest.multiorder')}}",
                data:{ret:'delivered'}
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
                { "data": "deliver" },
                {
                    "data":"action"
                },
            ],
            "lengthMenu": [[10, 50, 100, 150, 200, -1], [10, 50, 100, 150, 200, "All"]],
        } );

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
            }
            else {
                // Open this row
                row.child(formats(row.data())).show();
                tr.addClass('shown');
                tdi.first().removeClass('fa-plus-square');
                tdi.first().addClass('fa-minus-square');
            }
        });

        var ship = $('#shipped-tables').DataTable( {
            processing: true,
            paging: true,
            ajax: {
                url: "{{route('ajaxRequest.multiorder')}}",
                data:{ret:'shipped'}
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
                { "data": "ship" },
                {
                    "data":"action"
                },
            ],
            "lengthMenu": [[10, 50, 100, 150, 200, -1], [10, 50, 100, 150, 200, "All"]],
        } );

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
            }
            else {
                // Open this row
                row.child(formats(row.data())).show();
                tr.addClass('shown');
                tdi.first().removeClass('fa-plus-square');
                tdi.first().addClass('fa-minus-square');
            }
        });
    } );
//end of the datatables for all order list
</script>
@endsection
