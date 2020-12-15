@extends('frontend.layouts.master')
@section('content')
<nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </div><!-- End .container -->
</nav>

    <div class="container">
        <ul class="checkout-progress-bar">
            <li class="active">
                <span>Shipping</span>
            </li>
            <li>
                <span>Review &amp; Payments</span>
            </li>
        </ul>
        <div class="row">
            <div class="col-lg-8">
                <ul class="checkout-steps">
                    <li>
                        <h2 class="step-title">My Address(es)</h2>
                        <div class="shipping-step-addresses">
                          @if(!empty($my_location))
                            @foreach($my_location as $key => $my_addresses)
                            @php
                             $class = '';
                            if($key == 0){
                              $class = 'active';
                            }
                            @endphp
                            <div class="shipping-address-box {{ $class }}">
                              {{ $my_addresses->name }} <br>
                              {{ $my_addresses->address }}<br>
                              {{ @$my_addresses->City->name }}  <br>
                              {{ $my_addresses->Region->name }} <br>
                              {{ $my_addresses->phone }} <br>
                            </div><!-- End .shipping-address-box -->
                            @endforeach
                          @endif
                        </div><!-- End .shipping-step-addresses -->
                        <!--<a href="{{ route('addressList') }}" class="btn btn-sm btn-outline-secondary btn-new-address">+ New Address</a>-->
                    </li>
                </ul>
            </div><!-- End .col-lg-8 -->
            @include('frontend.layouts.summary')
        </div>
    </div>

    <div class="mb-6"></div><!-- margin -->
</main>
@endsection
@section('scripts')
<script type="text/javascript">
  $('.shipping-address-box').on('click', function(){
    $target = $(event.target);
    $target.toggleClass('active').siblings().removeClass('active');
  });
</script>
@endsection
