@extends('layouts.Admin')

@push('title')
    <title>Pickup | Home</title>
@endpush

@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Hello {{ Auth::user()->first_name }}</h1>
            <!-- Start Link  -->
            <a href="{{ route('homePage') }}" class="action-btn d-block">
                <i class="fa-light fa-arrow-right-from-bracket"></i>
                <span>Visit Front End</span>
            </a>
            <!-- End Link  -->
        </div>
        <!-- End Starter Header -->




    </section>
@endsection
