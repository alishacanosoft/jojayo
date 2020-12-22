@php
$title = Request::segment(1);
@endphp
<div class="ps-breadcrumb">
<div class="container">
    <ul class="breadcrumb">
    <li><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($title) }}</li>
    </ul>
</div>
</div>

<section class="ps-section--account">
    <div class="container">
        <div class="row">
           
