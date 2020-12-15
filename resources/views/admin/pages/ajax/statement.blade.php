<!DOCTYPE html>
<html lang="en">
<head>
  <title>Print Invoice</title>
  <link rel="stylesheet" href="/admin/css/bootstrap.min.css" id="bscss">
  <link rel="stylesheet" href="/admin/css/font-awesome.min.css">
  <style>
    page {
      background: white;
      position: relative;
      overflow: hidden;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
    }
    page[size="A4"] {  
      width: 19cm;
      height: 29.7cm; 
    }
    page[size="A4"][layout="landscape"] {
      width: 25.7cm;
      height: 21cm;  
    }
    .msg {
        position: absolute;
        top: 10px;
        left: -40px;
        width: 150px;
        overflow: hidden;
        height: 50px;
        font: 40px;
        color: #fff;
        text-align: center;
        line-height: 50px;
        -webkit-transform-origin: center;
        transform-origin: center;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg);
        -webkit-box-shadow: 0 0 30px #777;
        box-shadow: 0 0 30px #777;
    }
    .Paid{
        background: green;
    }
    .Unpaid{
        background: grey;
    }
    body{
      background-color: #eee;
    }
    .invoice-container{
      max-width: 900px;
      background: #fff;
      margin: auto;
    }
    .transparent{
      background: transparent;
      border: none;
    }
  </style>
</head>
<body>
<div class="container invoice-container" style="padding: 70px 30px 50px 30px;position:relative;overflow:hidden">
  <div class="msg {{ $data->status }}">{{ ucfirst($data->status) }}</div> 
  <!-- Header -->
  <header>
    <div class="row align-items-center">
      <div class="col-sm-7 mb-3 mb-sm-0"> <img id="logo" src="https://jojayo.com/images/login_logo.png" title="Jojayo" alt="Jojayo" /> </div>
      <div class="col-sm-5 text-center text-sm-right">
        <h4 class="mb-0">Transaction No</h4>
         {{ $data->transaction_no }}
      </div>
    </div>
    <hr>
  </header>
  <!-- Main Content -->
  <main>
    <h4 class="text-4">Order Details</h4>
    <div class="table-responsive">
      <table class="table table-bordered text-1 table-sm table-striped">
        <thead>
          <th><span class="font-weight-600">Order Id</span></th>
          <th><span class="font-weight-600">Delivery Charge</span></th>
          <th><span class="font-weight-600">Item Price</span></th>
          <th><span class="font-weight-600">Transaction Number</span></th>
          <th><span class="font-weight-600">Statement</span></th>
        </thead>
        <tbody>
          @if(!empty($data))
          @php $total = 0; @endphp
          @foreach($order_data as $row)
          @php
          $delivery_charge = App\Models\Area::where('id',$row->area_id)->first();
          if($row->delivery_type == 'express'){
            $charge = $delivery_charge->express_charge;
          } else {
            $charge = $delivery_charge->delivery_charge;
          }
          $order_price = 0;
          foreach($row->vendor_products as $price_data){
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
            <td>{{ @$row->order_no }}</td>
            <td>{{ $charge }}.00</td>
            <td>{{ number_format($order_price) }}.00</td>
            <td>{{ $data->transaction_no }}</td>
            <td>{{ $account_statement }}</td>
          </tr>
          @php $total = $order_price + $total; @endphp
          @endforeach
          @endif
        </tbody>
      </table>
    </div>
    
    <h4 class="text-4 mt-2">Vendor Detail</h4>
    <div class="table-responsive">
      <table class="table table-bordered text-1 table-sm">
        <tbody>
          <tr>
            <td class="col-4"><span class="font-weight-600">Supplier:</span> {{ $vendor_data->company }}</td>
            <td class="col-4"><span class="font-weight-600">Phone No:</span> {{ $vendor_data->user_detail->contact }}</td>
            <td class="col-4"><span class="font-weight-600">Email Id:</span> {{ $vendor_data->user_detail->email }}</td>
          </tr>
          <tr>
            <td colspan="3"><span class="font-weight-600">Adress:</span> {{ $vendor_data->vendor_address }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Fare Details -->
    <h4 class="text-4 mt-2">Fare Details</h4>
    <div class="table-responsive">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-9 font-weight-500 text-right"><strong>Total Transaction:</strong></td>
            <td class="col-3 text-right">{{ number_format($total) }}.00</td>
          </tr>
          <tr>
            <td class="col-9 font-weight-500 text-right"><strong>Paid Amount:</strong></td>
            <td class="col-3 text-right"> - {{ number_format($data->paid_amount) }}</td>
          </tr>
          <tr>
            <td class="col-9 font-weight-500 text-right"><strong>Due Amount:</strong></td>
            <td class="col-3 text-right">{{ number_format($data->due_amount) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    
  </main>
  <!-- Footer -->
  <footer class="text-center">
    <hr>
    <p><strong>JOJAYO.Pvt.ltd</strong><br>
      Bhangemudha, Kathmandu, Nepal <br>014260760 & 9802317039</p>
    <hr>
    <p class="text-1"><strong>NOTE :</strong> This is computer generated receipt and does not require physical signature.</p>
    <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a></div>
  </footer>
</div>
</body>
</html>