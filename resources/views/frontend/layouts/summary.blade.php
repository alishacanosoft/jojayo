@if(!empty(Cart::content()) && Cart::count() > 0)
<div class="col-lg-4">
<div class="ps-form__total">
   <h3 class="ps-form__heading">Your Order</h3>
   <div class="content">
      <div class="ps-block--checkout-total">
         <div class="ps-block__header">
            <p>Item(s)</p>
         </div>
         <div class="ps-block__content">            
            <div class="ps-block__shippings">
                @if(!empty(Cart::content()))
                @foreach(Cart::content() as $row)
               <figure>
                  <a href="{{ route('single-product', $row->options->slug) }}">{{ $row->name }}</a>
                  <span class="pull-right">{{ number_format($row->price) }}</span>
               </figure> <hr>
               @endforeach
                @endif
            </div>
            <strong>Sub Total:</strong>  <span class="pull-right">NPR {{ Cart::subtotal() }}</span><hr>

            @if(Request::segment(1) !== 'cart')
            @php
            if(count($my_address_book) == 0){
                redirect('https://jojayo.com/address-book');
            }
            $delivery = \App\Models\Area::where('city_id', $my_address_book[0]->city)->first();
            $delivery_charge = $delivery->delivery_charge;
            $total =  str_replace(',','',Cart::total()) + $delivery->delivery_charge;
            @endphp
            <strong>Shipping Charge:</strong>  <span class="pull-right">NPR {{ number_format($delivery->delivery_charge) }}</span>
            <hr>
            <h4 class="ps-block__title">Total: <span class="pull-right">{{ number_format($total) }}.00  </span></h4>
            @endif
         </div>
      </div>
      @if(Request::segment(1) == 'cart')
        <!-- <div class="">
            <h5>Apply Discount Code</h5>
            <form action="#" class="mb-1">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Enter discount code" required="">
                </div>
            </form>
        </div> -->
        <div class="checkout-methods">
            
            @if(\Auth::user() == null || \Auth::user()->roles !== 'customers')
            <a class="ps-btn ps-btn--fullwidth" href="#" data-toggle="modal" data-target="#loginModal">Procced to pay</a>
            @else
            <a href="{{ url('/review') }}" class="ps-btn ps-btn--fullwidth">Procced to pay</a>
            @endif
        </div>
        @endif
   </div>
</div><br>
</div><!-- End .col-lg-4 -->
@endif