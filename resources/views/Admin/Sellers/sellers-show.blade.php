@extends('layouts.Admin')

@push('title')
    <title>Pickup | Seller Details </title>
@endpush
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Seller Details</h1>

            <!-- Start Link -->
            <a href="{{ url()->previous() }}" class="action-btn d-block">
                <i class="fa-solid fa-rotate-left"></i>
                <span>Go Back</span> </a>
            <!-- End Link -->
        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')

        <!-- Start Show Header -->
        <div class="show-header clients d-flex j-start  a-center  col main-holder">
            <div class="img-holder">
                <img src="{{ asset('storage/' . $user->photo) }}" alt="">
            </div>
            <div class="info-holder">
                <div class="top-header d-flex col j-center a-center">
                    <h2>{{ $user->full_name }} <small>({{ $user->status }})</small></h2>

                    <ul class="horizontal-actions-holder d-flex j-end a-center">
                        @if ($user->status == 'Active')
                            <li>
                                <button class="deleteBtn delete-button">Ban</button>

                                <div class="modal-holder ">
                                    <form action="{{ route('admin.sellers.ban', $user->id) }}" method="post"
                                        class="modal t-center confirm-form">
                                        @csrf
                                        @method('PATCH')
                                        <i class=" fa-light fa-info"></i>
                                        <p>Are You Sure You Want To Ban This Seller ?</p>
                                        <div class="buttons d-flex j-center a-center">
                                            <button class="cancelBtn">Cancel</button>
                                            <button class="confirmBtn">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        @else
                            <li>
                                <button class="activateBtn activate-button">Activate</button>
                                <div class="modal-holder ">
                                    <form action="{{ route('admin.sellers.activate', $user->id) }}" method="post"
                                        class="modal t-center confirm-form">
                                        @csrf
                                        @method('PATCH')
                                        <i class=" fa-light fa-info"></i>
                                        <p>Are You Sure You Want To Activate This Seller ?</p>
                                        <div class="buttons d-flex j-center a-center">
                                            <button class="cancelBtn">Cancel</button>
                                            <button class="confirmBtn">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="details">
                    <p>{{ $user->state_city }}</p>
                    <div class="info-grid">
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-dollar"></i>
                                <h3>Balance </h3>
                            </div>
                            <div class="info-value">
                                <p>{{ $user->seller->balance }} <span>DT</span></p>
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
                                <p>1</p>
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
                                <p>24</p>
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
                                    {{ $user->email }}
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
                                    {{ $user->phone }}
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
                                    {{ \Carbon\Carbon::parse($user->d_o_b)->format('M jS Y') }}
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
                                    {{ $user->gender }}
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
                                    {{ $user->seller->verification }}
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
                                    {{ $user->seller->nid }}
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
                                    {{ $user->address }}
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
                                    {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}
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
                            <p class="box-value">21 </p>
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
                            <p class="box-value">{{ $user->seller->verificationRequestsCount() }} </p>
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
                            <p class="box-value">21 </p>
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
                        <p>{{ $user->seller->bank }}</p>
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
                        <p>{{ $user->seller->account_name }}</p>
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
                        <p>{{ $user->seller->rib }}</p>
                    </div>
                </div>
                <!-- End Info -->
            </div>



            <!-- Start Stores  -->
            <h2 class="t-left mb-0-5 ">Stores</h2>
            <div class="results-holder mt-0 minimal">

                <!-- Start Card -->
                <div class="card simple  store">
                    <header>
                        <p class="status">Status : <span>Published</span></p>
                        <p class="rate"><i class="fa-light fa-star"></i> 80%</p>
                    </header>

                    <div class="info">
                        <img loading="lazy" src="../../dist/Assets/store.svg" alt="">
                        <h3><a href="store_home.html">Store Name</a></h3>
                        <p>Grocery</p>
                        <p>Ariana - Mnihla</p>

                    </div>
                </div>
                <!-- End Card -->

            </div>
            <!-- End Stores -->
        </div>
        <!-- End Info -->
    </section>
@endsection

@push('scripts')
    @include('components.inc_modals-js')
@endpush
