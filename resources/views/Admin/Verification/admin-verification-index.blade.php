@extends('layouts.Admin')

@push('title')
    <title>Pickup | Verification Requests </title>
@endpush
@include('components.errors-alert')
@include('components.session-errors-alert')
@include('components.success-alert')
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Verification Requests</h1>


        </div>
        <!-- End Starter Header -->

        <!-- Start Quick Stats Holder -->
        <div class="quick-stats-holder" id="quick-stats-holder">
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Total</p>
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

                            {{-- <span>{{ number_format($statistics['totalChange'], 2) }}%</span> --}}
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
                        <p class="box-title">Approved</p>
                        <p class="box-value">{{ $statistics['counts']['approved'] }} </p>
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
                            class="progression-value   @if ($statistics['difference']['approved'] > 0) success
                            @elseif($statistics['difference']['approved'] < 0)
                                danger @endif ">
                            <span>{{ $statistics['difference']['approved'] }}</span>
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
                            class="progression-value   @if ($statistics['difference']['rejected'] > 0) success
                            @elseif($statistics['difference']['rejected'] < 0)
                                danger @endif ">
                            <span>{{ $statistics['difference']['rejected'] }}</span>
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
                <form action="{{ route('admin.verification-requests.filter') }}" method="get">
                    <div class="filter-row row3">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->search }}"
                                placeholder="Type A Request ID" class="form-element">
                        </div>



                        <div class="filter-box">
                            <label for="" class="form-label">Sort By</label>
                            <div class="select-box">
                                <div class="select-box">
                                    <select name="sort" class="form-element">
                                        <option value="newest"
                                            {{ request()->input('sort') === 'newest' ? 'selected' : '' }}>
                                            Newest</option>
                                        <option value="oldest"
                                            {{ request()->input('sort') === 'oldest' ? 'selected' : '' }}>
                                            Oldest</option>


                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="filter-row row2">
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
                                    <label for="approved-input">approved</label>
                                    <input type="checkbox"
                                        {{ in_array('approved', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="approved-input" name="status[]" value="approved">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="rejected-input">rejected</label>
                                    <input type="checkbox"
                                        {{ in_array('rejected', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="rejected-input" name="status[]" value="rejected">
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

        @if ($verificationRequests->count() > 0)
            <div class="results">
                <h2 class="t-left">Results</h2>
                <!-- Start Results Holder -->
                <div class=" main-holder">
                    <div class="table-responsive verification-requests">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Avatar</th>
                                    <th>Name</th>
                                    <th>Status </th>
                                    <th>Date </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($verificationRequests as $request)
                                    <tr>
                                        <td><a
                                                href="{{ route('admin.verification-requests.show', $request->id) }}">#{{ $request->id }}</a>
                                        </td>
                                        <td><img src="{{ asset('storage/' . $request->seller->user->photo) }}"
                                                alt=""></td>
                                        <td><a href="">{{ $request->seller->user->full_name }}</a></td>
                                        <td class="status {{ $request->status }}"><span>{{ $request->status }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($request->created_at)->format('M jS Y') }}</td>
                                    </tr>
                                @endforeach






                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Results Holder -->


                <!-- Start Pagination -->
                {{ $verificationRequests->appends(request()->input())->links() }}
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
@endpush
