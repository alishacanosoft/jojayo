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
                  
                  <a class="ps-btn btn-add-cart" value="{{ $data->id }}" data-class="btn-add-cart"> Add to Cart</a></div>
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
                <div class="ps-product__info">
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
                    <p>Sold By:<a href="#"><strong> Vendor name</strong></a></p>
                    <ul class="ps-list--dot">
                        {!! $data->specification !!}
                    </ul>
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

                     <figure>
                     <figcaption>Color: <strong> Choose an option</strong></figcaption>
                     <div class="ps-variant ps-variant--image"><span class="ps-variant__tooltip">Blue</span><img src="../img/products/detail/variants/small-1.jpg" alt=""></div>
                     <div class="ps-variant ps-variant--image"><span class="ps-variant__tooltip"> Dark</span><img src="../img/products/detail/variants/small-2.jpg" alt=""></div>
                     <div class="ps-variant ps-variant--image"><span class="ps-variant__tooltip"> Pink</span><img src="../img/products/detail/variants/small-3.jpg" alt=""></div>
                     </figure>


                     <figure>
                     <figcaption>Size <strong> Choose an option</strong></figcaption>
                     <div class="ps-variant ps-variant--size"><span class="ps-variant__tooltip">S</span><span class="ps-variant__size">S</span></div>
                     <div class="ps-variant ps-variant--size"><span class="ps-variant__tooltip"> M</span><span class="ps-variant__size">M</span></div>
                     <div class="ps-variant ps-variant--size"><span class="ps-variant__tooltip"> L</span><span class="ps-variant__size">L</span></div>
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
                     <a class="facebook" href="#"><i class="fa fa-facebook"></i></a>
                     <a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                     <a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                     <a class="instagram" href="#"><i class="fa fa-instagram"></i></a>
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
              <h3>Same Brand</h3>
              <div class="widget__content">
                            <div class="ps-product">
                              <div class="ps-product__thumbnail"><a href="#"><img src="../img/products/shop/5.jpg" alt=""></a>
                                <div class="ps-product__badge">-37%</div>
                                <ul class="ps-product__actions">
                                  <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                  <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                  <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                </ul>
                              </div>
                              <div class="ps-product__container"><a class="ps-product__vendor" href="#">Robert's Store</a>
                                <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Grand Slam Indoor Of Show Jumping Novel</a>
                                  <div class="ps-product__rating">
                                                <select class="ps-rating" data-read-only="true">
                                                  <option value="1">1</option>
                                                  <option value="1">2</option>
                                                  <option value="1">3</option>
                                                  <option value="1">4</option>
                                                  <option value="2">5</option>
                                                </select><span>01</span>
                                  </div>
                                  <p class="ps-product__price sale">$32.99 <del>$41.00 </del></p>
                                </div>
                                <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Grand Slam Indoor Of Show Jumping Novel</a>
                                  <p class="ps-product__price sale">$32.99 <del>$41.00 </del></p>
                                </div>
                              </div>
                            </div>
                            <div class="ps-product">
                              <div class="ps-product__thumbnail"><a href="#"><img src="../img/products/shop/6.jpg" alt=""></a>
                                <div class="ps-product__badge">-5%</div>
                                <ul class="ps-product__actions">
                                  <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                  <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                  <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                </ul>
                              </div>
                              <div class="ps-product__container"><a class="ps-product__vendor" href="#">Youngshop</a>
                                <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Sound Intone I65 Earphone White Version</a>
                                  <div class="ps-product__rating">
                                                <select class="ps-rating" data-read-only="true">
                                                  <option value="1">1</option>
                                                  <option value="1">2</option>
                                                  <option value="1">3</option>
                                                  <option value="1">4</option>
                                                  <option value="2">5</option>
                                                </select><span>01</span>
                                  </div>
                                  <p class="ps-product__price sale">$100.99 <del>$106.00 </del></p>
                                </div>
                                <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Sound Intone I65 Earphone White Version</a>
                                  <p class="ps-product__price sale">$100.99 <del>$106.00 </del></p>
                                </div>
                              </div>
                            </div>
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
                     <a class="ps-product__vendor" href="#">Vendor Shop</a>
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