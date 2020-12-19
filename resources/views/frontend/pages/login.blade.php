@extends('frontend.layouts.master')
@section('content')


     
  

    <div class="ps-my-account">        
        <div class="ps-form--account ps-tab-root">
            <ul class="ps-tab-list">
                <li class="active"><a href="#sign-in">Login</a></li>
                <li class=""><a href="#register">Register</a></li>
            </ul>
            <div class="ps-tabs">
                 @if(Session::has('warning'))
                <br>
                <div class="alert alert-warning alert-intro" role="alert">
                    {{ Session::get('warning') }}
                </div>
                @endif
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
                            <button type="submit" class="ps-btn ps-btn--fullwidth">Register</button>
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

    <div class="related-products"></div>


@endsection
