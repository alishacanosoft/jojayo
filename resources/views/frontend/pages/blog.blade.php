@extends('frontend.layouts.master') @section('content')
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blog Post</li>
        </ol>
    </div>
    <!-- End .container -->
</nav>
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <article class="entry single">
                <div class="entry-media">
                    <div class="entry-slider owl-carousel owl-theme owl-loaded owl-drag">
                        <div class="owl-stage-outer">
                            <div class="owl-stage" style="transform: translate3d(-2616px, 0px, 0px); transition: all 0.25s ease 0s; width: 6104px;">
                                <div class="owl-item cloned" style="width: 870px; margin-right: 2px;"><img src="{{ asset('/frontend/images/blog/post-2.jpg') }}" alt="Post"></div>
                                <div class="owl-item cloned" style="width: 870px; margin-right: 2px;"><img src="{{ asset('/frontend/images/blog/post-3.jpg') }}" alt="Post"></div>
                                <div class="owl-item" style="width: 870px; margin-right: 2px;"><img src="{{ asset('/frontend/images/blog/post-1.jpg') }}" alt="Post"></div>
                                <div class="owl-item active" style="width: 870px; margin-right: 2px;"><img src="{{ asset('/frontend/images/blog/post-2.jpg') }}" alt="Post"></div>
                                <div class="owl-item" style="width: 870px; margin-right: 2px;"><img src="{{ asset('/frontend/images/blog/post-3.jpg') }}" alt="Post"></div>
                                <div class="owl-item cloned" style="width: 870px; margin-right: 2px;"><img src="{{ asset('/frontend/images/blog/post-1.jpg') }}" alt="Post"></div>
                                <div class="owl-item cloned" style="width: 870px; margin-right: 2px;"><img src="{{ asset('/frontend/images/blog/post-2.jpg') }}" alt="Post"></div>
                            </div>
                        </div>
                        <div class="owl-nav disabled">
                            <button type="button" role="presentation" class="owl-prev"><i class="icon-left-open-big"></i></button>
                            <button type="button" role="presentation" class="owl-next"><i class="icon-right-open-big"></i></button>
                        </div>
                        <div class="owl-dots">
                            <button role="button" class="owl-dot"><span></span></button>
                            <button role="button" class="owl-dot active"><span></span></button>
                            <button role="button" class="owl-dot"><span></span></button>
                        </div>
                    </div>
                    <!-- End .entry-slider -->
                </div>
                <!-- End .entry-media -->

                <div class="entry-body">
                    <div class="entry-date">
                        <span class="day">22</span>
                        <span class="month">Jun</span>
                    </div>
                    <!-- End .entry-date -->

                    <h2 class="entry-title">
                        Post Format - Image Gallery
                    </h2>

                    <div class="entry-meta">
                        <span><i class="icon-calendar"></i>June 22, 2018</span>
                        <span><i class="icon-user"></i>By <a href="#">Admin</a></span>
                        <span><i class="icon-folder-open"></i>
                            <a href="#">Haircuts &amp; hairstyles</a>,
                            <a href="#">Fashion trends</a>,
                            <a href="#">Accessories</a>
                        </span>
                    </div>
                    <!-- End .entry-meta -->

                    <div class="entry-content">
                        <p>Euismod atras vulputate iltricies etri elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla nunc dui, tristique in semper vel, congue sed ligula.</p>
                        <p>Nam dolor ligula, faucibus id sodales in, auctor fringilla libero. Pellentesque pellentesque tempor tellus eget hendrerit. Morbi id aliquam ligula. Aliquam id dui sem. Proin rhoncus consequat nisl, eu ornare mauris tincidunt vitae. Nulla aliquet turpis eget sodales scelerisque. Ut accumsan rhoncus sapien a dignissim. Sed vel ipsum nunc. Aliquam erat volutpat. Donec et dignissim elit. Etiam condimentum, ante sed rutrum auctor, quam arcu consequat massa, at gravida enim velit id nisl.</p>
                        <p>Nullam non felis odio. Praesent aliquam magna est, nec volutpat quam aliquet non. Cras ut lobortis massa, a fringilla dolor. Quisque ornare est at felis consectetur mollis. Aliquam vitae metus et enim posuere ornare. Praesent sapien erat, pellentesque quis sollicitudin eget, imperdiet bibendum magna. Aenean sit amet odio est.</p>
                        <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris quis est lobortis odio dignissim rutrum. Pellentesque blandit lacinia diam, a tincidunt felis tempus eget.</p>
                        <p>Donec egestas metus non vehicula accumsan. Pellentesque sit amet tempor nibh. Mauris in risus lorem. Cras malesuada gravida massa eget viverra. Suspendisse vitae dolor erat. Morbi id rhoncus enim. In hac habitasse platea dictumst. Aenean lorem diam, venenatis nec venenatis id, adipiscing ac massa. Nam vel dui eget justo dictum pretium a rhoncus ipsum. Donec venenatis erat tincidunt nunc suscipit, sit amet bibendum lacus posuere. Sed scelerisque, dolor a pharetra sodales, mi augue consequat sapien, et interdum tellus leo et nunc. Nunc imperdiet eu libero ut imperdiet.</p>
                        <p>Nunc varius ornare tortor. In dignissim quam eget quam sodales egestas. Nullam imperdiet velit feugiat, egestas risus nec, rhoncus felis. Suspendisse sagittis enim aliquet augue consequat facilisis. Nunc sit amet eleifend tellus. Etiam rhoncus turpis quam. Vestibulum eu lacus mattis, dignissim justo vel, fermentum nulla. Donec pharetra augue eget diam dictum, eu ullamcorper arcu feugiat.</p>
                        <p>Proin ut ante vitae magna cursus porta. Aenean rutrum faucibus augue eu convallis. Phasellus condimentum elit id cursus sodales. Vivamus nec est consectetur, tincidunt augue at, tempor libero.</p>
                    </div>
                    <!-- End .entry-content -->

                    <div class="entry-share">
                        <h3>
                            <i class="icon-forward"></i>
                            Share this post
                        </h3>

                        <div class="social-icons">
                            <a href="#" class="social-icon social-facebook" target="_blank" title="Facebook">
                                <i class="icon-facebook"></i>
                            </a>
                            <a href="#" class="social-icon social-twitter" target="_blank" title="Twitter">
                                <i class="icon-twitter"></i>
                            </a>
                            <a href="#" class="social-icon social-linkedin" target="_blank" title="Linkedin">
                                <i class="icon-linkedin"></i>
                            </a>
                            <a href="#" class="social-icon social-gplus" target="_blank" title="Google +">
                                <i class="icon-gplus"></i>
                            </a>
                            <a href="#" class="social-icon social-mail" target="_blank" title="Email">
                                <i class="icon-mail-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </article>

            <div class="related-posts">
                <h4 class="light-title">Related <strong>Posts</strong></h4>
                <div class="owl-carousel owl-theme related-posts-carousel owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1200px;">
                            <div class="owl-item active" style="width: 270px; margin-right: 30px;">
                                <article class="entry">
                                    <div class="entry-media">
                                        <a href="single.html">
                                            <img src="{{ asset('/frontend/images/blog/related/post-1.jpg') }}" alt="Post">
                                        </a>
                                    </div>
                                    <!-- End .entry-media -->

                                    <div class="entry-body">
                                        <div class="entry-date">
                                            <span class="day">29</span>
                                            <span class="month">Jun</span>
                                        </div>
                                        <!-- End .entry-date -->

                                        <h2 class="entry-title">
                                            <a href="single.html">Post Format - Image</a>
                                        </h2>

                                        <div class="entry-content">
                                            <p>Euismod atras vulputate iltricies etri elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per incep tos himens.</p>

                                            <a href="single.html" class="read-more">Read More <i class="icon-angle-double-right"></i></a>
                                        </div>
                                        <!-- End .entry-content -->
                                    </div>
                                    <!-- End .entry-body -->
                                </article>
                            </div>
                            <div class="owl-item active" style="width: 270px; margin-right: 30px;">
                                <article class="entry">
                                    <div class="entry-media">
                                        <a href="single.html">
                                            <img src="{{ asset('/frontend/images/blog/related/post-2.jpg') }}" alt="Post">
                                        </a>
                                    </div>
                                    <!-- End .entry-media -->

                                    <div class="entry-body">
                                        <div class="entry-date">
                                            <span class="day">23</span>
                                            <span class="month">Mar</span>
                                        </div>
                                        <!-- End .entry-date -->

                                        <h2 class="entry-title">
                                            <a href="single.html">Post Format - Image</a>
                                        </h2>

                                        <div class="entry-content">
                                            <p>Euismod atras vulputate iltricies etri elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per incep tos himens.</p>

                                            <a href="single.html" class="read-more">Read More <i class="icon-angle-double-right"></i></a>
                                        </div>
                                        <!-- End .entry-content -->
                                    </div>
                                    <!-- End .entry-body -->
                                </article>
                            </div>
                            <div class="owl-item active" style="width: 270px; margin-right: 30px;">
                                <article class="entry">
                                    <div class="entry-media">
                                        <a href="single.html">
                                            <img src="{{ asset('/frontend/images/blog/related/post-3.jpg') }}" alt="Post">
                                        </a>
                                    </div>
                                    <!-- End .entry-media -->

                                    <div class="entry-body">
                                        <div class="entry-date">
                                            <span class="day">14</span>
                                            <span class="month">May</span>
                                        </div>
                                        <!-- End .entry-date -->

                                        <h2 class="entry-title">
                                <a href="single.html">Post Format - Image</a>
                            </h2>

                                        <div class="entry-content">
                                            <p>Euismod atras vulputate iltricies etri elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per incep tos himens.</p>

                                            <a href="single.html" class="read-more">Read More <i class="icon-angle-double-right"></i></a>
                                        </div>
                                        <!-- End .entry-content -->
                                    </div>
                                    <!-- End .entry-body -->
                                </article>
                            </div>
                            <div class="owl-item" style="width: 270px; margin-right: 30px;">
                                <article class="entry">
                                    <div class="entry-media">
                                        <a href="single.html">
                                            <img src="{{ asset('/frontend/images/blog/related/post-1.jpg') }}" alt="Post">
                                        </a>
                                    </div>
                                    <!-- End .entry-media -->

                                    <div class="entry-body">
                                        <div class="entry-date">
                                            <span class="day">11</span>
                                            <span class="month">Apr</span>
                                        </div>
                                        <!-- End .entry-date -->

                                        <h2 class="entry-title">
                                <a href="single.html">Post Format - Image</a>
                            </h2>

                                        <div class="entry-content">
                                            <p>Euismod atras vulputate iltricies etri elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per incep tos himens.</p>

                                            <a href="single.html" class="read-more">Read More <i class="icon-angle-double-right"></i></a>
                                        </div>
                                        <!-- End .entry-content -->
                                    </div>
                                    <!-- End .entry-body -->
                                </article>
                            </div>
                        </div>
                    </div>
                    <div class="owl-nav disabled">
                        <button type="button" role="presentation" class="owl-prev"><i class="icon-left-open-big"></i></button>
                        <button type="button" role="presentation" class="owl-next"><i class="icon-right-open-big"></i></button>
                    </div>
                </div>
                <!-- End .owl-carousel -->
            </div>
            <!-- End .related-posts -->
        </div>
        <!-- End .col-lg-9 -->

        <aside class="sidebar col-lg-3">
            <div class="pin-wrapper" style="height: 883.656px;">
                <div class="sidebar-wrapper" style="border-bottom: 0px none rgb(118, 127, 132); width: 270px;">
                    <div class="widget widget-search">
                        <form role="search" method="get" class="search-form" action="#">
                            <input type="search" class="form-control" placeholder="Search posts here..." name="s" required="">
                            <button type="submit" class="search-submit" title="Search">
                                <i class="icon-search"></i>
                                <span class="sr-only">Search</span>
                            </button>
                        </form>
                    </div>
                    <!-- End .widget -->

                    <div class="widget widget-categories">
                        <h4 class="widget-title">Blog Categories</h4>

                        <ul class="list">
                            <li><a href="#">All about clothing</a></li>
                            <li><a href="#">Make-up &amp; beauty</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Fashion trends</a></li>
                            <li><a href="#">Haircuts &amp; hairstyles</a></li>
                        </ul>
                    </div>
                    <!-- End .widget -->

                    <div class="widget">
                        <h4 class="widget-title">Recent Posts</h4>

                        <ul class="simple-entry-list">
                            <li>
                                <div class="entry-media">
                                    <a href="single.html">
                                        <img src="{{ asset('/frontend/images/blog/widget/post-1.jpg') }}" alt="Post">
                                    </a>
                                </div>
                                <!-- End .entry-media -->
                                <div class="entry-info">
                                    <a href="single.html">Post Format - Video</a>
                                    <div class="entry-meta">
                                        April 08, 2018
                                    </div>
                                    <!-- End .entry-meta -->
                                </div>
                                <!-- End .entry-info -->
                            </li>

                            <li>
                                <div class="entry-media">
                                    <a href="single.html">
                                        <img src="{{ asset('/frontend/images/blog/widget/post-2.jpg') }}" alt="Post">
                                    </a>
                                </div>
                                <!-- End .entry-media -->
                                <div class="entry-info">
                                    <a href="single.html">Post Format - Image</a>
                                    <div class="entry-meta">
                                        March 23, 2016
                                    </div>
                                    <!-- End .entry-meta -->
                                </div>
                                <!-- End .entry-info -->
                            </li>
                        </ul>
                    </div>
                    <!-- End .widget -->

                    <div class="widget">
                        <h4 class="widget-title">Tagcloud</h4>

                        <div class="tagcloud">
                            <a href="#">Fashion</a>
                            <a href="#">Shoes</a>
                            <a href="#">Skirts</a>
                            <a href="#">Dresses</a>
                            <a href="#">Bag</a>
                        </div>
                        <!-- End .tagcloud -->
                    </div>
                    <!-- End .widget -->

                    <div class="widget">
                        <h4 class="widget-title">Archive</h4>

                        <ul class="list">
                            <li><a href="#">April 2018</a></li>
                            <li><a href="#">March 2018</a></li>
                            <li><a href="#">February 2018</a></li>
                        </ul>
                    </div>
                    <!-- End .widget -->

                    <div class="widget widget_compare">
                        <h4 class="widget-title">Compare Products</h4>

                        <p>You have no items to compare.</p>
                    </div>
                    <!-- End .widget -->
                </div>
            </div>
            <!-- End .sidebar-wrapper -->
        </aside>
        <!-- End .col-lg-3 -->
    </div>
    <!-- End .row -->
</div>
@endsection