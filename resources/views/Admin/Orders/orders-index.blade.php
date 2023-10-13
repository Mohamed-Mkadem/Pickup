@extends('layouts.Admin')

@push('title')
    <title>Pickup | Orders </title>
@endpush
@section('content')

    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Orders</h1>
        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')



        <!-- Start Filters -->
        <div class="filters-holder">
            <div class="filters-header d-flex j-sp-between a-center">
                <h2>Filters</h2>
                <button id="filters-wrapper-controller" aria-controls="filters-wrapper"><i
                        class="fa-light fa-circle-caret-down"></i></button>
            </div>
            <div class="filters-wrapper" id="filters-wrapper">
                <form action="{{ route('admin.orders.filter') }}" method="get">
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
                                    <option value="highest_amount"
                                        {{ request()->input('sort') === 'highest_amount' ? 'selected' : '' }}>
                                        Highest Amount</option>
                                    <option value="lowest_amount"
                                        {{ request()->input('sort') === 'lowest_amount' ? 'selected' : '' }}>
                                        Lowest Amount</option>


                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="filter-row row2">
                        <div class="filter-box">
                            <label for="" class="form-label">Status </label>
                            <div class="choices-btns-wrapper  ">
                                <div class="choice-btn form-element">
                                    <label for="pending-input"> pending</label>
                                    <input type="checkbox"
                                        {{ in_array('pending', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="pending-input" name="status[]" value="pending">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="accepted-input">accepted</label>
                                    <input type="checkbox"
                                        {{ in_array('accepted', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="accepted-input" name="status[]" value="accepted">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="rejected-input">rejected</label>
                                    <input type="checkbox"
                                        {{ in_array('rejected', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="rejected-input" name="status[]" value="rejected">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="ready-input">ready</label>
                                    <input type="checkbox"
                                        {{ in_array('ready', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="ready-input" name="status[]" value="ready">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="picked-input">picked</label>
                                    <input type="checkbox"
                                        {{ in_array('picked', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="picked-input" name="status[]" value="picked">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="cancelled-input">cancelled</label>
                                    <input type="checkbox"
                                        {{ in_array('cancelled', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="cancelled-input" name="status[]" value="cancelled">
                                </div>
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

        @if ($orders->count() > 0)
            <div class="results">
                <h2 class="t-left">Results</h2>
                <!-- Start Results Holder -->
                <div class=" main-holder">
                    <div class="table-responsive admin-orders">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client </th>
                                    <th>Store </th>
                                    <th>Amount (DT)</th>
                                    <th>Status </th>
                                    <th>Date </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td><a
                                                href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('admin.clients.show', $order->client->user->id) }}">{{ ucfirst($order->client->user->full_name) }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('admin.store.home', $order->store->username) }}">{{ ucfirst($order->store->name) }}</a>
                                        </td>
                                        <td>{{ number_format($order->amount, 3, ',') }}</td>
                                        <td class="status {{ $order->status }} ">
                                            <span>{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td>{{ $order->created_at->format('M jS Y H:i') }}</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Results Holder -->


                <!-- Start Pagination -->
                {!! $orders->appends(request()->input())->links() !!}
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
