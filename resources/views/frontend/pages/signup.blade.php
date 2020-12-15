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
      <div class="login">
          <div class="login-title">
              <h3 class="text-center">Welcome to Jojayo! Please sign up to purchase.</h3>
          </div>
          <div>
              <form action="{{ route('customerSignUp') }}" method="POST">
                @csrf
                  <div class="mod-login">
                      <div class="row">
                        <div class="col-lg-10 offset-lg-1 col-md-10 offset-md-1 col-sm-12">
                          <div class="mod-login-col1">
                              <div class="form-group row">
                                  <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label for="login-email">Email address <span class="required">*</span></label>
                                    <input type="email" name="email" class="form-input form-wide" id="login-email" required="">
                                    <div class="mod-input-close-icon"></div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label for="login-password">Contact <span class="required">*</span></label>
                                    <input type="contact" name="contact" class="form-input form-wide" id="login-password" required="">
                                    @if ($errors->has('contact'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('contact') }}</strong>
                                        </span>
                                    @endif
                                    <div class="mod-input-close-icon"></div>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label for="login-password">Password <span class="required">*</span></label>
                                    <input type="password" name="password" class="form-input form-wide" id="login-password" required="">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    <div class="mod-input-close-icon"></div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label for="login-password">Confirm Password <span class="required">*</span></label>
                                    <input type="password" name="confirm" class="form-input form-wide" id="login-password" required="">
                                    @if ($errors->has('confirm'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('confirm') }}</strong>
                                        </span>
                                    @endif
                                    <div class="mod-input-close-icon"></div>
                                  </div>
                              </div>
                              <div class="form-group row justify-content-center">
                                <button type="submit" class="btn btn-primary btn-md">Sign Up</button>
                              </div>
                              <div class="mod-login-forgot text-center">Already a member?<a href="{{ route('signinform') }}"> Sign In</a></div>
                          </div>
                        </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
