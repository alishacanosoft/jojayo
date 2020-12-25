<table class="table table-condensed" style="border-collapse:collapse;">
   <thead>
      <tr>
         <!-- <th>&nbsp;</th> -->
         <th>Order Id</th>
         <th>Transaction Type</th>
         <th>Total Transcation</th>
         <th>Statement</th>
      </tr>
   </thead>
   <tbody>
       @if(!empty($data))
       @foreach($data as $list)
       @if(!empty($list))
       @php $price = 0;  @endphp
        @foreach($list->vendor_products as $value)
        @php
        if($type == 'item-price'){
            $price = $value->products->selling_price;
        } elseif($type == 'delivery-charge') {
            $price = '50';
        } else {
            $price = '100';
        }
        @endphp
      <!-- <tr>
         <td colspan="12" class="hiddenRow">
            <div class="accordian-body collapse" id="demo{{ $list->order_no }}">
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
                     <tr>
                        <td>{{ $value->products->name }}</td>
                        <td>{{ $value->colorInfo->name }}</td>
                        <td>{{ $value->sizeInfo->name }}</td>
                        <td>{{ $value->userDetail->name }}</td>
                        <td>{{ $value->quantity }}</td>
                        <td>400</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </td>
      </tr> -->

      @endforeach
      @endif
      <tr>
         <!-- <td data-toggle="collapse" data-target="#demo{{ $list->order_no }}" class="accordion-toggle"><button class="btn btn-default btn-xs"><span class="fa fa-plus"></span></button></td> -->
         <td>
            <!-- <form target="_blank" action="/auth/order-details"><input type="hidden" value="gg" name="order_no"><button class="btn-transparent" type="submit">{{ $list->order_no }}</button></form> -->
            {{ $list->order_no }}
         </td>
         <td>{{ $type }}</td>
         <td>{{ $price }}.00</td>
         <td>{{ date('d F Y', strtotime($date)) }} - {{ date('d F Y', strtotime($end_date)) }}</td>         
      </tr>
      
      
      @endforeach
      @endif
   </tbody>
</table>
