<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="JoJayo">

    <meta name="description" content="JOJAYO" />
    <meta name="keywords" content="jojayo, shopping, e-commerce" />
    <link rel="canonical" href="https://jojayo.com/" />

    <link rel="icon" href="{{asset('images/favicon.ico')}}" />
    <link rel="apple-touch-icon" href="{{asset('images/apple-touch-icon.png')}}" />
    <link rel="android-chrome-192x192" href="{{asset('images/android-chrome-192x192.png')}}" />
    <link rel="android-chrome-512x512" href="{{asset('images/android-chrome-512x512.png')}}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('images/site.webmanifest')}}">


    <meta property="og:type" content="ecommerce-website" />
    <meta property="og:title" content="JOJAYO" />
    <meta property="og:description" content="JOJAYO" />
    <meta property="og:url" content="https://jojayo.com/" />
    <meta property="og:site_name" content="JOJAYO" />
    <meta property="og:image" content="{{asset('images/jojayo_logo.png')}}" />

    <title>JoJayo Shopping</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700&amp;amp;subset=latin-ext" rel="stylesheet">
   
    <link rel="stylesheet" href="{{asset('frontend1/plugins/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend1/fonts/Linearicons/Linearicons/Font/demo-files/demo.css')}}">
    <link rel="stylesheet" href="{{asset('frontend1/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend1/plugins/owl-carousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend1/plugins/owl-carousel/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend1/plugins/slick/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('frontend1/plugins/nouislider/nouislider.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend1/plugins/lightGallery-master/dist/css/lightgallery.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend1/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css')}}">
    <link rel="stylesheet" href="{{asset('frontend1/plugins/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/admin/css/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend1/css/style.css')}}">
    <style>
        /* width */
        .productList::-webkit-scrollbar {
        width: 10px;
        }

        /* Track */
        .productList::-webkit-scrollbar-track {
        background: #000!important
        }

        /* Handle */
        .productList::-webkit-scrollbar-thumb {
        background: #888;
        }

        /* Handle on hover */
        .productList::-webkit-scrollbar-thumb:hover {
        background: #555;
        }
        .productList{
            position: absolute!important;
            top: 100%;
            transform: scaleX(1);
            padding: 0 20px;
            background: #fff!important;
            z-index: 9999!important;
            border: 1px solid #ccc;
            border-top: none;
            overflow-y: auto;
            display: none;
            width: 100%;
        }
        .productList li{
            cursor: pointer;
            padding: 10px;
            transition: 0.5s;
          }

        .productList li:hover{
            background: #000000;
            color: #fff;
        }
        
        .productListMob li{
            padding: 5px 15px;
            border-bottom: 1px solid #000;
        }
        @media (min-width: 576px){
            #loginModal .modal-dialog {
                max-width: 394;
            }
        }
        #loginModal .ps-form--account{
            box-shadow:none;
        }
        .top-bar{
            background: #f1f1f1;
        }
        .menu.text-right > li > a{
            padding: 5px 10px;
            font-size:13px;
            color:#000;
        }
      .font-13{
          font-size: 13px;
      } 
      .font-weight-normal{
          font-weight: normal;
      }
    </style>
    @yield('styles')

</head>

<body>

