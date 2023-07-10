@extends('layouts.Store')

@push('title')
    <title>{{ $store->name }} | Transfers</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        @include('components.Stores.store-header', ['store' => $store])

        <!-- Start Store Content -->
        <div class="store-content mt-2">
            <!-- Start Filters -->
            <div class="filters-holder">
                <div class="filters-header d-flex j-sp-between a-center">
                    <h2>Filters</h2>
                    <button id="filters-wrapper-controller" aria-controls="filters-wrapper"><i
                            class="fa-light fa-circle-caret-down"></i></button>
                </div>
                <div class="filters-wrapper" id="filters-wrapper">
                    <form action="{{ route('admin.store.transfers.filter', $store->username) }}" method="GET">
                        <div class="filter-row row2">
                            <div class="filter-box">
                                <label for="" class="form-label">Search</label>
                                <input type="search" name="search" value="{{ request()->search }}"
                                    placeholder="Type A Transfer ID" class="form-element">
                            </div>

                            <div class="filter-box">
                                <label for="" class="form-label">Sort By</label>
                                <div class="select-box">
                                    <select name="sort" class="form-element">
                                        <option value="newest"
                                            {{ request()->input('sort') === 'newest' ? 'selected' : '' }}>
                                            Newest</option>
                                        <option value="oldest"
                                            {{ request()->input('sort') === 'oldest' ? 'selected' : '' }}>
                                            Oldest</option>
                                        <option value="highest amount"
                                            {{ request()->input('sort') === 'highest amount' ? 'selected' : '' }}>
                                            highest amount</option>
                                        <option value="lowest amount"
                                            {{ request()->input('sort') === 'lowest amount' ? 'selected' : '' }}>
                                            lowest amount</option>


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
                                <label for="" class="form-label">Amount</label>
                                <div class="numbers-range-boxes filter-row sm-row2 ">
                                    <div class="number-box min-grid">
                                        <p class="limiters form-limiters">From : </p>
                                        <input type="number" placeholder="eg:5" value="{{ request()->min_amount }}"
                                            name="min_amount" pattern="^\d{8}$" inputmode="numeric" class="form-element" />

                                    </div>
                                    <div class="number-box min-grid">
                                        <p class="limiters form-limiters">To : </p>
                                        <input type="number" placeholder="eg:50" value="{{ request()->max_amount }}"
                                            name="max_amount" pattern="^\d{8}$" inputmode="numeric" class="form-element" />
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


            @if ($transfers->count() > 0)
                <div class="results">
                    <h2 class="t-left">Results</h2>
                    <!-- Start Results Holder -->
                    <div class=" main-holder">
                        <div class="table-responsive transfers">
                            <table>

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Store Name</th>
                                        <th>Seller Name</th>

                                        <th>Amount <span>(DT)</span></th>
                                        <th>Date </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transfers as $transfer)
                                        <tr>
                                            <td>#{{ $transfer->id }}</td>
                                            <td><a
                                                    href="{{ route('admin.store.home', $store->username) }}">{{ $store->name }}</a>
                                            </td>
                                            <td><a
                                                    href="{{ route('admin.sellers.show', $transfer->seller->user->id) }}">{{ $transfer->seller->full_name }}</a>
                                            </td>
                                            <td>{{ number_format($transfer->amount, 3, ',') }}</td>
                                            <td>{{ $transfer->created_at->format('M jS Y - H:i') }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Results Holder -->


                    <!-- Start Pagination -->
                    {!! $transfers->appends(request()->input())->links() !!}
                    <!-- End Pagination -->
                </div>
                <!-- End Results -->
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
        <!-- End Store Content -->

    </section>
@endsection

@push('scripts')
    <script>
        const filterHolderController = document.getElementById(
            "filters-wrapper-controller"
        );
        const filtersWrapper = document.getElementById("filters-wrapper");
        if (filterHolderController) {
            filterHolderController.addEventListener("click", () => {
                filtersWrapper.classList.toggle("hidden");
            });
        }
    </script>
@endpush
