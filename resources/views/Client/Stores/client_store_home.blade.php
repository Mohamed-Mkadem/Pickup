@extends('layouts.client-store')
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


        @if ($store->status == 'unpublished' || $store->status == 'banned')
            <div class="unavailable-wrapper d-flex col a-center ">
                <img src="{{ asset('dist/Assets/404_error.svg') }}" alt="">
                <p class="info-message">This store's subscription has expired, and it is no
                    longer available for browsing or making purchases. It will remain inaccessible until the
                    store owner purchases a new subscription. We apologize for any inconvenience caused. In the
                    meantime, feel free to check out our other active stores for your shopping needs.</p>
                <div class="buttons d-flex j-sp-between a-center gap-1 wrap mt-1">
                    <a href="{{ url()->previous() }}" class="go-back">Go Back</a>
                    <a href="{{ route('client.shopping') }}" class="shopping">Shopping</a>
                </div>
            </div>
        @elseif($store->status == 'maintenance')
            <div class="unavailable-wrapper d-flex col a-center ">
                <img src="{{ asset('dist/Assets/maintenance.svg') }}" alt="">
                <p class="info-message">This store is currently undergoing maintenance to improve your shopping
                    experience. The store owner is working diligently
                    to complete the necessary fixes and updates. Once the maintenance is finished, the store
                    will be published again. Thank you for your patience and understanding</p>
                <div class="buttons d-flex j-sp-between a-center gap-1 wrap mt-1">
                    <a href="{{ url()->previous() }}" class="go-back">Go Back</a>
                    <a href="{{ route('client.shopping') }}" class="shopping">Shopping</a>
                </div>
            </div>
        @else
            @include('components.errors-alert')
            @include('components.session-errors-alert')
            @include('components.success-alert')
            @include('components.Stores.client-store-header', ['store' => $store])
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
                            <h2 class="t-left mt-0 mb-0-5">Latest Products</h2>
                            @if ($products->count() > 0)
                                <div class="results-holder products-holder">
                                    @foreach ($products as $product)
                                        <!-- Start Product  -->
                                        <div
                                            class="product holder radius-10 @if ($product->quantity == 0) disabled @endif">
                                            <p class="product-quantity-holder mb-1">Quantity: <span class="quantity-value"
                                                    data-id="{{ $product->id }}">{{ $product->quantity }}</span>
                                            </p>
                                            <div class="img-holder ">
                                                <img src="{{ asset('storage/' . $product->image) }}" class=" radius-10"
                                                    alt="">
                                            </div>
                                            <div class="info-holder">
                                                <h3 class="product-name">{{ $product->name }}</h3>
                                                <p class="product-price">{{ number_format($product->price, 3,'.') }} <small>DT</small></p>
                                            </div>
                                            <div class="actions d-flex j-sp-between a-center gap-0-5 wrap">
                                                <form action="{{ route('client.cart.add', $store->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                                    <input type="hidden" name="name" value="{{ $product->name }}">
                                                    <input type="hidden" name="image"
                                                        value="{{ asset('storage/' . $product->image) }}">


                                                    <button type="submit"
                                                        @if ($product->quantity == 0) @disabled(true) @endif><i
                                                            class="fa-light fa-cart-shopping"></i></button>

                                                </form>
                                                <a
                                                    href="{{ route('client.store.product', ['username' => $store->username, 'id' => $product->id]) }}"><i
                                                        class="fa-light fa-eye"></i></a>
                                            </div>
                                        </div>
                                        <!-- End Product  -->
                                    @endforeach
                                </div>
                            @else
                                <!-- Start Not Found -->
                                <div class="not-found-holder show">
                                    <div class="wrapper">
                                        <i class="fa-light fa-circle-info"></i>
                                        <p>No Products Found</p>
                                    </div>
                                </div>
                                <!-- End Not Found -->
                            @endif

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
        @endif
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
