@extends('frontend.layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

@endsection
@section('content')
<div class="ps-page--simple">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="{{url('/shop')}}">Shop</a></li>
            <li> Order Tracking</li>
          </ul>
        </div>
      </div>
      <div class="ps-order-tracking">
        <div class="container">
          <div class="ps-section__header">
            <h3>Order Tracking</h3>
            <p>To track your order please enter your Order ID in the box below and press the "Track Order" button.</p>
          </div>
          <div class="ps-section__content">
            <form class="ps-form--order-tracking" method="get" id="trackingForm">
              <div class="form-group">
                <label>Order ID</label>
                <input class="form-control" type="text" name="orderid" placeholder="Enter Your Order ID"/>
              </div>
              <div class="form-group">
                <button type="submit" class="ps-btn ps-btn--fullwidth submit">Track Your Order</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div id="tracking"></div>      
</div>
@endsection
@section('scripts')
<script>
  $('.submit').on('click', function(){
    event.preventDefault();
    var formdata = $("#trackingForm").serialize();
    $.ajax({      
    type: "GET",
    url: "{{ route('tracking') }}",
    data: formdata,
    success: function(response) {
        $('#tracking').append(response);
        $('html, body').animate({
          scrollTop: $("#tracking").offset().top
      }, 2000);
    },
    error: function() {
        console.log('error handling here');
    }
    })
  })
</script>
@endsection