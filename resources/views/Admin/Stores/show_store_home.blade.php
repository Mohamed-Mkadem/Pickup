@extends('layouts.Store')
@php
    $currentDay = strtolower(date('l'));
    $currentTime = date('H:i:s');
    
    $openingHour = null;
    foreach ($store->openingHours as $hour) {
        if ($hour['day_of_week'] === $currentDay) {
            $openingHour = $hour;
            break;
        }
    }
    
    $isOpen = false;
    if ($openingHour && $currentTime >= $openingHour['opening_time'] && $currentTime <= $openingHour['closing_time']) {
        $isOpen = true;
    }
@endphp
@push('title')
    <title>{{ $store->name }} | Home</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        @include('components.Stores.store-header', ['store' => $store])
        <!-- Start Store Content -->
        <div class="store-content home m-block-2">
            <div class="main-grid">
                <!-- Start Sidebar -->
                <div class="info-sidebar holder p-1 radius-10">
                    <!-- Start Sidebar Header -->
                    <div class="info-sidebar-header d-flex j-sp-between a-center gap-0-5 wrap">
                        <h3 class="store-secondary-title">General Info</h3>
                        <button class="info-sidebar-btn" id="info-sidebar-btn">
                            <i class="fa-light fa-circle-caret-down"></i>
                        </button>
                    </div>
                    <!-- Start Sidebar Header -->
                    <div class="info-sidebar-body" id="info-sidebar-body">
                        <!-- Start Info -->
                        <div class="info ">
                            <h4 class="grid-title bio"><i class="fa-light fa-circle-info"></i> Bio</h4>
                            {!! $store->bio !!}
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info ">
                            <h4 class="grid-title address"><i class="fa-light fa-location"></i> {{ $store->state_city }}
                            </h4>
                            <p class="full-address">- {{ $store->address }}</p>

                        </div>
                        <!-- End Info -->
                        <div class="info phone">
                            <h4 class="grid-title phone"><i class="fa-light fa-phone"></i> {{ $store->phone }}</h4>

                        </div>
                        <!-- End Info -->

                        <!-- End Info -->
                        <div class="info ">
                            <h4 class="grid-title opening-hours-holder start">
                                <i class="fa-light fa-timer"></i>
                                <button id="opening-hours-btn" class="opening-hours-btn t-left">

                                    <p class="status"><span
                                            class=" {{ $isOpen ? 'open' : 'closed' }}">{{ $isOpen ? 'Open' : 'Closed' }}</span>
                                        <i class="fa-light fa-circle-caret-down"></i>
                                    </p>
                                    <p class="opening-hours">
                                        {{ \Carbon\Carbon::parse($openingHour['opening_time'])->format('H:i') . ' - ' . \Carbon\Carbon::parse($openingHour['closing_time'])->format('H:i') }}
                                    </p>
                                </button>

                            </h4>

                        </div>
                        <!-- End Info -->

                    </div>
                </div>
                <!-- End Sidebar -->
                <div class="main-grid-content ">
                    <div class="results">
                        <div class="results-holder home-content-cards">
                            <!-- Start Owner Card -->
                            <div class="card-holder holder p-1 radius-10">
                                <div class="card-title d-flex j-sp-between a-center wrap gap-0-5">
                                    <h3>Owner :</h3>
                                    <a href="{{ route('admin.store.owner', $store->username) }}">More Info</a>
                                </div>
                                <!-- Start Seller -->
                                <div class="seller card simple">
                                    <header>
                                        <p class="status">Status : <span>{{ $store->owner->user->status }}</span></p>

                                    </header>
                                    <div class="info">
                                        <img loading="lazy" src="{{ asset('storage/' . $store->owner->user->photo) }}"
                                            alt="">
                                        <h3>
                                            <a
                                                href="{{ route('admin.sellers.show', $store->owner->user->id) }}">{{ $store->owner->user->full_name }}</a>
                                            @if ($store->owner->verification == 'Verified')
                                                <i title="Verified Seller" class="fa-solid fa-badge-check"></i>
                                            @endif
                                        </h3>
                                        <p>{{ $store->owner->user->state_city }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Owner Card -->


                            <!-- Start Orders Card -->
                            <div class="card-holder holder p-1 radius-10">
                                <div class="card-title d-flex j-sp-between a-center wrap gap-0-5">
                                    <h3>Orders :</h3>
                                    <a href="{{ route('admin.store.orders', $store->username) }}">More Info</a>
                                </div>
                                <div class="card single-info-card orders-card">
                                    <p class="orders-count main-value">250 <small>Orders</small></p>
                                    <div class="details">
                                        <div class="detail">
                                            <h4 class="detail-title">Pending : </h4>
                                            <p class="detail-value">414 <small>Orders</small></p>
                                        </div>
                                        <div class="detail">
                                            <h4 class="detail-title">Rejected : </h4>
                                            <p class="detail-value">414 <small>Orders</small></p>
                                        </div>
                                        <div class="detail">
                                            <h4 class="detail-title">Approved : </h4>
                                            <p class="detail-value">414 <small>Orders</small></p>
                                        </div>
                                        <div class="detail">
                                            <h4 class="detail-title">Ready : </h4>
                                            <p class="detail-value">414 <small>Orders</small></p>
                                        </div>
                                        <div class="detail">
                                            <h4 class="detail-title">Picked : </h4>
                                            <p class="detail-value">414 <small>Orders</small></p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Orders Card -->


                            <!-- Start Balance Card -->
                            <div class="card-holder holder p-1 radius-10">
                                <div class="card-title">
                                    <h3>Balance :</h3>
                                </div>
                                <div class="card single-info-card balance-card">
                                    <p class="balance-value main-value">

                                        {{ $store->balance }}
                                        <small> DT</small>
                                    </p>
                                    <div class="details">
                                        <div class="detail">
                                            <h4 class="detail-title">Available : </h4>
                                            <p class="detail-value">414 <small>DT</small></p>
                                        </div>
                                        <div class="detail">
                                            <h4 class="detail-title">Suspended : </h4>
                                            <p class="detail-value">214 <small>DT</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Balance Card -->

                            <!-- Start Sales Card -->
                            <div class="card-holder holder p-1 radius-10">
                                <div class="card-title d-flex j-sp-between a-center wrap gap-0-5">
                                    <h3>Sales :</h3>
                                    <a href="store_sales_list.html">More Info</a>
                                </div>
                                <div class="card single-info-card sales-card">
                                    <p class="sales-count main-value">250 <small>Sales</small></p>
                                    <div class="details">
                                        <div class="detail">
                                            <h4 class="detail-title">Today : </h4>
                                            <p class="detail-value">414 <small>Sales</small></p>
                                        </div>
                                        <div class="detail">
                                            <h4 class="detail-title">This Week : </h4>
                                            <p class="detail-value">414 <small>Sales</small></p>
                                        </div>
                                        <div class="detail">
                                            <h4 class="detail-title">This Month : </h4>
                                            <p class="detail-value">414 <small>Sales</small></p>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <!-- End Sales Card -->
                            <!-- Start Transfers Card -->
                            <div class="card-holder holder p-1 radius-10">
                                <div class="card-title d-flex j-sp-between a-center wrap gap-0-5">
                                    <h3>Transfers :</h3>
                                    <a href="store_transfers.html">More Info</a>
                                </div>
                                <div class="card single-info-card transfers-card">
                                    <p class="transfers-count main-value">25 <small>Transfers</small></p>
                                    <div class="details">
                                        <div class="detail">
                                            <h4 class="detail-title">Total Amount : </h4>
                                            <p class="detail-value">4140 <small>DT</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Transfers Card -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Store Content -->
        <div class="modal-holder " id="opening-hours-modal-holder">
            <div class="modal opening-hours-modal">
                <!-- Start Modal Header -->
                <div class="modal-header d-flex j-sp-between a-center">
                    <h2>Opening Hours</h2>
                    <button class="close-modal-holder-btn"><i class="fa-light fa-close"></i></button>
                </div>
                <!-- End Modal Header -->
                <!-- Start Modal Body -->
                <div class="modal-body">
                    @foreach ($store->openingHours as $hour)
                        <!-- Start Day -->
                        <div class="day">
                            <h3>{{ ucfirst($hour['day_of_week']) }}</h3>
                            <div class="hours-holder">
                                <p class="hour">{{ \Carbon\Carbon::parse($hour['opening_time'])->format('H:i') }}</p>
                                <p class="hour">{{ \Carbon\Carbon::parse($hour['closing_time'])->format('H:i') }}</p>

                            </div>
                        </div>
                        <!-- End Day -->
                    @endforeach

                </div>
                <!-- End Modal Body -->

            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        const infoSidebarBtn = document.getElementById('info-sidebar-btn')
        const infoSidebarBody = document.getElementById('info-sidebar-body')
        infoSidebarBtn.addEventListener('click', () => {
            infoSidebarBody.classList.toggle('hidden')
        })
        const openingHoursBtn = document.getElementById('opening-hours-btn')
        const openingHoursModalHolder = document.getElementById('opening-hours-modal-holder')
        openingHoursBtn.addEventListener('click', () => {

            openingHoursModalHolder.classList.add('show')
            document.body.classList.add('no-scroll')
        })
    </script>
@endpush
