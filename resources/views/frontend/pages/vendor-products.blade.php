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
                    <h4>Digitalworld us</h4>
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
                    <p><strong>Digiworld US</strong>, New York’s no.1 online retailer was established in May 2012 with the aim and vision to become the one-stop shop for retail in New York with implementation of best practices both online</p><span class="ps-block__divider"></span>
                    </figure>
                  </div>
                
                </div>
              </div>
            </div>
            <div class="ps-section__right">
              <div class="ps-block--vendor-filter">
                <div class="ps-block__left">
                  <ul>
                    <li class="active">Products of <strong>{{ ucwords(str_replace('-', ' ', Request::segment(2))) }}</strong> </a></li>
                
                  </ul>
                </div>
                <div class="ps-block__right">
                  <form class="ps-form--search" action="#" method="get">
                    <input class="form-control" type="text" placeholder="Search in this shop">
                    <button><i class="fa fa-search"></i></button>
                  </form>
                </div>
              </div>
              <div class="ps-vendor-best-seller">
                <div class="ps-section__header">
                  <h3>Best Seller items</h3>
                  <div class="ps-section__nav"><a class="ps-carousel__prev" href="#vendor-bestseller"><i class="icon-chevron-left"></i></a><a class="ps-carousel__next" href="#vendor-bestseller"><i class="icon-chevron-right"></i></a></div>
                </div>
                <div class="ps-section__content">
                  <div class="owl-slider" id="vendor-bestseller" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="2" data-owl-item-sm="3" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on">
                   
                    <div class="ps-product">
                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="../img/products/technology/1.jpg" alt=""></a>
                        <div class="ps-product__badge">11%</div>
                        <ul class="ps-product__actions">
                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                            <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                        </ul>
                        </div>
                        <div class="ps-product__container"><a class="ps-product__vendor" href="#"></a>
                        <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple iPhone X 256GB T-Mobile – Black</a>
                            <div class="ps-product__rating">
                                        <select class="ps-rating" data-read-only="true">
                                            <option value="1">1</option>
                                            <option value="1">2</option>
                                            <option value="1">3</option>
                                            <option value="1">4</option>
                                            <option value="2">5</option>
                                        </select><span>01</span>
                            </div>
                            <p class="ps-product__price sale">$1389.99 <del>$1893.00</del></p>
                        </div>
                        <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Apple iPhone X 256GB T-Mobile – Black</a>
                            <p class="ps-product__price sale">$1389.99 <del>$1893.00</del></p>
                        </div>
                        </div>
                    </div>
                           
                  </div>
                </div>
              </div>
              <div class="ps-shopping ps-tab-root">
                <div class="ps-shopping__header">
                  <p><strong> 36</strong> Products Found</p>
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
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6 ">
                                    <div class="ps-product">
                                        <div class="ps-product__thumbnail"><a href="product-default.html"><img src="../img/products/technology/1.jpg" alt=""></a>
                                        <div class="ps-product__badge">11%</div>
                                        <ul class="ps-product__actions">
                                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                            <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                            <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                        </ul>
                                        </div>
                                        <div class="ps-product__container"><a class="ps-product__vendor" href="#"></a>
                                        <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple iPhone X 256GB T-Mobile – Black</a>
                                            <div class="ps-product__rating">
                                                        <select class="ps-rating" data-read-only="true">
                                                            <option value="1">1</option>
                                                            <option value="1">2</option>
                                                            <option value="1">3</option>
                                                            <option value="1">4</option>
                                                            <option value="2">5</option>
                                                        </select><span>01</span>
                                            </div>
                                            <p class="ps-product__price sale">$1389.99 <del>$1893.00</del></p>
                                        </div>
                                        <div class="ps-product__content hover"><a class="ps-product__title" href="product-default.html">Apple iPhone X 256GB T-Mobile – Black</a>
                                            <p class="ps-product__price sale">$1389.99 <del>$1893.00</del></p>
                                        </div>
                                        </div>
                                    </div>
                        </div>
                    </div>
                    <div class="ps-pagination">
                        
                    </div>
                  </div>
                  <div class="ps-tab" id="tab-2">
                        <div class="ps-product ps-product--wide">
                            <div class="ps-product__thumbnail"><a href="product-default.html"><img src="../img/products/technology/1.jpg" alt=""></a>
                            <div class="ps-product__badge">11%</div>
                            </div>
                            <div class="ps-product__container">
                            <div class="ps-product__content"><a class="ps-product__title" href="product-default.html">Apple iPhone X 256GB T-Mobile – Black</a>
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
                                <li> Unrestrained and portable active stereo speaker</li>
                                <li> Free from the confines of wires and chords</li>
                                <li> 20 hours of portable capabilities</li>
                                <li> Double-ended Coil Cord with 3.5mm Stereo Plugs Included</li>
                                <li> 3/4″ Dome Tweeters: 2X and 4″ Woofer: 1X</li>
                                </ul>
                            </div>
                            <div class="ps-product__shopping">
                                <p class="ps-product__price sale">$1389.99 <del>$1893.00</del></p><a class="ps-btn" href="#">Add to cart</a>
                                <ul class="ps-product__actions">
                                <li><a href="#"><i class="icon-heart"></i> Wishlist</a></li>
                                <li><a href="#" data-placement="top" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i>View</a></li>

                                </ul>
                            </div>
                            </div>
                        </div>
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