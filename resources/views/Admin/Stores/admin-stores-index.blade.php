@extends('layouts.Admin')

@push('title')
    <title>Pickup | Stores </title>
@endpush
@section('content')
    @include('components.errors-alert')
    @include('components.session-errors-alert')
    @include('components.success-alert')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Stores</h1>
        </div>
        <!-- End Starter Header -->
        <form action="{{ route('admin.stores.filter') }}" method="get" id="filter-form">
            <div class="form-grid stores-holder">
                <div class="filters-holder">
                    <div class="filters-header d-flex j-sp-between a-center">
                        <h2>Filters</h2>
                        <button id="filters-wrapper-controller" aria-controls="filters-wrapper"><i
                                class="fa-light fa-circle-caret-down"></i></button>
                    </div>
                    <div class="filters-wrapper " id="filters-wrapper">
                        <div class="form-sidebar  mt-1 fixed-sidebar">
                            <div class="form-grid-row row2">
                                <div class="form-control m-0">
                                    <input type="search" class="form-element" name="search"
                                        placeholder="Type A Store Name" value="{{ request()->search }}">

                                </div>
                                <div class="form-control m-0">
                                    <div class="select-box">
                                        <select name="sort" class="form-element">
                                            <option value="newest"
                                                {{ request()->input('sort') == 'newest' ? 'selected' : '' }}>newest</option>
                                            <option value="oldest"
                                                {{ request()->input('sort') == 'oldest' ? 'selected' : '' }}>oldest</option>
                                            <option value="highest rate"
                                                {{ request()->input('sort') == 'highest rate' ? 'selected' : '' }}>highest
                                                rate</option>
                                            <option value="lowest rate"
                                                {{ request()->input('sort') == 'lowest rate' ? 'selected' : '' }}>lowest
                                                rate
                                            </option>
                                            <option value="highest followers"
                                                {{ request()->input('sort') == 'highest followers' ? 'selected' : '' }}>
                                                highest followers</option>
                                            <option value="lowest followers"
                                                {{ request()->input('sort') == 'lowest followers' ? 'selected' : '' }}>
                                                lowest
                                                followers</option>
                                            <option value="highest balance"
                                                {{ request()->input('sort') == 'highest balance' ? 'selected' : '' }}>
                                                highest
                                                balance</option>
                                            <option value="lowest balance"
                                                {{ request()->input('sort') == 'lowest balance' ? 'selected' : '' }}>lowest
                                                balance</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-column g-250 mt-1">
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">State</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">
                                        <div class="form-control">
                                            <input type="search" class="form-element" name="states"
                                                placeholder="State Name" id="states-search">
                                        </div>

                                        <div class="choices states-choices">
                                            <div class="choice">
                                                <input type="radio" name="state_id" id="all" value="all"
                                                    onchange="getCities('all')" checked>
                                                <label for="all">all</label>
                                            </div>
                                            @foreach ($states as $state)
                                                <div class="choice">
                                                    <input type="radio" name="state_id" id="{{ 'state_' . $state->id }}"
                                                        value="{{ $state->id }}"
                                                        {{ request()->state_id == $state->id ? 'checked' : '' }}
                                                        onchange="getCities({{ $state->id }})">
                                                    <label for="{{ 'state_' . $state->id }}">{{ $state->name }}</label>
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>
                                </div>
                                <!-- End Form Filter -->
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">City</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">
                                        <div class="form-control">
                                            <input type="search" class="form-element" name="cities"
                                                placeholder="City Name" id="city-search">
                                        </div>

                                        <div class="choices cities-choices" id="cities-holder">

                                            @if (request()->input('state_id') && request()->input('state_id') != 'all')
                                                @foreach ($states as $state)
                                                    @if ($state->id == request()->input('state_id'))
                                                        <div class="choice">
                                                            <input type="radio" name="city_id" id="city_all"
                                                                value="all" checked>
                                                            <label for="city_all">All</label>
                                                        </div>
                                                        @foreach ($state->cities as $city)
                                                            <div class="choice">
                                                                <input type="radio" name="city_id"
                                                                    id="{{ 'city_' . $city->id }}"
                                                                    value="{{ $city->id }}"
                                                                    @if (request()->input('city_id') == $city->id) checked @endif>
                                                                <label
                                                                    for="{{ 'city_' . $city->id }}">{{ $city->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @else
                                                <div class="choice">
                                                    <input type="radio" name="city_id" id="city_all" value="all"
                                                        checked>
                                                    <label for="city_all">All</label>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <!-- End Form Filter -->
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Sector</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">
                                        <div class="form-control">
                                            <input type="search" class="form-element" name="sectors"
                                                placeholder="Sector Name" id="sector-search">
                                        </div>

                                        <div class="choices sectors-choices">

                                            @foreach ($sectors as $sector)
                                                <div class="choice">
                                                    <input type="checkbox" name="sectors[]"
                                                        id="{{ 'sector_' . $sector->id }}"
                                                        {{ in_array($sector->id, (array) request()->input('sectors')) ? 'checked' : '' }}
                                                        value="{{ $sector->id }}">
                                                    <label
                                                        for="{{ 'sector_' . $sector->id }}">{{ $sector->name }}</label>
                                                </div>
                                            @endforeach


                                        </div>

                                    </div>
                                </div>
                                <!-- End Form Filter -->
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Status</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">


                                        <div class="choices">
                                            <div class="choice">
                                                <input type="checkbox" id="published" name="status[]"
                                                    {{ in_array('published', (array) request()->input('status')) ? 'checked' : '' }}
                                                    value="published">
                                                <label for="published">Published</label>
                                            </div>
                                            <div class="choice">
                                                <input type="checkbox" id="unpublished" name="status[]"
                                                    {{ in_array('unpublished', (array) request()->input('status')) ? 'checked' : '' }}
                                                    value="unpublished">
                                                <label for="unpublished">unpublished</label>
                                            </div>
                                            <div class="choice">
                                                <input type="checkbox" id="banned" name="status[]"
                                                    {{ in_array('banned', (array) request()->input('status')) ? 'checked' : '' }}
                                                    value="banned">

                                                <label for="banned">banned</label>
                                            </div>
                                            <div class="choice">
                                                <input type="checkbox" id="maintenance" name="status[]"
                                                    {{ in_array('maintenance', (array) request()->input('status')) ? 'checked' : '' }}
                                                    value="maintenance">
                                                <label for="maintenance">Maintenance</label>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- End Form Filter -->

                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Followers</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">

                                        <div class="form-control">
                                            <p class="limiters form-limiters">From : </p>
                                            <input type="number" pattern="^\d{8}$" inputmode="numeric"
                                                placeholder="eg:500" value="{{ request()->min_followers }}"
                                                name="min_followers" class="form-element" />

                                        </div>
                                        <div class="form-control">
                                            <p class="limiters form-limiters">To : </p>
                                            <input type="number" pattern="^\d{8}$" inputmode="numeric"
                                                placeholder="eg:2000" value="{{ request()->max_followers }}"
                                                name="max_followers" class="form-element" />
                                        </div>

                                    </div>
                                </div>
                                <!-- End Form Filter -->
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Balance</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">

                                        <div class="form-control">
                                            <p class="limiters form-limiters">From : </p>
                                            <input type="number" pattern="^\d{8}$" inputmode="numeric"
                                                value="{{ request()->min_balance }}" name="min_balance"
                                                placeholder="eg:100" class="form-element" />

                                        </div>
                                        <div class="form-control">
                                            <p class="limiters form-limiters">To : </p>
                                            <input type="number" pattern="^\d{8}$" placeholder="eg:200"
                                                inputmode="numeric"value="{{ request()->max_balance }}"
                                                name="max_balance" class="form-element" />
                                        </div>

                                    </div>
                                </div>
                                <!-- End Form Filter -->
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Rate</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">

                                        <div class="form-control">
                                            <p class="limiters form-limiters">From : </p>
                                            <input type="number" pattern="^\d{3}$" inputmode="numeric"
                                                value="{{ request()->min_rate }}" name="min_rate" placeholder="eg:70"
                                                class="form-element" />

                                        </div>
                                        <div class="form-control">
                                            <p class="limiters form-limiters">To : </p>
                                            <input type="number" pattern="^\d{3}$" inputmode="numeric"
                                                value="{{ request()->max_rate }}" name="max_rate" placeholder="eg:90"
                                                class="form-element" />
                                        </div>

                                    </div>
                                </div>
                                <!-- End Form Filter -->
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Date</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">



                                        <div class="form-control">
                                            <p class="limiters form-limiters">From : </p>
                                            <input type="date" name="min_date" class="form-element"
                                                value="{{ request()->min_date }}">
                                        </div>
                                        <div class="form-control">
                                            <p class="limiters form-limiters">To : </p>
                                            <input type="date" name="max_date" class="form-element"
                                                value="{{ request()->max_date }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form Filter -->
                            </div>
                            <div class="buttons d-flex j-end gap-1 wrap mt-1">
                                <button type="reset" class="resetBtn">Reset</button>
                                <button type="submit" id="submitBtn" class="submitBtn">Filter</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if ($stores->count() > 0)
            <!-- Start Filter Form -->
            <!-- End Filter Form -->
            <div class="form-main">

                <div class="results">

                    <div class="results-holder  stores-grid">
                        @foreach ($stores as $store)
                            <!-- Start Store -->
                            <div class="card simple  store">
                                <header>
                                    <p class="status">Status: <span>{{ $store->status }}</span></p>
                                    <p class="rate"><i class="fa-light fa-star"></i> {{ $store->rate }}%</p>
                                </header>

                                <div class="info">
                                    <img loading="lazy" src="{{ asset('storage/' . $store->photo) }}" alt="">
                                    <h3><a href="{{ route('admin.store.home', $store->username) }}">{{ $store->name }}
                                            @php
                                                $currentDay = strtolower(date('l'));
                                                $currentTime = date('H:i:s');
                                                
                                                $openingHour = null;
                                                foreach ($store->openingHours as $hour) {
                                                    if ($hour['day_of_week'] === $currentDay) {
                                                        $openingHour = $hour;
                                                        break;
                                                    }
                                                }
                                                
                                                $isOpen = false;
                                                if ($openingHour && $currentTime >= $openingHour['opening_time'] && $currentTime <= $openingHour['closing_time']) {
                                                    $isOpen = true;
                                                }
                                            @endphp
                                        </a> <span class="status {{ $isOpen ? 'published' : '' }}"></span>
                                    </h3>
                                    <p>{{ $store->sector->name }}</p>
                                    <p>{{ $store->state_city }}</p>
                                    <div class="details d-flex col  j-center ">
                                        <div class="detail t-center">
                                            <p> <i class="fa-light fa-user-plus"></i> {{ $store->followers }} </p>

                                        </div>
                                        <div class="detail t-center">
                                            <p><i class="fa-light fa-dollar-sign"></i> {{ $store->balance }} DT</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Store -->
                        @endforeach
                    </div>


                    <!-- Start Pagination  -->
                    {!! $stores->appends(request()->input())->links() !!}
                    <!-- End Pagination   -->
                </div>
            </div>
        @else
            <!-- Start Not Found -->
            <div class="not-found-holder show">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p>No Results Found</p>
                </div>
            </div>
            <!-- End Not Found -->
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        function getCities(stateId) {
            // Get the selected state value
            // var stateId = document.querySelector('name[state]').value;
            const citiesHolder = document.getElementById('cities-holder')
            if (stateId == 'all') {
                citiesHolder.innerHTML = ''; // Clear existing options
                let choiceDiv = document.createElement('div')
                choiceDiv.className = 'choice';
                let input = document.createElement('input')
                input.type = 'radio'
                input.name = 'city_id'
                input.id = 'city_all'
                input.value = 'all'
                input.checked = true
                let label = document.createElement('label')
                label.setAttribute('for', 'city_all')
                label.textContent = 'All'
                choiceDiv.append(input)
                choiceDiv.append(label)
                citiesHolder.append(choiceDiv)
            } else {
                // Make an AJAX request to the server to fetch the cities based on the selected state
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        // Handle the response from the server
                        var cities = JSON.parse(xhr.responseText);

                        // Update the city select input options

                        citiesHolder.innerHTML = ''; // Clear existing options
                        let choiceDiv = document.createElement('div')
                        choiceDiv.className = 'choice';
                        let input = document.createElement('input')
                        input.type = 'radio'
                        input.name = 'city_id'
                        input.id = 'city_all'
                        input.value = 'all'
                        input.checked = true
                        let label = document.createElement('label')
                        label.setAttribute('for', 'city_all')
                        label.textContent = 'All'
                        choiceDiv.append(input)
                        choiceDiv.append(label)
                        citiesHolder.append(choiceDiv)

                        // Create new option elements for each city
                        cities.forEach(function(city) {
                            let choiceDiv = document.createElement('div')
                            choiceDiv.className = 'choice';
                            let input = document.createElement('input')
                            input.type = 'radio'
                            input.name = 'city_id'
                            input.id = `city_${city.id}`
                            input.value = city.id
                            let label = document.createElement('label')

                            label.setAttribute('for', `city_${city.id}`)
                            label.textContent = city.name


                            choiceDiv.append(input)
                            choiceDiv.append(label)
                            citiesHolder.append(choiceDiv)
                        });
                    }
                };

                // Send the AJAX request
                xhr.open('GET', '/api/cities/' + stateId, true);
                xhr.send();
            }
        }
    </script>
    <script>
        const filterForm = document.getElementById('filter-form')
        if (filterForm) {


            filterForm.addEventListener('submit', (e) => {
                e.preventDefault()
            })
            const filterHolderBtns = Array.from(document.querySelectorAll('.filter-holder-btn'))

            filterHolderBtns.forEach((btn) => {
                btn.addEventListener('click', () => {
                    let filterWrapper = btn.parentElement.nextElementSibling
                    filterWrapper.classList.toggle('hidden')
                })
            });


            const cittiesInput = document.getElementById('city-search');
            // liveSearch(cittiesInput, citiesChoices);
            const searchInput = document.getElementById('states-search');
            const stateChoices = document.querySelectorAll('.choices.states-choices .choice');
            const sectorInput = document.getElementById('sector-search')
            const sectorsChoices = document.querySelectorAll('.choices.sectors-choices .choice');
            liveSearch(searchInput, stateChoices);
            cittiesInput.addEventListener('input', () => {

                const citiesChoices = document.querySelectorAll('.choices.cities-choices .choice');

                liveSearch(cittiesInput, citiesChoices);
            })

            liveSearch(sectorInput, sectorsChoices);

            function liveSearch(searchInput, choicesArray) {
                searchInput.addEventListener('input', () => {
                    const searchText = searchInput.value.toLowerCase(); // Get the typed search text

                    // Iterate over each state choice
                    choicesArray.forEach((choice) => {
                        const label = choice.querySelector('label');
                        const stateName = label.textContent.toLowerCase();

                        if (stateName.includes(searchText)) {
                            // If the state name contains the search text, show the choice
                            choice.style.display = 'flex';
                        } else {
                            // Otherwise, hide the choice
                            choice.style.display = 'none';

                        }
                    });
                });
            }

            const submitBtn = document.getElementById('submitBtn')
            submitBtn.addEventListener('click', () => {
                filterForm.submit()
            })
            const choices = document.querySelectorAll('.choices .choice')
            const resetBtn = document.querySelector('.resetBtn')
            resetBtn.addEventListener('click', () => {
                choices.forEach(choice => {
                    choice.style.display = 'flex'
                })
            })
        }
    </script>
    @include('components.inc_modals-js')
@endpush