@if(Route::is('single-product') )
<header class="header header--1" data-sticky="false" id="jojayo-header">
      <div class="header__top">
        <div class="ps-container">
          <div class="header__left">
            <div class="menu--product-categories">
            <ul id="nav">  
                <li class="yahoo">      
                <div class="menu__toggle"><i class="icon-menu"></i><span> Shop By Categories</span></div>
                    <ul style="z-index:1000;min-width:260px;margin-top:10px">
                        @if(!empty($primary_categories))
                        @foreach($primary_categories as $prime)
                            @if($prime->secondaryCategories->count() > 0)
                            <li><a href="#"><i class="{{ $prime->icon }}"></i> {{ $prime->name }} »</a>            
                                <ul>
                                    @foreach($prime->secondaryCategories as $secondary)
                                        @if($secondary->FinalCategory->count() > 0)
                                        <?php
                                        $secondary->name = str_replace("Women's", "", $secondary->name);
                                        $secondary->name = str_replace("Men's", "", $secondary->name);
                                        ?>
                                        <li><a href="{{route('categories', $secondary->slug)}}">{{ $secondary->name }} »</a>
                                        <ul>
                                            @foreach($secondary->FinalCategory as $final_cat)
                                            <?php
                                            $final_cat->name = str_replace("Women's", "", $final_cat->name);
                                            $final_cat->name = str_replace("Men's", "", $final_cat->name);
                                            ?>
                                            <li><a href="{{ route('categories.sec', [$secondary->slug,$final_cat->slug]) }}">{{ $final_cat->name }}</a></li>
                                            @endforeach
                                        </ul>
                                        </li>
                                        @else
                                        <li><a href="{{route('categories', $secondary->slug)}}">{{ $secondary->name }}</a></li>
                                        @endif
                                    @endforeach                                                                                        
                                </ul>
                            </li>
                            @else
                            <li><a href="#"><i class="{{ $prime->icon }}"></i> {{ $prime->name }}</a></li>
                            @endif
                        @endforeach
                        @endif
                    </ul>
                </li>
              </ul> 
            </div>
            <a class="ps-logo" href="{{ url('/') }}"><img src="{{ $sensitive_data->logo }}" alt="jojayo-logo"></a>
          </div>
          <div class="header__center">
            <form class="ps-form--quick-search" action="{{ route('searchProduct')}}" method="GET">
            <!-- @csrf -->
              <div class="form-group--icon"><i class="icon-chevron-down"></i>
               
                <select class="form-control" id="searchCategory" style="text-indent: 0" name="category">
                                <option value="all" {{($selected_category = 'all') ? 'selected':''}}>All</option>
                                @foreach($primary_categories as $prime)
                                    @if($prime->secondaryCategories->count() > 0)
                                        @foreach($prime->secondaryCategories as $secondary)
                                            @if($secondary->FinalCategory->count() > 0)

                                                <?php
                                                    $secondary->name = str_replace("Women's", "", $secondary->name);
                                                    $secondary->name = str_replace("Men's", "", $secondary->name);
                                                ?>

                                                <optgroup label="{{trim($secondary->name)}}">

                                                @foreach($secondary->FinalCategory as $final_cat)
                                                    <?php
                                                        $final_cat->name = str_replace("Women's", "", $final_cat->name);
                                                        $final_cat->name = str_replace("Men's", "", $final_cat->name);
                                                    ?>
                                                    <option class="level-1" value="{{$final_cat->slug}}" {{(@$selected_category == $final_cat->slug) ? 'selected':''}}>{{trim($final_cat->name)}}</option>
                                                @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                </select>

                <select id="compute_select">
                    <option id="compute_option"></option>
                </select>
              </div>

            <div class="search-top">
             <input class="form-control" required name="q" id="productSearch"   type="text" placeholder="I'm shopping for...">
                <div id="productList" class="productList">
                </div>         
            </div>
            <button >Search</button>
            </form>
          </div>
          <div class="header__right">
            <div class="header__actions">
            
            <a class="header__extra" href="#"><i class="icon-heart"></i><span><i>0</i></span></a>
              <div class="ps-cart--mini"><a class="header__extra" href="#"><i class="icon-bag2"></i><span><i class="cart-count">{{ Cart::content()->count() }}</i></span></a>
                    <div class="ps-cart__content">
                        <div class="ps-cart__items">
                        @if(!empty(Cart::content()))
                        @foreach(Cart::content() as $row)
                            <div class="ps-product--cart-mobile">
                                <div class="ps-product__thumbnail"><a href="#"><img src="{{ url('/uploads/products/'.$row->options->image) }}" alt=""></a></div>
                                <div class="ps-product__content"><a class="ps-product__remove" value="{{ $row->rowId }}"><i class="icon-cross"></i></a><a href="{{ route('single-product', $row->options->slug) }}">{{ $row->name }}</a>
                                    <!-- <p><strong>Sold by:</strong> YOUNG SHOP</p> --> <br>
                                    <small>{{ $row->qty }} x NPR {{ number_format($row->price) }}</small>
                                </div>
                            </div>
                        @endforeach
                        @endif
                        </div>
                        <div class="ps-cart__footer">
                            <h3>Sub Total:<strong class="cart-total-price">NPR {{ Cart::total() }}</strong></h3>
                            <figure>
                                <a class="ps-btn ps-btn--fullwidth" href="{{ route('cart.index') }}" style="margin-right:2px">View Cart</a>
                                @if(\Auth::user() == null || \Auth::user()->roles !== 'customers')
                                <a class="ps-btn ps-btn--fullwidth" href="#" data-toggle="modal" data-target="#loginModal" style="margin-left:2px">Checkout</a>
                                @else
                                <a class="ps-btn ps-btn--fullwidth" href="{{ route('review') }}" style="margin-left:2px">Checkout</a>
                                @endif
                                </figure>
                        </div>
                    </div>
              </div>
              <div class="ps-block--user-header">
                <div class="ps-block__left"><i class="icon-user"></i></div>
                <div class="ps-block__right">
                          

                @if(!empty(Auth::user()) && Auth::user()->roles == 'customers')
                <div class="ps-block--user-header">
                    <div class="dropdown">
                        <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="ps-block__left text-dark font-13 font-weight-normal">
                            <i class="icon-user text-dark"></i>&nbsp;My Account
                            &nbsp;<i class="fa fa-angle-down text-dark"></i></div>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ url('/dashboard') }}">My Dashboard</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Log Out</a>
                        </div>
                    </div>
                </div> 
                @else
                <a href="{{ route('signinform') }}">Login & Register</a>
                    
                @endif
                
                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <nav class="navigation">
        <div class="ps-container">
          <div class="navigation__left">
            <div class="menu--product-categories">            
              <ul id="nav">  
                <li class="yahoo">      
                <div class="menu__toggle"><i class="icon-menu"></i><span> Shop By Categories</span></div>
                    <ul style="z-index:1000;min-width:260px;margin-top:10px">
                        @if(!empty($primary_categories))
                        @foreach($primary_categories as $prime)
                            @if($prime->secondaryCategories->count() > 0)
                            <li><a href="#"><i class="{{ $prime->icon }}"></i> {{ $prime->name }} »</a>            
                                <ul>
                                    @foreach($prime->secondaryCategories as $secondary)
                                        @if($secondary->FinalCategory->count() > 0)
                                        <?php
                                        $secondary->name = str_replace("Women's", "", $secondary->name);
                                        $secondary->name = str_replace("Men's", "", $secondary->name);
                                        ?>
                                        <li><a href="{{route('categories', $secondary->slug)}}">{{ ucwords($secondary->name) }} »</a>
                                        <ul>
                                            @foreach($secondary->FinalCategory as $final_cat)
                                            <?php
                                            $final_cat->name = str_replace("Women's", "", $final_cat->name);
                                            $final_cat->name = str_replace("Men's", "", $final_cat->name);
                                            ?>
                                            <li><a href="{{ route('categories.sec', [$secondary->slug,$final_cat->slug]) }}">{{ ucwords($final_cat->name) }}</a></li>
                                            @endforeach
                                        </ul>
                                        </li>
                                        @else
                                        <li><a href="{{route('categories', $secondary->slug)}}">{{ ucwords($secondary->name) }}</a></li>
                                        @endif
                                    @endforeach                                                                                        
                                </ul>
                            </li>
                            @else
                            <li><a href="#"><i class="{{ $prime->icon }}"></i> {{ $prime->name }}</a></li>
                            @endif
                        @endforeach
                        @endif
                    </ul>
                </li>
              </ul>  
            </div>
          </div>
          <div class="navigation__right">
                        <ul class="menu">
                            <li><a href="{{ url('/') }}">Home</a>
                            </li>
                            <li><a href="{{ url('/shop') }}">Shop</a></li>
                            <li><a href="{{ url('/about-us') }}">About</a></li>
                            <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li> 
                        </ul>
            <ul class="navigation__extra">
              <li><a href="{{url('/vendor')}}">Sell on JoJayo</a></li>
             
            </ul>
          </div>
        </div>
      </nav>
