@extends('frontend.layouts.master')
@section('content')
<header class="header header--product" data-sticky="true">
      <nav class="navigation">
        <div class="container">
          <article class="ps-product--header-sticky">
          @php
            $starting_price = App\Models\ProductSize::where('product_id', $data->id)->first();
            $product_image = (count($data->images)>0)?product_img($data->images[0]['images'][0]['image']):'';
            @endphp
            <div class="ps-product__thumbnail"><img src="{{ $product_image ? $product_image : asset('/images/noimage.png')}}" alt="{{$data->slug}}"/></div>
            <div class="ps-product__wrapper">
              <div class="ps-product__content"><a class="ps-product__title" href="#">{{ ucwords($data->name) }}</a>
              <ul class="ps-tab-list">
                  <li class="active"><a href="#description">Description</a></li>
                  <li><a href="#specification">Specification</a></li>
                  <li><a href="#reviews">Reviews </a></li>
                </ul>
              </div>
              @php
               $starting_price = App\Models\ProductSize::where('product_id', $data->id)->first();
               $old_price = @$starting_price->selling_price;
               $new_price = @$starting_price->selling_price - @$starting_price->discount;
               @endphp
              <div class="ps-product__shopping">
                 <span class="ps-product__price"><span>NPR {{ number_format($new_price) }}</span>
                  <del>NPR {{ number_format($old_price) }}</del></span>                  
                  <a class="ps-btn btn-add-cart" value="{{ $data->id }}" data-class="btn-add-cart"> Add to Cart</a>
              </div>
            </div>
          </article>
        </div>
      </nav>
</header>

<header class="header header--mobile header--mobile-product" data-sticky="true">
      <div class="navigation--mobile">
        <div class="navigation__left"><a class="header__back" href="{{ url('/shop') }}"><i class="icon-chevron-left"></i><strong>Back to Shop</strong></a></div>
        <div class="navigation__right">
          <div class="header__actions">
          <div class="ps-cart--mini"><a class="header__extra" href="#"><i class="icon-bag2"></i><span><i>0</i></span></a>
                      <div class="ps-cart__content">
                          <div class="ps-cart__items">
                          @if(!empty(Cart::content()))
                              @foreach(Cart::content() as $row)
                              <div class="ps-product--cart-mobile">
                                  <div class="ps-product__thumbnail"><a href="{{ route('single-product', $row->options->slug) }}"><img src="{{ url('/uploads/products/'.$row->options->image) }}" alt=""></a></div>
                                  <div class="ps-product__content"><a class="ps-product__remove" value="{{ $row->rowId }}" href="#"><i class="icon-cross"></i></a><a href="{{ route('single-product', $row->options->slug) }}">{{ $row->name }}</a>
                                      <small>{{ $row->qty }} x NPR {{ number_format($row->price) }}</small>
                                  </div>
                              </div>
                              @endforeach
                          @endif
                          </div>
                          <div class="ps-cart__footer">
                              <h3>Sub Total:<strong>{{ Cart::total() }}</strong></h3>
                              <figure><a class="ps-btn" href="{{ route('cart.index') }}">View Cart</a><a class="ps-btn" href="{{ route('review') }}">Checkout</a></figure>
                          </div>
                      </div>
                  </div>
                  <div class="ps-block--user-header">
                      <div class="ps-block__left"><a href="{{ route('signinform') }}"><i class="icon-user"></i></a></div>
                      <div class="ps-block__right"><a href="{{ route('signinform') }}">Login</a></div>
                  </div>
          </div>
        </div>
      </div>
</header>


<nav class="navigation--mobile-product">
<a class="ps-btn ps-btn--black btn-add-cart" value="{{ $data->id }}" data-class="btn-add-cart">Add to cart</a>
<a class="ps-btn btn-buy-now" value="{{ $data->id }}" data-class="btn-buy-now">Buy Now</a>
</nav>

<div class="ps-breadcrumb">
      <div class="ps-container">
         <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{route('categories.sec',[$secondary->Secondarycategory->slug, $data->category->name])}}">{{ ucwords($data->category->name) }}</a></li>
            <li>{{ ucwords($data->name) }}</li>
         </ul>
      </div>
