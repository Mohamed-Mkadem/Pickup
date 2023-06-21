@extends('layouts.Seller')

@push('title')
    <title>Pickup | Stores</title>
@endpush

@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Stores</h1>
        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')

        @if ($stores->count() > 0)
            <div class="results">

                <div class="results-holder  stores-grid">

                    <div class="holder radius-10 p-1">
                        @foreach ($stores as $store)
                            <!-- Start Store -->
                            <div class="card simple  store ">
                                <header>
                                    <p class="status">Status: <span>{{ ucfirst($store->status) }}</span></p>
                                    <p class="rate"><i class="fa-light fa-star"></i> {{ $store->rate }}%</p>
                                </header>

                                <div class="info">
                                    <img loading="lazy" src="{{ asset('storage/' . $store->photo) }}" alt="">
                                    <h3><a href="{{ route('seller.stores.show', $store->username) }}">{{ $store->name }}
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

                                        </a> <span class="status {{ $isOpen ? 'published' : '' }} "></span>
                                    </h3>
                                    <p>{{ $store->sector->name }}</p>
                                    <p>{{ $store->state_city }}</p>

                                    <div class="details d-flex col  j-center ">
                                        <div class="detail t-center">
                                            <p> <i class="fa-light fa-user-plus"></i> {{ $store->followers }} </p>

                                        </div>
                                        <div class="detail t-center">
                                            <p><i class="fa-light fa-dollar-sign"></i> {{ $store->balance }} DT</p>

                                        </div>
                                    </div>
                                </div>
                                <!-- End Store -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="not-found-holder show">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p class="mb-1">You Didn't Add Any Store yet</p>
                    <a href="{{ route('seller.stores.create') }}" class="activate-button ">Create Store</a>
                </div>
            </div>
        @endif
    </section>
@endsection

@push('scripts')
@endpush
