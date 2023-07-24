@extends('layouts.Admin')

@push('title')
    <title>Pickup | Earnings </title>
@endpush
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Earnings</h1>


        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        <!-- Start Quick Stats Holder -->

        <div class="quick-stats-holder" id="quick-stats-holder">

            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Total (DT)</p>
                        <p class="box-value">{{ Auth::user()->getEarningStatistics()['currentPeriod']['total'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar today"></i>
                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Today (DT)</p>
                        <p class="box-value">{{ Auth::user()->getEarningStatistics()['currentPeriod']['day'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar today"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value
                        @if (Auth::user()->getEarningStatistics()['difference']['day'] > 0) success
                        @elseif(Auth::user()->getEarningStatistics()['difference']['day'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ Auth::user()->getEarningStatistics()['difference']['day'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Day</p>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Week (DT)</p>
                        <p class="box-value">{{ Auth::user()->getEarningStatistics()['currentPeriod']['week'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar week"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if (Auth::user()->getEarningStatistics()['difference']['week'] > 0) success
                        @elseif(Auth::user()->getEarningStatistics()['difference']['week'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ Auth::user()->getEarningStatistics()['difference']['week'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Week</p>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Month (DT)</p>
                        <p class="box-value">{{ Auth::user()->getEarningStatistics()['currentPeriod']['month'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar month"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if (Auth::user()->getEarningStatistics()['difference']['month'] > 0) success
                        @elseif(Auth::user()->getEarningStatistics()['difference']['month'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ Auth::user()->getEarningStatistics()['difference']['month'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Month</p>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Year (DT)</p>
                        <p class="box-value">{{ Auth::user()->getEarningStatistics()['currentPeriod']['year'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar year"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if (Auth::user()->getEarningStatistics()['difference']['year'] > 0) success
                        @elseif(Auth::user()->getEarningStatistics()['difference']['year'] < 0)
                            danger @endif
                        ">
                            <span>{{ Auth::user()->getEarningStatistics()['difference']['year'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Year</p>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->


        </div>
        <!-- End Quick Stats Holder -->


        <div class="tables-holder">
            <!-- Start Table Row -->
            <div class="table-row">
                <!-- Start Table  Card-->
                <div class="table-card earnings">
                    <div class="table-header  d-flex j-sp-between a-center">
                        <h4 class="table-title">Expenses Report</h4>
                    </div>
                    <div class="table-responsive earnings-reports">
                        <table data-title="Expenses Report">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Total (DT)</th>
                                </tr>

                            </thead>


                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->category }}</td>
                                        <td>{{ $expense->total_amount }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table Card -->
                <!-- Start Table  Card-->
                <div class="table-card earnings">
                    <div class="table-header  d-flex j-sp-between a-center">
                        <h4 class="table-title">Revenues Report</h4>
                    </div>
                    <div class="table-responsive earnings-reports">
                        <table data-title="Revenues Report">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Total (DT)</th>
                                </tr>

                            </thead>


                            <tbody>
                                @foreach ($revenues as $revenue)
                                    <tr>
                                        <td>{{ $revenue->category }}</td>
                                        <td>{{ $revenue->total_amount }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table Card -->

            </div>
            <!-- End Table Row -->
        </div>






    </section>
@endsection

@push('scripts')
@endpush
