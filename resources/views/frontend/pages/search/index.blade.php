@extends('frontend.layouts.master')
@section('content')
    <div class="ps-page--shop">
        <div class="ps-container">
           <br>
            <div class="ps-layout--shop">
                <div class="ps-layout__left">
                    <aside class="widget widget_shop">
                        <h4 class="widget-title">Categories</h4>
                        <ul class="ps-list--categories">
                            @foreach($primary_categories as $prime)
                                @foreach($prime->secondaryCategories as $secondary)
                                    <li class="current-menu-item menu-item-has-children">
                                        <a href="{{route('categories', $secondary->slug)}}">
                                            {{$secondary->name}}
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
                                                <a href="{{ route('categories.sec', [$secondary->slug,$final_cat->slug]) }}">{{$final_cat->name}}</a>
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
                        {{-- <h4 class="widget-title">BY BRANDS</h4>
                        <form class="ps-form--widget-search" action="do_action" method="get">
                            <input class="form-control" type="text" placeholder="">
                            <button><i class="icon-magnifier"></i></button>
                        </form>
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 250px;">
                            <figure class="ps-custom-scrollbar" data-height="250" style="overflow: hidden; width: auto; height: 250px;">
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-1" name="brand">
                                <label for="brand-1">Adidas (3)</label>
                                </div>
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-2" name="brand">
                                <label for="brand-2">Amcrest (1)</label>
                                </div>
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-3" name="brand">
                                <label for="brand-3">Apple (2)</label>
                                </div>
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-4" name="brand">
                                <label for="brand-4">Asus (19)</label>
                                </div>
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-5" name="brand">
                                <label for="brand-5">Baxtex (20)</label>
                                </div>
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-6" name="brand">
                                <label for="brand-6">Adidas (11)</label>
                                </div>
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-7" name="brand">
                                <label for="brand-7">Casio (9)</label>
                                </div>
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-8" name="brand">
                                <label for="brand-8">Electrolux (0)</label>
                                </div>
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-9" name="brand">
                                <label for="brand-9">Gallaxy (0)</label>
                                </div>
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-10" name="brand">
                                <label for="brand-10">Samsung (0)</label>
                                </div>
                                <div class="ps-checkbox">
                                <input class="form-control" type="checkbox" id="brand-11" name="brand">
                                <label for="brand-11">Sony (0)</label>
                                </div>
                            </figure>
                            <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 6px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 166.667px;"></div>
                            <div class="slimScrollRail" style="width: 6px; height: 100%; position: absolute; top: 0px; display: block; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                        </div> --}}

                        <figure>
                            <h4 class="widget-title">By Price</h4>
                            <div class="form-row" style="height: 35px;">
                                <div class="form-group col-md-4" style="height: 35px; margin-bottom:0;">
                                    <input type="number" value="{{$requested['min_price']>0?$requested['min_price']:''}}" min="100" class="form-control" id="minPrice" style="height: 32px;padding:2px 8px;">
                                </div>
                                <div class="form-group col-md-4" style="height: 35px; margin-bottom:0;">
                                  <input type="number" value="{{$requested['max_price']>0?$requested['max_price']:''}}" min="200" class="form-control" id="maxPrice" style="height: 32px;padding:2px 8px;">
                                </div>
                                <div class="form-group col-md-4" style="height: 35px; margin-bottom:0;">
                                    <button class="btn btn-primary" style="padding: 5px 10px;" id="byPrice">
                                        <i class="fa fa-caret-right" style="font-size: 20px"></i>
                                    </button>
                                </div>
                            </div>
                        </figure>
                        {{-- <figure>
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
                        </figure> --}}
                        {{-- <figure>
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
                            <h4 class="widget-title">BY SIZE</h4>
                            <a href="#">L</a><a href="#">M</a><a href="#">S</a><a href="#">XL</a>
                        </figure> --}}
                    </aside>
                </div>

                <div class="ps-layout__right">
                    <div class="ps-shopping ps-tab-root">
                        <div class="ps-shopping__header">
                            <p>Products under<strong> {{ ucfirst(str_replace('-', '', Request::segment(2))) }}</strong></p>
                            <div class="ps-shopping__actions">
                                <select class="ps-select" id="onSort">
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
                                    <div class="row">
                                        @if(!empty($all_products))
                                        @foreach($all_products as $product_list)
                                        @php
                                        // $product_image = $product_list->images[0]->image;
                                        $product_image = '';
                                        $starting_price = App\Models\ProductSize::where('product_id', $product_list->id)->first();
                                        @endphp
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                            <div class="ps-product">
                                                <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->slug) }}"><img src="{{ $product_image }}" alt=""></a>
                                                    <ul class="ps-product__actions">
                                                        <li><a data-placement="top" class="btn-quick-view" value="{{ $product_list->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                        <li><a data-toggle="tooltip" data-placement="bottom" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ps-product__container"><a class="ps-product__vendor" href="#">Jojayo store</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $product_list->slug) }}">{{$product_list->name}}</a>
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
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $product_list->slug) }}">{{$product_list->name}}</a>
                                                        <p class="ps-product__price">NPR {{ number_format($starting_price['selling_price']) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="ps-pagination">
                                {{$all_products->appends($_GET)->links()}}
                                </div>
                            </div>
                            <div class="ps-tab ps-category-shop" id="tab-2">
                                @if(!empty($all_products))
                                <div class="ps-shopping-product">
                                @foreach($all_products as $product_list)
                                @php
                                // $product_image = $product_list->images[0]->image;
                                $product_image = '';
                                $starting_price = App\Models\ProductSize::where('product_id', $product_list->id)->first();
                                @endphp
                                <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->slug) }}"><img src="{{ $product_image }}" alt=""></a>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $product_list->slug) }}">Men’s Sports Runnning Swim Board Shorts</a>
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
                                                <p class="ps-product__vendor">Sold by:<a href="#">Jojayo store</a></p>
                                                {!! shortContent($product_list->specification, 80) !!}...
                                            </div>
                                            <ul class="ps-product__actions">
                                                <li><a class="btn-quick-view" value="{{ $product_list->id }}" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i> </a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                                @endif
                                <div class="ps-pagination">
                                {{$all_products->appends($_GET)->links()}}
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
<script>
    var current_url='{{url()->current()}}';
    var requested_category = '{{request()->category}}';
    var requested_query = '{{request()->q}}';
    // debugger;
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
        var new_url = current_url + '?category=' + requested_category + '&q=' + requested_query+'&';
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

        return new_url += price_url + sort_url
    }
</script>
@endsection
