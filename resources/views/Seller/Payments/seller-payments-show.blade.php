@extends('layouts.Seller')

@push('title')
    <title>Pickup | Payment Request Details</title>
@endpush
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Payment Request Details</h1>
            <!-- Start Link  -->
            <a href="{{ url()->previous() }}" class="action-btn d-block ">
                <i class="fa-light fa-arrow-right-from-bracket"></i>
                <span>Go Back</span>
            </a>
            <!-- End Link  -->


        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        <!-- Start Show Header -->
        <div class="show-header clients d-flex j-start  a-center  col main-holder">
            <div class="img-holder">
                <img src="{{ asset('storage/' . $paymentRequest->seller->user->photo) }}" alt="">
            </div>
            <div class="info-holder">
                <div class="top-header d-flex col j-center a-center">
                    <h2>Request N° : #{{ $paymentRequest->id }} </h2>
                    <ul class="horizontal-actions-holder  d-flex  j-center a-center">
                        <li>


                            <p>
                                {{ $paymentRequest->statusHistories()->latest()->first()->action }} :
                                {{ $paymentRequest->statusHistories()->latest()->first()->created_at->format('M jS Y : H:i') }}
                            </p>

                        </li>
                    </ul>
                </div>
                <div class="details">

                    <div class="info-grid minimal">
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-dollar"></i>
                                <h3>Amount </h3>
                            </div>
                            <div class="info-value">
                                <p>{{ $paymentRequest->amount }} <span>DT</span></p>
                            </div>
                        </div>
                        <!-- End Info -->

                    </div>
                </div>
            </div>
        </div>
        <!-- End Show Header -->


        <!-- Start Info -->
        <div class="results">


            <h2 class="t-left mb-0-5 ">Request History</h2>
            <!-- Start Quick Stats Holder -->
            <div class="quick-stats-holder ">
                @foreach ($paymentRequest->statusHistories as $history)
                    <!-- Start Stat -->
                    <div class="stat-item">
                        <!-- Start Top Info -->
                        <div class="top-info mb-0 d-flex a-start j-sp-between">
                            <div class="title-value-box">
                                <p class="box-title">{{ $history->action }}</p>
                                <p class="box-value light">{{ $history->created_at->format('M jS Y : H:i') }}</p>
                            </div>

                            <div class="icon-holder">
                                @if ($history->action == 'Placed')
                                    <i class="fa-solid fa-timer placed"></i>
                                @elseif($history->action == 'Accepted')
                                    <i class="fa-solid fa-badge-check accepted"></i>
                                @elseif($history->action == 'Rejected')
                                    <i class="fa-regular fa-xmark rejected"></i>
                                @else
                                    <i class="fa-light fa-arrow-right-arrow-left paid "></i>
                                @endif
                            </div>

                        </div>
                        <!-- End Top Info -->

                    </div>

                    <!-- End Stat -->
                @endforeach


            </div>
            <!-- End Quick Stats Holder -->

            <h2 class="t-left mb-0-5 ">General Info</h2>
            <div class=" results-holder mt-0 client-seller-show ">
                <!-- Start Info Card -->
                <div class="info-card main-holder ">

                    <!-- Start Card Info -->
                    <div class="card-info">

                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-envelope"></i>
                                <h3>Email</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    {{ $paymentRequest->seller->user->email }}
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-phone"></i>
                                <h3>Phone</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    {{ $paymentRequest->seller->user->phone }}
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-calendar"></i>
                                <h3>Date Of Birth</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    {{ $paymentRequest->seller->user->d_o_b }}
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-venus-mars"></i>
                                <h3>Gender</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    {{ $paymentRequest->seller->user->gender }}
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->





                    </div>
                    <!-- End Card Info -->
                </div>
                <!-- End Info Card -->

                <!-- Start Info Card -->
                <div class="info-card main-holder ">

                    <!-- Start Card Info -->
                    <div class="card-info">
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-badge-check"></i>
                                <h3>Verification</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    {{ $paymentRequest->seller->verification }}
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-address-card"></i>
                                <h3>N.I.D</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    {{ $paymentRequest->seller->nid }}
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-map-location-dot"></i>
                                <h3>Address</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    {{ $paymentRequest->seller->user->address }}
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-timer"></i>
                                <h3>Joined At</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    {{ \Carbon\Carbon::parse($paymentRequest->seller->user->created_at)->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->

                    </div>
                    <!-- End Card Info -->

                </div>
                <!-- End Info Card -->
            </div>


            <h2 class="t-left mb-0-5 ">Payments Summary</h2>
            <!-- Start Quick Stats Holder -->
            <div class="quick-stats-holder ">
                <!-- Start Stat -->
                <div class="stat-item">
                    <!-- Start Top Info -->
                    <div class="top-info mb-0 d-flex a-start j-sp-between">
                        <div class="title-value-box">
                            <p class="box-title">Pending</p>
                            <p class="box-value">{{ $paymentRequest->seller->paymentsSummary()['pending'] }} </p>
                        </div>

                        <div class="icon-holder">
                            <i class="fa-solid fa-hourglass-clock pending"></i>
                        </div>

                    </div>
                    <!-- End Top Info -->

                </div>
                <!-- End Stat -->
                <!-- Start Stat -->
                <div class="stat-item">
                    <!-- Start Top Info -->
                    <div class="top-info mb-0 d-flex a-start j-sp-between">
                        <div class="title-value-box">
                            <p class="box-title">Accepted</p>
                            <p class="box-value">{{ $paymentRequest->seller->paymentsSummary()['accepted'] }} </p>
                        </div>

                        <div class="icon-holder">

                            <i class="fa-solid fa-badge-check accepted"></i>
                        </div>

                    </div>
                    <!-- End Top Info -->

                </div>
                <!-- End Stat -->
                <!-- Start Stat -->
                <div class="stat-item">
                    <!-- Start Top Info -->
                    <div class="top-info mb-0 d-flex a-start j-sp-between">
                        <div class="title-value-box">
                            <p class="box-title">Rejected</p>
                            <p class="box-value">{{ $paymentRequest->seller->paymentsSummary()['rejected'] }} </p>
                        </div>

                        <div class="icon-holder">

                            <i class="fa-regular fa-xmark rejected"></i>
                        </div>

                    </div>
                    <!-- End Top Info -->

                </div>
                <!-- End Stat -->

                <!-- Start Stat -->
                <div class="stat-item">
                    <!-- Start Top Info -->
                    <div class="top-info mb-0 d-flex a-start j-sp-between">
                        <div class="title-value-box">
                            <p class="box-title">Paid</p>
                            <p class="box-value">{{ $paymentRequest->seller->paymentsSummary()['paid'] }}</p>
                        </div>

                        <div class="icon-holder">

                            <i class="fa-light fa-arrow-right-arrow-left paid"></i>
                        </div>

                    </div>
                    <!-- End Top Info -->

                </div>
                <!-- End Stat -->

            </div>
            <!-- End Quick Stats Holder -->

            <h2 class="t-left mb-0-5 ">Bank Info</h2>
            <div class="results-holder bank-info">
                <!-- Start Info -->
                <div class="info main-holder p-1 radius-10 shadow-1 m-0">
                    <div class="info-title d-flex j-start a-center ">
                        <i class="fa-light fa-bank"></i>
                        <h3>Bank</h3>
                    </div>
                    <div class="info-value">
                        <p>{{ $paymentRequest->seller->bank }}</p>
                    </div>
                </div>
                <!-- End Info -->
                <!-- Start Info -->
                <div class="info main-holder p-1 radius-10 shadow-1 m-0">
                    <div class="info-title d-flex j-start a-center ">
                        <i class="fa-light fa-user"></i>
                        <h3>Account Holer</h3>
                    </div>
                    <div class="info-value">
                        <p>{{ $paymentRequest->seller->account_name }}</p>
                    </div>
                </div>
                <!-- End Info -->
                <!-- Start Info -->
                <div class="info main-holder p-1 radius-10 shadow-1 m-0">
                    <div class="info-title d-flex j-start a-center ">
                        <i class="fa-light fa-bank"></i>
                        <h3>R.I.B</h3>
                    </div>
                    <div class="info-value">
                        <p>{{ $paymentRequest->seller->rib }}</p>
                    </div>
                </div>
                <!-- End Info -->
            </div>




        </div>
        <!-- End Info -->

    </section>
@endsection

@push('scripts')
@endpush