</div>

   <div class="ps-page--product">
      <div class="ps-container">
        <div class="ps-page__container">
        <div class="ps-page__left">
            <div class="ps-product--detail ps-product--fullwidth">
              <div class="ps-product__header">
                <div class="ps-product__thumbnail" data-vertical="true">
                  <figure>
                    <div class="ps-wrapper">
                      <div class="ps-product__gallery" data-arrow="true">
                              @if (count($pro_imgs) > 0)
                              @foreach ($pro_imgs as $pro_img)
                                 <div class="item">
                                    <a href="{{ product_img($pro_img) }}">
                                    <img src="{{ product_img($pro_img) }}">
                                    </a>
                                 </div>
                              @endforeach
                              @endif
                       </div>
                    </div>
                  </figure>
                  <div class="ps-product__variants" data-item="4" data-md="4" data-sm="4" data-arrow="false">
                        @if (count($pro_imgs) > 0)
                        @foreach ($pro_imgs as $image_list)
                           <div class="item">
                              <img src="{{ product_img($image_list) }}" alt="{{$data->slug}}">
                           </div>
                        @endforeach
                        @endif
                  </div>
                </div>
                <div class="ps-product__info" id="product_id" value="{{ $data->id }}">
                  <h1>{{ ucwords($data->name) }}</h1>
                  <div class="ps-product__meta">
                     @if (!empty($data->brand_id) && $data->brand->name !== 'No Brand')
                        <p>Brand: <a href="#">{{ @$data->brand->name }}</a></p>
                        @endif
                    <div class="ps-product__rating">
                        <select class="ps-rating" data-read-only="true">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><span>(1 review)</span>
                    </div>
                  </div>
                  <h4 class="ps-product__price"><span><strong>NPR</strong> {{ number_format($new_price) }}</span>
                  <del>NPR {{ number_format($old_price) }}</del></h4>

                  <div class="ps-product__desc">
                  
                    <p>Sold By:<a href="{{url('/vendor/'.$data->VendorName->vendor_slug)}}"><strong> {{$data->VendorName->company}}</strong></a></p>
                    
                  </div>
              
                  <div class="ps-product__variations">

                  <!-- <figure>
                     <figcaption>Color</figcaption>
                        @php
                        $unique_product_colors = $data->colors->unique('color_id');
                        @endphp
                        @if (!empty($unique_product_colors))
                        @foreach ($unique_product_colors as $key => $color_data)
                              <div class="ps-variant ps-variant--color @if($key==0) active @endif" value="{{ $color_data->colorInfo->id }}" style="background:{{ @$color_data->colorInfo->code }}">
                              <span class="ps-variant__tooltip">{{ $color_data->colorInfo->name }}</span></div>
                        @endforeach
                        @endif
                  </figure> -->

                     <figure id="color_data">
                     <figcaption>Color: <strong> Choose an option</strong></figcaption>
                     @php
                      $unique_product_colors = $data->colors->unique('color_id');
                      @endphp
                      @if (!empty($unique_product_colors))
                      @foreach ($unique_product_colors as $key => $color_data)
                      @php 
                      $image = App\Models\ProductImages::with('images')->where('product_id', $data->id)->where('color_id', $color_data->color_id)->first();
                      @endphp
                     <div class="ps-variant ps-variant--image @if($key == 0)first @endif" value="{{ $color_data->color_id }}"><span class="ps-variant__tooltip">{{ $color_data->colorInfo->name }}</span><img src="{{ product_img($image->images[0]['image']) }}" alt=""></div>
                     @endforeach
                      @endif
                     </figure>


                     <figure id="size_data">
                     <figcaption>Size <strong> Choose an option</strong></figcaption>
                     <ul class="size_data size-data-ul"></ul>                     
                     </figure>
                  </div>
                   

                  <div class="ps-product__shopping">
                        <figure>
                           <figcaption>Quantity</figcaption>
                           <div class="form-group--number">
                              <button class="up"><i class="fa fa-plus"></i></button>
                              <button class="down"><i class="fa fa-minus"></i></button>
                              <span value="{{ @$ids[0] }}"></span>
                              <input class="form-control vertical-quantity" type="text" min="1"
                                 value="1" data-max="">
                           </div>
                        </figure>
                        <button class="ps-btn ps-btn--black btn-add-cart" value="{{ $data->id }}" data-class="btn-add-cart">Add to
                        cart</button>
                        <button class="ps-btn btn-buy-now ps-btn--black" value="{{ $data->id }}" data-class="btn-buy-now">Buy Now</button>
                     
                     <div class="available-items">
                        <p style="color:#c5c5c5;position:relative;top:-9">
                        <span class="unavailable text-danger bold"></span><span class="available">Only <span id="stock_available">0</span> item(s) available</span>
                     </p>  
                     </div>

                    <div class="ps-product__actions">
                    <a class="wish-add" onclick="wishCart({{ $data->id }})"><i class="icon-heart"></i></a>                    
                    </div>

                  </div>
                                
                  <div class="ps-product__specification">
                    <a class="report" href="#">Report Abuse</a>
                    <p><strong>SKU:</strong> {{ @$data->sku }}</p>
                    <p class="categories"><strong> Categories:</strong>
                    <a href="{{route('categories.sec',[$secondary->Secondarycategory->slug, $data->category->name])}}">{{ ucwords($data->category->name) }}</a>
                    </p>
                    <p><small class="text-danger bold">May sure you select the correct size and color before adding it to a cart.</small><p>
                  </div>
                  <div class="ps-product__sharing">
                    <a class="facebook" value="{{ $data->id }}" onclick='fbShare("{{ URL('/')}}/{{$data->slug }}")'><i class="fa fa-facebook"></i></a>
                    <a class="twitter" value="{{ $data->id }}" onclick='twitShare("{{ URL('/')}}/{{$data->slug }}","{{ $data->name }}")'><i class="fa fa-twitter"></i></a>
                    <a class="whatsapp" value="{{ $data->id }}" onclick='whatsappShare("{{ URL('/')}}/{{$data->slug }}","{{ $data->name }}")'><i class="fa fa-whatsapp"></i></a>
                    <a class="google" value="{{ $data->id }}" href="mailto:?subject={{ $data->name }}...&amp;body={!! shortContent($data->description, 20) !!}...{{ URL('/')."/".$data->slug }}"><i class="fa fa-envelope"></i></a>
                  </div>
                </div>
              </div>
              <div class="ps-product__content ps-tab-root">
                <ul class="ps-tab-list">
                <li class="active"><a href="#description">Description</a></li>
                     <li><a href="#specification">Specification</a></li>
                     <li><a href="#reviews">Reviews (1)</a></li>
                </ul>
                <div class="ps-tabs">
                  <div class="ps-tab active" id="description">
                    <div class="ps-document">
                       {!! $data->description !!}
                    </div>
                  </div>

                  <div class="ps-tab" id="specification">
                        {!! $data->specification !!}
                  </div>

                  <div class="ps-tab" id="reviews">
                    <div class="row">
                                  <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12 ">
                                    <div class="ps-block--average-rating">
                                      <div class="ps-block__header">
                                        <h3>4.00</h3>
                                                    <select class="ps-rating" data-read-only="true">
                                                      <option value="1">1</option>
                                                      <option value="1">2</option>
                                                      <option value="1">3</option>
                                                      <option value="1">4</option>
                                                      <option value="2">5</option>
                                                    </select><span>1 Review</span>
                                      </div>
                                      <div class="ps-block__star"><span>5 Star</span>
                                        <div class="ps-progress" data-value="100"><span></span></div><span>100%</span>
                                      </div>
                                      <div class="ps-block__star"><span>4 Star</span>
                                        <div class="ps-progress" data-value="0"><span></span></div><span>0</span>
                                      </div>
                                      <div class="ps-block__star"><span>3 Star</span>
                                        <div class="ps-progress" data-value="0"><span></span></div><span>0</span>
                                      </div>
                                      <div class="ps-block__star"><span>2 Star</span>
                                        <div class="ps-progress" data-value="0"><span></span></div><span>0</span>
                                      </div>
                                      <div class="ps-block__star"><span>1 Star</span>
                                        <div class="ps-progress" data-value="0"><span></span></div><span>0</span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12 ">
                                    <form class="ps-form--review" action="http://nouthemes.net/html/martfury/index.html" method="get">
                                      <h4>Submit Your Review</h4>
                                      <p>Your email address will not be published. Required fields are marked<sup>*</sup></p>
                                      <div class="form-group form-group__rating">
                                        <label>Your rating of this product</label>
                                                    <select class="ps-rating" data-read-only="false">
                                                      <option value="0">0</option>
                                                      <option value="1">1</option>
                                                      <option value="2">2</option>
                                                      <option value="3">3</option>
                                                      <option value="4">4</option>
                                                      <option value="5">5</option>
                                                    </select>
                                      </div>
                                      <div class="form-group">
                                        <textarea class="form-control" rows="6" placeholder="Write your review here"></textarea>
                                      </div>
                                      <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  ">
                                                      <div class="form-group">
                                                        <input class="form-control" type="text" placeholder="Your Name">
                                                      </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  ">
                                                      <div class="form-group">
                                                        <input class="form-control" type="email" placeholder="Your Email">
                                                      </div>
                                                    </div>
                                      </div>
                                      <div class="form-group submit">
                                        <button class="ps-btn">Submit Review</button>
                                      </div>
                                    </form>
                                  </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="ps-page__right">
            <aside class="widget widget_product widget_features">
              <p><i class="icon-network"></i> Shipping worldwide</p>
              <p><i class="icon-3d-rotate"></i> Free 7-day return if eligible, so easy</p>
              <p><i class="icon-receipt"></i> Supplier give bills for this product.</p>
              <p><i class="icon-credit-card"></i> Pay online or when receiving goods</p>
            </aside>
            
            <aside class="widget widget_same-brand">
              <h3>Same brand products</h3>
              <div class="widget__content">
                @if(!empty($brand_products))
                @foreach($brand_products as $b_pro)
                @php                  
                $starting_price = App\Models\ProductSize::where('product_id', $b_pro->id)->first();
                $discount = $starting_price['discount'];
                $total_price = $starting_price['selling_price'] - $discount;                  
                @endphp 
                <div class="ps-product">
                  <div class="ps-product__thumbnail"><a href="{{ route('single-product', $b_pro->slug) }}"><img src="{{ product_img($b_pro->images[0]->images[0]['image']) }}" alt=""></a>
                    @if($discount > 0)<div class="ps-product__badge">NPR {{ $discount }} </div>@endif
                    <ul class="ps-product__actions">
                      <li><a href="{{ route('single-product', $b_pro->slug) }}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                      <li><a href="#" class="btn-quick-view" value="{{ $b_pro->id }}" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                      <li><a href="{{ route('single-product', $b_pro->slug) }}" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                    </ul>
                  </div>
                  <div class="ps-product__container"><a class="ps-product__vendor" href="{{url('/vendor/'.$b_pro->VendorName->vendor_slug)}}">{{ $b_pro->VendorName->company }}</a>
                    <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $b_pro->slug) }}">{{ $b_pro->name }}</a>
                      <div class="ps-product__rating">
                        <select class="ps-rating" data-read-only="true">
                          <option value="1">1</option>
                          <option value="1">2</option>
                          <option value="1">3</option>
                          <option value="1">4</option>
                          <option value="2">5</option>
                        </select><span>01</span>
                      </div>
                      <p class="ps-product__price sale">NPR {{ $total_price }} @if($discount > 0)<del>NPR {{ $starting_price->selling_price }} @endif</del></p>
                    </div>
                    <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $b_pro->slug) }}">{{ $b_pro->name }}</a>
                      <p class="ps-product__price sale">NPR {{ $total_price }} @if($discount > 0)<del>NPR {{ $starting_price->selling_price }} @endif</p>
                    </div>
                  </div>
                </div>
                @endforeach
                @endif
              </div>
            </aside>
          </div>
        </div>
       

      @if (!empty($related) && count($related) > 0)
      <div class="ps-section--default">
         <div class="ps-section__header">
            <h3>Related products</h3>
         </div>
         <div class="ps-section__content">
            <div class="ps-carousel--nav owl-slider" data-owl-auto="true" data-owl-loop="true"
               data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="6"
               data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4"
               data-owl-item-xl="5" data-owl-duration="1000" data-owl-mousedrag="on">
               @if (!empty($related))
               @foreach ($related as $related_products)
               @php
               $product_image =
               (isset($related_products->images[0]->images[0])&&count($related_products->images)>0)?$related_products->images[0]->images[0]->image: '';
               $starting_price = App\Models\ProductSize::where('product_id',
               $related_products->id)->first();
               $old_price = @$starting_price->selling_price;
               $new_price = @$starting_price->selling_price - @$starting_price->discount;
               @endphp
               <div class="ps-product">
                  <div class="ps-product__thumbnail">
                     <a href="{{ route('single-product', $related_products->slug) }}"><img
                        src="{{ product_img($product_image) }}" alt="{{$related_products->slug}}"></a>
                     @if (@$starting_price->discount > 0)
                     <div class="ps-product__badge">- NPR {{ @$starting_price->discount }}</div>
                     @endif
                     <ul class="ps-product__actions">
                     <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                        <li><a class="btn-quick-view" value="{{ $related_products->id }}"
                           data-placement="top" title="Quick View" data-toggle="modal"
                           data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" data-placement="top"
                           title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                     </ul>
                  </div>
                  <div class="ps-product__container">
                     <a class="ps-product__vendor" href="{{url('/vendor/'.$related_products->VendorName->vendor_slug)}}">{{$related_products->VendorName->company}}</a>
                     <div class="ps-product__content">
                        <a class="ps-product__title"
                           href="{{ route('single-product', $related_products->slug) }}">{{ ucwords($related_products->name) }}</a>
                        <div class="ps-product__rating">
                           <select class="ps-rating" data-read-only="true">
                              <option value="1">1</option>
                              <option value="1">2</option>
                              <option value="1">3</option>
                              <option value="1">4</option>
                              <option value="2">5</option>
                           </select>
                        </div>
                        <p class="ps-product__price">NPR {{ number_format(@$new_price) }}
                           @if (@$starting_price->discount > 0)
                           <del class="discount-product">-NPR {{ number_format($old_price) }} </del>
                           @endif
                        </p>
                     </div>
                     <div class="ps-product__content hover">
                        <a class="ps-product__title"
                           href="{{ route('single-product', $related_products->slug) }}">{{ ucwords($related_products->name) }}</a>
                        <p class="ps-product__price">NPR {{ number_format(@$new_price) }}
                           @if (@$starting_price->discount > 0)
                           <del class="discount-product">-NPR {{ number_format($old_price) }} </del>
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
      @endif

      </div>
    </div>

    <div class="related-products"></div>

