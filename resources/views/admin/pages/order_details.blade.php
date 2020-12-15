@extends('admin.layouts.master')
@section('styles')
<style>
   .group-title{
      font-size: 18px;
      font-weight: 600;
   }
   .block-element span { 
      display: block; 
   } 
</style>
@endsection
@section('content')
<div class="row">
   <div class="col-sm-12">
   <h3>Order details for order No. {{ $order_data->order_no }}</h3>
   @php 
   $total_amount = 0;
   foreach($order_data->order_products as $amount_data){
      $order_detail = App\Models\ProductSize::with('product')->where('product_id', $amount_data->product_id)->first();
      $total_amount = $total_amount + $order_detail->selling_price;
   }
   @endphp
   </div>
   <div class="col-sm-12 col-lg-5 col-md-5">
      <span class="group-title">Customer Information</span>
      <hr style="border-top:5px solid #e4eaec; margin: 10px 0px">
      <div class="row">
         <div class="col-sm-7 block-element">
            <span>Date <tag class="text-dark"> {{ date('d F Y', strtotime($order_data->created_at)) }}</tag></span>
            <span>Customer	<tag class="text-dark"> {{$area_id->name}}</tag></span>
            <span>Phone Number	<tag class="text-dark"> {{$area_id->phone}}</tag></span>
            <span>Payment Method <tag class="text-dark"> COD</tag></span>
         </div>
         <div class="col-sm-5 block-element" style="border-left:1px solid #eee">
            <span>Subtotal <tag class="text-dark"> {{ number_format($total_amount) }}.00</tag></span>
            <span>Shipping	<tag class="text-dark"> +{{$charge}}.00</tag></span>
            <span>Jojayo Discount <tag class="text-dark"> -0.00</tag></span>
            <span>Grand Total <tag class="text-dark"> {{ number_format($charge +  $total_amount) }}</tag></span>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-lg-3 col-md-3 block-element">
      <span class="group-title">Transaction Information</span>
      <hr style="border-top:5px solid #e4eaec; margin: 10px 0px">
      <span>Automatic Shipping Fee	-{{$normal_charge}}.00</span>
      <span>Shipping Fee (Paid By Customer)	{{$charge}}.00</span>
      <span>Items Amount {{ number_format($total_amount) }}.00</span>
   </div>
   <div class="col-sm-12 col-lg-2 col-md-2 block-element">
      <span class="group-title">Billing Address</span>
      <hr style="border-top:5px solid #e4eaec; margin: 10px 0px">
      <span>{{ $area_id->name }}</span>
      <span>{{ $delivery_charge->name }}</span>
      <span>{{ $area_id->address }}</span>
      <span>Nepal</span>
   </div>
   <div class="col-sm-12 col-lg-2 col-md-2 block-element">
      <span class="group-title">Shipping Address</span>
      <hr style="border-top:5px solid #e4eaec; margin: 10px 0px">
      <span>{{ $area_id->name }}</span>
      <span>{{ $delivery_charge->name }}</span>
      <span>{{ $area_id->address }}</span>
      <span>Nepal</span>
   </div>
</div>
<div class="row">
   <div class="col-sm-12">
      <h4>Items</h4>
   </div>
   <div class="table-responsive">
      <table id="delivered-tables" class="table table-striped table-bordered nowrap" role="grid" aria-describedby="basic-col-reorder_info">
         <thead>
               <tr>
                  <th></th>
                  <th>Seller SKU</th>
                  <th>JOJAYO SKU</th>
                  <th>Product</th>
                  <th>Delivery Type</th>
                  <th>Product Amount</th>
                  <th>Delivery Charge</th>
                  <th>Status</th>
               </tr>
         </thead>

      </table>
   </div>
</div>
<div class="row">
   <div class="col-sm-12">
      <h4>History</h4>
   </div>
   <div class="table-responsive">                        
      <table class="table table-striped table-bordered nowrap dataTable" role="grid" id="product-tables" aria-describedby="basic-col-reorder_info" style="width:100%">
         <thead>
            <tr>
               <th>Order Id</th>
               <th>Order no</th>
               <th>Status</th>
               <th>Updated On</th>
            </tr>
         </thead>
         <tbody>
            @if(!empty($order_data->verified_at))
            <tr >               
               <td>
                  {{$order_data->id}}
               </td>
               <td>
                  {{$order_data->order_no}}
               </td>
               <td>                  
                  Verified
               </td>
               <td>
                  {{$order_data->verified_at}}
               </td>
            </tr> 
            @endif
            @if(!empty($order_data->packed_at))
            <tr >               
               <td>
                  {{$order_data->id}}
               </td>
               <td>
                  {{$order_data->order_no}}
               </td>
               <td>                  
                  Packed
               </td>
               <td>
                  {{$order_data->packed_at}}
               </td>
            </tr> 
            @endif
            @if(!empty($order_data->shipped_at))
            <tr >               
               <td>
                  {{$order_data->id}}
               </td>
               <td>
                  {{$order_data->order_no}}
               </td>
               <td>                  
                  Sent for shipping
               </td>
               <td>
                  {{$order_data->shipped_at}}
               </td>
            </tr> 
            @endif
            @if(!empty($order_data->delivered_at))
            <tr >               
               <td>
                  {{$order_data->id}}
               </td>
               <td>
                  {{$order_data->order_no}}
               </td>
               <td>                  
                  Delivered
               </td>
               <td>
                  {{$order_data->delivered_at}}
               </td>
            </tr> 
            @endif            
         </tbody>
      </table>
   </div>
</div>
@endsection
@section('scripts')
<script>
   function formats ( d ) {
      var inner_table = '<table class="child_row table table-striped table-bordered nowrap"><thead><tr><th>Date</th><th>Transaction Type</th><th>Value</th><th>Number</th><th>Account Statement</th></tr></thead><tbody>'         
         inner_table += '<tr><td>'+d.created_at+'</td><td>Item Price</td><td>'+d.price+'.00 </td><td>Number-NJ-KOYR</td><td>'+d.transaction+'</td>';
         inner_table += '<tr><td>'+d.created_at+'</td><td>Commission</td><td> - '+d.commission+'.00 </td><td>Number-NJ-KOYR</td><td>'+d.transaction+'</td>';
         inner_table += '<tr><td>'+d.created_at+'</td><td>Shipping</td><td>'+d.shipping+'.00 </td><td>Number-NJ-KOYR</td><td>'+d.transaction+'</td>';
         // });
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
                

            ],
        });

        var table = $('#delivered-tables').DataTable( {
            processing: true,
            paging: true,
            "paging":   false,
            "ordering": false,
            "bFilter": false,
            "info": false,
            ajax: {
                url: "ajaxRequest/orderDetail/",
                data: { order_no: "{{ $_GET['order_no'] }}" },
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
                { "data": "seller_sku" },
                { "data": "jojayo_sku" },
                { "data": "product" },
                { "data": "delivery_type" },
                { "data": "price" },
                { "data": "shipping" },
                { "data": "status" },
            ],
        } );

        

   $('#delivered-tables tbody').on('click', 'td.details-control', function () {
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
</script>
@endsection