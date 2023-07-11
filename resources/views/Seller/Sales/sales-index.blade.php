@extends('layouts.Seller')

@push('title')
    <title>Pickup | Sales</title>
@endpush
@section('content')


    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Sales</h1>
            <!-- Start Link  -->
            <a href="{{ route('seller.sales.create') }}" class="header-btn d-block add-btn">
                <i class="fa-light fa-plus"></i>
                <span>Add Sale</span>
            </a>
            <!-- End Link  -->


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
                <form action="{{ route('seller.sales.filter') }}" method="GET">
                    <div class="filter-row row2">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->search }}"
                                placeholder="Type A Sale ID" class="form-element">
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
                                        Highest amount</option>
                                    <option value="lowest_amount"
                                        {{ request()->input('sort') === 'lowest_amount' ? 'selected' : '' }}>
                                        Lowest amount</option>
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
        @if ($sales->count() > 0)
            <!-- Start Results -->
            <div class="results">
                <h2 class="t-left">Results</h2>
                <!-- Start Results Holder -->
                <div class=" main-holder ">
                    <div class="table-responsive seller-sales">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount (DT)</th>
                                    <th>N° Items </th>
                                    <th>Date </th>
                                    <th>Actions </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td><a href="{{ route('seller.sales.show', $sale->id) }}">#{{ $sale->id }}</a>
                                        </td>
                                        <td>{{ number_format($sale->amount, 3, ',') }}</td>
                                        <td>{{ $sale->no_items }}</td>
                                        <td>{{ $sale->created_at->format('M jS Y H:i') }}</td>
                                        <td>
                                            <ul class="d-flex j-center a-center actions">
                                                <li>

                                                    <a href="{{ route('seller.sales.show', $sale->id) }}" class="td-btn"><i
                                                            class="fa-light fa-eye"></i></a>

                                                </li>

                                                <li>
                                                    <button class="deleteBtn td-btn" title="Delete Expense"><i
                                                            class="fa-light fa-trash"></i></button>
                                                    <div class="modal-holder ">
                                                        <form action="{{ route('seller.sales.destroy', $sale->id) }}"
                                                            method="post" class="modal t-center confirm-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <i class=" fa-light fa-trash"></i>


                                                            <p> Deleting this sale will result in an adjustment to the
                                                                product quantities
                                                                associated with this sale
                                                            </p>

                                                            <p>Are You Sure You Want To Delete This Sale ?</p>
                                                            <div class="buttons d-flex j-center a-center">
                                                                <button class="cancelBtn">Cancel</button>
                                                                <button class="confirmBtn">Yes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach




                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Results Holder -->


                <!-- Start Pagination -->

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
    @include('components.inc_modals-js')
@endpush
