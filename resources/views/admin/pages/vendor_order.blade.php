@extends('admin.layouts.master')
@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
   .slow  .toggle-group { transition: left 0.7s; -webkit-transition: left 0.7s; }
   .toggle, .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20rem; }
   .toggle, .toggle.ios .toggle-handle { border-radius: 20rem; }

   .flash{
       list-style: none; float: right; display: flex;
   }
   .ui-widget.ui-widget-content{
    left:50% !important;
    top: 1350px !important;
   }
   .ui-dialog-titlebar-close span{
      position: absolute;
      top: -2px;
      left: 3px;
   }

   .child_row tr:nth-child(even){background-color: #f2f2f2;}
   .child_row tr:hover {background-color: #ddd;}
   .child_row th {
      padding-top: 5px !important;
      background-color: #e8e8e8;

   }

   td.details-control {
       text-align:center;
       color:forestgreen;
       cursor: pointer;
   }
   tr.shown td.details-control {
       text-align:center;
       color:red;
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
                  <li class=" active "><a href="#manage" data-toggle="tab">Ordered Products</a></li>
               </ul>
               <div class="tab-content bg-white">
                  <div class="tab-pane  active" id="manage">
                     <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap dataTable" role="grid"
                            id="product-tables" aria-describedby="basic-col-reorder_info" style="width:100%">
                              <thead>
                                 <tr>
                                    <th>Product Name</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>User</th>
                                    <th>Quantity</th>
                                 </tr>
                              </thead>
                              <tbody>
                                  @if(!empty($data->vendor_products))
                                  @foreach($data->vendor_products as $prod_list)
                                  <tr>
                                      <td>{{ $prod_list->products->name }}</td>
                                      <td>{{ @$prod_list->colorInfo->name }}</td>
                                      <td>{{ @$prod_list->sizeInfo->name }}</td>
                                      <td>{{ @$prod_list->userDetail->name }}</td>
                                      <td>{{ $prod_list->quantity }}</td>
                                  </tr>
                                  @endforeach
                                  @endif
                              </tbody>
                           </table>
                     </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection