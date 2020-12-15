@extends('frontend.layouts.master')
@section('content')<br>
    <div class="container success-page">
        <div style="background: #eee;padding:10px;margin-bottom:15px">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="merchant-confirmation pull-left">
                                <span>Jojayo - eSewa Merchant</span><br>
                                Website: <a href="">https://jojayo.com</a><br>
                                Email: <a href="mailto:info@jojayo.com">info@jojayo.com</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="esewa-logo pull-right">
                                <img src="/frontend/images/esewa-logo.png">
                            </div>
                        </div>
                    </div><br>
                    <div class="order-summary">
                        <table>
                          <thead>
                              <th>Product Name</th>
                              <th>Quantity</th>
                              <th>Price</th>
                              <th>Total</th>
                          </thead>
                          @if(!empty($order_detail))
                          @php $grand = 0; @endphp
                          @foreach($order_detail as $row)
                          @php
                          $total = $row->quantity*$row->price;
                          $grand = $grand+$total;
                          @endphp
                          <tr>
                            <td><a href="{{ route('single-product', $row->products->slug) }}">{{ $row->products->name }}</a></td>
                            <td>{{ $row->quantity }}</td>
                            <td>{{ number_format($row->price) }}</td>
                            <td>{{ number_format($total) }}</td>
                          </tr>
                          @endforeach
                          <tr>
                            <td><strong>Sub Total</strong></td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($grand) }}</td>
                          </tr>
                          <tr>
                            <td><strong>Shipping</strong></td>
                            <td></td>
                            <td></td>
                            <td>20</td>
                          </tr>
                          <tr>
                            <td><strong>Grand Total</strong></td>
                            <td></td>
                            <td></td>
                            <td>{{ number_format($grand + 20) }}</td>
                          </tr>
                          @endif
                        </table>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="order-response">
                    @if(!empty($message))
                    <p>{{ $message }}</p>
                    @endif
                    <p><strong>Order ID</strong> <br><span>{{ $_GET['oid'] }}</span></p>
                    
                    <p><strong>Reference ID</strong> <br><span>{{ $_GET['refId'] }}</span></p>
                    
                    <p><strong>Total Amount</strong> <br><span>{{ $_GET['amt'] }}</span></p>
                    <a class="secondary-button" href="{{ url('/shop') }}">Go to Shop Page</a>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection