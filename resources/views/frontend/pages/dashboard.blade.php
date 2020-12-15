@extends('frontend.layouts.master')
@section('content')
@include('frontend.layouts.front-nav')
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Contact Information
                            <a href="#" class="card-edit">Edit</a>
                        </div><!-- End .card-header -->

                        <div class="card-body">
                            <p>
                                John Doe<br>
                                porto_shop@gmail.com<br>
                                <a href="#">Change Password</a>
                            </p>
                        </div><!-- End .card-body -->
                    </div><!-- End .card -->
                </div><!-- End .col-md-6 -->

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            newsletters
                            <a href="#" class="card-edit">Edit</a>
                        </div><!-- End .card-header -->

                        <div class="card-body">
                            <p>
                                You are currently not subscribed to any newsletter.
                            </p>
                        </div><!-- End .card-body -->
                    </div><!-- End .card -->
                </div><!-- End .col-md-6 -->
            </div><!-- End .row -->

            <div class="card">
                <div class="card-header">
                    Address Book
                    <a href="#" class="card-edit">Edit</a>
                </div><!-- End .card-header -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="">Default Billing Address</h4>
                            <address>
                                You have not set a default billing address.<br>
                                <a href="#">Edit Address</a>
                            </address>
                        </div>
                        <div class="col-md-6">
                            <h4 class="">Default Shipping Address</h4>
                            <address>
                                You have not set a default shipping address.<br>
                                <a href="#">Edit Address</a>
                            </address>
                        </div>
                    </div>
                </div><!-- End .card-body -->
            </div><!-- End .card -->
        </div><!-- End .col-lg-9 -->
        @include('frontend.layouts.customer-nav')
    </div><!-- End .row -->
</div><!-- End .container -->

<div class="mb-5"></div><!-- margin -->
@endsection
