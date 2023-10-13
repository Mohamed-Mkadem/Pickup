@extends('layouts.Admin')

@push('title')
    <title>Pickup | Expenses </title>
@endpush
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Expenses</h1>

            <button class="header-btn add-btn pop-up-controller" id="add-btn"> <i class="fa-light fa-plus"></i> New
                Expense</button>
            <div class="pop-up-holder  ">
                <div class="pop-up form-pop-up lg">
                    <div class="pop-up-header d-flex j-sp-between a-center">
                        <h2>Add Expense</h2>
                        <button class="close-pop-up-btn"><i class="fa-light fa-close"></i></button>
                    </div>
                    <div class="pop-up-body">
                        <!-- Start Form -->
                        <form action="{{ route('admin.expenses.store') }}" method="post" id="add-form">
                            @csrf
                            <div class="form-row  ">
                                <div class="col">
                                    <div class="form-control">
                                        <label for="" class="d-block required form-label">
                                            Title :
                                        </label>
                                        <input type="text" name="title" value="{{ old('title', '') }}" id="title-input"
                                            placeholder="Expense Title" class="form-element">
                                        <p class="error-message">This Field is Required</p>
                                    </div>
                                    <div class="form-control">
                                        <label for="" class="form-label required">Category</label>
                                        <div class="select-box">
                                            <select name="category" class="form-element" id="category-input">
                                                <option value="Operating Costs">Operating Costs</option>
                                            </select>
                                        </div>
                                        <p class="error-message" id="category-input-error-message">This
                                            Field Is
                                            Required</p>
                                    </div>
                                    <div class="form-control">
                                        <label for="" class="form-label required">Amount (DT)</label>
                                        <input type="number" step="0.1" value="{{ old('amount', '') }}" name="amount"
                                            id="value-input" class="form-element" placeholder="eg: 100 ">
                                        <p class="error-message">This Field Is Required</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="editor-holder pop-up-editor">
                                        <label for="" class="form-label required">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10">{{ old('description', '') }}</textarea>
                                        <p class="error-message" id="description-error-message">This Field
                                            Is Required
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-control d-flex j-end">
                                <button type="submit">Add</button>
                            </div>
                        </form>
                        <!-- End Form -->

                    </div>
                </div>
            </div>
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
                        <p class="box-title">Total (DT)</p>
                        <p class="box-value">{{ Auth::user()->getExpenseStatistics()['currentPeriod']['total'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar today"></i>
                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Today (DT)</p>
                        <p class="box-value">{{ Auth::user()->getExpenseStatistics()['currentPeriod']['day'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar today"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value
                        @if (Auth::user()->getExpenseStatistics()['difference']['day'] > 0) success
                        @elseif(Auth::user()->getExpenseStatistics()['difference']['day'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ Auth::user()->getExpenseStatistics()['difference']['day'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Day</p>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Week (DT)</p>
                        <p class="box-value">{{ Auth::user()->getExpenseStatistics()['currentPeriod']['week'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar week"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if (Auth::user()->getExpenseStatistics()['difference']['week'] > 0) success
                        @elseif(Auth::user()->getExpenseStatistics()['difference']['week'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ Auth::user()->getExpenseStatistics()['difference']['week'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Week</p>
                </div>
                <!-- End Bottom Info -->
            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Month (DT)</p>
                        <p class="box-value">{{ Auth::user()->getExpenseStatistics()['currentPeriod']['month'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar month"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if (Auth::user()->getExpenseStatistics()['difference']['month'] > 0) success
                        @elseif(Auth::user()->getExpenseStatistics()['difference']['month'] < 0)
                            danger @endif
                        
                        ">
                            <span>{{ Auth::user()->getExpenseStatistics()['difference']['month'] }}</span>
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
                        <p class="box-title">Year (DT)</p>
                        <p class="box-value">{{ Auth::user()->getExpenseStatistics()['currentPeriod']['year'] }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-light fa-dollar year"></i>
                    </div>

                </div>
                <!-- End Top Info -->
                <!-- Start Bottom Info -->
                <div class="bottom-info d-flex j-start a-center tickets-list">
                    <div class="progression-box">

                        <p
                            class="progression-value 
                        @if (Auth::user()->getExpenseStatistics()['difference']['year'] > 0) success
                        @elseif(Auth::user()->getExpenseStatistics()['difference']['year'] < 0)
                            danger @endif
                        ">
                            <span>{{ Auth::user()->getExpenseStatistics()['difference']['year'] }}</span>
                        </p>
                    </div>
                    <p class="standard">vs Previous Year</p>
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
                <form action="{{ route('admin.expenses.filter') }}" method="get">

                    <div class="filter-row row3">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->search }}"
                                placeholder="Type An Expense ID" class="form-element">
                        </div>


                        <div class="filter-box">
                            <label for="" class="form-label">Category</label>
                            <div class="select-box">
                                <select name="category" class="form-element">
                                    <option value="all">all</option>
                                    @foreach ($categories['admin'] as $category)
                                        <option @if (request()->category == $category) @selected(true) @endif
                                            value="{{ $category }}">{{ $category }}</option>
                                    @endforeach

                                </select>
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

                                    <option value="highest_amount"
                                        {{ request()->input('sort') === 'highest_amount' ? 'selected' : '' }}>
                                        Highest amount</option>
                                    <option value="lowest_amount"
                                        {{ request()->input('sort') === 'lowest_amount' ? 'selected' : '' }}>
                                        Lowest amount</option>
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
                            <label for="" class="form-label">Amount</label>
                            <div class="numbers-range-boxes filter-row sm-row2 ">
                                <div class="number-box min-grid">
                                    <p class="limiters form-limiters">From : </p>
                                    <input type="number" placeholder="eg:5" value="{{ request()->min_amount }}"
                                        name="min_amount" pattern="^\d{8}$" inputmode="numeric" class="form-element" />

                                </div>
                                <div class="number-box min-grid">
                                    <p class="limiters form-limiters">To : </p>
                                    <input type="number" placeholder="eg:50" value="{{ request()->max_amount }}"
                                        name="max_amount" pattern="^\d{8}$" inputmode="numeric" class="form-element" />
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

        @if ($expenses->count() > 0)
            <div class="results">
                <h2 class="t-left">Results</h2>
                <!-- Start Results Holder -->
                <div class=" main-holder">
                    <div class="table-responsive expenses-revenues">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Amount (DT)</th>
                                    <th>Date</th>
                                    <th>Actions </th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>#{{ $expense->id }}</td>
                                        <td>{{ $expense->title }}</td>
                                        <td>{{ $expense->category }}</td>
                                        <td>{{ number_format($expense->amount, 3, ',') }}</td>


                                        <td>{{ $expense->created_at->format('M jS Y - H:i') }}</td>
                                        <td>
                                            <ul class="d-flex j-center a-center actions">
                                                <li>
                                                    <button class="showBtn td-btn" title="Show Expense"><i
                                                            class="fa-light fa-eye"></i></button>
                                                    <div class="modal-holder ">
                                                        <div class="modal lg">
                                                            <div class="modal-header d-flex j-sp-between a-center">
                                                                <h2>{{ $expense->title }}</h2>
                                                                <button class="close-modal-holder-btn"><i
                                                                        class="fa-light fa-close"></i></button>
                                                            </div>
                                                            <form action="#" method="post">
                                                                <div class="form-row  ">
                                                                    <div class="col">
                                                                        <div class="form-control">
                                                                            <label for=""
                                                                                class="d-block  form-label">
                                                                                Title :
                                                                            </label>
                                                                            <input type="text" readonly
                                                                                placeholder="Expense Title"
                                                                                class="form-element"
                                                                                value="{{ $expense->title }}">

                                                                        </div>
                                                                        <div class="form-control">
                                                                            <label for=""
                                                                                class="form-label ">Category</label>
                                                                            <input type="text" readonly
                                                                                value="{{ $expense->category }}"
                                                                                class="form-element">
                                                                        </div>
                                                                        <div class="form-control">
                                                                            <label for=""
                                                                                class="form-label ">Amount
                                                                                (DT)
                                                                            </label>
                                                                            <input type="number" readonly
                                                                                class="form-element"
                                                                                placeholder="eg: 100 "
                                                                                value="{{ $expense->amount }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="editor-holder pop-up-editor">
                                                                            <label for=""
                                                                                class="form-label ">Description</label>
                                                                            <div style="height: 230px; padding: 10px; white-space:normal;"
                                                                                class="form-element  radius-5">
                                                                                {!! $expense->description !!}</div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>

                                                    </div>

                                                </li>
                                                <li>
                                                    <button class="editBtn td-btn" title="Edit Expense"><i
                                                            class="fa-light fa-pen"></i></button>

                                                    <div class="modal-holder ">
                                                        <div class="modal lg">
                                                            <div class="modal-header d-flex j-sp-between a-center">
                                                                <h2>Edit Expense</h2>
                                                                <button class="close-modal-holder-btn"><i
                                                                        class="fa-light fa-close"></i></button>
                                                            </div>

                                                            <form
                                                                action="{{ route('admin.expenses.update', $expense->id) }}"
                                                                method="post" class="edit-form ">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="form-row  ">
                                                                    <div class="col">
                                                                        <div class="form-control">
                                                                            <label for=""
                                                                                class="d-block required form-label">
                                                                                Title :
                                                                            </label>
                                                                            <input type="text" name="title"
                                                                                placeholder="Expense Title"
                                                                                class="form-element"
                                                                                value="{{ $expense->title }}">
                                                                            <p class="error-message">This Field is
                                                                                Required</p>
                                                                        </div>
                                                                        <div class="form-control">
                                                                            <label for=""
                                                                                class="form-label required">Category</label>
                                                                            <div class="select-box">
                                                                                <select name="category"
                                                                                    class="form-element">
                                                                                    <option
                                                                                        value="{{ $expense->category }}">
                                                                                        {{ $expense->category }}</option>

                                                                                </select>
                                                                            </div>
                                                                            <p class="error-message">This
                                                                                Field Is
                                                                                Required</p>
                                                                        </div>
                                                                        <div class="form-control">
                                                                            <label for=""
                                                                                class="form-label required">Amount
                                                                                (DT)</label>
                                                                            <input type="number" name="amount" readonly
                                                                                class="form-element"
                                                                                placeholder="eg: 100 "
                                                                                value="{{ $expense->amount }}">
                                                                            <p class="error-message">This Field Is
                                                                                Required</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="editor-holder pop-up-editor">
                                                                            <label for=""
                                                                                class="form-label required">Description</label>
                                                                            <textarea name="description" cols="30" rows="10" class="form-element editor-input">{{ $expense->description }}</textarea>
                                                                            <p class="error-message">This Field Is
                                                                                Required </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-control d-flex j-end">
                                                                    <button type="submit"
                                                                        class="submit-btn">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </li>
                                                @if ($expense->expensable_type == 'App\Models\Expensable')
                                                    <li>
                                                        <button class="deleteBtn td-btn" title="Delete Expense"><i
                                                                class="fa-light fa-trash"></i></button>
                                                        <div class="modal-holder ">
                                                            <form
                                                                action="{{ route('admin.expenses.destroy', $expense->id) }}"
                                                                method="post" class="modal t-center confirm-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <i class=" fa-light fa-trash"></i>
                                                                <p>Are You Sure You Want To Delete This Expense?</p>
                                                                <div class="buttons d-flex j-center a-center">
                                                                    <button class="cancelBtn">Cancel</button>
                                                                    <button class="confirmBtn">Yes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                </div>
                <!-- End Results Holder -->


                <!-- Start Pagination -->
                {!! $expenses->appends(request()->input())->links() !!}
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
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: ['heading', '|', 'bold', 'link', 'bulletedList'],
            })
            // .then(editor => {
            //     editor.model.document.on('change:data', () => {
            //         editorData = editor.getData();
            //         console.log(editorData);
            //     });
            // })

            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        const textareaInputs = Array.from(document.querySelectorAll('.editor-input'))
        textareaInputs.forEach((textarea, index) => {

            textarea.setAttribute('id', `editor-${index}`)
            let textareaId = textarea.getAttribute('id')
            ClassicEditor
                .create(document.querySelector(`#${textareaId}`), {
                    toolbar: ['heading', '|', 'bold', 'link', 'bulletedList'],
                })
                .catch(error => {
                    console.error(error);
                });

        })


        const editForms = Array.from(document.querySelectorAll(".edit-form"));
        editForms.forEach((form) => {
            form.addEventListener('submit', (e) => {
                e.preventDefault()
                let errors = 0
                let titleInput = form.elements[2]
                console.log(titleInput);
                let categoryInput = form.elements[3]
                let categoryInputErrorMessage = form.children[2].children[0].children[1].lastElementChild
                let valueInput = form.elements[4]

                let descriptionInput = form.elements[5]
                let descriptionErrorMessage = form.children[2].children[1].children[0].lastElementChild
                errors += validateField(titleInput, titleInput.nextElementSibling)
                // errors += validateField(valueInput, valueInput.nextElementSibling)
                errors += validateField(descriptionInput, descriptionErrorMessage)
                errors += validateField(categoryInput, categoryInputErrorMessage)

                if (!errors) {
                    form.submit()
                }
            })
        })
    </script>


    <script>
        const addForm = document.getElementById('add-form')
        const titleInput = document.getElementById('title-input')
        const categoryInput = document.getElementById('category-input')
        const categoryInputErrorMessage = document.getElementById('category-input-error-message')
        const valueInput = document.getElementById('value-input')
        const descriptionInput = document.getElementById('description')
        const descriptionErrorMessage = document.getElementById('description-error-message')
        addForm.addEventListener('submit', (e) => {
            e.preventDefault()
            let errors = 0
            errors += validateField(titleInput, titleInput.nextElementSibling)
            errors += validateField(categoryInput, categoryInputErrorMessage)
            errors += validateField(valueInput, valueInput.nextElementSibling)
            errors += validateField(descriptionInput, descriptionErrorMessage)
            if (!errors) {
                addForm.submit()
            }


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
    @include('components.inc_modals-js')
@endpush
