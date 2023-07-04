@extends('layouts.Admin')

@push('title')
    <title>Pickup | Payment Requests </title>
@endpush
@section('content')

    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Payment Requests</h1>

        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        <!-- Start Quick Stats Holder -->
        <div class="quick-stats-holder" id="quick-stats-holder">

            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">All</p>
                        <p class="box-value">{{ $statistics['counts']['total'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-calculator-simple all"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if ($statistics['difference']['total'] > 0) success
                        @elseif($statistics['difference']['total'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ $statistics['difference']['total'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Month</p>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Pending</p>
                        <p class="box-value">{{ $statistics['counts']['pending'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-hourglass-clock pending"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if ($statistics['difference']['pending'] > 0) success
                        @elseif($statistics['difference']['pending'] < 0)
                            danger @endif
                        ">
                            <span>{{ $statistics['difference']['pending'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Month</p>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Accepted</p>
                        <p class="box-value">{{ $statistics['counts']['accepted'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-badge-check accepted"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value
                        @if ($statistics['difference']['accepted'] > 0) success
                        @elseif($statistics['difference']['accepted'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ $statistics['difference']['accepted'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Month</p>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Rejected</p>
                        <p class="box-value">{{ $statistics['counts']['rejected'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-xmark rejected"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if ($statistics['difference']['rejected'] > 0) success
                        @elseif($statistics['difference']['rejected'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ $statistics['difference']['rejected'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Month</p>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->

            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Paid</p>
                        <p class="box-value">{{ $statistics['counts']['paid'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar paid"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if ($statistics['difference']['paid'] > 0) success
                        @elseif($statistics['difference']['paid'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ $statistics['difference']['paid'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Month</p>
                </div>
                <!-- End Bottom Info -->
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
                <form action="{{ route('admin.payment-requests.filter') }}" method="GET">
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
                    <div class="table-responsive payment-requests">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Amount (DT)</th>
                                    <th>Status </th>
                                    <th>Date </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td><a
                                                href="{{ route('admin.payment-requests.show', $payment->id) }}">#{{ $payment->id }}</a>
                                        </td>
                                        <td><a
                                                href="{{ route('admin.sellers.show', $payment->seller->user->id) }}">{{ $payment->seller->full_name }}</a>
                                        </td>
                                        <td>{{ $payment->amount }}</td>
                                        <td class="status {{ $payment->status }}"><span>{{ $payment->status }}</span>
                                        </td>
                                        <td>{{ $payment->created_at->format('M jS Y : H:i') }}</td>
                                    </tr>
                                @endforeach





                            </tbody>
                        </table>
                    </div>

                    <div class="form-dialog-btns-wrapper gap-1 a-center wrap d-flex j-center">
                        <button class=" form-dialog-btn reject-btn">Reject All</button>
                        <div class="modal-holder ">
                            <form action="{{ route('admin.payment-requests.rejectAll') }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class=" fa-light fa-info"></i>
                                <p>Are You Sure You Want To Reject All The Pending Payment Requests ?</p>
                                <div class="buttons d-flex j-center a-center">
                                    <button class="cancelBtn">Cancel</button>
                                    <button class="confirmBtn">Yes</button>
                                </div>
                            </form>
                        </div>
                        <button class=" form-dialog-btn approve-btn">Accept All</button>
                        <div class="modal-holder ">
                            <form action="{{ route('admin.payment-requests.acceptAll') }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class=" fa-light fa-info"></i>
                                <p>Are You Sure You Want To Accept All The Pending Payment Requests ?</p>
                                <div class="buttons d-flex j-center a-center">
                                    <button class="cancelBtn">Cancel</button>
                                    <button class="confirmBtn">Yes</button>
                                </div>
                            </form>
                        </div>
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
