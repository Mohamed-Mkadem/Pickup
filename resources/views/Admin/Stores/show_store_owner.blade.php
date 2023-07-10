@extends('layouts.Store')

@push('title')
    <title> {{ $store->name }} | Owner</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        @include('components.Stores.store-header', ['store' => $store])


        <!-- Start Show Header -->
        <div class="show-header clients d-flex j-start  a-center  col main-holder">
            <div class="img-holder">
                <img src="{{ asset('storage/' . $store->owner->user->photo) }}" alt="">
            </div>
            <div class="info-holder">
                <div class="top-header d-flex col j-center a-center">
                    <h2>{{ $store->owner->user->full_name }} <small>({{ $store->owner->user->status }})</small></h2>


                </div>
                <div class="details">
                    <p>{{ $store->owner->user->state_city }}</p>
                    <div class="info-grid">
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-dollar"></i>
                                <h3>Balance </h3>
                            </div>
                            <div class="info-value">
                                <p>{{ $store->owner->balance }} <span>DT</span></p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-shop"></i>
                                <h3>Stores</h3>
                            </div>
                            <div class="info-value">
                                <p>{{ $store->owner->storesCount() }}</p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-box-dollar"></i>
                                <h3>Subscriptions </h3>
                            </div>
                            <div class="info-value">
                                <p>{{ $store->subscriptionsCount() }}</p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-user-headset"></i>
                                <h3>Tickets</h3>
                            </div>
                            <div class="info-value">
                                <p>8 </p>
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
                                    {{ $store->owner->user->email }}
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
                                    {{ $store->owner->user->phone }}
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
                                    {{ \Carbon\Carbon::parse($store->owner->user->d_o_b)->format('M jS Y') }}
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
                                    {{ $store->owner->user->gender }}
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
                                    {{ $store->owner->verification }}
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
                                    {{ $store->owner->nid }}
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
                                    {{ $store->owner->user->address }}
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
                                    {{ \Carbon\Carbon::parse($store->owner->user->created_at)->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->

                    </div>
                    <!-- End Card Info -->

                </div>

            </div>

            <h2 class="t-left mb-0-5 ">Requests Summary</h2>
            <!-- Start Quick Stats Holder -->
            <div class="quick-stats-holder " id="quick-stats-holder">
                <!-- Start Stat -->
                <div class="stat-item">
                    <!-- Start Top Info -->
                    <div class="top-info mb-0 d-flex a-start j-sp-between">
                        <div class="title-value-box">
                            <p class="box-title">Payment</p>
                            <p class="box-value">{{ $store->owner->paymentRequestsCount() }} </p>
                        </div>

                        <div class="icon-holder">
                            <i class="fa-solid fa-sack-dollar payment"></i>
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
                            <p class="box-title">Verification</p>
                            <p class="box-value">{{ $store->owner->verificationRequestsCount() }} </p>
                        </div>

                        <div class="icon-holder">

                            <i class="fa-solid fa-badge-check verification"></i>
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
                            <p class="box-title">Transfers</p>
                            <p class="box-value">{{ $store->owner->transfersCount() }} </p>
                        </div>

                        <div class="icon-holder">

                            <i class="fa-light fa-arrow-right-arrow-left transfers"></i>
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
                        <p>{{ $store->owner->bank }}</p>
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
                        <p>{{ $store->owner->account_name }}</p>
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
                        <p>{{ $store->owner->rib }}</p>
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
