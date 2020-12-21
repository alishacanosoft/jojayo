@php
$title = Request::segment(1);
@endphp

<div class="col-lg-4">
    <div class="ps-section__left">
        <aside class="ps-widget--account-dashboard">
            <div class="ps-widget__header"><img src="{{ Auth::user()->image ? asset('/uploads/users/'.Auth::user()->image) : asset('/images/dummy.jpg')}}" alt="{{ Auth::user()->name }}">
            <figure>
                <figcaption>{{ ucwords(Auth::user()->name) }}</figcaption>
                <p><a href="mailto:{{ $sensitive_data->email }}"><span class="__cf_email__">{{ Auth::user()->email }}</span></a></p>
            </figure>
            </div>
            <div class="ps-widget__content">
            <ul>
                <li @if(@$title == 'dashboard') class="active" @endif><a href="{{ url('/dashboard') }}"><i class="icon-home"></i> Account Dashboard</a></li>
                <li @if(@$title == 'account-information') class="active" @endif><a href="{{ url('/account-information') }}"><i class="icon-user"></i> Account Information</a></li>
                <li @if(@$title == 'address-book' || @$title == 'add-address') class="active" @endif><a href="{{ url('/address-book') }}"><i class="icon-map-marker"></i>Address Book</a></li>
                <li @if(@$title == 'my-orders') class="active" @endif><a href="{{url('/my-orders')}}"><i class="icon-papers"></i> My Orders</a></li>
                <li  @if(@$title == 'my-reviews') class="active" @endif><a href="#"><i class="icon-store"></i>My Product Reviews</a></li>
                <li  @if(@$title == 'my-wishlist') class="active" @endif><a href="{{url('/my-wishlist')}}"><i class="icon-heart"></i> Wishlist</a></li>
                <li><a href="{{ route('logout') }}"><i class="icon-power-switch"></i>Logout</a></li>
            </ul>
            </div>
        </aside>
    </div>
</div>


