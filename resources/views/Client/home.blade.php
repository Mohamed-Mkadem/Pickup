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
            <a href="{{ route('client.shopping') }}" class="header-btn d-block add-btn">
                <i class="fa-light fa-plus"></i>
                <span>Shop Now</span>
            </a>
            <!-- End Link  -->
        </div>
        <!-- End Starter Header -->
        <!-- Start Quick Stats -->
        <div class="quick-stats-holder" id="quick-stats-holder">
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Balance (DT)</p>
                        <p class="box-value">{{ number_format(Auth::user()->client->balance, 3, ',') }} </p>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-sp-between a-center">
                    <a href="{{ route('client.balance') }}" class="action-link">More Info</a>
                    <i class="fa-light fa-dollar success"></i>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Orders</p>
                        <p class="box-value">{{ Auth::user()->client->ordersCount() }}</p>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-sp-between a-center">
                    <a href="{{ route('client.orders.index') }}" class="action-link">More Info</a>
                    <i class="fa-light fa-cart-arrow-down info"></i>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Notifications</p>
                        <p class="box-value">{{ Auth::user()->unreadNotifications()->count() }}</p>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-sp-between a-center">
                    <a href="{{ route('client.notifications.index') }}" class="action-link">More Info</a>
                    <i class="fa-light fa-bell alert"></i>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Tickets</p>
                        <p class="box-value">{{ Auth::user()->ticketsCount() }}</p>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-sp-between a-center">
                    <a href="{{ route('client.tickets.index') }}" class="action-link">More Info</a>
                    <i class="fa-light fa-user-headset primary"></i>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->

        </div>
        <!-- End Quick Stats -->
        @if ($stores->count() > 0)
            <div class="results">
                <h2 class="t-left">Latest Stores On Your City</h2>
                <div class="results-holder  stores-grid">
                    @foreach ($stores as $store)
                        <!-- Start Store -->
                        <div class="card simple  store">
                            <header class="wrap gap-1">
                                <p>{{ $store->state_city }}</p>
                                <p class="rate "><i class="fa-light fa-star"></i> {{ $store->rate }}%</p>
                            </header>

                            <div class="info">
                                <img loading="lazy" src="{{ asset('storage/' . $store->photo) }}" alt="">
                                <h3><a href="{{ route('client.store.home', $store->username) }}">{{ $store->name }} </a>
                                </h3>
                                <p>{{ $store->sector->name }}</p>

                                <div class="details d-flex   j-center ">
                                    <div class="detail t-center">
                                        <p> <i class="fa-light fa-user-plus"></i> {{ $store->followers }} </p>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Store -->
                    @endforeach



                </div>
            </div>
        @endif
    </section>
@endsection
