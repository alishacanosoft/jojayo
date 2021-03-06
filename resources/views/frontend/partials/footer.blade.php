<footer class="ps-footer">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-2 col-md-6">
                    <div class="widget">
                        <h4 class="widget-title">My Account</h4>
                        <ul class="ps-list--link">
                            <li><a href="">About Us</a></li>
                            <li><a href="">Contact Us</a></li>
                            <li><a href="">My Account</a></li>
                            <li><a href="#">Orders History</a></li>
                            <li><a href="#">Advanced Search</a></li>
                            <li><a href="#" class="login-link">Login</a></li>
                        </ul>
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-2 -->

                <div class="col-lg-3 col-md-6">
                    <div class="widget">
                        <h4 class="widget-title">Main Features</h4>

                        <ul class="ps-list--link">
                        <li><a href="">About Us</a></li>
                            <li><a href="">Contact Us</a></li>
                            <li><a href="">My Account</a></li>
                            <li><a href="#">Orders History</a></li>
                            <li><a href="#">Advanced Search</a></li>
                            <li><a href="#" class="login-link">Login</a></li>
                        </ul>
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-3 -->

                <div class="col-lg-4 col-md-6">
                    <div class="widget widget-newsletter">
                        <h4 class="widget-title">Subscribe newsletter</h4>
                        <p>Get all the latest information on Events,Sales and Offers. Sign up for newsletter today</p>
                        <form action="#">
                            <input type="email" class="form-control" placeholder="Email address" required>

                            <button type="submit" class="btn">Subscribe<i class="icon-angle-right"></i></button>
                        </form>
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-5 -->

                <div class="col-lg-3 col-md-6">
                    <div class="widget">
                        <ul class="ps-list--link">
                            <li>
                                <span class="contact-info-label">Address:</span>{{ $sensitive_data->location }}
                            </li>
                            <li>
                                <span class="contact-info-label">Phone:</span><a href="tel:">{{ $sensitive_data->mobile }} & {{ $sensitive_data->mobile1 }}</a>
                            </li>
                            <li>
                                <span class="contact-info-label">Email:</span> <a href="{{ $sensitive_data->email }}">{{ $sensitive_data->email }}</a>
                            </li>
                            <li>
                                <span class="contact-info-label">Working Days/Hours:</span>
                                Mon - Sun / 9:00AM - 8:00PM
                            </li>
                        </ul>
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-4 -->
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
                    <p><strong>{{ $main->name }}</strong>
                    @foreach($main->FinalCategory as $sub_cat)
                    <a href="{{ route('categories.sec', [$main->slug,$sub_cat->slug]) }}">{{ $sub_cat->name }}</a>
                    @endforeach
                    </p>
                    @endforeach
                    @endforeach
                @endif
            </div>
            <div class="ps-footer__copyright">
                <p>© 2018 Jojayo. All Rights Reserved</p>
                <p><span>We Using Safe Payment For:</span><a href="#"><img src="/frontend/images/payment-method/esewa.png" alt=""></a><a href="#"><img src="/frontend/images/payment-method/khalti.png" alt=""></a><a href="#"><img src="/frontend/images/payment-method/cod.png" alt=""></a>
                </p>
            </div>
        </div>
    </footer>
    <!-- pop up -->
    <div id="back2top"><i class="pe-7s-angle-up"></i></div>
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

    
    <script src="/frontend/js/jquery-1.12.4.min.js"></script>
    <script src="/frontend/js/popper.min.js"></script>
    <script src="/frontend/js/owl.carousel.min.js"></script>
    <script src="/frontend/js/bootstrap.min.js"></script>
    <script src="/frontend/js/imagesloaded.pkgd.min.js"></script>
    <script src="/frontend/js/masonry.pkgd.min.js"></script>
    <script src="/frontend/js/isotope.pkgd.min.js"></script>
    <script src="/frontend/js/jquery.matchHeight-min.js"></script>
    <script src="/frontend/js/slick.min.js"></script>
    <script src="/frontend/js/jquery.barrating.min.js"></script>
    <script src="/frontend/js/slick-animation.min.js"></script>
    <script src="/frontend/js/lightgallery-all.min.js"></script>
    <script src="/frontend/js/jquery-ui.min.js"></script>
    <script src="/frontend/js/sticky-sidebar.min.js"></script>
    <script src="/frontend/js/jquery.slimscroll.min.js"></script>
    <script src="/frontend/js/select2.full.min.js"></script>
    <script src="/admin/js/toastr.min.js"></script>
    <!-- custom scripts-->
    <script src="/frontend/js/main.js"></script>
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
	@if(Session::has('message'))
		var type="{{Session::get('alert-type','info')}}"
		switch(type){
			case 'info':
         toastr.info("{{ Session::get('message') }}");
         break;
      case 'success':
          toastr.success("{{ Session::get('message') }}");
          break;
     	case 'warning':
          toastr.warning("{{ Session::get('message') }}");
          break;
      case 'error':
        toastr.error("{{ Session::get('message') }}");
        break;
		}
	@endif
</script>
@yield('scripts')
</body>
</html>
