@extends('frontend.layouts.master')
@section('styles')
<style>
   button[disabled]{
   cursor: not-allowed;
   }
   .font-13{font-size:13px;}
   .size-data-ul {
   list-style-type: none;
   margin: 0;
   padding: 0;
   margin-left: 15px;
   }
   .size-data-ul span{display:none;}
   .size-data-ul li.active span.active{background: #000;}
   .size-data-ul li.active span{
   position: absolute;
   z-index: 999;
   top: 0;
   bottom: 0;
   right: 0px;
   left: 24px;
   height: 13px;
   width: 13px;
   display: block;
   color: #fff;
   font-size: 10px;
   padding: 1.4px;
   }
   .size-data-ul li {
   float: left;
   margin: 0 5px 0 0;
   width: 38px;
   height: 37px;
   position: relative;
   }
   .size-data-ul label,
   .size-data-ul input {
   display: block;
   position: absolute;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   }
   .size-data-ul input[type="radio"] {
   opacity: 0.01;
   z-index: 100;
   }
   .size-data-ul label {
   padding: 8px;
   border: 1px solid #efefef;
   cursor: pointer;
   z-index: 90;
   background: #efefef;
   margin-bottom: 0px;
   }
   .size-data-ul label:hover {
   background: #DDD;
   }
</style>
@endsection
@section('content')
<nav class="navigation--mobile-product"><a class="ps-btn ps-btn--black" href="shopping-cart.html">Add to cart</a><a
   class="ps-btn" href="checkout.html">Buy Now</a></nav>
<div class="ps-breadcrumb" id="color_data">
   <div class="ps-container" id="size_data">
      <ul class="breadcrumb">
         <li><a href="{{ url('/') }}">Home</a></li>
         <!--<li>{{ $data->primaryCategory }}</li>-->
         <li><a href="{{route('categories.sec',[$secondary->Secondarycategory->slug, $data->category->name])}}">{{ $data->category->name }}</a></li>
         <li>{{ $data->name }}</li>
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
                                 <img src="{{ product_img($pro_img) }}" alt="">
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
                           <img src="{{ product_img($image_list) }}" alt="">
                        </div>
                        @endforeach
                        @endif
                     </div>
                  </div>
                  <div class="ps-product__info">
                     <h1>{{ $data->name }}</h1>
                     <div class="ps-product__meta" id="product_id" value="{{ $data->id }}" style="margin-bottom:0">
                        @if (!empty($data->brand_id) && $data->brand->name !== 'No Brand')
                        <p>Brand: <a href="brnd">{{ @$data->brand->name }}</a></p>
                        @endif
                        <div class="ps-product__rating">
                           <select class="ps-rating" data-read-only="true">
                              <option value="1">1</option>
                              <option value="1">2</option>
                              <option value="1">3</option>
                              <option value="1">4</option>
                              <option value="2">5</option>
                           </select>
                           <span>(1 review)</span>
                        </div>
                        @php
                        $starting_price = App\Models\ProductSize::where('product_id', $data->id)->first();
                        $old_price = @$starting_price->selling_price;
                        $new_price = @$starting_price->selling_price - @$starting_price->discount;
                        @endphp
                        &nbsp;
                        <h4 class="ps-product__price">
                           NPR 
                           <price id="selling_price">
                              {{ number_format($new_price) }}
                           </price>
                           <del id="old_price">{{ number_format($old_price) }}</del>
                        </h4>
                     </div>
                     <div class="ps-product__desc single_page">
                         <!--<p>Sold By:<a href="shop-default.html"><strong> Go Pro</strong></a></p> -->
                        <div class="accordion" id="accordionExample">
                           <div id="headingOne">
                              <h5 class="mb-0">
                                 <span class="btn btn-block font-13 p-0 transparent" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                 Click to see/hide product description
                                 </span>
                              </h5>
                           </div>
                           <div id="collapseOne" class="collapse hide fade" aria-labelledby="headingOne" data-parent="#accordionExample">
                              <div class="card-body">
                                 {!! $data->specification !!}
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="ps-product__specification">
                        <a class="report" href="#">Report Abuse</a>
                        <p><strong>SKU:</strong> {{ @$data->sku }}</p>
                        <p class="categories"><strong> Categories:</strong>
                           <a
                              href="{{route('categories.sec',[$secondary->Secondarycategory->slug, $data->category->name])}}">{{ @$data->category->name }}</a>
                        </p>
                        <p></p>
                        <small class="text-danger bold">May sure you select the correct size and color before adding it to a cart.</small>
                     </div>
                     <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                           <div class="ps-product__variations">
                              <figure>
                                 <figcaption>Color</figcaption>
                                 @php
                                 $unique_product_colors = $data->colors->unique('color_id');
                                 @endphp
                                 @if (!empty($unique_product_colors))
                                 @foreach ($unique_product_colors as $key => $color_data)
                                 <div class="ps-variant ps-variant--color @if($key==0) active @endif" value="{{ $color_data->colorInfo->id }}" style="background:{{ @$color_data->colorInfo->code }}"><span
                                    class="ps-variant__tooltip">{{ $color_data->colorInfo->name }}</span>
                                 </div>
                                 @endforeach
                                 @endif
                              </figure>
                           </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                           <div class="ps-product__variations">
                              <figure>
                                 <figcaption>Size</figcaption>
                                 <div class="row">
                                    <ul class="size_data size-data-ul"></ul>
                                 </div>
                              </figure>
                           </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
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
                              <span style="color:#c5c5c5;position:relative;top:-9"><span class="unavailable text-danger bold"></span><span class="available">Only <span id="stock_available">0</span> item(s) available</span></span>
                              <button class="ps-btn ps-btn--black btn-add-cart" value="{{ $data->id }}" data-class="btn-add-cart">Add to
                              cart</button>
                              <button class="ps-btn btn-buy-now ps-btn--black" value="{{ $data->id }}" data-class="btn-buy-now">Buy Now</button>
                              <div class="ps-product__actions">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="ps-product__content ps-tab-root">
                  <ul class="ps-tab-list">
                     <li class="active"><a href="#description">Description</a></li>
                     <li><a href="#specification">Specification</a></li>
                     <!-- <li><a href="#vendor">Vendor</a></li> -->
                     <li><a href="#reviews">Reviews (1)</a></li>
                     <!-- <li><a href="#tab-5">Questions and Answers</a></li> -->
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
                     <!-- <div class="ps-tab" id="vendor">
                        <h4>GoPro</h4>
                        <p>Digiworld US, New York’s no.1 online retailer was established in May 2012 with the aim and vision to become the one-stop shop for retail in New York with implementation of best practices both online</p><a href="#">More Products from gopro</a>
                        </div> -->
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
                                    </select>
                                    <span>1 Review</span>
                                 </div>
                                 <div class="ps-block__star">
                                    <span>5 Star</span>
                                    <div class="ps-progress" data-value="100"><span></span></div>
                                    <span>100%</span>
                                 </div>
                                 <div class="ps-block__star">
                                    <span>4 Star</span>
                                    <div class="ps-progress" data-value="0"><span></span></div>
                                    <span>0</span>
                                 </div>
                                 <div class="ps-block__star">
                                    <span>3 Star</span>
                                    <div class="ps-progress" data-value="0"><span></span></div>
                                    <span>0</span>
                                 </div>
                                 <div class="ps-block__star">
                                    <span>2 Star</span>
                                    <div class="ps-progress" data-value="0"><span></span></div>
                                    <span>0</span>
                                 </div>
                                 <div class="ps-block__star">
                                    <span>1 Star</span>
                                    <div class="ps-progress" data-value="0"><span></span></div>
                                    <span>0</span>
                                 </div>
                              </div>
                           </div>
                           <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12 ">
                              <form class="ps-form--review" action="index.html" method="get">
                                 <h4>Submit Your Review</h4>
                                 <p>Your email address will not be published. Required fields are
                                    marked<sup>*</sup>
                                 </p>
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
                                    <textarea class="form-control" rows="6"
                                       placeholder="Write your review here"></textarea>
                                 </div>
                                 <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  ">
                                       <div class="form-group">
                                          <input class="form-control" type="text" placeholder="Your Name">
                                       </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  ">
                                       <div class="form-group">
                                          <input class="form-control" type="email"
                                             placeholder="Your Email">
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
                     <!-- <div class="ps-tab" id="tab-5">
                        <div class="ps-block--questions-answers">
                            <h3>Questions and Answers</h3>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Have a question? Search for answer?">
                            </div>
                        </div>
                        </div> -->
                  </div>
               </div>
            </div>
         </div>
         <div class="ps-page__right">
            <aside class="widget widget_product widget_features">
               <p><i class="icon-network"></i> Please visit out shiiping zone</p>
               <p><i class="icon-3d-rotate"></i> For return and replace, please visit our policy page.</p>
               <p><i class="icon-receipt"></i> Supplier give bills for this product.</p>
               <p><i class="icon-credit-card"></i> Pay online or when receiving goods</p>
            </aside>
            <aside class="widget widget_ads"><a href="#"><img src="/frontend/images/ads/product-ads.png" alt=""></a>
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
                     <a
                        href="{{ route('single-product', $related_products->slug) }}"><img
                        src="{{ product_img($product_image) }}" alt=""></a>
                     @if (@$starting_price->discount > 0)
                     <div class="ps-product__badge">- NPR {{ @$starting_price->discount }}</div>
                     @endif
                     <ul class="ps-product__actions">
                        <li><a class="btn-quick-view" value="{{ $related_products->id }}"
                           data-placement="top" title="Quick View" data-toggle="modal"
                           data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                        <li><a href="#" data-toggle="tooltip" data-placement="top"
                           title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                     </ul>
                  </div>
                  <div class="ps-product__container">
                     <!-- <a class="ps-product__vendor" href="#">Young Shop</a> -->
                     <div class="ps-product__content">
                        <a class="ps-product__title"
                           href="{{ route('single-product', $related_products->slug) }}">{{ $related_products->name }}</a>
                        <div class="ps-product__rating">
                           <select class="ps-rating" data-read-only="true">
                              <option value="1">1</option>
                              <option value="1">2</option>
                              <option value="1">3</option>
                              <option value="1">4</option>
                              <option value="2">5</option>
                           </select>
                        </div>
                        <p class="ps-product__price sale">NPR {{ number_format(@$new_price) }}
                           @if (@$starting_price->discount > 0)
                           <del>-NPR {{ number_format($old_price) }} </del>
                           @endif
                        </p>
                     </div>
                     <div class="ps-product__content hover">
                        <a class="ps-product__title"
                           href="{{ route('single-product', $related_products->slug) }}">{{ $related_products->name }}</a>
                        <p class="ps-product__price sale">NPR {{ number_format(@$new_price) }}
                           @if (@$starting_price->discount > 0)
                           <del>-NPR {{ number_format($old_price) }} </del>
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
@endsection
@section('scripts')
<script>
   let product_id = $('#product_id').attr('value'); 
   
   $( document ).ready(function() {
       $('.ps-variant--color.active')[0].click();
       setTimeout(function(){
           $('.size_data li.active')[0].click();
       }, 1500);
   });
   $('.ps-variant--color').on('click', function() {
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
           success: function(response) {
               $('.size_data').html('');
               $.each(response, function(key, value) {
                   var li_class = '';
                   if(key == 0){
                       li_class = "active";
                   }
                   $('.size_data').append('<li class="'+li_class+'"><span></span><input type="radio" class="size_id" value="'+response[key]['id']+'" data-colorid="' + response[key]['color_id'] +'"><label for="normal-charge">'+response[key]['name']+'</label> </li>');
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
   
   var btns = $('.ps-product__variations .ps-variant--color');
   for (var i = 0; i < btns.length; i++) {
     btns[i].addEventListener("click", function() {
     var current = document.getElementsByClassName("active");
     current[0].className = current[0].className.replace(" active", "");
     this.className += " active";
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
   
</script>
@endsection
