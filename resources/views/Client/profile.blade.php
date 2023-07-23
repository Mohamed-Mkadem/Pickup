@extends('layouts.Client')

@push('title')
    <title>Pickup | Profile</title>
@endpush

@section('content')
    <section class="content" id="content">
        <!-- Start Show Header -->
        <div class="show-header clients d-flex j-start  a-center  col main-holder">
            <div class="img-holder">
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="">
            </div>
            <div class="info-holder">
                <div class="top-header d-flex col j-center a-center">
                    <h2> {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} ({{ Auth::user()->status }})</h2>
                    <ul class="horizontal-actions-holder d-flex j-center md-end a-center">
                        <a href="{{ route('profile.edit') }}" class="editBtn"> <i class="fa-light fa-pen"></i>
                            Edit</a>
                    </ul>
                </div>
                <div class="details ">
                    <p>{{ Auth::user()->city->state->name . ' - ' . Auth::user()->city->name }}</p>
                    <div class="info-grid">
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-dollar"></i>
                                <h3>Balance </h3>
                            </div>
                            <div class="info-value">
                                <p>{{ Auth::user()->client->balance }} <span>DT</span></p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-shop"></i>
                                <h3>Following</h3>
                            </div>
                            <div class="info-value">
                                <p>{{ Auth::user()->client->followsCount() }}</p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-cart-arrow-down"></i>
                                <h3>Orders </h3>
                            </div>
                            <div class="info-value">
                                <p>{{ Auth::user()->client->ordersCount() }}</p>
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
                                <p>{{ Auth::user()->ticketsCount() }} </p>
                            </div>
                        </div>
                        <!-- End Info -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Show Header -->
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
                                    {{ Auth::user()->email }}
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
                                    {{ Auth::user()->phone }}
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
                                    {{ \Carbon\Carbon::parse(Auth::user()->d_o_b)->format('M jS Y') }}

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
                                <i class="fa-light fa-map-location-dot"></i>
                                <h3>Address</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    {{ Auth::user()->address }}
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
                                    {{ Auth::user()->gender }}
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
                                    {{ \Carbon\Carbon::parse(Auth::user()->created_at)->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->

                    </div>
                    <!-- End Card Info -->

                </div>

            </div>
        </div>


    </section>
@endsection
