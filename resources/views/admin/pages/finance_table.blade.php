<div class="col-lg-12">
   <div class="panel panel-default">
      <div class="panel-body">
         <table class="table table-condensed" style="border-collapse:collapse;">
            <thead>
               <tr>
                  <th>&nbsp;</th>
                  <th>Order Id</th>
                  <th>Delivery Charge</th>
                  <th>Total Transcation</th>
                  <th>Statement</th>
                  <th>Print</th>
               </tr>
            </thead>
            <tbody>
               @php $total = 0; @endphp
               @foreach($data as $data_detail)
               @php
               $order_data = \App\Models\Order::with(['vendor_products' => function($query) use ($id) {
               $query->whereHas('products', function ($query) use ($id) {
               $query->where('vendor_id', $id);
               });
               }])->where('order_no',$data_detail->order_no)->get(); 
               @endphp
               @foreach($order_data as $key => $order_detail)
               @php
               $delivery_charge = App\Models\Area::where('id',$order_detail->area_id)->first();
               if($order_detail->delivery_type == 'express'){
               $charge = $delivery_charge->express_charge;
               } else {
               $charge = $delivery_charge->delivery_charge;
               }
               $order_price = 0;
               $account_statement = '';
               foreach($order_detail->vendor_products as $price_data){
               $order_price = $price_data->price + $order_price;
               if(date('d', strtotime($price_data->created_at)) > 7 && date('d', strtotime($price_data->created_at)) <= 14){
               $account_statement = date('d F Y',strtotime($price_data->created_at)).' - '.date('14 F Y',strtotime($price_data->created_at));
               } elseif(date('d', strtotime($price_data->created_at)) > 14 && date('d', strtotime($price_data->created_at)) <= 21) {
               $account_statement = date('d F Y',strtotime($price_data->created_at)).' - '.date('21 F Y',strtotime($price_data->created_at));
               } elseif(date('d', strtotime($price_data->created_at)) > 21 && date('d', strtotime($price_data->created_at)) <= 28) {
               $account_statement = date('d F Y',strtotime($price_data->created_at)).' - '.date('28 F Y',strtotime($price_data->created_at));
               } elseif(date('d', strtotime($price_data->created_at)) <= 7) {
               $account_statement = date('d F Y',strtotime($price_data->created_at)).' - '.date('7 F Y',strtotime($price_data->created_at));
               }
               }
               @endphp
               <tr>
                  <td data-toggle="collapse" data-target="#demo{{$order_detail->order_no}}" class="accordion-toggle"><button class="btn btn-default btn-xs"><span class="fa fa-plus"></span></button></td>
                  <td>
                     <form target="_blank" action="/auth/order-details"><input type="hidden" value="{{ $order_detail->order_no }}" name="order_no"><button class="btn-transparent" type="submit">{{ $order_detail->order_no }}</button></form>
                  </td>
                  <!-- <td><form target="_blank" action="{{ route('transaction') }}"><input type="hidden" name="vendor_id" value="{{ $id }}"><input type="hidden" name="transaction_no" value="{{ $data_detail->transaction_no }}"><button class="btn-transparent">{{ $data_detail->transaction_no }}</button></form></td> -->
                  <td>{{ $charge }}.00</td>
                  <td>{{ number_format($order_price) }}.00</td>
                  <td>{{ $account_statement }}</td>
                  <td>
                     <form target="_blank" action="{{ route('printFinance') }}" method="POST">@csrf<input type="hidden" name="vendor_id" value="{{ $id }}"><input type="hidden" name="transaction_no" value="{{ $data_detail->transaction_no }}"><button class="btn-transparent"><i class="fa fa-print"></i> Print</button></form>
                  </td>
               </tr>
               <tr>
                  <td colspan="12" class="hiddenRow">
                     <div class="accordian-body collapse" id="demo{{$order_detail->order_no}}">
                        <table class="table table-striped">
                           <thead>
                              <tr>
                                 <th>Product Name</th>
                                 <th>Color</th>
                                 <th>Size</th>
                                 <th>User</th>
                                 <th>Quantity</th>
                                 <th>Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              @php
                              $data= App\Models\Order::with(['vendor_products' => function($query) use ($id) {
                              $query->whereHas('products', function ($query) use ($id) {
                              $query->where('vendor_id', $id);
                              });
                              }])->where('order_no',$order_detail->order_no)->first();
                              @endphp
                              @if(!empty($data->vendor_products))
                              @foreach($data->vendor_products as $prod_list)
                              <tr>
                                 <td>{{ $prod_list->products->name }}</td>
                                 <td>{{ @$prod_list->colorInfo->name }}</td>
                                 <td>{{ @$prod_list->sizeInfo->name }}</td>
                                 <td>{{ @$prod_list->userDetail->name }}</td>
                                 <td>{{ $prod_list->quantity }}</td>
                                 <td>{{ number_format(@$prod_list->price * @$prod_list->quantity) }}</td>
                              </tr>
                              @endforeach
                              @endif
                           </tbody>
                        </table>
                     </div>
                  </td>
               </tr>
               @endforeach
               @php $total = $order_price + $total; @endphp
               @endforeach
            </tbody>
         </table>
         <div class="row">
            <div class="col-md-3">
               <strong>Total Transaction: {{ number_format($total) }}.00</strong>
            </div>
            <div class="col-md-9">
               <div class="pull-right">
               <!-- <form target="_blank" action="/auth/get/transaction/detail" class="pull-right">
                  <input type="hidden" name="vendor_id" value="{{$id}}">
                  <input type="hidden" name="statement" value="{{ date('F d, Y', strtotime($date)) }} - {{ date('F d, Y', strtotime($end_date)) }}">
                  <input type="hidden" name="total" value="{{$total}}"> -->
                  <button class="btn btn-warning" data-toggle="modal" data-target="#transaction-modal"><i class="fa fa-money"></i> Make Payment</button>
               <!-- </form> -->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="transaction-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Transaction Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            @php
            $statement_data = date('F d, Y', strtotime($date)).' - '.date('F d, Y', strtotime($end_date));
            $my_state = \App\Models\Statement::where('vendor_id', $id)->where('statement', $statement_data)->first();
            @endphp
            <form action="{{ route('updateTransaction') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
               <input type="hidden" name="vendor_id" value="{{ $id }}">
               <input type="hidden" name="statement" value="{{ $statement_data }}">
               @csrf
               <div class="form-group">
                  <label class="col-sm-3 control-label"><strong>Total transaction</strong> <span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control" value="{{ $total }}">
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-sm-3 control-label"><strong>Paid Amount</strong> <span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control" value="{{ @$my_state->paid_amount }}" name="paid_amount" id="paid_amount">
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-sm-3 control-label"><strong>Due Amount</strong> <span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control" value="{{ @$my_state->due_amount }}" name="due_amount" id="due_amount">
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-sm-3 control-label"><strong>Narration</strong> <span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                     <textarea class="form-control" name="narration" rows="3">{{ @$my_state->narration }}</textarea>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-sm-3 control-label"></label>
                  <div class="col-sm-9">
                     <button type="submit" class="btn btn-primary m-b-0 m-r-5">Update</button>
                  </div>
               </div>
            </form>
         </div>         
      </div>
   </div>
</div>