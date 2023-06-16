@extends('layouts.Admin')

@push('title')
    <title>Pickup | Client Details </title>
@endpush
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Customer Details</h1>

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
                    <h2>{{ $user->full_name }} <small> ({{ $user->status }})</small></h2>
                    <ul class="horizontal-actions-holder d-flex j-end a-center">
                        @if ($user->status == 'Active')
                            <li>
                                <button class="deleteBtn delete-button">Ban</button>

                                <div class="modal-holder ">
                                    <form action="{{ route('admin.clients.ban', $user->id) }}" method="post"
                                        class="modal t-center confirm-form">

                                        @csrf
                                        @method('PATCH')
                                        <i class=" fa-light fa-trash"></i>
                                        <p>Are You Sure You Want To Ban This Client ?</p>
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
                                    <form action="{{ route('admin.clients.activate', $user->id) }}" method="post"
                                        class="modal t-center confirm-form">

                                        @csrf
                                        @method('PATCH')
                                        <i class=" fa-light fa-trash"></i>
                                        <p>Are You Sure You Want To Activate This Client ?</p>
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
                                <p>{{ $user->client->balance }} <span>DT</span></p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-cart-arrow-down"></i>
                                <h3>Orders</h3>
                            </div>
                            <div class="info-value">
                                <p>18</p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-sack-dollar"></i>
                                <h3>Spent </h3>
                            </div>
                            <div class="info-value">
                                <p>242 <span>DT</span></p>
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
                                <p>8 <span>Stores</span></p>
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
            <div class="results-holder client-seller-show">
                <!-- Start Info Card -->
                <div class="info-card main-holder">
                    <div class="card-header">
                        <h2>General Info</h2>
                    </div>
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
                                    {{ $user->email }}
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
                <!-- End Info Card -->
                <!-- Start Info Card -->
                <div class="info-card main-holder">
                    <div class="card-header">
                        <h2>Orders </h2>
                    </div>
                    <!-- Start Card Info -->
                    <div class="card-info">
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-hourglass-clock"></i>
                                <h3>Pending</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    2
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-square-check"></i>
                                <h3>Approved</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    20
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-rectangle-xmark"></i>
                                <h3>Rejected</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    4
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-gift"></i>
                                <h3>Ready</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    0
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-label">
                                <i class="fa-light fa-truck"></i>
                                <h3>Picked</h3>
                            </div>
                            <div class="info-value">
                                <p>
                                    68
                                </p>
                            </div>
                        </div>
                        <!-- End Info -->
                    </div>
                    <!-- End Card Info -->
                </div>
                <!-- End Info Card -->
            </div>
        </div>
        <!-- End Info -->
    </section>
@endsection

@push('scripts')
    @include('components.inc_modals-js')
@endpush
