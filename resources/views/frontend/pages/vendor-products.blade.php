@extends('frontend.layouts.master')
@section('content')
<div class="ps-page--single">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="{{url('/vendor')}}">Vendor</a></li>
            <li>{{ ucwords(str_replace('-', ' ', Request::segment(2))) }}</li>
          </ul>
        </div>
      </div>
      <div class="ps-vendor-store">
        <div class="container">
          <div class="ps-section__container">
            <div class="ps-section__left">
              <div class="ps-block--vendor">
                <div class="ps-block__thumbnail"><img src="../img/vendor/vendor-store.jpg" alt=""></div>
                <div class="ps-block__container">
                  <div class="ps-block__header">
                    <h4>{{ $vendor_data->company }}</h4>
                      <select class="ps-rating" data-read-only="true">
                        <option value="1">1</option>
                        <option value="1">2</option>
                        <option value="1">3</option>
                        <option value="1">4</option>
                        <option value="2">5</option>
                      </select>
                    <p><strong>85% Positive</strong>  (562 rating)</p>
                  </div><span class="ps-block__divider"></span>
                  <div class="ps-block__content">
                    <p><strong>{{ $vendor_data->company }}</strong>, {{ $vendor_data->intro }}</p><span class="ps-block__divider"></span>
                    </figure>
                  </div>

                </div>
              </div>
            </div>
            <div class="ps-section__right">
              <div class="ps-vendor-best-seller">
                <div class="ps-section__header">
                  <h3>Best Seller items</h3>
                  <div class="ps-section__nav"><a class="ps-carousel__prev" href="#vendor-bestseller"><i class="icon-chevron-left"></i></a><a class="ps-carousel__next" href="#vendor-bestseller"><i class="icon-chevron-right"></i></a></div>
                </div>
                <div class="ps-section__content">
                  <div class="owl-slider" id="vendor-bestseller" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="2" data-owl-item-sm="3" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on">
                   @if(!empty($best_seller))
                   @foreach($best_seller->vendor_products as $key => $value)
                   @php
                   $image_data = App\Models\ProductImages::with('images')->where('product_id', $value->products->id)->first();
                   $product_image = (count($image_data->images)>0)?product_img($image_data->images[0]->image):'';
                   $starting_price = App\Models\ProductSize::where('product_id', $value->products->id)->first();
                   $old_price = @$starting_price->selling_price;
                   $new_price = @$starting_price->selling_price - @$starting_price->discount;
                   @endphp
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $value->products->slug) }}"><img src="{{ $product_image }}" alt=""></a>
                        @if(@$starting_price->discount > 0)<div class="ps-product__badge">NPR {{ @$starting_price->discount }}</div>@endif
                        <ul class="ps-product__actions">
                            <li><a href="{{ route('single-product', $value->products->slug) }}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                            <li><a href="" data-placement="top" class="btn-quick-view" value="{{ $value->products->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                            <li><a href="{{ route('single-product', $value->products->slug) }}" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                        </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#"></a>
                        <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $value->products->slug) }}">{{ $value->products->name }}</a>
                            <div class="ps-product__rating">
                                <select class="ps-rating" data-read-only="true">
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                    <option value="2">5</option>
                                </select>
                                <span>01</span>
                            </div>
                            <p class="ps-product__price sale">NPR {{ $new_price }} @if(@$starting_price->discount > 0)<del>NPR {{ $old_price }}</del>@endif</p>
                        </div>
                        <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $value->products->slug) }}">{{ $value->products->name }}</a>
                            <p class="ps-product__price sale">NPR {{ $new_price }} @if(@$starting_price->discount > 0)<del>NPR {{ $old_price }}</del>@endif</p>
                        </div>
                        </div>
                    </div>
                   @endforeach
                   @endif
                  </div>
                </div>
              </div>
              <div class="ps-shopping ps-tab-root">
                <div class="ps-shopping__header">
                  <p><strong> {{ $count }}</strong> Products Found</p>
                  <div class="ps-shopping__actions">
                    <select class="ps-select" id="onSort" data-placeholder="Sort Items">
                        <option selected disabled>Choose one for filter</option>
                        <option value="latest" {{$requested['sort']=='latest'?'selected':''}}>Sort by latest</option>
                        <option value="oldest" {{$requested['sort']=='oldest'?'selected':''}}>Sort by older</option>
                        <option value="asc" {{$requested['sort']=='asc'?'selected':''}}>Name(A-Z)</option>
                        <option value="desc" {{$requested['sort']=='desc'?'selected':''}}>Name(Z-A)</option>
                     </select>
                    <div class="ps-shopping__view">
                      <p>View</p>
                      <ul class="ps-tab-list">
                        <li class="active"><a href="#tab-1"><i class="icon-grid"></i></a></li>
                        <li><a href="#tab-2"><i class="icon-list4"></i></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="ps-tabs">
                  <div class="ps-tab active" id="tab-1">
                    <div class="row">
                    @if(!empty($data))
                        @foreach($data as $key => $value)
                        @php
                        $product_image = (count($value->images)>0)?product_img($value->images[0]['images'][0]['image']):'';
                        $starting_price = App\Models\ProductSize::where('product_id', $value->id)->first();
                        $old_price = @$starting_price->selling_price;
                        $new_price = @$starting_price->selling_price - @$starting_price->discount;
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                            <div class="ps-product">
                                <div class="ps-product__thumbnail"><a href="{{ route('single-product', $value->slug) }}"><img src="{{ $product_image }}" alt="{{ $value->name }}"></a>
                                @if(@$starting_price->discount > 0)<div class="ps-product__badge">NPR {{ @$starting_price->discount }}</div>@endif
                                <ul class="ps-product__actions">
                                  <li><a href="{{ route('single-product', $value->slug) }}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                  <li><a href="" data-placement="top" class="btn-quick-view" value="{{ $value->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                  <li><a href="{{ route('single-product', $value->slug) }}" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                </ul>
                                </div>
                                <div class="ps-product__container"><a class="ps-product__vendor" href="#"></a>
                                <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $value->slug) }}">{{ $value->name }}</a>
                                    <div class="ps-product__rating">
                                        <select class="ps-rating" data-read-only="true">
                                            <option value="1">1</option>
                                            <option value="1">2</option>
                                            <option value="1">3</option>
                                            <option value="1">4</option>
                                            <option value="2">5</option>
                                        </select><span>01</span>
                                    </div>
                                    <p class="ps-product__price sale">NPR {{ $new_price }} @if(@$starting_price->discount > 0)<del>NPR {{ $old_price }}</del>@endif</p>
                                </div>
                                <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $value->slug) }}">{{ $value->name }}</a>
                                    <p class="ps-product__price sale">NPR {{ $new_price }} @if(@$starting_price->discount > 0)<del>NPR {{ $old_price }}</del>@endif</p>
                                </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="ps-pagination">

                    </div>
                  </div>
                  <div class="ps-tab" id="tab-2">
                        @if(!empty($data))
                        @foreach($data as $key => $value)
                        @php
                        $product_image = (count($value->images)>0)?product_img($value->images[0]['images'][0]['image']):'';
                        $starting_price = App\Models\ProductSize::where('product_id', $value->id)->first();
                        $old_price = @$starting_price->selling_price;
                        $new_price = @$starting_price->selling_price - @$starting_price->discount;
                        @endphp
                        <div class="ps-product ps-product--wide">
                            <div class="ps-product__thumbnail"><a href="{{ route('single-product', $value->slug) }}"><img src="{{ $product_image }}" alt="{{ $value->name }}"></a>
                            @if(@$starting_price->discount > 0)<div class="ps-product__badge">NPR {{ @$starting_price->discount }}</div>@endif
                            </div>
                            <div class="ps-product__container">
                            <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $value->slug) }}">{{ $value->name }}</a>
                                <div class="ps-product__rating">
                                  <select class="ps-rating" data-read-only="true">
                                      <option value="1">1</option>
                                      <option value="1">2</option>
                                      <option value="1">3</option>
                                      <option value="1">4</option>
                                      <option value="2">5</option>
                                  </select><span>01</span>
                                </div>
                                <p class="ps-product__vendor">Sold by:<a href="#"></a></p>
                                <ul class="ps-product__desc">
                                {!! shortContent($value->specification, 10) !!}
                                </ul>
                            </div>
                            <div class="ps-product__shopping">
                                <p class="ps-product__price sale">NPR {{ $new_price }} @if(@$starting_price->discount)<del>NPR {{ $old_price }}</del>@endif</p><a class="ps-btn" href="{{ route('single-product', $value->slug) }}">Add to cart</a>
                                <ul class="ps-product__actions">
                                <li><a href="{{ route('single-product', $value->slug) }}"><i class="icon-heart"></i> Wishlist</a></li>
                                <li><a href="{{ route('single-product', $value->slug) }}" data-placement="top" class="btn-quick-view" value="{{ $value->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i>View</a></li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div class="ps-pagination">

                        </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('scripts')
<script>
   var current_url='{{url()->current()}}';
   var sort = '{{$requested["sort"]}}';
   $('#onSort').change(function(){
      var sortBy=$(this).val();
      sort = sortBy
      window.location.replace(getUrl());
   })
   function getUrl(){
       var new_url=current_url
       var brand_url='';
       var price_url='';
       // var size_url='';
       var sort_url='';

       if(sort.length>0){
           sort_url = 'sort=' + sort + '&';
       }
       return new_url+='?' + sort_url
   }
</script>
@endsection
