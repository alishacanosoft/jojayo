@extends('frontend.layouts.master')
@section('styles')
<style>
    .font-17{
        font-size: 17px;
    }
</style>
@endsection
@section('content')
<div class="ps-page--simple">
            @include('frontend.layouts.front-nav')
            @include('frontend.layouts.customer-nav')
            <div class="col-lg-8">
                <div class="ps-section__right">
                @if(session()->has('success'))
                {{frontSuccess()}}
                @elseif(session()->has('warning'))
                    {{frontWarning()}}
                @elseif(session()->has('error'))
                    {{frontError()}}
                @endif                  
                    <h3>Wishlist</h3>
                          
                    <div class="table-responsive">
                    <table class="table ps-table--whishlist">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($my_wish))
                            @foreach($my_wish as $list)
                            @php
                            $starting_price = App\Models\ProductSize::where('product_id', $list->product_id)->first();
                            $old_price = @$starting_price->selling_price;
                            $new_price = @$starting_price->selling_price - @$starting_price->discount;
                            $my_data = App\Models\ProductImages::with('images')->where('product_id', $list->product_id)->where('color_id', $list->color_id)->first();
                            $status = "Out of Stock";
                            if($starting_price['stock'] > 0){
                                $status = "In Stock";
                            }
                            @endphp
                            <tr>
                                <td>
                                    <a class="pull-left" onclick="return confirm('Remove this product from wishlist?')">
                                       <form method="POST" action="{{ route('wish.remove', $list->id) }}" accept-charset="UTF-8">
                                          <input name="_method" type="hidden" value="DELETE">
                                          <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                          <button class="btn font-17" type="submit"><i class="icon-cross"></i></button>
                                       </form>
                                    </a>
                                </td>
                                <td>
                                <div class="ps-product--cart">
                                    <div class="ps-product__thumbnail"><a href="{{ route('single-product', $list->product->slug) }}"><img src="{{ product_img($my_data['images'][0]['image']) }}" alt=""></a></div>
                                    <div class="ps-product__content"><a href="{{ route('single-product', $list->product->slug) }}">{{ $list->product->name }}</a></div>
                                </div>
                                </td>
                                <td class="price">NPR {{ number_format($new_price) }}</td>
                                <td><span class="ps-tag ps-tag--in-stock">{{ $status }}</span></td>
                                <td>
                                    <a class="pull-left">
                                       <form method="POST" action="{{ route('cart.store') }}" accept-charset="UTF-8">
                                          <input type="hidden" name="id" value="{{ $list->product_id }}">
                                          <input type="hidden" name="color_id" value="{{ $list->color_id }}">
                                          <input type="hidden" name="size_id" value="{{ $list->size_id }}">
                                          <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                          <button class="btn font-17" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add To Cart" type="submit"><i class="icon-bag2"></i></button>
                                       </form>
                                    </a>
                                </td> 
                            </tr>
                            @endforeach
                            @endif                      
                        </tbody>
                    </table>
                    </div>
  

                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection