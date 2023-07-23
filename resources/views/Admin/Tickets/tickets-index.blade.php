@extends('layouts.Admin')

@push('title')
    <title>Pickup | Tickets </title>
@endpush
@section('content')

    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Tickets</h1>


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
                        <p class="box-title">New</p>
                        <p class="box-value">{{ $statistics['counts']['new'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-hourglass-clock new"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if ($statistics['difference']['new'] > 0) success
                        @elseif($statistics['difference']['new'] < 0)
                            
                        danger @endif
                        ">
                            <span>{{ $statistics['difference']['new'] }}</span>
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
                        <p class="box-title">Closed</p>
                        <p class="box-value">{{ $statistics['counts']['closed'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-badge-check closed"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if ($statistics['difference']['closed'] > 0) success
                        @elseif($statistics['difference']['closed'] < 0)
                            
                        danger @endif
                        
                        ">
                            <span>{{ $statistics['difference']['closed'] }}</span>
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
                        <p class="box-title">In Progress</p>
                        <p class="box-value">{{ $statistics['counts']['in progress'] }} </p>
                    </div>

                    <div class="icon-holder">

                        <i class="fa-solid fa-spinner in-progress"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if ($statistics['difference']['in progress'] > 0) success
                        @elseif($statistics['difference']['in progress'] < 0)
                            
                        danger @endif
                        ">
                            <span>{{ $statistics['difference']['in progress'] }}</span>
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
                <form action="{{ route('admin.tickets.filter') }}" method="get">
                    <div class="filter-row row3">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->search }}"
                                placeholder="Type A Ticket ID" class="form-element">
                        </div>

                        <div class="filter-box">
                            <label for="" class="form-label">User Type </label>
                            <div class="choices-btns-wrapper  ">
                                <div class="choice-btn form-element">
                                    <label for="seller-input"> seller</label>
                                    <input @if (in_array('Seller', (array) request()->user_types)) checked @endif type="checkbox"
                                        id="seller-input" name="user_types[]" value="Seller">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="client-input">client</label>
                                    <input @if (in_array('Client', (array) request()->user_types)) checked @endif type="checkbox"
                                        id="client-input" name="user_types[]" value="Client">
                                </div>
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
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="filter-row row2">
                        <div class="filter-box">
                            <label for="" class="form-label">Status </label>
                            <div class="choices-btns-wrapper  ">
                                <div class="choice-btn form-element">
                                    <label for="new-input"> new</label>
                                    <input type="checkbox"
                                        {{ in_array('new', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="new-input" name="status[]" value="new">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="in-progress-input">in progress</label>
                                    <input type="checkbox"
                                        {{ in_array('in progress', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="in-progress-input" name="status[]" value="in progress">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="closed-input"> closed</label>
                                    <input type="checkbox"
                                        {{ in_array('closed', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="closed-input" name="status[]" value="closed">
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
            </div>
            <div class="buttons d-flex j-end gap-1 wrap mt-1">
                <button type="reset" class="resetBtn">Reset</button>
                <button type="submit" id="submitBtn" class="submitBtn">Filter</button>

            </div>
            </form>
        </div>
        <!-- End Filters -->

        @if ($tickets->count() > 0)
            <div class="results">
                <!-- Start Results Holder -->
                <div class=" main-holder">
                    <div class="table-responsive tickets">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Subject</th>
                                    <th>Status </th>

                                    <th>Date </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td><a
                                                href="{{ route('admin.tickets.show', $ticket->id) }}">#{{ $ticket->id }}</a>
                                        </td>
                                        @if ($ticket->user->type == 'Client')
                                            <td><a
                                                    href="{{ route('admin.clients.show', $ticket->user->id) }}">{{ $ticket->user->full_name }}</a>
                                            </td>
                                        @else
                                            <td><a
                                                    href="{{ route('admin.sellers.show', $ticket->user->id) }}">{{ $ticket->user->full_name }}</a>
                                            </td>
                                        @endif
                                        <td>{{ $ticket->title }}</td>
                                        <td>{{ $ticket->subject }}</td>

                                        <td
                                            class="status 
                                    @if ($ticket->status == 'in progress') in-progress
                                    @else
                                        {{ $ticket->status }} @endif
                                    ">
                                            <span>{{ $ticket->status }}</span>
                                        </td>
                                        <td>{{ $ticket->created_at->format('m-d-y H:i') }}</td>
                                    </tr>
                                    </tr>
                                @endforeach





                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Results Holder -->


                <!-- Start Pagination -->
                {!! $tickets->appends(request()->input())->links() !!}
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
