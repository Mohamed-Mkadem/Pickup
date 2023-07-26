@extends('layouts.Seller')

@push('title')
    <title>Pickup | Edit Product</title>
@endpush
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Edit Product</h1>
        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')

        <form action="{{ route('seller.products.update', $product->id) }}" method="post" id="creation-form"
            enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-grid has-sticky">
                <div class="form-sidebar sticky  p-1 radius-10 holder">

                    <div class="form-control">
                        <label for="" class="form-label ">Image : </label>
                        <div class="drop-zone form-element">
                            <label for="image-input" class="drop-zone-label form-label">
                                <i class="fa-light fa-cloud-arrow-up d-block"></i>
                                <p>Drop File Here Or Click To Upload File</p>
                                <p>Allowed Formats are jpg, jpeg</p>
                            </label>
                            <input type="file" name="image" id="image-input" accept="image/jpeg, image/jpg">
                        </div>
                        <p class="error-message" id="image-error-message">This Field Is Required</p>
                        <p class="field-instructions">Dimensions : 500px x 500px, Max size : 2 MB </p>
                        <div class="upload-area d-flex j-start a-center">
                            <i class="fa-solid fa-file-image"></i>
                            <div class="file-info">
                                <p class="file-name">
                                    FileName.png </p>
                                <p class="file-size">485 KB</p>

                            </div>
                            <i class="fa-light fa-check"></i>
                        </div>
                    </div>
                    <div class="form-control">
                        <label for="" class="required form-label">Status :</label>
                        <div class="vertical-statuses-wrapper">
                            <div class="status form-element">
                                <label for="active ">Active</label>
                                <input type="radio" {{ $product->status == 'active' ? 'checked' : '' }} id="active"
                                    name="status" value="active">
                            </div>
                            <div class="status form-element">
                                <label for="active ">Inactive</label>
                                <input type="radio" {{ $product->status == 'inactive' ? 'checked' : '' }} id="inactive"
                                    name="status" value="inactive">
                            </div>
                        </div>
                        <p class="error-message" id="status-error-message">This Field Is Required</p>
                    </div>

                    <div class="filter-column">
                        <div class="form-control">
                            <!-- Start Form Filter -->
                            <div class="filter-holder ">
                                <div class="filter-header  d-flex j-sp-between a-center">
                                    <label for="" class="form-label required">Category</label>
                                    <button class="filter-holder-btn">
                                        <i class="fa-light fa-circle-caret-down"></i>
                                    </button>
                                </div>
                                <div class="filter-wrapper">
                                    <div class="form-control">
                                        <input type="search" class="form-element" name="categories"
                                            placeholder="Category Name" id="categories-search">
                                    </div>

                                    <div class="choices categories-choices">
                                        @foreach ($categories as $category)
                                            <div class="choice">
                                                <input type="radio"
                                                    {{ $product->category_id == $category->id ? 'checked' : '' }}
                                                    name="category_id" id="{{ 'category_' . $category->id }}"
                                                    value="{{ $category->id }}">
                                                <label for="{{ 'category_' . $category->id }}">{{ $category->name }}</label>
                                            </div>
                                        @endforeach



                                    </div>

                                </div>
                                <p class="error-message" id="category-error-message">This Field Is Required
                                </p>
                            </div>
                            <!-- End Form Filter -->
                        </div>
                        <div class="form-control">
                            <!-- Start Form Filter -->
                            <div class="filter-holder ">
                                <div class="filter-header  d-flex j-sp-between a-center">
                                    <label for="" class="form-label required">Brand</label>
                                    <button class="filter-holder-btn">
                                        <i class="fa-light fa-circle-caret-down"></i>
                                    </button>
                                </div>
                                <div class="filter-wrapper">
                                    <div class="form-control">
                                        <input type="search" class="form-element" name="brands" placeholder="Brand Name"
                                            id="brands-search">
                                    </div>

                                    <div class="choices brands-choices">
                                        @foreach ($brands as $brand)
                                            <div class="choice">
                                                <input type="radio"
                                                    {{ $product->brand_id == $brand->id ? 'checked' : '' }} name="brand_id"
                                                    id="{{ 'brand_' . $brand->id }}" value="{{ $brand->id }}">
                                                <label for="{{ 'brand_' . $brand->id }}">{{ $brand->name }}</label>
                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                                <p class="error-message" id="brand-error-message">This Field Is Required</p>
                            </div>
                            <!-- End Form Filter -->
                        </div>
                    </div>
                </div>
                <div class=" light">
                    <div class="holder p-1 radius-10">
                        <h2 class="mb-0-5 form-holder-title">General Info</h2>
                        <div class="form-control">
                            <label for="" class="form-label required">Name :</label>
                            <input type="text" name="name" id="name-input" class="form-element"
                                placeholder="Product Name" value=" {{ $product->name }}">
                            <p class="error-message">This Field Is Required</p>
                        </div>

                        <div class="form-control">
                            <label for="" class="form-label required">Description :</label>
                            <textarea class="form-element" placeholder="Brief Descirption Of The Product" name="description" id="description"
                                rows="10" cols="80">{!! $product->description !!}</textarea>
                            <p class="error-message" id="description-error-message">This Field Is Required
                            </p>
                        </div>
                        <div class="form-control">

                            <label for="" class="form-label required">Unit </label>


                            <div class="choices-btns-wrapper  ">
                                <div class="choice-btn form-element">
                                    <label for="piece-input"> piece</label>
                                    <input type="radio" checked id="piece-input"
                                        {{ $product->unit == 'piece' ? 'checked' : '' }} name="unit" value="piece">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="weight-input">weight</label>
                                    <input type="radio" id="weight-input"
                                        {{ $product->unit == 'weight' ? 'checked' : '' }} name="unit" value="weight">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="liquid-input">liquid</label>
                                    <input type="radio" id="liquid-input"
                                        {{ $product->unit == 'liquid' ? 'checked' : '' }} name="unit" value="liquid">
                                </div>

                            </div>
                            <p class="error-message" id="unit-error-message">This field is required</p>
                        </div>

                        <div class="form-row">
                            <div class="form-control">
                                <label for="" class="form-label required">Quantity</label>
                                <input type="number" value="{{ $product->quantity }}" name="quantity"
                                    id="quantity-input" placeholder="eg: 100" class="form-element" inputmode="numeric">
                                <p class="error-message">This field is required</p>
                            </div>
                            <div class="form-control">
                                <label for="" class="form-label required">Stock Alert</label>
                                <input type="number" name="stock_alert" value="{{ $product->stock_alert }}"
                                    id="stock-alert-input" placeholder="eg: 10" class="form-element"
                                    inputmode="numeric">
                                <p class="error-message">This field is required</p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-control">
                                <label for="" class="form-label required">Cost Price (DT)</label>
                                <input type="number" name="cost_price" value="{{ $product->cost_price }}"
                                    step="0.01" id="cost-input" placeholder="eg: 7" class="form-element"
                                    inputmode="numeric">
                                <p class="error-message">This field is required</p>
                            </div>
                            <div class="form-control">
                                <label for="" class="form-label required">Sale Price (DT)</label>
                                <input type="number" name="price" step="0.01" value="{{ $product->price }}"
                                    id="price-input" placeholder="eg: 11" class="form-element" inputmode="numeric">
                                <p class="error-message">This field is required</p>
                            </div>
                        </div>
                    </div>
                    <div class="holder p-1 radius-10 mt-2">
                        <h2 class="mb-0-5 form-holder-title">Advanced</h2>
                        <div class="form-control">
                            <label for="" class="form-label ">info :</label>
                            <textarea class="form-element" placeholder="The info Of The Product (Like Wheight, Dimenstions...etc)" name="info"
                                id="info" rows="10" cols="80">{!! $product->info !!}</textarea>
                            <p class="error-message" id="info-error-message">This Field Is Required
                            </p>
                        </div>
                        <div class="form-control">
                            <label for="" class="form-label ">ingredients :</label>
                            <textarea class="form-element"
                                placeholder="The Ingredients Of The Product (What are the main Ingredients of this product)" name="ingredients"
                                id="ingredients" rows="10" cols="80">{!! $product->ingredients !!}</textarea>
                            <p class="error-message" id="ingredients-error-message">This Field Is Required
                            </p>
                        </div>

                        <div class="buttons d-flex j-end gap-1 wrap mt-1">
                            <button type="reset" class="resetBtn">Reset</button>
                            <button type="submit" id="submitBtn" class="submitBtn">Filter</button>

                        </div>

                    </div>
                </div>

            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
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
        ClassicEditor
            .create(document.querySelector('#ingredients'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
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
        ClassicEditor
            .create(document.querySelector('#info'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
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
        const creationForm = document.getElementById('creation-form')
        const descriptionInput = document.getElementById('description')
        const descriptionErrorMessage = document.getElementById('description-error-message')
        const nameInput = document.getElementById('name-input')
        const imageInput = document.getElementById('image-input')
        const quantityInput = document.getElementById('quantity-input')
        const stockAlertInput = document.getElementById('stock-alert-input')
        const costInput = document.getElementById('cost-input')
        const priceInput = document.getElementById('price-input')
        const imageInputErrorMessage = document.getElementById('image-error-message')
        const statusInputErrorMessage = document.getElementById('status-error-message')
        const unitnputErrorMessage = document.getElementById('unit-error-message')
        const categoryInputErrorMessage = document.getElementById('category-error-message')
        const brandInputErrorMessage = document.getElementById('brand-error-message')

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
        imageInput.addEventListener('change', () => {
            if (validateFileType(imageInput)) {
                showFileInfo(imageInput)

            } else {
                showFileTypeError(imageInput)
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
        creationForm.addEventListener('submit', (e) => {
            e.preventDefault()
            let errors = 0
            errors += validateRadioBtn('input[name="status"]:checked', statusInputErrorMessage)
            errors += validateRadioBtn('input[name="category_id"]:checked', categoryInputErrorMessage)
            errors += validateRadioBtn('input[name="brand_id"]:checked', brandInputErrorMessage)
            errors += validateRadioBtn('input[name="unit"]:checked', unitnputErrorMessage)
            errors += validateField(nameInput, nameInput.nextElementSibling)
            errors += validateField(descriptionInput, descriptionErrorMessage)

            errors += validateNumber(stockAlertInput, stockAlertInput.nextElementSibling, 1)
            errors += validateNumber(costInput, costInput.nextElementSibling, 0.1)
            errors += validateNumber(quantityInput, quantityInput.nextElementSibling, 1)
            errors += validateNumber(priceInput, priceInput.nextElementSibling, 0.1)
            if (!errors) {
                creationForm.submit()
            }
        })

        function validateRadioBtn(fieldSelector, errorMessage) {
            let errors = 0

            let field = document.querySelector(fieldSelector)
            if (!field) {
                errorMessage.textContent = 'This Field Is Required'
                errorMessage.classList.add('show')
                errors = 1
            } else {
                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                errors = 0
            }
            return 0
        }

        function validateNumber(field, errorMsg, minValue = 0) {
            let errors = 0
            if (!field.value || field.value <= minValue) {

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
    </script>
    <script>
        const filterHolderBtns = Array.from(document.querySelectorAll('.filter-holder-btn'))

        filterHolderBtns.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault()
                let filterWrapper = btn.parentElement.nextElementSibling
                filterWrapper.classList.toggle('hidden')
            })
        });
    </script>
    <script>
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
        const resetBtn = document.querySelector('.resetBtn')
        resetBtn.addEventListener('click', () => {
            let errorMessages = document.querySelectorAll('p.error-message')
            errorMessages.forEach(msg => {
                msg.classList.remove('show')
                msg.textContent = ''
            })
        })
    </script>
@endpush
