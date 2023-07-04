@extends('layouts.Seller')

@push('title')
    <title>Pickup | Payments</title>
@endpush
@section('content')

    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Payment Requests</h1>

            @if (Auth::user()->seller->balance - 5 > 0)
                <button class="header-btn add-btn pop-up-controller" id="add-btn"> <i class="fa-light fa-plus"></i> New
                    Payment</button>
                <div class="pop-up-holder ">
                    <div class="pop-up form-pop-up">
                        <div class="pop-up-header d-flex j-sp-between a-center">
                            <h2>New Payment</h2>
                            <button class="close-pop-up-btn"><i class="fa-light fa-close"></i></button>
                        </div>
                        <div class="pop-up-body">
                            <!-- Start Form -->
                            <form action="{{ route('seller.payment-requests.store') }}" method="post" id="payment-form">
                                @csrf
                                <div class="form-control">
                                    <label for="" class="d-block  form-label">
                                        Available To Withdraw (DT) :
                                    </label>

                                    <input type="number" name="" value="{{ Auth::user()->seller->balance - 5 }}"
                                        readonly id="available-input" class="form-element">

                                </div>
                                <div class="form-control">
                                    <label for="" class="d-block required form-label">
                                        Amount To Withdraw (DT) :
                                    </label>

                                    <input type="number" step="0.01" name="amount" id="amount-input"
                                        placeholder="eg: 500" class="form-element">
                                    <p class="error-message">This Field Is Required</p>
                                </div>
                                <div class="form-control">
                                    <label for="" class="d-block form-label">
                                        Payment Fee : 5 DT
                                    </label>
                                </div>
                                <div class="form-control d-flex j-end">
                                    <button type="submit">Confirm</button>
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
                <form action="{{ route('seller.payment-requests.filter') }}" method="GET">
                    <div class="filter-row row2">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->search }}"
                                placeholder="Type A Request ID" class="form-element">
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

                    <div class="filter-row row3">
                        <div class="filter-box">
                            <label for="" class="form-label">Status</label>
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
                                    <label for="paid-input">paid</label>
                                    <input type="checkbox"
                                        {{ in_array('paid', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="paid-input" name="status[]" value="paid">
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

        @if ($payments->count() > 0)
            <div class="results">
                <h2 class="t-left">Results</h2>
                <!-- Start Results Holder -->
                <div class=" main-holder">
                    <div class="table-responsive seller-payment-requests">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount (DT)</th>
                                    <th>Status </th>
                                    <th>Date </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td><a
                                                href="{{ route('seller.payment-requests.show', $payment->id) }}">#{{ $payment->id }}</a>
                                        </td>
                                        <td>{{ $payment->amount }}</td>
                                        <td class="status {{ $payment->status }}"><span>{{ $payment->status }}</span>
                                        </td>
                                        <td>{{ $payment->created_at->format('M jS Y') }}</td>
                                    </tr>
                                @endforeach





                            </tbody>
                        </table>
                    </div>


                </div>
                <!-- End Results Holder -->


                <!-- Start Pagination -->
                {!! $payments->appends(request()->input())->links() !!}

                <!-- End Pagination -->
            </div>
            <!-- End Results -->
        @else
            <!-- Start Not found -->
            <div class="not-found-holder show ">
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
        const paymentForm = document.getElementById('payment-form')
        const amountInput = document.getElementById('amount-input')
        if (paymentForm) {


            paymentForm.addEventListener('submit', (e) => {
                e.preventDefault()
                let errors = 0
                // errors += validateNumber(amountInput, amountInput.nextElementSibling, 10)

                if (!errors) {
                    paymentForm.submit()
                }

            })

            function validateNumber(field, errorMsg, minValue = 0) {
                let errors = 0
                if (!field.value || field.value <= minValue) {

                    errors = 1
                    errorMsg.classList.add('show')
                    errorMsg.textContent = `This Field Is Required, Minimum Value : ${minValue}`
                } else {
                    errors = 0
                    errorMsg.classList.remove('show')
                    errorMsg.textContent = ``

                }
                return errors
            }
        }
    </script>
@endpush
