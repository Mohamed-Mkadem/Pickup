@extends('layouts.Seller')

@push('title')
    <title>Pickup | Transfers</title>
@endpush
@section('content')


    <section class="content" id="content">

        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Transfers</h1>

            @if ($store->balance != 0)
                <button class="header-btn add-btn pop-up-controller" id="add-btn"> <i class="fa-light fa-plus"></i> New
                    Transfer</button>
                <div class="pop-up-holder ">
                    <div class="pop-up form-pop-up">
                        <div class="pop-up-header d-flex j-sp-between a-center">
                            <h2>New Transfer</h2>
                            <button class="close-pop-up-btn"><i class="fa-light fa-close"></i></button>
                        </div>
                        <div class="pop-up-body">
                            <!-- Start Form -->
                            <form action="{{ route('seller.transfers.store') }}" method="post" id="transfer-form">
                                @csrf
                                <div class="form-control">
                                    <label for="" class="d-block  form-label">
                                        Available To Transfer (DT) :
                                    </label>
                                    <input type="number" value="{{ $store->balance }}" readonly id="available-input"
                                        class="form-element">

                                </div>
                                <div class="form-control">
                                    <label for="" class="d-block required form-label">
                                        Amount To Transfer (DT) :
                                    </label>
                                    <input type="number" step="0.001" name="amount" id="amount-input"
                                        placeholder="eg: 500" class="form-element">
                                    <p class="error-message">This Field Is Required</p>
                                </div>

                                <div class="form-control d-flex j-end">
                                    <button type="submit">Transfer</button>
                                </div>
                            </form>
                            <!-- End Form -->

                        </div>
                    </div>
                </div>
            @endif
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
                <form action="{{ route('seller.transfers.filter') }}" method="GET">
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
                                    <option value="newest" {{ request()->input('sort') === 'newest' ? 'selected' : '' }}>
                                        Newest</option>
                                    <option value="oldest" {{ request()->input('sort') === 'oldest' ? 'selected' : '' }}>
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
                    <div class="table-responsive seller-transfers">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Store Name</th>
                                    <th>Amount <span>(DT)</span></th>
                                    <th>Date </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transfers as $transfer)
                                    <tr>
                                        <td>#{{ $transfer->id }}</td>
                                        <td><a
                                                href="{{ route('seller.stores.show', $transfer->store->username) }}">{{ $transfer->store->name }}</a>
                                        </td>

                                        <td>{{ $transfer->amount }}</td>
                                        <td>{{ $transfer->created_at->format('M jS Y H:i') }}</td>
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


    </section>
@endsection

@push('scripts')
    <script>
        const availableInput = document.getElementById('available-input')
        const transferForm = document.getElementById('transfer-form')
        const amountInput = document.getElementById('amount-input')
        transferForm.addEventListener('submit', (e) => {
            e.preventDefault()
            let errors = 0
            errors += validateField(amountInput, amountInput.nextElementSibling)

            if (!errors) {
                transferForm.submit()
            }

        })

        function validateField(field, errorMessage) {
            let errors = 0
            if (!field.value) {
                errorMessage.textContent = 'This Field Is Required'
                errorMessage.classList.add('show')
                errors = 1
            } else {
                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                errors = 0
            }
            return errors
        }
    </script>
@endpush
