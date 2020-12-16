    <footer class="ps-footer">
      <div class="ps-container">
        <div class="ps-footer__widgets">
          <aside class="widget widget_footer widget_contact-us">
            <h4 class="widget-title">Contact us</h4>
            <div class="widget_content">

              
              <p><a href="tel:{{ $sensitive_data->mobile }}"> <i class="icon-telephone"></i> {{ $sensitive_data->mobile }}</a> & 
              <a href="tel:{{ $sensitive_data->mobile1 }}">{{ $sensitive_data->mobile1}}</a> </p>
              <p><i class="icon-location"> </i>{{ $sensitive_data->location }}</p>
              <p><a href="mailto:{{ $sensitive_data->email }}"><i class="icon-map-marker"> </i>{{ $sensitive_data->email }}</a></p>
              <ul class="ps-list--social">
                <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></li>
              </ul>
            </div>
          </aside>
          <aside class="widget widget_footer">
            <h4 class="widget-title">Quick links</h4>
            <ul class="ps-list--link">
              <li><a href="{{ url('/privacy-policy') }}">Policy</a></li>
              <li><a href="#">FAQs</a></li>
            </ul>
          </aside>
          <aside class="widget widget_footer">
            <h4 class="widget-title">Company</h4>
            <ul class="ps-list--link">
              <li><a href="{{ url('/about-us') }}">About Us</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </aside>
          <aside class="widget widget_footer">
            <h4 class="widget-title">Bussiness</h4>
            <ul class="ps-list--link">
              <li><a href="#">Checkout</a></li>
              <li><a href="#">My Account</a></li>
              <li><a href="{{ url('/shop') }}">Shop</a></li>
            </ul>
          </aside>
        </div>

        <div class="ps-footer__links">
            @if(!empty($primary_categories)) 
                @foreach($primary_categories as $top_categories)
                @foreach($top_categories->secondaryCategories as $main)
                @php
                    if(count($main->FinalCategory) == 0){
                        continue;
                    }
                @endphp
                <p><strong>{{ ucwords($main->name) }}:</strong>
                    @foreach($main->FinalCategory as $sub_cat)
                    <a href="{{ route('categories.sec', [$main->slug,$sub_cat->slug]) }}">{{ $sub_cat->name }}</a>
                    @endforeach
                    </p>
                @endforeach
                @endforeach
            @endif
        </div>

        <div class="ps-footer__copyright">
            <div class="container">
        <div class="row">
            <div class="col-lg-6">
            <p>© 2018 Jojayo. All Rights Reserved</p>
            </div>
            <div class="col-lg-6">
            <div class="footer-payments"><div>We Using Safe Payment For:</div>
                <ul class="payments">
                    <li><a href="#"><img src="/frontend/images/payment-method/esewa.png" alt=""></a></li>
                    <li><a href="#"><img src="/frontend/images/payment-method/khalti.png" alt=""></a></li>
                    <li><a href="#"><img src="/frontend/images/payment-method/cod.png" alt=""></a></li>
                </ul>
            </div>
            </div>
        </div>
                </div>
       
          
            
        </div>

      </div>
    </footer>
   
    <!-- Scroll up -->

    <a id="scroll-top" class="backtotop show-scroll" href="#page-top">
    <i class="fa fa-chevron-up"></i>
    </a>
    <div class="ps-site-overlay"></div>
    <div id="loader-wrapper">
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <div class="ps-search" id="site-search"><a class="ps-btn--close" href="#"></a>
        <div class="ps-search__content">
            <form class="ps-form--primary-search" action="" method="post">
                <input class="form-control" type="text" placeholder="Search for...">
                <button><i class="aroma-magnifying-glass"></i></button>
            </form>
        </div>
    </div>
    <div class="modal fade" id="product-quickview" tabindex="-1" role="dialog" aria-labelledby="product-quickview" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"><span class="modal-close" data-dismiss="modal"><i class="icon-cross2"></i></span>
                <article class="ps-product--detail ps-product--fullwidth ps-product--quickview">
                </article>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
             <div class="modal-body p-0">
                <div class="ps-my-account">        
                    <div class="ps-form--account ps-tab-root" style="margin:0 auto">
                        <ul class="ps-tab-list">
                            <li class="active"><a href="#sign-in">Login</a></li>
                            <li class=""><a href="#register">Register</a></li>
                        </ul>
                        <div class="ps-tabs">
                            <div class="ps-tab active" id="sign-in">
                            <div class="ps-form__content">
                                <form action="{{ route('customerlogin') }}" method="POST">
                                    @csrf
                                    <h5>Log In Your Account</h5>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="email" placeholder="Username or email address">
                                        @if($errors->has('email'))
                                            <span class="text-danger small">{{ $errors->first('email') }}</span><br>
                                        @endif
                                    </div>
                                    <div class="form-group form-forgot">
                                        <input class="form-control" type="password" name="password" placeholder="Password"><a href="">Forgot?</a>
                                        @if($errors->has('password'))
                                            <span class="text-danger small">{{ $errors->first('password') }}</span><br>
                                        @endif
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="ps-checkbox">
                                            <input class="form-control" type="checkbox" id="remember-me" name="remember-me">
                                            <label for="remember-me">Rememeber me</label>
                                        </div>
                                    </div> -->
                                    <div class="form-group submtit">
                                        <button type="submit" class="ps-btn ps-btn--fullwidth">Login</button>
                                    </div>
                                </form>
                            </div>                
                            </div>
                            <div class="ps-tab" id="register">
                            <div class="ps-form__content">
                                <form action="{{ route('customerSignUp') }}" method="POST">
                                    @csrf
                                    <h5>Register An Account</h5>
                                    <div class="form-group">
                                        <input class="form-control" name="email" type="text" placeholder="Username or email address">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="contact" type="text" placeholder="Contact number">
                                        @if ($errors->has('contact'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('contact') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="password" placeholder="Password" name="password">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="confirm" type="password" placeholder="Re-type Password">
                                        @if ($errors->has('confirm'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('confirm') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group submtit">
                                        <button class="ps-btn ps-btn--fullwidth">Register</button>
                                    </div>
                                </form>
                            </div>
                            
                            </div>
                            <div class="ps-form__footer">
                                <p>Connect with:</p>
                                <ul class="ps-list--social">
                                    <li><a class="facebook" href="{{ url('/login/facebook') }}"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="google" href="{{ url('/login/google') }}"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>        
                </div>
             </div>
          </div>
       </div>
    </div>

   
    <script src="{{asset('/frontend/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('/frontend/js/popper.min.js')}}"></script>
    <script src="{{asset('/frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('/frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/frontend/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('/frontend/js/masonry.pkgd.min.js')}}"></script>
    <script src="{{asset('/frontend/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('/frontend/js/jquery.matchHeight-min.js')}}"></script>
    <script src="{{asset('/frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('/frontend/js/jquery.barrating.min.js')}}"></script>
    <script src="{{asset('/frontend/js/slick-animation.min.js')}}"></script>
    <script src="{{asset('/frontend/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('/frontend/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('/frontend/js/sticky-sidebar.min.js')}}"></script>
    <script src="{{asset('/frontend/js/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('/frontend/js/select2.full.min.js')}}"></script>
    <script src="{{asset('/admin/js/toastr.min.js')}}"></script>
    <!-- custom scripts-->
    <script src="{{asset('/frontend/js/main.js')}}"></script>
    <script type="text/javascript">
    var currentVal = 1;
    function cartCount(){
        $.ajax({
            method: "GET",
            url: "{{ route('cart.count') }}",
            dataType: 'json',
            success(response){
                $('.cart-count').html(response.count);
                $('.cart-total-price').html(response.total);
            }
        });
    }
    $('.cart-count').html("{{ Cart::content()->count() }}");
    function updateCart(){
        $.ajax({
            method: "GET",
            url: "{{ route('cart.content') }}",
            dataType: 'json',
            success(callback_resonse){
                $('.ps-cart__items').empty();
                let html = "";
                let total = "";
                $.each(callback_resonse, function( key, value ){
                    total = total+value.price;
                    var data = value.options.slug;
                    var url = "{{ route('single-product', ':data') }}";
                    url = url.replace(':data', data);
                    html += '<div class="ps-product--cart-mobile"><div class="ps-product__thumbnail"><a href="#"><img src="/uploads/products/'+value.options.image+'" alt=""></a></div><div class="ps-product__content"><a class="ps-product__remove" value="'+value.rowId+'"><i class="icon-cross"></i></a><a href="'+url+'">'+value.name+'</a><br><small>'+value.qty+' x NPR '+value.price+'</small></div></div>';
                });
                $('.ps-cart__items').html(html);
                $.getScript("{{ asset('/frontend/js/jquery.min.js') }}")
                cartCount();
            },
            error: function(callback_resonse){
                toastr.error('Problem!');
            }
        });
    }
    $(document).on("click", ".ps-product__remove", function() {
    let confirmation = confirm("Are you sure, you want to remove this item from your cart?");
    if(confirmation){
        let data = $(this).attr('value');
        var url = '{{ route("cart.destroy", ":data") }}';
        url = url.replace(':data', data);
        $.ajax({
            method: "POST",
            url: url,
            dataType: 'json',
            data: { _token:"{{ csrf_token() }}",  _method:"DELETE"},
            success(response){
                updateCart();
                $('.ps-product__info').find('span').attr('value', '');
                toastr.success(response.data);
                setTimeout(function() { window.location.reload(); }, 1000);
            }
        });
    }
    });

    function addcart() {
        $('.btn-add-cart, .btn-buy-now').on('click', function(){
        let my_var = $(this).attr('data-class');
        let id = $(this).attr('value');
        let url = '{{ route("cart.store") }}';
        var image_src = $(this).closest('figure').find('img').attr('src');
        let color_id = $('#color_data').attr('value');
        if(color_id == undefined){
            toastr.warning('Please select color!');
            return;
        }
        let size_id = $('#size_data').attr('value');
        if(size_id == undefined){
            toastr.warning('Please select size!');
            return;
        }
        $.ajax({
            method: "POST",
            url: url,
            dataType: 'json',
            data: { _token:"{{ csrf_token() }}", id: id, size_id: size_id, color_id:color_id},
            success(response){
                $('.ps-product__info').closest('div').find('span').attr('value', response.rowId)
                $('#productImage').attr('src', image_src);
                cartCount();
                updateCart();
                toastr.success(response.message);
                if(my_var == 'btn-buy-now'){
                  if("\Auth::user() == null || \Auth::user()->roles !== 'customers'"){
                    $("#loginModal").modal('show');
                  } else {
                    setTimeout(function() { window.location.replace('/review'); }, 1000);
                  }                  
                }
            },
            error: function(response){
                toastr.error('Something went wrong!');
            }
        });
        })
        
    }
    addcart();

    $(function () {
        var currentVal = '';
        $(".up, .down").on('click', function(){
        let quantity = $(this).val();
        let data = $(this).closest('div').find('span').attr('value');

        if(quantity<1){
            toastr.info('Please add the product to the cart first!');
            return;
        }

        if(data == ''){
            toastr.info('Please add the product to the cart first!');
            return;
        }
        var url = '{{ route("update.cart", ":data") }}';
        url = url.replace(':data', data);
            $.ajax({
                method: "POST",
                url: url,
                dataType: 'json',
                data: { _token:"{{ csrf_token() }}", _method:"PATCH", quantity: quantity},
                success(response){
                    toastr.success(response.data);
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
    });

    function quickView(){
        $('.btn-quick-view').on('click', function(){
        let id = $(this).attr('value');
        let url = '{{ route("quick", ":data") }}';
        url = url.replace(":data", id);
        $.ajax({
            method: "GET",
            url: url,
            dataType: 'json',
            success(response){
                let html = "<div class='ps-product__header'><div class='ps-product__thumbnail' data-vertical='false'><div class='ps-product__images' data-arrow='true'>";
                $.each(response.data.images, function(key, value){
                html += "<div class='item'><img src='/uploads/products/Thumb-"+value.images[0].image+"'></div>";
                });
                let product_url = '{{ route("single-product", ":data") }}';
                product_url = product_url.replace(":data", response.data.slug);
                html += "</div></div><div class='ps-product__info'><h1><a href='"+product_url+"'>"+response.data.name+"</a></h1><div class='ps-product__meta'><p>Brand:<a href=''>Sony</a></p><div class='ps-product__rating'><select class='ps-rating' data-read-only='true'><option value='1'>1</option><option value='1'>2</option><option value='1'>3</option><option value='1'>4</option><option value='2'>5</option></select><span>(1 review)</span></div></div><h4 class='ps-product__price'>From NPR – <span class='quick-price'>"+number_format(response.starting_price.selling_price)+"</span></h4><div class='ps-product__desc single_page'>"+response.data.specification+"</div><div class='ps-product__shopping'>Click on the product title to view product page.</div></div>";
                $('.ps-product--quickview').html(html);
                $('.ps-product__images').slick();
                $('.slick-prev').html("<i class='fa fa-angle-left'></i></a>");
                $('.slick-next').html("<i class='fa fa-angle-right'></i></a>");
                $('select.ps-rating').each(function() {
                    var readOnly;
                    if ($(this).attr('data-read-only') == 'true') {
                        readOnly = true
                    } else {
                        readOnly = false;
                    }
                    $(this).barrating({
                        theme: 'fontawesome-stars',
                        readonly: readOnly,
                        emptyValue: '0'
                    });
                });

            },
            error: function(response){
                toastr.error('Something went wrong!');
            }
        });
        })
    }
    quickView();

    setTimeout(function(){
    $('.alert').fadeOut();
    }, 5000);
    </script>




<script>
    $(document).ready(function(){
    	$("#nav li").hover(
    	function(){
    		$(this).children('ul').hide();
    		$(this).children('ul').slideDown('fast');
    	},
    	function () {
    		$('ul', this).slideUp('fast');
    	});
    });

    $(document).ready(function () {
        $("#productSearch").keyup(function () {
            var query=(this.value);
            getProd(query,'web')
        });

        $('#productSearchMob').keyup(function(){
            var query=(this.value);
            getProd(query,'mob')
        })
    });

    var url='{{route("searchProductAjax")}}';
    var _token='{{csrf_token()}}';

function getProd(query,temp){
    if (query != '') {
        var query = query;
        var cat = (temp=='mob')?'all':$('#searchCategory').val();
        $.ajax({
            url: url,
            method: "POST",
            data: {_token: _token, category: cat, query: query},
            success: function (data) {
                if(temp=='mob'){
                    $('#productListMob').fadeIn(20);
                    $('#productListMob').html(data);
                }else{
                    $('#productList').fadeIn(20);
                    $('#productList').html(data);
                }
            }
        });
    }
}
$(document).on('click', '.productList li', function () {
    $('#productSearch').val($(this).text());
    $('#productList').fadeOut(1);
});

$('html').click(function () {
    $('.productList').fadeOut(1);
    $('.productListMob').fadeOut(1);
});

$(document).on('click', '.productListMob li', function () {
    $('#productSearchMob').val($(this).text());
    $('#productListMob').fadeOut(1);
});
</script>
<script>
	// @if(Session::has('message'))
	// 	var type="{{Session::get('alert-type','info')}}"
	// 	switch(type){
	// 		case 'info':
    //      toastr.info("{{ Session::get('message') }}");
    //      break;
    //   case 'success':
    //       toastr.success("{{ Session::get('message') }}");
    //       break;
    //  	case 'warning':
    //       toastr.warning("{{ Session::get('message') }}");
    //       break;
    //   case 'error':
    //     toastr.error("{{ Session::get('message') }}");
    //     break;
	// 	}
    // @endif

    (function($, window){
        var arrowWidth = 30;

        $.fn.resizeselect = function(settings) {  
            return this.each(function() { 

            $(this).change(function(){
                var $this = $(this);

                // create test element
                var text = $this.find("option:selected").text();
                
                var $test = $("<span>").html(text).css({
                    "font-size": $this.css("font-size"), // ensures same size text
                "visibility": "hidden" 							 // prevents FOUC
                });
                

                // add to body, get width, and get out
                $test.appendTo($this.parent());
                var width = $test.width();
                $test.remove();

                // set select width
                $this.width(width + arrowWidth);

                // run on start
            }).change();

            });
    };

  // run by default
  $("select.resizeselect").resizeselect();                       

})(jQuery, window);



$( document ).ready(function() {
    var $scrollTop=$('#scroll-top');
    var jojayo = $('#jojayo-header');
    $(window).scroll(function(){
        if($(window).scrollTop()>$(window).height()){
            $scrollTop.addClass('show-scroll');}
            else{
                $scrollTop.removeClass('show-scroll');
            }
        });
        $scrollTop.on('click',function(event){
            event.preventDefault();
            $('html, body').stop().animate({scrollTop:0},800);
            });
        });
</script>


@yield('scripts')
</body>
</html>
