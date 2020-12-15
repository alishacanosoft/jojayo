@php
$title = Request::segment(1);
@endphp
<aside class="sidebar col-lg-3">
    <div class="widget widget-dashboard">
        <h3 class="widget-title">My Account</h3>
        <ul class="list">
            <li @if(@$title == 'dashboard') class="active" @endif><a href="{{ url('/dashboard') }}">Account Dashboard</a></li>
            <li @if(@$title == 'account-information') class="active" @endif><a href="{{ url('/account-information') }}">Account Information</a></li>
            <li @if(@$title == 'address-book' || @$title == 'add-address') class="active" @endif><a href="{{ url('/address-book') }}">Address Book</a></li>
            <li @if(@$title == 'my-orders') class="active" @endif><a href="/my-orders">My Orders</a></li>
            <li @if(@$title == 'my-reviews') class="active" @endif><a href="#">My Product Reviews</a></li>
        </ul>
    </div><!-- End .widget -->
</aside><!-- End .col-lg-3 -->