</header>
@else
<header class="header header--1" data-sticky="true" id="jojayo-header">
      <div class="header__top">
        <div class="ps-container">
          <div class="header__left">
            <div class="menu--product-categories">
            <ul id="nav">  
                <li class="yahoo">      
                <div class="menu__toggle"><i class="icon-menu"></i><span> Shop By Categories</span></div>
                    <ul style="z-index:1000;min-width:260px;margin-top:10px">
                        @if(!empty($primary_categories))
                        @foreach($primary_categories as $prime)
                            @if($prime->secondaryCategories->count() > 0)
                            <li><a href="#"><i class="{{ $prime->icon }}"></i> {{ $prime->name }} »</a>            
                                <ul>
                                    @foreach($prime->secondaryCategories as $secondary)
                                        @if($secondary->FinalCategory->count() > 0)
                                        <?php
                                        $secondary->name = str_replace("Women's", "", $secondary->name);
                                        $secondary->name = str_replace("Men's", "", $secondary->name);
                                        ?>
                                        <li><a href="{{route('categories', $secondary->slug)}}">{{ $secondary->name }} »</a>
                                        <ul>
                                            @foreach($secondary->FinalCategory as $final_cat)
                                            <?php
                                            $final_cat->name = str_replace("Women's", "", $final_cat->name);
                                            $final_cat->name = str_replace("Men's", "", $final_cat->name);
                                            ?>
                                            <li><a href="{{ route('categories.sec', [$secondary->slug,$final_cat->slug]) }}">{{ $final_cat->name }}</a></li>
                                            @endforeach
                                        </ul>
                                        </li>
                                        @else
                                        <li><a href="{{route('categories', $secondary->slug)}}">{{ $secondary->name }}</a></li>
                                        @endif
                                    @endforeach                                                                                        
                                </ul>
                            </li>
                            @else
                            <li><a href="#"><i class="{{ $prime->icon }}"></i> {{ $prime->name }}</a></li>
                            @endif
                        @endforeach
                        @endif
                    </ul>
                </li>
              </ul> 
            </div>
            <a class="ps-logo" href="{{ url('/') }}"><img src="{{ $sensitive_data->logo }}" alt="jojayo-logo"></a>
          </div>
          <div class="header__center">
            <form class="ps-form--quick-search" action="{{ route('searchProduct') }}" method="GET">
            <!-- @csrf -->
              <div class="form-group--icon"><i class="icon-chevron-down"></i>
               
                <select class="form-control" id="searchCategory" style="text-indent: 0" name="category">
                                <option value="all" {{($selected_category = 'all') ? 'selected':''}}>All</option>
                                @foreach($primary_categories as $prime)
                                    @if($prime->secondaryCategories->count() > 0)
                                        @foreach($prime->secondaryCategories as $secondary)
                                            @if($secondary->FinalCategory->count() > 0)

                                                <?php
                                                    $secondary->name = str_replace("Women's", "", $secondary->name);
                                                    $secondary->name = str_replace("Men's", "", $secondary->name);
                                                ?>  
                                            <optgroup label="{{trim($secondary->name)}}">
                                                @foreach($secondary->FinalCategory as $final_cat)
                                                    <?php
                                                        $final_cat->name = str_replace("Women's", "", $final_cat->name);
                                                        $final_cat->name = str_replace("Men's", "", $final_cat->name);
                                                    ?>
                                                    <option class="level-1" value="{{$final_cat->slug}}" {{(@$selected_category == $final_cat->slug) ? 'selected':''}}>{{trim($final_cat->name)}}</option>
                                                @endforeach
                                            </optgroup>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                </select>

                
                <select id="compute_select">
                    <option id="compute_option"></option>
                </select>
                
              </div>
            <div class="search-top">
             <input class="form-control" required name="q" id="productSearch"   type="text" placeholder="I'm shopping for...">
                        <div id="productList" class="productList">
                        </div>
            </div>
                <button>Search</button>
            </form>
          </div>
          <div class="header__right">
            <div class="header__actions">
            
            <a class="header__extra" href="#"><i class="icon-heart"></i><span><i>0</i></span></a>
              <div class="ps-cart--mini"><a class="header__extra" href="#"><i class="icon-bag2"></i><span><i class="cart-count">{{ Cart::content()->count() }}</i></span></a>
                    <div class="ps-cart__content">
                        <div class="ps-cart__items">
                        @if(!empty(Cart::content()))
                        @foreach(Cart::content() as $row)
                            <div class="ps-product--cart-mobile">
                                <div class="ps-product__thumbnail"><a href="#"><img src="{{ url('/uploads/products/'.$row->options->image) }}" alt=""></a></div>
                                <div class="ps-product__content"><a class="ps-product__remove" value="{{ $row->rowId }}"><i class="icon-cross"></i></a><a href="{{ route('single-product', $row->options->slug) }}">{{ $row->name }}</a>
                                    <!-- <p><strong>Sold by:</strong> YOUNG SHOP</p> --> <br>
                                    <small>{{ $row->qty }} x NPR {{ number_format($row->price) }}</small>
                                </div>
                            </div>
                        @endforeach
                        @endif
                        </div>
                        <div class="ps-cart__footer">
                            <h3>Sub Total:<strong class="cart-total-price">NPR {{ Cart::total() }}</strong></h3>
                            <figure>
                                <a class="ps-btn ps-btn--fullwidth" href="{{ route('cart.index') }}" style="margin-right:2px">View Cart</a>
                                @if(\Auth::user() == null || \Auth::user()->roles !== 'customers')
                                <a class="ps-btn ps-btn--fullwidth" href="#" data-toggle="modal" data-target="#loginModal" style="margin-left:2px">Checkout</a>
                                @else
                                <a class="ps-btn ps-btn--fullwidth" href="{{ route('review') }}" style="margin-left:2px">Checkout</a>
                                @endif
                                </figure>
                        </div>
                    </div>
              </div>
              <div class="ps-block--user-header">
               
                <div class="ps-block__right">
                          
                @if(!empty(Auth::user()) && Auth::user()->roles == 'customers')
                <div class="ps-block--user-header">
                    <div class="dropdown">
                        <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="ps-block__left text-dark font-13 font-weight-normal">
                            <i class="icon-user text-dark"></i>&nbsp;My Account
                            &nbsp;<i class="fa fa-angle-down text-dark"></i></div>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ url('/dashboard') }}">My Dashboard</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Log Out</a>
                        </div>
                    </div>
                </div> 
                @else
                <div class="ps-block__left"><i class="icon-user"></i> <a href="{{ route('signinform') }}">Login & Register</a></div> 
                @endif
                
                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <nav class="navigation">
        <div class="ps-container">
          <div class="navigation__left">
            <div class="menu--product-categories">            
              <ul id="nav">  
                <li class="yahoo">      
                <div class="menu__toggle"><i class="icon-menu"></i><span> Shop By Categories</span></div>
                    <ul style="z-index:1000;min-width:260px;margin-top: 10px;">
                        @if(!empty($primary_categories))
                        @foreach($primary_categories as $prime)
                            @if($prime->secondaryCategories->count() > 0)
                            <li><a href="#"><i class="{{ $prime->icon }}"></i> {{ $prime->name }} »</a>            
                                <ul>
                                    @foreach($prime->secondaryCategories as $secondary)
                                        @if($secondary->FinalCategory->count() > 0)
                                        <?php
                                        $secondary->name = str_replace("Women's", "", $secondary->name);
                                        $secondary->name = str_replace("Men's", "", $secondary->name);
                                        ?>
                                        <li><a href="{{route('categories', $secondary->slug)}}">{{ ucwords($secondary->name) }} »</a>
                                        <ul>
                                            @foreach($secondary->FinalCategory as $final_cat)
                                            <?php
                                            $final_cat->name = str_replace("Women's", "", $final_cat->name);
                                            $final_cat->name = str_replace("Men's", "", $final_cat->name);
                                            ?>
                                            <li><a href="{{ route('categories.sec', [$secondary->slug,$final_cat->slug]) }}">{{ ucwords($final_cat->name) }}</a></li>
                                            @endforeach
                                        </ul>
                                        </li>
                                        @else
                                        <li><a href="{{route('categories', $secondary->slug)}}">{{ ucwords($secondary->name) }}</a></li>
                                        @endif
                                    @endforeach                                                                                        
                                </ul>
                            </li>
                            @else
                            <li><a href="#"><i class="{{ $prime->icon }}"></i> {{ $prime->name }}</a></li>
                            @endif
                        @endforeach
                        @endif
                    </ul>
                </li>
              </ul>  
            </div>
          </div>
          <div class="navigation__right">
                        <ul class="menu">
                            <li><a href="{{ url('/') }}">Home</a>
                            </li>
                            <li><a href="{{ url('/shop') }}">Shop</a></li>
                            <li><a href="{{ url('/about-us') }}">About</a></li>
                            <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li> 
                        </ul>
            <ul class="navigation__extra">
              <li><a href="{{url('/vendor')}}">Sell on JoJayo</a></li>
             
            </ul>
          </div>
        </div>
      </nav>
