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
          @if(!empty($shop_slider))
          @foreach($shop_slider as $slider_list)
          <a href="{{ url($slider_list->url) }}"><img src="{{ asset('/uploads/slider/'.$slider_list->image) }}" alt="{{ $slider_list->name }}"></a>
          @endforeach
          @endif          
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
          <div class="ps-layout__left" >
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
                </div>
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
                <a href="#">L</a>
                <a href="#">M</a>
                <a href="#">S</a>
                <a href="#">XL</a>
              </figure>
            </aside>
          </div>
                
          <div class="ps-layout__right">    
            <div class="ps-shopping ps-tab-root">
               <div class="ps-shopping__header">
                  <p><strong> {{$allcount}}</strong> Products found</p>
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
                     <div class="ps-shopping-product">
                        <div class="row" id="product-data">
                           @if(!empty($all_products))
                           @foreach($all_products as $key => $product_list)
                           @php
                           // $product_image = (isset($product_list->images)&&count($product_list->images)>0)?$product_list->images[0]->image:'';
                           $starting_price = App\Models\ProductSize::where('product_id', $product_list->id)->first();
                           $product_image = (count($product_list->images)>0)?product_img($product_list->images[0]['images'][0]['image']):'';
                           @endphp                         
                           <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-6 ">
                              <div class="ps-product">
                                 <div class="ps-product__thumbnail">
                                    <a href="{{ route('single-product', $product_list->slug) }}"><img src="{{ $product_image ? $product_image : asset('/images/noimage.png')}}" alt="{{$product_list->slug}}"></a>
                                    <ul class="ps-product__actions">
                                       <li><a href="{{ route('single-product', $product_list->slug) }}" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-bag2"></i></a></li>
                                       <li><a data-placement="top" class="btn-quick-view" value="{{ $product_list->id }}" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li>
                                       <li><a href="{{ route('single-product', $product_list->slug) }}" data-toggle="tooltip" data-placement="bottom" title="Add to Whishlist"><i class="icon-heart"></i></a></li>
                                    </ul>
                                 </div>
                                 <?php 
                                    $rout = App\Models\SecondaryCategory::find($product_list->productCategory->secondary_category_id)->select('slug')->get();
                                    //    print_r(isset($rout[$key]) ? $rout[$key]->slug : '');
                                    
                                    ?>
                                 <div class="ps-product__container">
                                    <a class="ps-product__vendor" href="{{ route('vendor.store', $product_list->VendorName->vendor_slug) }}">{{ $product_list->VendorName->company }}</a>
                                    <div class="ps-product__content">
                                       <a class="ps-product__title" href="{{ route('single-product', $product_list->slug) }}">{{ $product_list->name }}</a>
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
                                    <div class="ps-product__content hover">
                                       <a class="ps-product__title" href="{{ route('single-product', $product_list->slug) }}">{{ $product_list->name }}</a>
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
                  <div class="ps-tab" id="tab-2">
                     @if(!empty($all_products))
                     <div class="ps-shopping-product" id="list-product-data">
                        @foreach($all_products as $key => $product_list)
                        @php
                        $starting_price = App\Models\ProductSize::where('product_id', $product_list->id)->first();
                        $product_image = (count($product_list->images)>0)?product_img($product_list->images[0]['images'][0]['image']):'';
                        @endphp
                        <div class="ps-product ps-product--wide">
                           <div class="ps-product__thumbnail"><a href="{{ route('single-product', $product_list->slug) }}"><img src="{{ $product_image ? $product_image : asset('/images/noimage.png')}}" alt="{{$product_list->slug}}"></a>
                           </div>
                           <div class="ps-product__container">
                              <?php 
                                 $rout = App\Models\SecondaryCategory::find($product_list->productCategory->secondary_category_id)->select('slug')->get();
                                 //    print_r(isset($rout[$key]) ? $rout[$key]->slug : '');
                                 
                                 ?>
                              <div class="ps-product__content">
                                 <a class="ps-product__title" href="{{ route('single-product', $product_list->slug) }}">{{ $product_list->name }}</a>
                                 <div class="ps-product__vendor"><strong>Sold by: </strong><a href="{{ route('vendor.store', $product_list->VendorName->vendor_slug) }}">{{ $product_list->VendorName->company }}</a></div>
                                 <div class="ps-product__vendor"><strong>Category: </strong><a href="{{ route('categories.sec',[isset($rout[$key]) ? $rout[$key]->slug : '',$product_list->productCategory->slug]) }}">{{ $product_list->productCategory->name }}</a></div>
                                 <ul class="ps-product__desc">
                                    {!! shortContent($product_list->specification, 10) !!} <?php if($product_list->specification) echo"..." ?>
                                 </ul>
                              </div>
                              <div class="ps-product__shopping">
                                 <p class="ps-product__price"> NPR {{ number_format($starting_price['selling_price']) }}</p>
                                 <a class="ps-btn" href="{{ route('single-product', $product_list->slug) }}">Add to cart</a>
                                 <ul class="ps-product__actions">
                                    <li><a href="{{ route('single-product', $product_list->slug) }}"><i class="icon-heart"></i>Wishlist</a></li>
                                    <li><a class="btn-quick-view" value="{{ $product_list->id }}" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i>View</a></li>
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
                  <div class="list-group"><a class="list-group-item list-group-item-action" href="#">Sort by</a><a class="list-group-item list-group-item-action" href="#">Sort by average rating</a><a class="list-group-item list-group-item-action" href="#">Sort by latest</a><a class="list-group-item list-group-item-action" href="#">Sort by price: low to high</a><a class="list-group-item list-group-item-action" href="#">Sort by price: high to low</a><a class="list-group-item list-group-item-action text-center" href="#" data-dismiss="modal"><strong>Close</strong></a></div>
               </div>
            </div>
         </div>
      </div>

@endsection


@section('scripts')
@include('frontend.layouts.load-more')

<script>  
    
    $('#chkfilter').on('keyup', function() {
    var query = this.value;

        $('[name^="brands"]').each(function(i, elem) {
            if (elem.value.indexOf(query) != -1) {
                elem.style.display = 'block';

                if(this.style.display === 'block'){ 
                    var mainid = this.id
                    var aa =$('#'+mainid).attr("myname");
                    if(this.id===aa){
                        $('.'+aa).show();
                    }
                }
                
            }else{
                elem.style.display = 'none';
                if(this.style.display === 'none'){ 
                    var mainid = this.id
                    var aa =$('#'+mainid).attr("myname");
                    if(this.id===aa){
                        $('.'+aa).hide();
                    }

                }

            }
        });
    });
    </script>
<script>
   var current_url='{{url()->current()}}';
   // var favorite = [];
   var brands = '';
   var sort = '{{$requested["sort"]}}';
   var minPrice = '';
   var maxPrice = '';
   // var sizes = [];
   
   function selectBrands(){
      setBrands();
       window.location.replace(getUrl());
   }
   
   // function bySize(){
   //     setSizes();
   //     window.location.replace(getUrl());
   // }
   
   function setBrands(){
       brands=[];
       $.each($("input[name='brands']:checked"), function(){
           brands.push($(this).val());
       });
   }
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
       var brand_url='';
       var price_url='';
       // var size_url='';
       var sort_url='';
   
       minPrice = $('#minPrice').val();
       maxPrice = $('#maxPrice').val();
   
       // setSizes();
       setBrands();
   
       if(brands.length>0){
           $.each(brands,function(index,value){
              brand_url+='brands['+index+']='+value+'&';
           })
       }
   
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
