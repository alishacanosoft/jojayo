<div class="col-lg-12">
   <div class="panel panel-default">
      <div class="panel-body">
         <table class="table table-condensed" style="border-collapse:collapse;">
            <thead>
               <tr>
                  <th>&nbsp;</th>
                  <th>Order Id</th>
                  <th>Transaction Id</th>
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
            }])->where('id',$data_detail->order_id)->get();
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
               <tr data-toggle="collapse" data-target="#demo{{$order_detail->order_no}}" class="accordion-toggle">
                  <td><button class="btn btn-default btn-xs"><span class="fa fa-plus"></span></button></td>
                  <td>{{ $order_detail->order_no }}</td>
                  <td><form target="_blank" action="{{ route('transaction') }}"><input type="hidden" name="vendor_id" value="{{ $id }}"><input type="hidden" name="transaction_no" value="{{ $data_detail->transaction_no }}"><button class="btn-transparent">{{ $data_detail->transaction_no }}</button></form></td>
                  <td>{{ $charge }}.00</td>
                  <td>{{ number_format($order_price) }}.00</td>
                  <td>{{ $account_statement }}</td>
                  <td><form target="_blank" action="{{ route('printFinance') }}" method="POST">@csrf<input type="hidden" name="vendor_id" value="{{ $id }}"><input type="hidden" name="transaction_no" value="{{ $data_detail->transaction_no }}"><button class="btn-transparent"><i class="fa fa-print"></i> Print</button></form></td>
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
         <br><strong>Total Transaction: {{ number_format($total) }}.00
      </div>      
   </div>
</div>

