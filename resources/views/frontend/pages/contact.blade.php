@extends('frontend.layouts.master')
@section('content')

<div class="ps-page--single" id="contact-us">
      <div class="ps-breadcrumb">
        <div class="container">
          <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>
            <li>Contact Us</li>
          </ul>
        </div>
      </div>
      <div class="ps-contact-info">
        <div class="container">
          <div class="ps-section__header">
            <h3>Contact Us For Any Questions</h3>
          </div>
          <div class="ps-section__content">
            <div class="row">
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                            <div class="ps-block--contact-info">
                              <h4>Contact Directly</h4>
                              <p><a href="mailto:{{$sensitive_data->email}}"><span class="__cf_email__" >{{$sensitive_data->email}}</span></a>
                              <span>
                              <a href="tel:{{$sensitive_data->mobile1}}">{{$sensitive_data->mobile1}}</a></span></p>
                            </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                            <div class="ps-block--contact-info">
                              <h4>Head Quater</h4>
                              <p><a href="tel:{{$sensitive_data->mobile}}">{{$sensitive_data->mobile}}</a></span>
                            <span>{{ $sensitive_data->location }}</span></p>

                            </div>
                          </div>
                          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                            <div class="ps-block--contact-info">
                              <h4>Work With Us</h4>
                              <p><span>Send your CV to our email:</span><a href="mailto:{{$sensitive_data->email}}"><span class="__cf_email__">{{$sensitive_data->email}}</span></a></p>
                            </div>
                          </div>
                   
            </div>
          </div>
        </div>
      </div>
      <div class="ps-contact-form">
        <div class="container">
          <form class="ps-form--contact-us" action="#" method="POST">
            <h3>Get In Touch</h3>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                <div class="form-group">
                    <input class="form-control" type="text" name="fullname" placeholder="Full Name *">
                </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="Email *">
                </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <input class="form-control" type="text" name="subject" placeholder="Subject *">
                </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                    <textarea class="form-control" rows="5" name="message" placeholder="Message"></textarea>
                </div>
                </div>
            </div>
            <div class="form-group submit">
              <button class="ps-btn" type="submit">Send message</button>
            </div>
          </form>
        </div>
      </div>
</div>
@endsection