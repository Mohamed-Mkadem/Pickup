@extends('layouts.Admin')

@push('title')
    <title>Pickup | Edit Brand</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Edit Brand</h1>
        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.success-alert')

        <!-- Start Creation Form -->
        <div class="creation-holder main-holder">
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="post" id="creation-form"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-grid">
                    <div class="form-sidebar">
                        <div class="form-control">
                            <label for="" class="form-label ">Logo : </label>
                            <div class="drop-zone form-element">
                                <label for="icon-image" class="drop-zone-label form-label">
                                    <i class="fa-light fa-cloud-arrow-up d-block"></i>
                                    <p>Drop File Here Or Click To Upload File</p>
                                    <p>Allowed Formats are jpeg, jpg</p>
                                </label>
                                <input type="file" name="logo" id="icon-image" accept="image/jpeg , image/jpg">
                            </div>
                            <p class="error-message" id="logo-error-message">This Field Is Required</p>
                            <div class="upload-area  d-flex j-start a-center ">
                                <i class="fa-solid fa-file-image"></i>
                                <div class="file-info">
                                    <p class="file-name">
                                        FileName.jpg </p>
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
                                    <input type="radio" checked id="active"
                                        {{ $brand->status == 'Active' ? 'checked' : '' }} name="status" value="Active">
                                </div>
                                <div class="status form-element">
                                    <label for="active ">Inactive</label>
                                    <input type="radio" id="inactive" {{ $brand->status == 'Inactive' ? 'checked' : '' }}
                                        name="status" value="Inactive">
                                </div>
                            </div>
                            <p class="error-message" id="status-error-message">This Field Is Required</p>
                        </div>
                    </div>
                    <div class="form-main">
                        <div class="form-control">
                            <label for="" class="form-label required">Name :</label>
                            <input type="text" name="name" value="{{ $brand->name }}" id="name-input"
                                class="form-element" placeholder="Brand Name">
                            <p class="error-message">This Field Is Required</p>
                        </div>

                        <div class="form-control">
                            <label for="" class="form-label required">Description :</label>
                            <textarea name="description" id="description" rows="10" cols="80">{!! $brand->description !!}</textarea>


                            <p class="error-message" id="description-error-message">This Field Is Required
                            </p>
                        </div>
                        <div class="form-control">
                            <div class="buttons d-flex j-end a-center">
                                <button type="submit" class="submit-btn">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- End Creation Form -->
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
    </script>



    <script>
        const creationForm = document.getElementById('creation-form')
        const descriptionInput = document.getElementById('description')
        const descriptionErrorMessage = document.getElementById('description-error-message')
        const nameInput = document.getElementById('name-input')

        const iconInput = document.getElementById('icon-image')
        const iconInputErrorMessage = document.getElementById('logo-error-message')


        const statusInput = document.querySelector('input[name="status"]:checked')
        const statusInputErrorMessage = document.getElementById('status-error-message')


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
        iconInput.addEventListener('change', () => {
            if (validateFileType(iconInput)) {
                showFileInfo(iconInput)

            } else {
                showFileTypeError(iconInput)
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
            // errors += validateField(iconInput, iconInputErrorMessage)
            errors += validateRadioBtn('input[name="status"]:checked', statusInputErrorMessage)
            errors += validateField(nameInput, nameInput.nextElementSibling)
            errors += validateField(descriptionInput, descriptionErrorMessage)
            if (!errors) {
                creationForm.submit()
            }
        })
    </script>
@endpush
