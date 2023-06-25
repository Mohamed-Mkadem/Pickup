@extends('layouts.Seller')

@push('title')
    <title>Pickup | Products</title>
@endpush
@section('content')

    <section class="content" id="content">

        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Products</h1>
            <!-- Start Link  -->
            <a href="{{ route('seller.products.create') }}" class="header-btn d-block add-btn">
                <i class="fa-light fa-plus"></i>
                <span>New Product</span>
            </a>
            <!-- End Link  -->
        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        <!-- Start Filter Form -->
        <form action="{{ route('seller.products.filter') }}" method="get" id="filter-form">
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
                                        value="{{ request()->search }}" placeholder="Type A Product Name">

                                </div>
                                <div class="form-control m-0">
                                    <div class="select-box">
                                        <select name="sort" class="form-element">

                                            <option value="newest"
                                                {{ request()->input('sort') === 'newest' ? 'selected' : '' }}>
                                                Newest</option>
                                            <option value="oldest"
                                                {{ request()->input('sort') === 'oldest' ? 'selected' : '' }}>
                                                Oldest</option>
                                            <option value="highest_sale_price"
                                                {{ request()->input('sort') === 'highest_sale_price' ? 'selected' : '' }}>
                                                Highest sale price</option>
                                            <option value="lowest_sale_price"
                                                {{ request()->input('sort') === 'lowest_sale_price' ? 'selected' : '' }}>
                                                Lowest sale price</option>
                                            <option value="highest_quantity"
                                                {{ request()->input('sort') === 'highest_quantity' ? 'selected' : '' }}>
                                                Highest Quantity</option>
                                            <option value="lowest_quantity"
                                                {{ request()->input('sort') === 'lowest_quantity' ? 'selected' : '' }}>
                                                Lowest Quantity</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-column g-250 mt-1">
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
                                        <label for="" class="form-label">Statuses</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">


                                        <div class="choices">

                                            <div class="choice">
                                                <input type="checkbox" id="active" name="statuses[]" value="active"
                                                    {{ in_array('active', (array) request()->input('statuses')) ? 'checked' : '' }}>
                                                <label for="active">active</label>
                                            </div>
                                            <div class="choice">
                                                <input type="checkbox" id="inactive" name="statuses[]" value="inactive"
                                                    {{ in_array('inactive', (array) request()->input('statuses')) ? 'checked' : '' }}>
                                                <label for="inactive">inactive</label>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- End Form Filter -->
                                </div>
                                <!-- Start Form Filter -->
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Stock Statuses</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">


                                        <div class="choices">

                                            <div class="choice">
                                                <input type="checkbox" id="in_stock" name="stock_statuses[]"
                                                    value="in stock"
                                                    {{ in_array('in stock', (array) request()->input('stock_statuses')) ? 'checked' : '' }}>
                                                <label for="in_stock">in stock</label>
                                            </div>
                                            <div class="choice">
                                                <input type="checkbox" id="out_of_stock" name="stock_statuses[]"
                                                    value="out of stock"
                                                    {{ in_array('out of stock', (array) request()->input('stock_statuses')) ? 'checked' : '' }}>
                                                <label for="out_of_stock">out of stock</label>
                                            </div>
                                            <div class="choice">
                                                <input type="checkbox" id="stock_alert" name="stock_statuses[]"
                                                    value="stock alert"
                                                    {{ in_array('stock alert', (array) request()->input('stock_statuses')) ? 'checked' : '' }}>
                                                <label for="stock_alert">stock alert</label>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- End Form Filter -->
                                </div>
                                <!-- Start Form Filter -->
                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Units</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">


                                        <div class="choices">

                                            <div class="choice">
                                                <input type="checkbox" id="piece" name="units[]"
                                                    {{ in_array('piece', (array) request()->input('units')) ? 'checked' : '' }}
                                                    value="piece">
                                                <label for="piece">piece</label>
                                            </div>
                                            <div class="choice">
                                                <input type="checkbox" id="weight" name="units[]"
                                                    {{ in_array('weight', (array) request()->input('units')) ? 'checked' : '' }}
                                                    value="weight">
                                                <label for="weight">weight</label>
                                            </div>
                                            <div class="choice">
                                                <input type="checkbox" id="liquid" name="units[]"
                                                    {{ in_array('liquid', (array) request()->input('units')) ? 'checked' : '' }}
                                                    value="liquid">
                                                <label for="liquid">liquid</label>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- End Form Filter -->
                                </div>

                                <!-- Start Form Filter -->
                                <div class="filter-holder">
                                    <div class="filter-header  d-flex j-sp-between a-center">
                                        <label for="" class="form-label">Sale Price (DT)</label>
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
                                        <label for="" class="form-label">Quantity</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">

                                        <div class="form-control">
                                            <p class="limiters form-limiters">From : </p>
                                            <input type="number" pattern="^\d{3}$" inputmode="numeric"
                                                name="min_quantity" placeholder="eg:5"
                                                value="{{ request()->min_quantity }}" class="form-element" />

                                        </div>
                                        <div class="form-control">
                                            <p class="limiters form-limiters">To : </p>
                                            <input type="number" placeholder="eg:50" pattern="^\d{3}$"
                                                inputmode="numeric" name="max_quantity"
                                                value="{{ request()->max_quantity }}" class="form-element" />
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
        <!-- End Filter Form -->
        @if ($products->count() > 0)
            <div class="results">

                <!-- Start Results Holder -->
                <div class=" main-holder">
                    <div class="table-responsive products-list">
                        <table>

                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Unit </th>
                                    <th> Quantity </th>
                                    <th> Status </th>
                                    <th> Price (DT) </th>

                                    <th>Stock Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td><img loading="lazy" src="{{ asset('storage/' . $product->image) }}"></td>
                                        <td><a href="{{ route('seller.products.show', $product->id) }}"
                                                title="{{ $product->name }}">{{ $product->name }}</a></td>
                                        <td title="Category Name">{{ $product->category->name }}</td>
                                        <td title="Brand Name">{{ $product->brand->name }}</td>
                                        <td> {{ $product->unit }}</td>
                                        <td> {{ $product->quantity }}</td>
                                        <td>{{ $product->status }}</td>
                                        <td>{{ $product->price }}</td>
                                        @if ($product->quantity == 0)
                                            <td class="status out-of-stock"><span>Out Of Stock</span></td>
                                        @elseif ($product->stock_alert < $product->quantity)
                                            <td class="status in-stock"><span>In Stock</span></td>
                                        @elseif($product->stock_alert >= $product->quantity)
                                            <td class="status stock-alert"><span>Stock Alert</span></td>
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Results Holder -->


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
        const filterForm = document.getElementById('filter-form')
        filterForm.addEventListener('submit', (e) => {
            e.preventDefault()
        })
        const filterHolderBtns = Array.from(document.querySelectorAll('.filter-holder-btn'))

        filterHolderBtns.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault()
                let filterWrapper = btn.parentElement.nextElementSibling
                filterWrapper.classList.toggle('hidden')
            })
        });
        const categoriesSearch = document.getElementById('categories-search')
        const categoriesChoices = document.querySelectorAll('.choices.categories-choices .choice');

        const brandsSearch = document.getElementById('brands-search')
        const brandsChoices = document.querySelectorAll('.choices.brands-choices .choice');
        liveSearch(brandsSearch, brandsChoices)
        liveSearch(categoriesSearch, categoriesChoices)

        function liveSearch(searchInput, choicesArray) {
            searchInput.addEventListener('input', () => {
                const searchText = searchInput.value.toLowerCase();

                choicesArray.forEach((choice) => {
                    const label = choice.querySelector('label');
                    const stateName = label.textContent.toLowerCase();

                    if (stateName.includes(searchText)) {

                        choice.style.display = 'flex';
                    } else {

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
