@extends('frontend.layouts.master')
@section('styles')
<style>
ul.ps-countdown{
    padding: 0px 0px 0px 5px
}
.ps-block__right .text-dark{
    font-size: 14px;
    font-weight: 500
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row text-left pt-10">        
        <div class="ps-container">
            <div class="ps-section__header">
                <div class="ps-block--countdown-deal">                    
                    <div class="ps-block__right">
                        <figure>
                            <figcaption>Current sale Ends in:</figcaption>
                            <ul class="ps-countdown" data-time="{{ date('F d, Y') }} {{$end_time}}">
                                <!--<li><span class="days"></span></li>-->
                                <li><span class="hours"></span></li> <span class="text-dark bold">:</span>
                                <li><span class="minutes"></span></li> <span class="text-dark bold">:</span>
                                <li><span class="seconds"></span></li>
                            </ul>
                            <a href="#today11" class="text-dark today11" @if(date('H') > 11) hidden @endif>&nbsp; &nbsp; 11:00 &nbsp; |</a>
                            <a href="#today15" class="text-dark today15" @if(date('H') > 15) hidden @endif>&nbsp; &nbsp; 15:00 &nbsp; |</a>
                            <a href="#tomorrow00" class="text-dark tomorrow00">&nbsp; Tomorrow 00:00 &nbsp; |</a>
                            <a href="#tomorrow11" class="text-dark tomorrow11">&nbsp; Tomorrow 11:00 &nbsp; |</a>
                            <a href="#tomorrow15" class="text-dark tomorrow15">&nbsp; Tomorrow 15:00 &nbsp;</a>
                        </figure>                        
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
<div class="ps-layout--shop">
    <div class="ps-product-list ps-clothings">
        <div class="ps-container">        
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
                <div class="row" @if(date('H') > 11) hidden @endif id="today11">
                    @if(!empty($eleven))
                    @foreach($eleven as $product_list)
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
                <div class="row" @if(date('H') > 15) hidden @endif id="today15">
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
                <div class="row" id="tomorrow00">
                    @if(!empty($tom0))
                    @foreach($tom0 as $product_list)
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
                <div class="row" id="tomorrow11">
                    @if(!empty($tom1))
                    @foreach($tom1 as $product_list)
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
                <div class="row" id="tomorrow15">
                    @if(!empty($tom1))
                    @foreach($tom1 as $product_list)
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
@endsection