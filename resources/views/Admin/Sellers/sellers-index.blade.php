@extends('layouts.Admin')

@push('title')
    <title>Pickup | Sellers </title>
@endpush
@section('content')
    @include('components.errors-alert')
    @include('components.session-errors-alert')
    @include('components.success-alert')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Sellers</h1>
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
                <form action="{{ route('admin.sellers.filter') }}" method="GET">
                    <div class="filter-row row3 has-statuses">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->search }}"
                                placeholder="Type A Seller First Name / Last Name" class="form-element">
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
                    <div class="filter-row row3 has-statuses">
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

                                        <option value="all">All</option>
                                        }
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="filter-box">
                            <label for="" class="form-label">Verification </label>
                            <div class="choices-btns-wrapper  ">
                                <div class="choice-btn form-element">
                                    <label for="verified-input"> verified</label>
                                    <input type="checkbox"
                                        {{ in_array('Verified', (array) request()->input('verification')) ? 'checked' : '' }}
                                        id="verified-input" name="verification[]" value="Verified">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="unverified-input">unverified</label>
                                    <input type="checkbox"
                                        {{ in_array('Unverified', (array) request()->input('verification')) ? 'checked' : '' }}
                                        id="unverified-input" name="verification[]" value="Unverified">
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

        @if ($sellers->count() > 0)
            <!-- Start Results -->
            <div class="results">
                <div class="results-holder main-holder sellers">
                    @foreach ($sellers as $seller)
                        <!-- Start Seller -->
                        <div class="seller card simple">
                            <header>
                                <p class="status">Status : <span>{{ $seller->user->status }}</span></p>
                                <button class="actions-controller"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="actions-holder ">

                                    <li>
                                        <a href="{{ route('admin.sellers.show', $seller->user->id) }}">Show</a>
                                    </li>
                                    @if ($seller->user->status == 'Banned')
                                        <li>
                                            <button class="deleteBtn">Activate</button>
                                            <div class="modal-holder ">
                                                <form action="{{ route('admin.sellers.activate', $seller->user->id) }}"
                                                    method="post" class="modal t-center confirm-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <i class=" fa-light fa-trash"></i>
                                                    <p>Are You Sure You Want To Activate This Seller ?</p>
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
                                                <form action="{{ route('admin.sellers.ban', $seller->user->id) }}"
                                                    method="post" class="modal t-center confirm-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <i class=" fa-light fa-trash"></i>
                                                    <p>Are You Sure You Want To Ban This Seller ?</p>
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
                                <img loading="lazy" src="{{ asset('storage/' . $seller->user->photo) }}" alt="">
                                <h3><a
                                        href="{{ route('admin.sellers.show', $seller->user->id) }}">{{ $seller->user->full_name }}</a>
                                    @if ($seller->verification == 'Verified')
                                        <i title="Verified Seller" class="fa-solid fa-badge-check"></i>
                                    @endif
                                </h3>
                                <p>{{ $seller->user->state_city }}</p>
                            </div>
                        </div>
                        <!-- End Seller -->
                    @endforeach
                </div>
                {!! $sellers->appends(request()->input())->links() !!}
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