</header>

<header class="header header--mobile" data-sticky="true">
    <div class="header__top">
      <div class="header__left">
        <p>Welcome to JoJayo Online Shopping Store !</p>
      </div>
      <div class="header__right">
        <ul class="navigation__extra">
          <li><a href="{{url('/vendor')}}">Sell on JoJayo</a></li>
          
        </ul>
      </div>
    </div>
    <div class="navigation--mobile">
          <div class="navigation__left"><a class="ps-logo" href="{{ url('/') }}"><img src="{{ $sensitive_data->logo }}" alt=""></a></div>
          <div class="navigation__right">
              <div class="header__actions">
                  <div class="ps-cart--mini"><a class="header__extra" href="#"><i class="icon-bag2"></i><span><i>0</i></span></a>
                      <div class="ps-cart__content">
                          <div class="ps-cart__items">
                          @if(!empty(Cart::content()))
                              @foreach(Cart::content() as $row)
                              <div class="ps-product--cart-mobile">
                                  <div class="ps-product__thumbnail"><a href="{{ route('single-product', $row->options->slug) }}"><img src="{{ url('/uploads/products/'.$row->options->image) }}" alt=""></a></div>
                                  <div class="ps-product__content"><a class="ps-product__remove" value="{{ $row->rowId }}" href="#"><i class="icon-cross"></i></a><a href="{{ route('single-product', $row->options->slug) }}">{{ $row->name }}</a>
                                      <small>{{ $row->qty }} x NPR {{ number_format($row->price) }}</small>
                                  </div>
                              </div>
                              @endforeach
                          @endif
                          </div>
                          <div class="ps-cart__footer">
                              <h3>Sub Total:<strong>{{ Cart::total() }}</strong></h3>
                              <figure><a class="ps-btn" href="{{ route('cart.index') }}">View Cart</a><a class="ps-btn" href="{{ route('review') }}">Checkout</a></figure>
                          </div>
                      </div>
                  </div>
                  <div class="ps-block--user-header">
                      <div class="ps-block__left"><a href="{{ route('signinform') }}"><i class="icon-user"></i></a></div>
                      <div class="ps-block__right"><a href="{{ route('signinform') }}">Login</a></div>
                  </div>
              </div>
          </div>
      </div>
    <!-- <div class="ps-search--mobile">
      <form class="ps-form--search-mobile" action="" method="get">
        <div class="form-group--nest">
          <input class="form-control" type="text" placeholder="Search something...">
          <button><i class="icon-magnifier"></i></button>
        </div>
      </form>
    </div> -->
  </header>

    <div class="ps-panel--sidebar" id="cart-mobile">
      <div class="ps-panel__header">
        <h3>Shopping Cart</h3>
      </div>
      <div class="navigation__content">
            <div class="ps-cart--mobile">
                <div class="ps-cart__content">
                @if(!empty(Cart::content()))
                    @foreach(Cart::content() as $row)
                    <div class="ps-product--cart-mobile">
                        <div class="ps-product__thumbnail"><a href="{{ route('single-product', $row->options->slug) }}"><img src="{{ url('/uploads/products/'.$row->options->image) }}" alt=""></a></div>
                        <div class="ps-product__content"><a class="ps-product__remove" value="{{ $row->rowId }}" href="#"><i class="icon-cross"></i></a><a href="{{ route('single-product', $row->options->slug) }}">{{ $row->name }}</a>
                            <small>{{ $row->qty }} x NPR {{ number_format($row->price) }}</small>
                        </div>
                    </div>
                    @endforeach
                @endif
                </div>
                <div class="ps-cart__footer">
                    <h3>Sub Total:<strong>NPR {{ Cart::total() }}</strong></h3>
                    <figure><a class="ps-btn" href="{{ route('cart.index') }}">View Cart</a><a class="ps-btn" href="{{ route('review') }}">Checkout</a></figure>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-panel--sidebar" id="navigation-mobile">
      <div class="ps-panel__header">
        <h3>Categories</h3>
      </div>
      <div class="ps-panel__content">
           <ul class="menu--mobile">
                @if(!empty($primary_categories))
                    @foreach($primary_categories as $prime)
                        @if($prime->secondaryCategories->count() > 0)
                        <li class="current-menu-item menu-item-has-children has-mega-menu">
                            <a href="#">{{$prime->name}}</a><span class="sub-toggle"></span>
                            <div class="mega-menu">
                                @foreach($prime->secondaryCategories as $secondary)
                                    @if($secondary->FinalCategory->count() > 0)
                                        @php
                                            $secondary->name = str_replace("Women's", "", $secondary->name);
                                            $secondary->name = str_replace("Men's", "", $secondary->name);
                                        @endphp
                                        <div class="mega-menu__column">
                                            <h4><a href="{{route('categories', $secondary->slug)}}">{{ucwords($secondary->name)}}</a><span class="sub-toggle"></span></h4>
                                            <ul class="mega-menu__list">
                                                @foreach($secondary->FinalCategory as $final_cat)
                                                    @php
                                                        $final_cat->name = str_replace("Women's", "", $final_cat->name);
                                                        $final_cat->name = str_replace("Men's", "", $final_cat->name);
                                                    @endphp
                                                    <li class="current-menu-item ">
                                                        <a href="{{ route('categories.sec', [$secondary->slug,$final_cat->slug]) }}">{{ucwords($final_cat->name)}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <h4><a href="{{route('categories', $secondary->slug)}}">{{ucwords($secondary->name)}}</a></h4>
                                    @endif
                                @endforeach
                            </div>
                        </li>
                        @else
                        <li class="current-menu-item "><a href="#">{{$prime->name}}</a></li>
                        @endif
                    @endforeach
                @endif

            </ul>
              </div>
    </div>
    <div class="navigation--list">
      <div class="navigation__content"><a class="navigation__item ps-toggle--sidebar" href="#menu-mobile"><i class="icon-menu"></i><span> Menu</span></a><a class="navigation__item ps-toggle--sidebar" href="#navigation-mobile"><i class="icon-list4"></i><span> Categories</span></a><a class="navigation__item ps-toggle--sidebar" href="#search-sidebar"><i class="icon-magnifier"></i><span> Search</span></a><a class="navigation__item ps-toggle--sidebar" href="#cart-mobile"><i class="icon-bag2"></i><span> Cart</span></a></div>
    </div>
    <div class="ps-panel--sidebar" id="search-sidebar">

        <div class="ps-panel__header">
            <form class="ps-form--search-mobile" action="{{ route('searchProduct') }}" method="GET" autocomplete="off">
            <!-- @csrf -->
               
            <div class="form-group--nest">
                    <input type="hidden" name="category" value="all">
                    <input class="form-control" name="q" id="productSearchMob" value="{{@$query}}" type="text" placeholder="Search something...">
                    <button><i class="icon-magnifier"></i></button>
                </div>

              
            </form>
        </div>
      <div class="navigation__content"></div>
    </div>
    <div class="ps-panel--sidebar" id="menu-mobile">
      <div class="ps-panel__header">
        <h3>Menu</h3>
      </div>
      <div class="ps-panel__content">
                    <ul class="menu--mobile">
                    <li class="current-menu-item "><a href="/">Home</a>
                    </li>
                    <li class="current-menu-item "><a href="{{ url('/shop') }}">Shop</a>
                    </li>
                    <li class="current-menu-item "><a href="{{ url('/about-us') }}">About</a>
                    </li>
                    <li class="current-menu-item "><a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                    </li>
                    
                    </ul>
      </div>
    </div>
  
@endif


  