@endsection
@section('scripts')
<script>

   let product_id = $('#product_id').attr('value'); 
   
   $( document ).ready(function() {
       $('.ps-variant--image.first')[0].click();
       setTimeout(function(){
           $('.size_data li.active')[0].click();
       }, 1500);
   });
   $('.ps-variant--image').on('click', function() {
       let color_id = $(this).attr('value');
       $('#color_data').attr('value', color_id);
       $.ajax({
           method: "POST",
           url: "/product-available-size/" + product_id,
           data: {
               _token: "{{ csrf_token() }}",
               _method: "POST",
               color_id: color_id
           },
           success: function(response) { console.log(response)
               $('.size_data').html('');
               $.each(response, function(key, value) {
                   var li_class = '';
                   if(key == 0){
                       li_class = "active";
                   }
                   
                   //$('.size_data').append('<li class="'+li_class+'"><span></span><input type="radio" class="size_id" value="'+response[key]['id']+'" data-colorid="' + response[key]['color_id'] +'"><label for="normal-charge">'+response[key]['name']+'</label> </li>');
                   $('.size_data').append('<li class="'+li_class+' size_id" value="'+response[key]['id']+'" data-colorid="' + response[key]['color_id'] +'"><span class="data-tag"><div class="ps-variant ps-variant--size"><span class="ps-variant__tooltip">S</span><span class="ps-variant__size">'+response[key]['name']+'</span></div></span></li>');
               });
               
               $('.size_id').on('click', function() {
                   let size_id = $(this).attr('value');
                   let color_id = $(this).data('colorid');
                   $('#size_data').attr('value', size_id);
                   $.ajax({
                       method: "POST",
                       url: "{{ route('getstock') }}",
                       data: {
                           _token: "{{ csrf_token() }}",
                           _method: "POST",
                           size_id: size_id,
                           product_id: product_id,
                           color_id: color_id
                       },
                       success: function(response) {
                           if (response[0]['stock'] > 0) {
                               $('#stock_available').html(response[0][
                                   'stock'
                               ]);
                               $('.vertical-quantity').attr('data-max', response[0]['stock']);
                               $('#selling_price').html(number_format(response[
                                   0]['selling_price']));
                               if (response[0]['discount'] != null) {
                                   discount = response[0]['selling_price'] -
                                       response[0]['discount'];
                                   $('#old_price').html(number_format(
                                       discount));
                               } else {
                                   $('#old_price').html('');
                               }
                               $('.available').removeClass('hidden');
                               $('.unavailable').addClass('hidden');
                               $('.btn-add-cart').prop("disabled",false);
                               $('.btn-buy-now').prop("disabled",false);
                               $('.up').prop("disabled",false); 
                               $('.down').prop("disabled",false);
                           } else {    
                               $('.btn-add-cart').prop("disabled",true); 
                               $('.btn-buy-now').prop("disabled",true);
                               $('.up').prop("disabled",true); 
                               $('.down').prop("disabled",true); 
                               $('.available').addClass('hidden');
                               $('.unavailable').removeClass('hidden');
                               $('.unavailable').text('Out of stock!');
                               $('#stock').addClass('text-danger');
                               $('#reload').fadeIn();
                               $('#product-unavailable').hide(1000);
                           }
                       }
                   });
               })
           }
       });
   });
   
   var btns = $('.ps-variant--image');
   for (var i = 0; i < btns.length; i++) {
     btns[i].addEventListener("click", function() {
     var current = document.getElementsByClassName("active");
     current[0].className = current[0].className.replace("active", "");
     this.className += "active";
     });
   }
   
   $(document).on('click','.size-data-ul li',function(){
       $('.size-data-ul li').removeClass("active");
       $('.size-data-ul li span').removeClass("active");
       $(this).addClass("active");
       $(this).find('span').addClass("active");
       //$(this).find('.size_id').attr('checked', 'checked');
       $(this).find('.size_id')[0].click();
       $(this).find('span').html('<i class="fa fa-check" aria-hidden="true"></i>');
   });
   
  function fbShare(url) {
    window.open("https://www.facebook.com/sharer/sharer.php?u=" + url, "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=200, left=500, width=600, height=400");
  }
  function twitShare(url, title) {
      window.open("https://twitter.com/intent/tweet?text=" + encodeURIComponent(title) + "+" + url + " via @jojayo", "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=200, left=500, width=600, height=400");
  }
  function whatsappShare(url, title) {
      message = title + " " + url;
      window.open("https://api.whatsapp.com/send?text=" + message);
  }
  function googleplusShare(url) {
      window.open("https://plus.google.com/share?url=" + url, "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=200, left=500, width=600, height=400");
  }
  
  function wishCount(){
        $.ajax({
            method: "GET",
            url: "{{ route('wish.count') }}",
            dataType: 'json',
            success(response){
                $('.wish-count').html(response.count);
            }
        });
  }

  function wishCart(id) {        
    let url = '{{ route("wish.store") }}';
    let color_id = $('#color_data').attr('value');
    if(color_id == undefined){
        toastr.warning('Please select color!');
        return;
    }
    let size_id = $('#size_data').attr('value');
    if(size_id == undefined){
        toastr.warning('Please select size!');
        return;
    }
    $.ajax({
        method: "POST",
        url: url,
        dataType: 'json',
        data: { _token:"{{ csrf_token() }}", id: id, size_id: size_id, color_id:color_id},
        success(response){
            $('.ps-product__info').closest('div').find('span').attr('value', response.rowId)
            wishCount();
            toastr.success(response.message);                
        },
        error: function(response){
            toastr.error('Something went wrong!');
        }
    });        
    }

</script>
@endsection
