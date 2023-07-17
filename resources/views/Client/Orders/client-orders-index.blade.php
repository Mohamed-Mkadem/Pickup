@extends('layouts.Client')

@push('title')
    <title>Pickup | Orders</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Orders</h1>
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
                <form action="" method="get">
                    <div class="filter-row row2">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="" placeholder="Type An Order ID" class="form-element">
                        </div>


                        <div class="filter-box">
                            <label for="" class="form-label">Status</label>
                            <div class="select-box">
                                <select name="" class="form-element">
                                    <option value="">Pending</option>
                                    <option value="">Accepted</option>
                                    <option value="">Ready</option>
                                    <option value="">Picked</option>
                                    <option value="">Rejected</option>
                                    <option value="">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter-box">
                            <label for="" class="form-label">Sort By</label>
                            <div class="select-box">
                                <select name="" class="form-element">
                                    <option value="">Option</option>
                                    <option value="">Option</option>
                                    <option value="">Option</option>
                                    <option value="">Option</option>
                                    <option value="">Option</option>
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
                                    <input type="date" name="" class="form-element">
                                </div>
                                <div class="date-box min-grid">
                                    <p class="limiters form-limiters">To : </p>
                                    <input type="date" name="" class="form-element">
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
            <!-- Strt Results -->
            <div class="results">
                <h2 class="t-left">Results</h2>
                <!-- Start Results Holder -->
                <div class=" main-holder">
                    <div class="table-responsive client-orders">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>

                                    <th>Store </th>
                                    <th>Amount (DT)</th>
                                    <th>Status </th>
                                    <th>Date </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td><a href="{{ route('client.order.show', $order->id) }}">#{{ $order->id }}</a>
                                        </td>

                                        <td><a
                                                href="{{ route('client.store.home', $order->store->username) }}">{{ ucfirst($order->store->name) }}</a>
                                        </td>
                                        <td>{{ number_format($order->amount, 3, ',') }}</td>
                                        <td class="status {{ $order->status }} "><span>{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td>{{ $order->created_at->format('M jS Y H:i') }}</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Results Holder -->


                <!-- Start Pagination   -->
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
