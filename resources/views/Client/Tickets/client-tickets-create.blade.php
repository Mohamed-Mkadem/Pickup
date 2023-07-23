@extends('layouts.Client')

@push('title')
    <title>Pickup | New Ticket</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>New Ticket</h1>
            <!-- Start Link  -->
            <a href="{{ url()->previous() }}" class="action-btn d-block ">
                <i class="fa-light fa-arrow-right-from-bracket"></i>
                <span>Go Back</span>
            </a>
            <!-- End Link  -->
        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')

        <form action="{{ route('client.tickets.store') }}" method="post" id="ticket-form" enctype="multipart/form-data">
            <div class="main-holder">
                @csrf
                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="required form-label"> Title </label>
                        <input type="text" name="title" id="title-input" placeholder="eg: How Can I Place An Order "
                            class="form-element" value="{{ old('title', '') }}">
                        <p class="error-message">This Fiedl Is required</p>
                    </div>
                    <div class="form-control">
                        <label for="" class="required form-label"> Subject </label>
                        <input type="text" name="subject" id="subject-input" placeholder="eg: Order Cancellation "
                            class="form-element" value="{{ old('subject', '') }}">
                        <p class="error-message">This Fiedl Is required</p>
                    </div>


                </div>
                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="form-label required">Message :</label>
                        <textarea class="form-element" name="message" id="message" rows="10" cols="80">{{ old('message', '') }}</textarea>


                        <p class="error-message" id="message-error-message">This Field Is Required
                        </p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="form-label ">Attach File </label>
                        <div class="drop-zone form-element">
                            <label for="icon-image" class="drop-zone-label form-label">
                                <i class="fa-light fa-cloud-arrow-up d-block"></i>
                                <p>Drop File Here Or Click To Upload File</p>
                                <p>Allowed Formats are Pdf, Zip, Png, Jpeg</p>
                            </label>
                            <input type="file" name="file" id="files-input" multiple
                                accept="image/jpeg image/png, image/jpg, image/svg , .pdf">

                        </div>
                        <p class="error-message" id="files-error-message">This Field Is Required</p>
                        <div class="upload-area d-flex j-start a-center sm">
                            <i class="fa-solid fa-file"></i>
                            <div class="file-info">
                                <p class="file-name">
                                    FileName.png </p>
                                <p class="file-size">485 KB</p>

                            </div>
                            <i class="fa-light fa-check"></i>
                        </div>

                    </div>
                </div>
                <div class="form-control">
                    <div class="buttons d-flex j-end a-center">
                        <button type="submit" class="submit-btn">Submit</button>
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
            .create(document.querySelector('#message'), {
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
        const ticketForm = document.getElementById('ticket-form')
        const descriptionTextarare = document.getElementById('message')
        const descriptionErrorMessage = document.getElementById('message-error-message')
        const filesInput = document.getElementById('files-input')
        const filesErrorMessage = document.getElementById('files-error-message')
        const uploadAreasWrapper = document.getElementById('upload-areas-wrapper')
        const titleInput = document.getElementById('title-input')
        const subjectInput = document.getElementById('subject-input')
        ticketForm.addEventListener('submit', (e) => {
            e.preventDefault()
            let errors = 0
            errors += validateField(descriptionTextarare, descriptionErrorMessage)
            errors += validateField(titleInput, titleInput.nextElementSibling)
            errors += validateField(subjectInput, subjectInput.nextElementSibling)


            if (!errors) {
                ticketForm.submit()
            }
        })




        filesInput.addEventListener('change', () => {
            if (validateFileType(filesInput)) {
                showFileInfo(filesInput)
            } else {
                showFileTypeError(filesInput)
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
            allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf|\.zip|\.rar)$/i
            return allowedExtensions.exec(actualFileInput.files[0].name);

        }

        function showFileTypeError(input) {
            let errorMessage = input.parentElement.nextElementSibling
            let uploadArea = errorMessage.nextElementSibling
            uploadArea.classList.remove('show')
            input.value = ''
            errorMessage.textContent = 'We Only Accept Pdf, Zip, Jpeg, Png  Formats'
            errorMessage.classList.add('show')
        }

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
@endpush
