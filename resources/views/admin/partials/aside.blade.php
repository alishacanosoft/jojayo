<link rel="stylesheet" href="/admin/css/awesomplete.css">
<script src="/admin/js/awesomplete.min.js"></script> <!-- sidebar-->
<style>
    .menu-border-transparent {
        border-color: transparent !important;
        height: 40px;
        color: #a9a3a3;
        background-color: rgba(255, 255, 255, .1);
        /*width: 100%;*/
    }

    input[type="search"]::-webkit-search-cancel-button {
        -webkit-appearance: searchfield-cancel-button;
    }

    .inner-addon {
        position: relative;
    }

    .left-addon .fa {
        left: 0px;
    }

    .inner-addon .fa {
        position: absolute;
        pointer-events: none;
        padding: 13px;
    }

    .left-addon input {
        padding-left: 30px;
    }

</style>
<aside class="aside">
    <!-- START Sidebar (left)-->
    <div class="aside-inner">
        <nav data-sidebar-anyclick-close="" class="sidebar ">
            <!-- START sidebar nav-->
            <ul class="nav">
                <!-- START user info-->
                <li class="has-user-block">
                    <a href="">
                        <div id="user-block" class="block">
                            <div class="item user-block">
                                <!-- User picture-->
                                <div class="user-block-picture">
                                    <div class="user-block-status">
                                        <img src="/uploads/users/{{ \Auth::user()->image }}" alt="Avatar" width="60"
                                            height="60" class="img-thumbnail img-circle">
                                        <div class="circle circle-success circle-lg"></div>
                                    </div>
                                </div>
                                <!-- Name and Job-->
                                <div class="user-block-info">
                                    <span class="user-block-name">{{ \Auth::user()->name }}</span>
                                    <span class="user-block-role"> Online</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>

            <!-- END user info-->
            <div class="inner-addon left-addon" style="width: 95%">
                <i class="fa fa-search"></i>
                <input type="search" id="s-menu" class="form-control menu-border-transparent"
                    placeholder="Search in menu..." />
            </div>
            <br />

            <ul class='nav s-menu '>
                <li class='active'>
                    <a title='Dashboard' href="{{ url('/auth/dashboard') }}">
                        <em class='fa fa-dashboard'></em><span>Dashboard</span></a>
                </li>
                <li class='sub-menu '>
                    <a data-toggle='collapse' href='#stock'> <em class='fa fa-product-hunt'></em><span>Stock
                            Management</span></a>
                    <ul id=stock class='nav s-menu sidebar-subnav collapse'>
                        <li class="sidebar-subnav-header">Stock Management
                        </li>
                        <li class=''>
                            <a title='Items' href="{{ route('products.index') }}">
                                <em class='fa fa-shopping-bag'></em><span>Products</span></a>
                        </li>
                        @if (Auth::user()->admin())
                            <li class=''>
                                <a title='Items' href="{{ route('attributes.index') }}">
                                    <em class='fa fa-shopping-bag'></em><span>Attribute</span></a>
                            </li>
                            <li class=''>
                                <a title='Items' href="{{ route('colors.index') }}">
                                    <em class='fa fa-code'></em><span>Colors</span></a>
                            </li>
                            <li class=''>
                                <a title='Supplier' href="{{ route('primary_categories.index') }}">
                                    <em class='fa fa-sitemap'></em><span>Primary Categories</span></a>
                            </li>
                            <li class=''>
                                <a title='Supplier' href="{{ route('secondary_categories.index') }}">
                                    <em class='fa fa-sitemap'></em><span>Secondary Categories</span></a>
                            </li>
                            <li class=''>
                                <a title='Supplier' href="{{ route('product_categories.index') }}">
                                    <em class='fa fa-sitemap'></em><span>Final Categories</span></a>
                            </li>
                            <li class=''>
                                <a title='Supplier' href="{{ route('brands.index') }}">
                                    <em class='fa fa-globe'></em><span>Brands</span></a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class='sub-menu '>
                        <a data-toggle='collapse' href='#sales'> <em class='fa fa-shopping-basket'></em><span>@if (Auth::user()->admin())Sales &@endif Orders</span></a>
                        <ul id=sales class='nav s-menu sidebar-subnav collapse'>
                            <li class="sidebar-subnav-header">Sales
                            </li>
                            @if (Auth::user()->admin())
                            <li class=''>
                                <a title='Items' href="{{ route('sales.index') }}">
                                    <em class='fa fa-cube'></em><span>All Sales</span></a>
                            </li>
                            @endif
                            <li class=''>
                                <a title='Supplier' href="{{ route('orders.index') }}">
                                    <em class='icon-briefcase'></em><span>All Orders</span></a>
                            </li>
                        </ul>
                    </li>
                @if (Auth::user()->admin())
                    <li class='sub-menu '>
                        <a data-toggle='collapse' href='#officemgm'> <em class='fa fa-building'></em><span>Office Management</span></a>
                        <ul id='officemgm' class='nav s-menu sidebar-subnav collapse'><li class="sidebar-subnav-header">General Management
                            </li>
                            <li class='' >
                                <a  title='Add Category' href="{{ route('office_category.index') }}">
                                    <em class='fa fa-plus'></em><span>Add Category</span></a>
                            </li>
                            <li class='' >
                                <a  title='Voucher List' href="{{ route('office_voucher.index') }}">
                                    <em class='icon-list'></em><span>All Vouchers</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class='sub-menu '>
                        <a data-toggle='collapse' href='#slider'> <em class='fa fa-sliders'></em><span>Slider</span></a>
                        <ul id=slider class='nav s-menu sidebar-subnav collapse'>
                            <li class="sidebar-subnav-header">Slider
                            </li>
                            <li class=''>
                                <a title='Add Slider' href="{{ route('sliders.create') }}">
                                    <em class='fa fa-plus'></em><span>Add new</span></a>
                            </li>
                            <li class=''>
                                <a title='Slider List' href="{{ route('sliders.index') }}">
                                    <em class='icon-list'></em><span>All Slider</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class='sub-menu '>
                        <a data-toggle='collapse' href='#posts'> <em
                                class='fa fa-newspaper-o'></em><span>Posts</span></a>
                        <ul id=posts class='nav s-menu sidebar-subnav collapse'>
                            <li class="sidebar-subnav-header">Posts
                            </li>
                            <li class=''>
                                <a title='Add News' href="{{ route('blogs.create') }}">
                                    <em class='fa fa-plus'></em><span>Add new</span></a>
                            </li>
                            <li class=''>
                                <a title='News List' href="{{ route('blogs.index') }}">
                                    <em class='icon-list'></em><span>All Post</span></a>
                            </li>
                            <li class=''>
                                <a title='News Categories' href="{{ route('category.index') }}">
                                    <em class='fa fa-sitemap'></em><span>Categories</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class='sub-menu '>
                        <a data-toggle='collapse' href='#page'> <em
                                class='fa fa-newspaper-o'></em><span>Pages</span></a>
                        <ul id=page class='nav s-menu sidebar-subnav collapse'>
                            <li class="sidebar-subnav-header">Pages
                            </li>
                            <li class=''>
                                <a title='Add News' href="{{ route('page.create') }}">
                                    <em class='fa fa-plus'></em><span>Add new</span></a>
                            </li>
                            <li class=''>
                                <a title='News List' href="{{ route('page.index') }}">
                                    <em class='icon-list'></em><span>All Pages</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class='sub-menu '>
                        <a data-toggle='collapse' href='#user'> <em class='fa fa-users'></em><span>Users</span></a>
                        <ul id=user class='nav s-menu sidebar-subnav collapse'>
                            <li class="sidebar-subnav-header">Users
                            </li>
                            <li class=''>
                                <a title='Add User' href="{{ route('users.create') }}">
                                    <em class='fa fa-plus'></em><span>Add new</span></a>
                            </li>
                            <li class=''>
                                <a title='List User' href="{{ route('users.index') }}">
                                    <em class='icon-list'></em><span>All users</span></a>
                            </li>
                        </ul>
                    </li>
                    <!--<li class=''>-->
                    <!--    <a title='Purchase Management' href="{{ url('/admin/expenses') }}">-->
                    <!--        <em class='fa fa-briefcase'></em><span>Purchase Management</span></a>-->
                    <!--</li>-->
                    <li class='sub-menu '>
                        <a data-toggle='collapse' href='#ads'> <em class='fa fa-money'></em><span>Ads</span></a>
                        <ul id=ads class='nav s-menu sidebar-subnav collapse'>
                            <li class="sidebar-subnav-header">Ads
                            </li>
                            <li class=''>
                                <a title='Ads' href="{{ route('ads.create') }}">
                                    <em class='fa fa-plus'></em><span>Add new</span></a>
                            </li>
                            <li class=''>
                                <a title='Ads' href="{{ route('ads.index') }}">
                                    <em class='icon-list'></em><span>All Ads</span></a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class='sub-menu '>
                        <a data-toggle='collapse' href='#payment'> <em class='fa fa-bank'></em><span>Payment</span></a>
                        <ul id=payment class='nav s-menu sidebar-subnav collapse'>
                            <li class="sidebar-subnav-header">Payment
                            </li>
                            <li class=''>
                                <a title='Supplier' href="{{ route('payments.index') }}">
                                    <em class='icon-briefcase'></em><span>Payment Methods</span></a>
                            </li>                            
                        </ul>
                    </li>
                    <li class='sub-menu '>
                        <a data-toggle='collapse' href='#locations'> <em class='fa fa-map'></em><span>Delivery
                                locations</span></a>
                        <ul id=locations class='nav s-menu sidebar-subnav collapse'>
                            <li class="sidebar-subnav-header">Delivery locations
                            </li>
                            <li class=''>
                                <a title='Items' href="{{ route('cities.index') }}">
                                    <em class='fa fa-cube'></em><span>Cities</span></a>
                            </li>
                            <li class=''>
                                <a title='Supplier' href="{{ route('areas.index') }}">
                                    <em class='icon-briefcase'></em><span>Areas</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class=''>
                        <a title='Settings' href="{{ url('/auth/media') }}">
                            <em class='fa fa-upload'></em><span>File Manager</span></a>
                    </li>
                    <li class=''>
                        <a title='Settings' href="{{ route('settings.index') }}">
                            <em class='fa fa-cogs'></em><span>Settings</span></a>
                    </li>

                    <li class=''>
                        <a title='Recycle' href="{{ route('products.trash') }}">
                            <em class='fa fa-trash'></em><span>Recycle</span></a>
                    </li>
                @endif
                
                <li class='sub-menu '>
                <a data-toggle='collapse' href='#finance'> <em class='fa fa-map'></em><span>Finance<span></a>
                <ul id=finance class='nav s-menu sidebar-subnav collapse'>
                    <li class="sidebar-subnav-header">Finance
                    </li>
                    <li class=''>
                        <a title='Items' href="/auth/finance/account-statement">
                            <em class='fa fa-money'></em><span>Account Statement</span></a>
                    </li>
                    @if (Auth::user()->admin())
                    <li class=''>
                        <a title='Supplier' href="{{ route('transaction') }}"><em class='icon-briefcase'></em><span>Transaction</span></a>
                    </li>
                    @endif
                </ul>
            </li>
            </ul>
            </ul>
            <!-- Iterates over all sidebar items-->
            <!-- END sidebar nav-->
        </nav>
    </div>
    <!-- END Sidebar (left)-->
