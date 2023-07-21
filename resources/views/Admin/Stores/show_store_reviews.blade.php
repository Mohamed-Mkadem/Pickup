@extends('layouts.Store')

@push('title')
    <title>{{ $store->name }} | Reviews</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        @include('components.Stores.store-header', ['store' => $store])
        <!-- Start Store Content -->
        <div class="store-content mt-2">
            <div class="results">
                <h2 class="t-left mb-0-5">Reviews : {{ $store->reviewsCount() }}</h2>
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
                                                <img src="{{ asset('storage/' . $review->client->user->photo) }}"
                                                    alt="">
                                                <div class="review-info">
                                                    <h3>{{ ucfirst($review->client->user->full_name) }}</h3>
                                                    <p>{{ $review->created_at->format('M jS Y H:i') }}</p>
                                                </div>
                                                <p class="rate ml-auto"><i class="fa-light fa-star"></i>
                                                    {{ $review->total }}%
                                                </p>
                                            </header>
                                            <p class="review-body">
                                                <span class="d-block order-id"> Order ID : <a
                                                        href="{{ route('admin.orders.show', $review->order->id) }}">#{{ $review->order->id }}</a>
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

            </div>
        </div>
        <!-- End Store Content -->
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
@endpush
