@extends('layouts.Seller')

@push('title')
    <title>Pickup | Inventory</title>
@endpush
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Inventory</h1>
        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        <!-- Start Quick Stats Holder -->
        <div class="quick-stats-holder ">
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Stock Cost (DT)</p>
                        <p class="box-value light">{{ $inventoryFinancials['stock_cost'] }}</p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-solid fa-sack-dollar placed"></i>
                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Stock Price (DT)</p>
                        <p class="box-value light">{{ $inventoryFinancials['stock_price'] }}</p>
                    </div>

                    <div class="icon-holder">

                        <i class="fa-solid fa-sack-dollar accepted"></i>
                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->


            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Expected Earnings (DT)</p>
                        <p class="box-value light">{{ $inventoryFinancials['expected_earnings'] }}</p>
                    </div>

                    <div class="icon-holder">

                        <i class="fa-solid fa-sack-dollar ready"></i>
                        <!-- <i class="fa-solid fa-square-xmark rejected"></i> -->

                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->

        </div>
        <!-- End Quick Stats Holder -->
        <!-- Start Quick Stats Holder -->
        <div class="quick-stats-holder ">
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">All</p>
                        <p class="box-value light">{{ $inventoryStatuses['all'] }}</p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-solid fa-box all"></i>
                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">In Stock</p>
                        <p class="box-value light">{{ $inventoryStatuses['inStock'] }}</p>
                    </div>

                    <div class="icon-holder">

                        <i class="fa-solid fa-box accepted"></i>
                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->


            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Stock Alert</p>
                        <p class="box-value light">{{ $inventoryStatuses['stockAlert'] }}</p>
                    </div>

                    <div class="icon-holder">

                        <i class="fa-solid fa-warning info"></i>


                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Out Of Stock</p>
                        <p class="box-value light">{{ $inventoryStatuses['outOfStock'] }}</p>
                    </div>

                    <div class="icon-holder">

                        <i class="fa-solid fa-xmark rejected"></i>


                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->

        </div>
        <!-- End Quick Stats Holder -->


        <!-- Start Filters -->


        <form action="{{ route('seller.inventory.filter') }}" method="get" id="filter-form">
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
                                            <option value="highest_cost_price"
                                                {{ request()->input('sort') === 'highest_cost_price' ? 'selected' : '' }}>
                                                Highest Cost price</option>
                                            <option value="lowest_cost_price"
                                                {{ request()->input('sort') === 'lowest_cost_price' ? 'selected' : '' }}>
                                                Lowest Cost price</option>
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
                                                    <input type="checkbox" name="brands[]"
                                                        id="{{ 'brand_' . $brand->id }}"
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
                                        <label for="" class="form-label">Cost Price (DT)</label>
                                        <button class="filter-holder-btn">
                                            <i class="fa-light fa-circle-caret-down"></i>
                                        </button>
                                    </div>
                                    <div class="filter-wrapper">

                                        <div class="form-control">
                                            <p class="limiters form-limiters">From : </p>
                                            <input type="number" pattern="^\d{8}$" inputmode="numeric" step="0.01"
                                                placeholder="eg:5" name="min_sale_price"
                                                value="{{ request()->min_sale_price }}" class="form-element" />

                                        </div>
                                        <div class="form-control">
                                            <p class="limiters form-limiters">To : </p>
                                            <input type="number" pattern="^\d{8}$" inputmode="numeric" step="0.01"
                                                placeholder="eg:50" name="max_sale_price"
                                                value="{{ request()->max_sale_price }}" class="form-element" />
                                        </div>

                                    </div>
                                </div>
                                <!-- End Form Filter -->
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
        <!-- End Filters -->

        @if ($products->count() > 0)
            <!-- Start Results -->
            <div class="results">
                <h2 class="t-left">Results</h2>
                <!-- Start Results Holder -->
                <div class=" main-holder">
                    <div class="table-responsive inventory-table">
                        <table>

                            <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    <th>Unit</th>
                                    <th>Cost Price <span>(DT)</span></th>
                                    <th>Sale Price <span>(DT)</span></th>
                                    <th>Quantity </th>
                                    <th>Stock Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <ul class="actions d-flex j-center">
                                                <li>
                                                    <button class="td-btn manageBtn"><i
                                                            class="fa-light fa-gear"></i></button>
                                                    <div class="modal-holder ">
                                                        <div class="modal form-modal">
                                                            <div class="modal-header d-flex j-sp-between a-center">
                                                                <h2>Manage Product</h2>
                                                                <button class="close-modal-holder-btn"><i
                                                                        class="fa-light fa-close"></i></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('seller.inventory.manage', $product->id) }}"
                                                                    method="post" class="manage-form">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="form-control">

                                                                        <div class="filter-box">
                                                                            <label for=""
                                                                                class="form-label required">Operation</label>
                                                                            <div class="select-box">
                                                                                <select name="operation"
                                                                                    class="form-element">
                                                                                    <option value="add">Add</option>
                                                                                    <option value="deduct">Deduct
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <p class="error-message">This Field Is
                                                                                Required</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-control">
                                                                        <label for=""
                                                                            class="d-block required form-label">
                                                                            Quantity
                                                                        </label>
                                                                        <input type="number" name="quantity"
                                                                            placeholder="eg: 50"
                                                                            class="form-element quantity-input">
                                                                        <p class="error-message">This Field Is
                                                                            Required</p>
                                                                    </div>
                                                                    <div class="form-control d-flex j-end">
                                                                        <button type="submit"
                                                                            class="submitBtn">Confirm</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                        <td><img loading="lazy" src="{{ asset('storage/' . $product->image) }}"
                                                alt=""></td>
                                        <td><a
                                                href="{{ route('seller.products.show', $product->id) }}">{{ $product->name }}</a>
                                        </td>
                                        <td>{{ $product->brand->name }}</td>
                                        <td>{{ $product->unit }}</td>
                                        <td>{{ $product->cost_price }}</td>
                                        <td>{{ $product->price }}</td>

                                        <td>{{ $product->quantity }}</td>
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
    <script>
        const manageBtns = document.querySelectorAll('.manageBtn')
        const manageForms = document.querySelectorAll('.manage-form')
        manageForms.forEach((form) => {
            form.addEventListener('submit', (e) => {
                e.preventDefault()
                let errors = 0
                let actionTypeInput = form.elements[2]
                let actionTypeInputErrorMessage = actionTypeInput.parentElement.nextElementSibling
                let quantityInput = form.elements[3]
                let quantityInputErrorMessage = quantityInput.nextElementSibling


                // errors += validateField(actionTypeInput, actionTypeInputErrorMessage)
                // errors += validateNumber(quantityInput, quantityInputErrorMessage, 1)


                if (!errors) form.submit()
            })
        })

        function validateNumber(field, errorMsg, minValue = 0) {
            let errors = 0
            if (!field.value || field.value <= 0) {

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
        manageBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                let modalHolder = btn.nextElementSibling
                modalHolder.classList.add('show')
                document.body.classList.add('no-scroll')
            })
        })

        function validateField(field, errorMessage) {
            let errors = 0
            if (!field.value) {
                errorMessage.textContent = 'This Field Is Required'
                errorMessage.classList.add('show')
                errors = 1
            } else {
                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                errors = 0
            }
            return errors
        }
    </script>
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
    @include('components.inc_modals-js')
@endpush
