@extends('layouts.Admin')

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
            <a target="_blank" href="{{ route('homePage') }}" class="action-btn d-block">
                <i class="fa-light fa-arrow-right-from-bracket"></i>
                <span>Visit Front End</span>
            </a>
        </div>
        <!-- End Starter Header -->

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
                    <a href="{{ route('admin.earnings.index') }}" class="action-link">Net Earnings</a>
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
                        <p class="box-title">Sellers</p>
                        <p class="box-value">{{ $sellers['todayCount'] }}</p>
                    </div>
                    <div class="progression-box">
                        <p
                            class="progression-value 
                        @if ($sellers['difference'] > 0) success
                        @elseif($sellers['difference'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ $sellers['difference'] }}</span>
                        </p>
                    </div>
                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-sp-between a-center">
                    <a href="{{ route('admin.sellers.index') }}" class="action-link">More Info</a>
                    <i class="fa-light fa-users-viewfinder success"></i>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Clients</p>
                        <p class="box-value">{{ $clients['todayCount'] }}</p>
                    </div>
                    <div class="progression-box">
                        <p
                            class="progression-value 
                        @if ($clients['difference'] > 0) success
                        @elseif($clients['difference'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ $clients['difference'] }}</span>
                        </p>
                    </div>
                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-sp-between a-center">
                    <a href="{{ route('admin.clients.index') }}" class="action-link">More Info</a>
                    <i class="fa-light fa-users info"></i>
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
                        <p class="box-value">{{ $notifications['todayCount'] }}</p>
                    </div>
                    <div class="progression-box">
                        <p
                            class="progression-value 
                        @if ($notifications['difference'] > 0) success
                        @elseif($notifications['difference'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ $notifications['difference'] }}</span>
                        </p>
                    </div>
                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-sp-between a-center">
                    <a href="{{ route('admin.notifications.index') }}" class="action-link">More Info</a>
                    <i class="fa-light fa-bell alert"></i>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->




        </div>
        <!-- End Quick Stats -->



    </section>
@endsection
