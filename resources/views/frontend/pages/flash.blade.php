@extends('frontend.layouts.master')
@section('styles')
<style>
.scroll{
    cursor: pointer;
}
.ps-block__right .text-dark{
    font-size: 14px;
    font-weight: 500
}
</style>
@endsection
@section('content')
<div class="ps-page--simple">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="{{url('/shop')}}">Shop</a></li>
            <li>Deals of the day</li>
          </ul>
        </div>
      </div>

    <div class="container-fluid container-flash">
        <div class="row text-left pt-10">        
            <div class="ps-container">
                <div class="ps-section__header">
                    <div class="ps-block--countdown-deal">                    
                        <div class="ps-block__right">
                            <figure class="flash-sale-header">
                                @php
                                if(date('H') >= '07' && date('H') <= '11' && !empty($mid) && count($mid) > 0){
                                    $date = date('F d, Y');
                                    $next_sale = '12:00:00';
                                } elseif(date('H') >= '12' && date('H') <= '19' && !empty($three) && count($three) > 0){
                                    $date = date('F d, Y');
                                    $next_sale = '15:00:00';
                                } elseif(date('H') >= '00' && date('H') <= '07' && !empty($first) && count($first) > 0){
                                    $date = date("Y-m-d", strtotime("+1 day"));
                                    $next_sale = '11:00:00';
                                } elseif(date('H') >= '12' && date('H') <= '15' && !empty($second) && count($second) > 0){                                    
                                    $date = date("Y-m-d", strtotime("+1 day"));
                                    $next_sale = '12:00:00';
                                } elseif(date('H') >= '15' && date('H') <= '19' && !empty($third) && count($third) > 0){
                                    $date = date("Y-m-d", strtotime("+1 day"));
                                    $next_sale = '15:00:00';
                                }                                
                                @endphp
                                @if(!empty($flash) && count($flash) > 0)                              
                                <figcaption>Current sale Ends in:</figcaption>
                                <ul class="ps-countdown" data-time="{{ date('F d, Y') }} {{$end_time}}">
                                    <li><span class="hours"></span></li> <span class="text-dark bold">:</span>
                                    <li><span class="minutes"></span></li> <span class="text-dark bold">:</span>
                                    <li><span class="seconds"></span></li>
                                </ul>
                                @else
                                <figcaption>Sale starts in:</figcaption>
                                <ul class="ps-countdown" data-time="{{ $date }} {{ $next_sale }}">
                                    <li><span class="hours"></span></li> <span class="text-dark bold">:</span>
                                    <li><span class="minutes"></span></li> <span class="text-dark bold">:</span>
                                    <li><span class="seconds"></span></li>
                                </ul>
                                @endif
                                @if(!empty($mid) && count($mid) > 0)<a data-href="today11" class="text-dark scroll today11" @if(date('H') > 11) hidden @endif>&nbsp; &nbsp; 11:00 &nbsp; |</a>@endif
                                @if(!empty($three) && count($three) > 0)<a data-href="today15" class="text-dark scroll today15" @if(date('H') > 15) hidden @endif>&nbsp; &nbsp; 15:00 &nbsp; |</a>@endif
                                @if(!empty($first) && count($first) > 0)<a data-href="tomorrow00" class="text-dark scroll tomorrow00">&nbsp; Tomorrow 00:00 &nbsp; |</a>@endif
                                @if(!empty($second) && count($second) > 0)<a data-href="tomorrow11" class="text-dark scroll tomorrow11">&nbsp; Tomorrow 11:00 &nbsp; |</a>@endif
                                @if(!empty($third) && count($third) > 0)<a data-href="tomorrow15" class="text-dark scroll tomorrow15">&nbsp; Tomorrow 15:00 &nbsp;</a>@endif
                            </figure>                        
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>

    <section class="flash-category">
            @if(!empty($flash) && count($flash) > 0)
            <div class="ps-layout--shop">
                <div class="ps-product-list ps-clothings">
                    <div class="ps-container"> 

                        <div class="ps-section__header">
                            <h3>Flash Sales</h3>
                        </div>

                        <div class="ps-shopping-product">
                            <div class="row" id="product-data">
                                @if(!empty($flash))
                                @foreach($flash as $product_list)
                                @php
                                $starting_price = App\Models\ProductSize::where('product_id', $product_list->product_id)->first();
                                $total_price = $product_list->selling_price;
                                $product_image = App\Models\ProductImages::where('product_id', $product_list->product_id)->where('color_id', $product_list->color_id)->first();
                                $image = App\Models\Image::where('imageable_id', $product_image->id)->first();
                                @endphp
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-6">
                                    <div class="ps-product">
                                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->product->slug) }}"><img src="{{ product_img($image->image) }}" alt=""></a>
                                            <ul class="ps-product__actions">
                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                <li><a data-placement="top" class="btn-quick-view" value="{{ $product_list->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                <li><a data-toggle="tooltip" data-placement="bottom" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">{{ $product_list->product->productCategory->name }}</a>
                                            <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select>
                                                </div>
                                                <p class="ps-product__price">NPR {{ number_format($starting_price['selling_price']) }}</p>
                                            </div>
                                            <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <p class="ps-product__price">NPR {{ number_format($starting_price['selling_price']) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endif
            @if(!empty($mid) && count($mid) > 0)
            <div class="ps-layout--shop" id="today11" @if(date("H") > 11) hidden @endif>
                <div class="ps-product-list ps-clothings">
                    <div class="ps-container">
                        <div class="ps-section__header">
                            <h3>Flash Sales | Today 11</h3>
                        </div>
                        <div class="ps-shopping-product">                
                            <div class="row" @if(date("H") > 11) hidden @endif >
                                @if(!empty($mid))
                                @foreach($mid as $product_list)
                                @php
                                $starting_price = App\Models\ProductSize::where('product_id', $product_list->product_id)->first();
                                $total_price = $product_list->selling_price;
                                $product_image = App\Models\ProductImages::where('product_id', $product_list->product_id)->where('color_id', $product_list->color_id)->first();
                                $image = App\Models\Image::where('imageable_id', $product_image->id)->first();
                                @endphp
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-6">
                                    <div class="ps-product">
                                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->product->slug) }}"><img src="{{ product_img($image->image) }}" alt=""></a>
                                            <ul class="ps-product__actions">
                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                <li><a data-placement="top" class="btn-quick-view" value="{{ $product_list->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                <li><a data-toggle="tooltip" data-placement="bottom" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">{{ $product_list->product->productCategory->name }}</a>
                                            <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select>
                                                </div>
                                                <p class="ps-product__price">@if(date('H') < 15) ??? @else NPR {{ number_format($starting_price['selling_price']) }} @endif</p>
                                            </div>
                                            <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <p class="ps-product__price">@if(date('H') < 15) ??? @else NPR {{ number_format($starting_price['selling_price']) }} @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($three) && count($three) > 0)
            <div class="ps-layout--shop" @if(date('H') > 15) hidden @endif id="today15">
                <div class="ps-product-list ps-clothings">
                    <div class="ps-container"> 

                        <div class="ps-section__header">
                            <h3>Flash Sales | Today 15</h3>
                        </div>
                        <div class="ps-shopping-product">
                            <div class="row" @if(date('H') > 15) hidden @endif>
                                @if(!empty($three))
                                @foreach($three as $product_list)
                                @php
                                $starting_price = App\Models\ProductSize::where('product_id', $product_list->product_id)->first();
                                $total_price = $product_list->selling_price;
                                $product_image = App\Models\ProductImages::where('product_id', $product_list->product_id)->where('color_id', $product_list->color_id)->first();
                                $image = App\Models\Image::where('imageable_id', $product_image->id)->first();
                                @endphp
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-6">
                                    <div class="ps-product">
                                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->product->slug) }}"><img src="{{ product_img($image->image) }}" alt=""></a>
                                            <ul class="ps-product__actions">
                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                <li><a data-placement="top" class="btn-quick-view" value="{{ $product_list->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                <li><a data-toggle="tooltip" data-placement="bottom" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">{{ $product_list->product->productCategory->name }}</a>
                                            <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select>
                                                </div>
                                                <p class="ps-product__price">@if(date('H') < 15) ??? @else NPR {{ number_format($starting_price['selling_price']) }} @endif</p>
                                            </div>
                                            <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <p class="ps-product__price">@if(date('H') < 15) ??? @else NPR {{ number_format($starting_price['selling_price']) }} @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($first) && count($first) > 0)
            <div class="ps-layout--shop" id="tomorrow00">
                <div class="ps-product-list ps-clothings">
                    <div class="ps-container"> 

                        <div class="ps-section__header">
                            <h3>Flash Sales | Tomorrow 00</h3>
                        </div>
                        <div class="ps-shopping-product">
                            <div class="row">
                                @if(!empty($first))
                                @foreach($first as $product_list)
                                @php
                                $starting_price = App\Models\ProductSize::where('product_id', $product_list->product_id)->first();
                                $total_price = $product_list->selling_price;
                                $product_image = App\Models\ProductImages::where('product_id', $product_list->product_id)->where('color_id', $product_list->color_id)->first();
                                $image = App\Models\Image::where('imageable_id', $product_image->id)->first();
                                @endphp
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-6">
                                    <div class="ps-product">
                                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->product->slug) }}"><img src="{{ product_img($image->image) }}" alt=""></a>
                                            <ul class="ps-product__actions">
                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                <li><a data-placement="top" class="btn-quick-view" value="{{ $product_list->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                <li><a data-toggle="tooltip" data-placement="bottom" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">{{ $product_list->product->productCategory->name }}</a>
                                            <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select>
                                                </div>
                                                <p class="ps-product__price">@if(date('H') < 15) ??? @else NPR {{ number_format($starting_price['selling_price']) }} @endif</p>
                                            </div>
                                            <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <p class="ps-product__price">@if(date('H') < 15) ??? @else NPR {{ number_format($starting_price['selling_price']) }} @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($second) && count($second) > 0)
            <div class="ps-layout--shop"  id="tomorrow11">
                <div class="ps-product-list ps-clothings">
                    <div class="ps-container"> 

                        <div class="ps-section__header">
                            <h3>Flash Sales | Tomorrow 11</h3>
                        </div>
                        <div class="ps-shopping-product">
                            <div class="row">
                                @if(!empty($second))
                                @foreach($second as $product_list)
                                @php
                                $starting_price = App\Models\ProductSize::where('product_id', $product_list->product_id)->first();
                                $total_price = $product_list->selling_price;
                                $product_image = App\Models\ProductImages::where('product_id', $product_list->product_id)->where('color_id', $product_list->color_id)->first();
                                $image = App\Models\Image::where('imageable_id', $product_image->id)->first();
                                @endphp
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-6">
                                    <div class="ps-product">
                                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->product->slug) }}"><img src="{{ product_img($image->image) }}" alt=""></a>
                                            <ul class="ps-product__actions">
                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                <li><a data-placement="top" class="btn-quick-view" value="{{ $product_list->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                <li><a data-toggle="tooltip" data-placement="bottom" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">{{ $product_list->product->productCategory->name }}</a>
                                            <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select>
                                                </div>
                                                <p class="ps-product__price">@if(date('H') < 15) ??? @else NPR {{ number_format($starting_price['selling_price']) }} @endif</p>
                                            </div>
                                            <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <p class="ps-product__price">@if(date('H') < 15) ??? @else NPR {{ number_format($starting_price['selling_price']) }} @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($third) && count($third) > 0)
            <div class="ps-layout--shop" id="tomorrow15">
                <div class="ps-product-list ps-clothings">
                    <div class="ps-container"> 

                        <div class="ps-section__header">
                            <h3>Flash Sales | Tomorrow 15</h3>
                        </div>
                        <div class="ps-shopping-product">
                            <div class="row">
                                @if(!empty($third))
                                @foreach($third as $product_list)
                                @php
                                $starting_price = App\Models\ProductSize::where('product_id', $product_list->product_id)->first();
                                $total_price = $product_list->selling_price;
                                $product_image = App\Models\ProductImages::where('product_id', $product_list->product_id)->where('color_id', $product_list->color_id)->first();
                                $image = App\Models\Image::where('imageable_id', $product_image->id)->first();
                                @endphp
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-6">
                                    <div class="ps-product">
                                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->product->slug) }}"><img src="{{ product_img($image->image) }}" alt=""></a>
                                            <ul class="ps-product__actions">
                                                <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                <li><a data-placement="top" class="btn-quick-view" value="{{ $product_list->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                <li><a data-toggle="tooltip" data-placement="bottom" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#">{{ $product_list->product->productCategory->name }}</a>
                                            <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select>
                                                </div>
                                                <p class="ps-product__price">@if(date('H') < 15) ??? @else NPR {{ number_format($starting_price['selling_price']) }} @endif</p>
                                            </div>
                                            <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $product_list->product->slug) }}">{{ $product_list->product->name }}</a>
                                                <p class="ps-product__price">@if(date('H') < 15) ??? @else NPR {{ number_format($starting_price['selling_price']) }} @endif</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
    </section>

</div>
@endsection

@section('scripts')
<script>
    $(".scroll").click(function() {
        id = $(this).attr('data-href');
        $('html, body').animate({
            scrollTop: $("#"+id).offset().top
        }, 2000);
    });
</script>
@endsection