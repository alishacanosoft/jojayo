@extends('frontend.layouts.master')
@section('content')
    <div class="ps-page--shop">
        <div class="ps-container">
           <br>
            <div class="ps-layout--shop">
                <div class="ps-layout__left">
                     @include('frontend.pages.filters.categories',['cat_slug'=>$category_slug,'cat'=>$categories])
                    <aside class="widget widget_shop">
                        @include('frontend.pages.filters.brands')

                        <figure>
                        <h4 class="widget-title">By Price</h4>
                            <div class="form-row" style="height: 35px;">
                                <div class="form-group col-md-4" style="height: 35px; margin-bottom:0;">
                                    <input type="number" value="{{$requested['min_price']>0?$requested['min_price']:''}}" min="100" class="form-control" placeholder="150" id="minPrice" style="height: 32px;padding:2px 8px;">
                                </div>
                                <div class="form-group col-md-4" style="height: 35px; margin-bottom:0;">
                                    <input type="number" value="{{$requested['max_price']>0?$requested['max_price']:''}}" min="200" class="form-control" placeholder="250" id="maxPrice" style="height: 32px;padding:2px 8px;">
                                </div>
                                <div class="form-group col-md-4" style="height: 35px; margin-bottom:0;">
                                    <button class="btn btn-primary" style="padding: 5px 10px;" id="byPrice">
                                        <i class="fa fa-caret-right" style="font-size: 20px"></i>
                                    </button>
                                </div>
                            </div>`
                        </figure>

                        <figure>
                            <h4 class="widget-title">By Rating</h4>
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
            
                       <figure class="sizes">
                            <h4 class="widget-title">BY SIZE</h4>
                            @foreach ($sizes as $size)
                                <div class="ps-checkbox ps-checkbox--color ps-checkbox--inline size-product">
                                    <input class="form-control" type="checkbox" id="{{$size->slug}}" value="{{$size->slug}}" name="sizes" onclick="bySize()"  {{in_array($size->id,$requested['selected_sizes'])?'checked':''}}>
                                    <label for="{{$size->slug}}" style="text-align: center">{{ucfirst($size->name)}}</label>
                                </div>
                            @endforeach
                        </figure>

                        
                    </aside>
                </div>

                <div class="ps-layout__right">
                    <div class="ps-shopping ps-tab-root">
                        <div class="ps-shopping__header">
                            <p><strong>{{$allcount}}</strong> Products Under: <strong> {{ ucfirst(str_replace('-', '', Request::segment(2))) }}</strong></p>
                            <div class="ps-shopping__actions">
                                <select class="ps-select" id="onSort">
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
                                <div class="ps-shopping-product">
                                    <div class="row" id="product-data">
                                        @if(!empty($category_product))
                                        @foreach($category_product as $all_products)
                                        @php
                                        // $product_image = (isset($all_products->images)&&count($all_products->images)>0)?$all_products->images[0]->image:'';
                                        $starting_price = App\Models\ProductSize::where('product_id', $all_products->id)->first();
                                        $product_image = (count($all_products->images)>0)?product_img($all_products->images[0]['images'][0]['image']):'';
                                        @endphp
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                            <div class="ps-product">
                                                <div class="ps-product__thumbnail"><a href="{{ route('single-product', $all_products->slug) }}"><img src="{{ $product_image }}" alt=""></a>
                                                    <ul class="ps-product__actions">
                                                        <li><a data-placement="top" class="btn-quick-view" value="{{ $all_products->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                        <li><a data-toggle="tooltip" data-placement="bottom" title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ps-product__container"><a class="ps-product__vendor" href="#">Jojayo store</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $all_products->slug) }}">{{ ucwords($all_products->name) }}</a>
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
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $all_products->slug) }}">{{ ucwords($all_products->name) }}</a>
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
                            <div class="ps-tab ps-category-shop" id="tab-2">
                                @if(!empty($category_product))
                                <div class="ps-shopping-product" id="list-product-data">
                                @foreach($category_product as $all_products)
                                @php
                                // $product_image = (isset($all_products->images)&&count($all_products->images)>0)?$all_products->images[0]->image:'';
                                $starting_price = App\Models\ProductSize::where('product_id', $all_products->id)->first();
                                $product_image = (count($all_products->images)>0)?product_img($all_products->images[0]['images'][0]['image']):'';
                                @endphp
                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $all_products->slug) }}"><img src="{{ $product_image }}" alt=""></a>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $all_products->slug) }}">{{ ucwords($all_products->name) }}</a>
                                                <div class="ps-product__rating">
                                                    <select class="ps-rating" data-read-only="true">
                                                        <option value="1">1</option>
                                                        <option value="1">2</option>
                                                        <option value="1">3</option>
                                                        <option value="1">4</option>
                                                        <option value="2">5</option>
                                                    </select>
                                                    NPR {{ number_format($starting_price['selling_price']) }}
                                                </div>
                                                    <div class="ps-product__vendor"><strong>Sold by: </strong><a href="#">Vendor STORE</a></div>
                                                    <ul class="ps-product__desc">
                                                    {!! shortContent($all_products->specification, 10) !!} <?php if($all_products->specification) echo"..." ?>
                                                    </ul>   
                                               
                                            </div>
                                           

                                            <div class="ps-product__shopping">
                                                <p class="ps-product__price"> NPR {{ number_format($starting_price['selling_price']) }}</p>
                                                <a class="ps-btn" href="#">Add to cart</a>
                                                <ul class="ps-product__actions">
                                                <li><a href="#"><i class="icon-heart"></i>Wishlist</a></li>
                                                <li><a class="btn-quick-view" value="{{ $all_products->id }}" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i>View</a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="shop-filter-lastest" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="list-group">
                                <a class="list-group-item list-group-item-action" href="#">Sort by</a><a class="list-group-item list-group-item-action" href="#">Sort by average rating</a><a class="list-group-item list-group-item-action" href="#">Sort by latest</a><a class="list-group-item list-group-item-action" href="#">Sort by price: low to high</a><a class="list-group-item list-group-item-action" href="#">Sort by price: high to low</a><a class="list-group-item list-group-item-action text-center" href="#" data-dismiss="modal"><strong>Close</strong></a></div>
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
    var favorite=[];
    var brands='';
     var sort = '{{$requested["sort"]}}';
    var minPrice = '';
    var maxPrice = '';
    var sizes = [];

    function selectBrands(){
        setBrands();
        window.location.replace(getUrl());
    }

    function bySize(){
        setSizes();
        window.location.replace(getUrl());
    }

    function setBrands(){
        brands=[];
        $.each($("input[name='brands']:checked"), function(){
            brands.push($(this).val());
        });
    }

    function setSizes(){
        sizes=[];
        $.each($("input[name='sizes']:checked"), function(){
            sizes.push($(this).val());
        });
    }

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
        var new_url = current_url
        var brand_url = '';
        var price_url = '';
        var size_url = '';
        var sort_url = '';

        minPrice = $('#minPrice').val();
        maxPrice = $('#maxPrice').val();

        setSizes();
        setBrands();

        if(brands.length>0){
            $.each(brands,function(index,value){
               brand_url+='brands['+index+']='+value+'&'
            })
        }

        if(sizes.length>0){
            $.each(sizes,function(index,value){
               size_url+='sizes['+index+']='+value+'&';
            })
        }

        if(minPrice>0&&maxPrice>0){
            price_url = 'price='+minPrice+'-'+maxPrice+'&';
        }

        if(sort.length>0){
            sort_url = 'sort=' + sort + '&';
        }

        return new_url+='?'+brand_url + price_url + size_url + sort_url
    }
</script>
@endsection
