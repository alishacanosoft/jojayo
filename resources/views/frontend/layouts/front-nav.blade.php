@php
$title = Request::segment(1);
@endphp
<div class="ps-breadcrumb" id="color_data">
    <div class="ps-container" id="size_data">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($title) }}</li>
        </ul>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-lg-9 order-lg-last dashboard-content">
          @if(session()->has('success'))
            {{frontSuccess()}}
          @elseif(session()->has('warning'))
            {{frontWarning()}}
          @elseif(session()->has('error'))
            {{frontError()}}
          @endif
