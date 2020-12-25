@extends('frontend.layouts.master')
@section('content')
<main class="ps-page--my-account">
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

                        <div class="ps-top-categories">
                            <div class="container">
                                <div class="ps-block__header">
                                  <h3>Recent Arrival Products</h3>
                                </div>
                                <div class="ps-section__content">
                                    <div class="row align-content-lg-stretch">
                                    
                                    @foreach($latestProducts as $key => $product)
                                        @php
                                        $starting_price = App\Models\ProductSize::where('product_id', $product->id)->first();
                                        $product_image = (count($product->images)>0)?product_img($product->images[0]['images'][0]['image']):'';
                                        @endphp
                                            <div class="col-sm-6 col-md-6 col-12">
                                                <div class="ps-block--category-2 ps-block--category-auto-part" data-mh="categories">
                                                    <div class="ps-block__thumbnail"><img src="{{ $product_image ? $product_image : asset('/images/noimage.png')}}" alt="{{$product->slug}}"></div>
                                                    <div class="ps-block__content">
                                                    <ul>
                                                        <li>
                                                          <h4><a class="customer-recent-products" href="{{ route('single-product', $product->slug) }}">{{ strtoupper($product->name) }}</a></h4>
                                                        </li>
                                                    </ul>
                                                    <span class="ps-product__price"> NPR {{ number_format($starting_price['selling_price']) }}</span>

                                                    <ul>
                                                        <li class="more"><a href="{{url('/shop')}}">More<i class="icon-chevron-right"></i></a></li>
                                                    </ul>
                                                    </div>
                                                </div>
                                            </div>
                                      
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!empty($latestOrders))
                        <div class="ps-block--vendor-dashboard">
                            <div class="container">

                                <div class="ps-block__header">
                                <h3>Recent Orders</h3>
                                </div>
                                <div class="ps-block__content">
                                    <div class="table-responsive">
                                        <table class="table ps-table ps-table--vendor">
                                        <thead>
                                            <tr>
                                            <th>Date</th>
                                            <th>Order ID</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                            <th>Extra Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($latestOrders))
                                            @foreach($latestOrders as $order)
                                                <tr>
                                                <td>{{$order->created_at->format('M  j, Y')}}</td>
                                                <td class="recent-order-number">{{$order->order_no}}</td>
                                                <td>NPR {{$order->total_amount}}</td>
                                                <td>{{ucfirst(str_replace('_', ' ' ,$order->status))}}</td>
                                                <td><a href="{{url('/my-orders')}}">View Detail</a></td>
                                                </tr>
                                            @endforeach
                                        @endif 
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</section>
</main>
@endsection
