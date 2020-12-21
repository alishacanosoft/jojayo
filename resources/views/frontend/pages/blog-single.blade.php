@extends('frontend.layouts.master') @section('content')
<div class="ps-breadcrumb">
    <div class="ps-container">
    <ul class="breadcrumb">
        <li><a href="{{url('/')}}">Home</a></li>
        <li><a href="{{url('/blogs')}}">Blogs</a></li>
        <li>{{ucwords($singleBlog->title)}}</li>
    </ul>
    </div>
</div>
<div class="ps-page--blog">
         <div class="ps-post--detail ps-post--parallax">
        <div class="ps-post__header bg--parallax" data-background="{{ asset('/uploads/blogs/'.$singleBlog->image) }}">
          <div class="container">
            <h4>{{ucwords($singleBlog->category->name)}}</h4>
            <h1>{{ucwords($singleBlog->title)}}</h1>
            <p>{{$singleBlog->created_at->format('F  j, Y')}}</p>
          </div>
        </div>
        <div class="container">
          <div class="ps-post__content">
            <p> {!! $singleBlog->description !!} </p>
          </div>
          <div class="ps-post__footer">
            <div class="ps-post__social">
              <a class="facebook" value="{{ $singleBlog->id }}" onclick='fbShare("{{ URL('/')}}/{{$singleBlog->slug }}")'><i class="fa fa-facebook"></i></a>
              <a class="twitter" value="{{ $singleBlog->id }}" onclick='twitShare("{{ URL('/')}}/{{$singleBlog->slug }}","{{ $singleBlog->title }}")'><i class="fa fa-twitter"></i></a>
              <a class="whatsapp" value="{{ $singleBlog->id }}" onclick='whatsappShare("{{ URL('/')}}/{{$singleBlog->slug }}","{{ $singleBlog->title }}")'><i class="fa fa-whatsapp"></i></a>
              <a class="google" value="{{ $singleBlog->id }}" href="mailto:?subject={{ $singleBlog->title }}...&amp;body={!! shortContent($singleBlog->description, 20) !!}...{{ URL('/')."/".$singleBlog->slug }}"><i class="fa fa-envelope"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="ps-related-posts">
          <h3>Related Posts</h3>
          <div class="row">
          @if(!empty($relatedBlogs)) 
          @foreach($relatedBlogs as $post)
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                <div class="ps-post">
                <div class="ps-post__thumbnail"><a class="ps-post__overlay" href="{{url('/blogs/'.$post->slug)}}"></a><img src="{{ asset('/uploads/blogs/'.$singleBlog->image) }}" alt="{{$post->slug}}">
                    @if($post->feature==1)
                    <div class="ps-post__badge"><i class="icon-star"></i></div>
                    @endif
                </div>
                <div class="ps-post__content">
                    <div class="ps-post__top">
                    <div class="ps-post__meta"><a href="{{url('/blogs/categories/'.$post->category->slug)}}">{{ucwords($post->category->name)}}</a>
                    </div><a class="ps-post__title" href="{{url('/blogs/'.$post->slug)}}">{{ucwords($post->title)}}</a>
                    </div>
                    <div class="ps-post__bottom">
                    <p>{{$post->created_at->format('F  j, Y')}}</p>
                    </div>
                </div>
                </div>
            </div>
            @endforeach
           @endif
          </div>
        </div>
      </div>
</div>

<div class="related-products"></div>

@endsection
@section('scripts')
<script>
function fbShare(url) {
  window.open("https://www.facebook.com/sharer/sharer.php?u=" + url, "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=200, left=500, width=600, height=400");
}
function twitShare(url, title) {
    window.open("https://twitter.com/intent/tweet?text=" + encodeURIComponent(title) + "+" + url + " via @jojayo", "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=200, left=500, width=600, height=400");
}
function whatsappShare(url, title) {
    message = title + " " + url;
    window.open("https://api.whatsapp.com/send?text=" + message);
}
function googleplusShare(url) {
    window.open("https://plus.google.com/share?url=" + url, "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=200, left=500, width=600, height=400");
}
</script>
@endsection