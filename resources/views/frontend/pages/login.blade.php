@extends('frontend.layouts.master')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-9 offset-lg-2 col-md-9 offset-md-2">

      @if(Session::has('warning'))
      <br>
      <div class="alert alert-warning alert-intro" role="alert">
          {{ Session::get('warning') }}
      </div>
      @endif
      <!-- <div class="login">
          <div class="login-title">
              <h3 class="text-center">Welcome to Jojayo! Please login to purchase.</h3>
          </div>
          <div>
              <form action="{{ route('customerlogin') }}" method="POST">
                @csrf
                  <div class="mod-login">
                      <div class="row">
                        <div class="col-lg-6 offset-lg-1 col-md-6 offset-md-1 col-sm-12">
                          <div class="mod-login-col1">
                              <div class="form-group row">
                                  <label for="login-email">Email address <span class="required">*</span></label>
                                  <input type="email" name="email" class="form-input form-wide" id="login-email" required="">
                                  <div class="mod-input-close-icon"></div>
                                  @if (Session::has('email'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ Session::get('email') }}</strong>
                                      </span>
                                  @endif
                              </div>
                              <div class="form-group row">
                                  <label for="login-password">Password <span class="required">*</span></label>
                                  <input type="password" name="password" class="form-input form-wide" id="login-password" required="">
                                  @if (Session::has('password'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ Session::get('password') }}</strong>
                                      </span>
                                  @endif
                                  <div class="mod-input-close-icon"></div>
                              </div>
                              <div class="form-group row justify-content-center">
                                <button type="submit" class="btn btn-primary btn-md">LOGIN</button>
                              </div>
                              <div class="mod-login-forgot text-center"><a href="https://member.daraz.com.np/user/forget-password">Forgot Password?</a></div>
                          </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                          <div class="mod-login-col2 text-center">
                            <label for="login-password"></label>
                              <div class="login-other"><span>New member? <a href="{{ route('signupform') }}">Register</a> here. <br> Or <br> Login with </span></div>
                              <br>
                              <a href="{{ url('/login/facebook') }}" class="btn  btn-facebook btn-md"><i class="icon-facebook"></i> Facebook</a> <br>
                              <a href="{{ url('/login/google') }}" class="mt-1 btn btn-primary btn-md"><i class="icon-gplus"></i>&nbsp; Google Mail</a>
                          </div>
                        </div>
                      </div>
                  </div>
              </form>
          </div>
      </div> -->

      <!-- <div class="ps-form--account ps-tab-root">
        @csrf
          <ul class="ps-tab-list">
              <li class="active"><a href="#sign-in">Login</a></li>
              <li><a href="#register">Register</a></li>
          </ul>
          <div class="ps-tabs">
              <form action="{{ route('customerlogin') }}" method="POST">
                @csrf
                <div class="ps-tab active" id="sign-in">
                    <div class="ps-form__content">
                        <h5>Log In Your Account</h5>
                        <div class="form-group">
                            <input class="form-control" type="text" name="email" placeholder="Username or email address">
                            @if (Session::has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ Session::get('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group form-forgot">
                            <input class="form-control" type="password" name="password" placeholder="Password"><a href="#">Forgot?</a>
                            @if (Session::has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ Session::get('password') }}</strong>
                                </span>
                            @endif
                        </div>                      
                        <div class="form-group submtit">
                            <button type="submit" class="ps-btn ps-btn--fullwidth">Login</button>
                        </div>
                    </div>
                    <div class="ps-form__footer">
                        <p>Connect with:</p>
                        <ul class="ps-list--social">
                            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="google" href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
              </form>
              <div class="ps-tab" id="register">
                  <div class="ps-form__content">
                      <h5>Register An Account</h5>
                      <div class="form-group">
                          <input class="form-control" type="text" placeholder="Username or email address">
                      </div>
                      <div class="form-group">
                          <input class="form-control" type="text" placeholder="Password">
                      </div>
                      <div class="form-group submtit">
                          <button class="ps-btn ps-btn--fullwidth">Login</button>
                      </div>
                  </div>
                  <div class="ps-form__footer">
                      <p>Connect with:</p>
                      <ul class="ps-list--social">
                          <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                          <li><a class="google" href="#"><i class="fa fa-google-plus"></i></a></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div> -->

    <div class="ps-my-account">        
        <div class="ps-form--account ps-tab-root">
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
    </div><br>

    </div>
  </div>
</div>
@endsection
