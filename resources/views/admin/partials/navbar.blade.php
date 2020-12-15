<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="{{ url('/admin/dashboard') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-image"></i></span>
                    <span class="pcoded-mtext">Sliders</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" pcoded-hasmenu">
                        <li class="">
                            <a href="{{--{{ route('sliders.create') }}--}}">
                                <span class="pcoded-mtext">Add New</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{--{{ route('sliders.index') }}--}}">
                                <span class="pcoded-mtext">Sliders</span>
                            </a>
                        </li>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-edit-1"></i></span>
                    <span class="pcoded-mtext">Posts</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" pcoded-hasmenu">
                        <li class="">
                            <a href="{{ route('blogs.create') }}">
                                <span class="pcoded-mtext">Add New</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('blogs.index') }}">
                                <span class="pcoded-mtext">posts</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('category.index') }}">
                                <span class="pcoded-mtext">categories</span>
                            </a>
                        </li>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="icofont icofont-layers"></i></span>
                    <span class="pcoded-mtext">Stock Mgmt</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="{{ route('products.create') }}">
                            <span class="pcoded-mtext">Add New</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('products.index') }}">
                            <span class="pcoded-mtext">Products</span>
                        </a>
                    </li>
                    <li class=" pcoded-hasmenu">
                        <li class="pcoded-hasmenu pcoded-trigger" dropdown-icon="style1" subitem-icon="style1">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext">Categories</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ route('primary_categories.index') }}">
                                        <span class="pcoded-mtext">Primary</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('secondary_categories.index') }}">
                                        <span class="pcoded-mtext">Secondary</span>
                                    </a>
                                </li>

                                <li class="pcoded-hasmenu pcoded-trigger" dropdown-icon="style1" subitem-icon="style1">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-mtext">Final category</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="second">
                                            <a href="{{ route('product_categories.create') }}">
                                                <span class="pcoded-mtext">Add new</span>
                                            </a>
                                        </li>
                                        <li class="second">
                                            <a href="{{ route('product_categories.index') }}">
                                                <span class="pcoded-mtext">All Categories</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                    </li>
                    <li class="">
                        <a href="{{ route('brands.index') }}">
                            <span class="pcoded-mtext">Brands</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="">
                <a href="{{ url('/admin/media') }}">
                    <span class="pcoded-micon"><i class="feather icon-upload-cloud"></i></span>
                    <span class="pcoded-mtext">File Upload</span>
                </a>
            </li>
            <li class="">
                <a href="{{--{{ route('popups.create') }}--}}">
                    <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                    <span class="pcoded-mtext">Pop up</span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Users</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" pcoded-hasmenu">
                        <li class="">
                            <a href="{{ route('users.create') }}">
                                <span class="pcoded-mtext">Add New</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('users.index') }}">
                                <span class="pcoded-mtext">users</span>
                            </a>
                        </li>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="icofont icofont-deal"></i></span>
                    <span class="pcoded-mtext">Advertisement</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="{{ route('ads.index') }}">
                            <span class="pcoded-mtext">Add New</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('ads.index') }}">
                            <span class="pcoded-mtext">All ads</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="{{ url('/admin/expenses') }}">
                    <span class="pcoded-micon"><i class="icofont icofont-money"></i></span>
                    <span class="pcoded-mtext">Purchase Mgmt</span>
                </a>
            </li>

            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="icofont icofont-chart-histogram"></i></span>
                    <span class="pcoded-mtext">Sales</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" pcoded-hasmenu">
                        <li class="">
                            <a href="{{ route('sales.create') }}">
                                <span class="pcoded-mtext">Add New</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="{{ route('sales.index') }}">
                                <span class="pcoded-mtext">sales</span>
                            </a>
                        </li>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="icofont icofont-university"></i></span>
                    <span class="pcoded-mtext">Account details</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" pcoded-hasmenu">
                        <li class="">
                            <a href="{{ route('payments.index') }}">
                                <span class="pcoded-mtext">Payment methods</span>
                            </a>
                        </li>
                    </li>
                    <li class=" pcoded-hasmenu">
                        <li class="pcoded-hasmenu pcoded-trigger" dropdown-icon="style1" subitem-icon="style1">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext">Accounts</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ route('accounts.create') }}">
                                        <span class="pcoded-mtext">Add new</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('accounts.index') }}">
                                        <span class="pcoded-mtext">All accounts</span>
                                    </a>
                                </li>

                                >
                            </ul>
                        </li>

                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="icofont icofont-location-pin"></i></span>
                    <span class="pcoded-mtext">Delivery locations</span>
                </a>
                <ul class="pcoded-submenu">

                    <li class=" pcoded-hasmenu">
                        <li class="pcoded-hasmenu pcoded-trigger" dropdown-icon="style1" subitem-icon="style1">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext">Cities</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ route('cities.create') }}">
                                        <span class="pcoded-mtext">Add new</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('cities.index') }}">
                                        <span class="pcoded-mtext">All Cities</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </li>
                    <li class=" pcoded-hasmenu">
                        <li class="pcoded-hasmenu pcoded-trigger" dropdown-icon="style1" subitem-icon="style1">
                            <a href="javascript:void(0)">
                                <span class="pcoded-mtext">Areas</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ route('areas.create') }}">
                                        <span class="pcoded-mtext">Add New</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('areas.index') }}">
                                        <span class="pcoded-mtext">All areas</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="{{ route('settings.index') }}">
                    <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                    <span class="pcoded-mtext">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
