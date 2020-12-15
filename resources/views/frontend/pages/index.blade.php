@extends('frontend.layouts.master')
@section('content')
    <div id="homepage-1">
        <div class="ps-home-banner ps-home-banner--1">
            <div class="ps-container">
                <div class="ps-section__left">
                    <div class="ps-carousel--nav-inside owl-slider" data-owl-auto="true" data-owl-loop="true"
                        data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="1"
                        data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1"
                        data-owl-duration="1000" data-owl-mousedrag="on">
                        @if (!empty($all_slider))
                            @foreach ($all_slider as $slider_list)
                                <div class="ps-banner"><a href="#"><img
                                            src="{{ url('/uploads/slider/' . $slider_list->image) }}" alt=""></a></div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="ps-section__right"><a class="ps-collection" href="#"><img
                            src="/frontend/images/slider/home-1/womens-fashion.png" alt=""></a><a class="ps-collection"
                        href="#"><img src="/frontend/images/slider/home-1/mens-fashion.png" alt=""></a></div>
            </div>
        </div>
        <!-- delivery -->
        @if (!empty($flash) && count($flash) > 0)
            <div class="ps-deal-of-day">
                <div class="ps-container">
                    <div class="ps-section__header">
                        <div class="ps-block--countdown-deal">
                            <div class="ps-block__left">
                                <h3>Deals of the day</h3>
                            </div>
                            <div class="ps-block__right">
                                <figure>
                                    <figcaption>Ends in:</figcaption>
                                    <ul class="ps-countdown" data-time="{{ date('F d, Y') }} {{ $end_time }}">
                                        <!--<li><span class="days"></span></li>-->
                                        <li><span class="hours"></span></li> <span class="text-dark bold">:</span>
                                        <li><span class="minutes"></span></li> <span class="text-dark bold">:</span>
                                        <li><span class="seconds"></span></li>
                                    </ul>
                                </figure>
                            </div>
                        </div><a href="{{ url('/flash-sales') }}">View all</a>
                    </div>
                    <div class="ps-section__content">
                        <div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false"
                            data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true"
                            data-owl-item="7" data-owl-item-xs="2" data-owl-item-sm="3" data-owl-item-md="4"
                            data-owl-item-lg="5" data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on">
                            @if (!empty($flash))
                                @foreach ($flash as $recent_products)
                                    @php
                                    $starting_price = App\Models\ProductSize::where('product_id',
                                    $recent_products->product_id)->first();
                                    $total_price = $recent_products->selling_price;
                                    $product_image = App\Models\ProductImages::where('product_id',
                                    $recent_products->product_id)->where('color_id', $recent_products->color_id)->first();
                                    $image = App\Models\Image::where('imageable_id', $product_image->id)->first();
                                    @endphp
                                    <div class="ps-product">
                                        <div class="ps-product__thumbnail"><a
                                                href="{{ route('single-product', $recent_products->product->slug) }}"><img
                                                    src="{{ product_img($image->image) }}" alt=""></a>
                                            @if ($recent_products->flash_price > 0)
                                                <div class="ps-product__badge">
                                                    -{{ $recent_products->selling_price - $recent_products->flash_price }}
                                                    NPR </div>
                                            @endif
                                            <ul class="ps-product__actions">
                                                <li><a href="#" data-placement="top" class="btn-quick-view"
                                                        value="{{ $recent_products->id }}" title="Quick View"
                                                        data-toggle="modal" data-target="#product-quickview"><i
                                                            class="icon-eye"></i></a></li>
                                                <li><a href="#" data-toggle="tooltip" data-placement="top"
                                                        title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="ps-product__container">
                                            <a class="ps-product__vendor" href="#">Jojayo Store</a>
                                            <div class="ps-product__content"><a class="ps-product__title"
                                                    href="{{ route('single-product', $recent_products->product->slug) }}">{{ $recent_products->product->name }}</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select>
                                                </div>
                                                <p class="ps-product__price sale">NPR {{ $recent_products->flash_price }}
                                                    @if ($recent_products->flash_price > 0)
                                                        <del>NPR {{ $recent_products->selling_price }}</del>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="ps-product__content hover"><a class="ps-product__title"
                                                    href="{{ route('single-product', $recent_products->product->slug) }}">{{ $recent_products->product->name }}</a>
                                                <p class="ps-product__price sale">NPR {{ $recent_products->flash_price }}
                                                    @if ($recent_products->flash_price > 0)
                                                        <del>NPR {{ $recent_products->selling_price }}</del>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- <div class="ps-home-ads">
                        <div class="ps-container">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img src="/frontend/images/collection/home-1/1.jpg" alt=""></a>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img src="/frontend/images/collection/home-1/2.jpg" alt=""></a>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img src="/frontend/images/collection/home-1/3.jpg" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div> -->
        <br>
        <div class="ps-product-list ps-clothings">
            <div class="ps-container">
                <div class="ps-section__header">
                    <h3>Women's Fashion</h3>
                </div>
                <div class="ps-section__content">
                    <div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false"
                        data-owl-speed="10000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="7"
                        data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4"
                        data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on">

                        @if (!empty($women_fashion))
                            @foreach ($women_fashion as $women_products)
                                @php
                                //$product_image =
                                //
                                (isset($women_products->images)&&count($women_products->images)>0)?$women_products->images[0]->image:'';
                                $starting_price = App\Models\ProductSize::where('product_id', $women_products->id)->first();
                                $discount = $starting_price['discount'];
                                $total_price = $starting_price['selling_price'] - $discount;
                                $product_image =
                                (count($women_products->images)>0)?product_img($women_products->images[0]['images'][0]['image']):'';
                                @endphp
                                <div class="ps-product">
                                    <div class="ps-product__thumbnail"><a
                                            href="{{ route('single-product', $women_products->slug) }}"><img
                                                src="{{ $product_image }}" alt=""></a>
                                        @if ($discount > 0)
                                            <div class="ps-product__badge">-{{ $discount }} NPR </div>
                                        @endif
                                        <ul class="ps-product__actions">
                                            <li><a href="#" data-placement="top" class="btn-quick-view"
                                                    value="{{ $women_products->id }}" title="Quick View" data-toggle="modal"
                                                    data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                            <li><a href="#" data-toggle="tooltip" data-placement="top"
                                                    title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="ps-product__container">
                                        <a class="ps-product__vendor" href="#">Jojayo Store</a>
                                        <div class="ps-product__content"><a class="ps-product__title"
                                                href="{{ route('single-product', $women_products->slug) }}">{{ $women_products->name }}</a>
                                            <div class="ps-product__rating">
                                                <select class="ps-rating" data-read-only="true">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                    <option value="1">3</option>
                                                    <option value="1">4</option>
                                                    <option value="2">5</option>
                                                </select>
                                            </div>
                                            <p class="ps-product__price sale">NPR {{ $total_price }}
                                                @if ($discount > 0)
                                                    <del>NPR {{ $total_price + $discount }}</del>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="ps-product__content hover"><a class="ps-product__title"
                                                href="{{ route('single-product', $women_products->slug) }}">{{ $women_products->name }}</a>
                                            <p class="ps-product__price sale">NPR {{ $total_price }}
                                                @if ($discount > 0)
                                                    <del>NPR {{ $total_price + $discount }}</del>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="ps-product-list ps-clothings">
            <div class="ps-container">
                <div class="ps-section__header">
                    <h3>Men's Clothings</h3>
                </div>
                <div class="ps-section__content">
                    <div class="ps-carousel--nav owl-slider" data-owl-auto="false" data-owl-loop="false"
                        data-owl-speed="10000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="7"
                        data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4"
                        data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on">
                        @if (!empty($men_fashion))
                            @foreach ($men_fashion as $men_products)
                                @php
                                //$product_image =
                                //
                                (isset($men_products->images)&&count($men_products->images)>0)?$men_products->images[0]->image:'';
                                $starting_price = App\Models\ProductSize::where('product_id', $men_products->id)->first();
                                $discount = $starting_price['discount'];
                                $total_price = $starting_price['selling_price'] - $discount;
                                $product_image =
                                (count($men_products->images)>0)?product_img($men_products->images[0]['images'][0]['image']):'';
                                @endphp
                                <div class="ps-product">
                                    <div class="ps-product__thumbnail"><a
                                            href="{{ route('single-product', $men_products->slug) }}"><img
                                                src="{{ $product_image }}" alt=""></a>
                                        @if ($discount > 0)
                                            <div class="ps-product__badge">-{{ $discount }} NPR </div>
                                        @endif
                                        <ul class="ps-product__actions">
                                            <li><a href="#" data-placement="top" class="btn-quick-view"
                                                    value="{{ $men_products->id }}" title="Quick View" data-toggle="modal"
                                                    data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                            <li><a href="#" data-toggle="tooltip" data-placement="top"
                                                    title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="ps-product__container">
                                        <a class="ps-product__vendor" href="#">Jojayo Store</a>
                                        <div class="ps-product__content"><a class="ps-product__title"
                                                href="{{ route('single-product', $men_products->slug) }}">{{ $men_products->name }}</a>
                                            <div class="ps-product__rating">
                                                <select class="ps-rating" data-read-only="true">
                                                    <option value="1">1</option>
                                                    <option value="1">2</option>
                                                    <option value="1">3</option>
                                                    <option value="1">4</option>
                                                    <option value="2">5</option>
                                                </select>
                                            </div>
                                            <p class="ps-product__price sale">NPR {{ $total_price }}
                                                @if ($discount > 0)
                                                    <del>NPR {{ $total_price + $discount }}</del>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="ps-product__content hover"><a class="ps-product__title"
                                                href="{{ route('single-product', $men_products->slug) }}">{{ $men_products->name }}</a>
                                            <p class="ps-product__price sale">NPR {{ $total_price }}
                                                @if ($discount > 0)
                                                    <del>NPR {{ $total_price + $discount }}</del>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="ps-home-ads">
                        <div class="ps-container">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img src="/frontend/images/collection/home-1/ad-1.jpg" alt=""></a>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 "><a class="ps-collection" href="#"><img src="/frontend/images/collection/home-1/ad-2.jpg" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div> -->

        <!-- <div class="ps-download-app">
                        <div class="ps-container">
                            <div class="ps-block--download-app">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                                            <div class="ps-block__thumbnail"><img src="/frontend/images/app.png" alt=""></div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                                            <div class="ps-block__content">
                                                <h3>Download Martfury App Now!</h3>
                                                <p>Shopping fastly and easily more with our app. Get a link to download the app on your phone</p>
                                                <form class="ps-form--download-app" action="http://nouthemes.net/html/martfury/do_action" method="post">
                                                    <div class="form-group--nest">
                                                        <input class="form-control" type="Email" placeholder="Email Address">
                                                        <button class="ps-btn">Subscribe</button>
                                                    </div>
                                                </form>
                                                <p class="download-link"><a href="#"><img src="/frontend/images/google-play.png" alt=""></a><a href="#"><img src="/frontend/images/app-store.png" alt=""></a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --> <br>
        <div class="ps-product-list ps-new-arrivals">
            <div class="ps-container">
                <div class="ps-section__header">
                    <h3>Hot New Arrivals</h3>
                </div>
                <div class="ps-section__content">
                    <div class="row">
                        @if (!empty($latest_products))
                            @foreach ($latest_products as $recent_products)
                                @php
                                // $product_image =
                                (isset($recent_products->images)&&count($recent_products->images)>0)?$recent_products->images[0]->image:'';
                                //$product_image=product_img($men_products->images[0]['images'][0]['image']);
                                $starting_price = App\Models\ProductSize::where('product_id',
                                $recent_products->id)->first();
                                $product_image=(count($recent_products->images)>0)?product_img($recent_products->images[0]['images'][0]['image']):'';
                                @endphp
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 ">
                                    <div class="ps-product--horizontal">
                                        <div class="ps-product__thumbnail"><a
                                                href="{{ route('single-product', $recent_products->slug) }}"><img
                                                    src="{{ $product_image }}" alt=""></a></div>
                                        <div class="ps-product__content"><a class="ps-product__title"
                                                href="{{ route('single-product', $recent_products->slug) }}">{{ $recent_products->name }}</a>
                                            <p class="ps-product__price">NPR
                                                {{ number_format($starting_price['selling_price']) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="ps-site-features">
            <div class="ps-container">
                <div class="ps-block--site-features">
                    <div class="ps-block__item">
                        <div class="ps-block__left"><i class="icon-rocket"></i></div>
                        <div class="ps-block__right">
                            <h4>Free Delivery</h4>
                            <p>For all oders over $99</p>
                        </div>
                    </div>
                    <div class="ps-block__item">
                        <div class="ps-block__left"><i class="icon-sync"></i></div>
                        <div class="ps-block__right">
                            <h4>90 Days Return</h4>
                            <p>If goods have problems</p>
                        </div>
                    </div>
                    <div class="ps-block__item">
                        <div class="ps-block__left"><i class="icon-credit-card"></i></div>
                        <div class="ps-block__right">
                            <h4>Secure Payment</h4>
                            <p>100% secure payment</p>
                        </div>
                    </div>
                    <div class="ps-block__item">
                        <div class="ps-block__left"><i class="icon-bubbles"></i></div>
                        <div class="ps-block__right">
                            <h4>24/7 Support</h4>
                            <p>Dedicated support</p>
                        </div>
                    </div>
                    <div class="ps-block__item">
                        <div class="ps-block__left"><i class="icon-gift"></i></div>
                        <div class="ps-block__right">
                            <h4>Gift Service</h4>
                            <p>Support gift service</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
