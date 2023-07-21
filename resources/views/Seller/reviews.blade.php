@extends('layouts.Seller')

@push('title')
    <title>Pickup | Reviews</title>
@endpush
@section('content')
    @include('components.errors-alert')
    @include('components.session-errors-alert')
    @include('components.success-alert')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Reviews : 180</h1>
        </div>
        <!-- End Starter Header -->

        <!-- Start Quick Stats Holder -->
        <div class="quick-stats-holder ">
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Total Rate</p>
                        <p class="box-value light">{{ $store->rate }}%</p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-star placed"></i>
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
                        <p class="box-title">Honesty</p>
                        <p class="box-value light">{{ $store->totalHonesty() }}%</p>
                    </div>

                    <div class="icon-holder">

                        <i class="fa-solid fa-hands-holding-heart accepted"></i>

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
                        <p class="box-title">Commitment</p>
                        <p class="box-value light">{{ $store->totalCommitment() }}%</p>
                    </div>

                    <div class="icon-holder">


                        <i class="fa-light fa-handshake picked"></i>


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
                        <p class="box-title">Hospitality</p>
                        <p class="box-value light">{{ $store->totalHospitality() }}%</p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-bell-concierge all"></i>


                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->

        </div>
        <!-- End Quick Stats Holder -->

        <!-- Start Filters -->
        <div class="filters-holder">
            <div class="filters-header d-flex j-sp-between a-center">
                <h2>Filters</h2>
                <button id="filters-wrapper-controller" aria-controls="filters-wrapper"><i
                        class="fa-light fa-circle-caret-down"></i></button>
            </div>
            <div class="filters-wrapper" id="filters-wrapper">
                <form action="{{ route('seller.reviews.filter') }}" method="get">
                    <div class="filter-row row2">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->search }}"
                                placeholder="Type An Order ID" class="form-element">
                        </div>

                        <div class="filter-box">
                            <label for="" class="form-label">Sort By</label>
                            <div class="select-box">
                                <select name="sort" class="form-element">
                                    <option value="newest" {{ request()->input('sort') === 'newest' ? 'selected' : '' }}>
                                        Newest</option>
                                    <option value="oldest" {{ request()->input('sort') === 'oldest' ? 'selected' : '' }}>
                                        Oldest</option>
                                    <option value="highest rate"
                                        {{ request()->input('sort') == 'highest rate' ? 'selected' : '' }}>highest
                                        rate</option>
                                    <option value="lowest rate"
                                        {{ request()->input('sort') == 'lowest rate' ? 'selected' : '' }}>lowest
                                        rate
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="filter-row row2">

                        <div class="filter-box">
                            <label for="" class="form-label">Date Range</label>
                            <div class="dates-boxes     filter-row sm-row2  ">
                                <div class="date-box min-grid">
                                    <p class="limiters form-limiters">From : </p>
                                    <input type="date" value="{{ request('min_date') }}" name="min_date"
                                        class="form-element">
                                </div>
                                <div class="date-box min-grid">
                                    <p class="limiters form-limiters">To : </p>
                                    <input type="date" value="{{ request('max_date') }}" name="max_date"
                                        class="form-element">
                                </div>
                            </div>
                        </div>
                        <div class="filter-box">
                            <label for="" class="form-label">Rate Range</label>
                            <div class="numbers-range-boxes filter-row sm-row2 ">
                                <div class="number-box min-grid">
                                    <p class="limiters form-limiters">From : </p>
                                    <input type="number" value="{{ request()->min_rate }}" name="min_rate"
                                        pattern="^\d{8}$" inputmode="numeric" placeholder="eg: 10" class="form-element" />

                                </div>
                                <div class="number-box min-grid">
                                    <p class="limiters form-limiters">To : </p>
                                    <input type="number" value="{{ request()->max_rate }}" name="max_rate"
                                        pattern="^\d{8}$" inputmode="numeric" placeholder="eg: 80" class="form-element" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="buttons d-flex j-end gap-1 wrap mt-1">
                        <button type="reset" class="resetBtn">Reset</button>
                        <button type="submit" id="submitBtn" class="submitBtn">Filter</button>
                    </div>
                </form>
            </div>


        </div>
        <!-- End Filters -->

        @if ($reviews->count() > 0)
            <div class="results mt-2">

                <!-- Start Results Holder -->
                <div class="results-holder reviews ">
                    @foreach ($reviews as $review)
                        <!-- Start Review -->
                        <div class="review holder radius-10 p-1">
                            <div class="review-header d-flex j-start a-center gap-1 wrap">
                                <img src="{{ asset('storage/' . $review->client->user->photo) }}" alt="">
                                <div class="review-info">
                                    <h4 class="reviewer-name">{{ ucfirst($review->client->user->full_name) }}</h4>
                                    <p class="review-date">{{ $review->created_at->format('M jS Y H:i') }}</p>
                                </div>
                                <p class="ml-auto rate"><i class="fa-light fa-star"></i> {{ $review->total }}%</p>
                            </div>
                            <div class="review-body mt-1">
                                @if ($review->feedback)
                                    {!! $review->feedback !!}
                                @endif
                            </div>
                            <button id="open-modal" class="radius-10 openModalBtn"></button>
                            <div class="modal-holder ">
                                <div class="review-box modal">
                                    <header class="d-flex j-start a-center row">
                                        <img src="{{ asset('storage/' . $review->client->user->photo) }}" alt="">
                                        <div class="review-info">
                                            <h3>{{ ucfirst($review->client->user->full_name) }}</h3>
                                            <p>{{ $review->created_at->format('M jS Y H:i') }}</p>
                                        </div>
                                        <p class="rate ml-auto"><i class="fa-light fa-star"></i> {{ $review->total }}%
                                        </p>
                                    </header>
                                    <p class="review-body">
                                        <span class="d-block order-id"> Order ID : <a
                                                href="{{ route('seller.orders.show', $review->order->id) }}">#{{ $review->order->id }}</a>
                                        </span>
                                        @if ($review->feedback)
                                            {!! $review->feedback !!}
                                        @endif
                                    </p>
                                    <div class="review-criteria mt-1">
                                        <div class="criterion">
                                            <p>- Honesty : </p>
                                            <div class="points">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <div
                                                        class="point @if ($i <= $review->honesty) checked @endif    ">
                                                    </div>
                                                @endfor

                                            </div>
                                        </div>
                                        <div class="criterion">
                                            <p>- Commitment : </p>
                                            <div class="points">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <div
                                                        class="point @if ($i <= $review->commitment) checked @endif    ">
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="criterion">
                                            <p>- Hospitality : </p>
                                            <div class="points">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <div
                                                        class="point @if ($i <= $review->hospitality) checked @endif    ">
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Review -->
                    @endforeach
                </div>
                <!-- End Results Holder -->
                <!-- Start Pagination -->
                {!! $reviews->appends(request()->input())->links() !!}
                <!-- End Pagination -->

            </div>
        @else
            <!-- Start Not found -->
            <div class="not-found-holder show">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p>There Is No Results Found</p>
                </div>
            </div>
            <!-- End Not found -->
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        const openModalBtns = Array.from(document.querySelectorAll('.openModalBtn'))
        openModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                let modalHolder = btn.nextElementSibling
                modalHolder.classList.add('show')
                document.body.classList.add('no-scroll')
            })
        })
    </script>
    @include('components.inc_modals-js')
@endpush
