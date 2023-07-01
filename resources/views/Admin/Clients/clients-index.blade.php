@extends('layouts.Admin')

@push('title')
    <title>Pickup | Clients </title>
@endpush

@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Clients</h1>



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
                <form action="{{ route('admin.clients.filter') }}" method="GET">
                    <div class="filter-row row3 has-statuses">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->search }}"
                                placeholder="Type A Client First Name / Last Name" class="form-element">
                        </div>
                        <div class="filter-box">
                            <label for="" class="form-label">Status </label>
                            <div class="choices-btns-wrapper  ">
                                <div class="choice-btn form-element">
                                    <label for="active-input"> active</label>
                                    <input type="checkbox"
                                        {{ in_array('active', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="active-input" name="status[]" value="active">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="banned-input">banned</label>
                                    <input type="checkbox"
                                        {{ in_array('banned', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="banned-input" name="status[]" value="banned">
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
                            <label for="" class="form-label">State</label>
                            <div class="select-box">
                                <select name="state_id" id="state-select" class="form-element" onchange="getCities()">

                                    <option value="all">All</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ request()->input('state_id') == $state->id ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="filter-box">
                            <label for="" class="form-label">City</label>
                            <div class="select-box">
                                <select name="city_id" class="form-element" id="city-select">

                                    @if (request()->input('state_id') && request()->input('state_id') != 'all')
                                        <option value="all">All</option>
                                        @foreach ($states as $state)
                                            @if ($state->id == request()->input('state_id'))
                                                @foreach ($state->cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        @if (request()->input('city_id') == $city->id) selected @endif>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @else{
                                        {{-- @foreach ($states[0]->cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}
                                            </option>
                                        @endforeach --}}
                                        <option value="all">All</option>
                                        }
                                    @endif
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

        @if ($clients->count() > 0)
            <!-- Start Results -->
            <div class="results">
                <div class="results-holder main-holder clients">
                    @foreach ($clients as $client)
                        <!-- Start client -->
                        <div class="client card simple">
                            <header>
                                <p class="status">Status : <span>{{ $client->user->status }}</span></p>

                                <button class="actions-controller"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="actions-holder ">

                                    <li>
                                        <a href="{{ route('admin.clients.show', $client->user->id) }}">Show</a>
                                    </li>
                                    @if ($client->user->status == 'Banned')
                                        <li>
                                            <button class="deleteBtn">Activate</button>
                                            <div class="modal-holder ">
                                                <form action="{{ route('admin.clients.activate', $client->user->id) }}"
                                                    method="post" class="modal t-center confirm-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <i class=" fa-light fa-info"></i>
                                                    <p>Are You Sure You Want To Activate This Client ?</p>
                                                    <div class="buttons d-flex j-center a-center">
                                                        <button class="cancelBtn">Cancel</button>
                                                        <button class="confirmBtn">Yes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>
                                    @else
                                        <li>
                                            <button class="deleteBtn">Ban</button>
                                            <div class="modal-holder ">
                                                <form action="{{ route('admin.clients.ban', $client->user->id) }}"
                                                    method="post" class="modal t-center confirm-form">
                                                    @method('PATCH')
                                                    @csrf
                                                    <i class=" fa-light fa-info"></i>
                                                    <p>Are You Sure You Want To Ban This Client ?</p>
                                                    <div class="buttons d-flex j-center a-center">
                                                        <button class="cancelBtn">Cancel</button>
                                                        <button class="confirmBtn">Yes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </header>
                            <div class="info">
                                <img loading="lazy" src="{{ asset('storage/' . $client->user->photo) }}" alt="">
                                <h3><a href="{{ route('admin.clients.show', $client->user->id) }}">
                                        {{ $client->user->full_name }}</a>
                                </h3>
                                <p>{{ $client->user->state_city }}</p>
                            </div>
                        </div>
                        <!-- End client -->
                    @endforeach

                </div>

                {!! $clients->appends(request()->input())->links() !!}
            </div>
            <!-- End Results -->
        @else
            <div class="not-found-holder show">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p>No Results Found</p>
                </div>
            </div>
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        const cityField = document.getElementById('city-select')

        function getCities() {
            // Get the selected state value
            var stateId = document.getElementById('state-select').value;

            if (stateId == 'all') {
                cityField.innerHTML = ''
                let allOption = document.createElement('option')
                allOption.setAttribute('value', 'all')
                allOption.textContent = 'All'
                cityField.appendChild(allOption)
            } else {
                // Make an AJAX request to the server to fetch the cities based on the selected state
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        // Handle the response from the server
                        var cities = JSON.parse(xhr.responseText);

                        // Update the city select input options

                        cityField.innerHTML = ''; // Clear existing options

                        var option = document.createElement('option');
                        option.value = 'all';
                        option.textContent = "All";
                        cityField.appendChild(option);
                        // Create new option elements for each city
                        cities.forEach(function(city) {
                            var option = document.createElement('option');
                            option.value = city.id;
                            option.text = city.name;
                            cityField.appendChild(option);
                        });
                    }
                };

                // Send the AJAX request
                xhr.open('GET', '/api/cities/' + stateId, true);
                xhr.send();
            }
        }
    </script>
    @include('components.inc_modals-js')
@endpush
