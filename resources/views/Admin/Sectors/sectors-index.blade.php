@extends('layouts.Admin')

@push('title')
    <title>Pickup | Sectors </title>
@endpush

@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Sectors</h1>


            <!-- Start Add Form -->
            <button class="header-btn add-btn pop-up-controller" id="add-btn"> <i class="fa-light fa-plus"></i> Add
                Sector</button>
            <div class="pop-up-holder ">
                <div class="pop-up form-pop-up">
                    <div class="pop-up-header d-flex j-sp-between a-center">
                        <h2>Add Sector</h2>
                        <button class="close-pop-up-btn"><i class="fa-light fa-close"></i></button>
                    </div>
                    <div class="pop-up-body">
                        <!-- Start Form -->
                        <form action="{{ route('admin.sectors.store') }}" method="post" id="add-form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-control">
                                <label for="" class="d-block required form-label">
                                    Name :
                                </label>
                                <input type="text" name="name" value="{{ old('name', '') }}" id="name-input"
                                    placeholder="Sector Name" class="form-element">
                                <p class="error-message">This Field is Required</p>
                            </div>
                            <div class="form-control">
                                <label for="" class="form-label required">Status</label>
                                <div class="select-box">
                                    <select name="status" class="form-element" id="status-input">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <p class="error-message" id="status-input-error-message">This Field Is
                                    Required</p>
                            </div>
                            <div class="form-control">
                                <label for="" class="d-block required form-label">icon : </label>
                                <div class="drop-zone" class="form-element">
                                    <label for="icon-image" class="drop-zone-label form-label">
                                        <i class="fa-light fa-cloud-arrow-up d-block"></i>
                                        <p>Drop Files Here Or Click To Upload File</p>
                                        <p>Allowed Formats are jpg, jpeg</p>
                                    </label>
                                    <input type="file" name="icon" id="icon-image" accept="image/jpeg  image/jpg">
                                </div>
                                <p class="error-message" id="file-error-message">This Field is Required</p>
                                <div class="upload-area d-flex j-start a-center " id="upload-area">
                                    <i class="fa-solid fa-file-image"></i>
                                    <div class="file-info">
                                        <p class="file-name" id="file-name-holder">FileName.png </p>
                                        <p class="file-size" id="file-size-holder">485 KB</p>
                                    </div>
                                    <i class="fa-light fa-check"></i>
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
            <!-- End Add Form -->
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
                <form action="{{ route('admin.sectors.filter') }}" method="get">

                    <div class="filter-row row3">
                        <div class="filter-box">
                            <label for="" class="form-label">Search</label>
                            <input type="search" name="search" value="{{ request()->search }}"
                                placeholder="Search For Sector Name" class="form-element">
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
                                    <label for="inactive-input">inactive</label>
                                    <input type="checkbox"
                                        {{ in_array('inactive', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="inactive-input" name="status[]" value="inactive">
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
                                    <option value="highest_stores"
                                        {{ request()->input('sort') === 'highest_stores' ? 'selected' : '' }}>
                                        Highest Stores</option>
                                    <option value="lowest_stores"
                                        {{ request()->input('sort') === 'lowest_stores' ? 'selected' : '' }}>
                                        Lowest Stores</option>
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
                            <label for="" class="form-label">N° Of Stores</label>
                            <div class="numbers-range-boxes filter-row sm-row2 ">
                                <div class="number-box min-grid">
                                    <p class="limiters form-limiters">From : </p>
                                    <input type="number" placeholder="eg:5" value="{{ request()->min_stores }}"
                                        name="min_stores" pattern="^\d{8}$" inputmode="numeric" class="form-element" />

                                </div>
                                <div class="number-box min-grid">
                                    <p class="limiters form-limiters">To : </p>
                                    <input type="number" placeholder="eg:50" value="{{ request()->max_stores }}"
                                        name="max_stores" pattern="^\d{8}$" inputmode="numeric" class="form-element" />
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

        @if ($sectors->count() > 0)
            <!-- Start Results -->
            <div class="results">
                <!-- Start Results Holder -->
                <div class="results-holder main-holder sectors">
                    @foreach ($sectors as $sector)
                        <!-- Start Sector Card -->
                        <div class="sector card simple">
                            <header>
                                <p class="status">Status : <span>{{ ucfirst($sector->status) }}</span></p>
                                <button class="actions-controller"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="actions-holder ">
                                    <li>
                                        <button class="editBtn">Edit</button>
                                        <div class="modal-holder">
                                            <div class=" form-modal modal">
                                                <div class="modal-header d-flex j-sp-between a-center">
                                                    <h2>Edit {{ $sector->name }}</h2>
                                                    <button class="close-modal-holder-btn"><i
                                                            class="fa-light fa-close"></i></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Start Form -->
                                                    <form action="{{ route('admin.sectors.update', $sector->id) }}"
                                                        method="post" class="edit-form" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="form-control">
                                                            <label for="" class="d-block required form-label">
                                                                Name :
                                                            </label>
                                                            <input type="text" name="name"
                                                                placeholder="Sector Name" class="form-element"
                                                                value="{{ $sector->name }}">
                                                            <p class="error-message">This Field is Required</p>
                                                        </div>

                                                        <div class="form-control">
                                                            <label for=""
                                                                class="form-label required">Status</label>
                                                            <div class="select-box">
                                                                <select name="status" class="form-element"
                                                                    id="status-input">
                                                                    <option value="active"
                                                                        {{ $sector->status == 'active' ? 'selected' : '' }}>
                                                                        Active</option>
                                                                    <option value="inactive"
                                                                        {{ $sector->status == 'inactive' ? 'selected' : '' }}>
                                                                        Inactive</option>
                                                                </select>
                                                            </div>
                                                            <p class="error-message" id="status-input-error-message">This
                                                                Field Is
                                                                Required</p>
                                                        </div>


                                                        <div class="form-control">
                                                            <label for="" class="d-block  form-label">icon
                                                                :
                                                            </label>
                                                            <div class="drop-zone" class="form-element">
                                                                <label for="icon-image"
                                                                    class="drop-zone-label form-label">
                                                                    <i class="fa-light fa-cloud-arrow-up d-block"></i>
                                                                    <p>Drop File Here Or Click To Upload File</p>
                                                                    <p>Allowed Formats are jpg, jpeg</p>
                                                                </label>
                                                                <input type="file" name="icon" class="file-input"
                                                                    accept="image/jpeg , image/jpg">
                                                            </div>
                                                            <p class="error-message">This Field
                                                                is Required</p>
                                                            <div class="upload-area d-flex j-start a-center ">
                                                                <i class="fa-solid fa-file-image"></i>
                                                                <div class="file-info">
                                                                    <p class="file-name">
                                                                        FileName.png </p>
                                                                    <p class="file-size">485 KB</p>

                                                                </div>
                                                                <i class="fa-light fa-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="form-control d-flex j-end">
                                                            <button type="submit" class="submit-btn">Save</button>
                                                        </div>
                                                    </form>
                                                    <!-- End Form -->

                                                </div>
                                            </div>

                                        </div>
                                    </li>

                                    <li>
                                        <button class="deleteBtn">Remove</button>
                                        <div class="modal-holder ">
                                            <form action="{{ route('admin.sectors.destroy', $sector->id) }}"
                                                method="post" class="modal t-center confirm-form">

                                                <i class=" fa-light fa-trash"></i>
                                                <p>Are You Sure You Want To Delete This Sector ?</p>
                                                <div class="buttons d-flex j-center a-center">
                                                    <button class="cancelBtn">Cancel</button>
                                                    <button class="confirmBtn">Yes</button>
                                                </div>
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </li>

                                </ul>
                            </header>

                            <div class="info">
                                <img loading="lazy" src="{{ asset($sector->icon) }}" alt="">
                                {{-- <img loading="lazy" src="{{ asset('storage/' . $sector->icon) }}" alt=""> --}}
                                <h3>{{ $sector->name }}</h3>
                                <p>{{ $sector->storesCount() == 1 ? '1 Store' : $sector->storesCount() . ' Stores' }}</p>
                                <p class="p-span">Added At :
                                    <span>{{ \Carbon\Carbon::parse($sector->created_at)->format('M jS Y') }}</span>
                                </p>
                            </div>
                        </div>
                        <!-- End Sector Card -->
                    @endforeach

                </div>
                <!-- End Results Holder -->

                {!! $sectors->appends(request()->input())->links() !!}
            </div>
            <!-- End Results -->
        @else
            <!-- Start Not found -->
            <div class="not-found-holder show">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p>No Results Found!</p>
                </div>
            </div>
            <!-- End Not found -->
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        const addForm = document.getElementById('add-form')
        const nameInput = document.getElementById('name-input')
        const fileInput = document.getElementById('icon-image')
        const statusInput = document.getElementById('status-input')
        const statusInputErrorMessage = document.getElementById('status-input-error-message')
        console.log("file: sectors.html:592 ~ statusInputErrorMessage:", statusInputErrorMessage)
        const uploadArea = document.getElementById('upload-area')
        const fileNameHolder = document.getElementById('file-name-holder')
        const fileSizeHolder = document.getElementById('file-size-holder')
        const fileErrorMessage = document.getElementById('file-error-message')


        addForm.addEventListener('submit', (e) => {
            e.preventDefault()
            let errors = 0
            errors += validateField(nameInput, nameInput.nextElementSibling)
            errors += validateField(statusInput, statusInputErrorMessage)
            errors += validateField(fileInput, fileErrorMessage)
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
        fileInput.addEventListener('change', () => {
            if (validateFileType(fileInput)) {
                showFileInfo(fileInput)

            } else {
                showFileTypeError(fileInput)
            }
        })

        function showFileInfo(input) {
            let errorMessage = input.parentElement.nextElementSibling
            let uploadArea = errorMessage.nextElementSibling
            let fileNameHolder = uploadArea.children[1].children[0]
            let fileSizeHolder = uploadArea.children[1].children[1]
            errorMessage.classList.remove('show')
            errorMessage.textContent = '';
            let fileSize = Math.floor(input.files[0].size / 1000)
            let fileName = input.files[0].name
            if (fileName.length > 12) {
                let splitName = fileName.split('.')
                fileName = splitName[0].substring(0, 12) + '... .' + splitName[1];
                console.log(fileName);
            }
            uploadArea.classList.add('show')
            fileNameHolder.textContent = fileName
            fileSizeHolder.textContent = fileSize > 1000 ? `${Math.floor(fileSize / 1000)} MB` : `${fileSize} KB`
        }

        function validateFileType(actualFileInput) {
            allowedExtensions = /(\.jpg|\.jpeg)$/i
            return allowedExtensions.exec(actualFileInput.files[0].name);

        }

        function showFileTypeError(input) {
            let errorMessage = input.parentElement.nextElementSibling
            let uploadArea = errorMessage.nextElementSibling
            uploadArea.classList.remove('show')
            input.value = ''
            errorMessage.textContent = 'We Only Accept Jpeg, Jpg Formats'
            errorMessage.classList.add('show')
        }

        // Edit Forms
        const editForms = Array.from(document.querySelectorAll(".edit-form"));
        editForms.forEach((form) => {
            form.addEventListener('submit', (e) => {
                e.preventDefault()
                let errors = 0
                let nameInput = form.elements[2]
                let nameInputErrorMessage = nameInput.nextElementSibling
                let statusInput = form.children[3].children[1].children[0]
                let statusInputErrorMessage = form.children[3].children[2]
                let imageInput = form.elements[4]

                let imageInputErrorMessage = form.children[4].children[2]

                errors += validateField(nameInput, nameInputErrorMessage)
                errors += validateField(statusInput, statusInputErrorMessage)
                // errors += validateField(imageInput, imageInputErrorMessage)
                if (!errors) {
                    form.submit()
                }
            })
        })
        const fileInputs = Array.from(document.querySelectorAll('.file-input'))
        fileInputs.forEach((fileInput) => {
            fileInput.addEventListener('change', () => {
                if (validateFileType(fileInput)) {
                    showFileInfo(fileInput)

                } else {
                    showFileTypeError(fileInput)
                }

            })
        })
    </script>
    @include('components.inc_modals-js')
@endpush
