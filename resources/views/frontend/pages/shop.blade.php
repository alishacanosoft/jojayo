@extends('frontend.layouts.master')
@section('content')
   
<div class="ps-breadcrumb">
    <div class="ps-container">
    <ul class="breadcrumb">
        <li><a href="{{url('/')}}">Home</a></li>
        <li>Shop</li>
    </ul>
    </div>
</div>
<div class="ps-page--shop">
      <div class="ps-container">
        <div class="ps-shop-banner">
          <div class="ps-carousel--nav-inside owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">
          <a href="#"><img src="img/slider/shop-default/1.jpg" alt=""></a>
          <a href="#"><img src="img/slider/shop-default/2.jpg" alt=""></a>
          </div>
        </div>
        
        <div class="ps-shop-brand">
            <div class="ps-carousel--nav owl-slider owl-slider-brand" data-owl-auto="false" data-owl-loop="false" data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="7" data-owl-item-xs="2" data-owl-item-sm="3" data-owl-item-md="4" data-owl-item-lg="5" data-owl-item-xl="6" data-owl-duration="1000" data-owl-mousedrag="on">
                @foreach($brands as $brand)
                    <a href="#"><img src="{{asset('/uploads/brands/'.$brand->logo)}}" alt="{{$brand->slug}}">
                    </a>
                @endforeach  
            </div>
        </div>
      
        <div class="ps-layout--shop">
          <div class="ps-layout__left">
            <aside class="widget widget_shop">
              <h4 class="widget-title">Categories</h4>
                <ul class="ps-list--categories">
                    @foreach($primary_categories as $prime)
                        @foreach($prime->secondaryCategories as $secondary)
                            <li class="current-menu-item menu-item-has-children">
                                <a href="{{route('categories', $secondary->slug)}}">
                                    {{ucwords($secondary->name)}}
                                </a>
                                @if($secondary->FinalCategory->count() > 0)
                                <?php
                                    $secondary->name = str_replace("Women's", "", $secondary->name);
                                    $secondary->name = str_replace("Men's", "", $secondary->name);
                                ?>
                                <span class="sub-toggle"><i class="fa fa-angle-down"></i></span>
                                <ul class="sub-menu">
                                    @foreach($secondary->FinalCategory as $final_cat)
                                    <?php
                                        $final_cat->name = str_replace("Women's", "", $final_cat->name);
                                        $final_cat->name = str_replace("Men's", "", $final_cat->name);
                                    ?>
                                    <li class="current-menu-item ">
                                        <a href="{{ route('categories.sec', [$secondary->slug,$final_cat->slug]) }}">{{ucwords($final_cat->name)}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            </aside>
            <aside class="widget widget_shop">
            @include('frontend.pages.filters.brands')
              
              <figure>
                <h4 class="widget-title">By Price</h4>
                <div id="nonlinear"></div>
                <p class="ps-slider__meta">Price:<span class="ps-slider__value">$<span class="ps-slider__min"></span></span>-<span class="ps-slider__value">$<span class="ps-slider__max"></span></span></p>
              </figure>
              <figure>
                <h4 class="widget-title">By Price</h4>
                <div class="ps-checkbox">
                  <input class="form-control" type="checkbox" id="review-1" name="review">
                  <label for="review-1"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i></span><small>(13)</small></label>
                </div>
                <div class="ps-checkbox">
                  <input class="form-control" type="checkbox" id="review-2" name="review">
                  <label for="review-2"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i></span><small>(13)</small></label>
                </div>
                <div class="ps-checkbox">
                  <input class="form-control" type="checkbox" id="review-3" name="review">
                  <label for="review-3"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>(5)</small></label>
                </div>
                <div class="ps-checkbox">
                  <input class="form-control" type="checkbox" id="review-4" name="review">
                  <label for="review-4"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>(5)</small></label>
                </div>
                <div class="ps-checkbox">
                  <input class="form-control" type="checkbox" id="review-5" name="review">
                  <label for="review-5"><span><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>(1)</small></label>
                </div>
              </figure>
              <figure>
                <h4 class="widget-title">By Color</h4>
                            <div class="ps-checkbox ps-checkbox--color color-1 ps-checkbox--inline">
                              <input class="form-control" type="checkbox" id="color-1" name="size">
                              <label for="color-1"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-2 ps-checkbox--inline">
                              <input class="form-control" type="checkbox" id="color-2" name="size">
                              <label for="color-2"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-3 ps-checkbox--inline">
                              <input class="form-control" type="checkbox" id="color-3" name="size">
                              <label for="color-3"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-4 ps-checkbox--inline">
                              <input class="form-control" type="checkbox" id="color-4" name="size">
                              <label for="color-4"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-5 ps-checkbox--inline">
                              <input class="form-control" type="checkbox" id="color-5" name="size">
                              <label for="color-5"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-6 ps-checkbox--inline">
                              <input class="form-control" type="checkbox" id="color-6" name="size">
                              <label for="color-6"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-7 ps-checkbox--inline">
                              <input class="form-control" type="checkbox" id="color-7" name="size">
                              <label for="color-7"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-8 ps-checkbox--inline">
                              <input class="form-control" type="checkbox" id="color-8" name="size">
                              <label for="color-8"></label>
                            </div>
              </figure>
              <figure class="sizes">
                <h4 class="widget-title">BY SIZE</h4><a href="#">L</a><a href="#">M</a><a href="#">S</a><a href="#">XL</a>
              </figure>
            </aside>
          </div>
          <div class="ps-layout__right">    
           
            <div class="ps-shopping ps-tab-root">
              <div class="ps-shopping__header">
                <p><strong> 36</strong> Products found</p>
                <div class="ps-shopping__actions">
                  <select class="ps-select" data-placeholder="Sort Items">
                    <option>Sort by latest</option>
                    <option>Sort by popularity</option>
                    <option>Sort by average rating</option>
                    <option>Sort by price: low to high</option>
                    <option>Sort by price: high to low</option>
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
                  <div class="ps-shopping-product">
                    <div class="row">
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/1.jpg" alt=""></a>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                  </div>
                                                  <div class="ps-product__container"><a class="ps-product__vendor" href="#">ROBERT’S STORE</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple iPhone Retina 6s Plus 64GB</a>
                                                      <p class="ps-product__price">$1310.00</p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Apple iPhone Retina 6s Plus 64GB</a>
                                                      <p class="ps-product__price">$1310.00</p>
                                                    </div>
                                                  </div>
                                                </div>
                                  </div>
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/1.jpg" alt=""></a>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                  </div>
                                                  <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young Shop</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple iPhone Retina 6s Plus 64GB</a>
                                                      <p class="ps-product__price">$1150.00</p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Apple iPhone Retina 6s Plus 64GB</a>
                                                      <p class="ps-product__price">$1150.00</p>
                                                    </div>
                                                  </div>
                                                </div>
                                  </div>
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/2.jpg" alt=""></a>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                  </div>
                                                  <div class="ps-product__container"><a class="ps-product__vendor" href="#">Go Pro</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Marshall Kilburn Portable Wireless Speaker</a>
                                                      <div class="ps-product__rating">
                                                                    <select class="ps-rating" data-read-only="true">
                                                                      <option value="1">1</option>
                                                                      <option value="1">2</option>
                                                                      <option value="1">3</option>
                                                                      <option value="1">4</option>
                                                                      <option value="2">5</option>
                                                                    </select><span>01</span>
                                                      </div>
                                                      <p class="ps-product__price">$42.99 - $60.00</p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Marshall Kilburn Portable Wireless Speaker</a>
                                                      <p class="ps-product__price">$42.99 - $60.00</p>
                                                    </div>
                                                  </div>
                                                </div>
                                  </div>
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/3.jpg" alt=""></a>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                  </div>
                                                  <div class="ps-product__container"><a class="ps-product__vendor" href="#">Go Pro</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Herschel Leather Duffle Bag In Brown Color</a>
                                                      <div class="ps-product__rating">
                                                                    <select class="ps-rating" data-read-only="true">
                                                                      <option value="1">1</option>
                                                                      <option value="1">2</option>
                                                                      <option value="1">3</option>
                                                                      <option value="1">4</option>
                                                                      <option value="2">5</option>
                                                                    </select><span>01</span>
                                                      </div>
                                                      <p class="ps-product__price">$125.30</p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Herschel Leather Duffle Bag In Brown Color</a>
                                                      <p class="ps-product__price">$125.30</p>
                                                    </div>
                                                  </div>
                                                </div>
                                  </div>
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/4.jpg" alt=""></a>
                                                    <div class="ps-product__badge hot">hot</div>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                  </div>
                                                  <div class="ps-product__container"><a class="ps-product__vendor" href="#">Global Office</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Xbox One Wireless Controller Black Color</a>
                                                      <div class="ps-product__rating">
                                                                    <select class="ps-rating" data-read-only="true">
                                                                      <option value="1">1</option>
                                                                      <option value="1">2</option>
                                                                      <option value="1">3</option>
                                                                      <option value="1">4</option>
                                                                      <option value="2">5</option>
                                                                    </select><span>01</span>
                                                      </div>
                                                      <p class="ps-product__price">$55.99</p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Xbox One Wireless Controller Black Color</a>
                                                      <p class="ps-product__price">$55.99</p>
                                                    </div>
                                                  </div>
                                                </div>
                                  </div>
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/5.jpg" alt=""></a>
                                                    <div class="ps-product__badge">-37%</div>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
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
                                  </div>
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/6.jpg" alt=""></a>
                                                    <div class="ps-product__badge">-5%</div>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
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
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/7.jpg" alt=""></a>
                                                    <div class="ps-product__badge">-16%</div>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                  </div>
                                                  <div class="ps-product__container"><a class="ps-product__vendor" href="#">Youngshop</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Korea Long Sofa Fabric In Blue Navy Color</a>
                                                      <div class="ps-product__rating">
                                                                    <select class="ps-rating" data-read-only="true">
                                                                      <option value="1">1</option>
                                                                      <option value="1">2</option>
                                                                      <option value="1">3</option>
                                                                      <option value="1">4</option>
                                                                      <option value="2">5</option>
                                                                    </select><span>01</span>
                                                      </div>
                                                      <p class="ps-product__price sale">$567.89 <del>$670.20 </del></p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Korea Long Sofa Fabric In Blue Navy Color</a>
                                                      <p class="ps-product__price sale">$567.89 <del>$670.20 </del></p>
                                                    </div>
                                                  </div>
                                                </div>
                                  </div>
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/8.jpg" alt=""></a>
                                                    <div class="ps-product__badge">-16%</div>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                  </div>
                                                  <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young shop</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Unero Military Classical Backpack</a>
                                                      <div class="ps-product__rating">
                                                                    <select class="ps-rating" data-read-only="true">
                                                                      <option value="1">1</option>
                                                                      <option value="1">2</option>
                                                                      <option value="1">3</option>
                                                                      <option value="1">4</option>
                                                                      <option value="2">5</option>
                                                                    </select><span>02</span>
                                                      </div>
                                                      <p class="ps-product__price sale">$35.89 <del>$42.20 </del></p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Unero Military Classical Backpack</a>
                                                      <p class="ps-product__price sale">$35.89 <del>$42.20 </del></p>
                                                    </div>
                                                  </div>
                                                </div>
                                  </div>
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/9.jpg" alt=""></a>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                  </div>
                                                  <div class="ps-product__container"><a class="ps-product__vendor" href="#">Young shop</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Rayban Rounded Sunglass Brown Color</a>
                                                      <div class="ps-product__rating">
                                                                    <select class="ps-rating" data-read-only="true">
                                                                      <option value="1">1</option>
                                                                      <option value="1">2</option>
                                                                      <option value="1">3</option>
                                                                      <option value="1">4</option>
                                                                      <option value="2">5</option>
                                                                    </select><span>02</span>
                                                      </div>
                                                      <p class="ps-product__price">$35.89</p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Rayban Rounded Sunglass Brown Color</a>
                                                      <p class="ps-product__price">$35.89</p>
                                                    </div>
                                                  </div>
                                                </div>
                                  </div>
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/10.jpg" alt=""></a>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                  </div>
                                                  <div class="ps-product__container"><a class="ps-product__vendor" href="#">Go Pro</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Sleeve Linen Blend Caro Pane Shirt</a>
                                                      <div class="ps-product__rating">
                                                                    <select class="ps-rating" data-read-only="true">
                                                                      <option value="1">1</option>
                                                                      <option value="1">2</option>
                                                                      <option value="1">3</option>
                                                                      <option value="1">4</option>
                                                                      <option value="2">5</option>
                                                                    </select><span>01</span>
                                                      </div>
                                                      <p class="ps-product__price">$29.39 - $39.99</p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Sleeve Linen Blend Caro Pane Shirt</a>
                                                      <p class="ps-product__price">$29.39 - $39.99</p>
                                                    </div>
                                                  </div>
                                                </div>
                                  </div>
                                  <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                                <div class="ps-product">
                                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/11.jpg" alt=""></a>
                                                    <ul class="ps-product__actions">
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                      <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                      <li><a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="icon-chart-bars"></i></a></li>
                                                    </ul>
                                                  </div>
                                                  <div class="ps-product__container"><a class="ps-product__vendor" href="#">Robert's Store</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Men’s Sports Runnning Swim Board Shorts</a>
                                                      <div class="ps-product__rating">
                                                                    <select class="ps-rating" data-read-only="true">
                                                                      <option value="1">1</option>
                                                                      <option value="1">2</option>
                                                                      <option value="1">3</option>
                                                                      <option value="1">4</option>
                                                                      <option value="2">5</option>
                                                                    </select><span>01</span>
                                                      </div>
                                                      <p class="ps-product__price">$13.43</p>
                                                    </div>
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Men’s Sports Runnning Swim Board Shorts</a>
                                                      <p class="ps-product__price">$13.43</p>
                                                    </div>
                                                  </div>
                                                </div>
                                  </div>
                    </div>
                  </div>
                              <div class="ps-pagination">
                                <ul class="pagination">
                                  <li class="active"><a href="#">1</a></li>
                                  <li><a href="#">2</a></li>
                                  <li><a href="#">3</a></li>
                                  <li><a href="#">Next Page<i class="icon-chevron-right"></i></a></li>
                                </ul>
                              </div>
                </div>
                <div class="ps-tab" id="tab-2">
                  <div class="ps-shopping-product">
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/1.jpg" alt=""></a>
                                  </div>
                                  <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple iPhone Retina 6s Plus 64GB</a>
                                      <p class="ps-product__vendor">Sold by:<a href="#">ROBERT’S STORE</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price">$1310.00</p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/1.jpg" alt=""></a>
                                  </div>
                                  <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple iPhone Retina 6s Plus 64GB</a>
                                      <p class="ps-product__vendor">Sold by:<a href="#">Young Shop</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price">$1150.00</p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/2.jpg" alt=""></a>
                                  </div>
                                  <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Marshall Kilburn Portable Wireless Speaker</a>
                                      <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                      <option value="1">1</option>
                                                      <option value="1">2</option>
                                                      <option value="1">3</option>
                                                      <option value="1">4</option>
                                                      <option value="2">5</option>
                                                    </select><span>01</span>
                                      </div>
                                      <p class="ps-product__vendor">Sold by:<a href="#">Go Pro</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price">$42.99 - $60.00</p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/3.jpg" alt=""></a>
                                  </div>
                                  <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Herschel Leather Duffle Bag In Brown Color</a>
                                      <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                      <option value="1">1</option>
                                                      <option value="1">2</option>
                                                      <option value="1">3</option>
                                                      <option value="1">4</option>
                                                      <option value="2">5</option>
                                                    </select><span>01</span>
                                      </div>
                                      <p class="ps-product__vendor">Sold by:<a href="#">Go Pro</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price">$125.30</p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/4.jpg" alt=""></a>
                                  </div>
                                  <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Xbox One Wireless Controller Black Color</a>
                                      <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                      <option value="1">1</option>
                                                      <option value="1">2</option>
                                                      <option value="1">3</option>
                                                      <option value="1">4</option>
                                                      <option value="2">5</option>
                                                    </select><span>01</span>
                                      </div>
                                      <p class="ps-product__vendor">Sold by:<a href="#">Global Office</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price">$55.99</p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/5.jpg" alt=""></a>
                                    <div class="ps-product__badge">-37%</div>
                                  </div>
                                  <div class="ps-product__container">
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
                                      <p class="ps-product__vendor">Sold by:<a href="#">Robert's Store</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price sale">$32.99 <del>$41.00 </del></p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/6.jpg" alt=""></a>
                                    <div class="ps-product__badge">-5%</div>
                                  </div>
                                  <div class="ps-product__container">
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
                                      <p class="ps-product__vendor">Sold by:<a href="#">Youngshop</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price sale">$100.99 <del>$106.00 </del></p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/7.jpg" alt=""></a>
                                    <div class="ps-product__badge">-16%</div>
                                  </div>
                                  <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Korea Long Sofa Fabric In Blue Navy Color</a>
                                      <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                      <option value="1">1</option>
                                                      <option value="1">2</option>
                                                      <option value="1">3</option>
                                                      <option value="1">4</option>
                                                      <option value="2">5</option>
                                                    </select><span>01</span>
                                      </div>
                                      <p class="ps-product__vendor">Sold by:<a href="#">Youngshop</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price sale">$567.89 <del>$670.20 </del></p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/8.jpg" alt=""></a>
                                    <div class="ps-product__badge">-16%</div>
                                  </div>
                                  <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Unero Military Classical Backpack</a>
                                      <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                      <option value="1">1</option>
                                                      <option value="1">2</option>
                                                      <option value="1">3</option>
                                                      <option value="1">4</option>
                                                      <option value="2">5</option>
                                                    </select><span>02</span>
                                      </div>
                                      <p class="ps-product__vendor">Sold by:<a href="#">Young shop</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price sale">$35.89 <del>$42.20 </del></p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/9.jpg" alt=""></a>
                                  </div>
                                  <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Rayban Rounded Sunglass Brown Color</a>
                                      <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                      <option value="1">1</option>
                                                      <option value="1">2</option>
                                                      <option value="1">3</option>
                                                      <option value="1">4</option>
                                                      <option value="2">5</option>
                                                    </select><span>02</span>
                                      </div>
                                      <p class="ps-product__vendor">Sold by:<a href="#">Young shop</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price">$35.89</p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/10.jpg" alt=""></a>
                                  </div>
                                  <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Sleeve Linen Blend Caro Pane Shirt</a>
                                      <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                      <option value="1">1</option>
                                                      <option value="1">2</option>
                                                      <option value="1">3</option>
                                                      <option value="1">4</option>
                                                      <option value="2">5</option>
                                                    </select><span>01</span>
                                      </div>
                                      <p class="ps-product__vendor">Sold by:<a href="#">Go Pro</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price">$29.39 - $39.99</p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                                <div class="ps-product ps-product--wide">
                                  <div class="ps-product__thumbnail"><a href="product-default.html"><img src="img/products/shop/11.jpg" alt=""></a>
                                  </div>
                                  <div class="ps-product__container">
                                    <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Men’s Sports Runnning Swim Board Shorts</a>
                                      <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                      <option value="1">1</option>
                                                      <option value="1">2</option>
                                                      <option value="1">3</option>
                                                      <option value="1">4</option>
                                                      <option value="2">5</option>
                                                    </select><span>01</span>
                                      </div>
                                      <p class="ps-product__vendor">Sold by:<a href="#">Robert's Store</a></p>
                                      <ul class="ps-product__desc">
                                        <li> Unrestrained and portable active stereo speaker</li>
                                        <li> Free from the confines of wires and chords</li>
                                        <li> 20 hours of portable capabilities</li>
                                        <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                        <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                      </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                      <p class="ps-product__price">$13.43</p><a class="ps-btn" href="#">Add to cart</a>
                                      <ul class="ps-product__actions">
                                        <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                        <li><a href="#"><i class="icon-chart-bars"></i> Compare</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>
                  </div>
                              <div class="ps-pagination">
                                <ul class="pagination">
                                  <li class="active"><a href="#">1</a></li>
                                  <li><a href="#">2</a></li>
                                  <li><a href="#">3</a></li>
                                  <li><a href="#">Next Page<i class="icon-chevron-right"></i></a></li>
                                </ul>
                              </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal" id="shop-filter-lastest" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <div class="list-group"><a class="list-group-item list-group-item-action" href="#">Sort by</a><a class="list-group-item list-group-item-action" href="#">Sort by average rating</a><a class="list-group-item list-group-item-action" href="#">Sort by latest</a><a class="list-group-item list-group-item-action" href="#">Sort by price: low to high</a><a class="list-group-item list-group-item-action" href="#">Sort by price: high to low</a><a class="list-group-item list-group-item-action text-center" href="#" data-dismiss="modal"><strong>Close</strong></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



@endsection
@section('scripts')
@include('frontend.layouts.load-more');
<script>
    var current_url='{{url()->current()}}'
    // var favorite = [];
    // var brands = '';
    var sort = '{{$requested["sort"]}}';
    var minPrice = '';
    var maxPrice = '';
    // var sizes = [];

    // function selectBrands(){
    //    setBrands();
    //     window.location.replace(getUrl());
    // }

    // function bySize(){
    //     setSizes();
    //     window.location.replace(getUrl());
    // }

    // function setBrands(){
    //     brands=[];
    //     $.each($("input[name='brands']:checked"), function(){
    //         brands.push($(this).val());
    //     });
    // }
    // function setSizes(){
    //     sizes=[];
    //     $.each($("input[name='sizes']:checked"), function(){
    //         sizes.push($(this).val());
    //     });
    // }



   $('#onSort').change(function(){
       var sortBy=$(this).val();
       sort = sortBy
       window.location.replace(getUrl());
   })

    $('#byPrice').on('click',function(){
         minPrice = $('#minPrice').val();
         maxPrice = $('#maxPrice').val();
         window.location.replace(getUrl());
    })

  
    function getUrl(){
        var new_url=current_url
        // var brand_url='';
        var price_url='';
        // var size_url='';
        var sort_url='';

        minPrice = $('#minPrice').val();
        maxPrice = $('#maxPrice').val();

        // setSizes();
        // setBrands();

        // if(brands.length>0){
        //     $.each(brands,function(index,value){
        //        brand_url+='brands['+index+']='+value+'&';
        //     })
        // }

        // if(sizes.length>0){
        //     $.each(sizes,function(index,value){
        //        size_url+='sizes['+index+']='+value+'&';
        //     })
        // }

        if(sort.length>0){
            sort_url = 'sort=' + sort + '&';
        }

        if(minPrice>0&&maxPrice>0){
            price_url = 'price='+minPrice+'-'+maxPrice+'&';
        }

        return new_url+='?' + price_url + sort_url
    }
</script>
@endsection
