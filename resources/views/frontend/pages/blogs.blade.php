@extends('frontend.layouts.master')
@section('content')
<div class="ps-page--blog">
      <div class="container">
        <div class="ps-page__header">
          <h1>Our Blogs</h1>
          <div class="ps-breadcrumb--2">
            <ul class="breadcrumb">
              <li><a href="{{url('/')}}">Home</a></li>
              <li>Our Blogs</li>
            </ul>
          </div>
        </div>
        <div class="ps-blog--sidebar">
          <div class="ps-blog__left">
          @if(!empty($allPosts))
          @foreach($allPosts as $post)
            <div class="ps-post ps-post--small-thumbnail">
              <div class="ps-post__thumbnail"><a class="ps-post__overlay" href="{{url('/blogs/'.$post->slug)}}"></a><img src="{{ url('/uploads/blogs/'.$post->image) }}" alt="{{$post->slug}}">
                @if($post->feature==1)
                <div class="ps-post__badge"><i class="icon-star"></i></div>
                @endif
              </div>
              <div class="ps-post__content">
                <div class="ps-post__top">
                  <div class="ps-post__meta"><a href="{{url('/blogs/categories/'.$post->category->slug)}}">{{ucwords($post->category->name)}}</a>
                  </div><a class="ps-post__title" href="{{url('/blogs/'.$post->slug)}}">{{ucwords($post->title)}}</a>
                 
                  <p>  {{ucfirst($post->excerpt)}} </p>
                </div>
                <div class="ps-post__bottom">
                  <p>{{$post->created_at->format('F  j, Y')}}</p>
                </div>
              </div>
            </div>
           @endforeach
           @endif
            <div class="ps-pagination">
            {{ $allPosts->links() }}  
            </div>
          </div>

          <div class="ps-blog__right">
                @include('frontend.pages.blog-sidebar')            
          </div>
        </div>
      </div>
</div>
<div class="related-products"></div>

@endsection