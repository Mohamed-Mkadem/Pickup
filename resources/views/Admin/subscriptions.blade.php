@extends('layouts.Admin')

@push('title')
    <title>Pickup | Subscriptions </title>
@endpush
@section('content')
    @include('components.errors-alert')
    @include('components.session-errors-alert')
    @include('components.success-alert')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Subscriptions</h1>
        </div>
        <!-- End Starter Header -->



        <!-- Start Filters -->
        <div class="filters-holder">
            <div class="filters-header d-flex j-sp-between a-center">
                <h2>Filters</h2>
                <button id="filters-wrapper-controller" aria-controls="filters-wrapper"><i
                        class="fa-light fa-circle-caret-down"></i></button>
            </div>
            <div class="filters-wrapper" id="filters-wrapper">
                <form action="{{ route('admin.subscriptions.filter') }}" method="GET">
                    <div class="filter-row row3">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->search }}"
                                placeholder="Type A Subscription ID" class="form-element">
                        </div>

                        <div class="filter-box">
                            <label for="" class="form-label">All</label>
                            <div class="select-box">
                                <select name="duration" class="form-element">
                                    <option value="all">All
                                    </option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i . ($i == 1 ? ' Month' : ' Months') }}"
                                            {{ (int) request()->duration == (int) $i ? 'selected' : '' }}>
                                            {{ $i . ($i == 1 ? ' Month' : ' Months') }}

                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="filter-box">
                            <label for="" class="form-label">Sort By</label>
                            <div class="select-box">
                                <select name="sort" class="form-element">
                                    <option value="newest" {{ request()->input('sort') === 'newest' ? 'selected' : '' }}>
                                        Newest</option>
                                    <option value="oldest" {{ request()->input('sort') === 'oldest' ? 'selected' : '' }}>
                                        Oldest</option>
                                    <option value="highest_duration"
                                        {{ request()->input('sort') === 'highest_duration' ? 'selected' : '' }}>
                                        Highest Duration</option>
                                    <option value="lowest_duration"
                                        {{ request()->input('sort') === 'lowest_duration' ? 'selected' : '' }}>
                                        Lowest Duration</option>

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

                    </div>
                    <div class="buttons d-flex j-end gap-1 wrap mt-1">
                        <button type="reset" class="resetBtn">Reset</button>
                        <button type="submit" id="submitBtn" class="submitBtn">Filter</button>

                    </div>
                </form>
            </div>


        </div>
        <!-- End Filters -->

        @if ($subscriptions->count() > 0)
            <div class="results">
                <h2 class="t-left">Results</h2>
                <!-- Start Results Holder -->
                <div class=" main-holder">
                    <div class="table-responsive subscriptions">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Store Avatar</th>
                                    <th>Store </th>
                                    <th>Duration </th>
                                    <th>Amount <span>(DT)</span></th>
                                    <th>Date </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>#{{ $subscription->id }}</td>
                                        <td><img loading="lazy" src="{{ asset('storage/' . $subscription->store->photo) }}"
                                                alt=""></td>
                                        <td> <a href="{{ route('admin.store.home', $subscription->store->username) }}">{{ ucfirst($subscription->store->name) }}
                                            </a> </td>
                                        <td>{{ $subscription->duration }}</td>
                                        <td>{{ number_format($subscription->id, 3, ',') }}</td>
                                        <td>{{ $subscription->created_at->format('M jS Y H:i') }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Results Holder -->


                <!-- Start Pagination -->
                {!! $subscriptions->appends(request()->input())->links() !!}
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
    </section>
@endsection

@push('scripts')
@endpush
