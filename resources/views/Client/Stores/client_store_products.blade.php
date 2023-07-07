@extends('layouts.client-store')

@push('title')
    <title>{{ $store->name }} | Products</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @if ($store->status == 'unpublished')
            <div class="unavailable-wrapper d-flex col a-center ">
                <img src="{{ asset('dist/Assets/404_error.svg') }}" alt="">
                <p class="info-message">This store's subscription has expired, and it is no
                    longer available for browsing or making purchases. It will remain inaccessible until the
                    store owner purchases a new subscription. We apologize for any inconvenience caused. In the
                    meantime, feel free to check out our other active stores for your shopping needs.</p>
                <div class="buttons d-flex j-sp-between a-center gap-1 wrap mt-1">
                    <a href="{{ url()->previous() }}" class="go-back">Go Back</a>
                    <a href="{{ route('client.shopping') }}" class="shopping">Shopping</a>
                </div>
            </div>
        @elseif($store->status == 'maintenance')
            <div class="unavailable-wrapper d-flex col a-center ">
                <img src="{{ asset('dist/Assets/maintenance.svg') }}" alt="">
                <p class="info-message">This store is currently undergoing maintenance to improve your shopping
                    experience. The store owner is working diligently
                    to complete the necessary fixes and updates. Once the maintenance is finished, the store
                    will be published again. Thank you for your patience and understanding</p>
                <div class="buttons d-flex j-sp-between a-center gap-1 wrap mt-1">
                    <a href="{{ url()->previous() }}" class="go-back">Go Back</a>
                    <a href="{{ route('client.shopping') }}" class="shopping">Shopping</a>
                </div>
            </div>
        @else
            @include('components.errors-alert')
            @include('components.session-errors-alert')
            @include('components.success-alert')
            @include('components.Stores.client-store-header', ['store' => $store])
            <!-- Start Store Content -->
            <div class="store-content mt-2">
                <form action="{{ route('client.store.products.filter', $store->username) }}" method="get"
                    id="filter-form">
                    <div class="form-grid products">
                        <div class="filters-holder ">
                            <div class="filters-header d-flex j-sp-between a-center">
                                <h2>Filters</h2>
                                <button id="filters-wrapper-controller" aria-controls="filters-wrapper"><i
                                        class="fa-light fa-circle-caret-down"></i></button>
                            </div>
                            <div class="filters-wrapper" id="filters-wrapper">
                                <div class="form-sidebar mt-1 fixed-sidebar">
                                    <div class="form-grid-row  row2">
                                        <div class="filter-box">
                                            <label for="" class="form-label">Search</label>
                                            <input type="search" class="form-element" name="search"
                                                value="{{ request()->search }}" placeholder="Type A Product Name">
                                        </div>

                                        <div class="filter-box">
                                            <label for="" class="form-label">Sort By</label>
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
                                    <div class="filter-column mt-1 ">
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
                                                            <input type="checkbox" name="brands[]"
                                                                id="{{ 'brand_' . $brand->id }}"
                                                                {{ in_array($brand->id, (array) request()->input('brands')) ? 'checked' : '' }}
                                                                value="{{ $brand->id }}">
                                                            <label
                                                                for="{{ 'brand_' . $brand->id }}">{{ $brand->name }}</label>
                                                        </div>
                                                    @endforeach


                                                </div>

                                            </div>

                                        </div>
                                        <!-- End Form Filter -->
                                        <!-- Start Form Filter -->
                                        <div class="filter-holder ">
                                            <div class="filter-header  d-flex j-sp-between a-center">
                                                <label for="" class="form-label ">Categories</label>
                                                <button class="filter-holder-btn">
                                                    <i class="fa-light fa-circle-caret-down"></i>
                                                </button>
                                            </div>
                                            <div class="filter-wrapper">
                                                <div class="form-control">
                                                    <input type="search" class="form-element" placeholder="Category Name"
                                                        id="categories-search">
                                                </div>

                                                <div class="choices categories-choices">

                                                    @foreach ($categories as $category)
                                                        <div class="choice">
                                                            <input type="checkbox" name="categories[]"
                                                                id="{{ 'category_' . $category->id }}"
                                                                {{ in_array($category->id, (array) request()->input('categories')) ? 'checked' : '' }}
                                                                value="{{ $category->id }}">
                                                            <label
                                                                for="{{ 'category_' . $category->id }}">{{ $category->name }}</label>
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
                                                    <input type="number" pattern="^\d{8}$" inputmode="numeric"
                                                        step="0.01" placeholder="eg:5" name="min_price"
                                                        value="{{ request()->min_price }}" class="form-element" />

                                                </div>
                                                <div class="form-control">
                                                    <p class="limiters form-limiters">To : </p>
                                                    <input type="number" pattern="^\d{8}$" inputmode="numeric"
                                                        step="0.01" placeholder="eg:50" name="max_price"
                                                        value="{{ request()->max_price }}" class="form-element" />
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


                @if ($products->count() > 0)
                    <div class="results">

                        <div class="results-holder mt-2 products-holder">
                            @foreach ($products as $product)
                                <!-- Start Product  -->
                                <div class="product holder radius-10">
                                    <div class="img-holder ">
                                        <img src="{{ asset('storage/' . $product->image) }}" class=" radius-10"
                                            alt="">
                                    </div>
                                    <div class="info-holder">
                                        <h3 class="product-name">{{ $product->name }}</h3>
                                        <p class="product-brand">{{ ucfirst($product->brand->name) }}</p>
                                        <p class="product-price">{{ $product->price }} <small>DT</small></p>
                                    </div>
                                    <div class="actions d-flex j-sp-between a-center gap-0-5 wrap">
                                        <form action="" method="post">
                                            <button type="submit"><i class="fa-light fa-cart-shopping"></i></button>
                                        </form>
                                        <a
                                            href="{{ route('client.store.product', ['username' => $store->username, 'id' => $product->id]) }}"><i
                                                class="fa-light fa-eye"></i></a>
                                    </div>
                                </div>
                                <!-- End Product  -->
                            @endforeach
                        </div>
                        {!! $products->appends(request()->input())->links() !!}
                    </div>
                @else
                    <div class="not-found-holder show">
                        <div class="wrapper">
                            <i class="fa-light fa-circle-info"></i>
                            <p>No Products Found!</p>
                        </div>
                    </div>
                @endif
            </div>


        @endif
    </section>
@endsection

@push('scripts')
    <script>
        const filterHolderController = document.getElementById(
            "filters-wrapper-controller"
        );
        const filtersWrapper = document.getElementById("filters-wrapper");
        if (filterHolderController) {
            filterHolderController.addEventListener("click", (e) => {

                filtersWrapper.classList.toggle("hidden");
            });
        }

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
        const submitBtn = document.getElementById('submitBtn')
        submitBtn.addEventListener('click', () => {
            filterForm.submit()
        })
        const brandsSearch = document.getElementById('brands-search')
        const brandsChoices = document.querySelectorAll('.choices.brands-choices .choice');
        const categoriesSearch = document.getElementById('categories-search')
        const categoriesChoices = document.querySelectorAll('.choices.categories-choices .choice');

        liveSearch(categoriesSearch, categoriesChoices)
        liveSearch(brandsSearch, brandsChoices)

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
    </script>
@endpush
