@extends('frontend.layouts.master')
@section('content')
<main class="ps-page--my-account">
            @include('frontend.layouts.front-nav')
            @include('frontend.layouts.customer-nav')
            <div class="col-lg-8">
                <div class="ps-section__right">
                    @if(session()->has('success'))
                    {{frontSuccess()}}
                    @elseif(session()->has('warning'))
                        {{frontWarning()}}
                    @elseif(session()->has('error'))
                        {{frontError()}}
                    @endif
                        <div class="ps-block--vendor-dashboard">
                            <div class="ps-block__header">
                            <h3>Recent Orders</h3>
                            </div>
                            <div class="ps-block__content">
                                <div class="table-responsive">
                                    <table class="table ps-table ps-table--vendor">
                                    <thead>
                                        <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Shipping</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Information</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <td>Nov 4, 2019</td>
                                        <td><a href="#">MS46891357</a></td>
                                        <td>NRP 00.00</td>
                                        <td>NRP 295.47</td>
                                        <td><a href="#">Open</a></td>
                                        <td><a href="#">View Detail</a></td>
                                        </tr>
                                        <tr>
                                        <td>Nov 2, 2017</td>
                                        <td><a href="#">AP47305441</a></td>
                                        <td>NRP 00.00</td>
                                        <td>NRP 25.47</td>
                                        <td>Close</td>
                                        <td><a href="#">View Detail</a></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</section>
</main>
@endsection
