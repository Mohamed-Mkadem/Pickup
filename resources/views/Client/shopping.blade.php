@extends('layouts.Client')

@push('title')
    <title>Pickup | Shopping</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Shopping</h1>
        </div>
        <!-- Start Filters Form -->


        <!-- Start Filters Form -->
        <form action="{{ route('client.shopping.filter') }}" method="GET" id="filter-form">
            <div class="form-grid stores-holder">
                <div class="filters-holder">
                    <div class="filters-header d-flex j-sp-between a-center">
                        <h2>Filters</h2>
                        <button id="filters-wrapper-controller" aria-controls="filters-wrapper"><i
                                class="fa-light fa-circle-caret-down"></i></button>
                    </div>
                    <div class="filters-wrapper" id="filters-wrapper">
                        <div class="form-sidebar  mt-1 fixed-sidebar">
                            <div class="form-grid-row row2">
                                <div class="form-control m-0">
                                    <input type="search" class="form-element" name="search"
                                        placeholder="Type A Product Name" value="{{ request()->search }}">

                                </div>
                                <div class="form-control m-0">
                                    <div class="select-box">
                                        <select name="sort" class="form-element">


                                            <option value="a-z"
                                                {{ request()->input('sort') === 'a-z' ? 'selected' : '' }}>
                                                A - Z</option>
                                            <option value="z-a"
                                                {{ request()->input('sort') === 'z-a' ? 'selected' : '' }}>
                                                Z - A</option>
                                            <option value="highest_sale_price"
                                                {{ request()->input('sort') === 'highest_sale_price' ? 'selected' : '' }}>
                                                Highest price</option>
                                            <option value="lowest_sale_price"
                                                {{ request()->input('sort') === 'lowest_sale_price' ? 'selected' : '' }}>
                                                Lowest price</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-column g-250 mt-1">
                                <!-- Start Form Filter -->
                                <div class="filter-holder ">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label ">Brands</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">
                                        <div class="form-control">
                                            <input type="search" class="form-element" placeholder="Brand Name"
                                                id="brands-search">
                                        </div>

                                        <div class="choices brands-choices">
                                            @foreach ($brands as $brand)
                                                <div class="choice">
                                                    <input type="checkbox" name="brands[]" id="{{ 'brand_' . $brand->id }}"
                                                        {{ in_array($brand->id, (array) request()->input('brands')) ? 'checked' : '' }}
                                                        value="{{ $brand->id }}">
                                                    <label for="{{ 'brand_' . $brand->id }}">{{ $brand->name }}</label>
                                                </div>
                                            @endforeach


                                        </div>

                                    </div>

                                </div>
                                <!-- End Form Filter -->
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Sectors</label>
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
                                                    <label for="{{ 'sector_' . $sector->id }}">{{ $sector->name }}</label>
                                                </div>
                                            @endforeach


                                        </div>

                                    </div>
                                </div>
                                <!-- End Form Filter -->


                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Price (DT)</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">

                                        <div class="form-control">
                                            <p class="limiters form-limiters">From : </p>
                                            <input type="number" pattern="^\d{8}$" inputmode="numeric" step="0.01"
                                                placeholder="eg:5" name="min_price" value="{{ request()->min_price }}"
                                                class="form-element" />

                                        </div>
                                        <div class="form-control">
                                            <p class="limiters form-limiters">To : </p>
                                            <input type="number" pattern="^\d{8}$" inputmode="numeric" step="0.01"
                                                placeholder="eg:50" name="max_price" value="{{ request()->max_price }}"
                                                class="form-element" />
                                        </div>

                                    </div>
                                </div>
                                <!-- End Form Filter -->
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">States</label>
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
                                                    <input type="radio" name="state_id"
                                                        id="{{ 'state_' . $state->id }}" value="{{ $state->id }}"
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
                                        <label for="" class="form-label">Cities</label>
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
                                        <label for="" class="form-label">Store Rate</label>
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
        <!-- End Filters Form -->

        @if ($products->count() > 0)
            <div class="results mt-2">

                <div class="results-holder shopping-grid">
                    @foreach ($products as $product)
                        <!-- Start Product  -->
                        <div class="product holder radius-10">
                            <div class="product-header d-flex j-sp-between a-center wrap gap-1">
                                <p class="state-city">{{ $product->store->state_city }}</p>
                                <p class="rate "><i class="fa-light fa-star"></i> {{ $product->store->rate }}%</p>
                            </div>
                            <div class="img-holder mt-1">
                                <img src="{{ asset('storage/' . $product->image) }}" class=" radius-10" alt="">
                            </div>
                            <div class="info-holder">
                                <h3 class="product-name"><a
                                        href="{{ route('client.store.product', ['username' => $product->store->username, 'id' => $product->id]) }}"
                                        title="{{ $product->name }}">{{ $product->name }}</a>
                                </h3>
                                <p class="product-brand">{{ $product->brand->name }}</p>
                                <p class="product-brand">{{ $product->store->sector->name }}</p>
                                <p class="product-price">{{ number_format($product->price, 3, ',') }} <small>DT</small>
                                </p>
                            </div>
                            <p class="store-name"><a
                                    href="{{ route('client.store.home', $product->store->username) }}">{{ $product->store->name }}</a>
                            </p>
                        </div>
                        <!-- End Product  -->
                    @endforeach


                </div>
                <!-- Start Pagination -->
                {!! $products->appends(request()->input())->links() !!}
                <!-- End Pagination -->
            </div>
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



        const searchInput = document.getElementById('states-search');
        const stateChoices = document.querySelectorAll('.choices.states-choices .choice');
        const cittiesInput = document.getElementById('city-search');

        const citiesChoices = document.querySelectorAll('.choices.cities-choices .choice');

        const sectorInput = document.getElementById('sector-search')
        const sectorsChoices = document.querySelectorAll('.choices.sectors-choices .choice');
        const brandsSearch = document.getElementById('brands-search')
        const brandsChoices = document.querySelectorAll('.choices.brands-choices .choice');
        liveSearch(brandsSearch, brandsChoices)
        liveSearch(searchInput, stateChoices);
        liveSearch(cittiesInput, citiesChoices);
        liveSearch(sectorInput, sectorsChoices);

        function liveSearch(searchInput, choicesArray) {
            searchInput.addEventListener('input', () => {
                const searchText = searchInput.value.toLowerCase(); // Get the typed search text

                // Iterate over each state choice
                choicesArray.forEach((choice) => {
                    const label = choice.querySelector('label');
                    const choiceName = label.textContent.toLowerCase();

                    if (choiceName.includes(searchText)) {
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
    </script>
@endpush
