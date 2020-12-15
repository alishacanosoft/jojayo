<div class="product-single-container product-single-default product-quick-view container">
    <div class="row">
        <div class="col-lg-6 col-md-6 product-single-gallery">
            <div class="product-slider-container product-item">
                <div class="product-single-carousel owl-carousel owl-theme">
                    @if(!empty($data->images))
                    @foreach($data->images as $product_images)
                    <div class="product-item">
                        <img class="product-single-image" src="{{ $product_images->image }}" data-zoom-image="{{ $product_images->image }}"/>
                    </div>
                    @endforeach
                    @endif
                </div>
                <!-- End .product-single-carousel -->
            </div>
            <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                @if(!empty($data->images))
                @foreach($data->images as $product_images)
                <div class="col-3 owl-dot">
                    <img src="{{ $product_images->image }}"/>
                </div>
                @endforeach
                @endif
            </div>
        </div><!-- End .col-lg-7 -->

        <div class="col-lg-6 col-md-6">
            <div class="product-single-details">
                <h1 class="product-title">{{ $data->name }}</h1>

                <div class="ratings-container">
                    <div class="product-ratings">
                        <span class="ratings" style="width:60%"></span><!-- End .ratings -->
                    </div><!-- End .product-ratings -->

                    <a href="#" class="rating-link">( 6 Reviews )</a>
                </div><!-- End .product-container -->

                <div class="price-box">
                    <!-- <span class="old-price">$81.00</span> -->
                    <span class="product-price">@if(!empty($data->sizes[0])) $ {{ number_format($data->sizes[0]->selling_price) }} @endif</span>
                </div><!-- End .price-box -->

                <div class="product-desc">
                    <p>{!! shortContent($data->description, 30) !!}...</p>
                </div><!-- End .product-desc -->

                <div class="product-filters-container">
                    <div class="product-single-filter">
                        <label>Available Colors:</label>
                        <ul class="config-swatch-list">
                            @if(!empty($colors))
                            @foreach($colors as $product_colors)
                            <li>
                                <a style="background-color: {{ $product_colors->colors->name }};"></a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="product-action">
                    <div class="product-single-qty">
                        <input class="horizontal-quantity form-control" type="text">
                    </div><!-- End .product-single-qty -->

                    <a href="https://www.portotheme.com/html/porto_ecommerce/demo_4/ajax/cart.html" class="paction add-cart" title="Add to Cart">
                        <span>Add to Cart</span>
                    </a>
                    <a href="#" class="paction add-wishlist" title="Add to Wishlist">
                        <span>Add to Wishlist</span>
                    </a>
                </div>

                <div class="product-single-share">
                    <label>Share:</label>
                    <div class="addthis_inline_share_toolbox"></div>
                </div>
            </div>
        </div>
    </div>
</div>
