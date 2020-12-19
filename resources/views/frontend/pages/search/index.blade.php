@extends('frontend.layouts.master')
@section('content')
    <div class="ps-page--shop">
        <br/>
        <div class="ps-container">
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
                  
                </div>

                <div class="ps-layout__right">
                    <div class="ps-shopping ps-tab-root">
                        <div class="ps-shopping__header">
                            <p><strong>{{$all_products->count()}}</strong> Products Under: <strong> {{$catg}}</strong></p>
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
                                    <div class="row">
                                        @if(!empty($all_products))
                                        @foreach($all_products as $product_list)
                                        @php
                                        // $product_image = $product_list->images[0]->image;
                                        $product_image = '';
                                        $product_image = (count($product_list->images)>0)?product_img($product_list->images[0]['images'][0]['image']):'';

                                        $starting_price = App\Models\ProductSize::where('product_id', $product_list->id)->first();
                                        @endphp
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                        <div class="ps-product">
                                                <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->slug) }}"><img src="{{ $product_image }}" alt=""></a>
                                                    <ul class="ps-product__actions">
                                                        <li><a data-placement="top" class="btn-quick-view" value="{{ $product_list->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                                        <li><a href="#" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                                        <li><a data-toggle="tooltip" data-placement="bottom" title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="ps-product__container"><a class="ps-product__vendor" href="#">Jojayo store</a>
                                                    <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $product_list->slug) }}">{{ ucwords($product_list->name) }}</a>
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
                                                    <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('single-product', $product_list->slug) }}">{{ ucwords($product_list->name) }}</a>
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
                                $product_image = (count($product_list->images)>0)?product_img($product_list->images[0]['images'][0]['image']):'';

                                $starting_price = App\Models\ProductSize::where('product_id', $product_list->id)->first();
                                @endphp
                                    <div class="ps-product ps-product--wide">
                                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->slug) }}"><img src="{{ $product_image }}" alt=""></a>
                                        </div>
                                        <div class="ps-product__container">
                                            <div class="ps-product__content"><a class="ps-product__title" href="{{ route('single-product', $product_list->slug) }}">{{ ucwords($product_list->name) }}</a>
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
                                                    {!! shortContent($product_list->specification, 10) !!} <?php if($product_list->specification) echo"..." ?>
                                                    </ul>   
                                               
                                            </div>
                                           

                                            <div class="ps-product__shopping">
                                                <p class="ps-product__price"> NPR {{ number_format($starting_price['selling_price']) }}</p>
                                                <a class="ps-btn" href="#">Add to cart</a>
                                                <ul class="ps-product__actions">
                                                <li><a href="#"><i class="icon-heart"></i>Wishlist</a></li>
                                                <li><a class="btn-quick-view" value="{{ $product_list->id }}" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i>View</a></li>

                                                </ul>
                                            </div>
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

    <div class="related-products"></div>

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
