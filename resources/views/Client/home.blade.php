@extends('layouts.Client')

@push('title')
    <title>Pickup | Home</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Hello {{ Auth::user()->first_name }}</h1>
            <!-- Start Link  -->
            <a href="shopping.html" class="header-btn d-block add-btn">
                <i class="fa-light fa-plus"></i>
                <span>Shop Now</span>
            </a>
            <!-- End Link  -->
        </div>
        <!-- End Starter Header -->


    </section>
@endsection