@extends('frontend/layouts.master')
@section('content')
<div class="ps-page--single" id="about-us"><img src="img/bg/about-us.jpg" alt="">
    <div class="ps-about-intro">
        <div class="container">
            {!! $page_detail->description !!}
        </div>
    </div>
</div>
@endsection