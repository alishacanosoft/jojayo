@extends('frontend.layouts.master')
@section('content')
<div class="ps-page--simple">
            @include('frontend.layouts.front-nav')
            @include('frontend.layouts.customer-nav')
            <div class="col-lg-8">
                <div class="ps-section__right">
                @if(session()->has('success'))
                {{frontSuccess()}}
                @elseif(session()->has('warning'))
                    {{frontWarning()}}
                @elseif(session()->has('error'))
                    {{frontError()}}
                @endif



                  
                    <h3>Wishlist</h3>
                          
                    <div class="table-responsive">
                    <table class="table ps-table--whishlist">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><a href="#"><i class="icon-cross"></i></a></td>
                            <td>
                            <div class="ps-product--cart">
                                <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/electronic/1.jpg" alt=""></a></div>
                                <div class="ps-product__content"><a href="product-default.html">Marshall Kilburn Wireless Bluetooth Speaker, Black (A4819189)</a></div>
                            </div>
                            </td>
                            <td class="price">$205.00</td>
                            <td><span class="ps-tag ps-tag--in-stock">Yes</span></td>
                            <td>
                                <a href="" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add To Cart">
                                    <i class="icon-bag2"></i></a>
                            </td>
                           
                        </tr>
                        
                        </tbody>
                    </table>
                    </div>
  

                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection