@extends('frontend.layouts.master')
@section('content')
    <br>
    <div class="container-fluid">
        <div class="row">
          @if(Cart::count() == 0)
          <div class="col-lg-12">
            <div class="cart-table-container">
              <div class="row justify-content-center">
                <div class="">
                    <img src="/frontend/images/empty_product.png" style="padding-left: 20px">
                    <p><strong>Your shopping cart is empty</strong></p>
                    <a href="{{ url('/shop') }}" class="ps-btn">Go shopping</a>
                </div>
              </div><br>
            </div>
          </div>
          @endif
          <div class="col-lg-8">
              <div class="cart-table-container">
                @if(!empty(Cart::content()) && Cart::count() > 0)
                <div class="table-responsive">
                    <table class="table ps-table--shopping-cart">
                        <thead>
                          <tr>
                              <th>Product name</th>
                              <th>PRICE</th>
                              <th>QUANTITY</th>
                              <th>TOTAL</th>
                              <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach(Cart::content() as $row)
                          <tr>
                              <td>
                                <div class="ps-product--cart">
                                    <div class="ps-product__thumbnail"><a href="{{ route('single-product', $row->options->slug) }}"><img src="{{ url('/uploads/products/'.$row->options->image) }}" alt=""></a></div>
                                    <div class="ps-product__content">
                                      <a href="{{ route('single-product', $row->options->slug) }}">{{ $row->name }}</a>
                                      @php
                                      $color = App\Models\Color::where('id', $row->options->color_id)->first();
                                      $size = App\Models\Size::where('id', $row->options->size_id)->first();                                     
                                      @endphp
                                      <p>Color :<strong> {{ @$color->name }}, </strong> Size: <strong> {{ @$size->name }} </strong></p>
                                    </div>
                                </div>
                              </td>
                              <td class="price">NPR {{ number_format($row->price) }}</td>
                              <td>
                                <div class="form-group--number">
                                    <span value="{{ $row->rowId }}"></span>
                                    <button class="up">+</button>
                                    <button class="down">-</button>
                                    <input class="form-control vertical-quantity" type="text" value="{{ $row->qty }}">
                                </div>
                              </td>
                              <td>NPR {{ number_format($row->price) }}</td>
                              <td><a class="ps-product__remove" value="{{ $row->rowId }}"><i class="icon-cross"></i></a></td>
                          </tr>
                        @endforeach
                        </tbody>
                          </table>
                        </div>
                  <br>
                  <div class="row justify-content-center">
                    <div class="ps-section__cart-actions">
                      <a class="ps-btn" href="{{ url('/shop') }}"><i class="icon-arrow-left"></i> Back to Shop</a>
                      <a class="ps-btn ps-btn--outline" href="{{ route('destroyCart') }}"><i class="icon-trash"></i> Clear cart</a>
                    </div>
                  </div><br>
                                      
                @endif                      
              </div>
          </div>
          @include('frontend.layouts.summary')
        </div><br>
    </div><!-- End .container -->

    <div class="mb-6"></div>
</main>
@endsection
@section('scripts')
<script>
$('.vertical-quantity').on('change', function(){
  let quantity = $(this).val(); alert(quantity);
  let data = $(this).closest('span').attr("value");
  var url = '{{ route("update.cart", ":data") }}';
  url = url.replace(':data', data);
  alert(url);
  $.ajax({
    method: "POST",
    url: url,
    dataType: 'json',
    data: { _token:"{{ csrf_token() }}", _method:"PATCH", quantity: quantity},
    success(response){
      updateCart();
    },

    error: function(response){

        let data = response.responseJSON.errors;

        $.each( data, function( key, value ) {
            $( "<span class='validation-errors text-danger'>"+value+"</span>" ).insertAfter( "#"+key );
        });
      }
  });

})

$(document).on("click", ".product-remove", function() {
    $.ajax({
        method: "GET",
        url: "{{ route('cart.content') }}",
        dataType: 'json',
        success(callback_resonse){
            $('.cart-table-container').empty();
            let html = "";
            let side = "";
            let total = "";
            $.each(callback_resonse, function( key, value ){
                total = total+value.price;
                var data = value.options.slug;
                var url = "{{ route('single-product', ':data') }}";
                url = url.replace(':data', data);
                html += '<div class="row" style="border: 1px solid #fff;padding: 10px 5px 10px 0px; background:#eee"><div class="col-lg-2 col-md-3 col-sm-12"><a href="/uploads/products/'+value.options.image+'" target="_blank"><img src="/uploads/products/'+value.options.image+'" class="cart-image" alt=""></a></div><div class="col-lg-10 col-md-9 col-sm-12"><a href="'+url+'" class="mb-point"><strong>'+value.name+'</strong></a> <p>Zivah</p><div class="tools" style="background:#fff; padding: 4px;  margin-top: 3px"><div class="row"><div class="col-lg-3 col-md-3 col-sm-12"><span value="'+value.rowId+'"><div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected"><input class="vertical-quantity form-control" type="text" value="'+value.qty+'"><span class="input-group-btn-vertical"><button class="btn btn-outline bootstrap-touchspin-up icon-up-dir" type="button"></button><button class="btn btn-outline bootstrap-touchspin-down icon-down-dir" type="button"></button></span></div></span></div><div class="col-lg-3 col-md-3 col-sm-12"><div class="inner-tools">NPR '+value.price+'</div></div><div class="col-lg-3 col-md-3 col-sm-12"><div class="inner-tools"><a href="#" class="btn-icon btn-icon-wish"><i class="icon-heart"></i> Move to wish lists</a></div></div><div class="col-lg-3 col-md-3 col-sm-12"><div class="inner-tools"><button value="'+value.rowId+'" title="Remove product" class="btn-remove product-remove"> Remove</button></div></div></div></div></div></div>';
                side += '<tr><td class="product-col"><figure class="product-image-container"><a href="'+url+'" class="product-image"><img src="/uploads/products/'+value.options.image+'" alt="product"></a></figure><div><h3 class="product-title"><a href="'+url+'">'+value.name+'</a></h3><span class="product-qty" value="'+value.rowId+'">Qty: '+value.qty+'</span></div></td><td class="price-col">'+value.price+'</td></tr>';
            });
            $('.cart-table-container').html(html);
            $('.table-cart').html(side);        
            // cartCount();
        },
        error: function(callback_resonse){
             
        }
    });
});
</script>
@endsection
