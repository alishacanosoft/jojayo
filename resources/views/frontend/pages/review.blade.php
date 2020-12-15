@extends('frontend.layouts.master')
@section('styles')
<style>
    .delivery-data {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }
    
    .delivery-data li {
      float: left;
      margin: 0 5px 0 0;
      width: 70px;
      height: 40px;
      position: relative;
    }
    
    .delivery-data label,
    .delivery-data input {
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
    }
    
    .delivery-data input[type="radio"] {
      opacity: 0.01;
      z-index: 100;
    }
    
    .delivery-data input[type="radio"]:checked+label,
    .Checked+label {
      box-shadow: 2px 3px #b9b9b9;
    }
    
    .delivery-data label {
      padding: 9px 6px;
      border: 1px solid #CCC;
      cursor: pointer;
      z-index: 90;
      border-radius: 5px;
      background: #d4d4d4;
      margin-bottom: 0px;
    }
    
    .delivery-data label:hover {
      background: #DDD;
    }
</style>
@endsection
@section('content')
<br>
<div class="container-fluid">
    <div class="row ps-form__billing-info">
        @include('frontend.layouts.summary')
        <div class="col-lg-8 order-lg-first">
            <div class="checkout-payment">
              <div class="row">                  
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <h3 class="ps-form__heading">Default Billing Address</h3>
                    <address>
                    {{ $my_address_book[0]->name }} <br>
                    {{ $my_address_book[0]->address }},  {{ @$my_address_book[0]->Region->name }}, <br>
                    Nepal <br>                      
                    {{ $my_address_book[0]->phone }}
                    </address>
                  </div>
                  <div class="form-group">
                      <div class="ps-checkbox">
                          <input class="form-control" type="checkbox" id="cb01">
                          <label for="cb01">My billing and shipping address is same</label>
                      </div>
                  </div>
              </div>
              <div class="shipping-address">
                  <div class="ps-form__billing-info">
                      <h4 class="ps-form__heading">Billing Details</h4>
                      <div class="form-group">
                          <label>First Name<sup>*</sup>
                          </label>
                          <div class="form-group__content">
                              <input class="form-control" type="text">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Last Name<sup>*</sup>
                          </label>
                          <div class="form-group__content">
                              <input class="form-control" type="text">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Company Name<sup>*</sup>
                          </label>
                          <div class="form-group__content">
                              <input class="form-control" type="text">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Email Address<sup>*</sup>
                          </label>
                          <div class="form-group__content">
                              <input class="form-control" type="email">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Country<sup>*</sup>
                          </label>
                          <div class="form-group__content">
                              <input class="form-control" type="text">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Phone<sup>*</sup>
                          </label>
                          <div class="form-group__content">
                              <input class="form-control" type="text">
                          </div>
                      </div>
                      <div class="form-group">
                          <label>Address<sup>*</sup>
                          </label>
                          <div class="form-group__content">
                              <input class="form-control" type="text">
                          </div>
                      </div>                                          
                  </div>
                </div>

                
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">   
                    <h4 class="ps-form__heading">Delivery Method</h4>
                        <ul class="delivery-data">
                      <li>
                        <input type="radio" id="normal-charge" name="delivery_type" value="" checked>
                        <label for="normal-charge">Normal</label>
                      </li>
                      <li>
                        <input type="radio" id="express-charge" name="delivery_type" value="">
                        <label for="express-charge">Express</span></label>
                      </li>
                    </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h4 class="ps-form__heading">Payment Method</h4> 
                        <form method='POST' action="{{ route('checkout.payment.esewa.process') }}" style="display:initial">
                          @csrf               
                          <span class="cash_data" data-add=""></span>
                          <button class='btn esewa_btn'><img src="/frontend/images/payment-method/esewa.png" alt=""></button>
                        </form>
                        
                        <form method='POST' action="{{ route('checkout.payment.connectips.process') }}" style="display:initial">
                            @csrf
                            <span class="cash_data" data-add=""></span>
                            <button class='btn esewa_btn'>
                                <img src="/frontend/images/payment-method/connect.png" alt="">
                            </button>
                        </form>
                                        
                        <form method='POST' action="{{ route('orders.store') }}" style="display:initial">
                          @csrf
                          <span class="cash_data" data-add=""></span>
                          <button class='btn cash_on_delivery'><img src="/frontend/images/payment-method/cod.png" alt=""></button>
                        </form>   
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
<div class="mb-6"></div>

@endsection
@section('scripts')
<script type="text/javascript">
let logged_name = "{{ Auth::user()->name }}";
let logged_contact = "{{ Auth::user()->contact }}";
let user_id = "{{ Auth::user()->id }}";
let second_url = "{{ route('user.address', ':data') }}";
second_url = second_url.replace(':data', user_id);
let html = '';
$.ajax({
  method: "GET",
  url: second_url,
  dataType: 'json',
  success(response){      
    html += "<div class='form-group-custom-control'></div>";
    $('#cb01').on('click', function(){
        $('.cash_data').html('<input type="hidden" name="address" value="'+response.id+'">');
        $('.shipping-address').toggle();
    })    
  }
});

$('.cash_on_delivery, .esewa_btn').on('click', function(){
    let order_id = "{{ getOrderId() }}";
    $('.cash_data').append('<input type="hidden" name="order_id" value="'+order_id+'">');
})
$('input[name="delivery_type"]').on('change', function(){
    let delivery = $(this).val();
    $('.cash_data').append('<input type="hidden" name="delivery_method" value="'+delivery+'">');
});
</script>
@endsection
