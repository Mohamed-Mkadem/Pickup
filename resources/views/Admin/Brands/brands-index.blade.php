@extends('layouts.Admin')

@push('title')
    <title>Pickup | Brands</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Brands</h1>
            <!-- Start Link  -->
            <a href="{{ route('admin.brands.create') }}" class="header-btn d-block add-btn">
                <i class="fa-light fa-plus"></i>
                <span>Add Brand</span>
            </a>
            <!-- End Link  -->
        </div>
        <!-- End Starter Header -->

        @include('components.session-errors-alert')
        @include('components.errors-alert')
        @include('components.success-alert')

        <!-- Start Filters -->
        <div class="filters-holder">
            <div class="filters-header d-flex j-sp-between a-center">
                <h2>Filters</h2>
                <button id="filters-wrapper-controller" aria-controls="filters-wrapper"><i
                        class="fa-light fa-circle-caret-down"></i></button>
            </div>
            <div class="filters-wrapper" id="filters-wrapper">
                <form action="{{ route('admin.brands.filter') }}" method="get">
                    <div class="filter-row row3">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->input('search') }}"
                                placeholder="Search For Brand Name" class="form-element">
                        </div>

                        <div class="filter-box">
                            <label for="" class="form-label">Status </label>
                            <div class="choices-btns-wrapper  ">
                                <div class="choice-btn form-element">
                                    <label for="active-input"> active</label>
                                    <input type="checkbox"
                                        {{ in_array('Active', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="active-input" name="status[]" value="Active">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="inactive-input">inactive</label>
                                    <input type="checkbox"
                                        {{ in_array('Inactive', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="inactive-input" name="status[]" value="Inactive">
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
                            <label for="" class="form-label">N° Of Products</label>
                            <div class="numbers-range-boxes filter-row sm-row2 ">
                                <div class="number-box min-grid">
                                    <p class="limiters form-limiters">From : </p>
                                    <input type="number" pattern="^\d{8}$" inputmode="numeric" value="0"
                                        class="form-element" name="product_min" />

                                </div>
                                <div class="number-box min-grid">
                                    <p class="limiters form-limiters">To : </p>
                                    <input type="number" pattern="^\d{8}$" inputmode="numeric" value="1000"
                                        class="form-element" name="product_max" />
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

        @if ($brands->count() > 0)
            <!-- Start Results -->
            <div class="results">
                <h2 class="mb-1 t-left">Results : {{ $brands->count() }}</h2>
                <div class="results-holder main-holder brands">
                    @foreach ($brands as $brand)
                        <!-- Start Brand -->
                        <div class="brand card simple">
                            <header>
                                <p class="status">Status : <span>{{ $brand->status }}</span></p>
                                <button class="actions-controller"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="actions-holder ">
                                    <li>
                                        <a href="{{ route('admin.brands.edit', $brand->id) }}">Edit</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.brands.show', $brand->id) }}">Show</a>
                                    </li>
                                    <li>
                                        <button class="deleteBtn">Remove</button>
                                        <div class="modal-holder ">
                                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="post"
                                                class="modal t-center confirm-form">
                                                @csrf
                                                @method('DELETE')
                                                <i class=" fa-light fa-trash"></i>
                                                <p>Are You Sure You Want To Delete This Brand ?</p>
                                                <div class="buttons d-flex j-center a-center">
                                                    <button class="cancelBtn">Cancel</button>
                                                    <button class="confirmBtn">Yes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </li>

                                </ul>
                            </header>

                            <div class="info">
                                <img loading="lazy" src="{{ asset('storage/' . $brand->logo) }}" alt="">
                                <h3><a href="{{ route('admin.brands.show', $brand->id) }}">{{ $brand->name }}</a></h3>
                                <p>15 Products</p>
                                <p> {{ \Carbon\Carbon::parse($brand->created_at)->format('M jS Y') }} </p>
                            </div>
                        </div>
                        <!-- End Brand -->
                    @endforeach
                </div>

                {!! $brands->appends(request()->input())->links() !!}

            </div>
            <!-- End Results -->
        @else
            <div class="not-found-holder show">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p>No Brands Found!</p>
                </div>
            </div>
        @endif
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('dist/js/modals.js') }}"></script>
@endpush