</aside>
<!-- offsidebar-->
<style type="text/css">
    .offsidebar {
        background-color: #1e1e2d
    }
</style>
<aside class="offsidebar hide">
    <!-- START Off Sidebar (right)-->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" style="background:none;" id="control-sidebar-home-tab">
            <h2 style="color: #EFF3F4;font-weight: 100;text-align: center;">Sunday<br />31st May, 2020</h2>
            <div id="idCalculadora"></div>
        </div><!-- /.tab-pane -->
    </div>
    <!-- END Off Sidebar (right)-->
</aside>
<!-- Page content-->
<section>
    <div class="content-wrapper">
        <div class="content-heading">
            @php
            $segment = str_replace('_', ' ', ucfirst(Request::segment('3')));
            if($segment == null || is_numeric($segment)){
            $segment = str_replace('_', ' ', ucfirst(Request::segment('2')));
            }
            if($segment == null){
            $segment = str_replace('_', ' ', ucfirst(Request::segment('1')));
            }
            @endphp
            <a class='text-muted' href=''>{{ $segment }}</a>
            <div class="pull-right">
            <small class="text-sm">
           &nbsp; {{ date('l jS F', strtotime(date('Y-m-d'))) }} - {{ date('Y') }}, &nbsp;Time &nbsp;<span id="txt"></span></small>                        
            </div>
        </div>
