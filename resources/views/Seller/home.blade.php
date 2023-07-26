@extends('layouts.Seller')

@push('title')
    <title>Pickup | Home</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <div>
                <h1>Hello {{ Auth::user()->first_name }}</h1>
                <p class="today-stats">Here Are Today's Statistics</p>
            </div>
            <!-- Start Link  -->
            <a href="{{ route('seller.sales.create') }}" class="header-btn d-block add-btn">
                <i class="fa-light fa-plus"></i>
                <span>Add Sale</span>
            </a>
            <!-- End Link  -->
        </div>
        <!-- End Starter Header -->

        @if (Auth::user()->seller->hasActiveStore())
            <!-- Start Quick Stats -->
            <div class="quick-stats-holder" id="quick-stats-holder">
                <!-- Start Stat -->
                <div class="stat-item">
                    <!-- Start Top Info -->
                    <div class="top-info d-flex a-start j-sp-between">
                        <div class="title-value-box">
                            <p class="box-title">Earnings (DT)</p>
                            <p class="box-value">{{ Auth::user()->getEarningStatistics()['currentPeriod']['day'] }}</p>
                        </div>
                        <div class="progression-box">
                            <p
                                class="progression-value 
                       
                            @if (Auth::user()->getEarningStatistics()['difference']['day'] > 0) success
                        @elseif(Auth::user()->getEarningStatistics()['difference']['day'] < 0)
                            danger @endif ">
                                <span>{{ Auth::user()->getEarningStatistics()['difference']['day'] }}</span>
                            </p>
                        </div>
                    </div>
                    <!-- End Top Info -->
                    <!-- Start Bottom Info -->
                    <div class="bottom-info d-flex j-sp-between a-center">
                        <a href="{{ route('seller.earnings.index') }}" class="action-link">Net Earnings</a>
                        <i class="fa-light fa-dollar primary"></i>
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
                            <p class="box-value">{{ $orders['todayCount'] }}</p>
                        </div>
                        <div class="progression-box">
                            <p
                                class="progression-value 
                            @if ($orders['difference'] > 0) success
                            @elseif($orders['difference'] < 0)
                                danger @endif
                            ">
                                <span>{{ $orders['difference'] }}</span>
                            </p>
                        </div>
                    </div>
                    <!-- End Top Info -->
                    <!-- Start Bottom Info -->
                    <div class="bottom-info d-flex j-sp-between a-center">
                        <a href="{{ route('seller.orders.index') }}" class="action-link">More Info</a>
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
                            <p class="box-title">Sales</p>
                            <p class="box-value">{{ $sales['todayCount'] }}</p>
                        </div>
                        <div class="progression-box">
                            <p
                                class="progression-value 
                            @if ($sales['difference'] > 0) success
                            @elseif($sales['difference'] < 0)
                                danger @endif
                            ">
                                <span>{{ $sales['difference'] }}</span>
                            </p>
                        </div>
                    </div>
                    <!-- End Top Info -->
                    <!-- Start Bottom Info -->
                    <div class="bottom-info d-flex j-sp-between a-center">
                        <a href="{{ route('seller.sales.index') }}" class="action-link">More Info</a>
                        <i class="fa-light fa-hand-holding-dollar alert"></i>
                    </div>
                    <!-- End Bottom Info -->
                </div>
                <!-- End Stat -->
                <!-- Start Stat -->
                <div class="stat-item">
                    <!-- Start Top Info -->
                    <div class="top-info d-flex a-start j-sp-between">
                        <div class="title-value-box">
                            <p class="box-title">Reviews</p>
                            <p class="box-value">{{ $reviews['todayCount'] }}</p>
                        </div>
                        <div class="progression-box">
                            <p
                                class="progression-value 
                            @if ($reviews['difference'] > 0) success
                            @elseif($reviews['difference'] < 0)
                                danger @endif
                            ">
                                <span>{{ $reviews['difference'] }}</span>
                            </p>
                        </div>
                    </div>
                    <!-- End Top Info -->
                    <!-- Start Bottom Info -->
                    <div class="bottom-info d-flex j-sp-between a-center">
                        <a href="{{ route('seller.reviews.index') }}" class="action-link">More Info</a>
                        <i class="fa-light fa-star primary"></i>
                    </div>
                    <!-- End Bottom Info -->
                </div>
                <!-- End Stat -->



            </div>
            <!-- End Quick Stats -->
        @endif
        @if (Auth::user()->seller->hasBannedStore())
            <div class="alert alert-error">
                <h3>Notice</h3>
                <p>
                    Your Store {{ Auth::user()->seller->store->name }} Has Been Banned Due the violation of our guidelines,
                    you will no longer be able to use the store again, you can transfer the money to your account and make a
                    payment request to withdraw your money
                </p>
            </div>
        @endif
    </section>
@endsection
