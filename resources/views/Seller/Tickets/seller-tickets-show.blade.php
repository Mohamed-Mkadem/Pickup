@extends('layouts.Seller')

@push('title')
    <title>Pickup | Ticket Details</title>
@endpush
@section('content')
    <section class="content" id="content">
        @if ($ticket->status == 'in progress')
            <ul class="horizontal-actions-holder  d-flex gap-1 mb-2 wrap j-center a-center">

                <li>
                    <button class="deleteBtn delete-button">Close</button>

                    <div class="modal-holder ">
                        <form action="{{ route('seller.tickets.close', $ticket->id) }}" method="post"
                            class="modal t-center confirm-form">
                            @csrf
                            @method('PATCH')
                            <i class=" fa-light fa-info"></i>
                            <p>Are You Sure You Want To Close This Ticket ?</p>
                            <div class="buttons d-flex j-center a-center">
                                <button class="cancelBtn">Cancel</button>
                                <button class="confirmBtn">Yes</button>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        @endif
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        <div class="ticket-holder show-holder">
            <!-- Start Header -->
            <header>
                <div class="img-holder">
                    <img src="{{ asset('storage/' . $ticket->user->photo) }}" alt="">
                </div>
                <div class="info-holder">
                    <p class="ticket-title header-title">
                        <span class="ticket-id header-id">#{{ $ticket->id }} - </span>
                        {{ $ticket->title }}
                        <span
                            class="status
                    @if ($ticket->status == 'in progress') in-progress
                    @else
                    {{ $ticket->status }} @endif
                    ">{{ $ticket->status }}</span>
                    </p>
                    <div class="ticket-details header-details">

                        <div class="detail">
                            <span>Created : </span>
                            <p>{{ $ticket->created_at->format('M jS Y - H:i') }}</p>
                        </div>
                        @if ($ticket->status == 'closed')
                            <div class="detail">
                                <span>Closed : </span>
                                <p>{{ $ticket->updated_at->format('M jS Y - H:i') }}</p>
                            </div>
                        @endif

                    </div>
                </div>
            </header>
            <!-- End Header -->

            <!-- Start Ticket Details Holder -->
            <div class="ticket-details-holder holder">
                <!-- Start Detail -->
                <div class="detail description">
                    <h2>Description</h2>
                    {!! $ticket->message !!}
                </div>
                <!-- End Detail -->
                <!-- End Detail -->
                @if ($ticket->hasResponses())
                    <!-- Start Detail -->
                    <div class="detail ">
                        <h2>Responses</h2>
                        <div class="responses-wrapper">
                            @foreach ($ticket->responses as $response)
                                <!-- Start Response -->
                                <div
                                    class="response d-flex j-start a-start  @if ($response->user->type == 'Admin') admin @endif ">
                                    <div class="img-holder">
                                        <img src="{{ asset('storage/' . $response->user->photo) }}" alt="">

                                    </div>
                                    <div class="info-holder">
                                        <h3 class="name">{{ ucfirst($response->user->full_name) }}
                                            <small>{{ $response->created_at->format('M jS Y - H:i') }}</small>
                                        </h3>
                                        <div class="response-body">

                                            {!! $response->message !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- End Response -->
                            @endforeach
                        </div>
                    </div>
                    <!-- End Detail -->
                @endif
                <!-- Start Detail -->
                @if ($ticket->status == 'in progress')
                    <!-- Start Detail -->
                    <div class="detail new-response">
                        <h2>New Response</h2>
                        <form action="{{ route('seller.tickets.response.new', $ticket->id) }}" method="post"
                            id="response-form" enctype="multipart/form-data">
                            @csrf
                            <div class="editor-holder">
                                <label for="" class="form-label required">Response :</label>
                                <textarea name="message" id="response-textarea" cols="30" rows="10">{{ old('message', '') }}</textarea>
                                <p class="error-message" id="response-error-message">This Field Is Required</p>
                            </div>


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
                            <div class="form-control">
                                <div class="buttons d-flex j-end a-center wrap">

                                    <button class="submit-btn">Add
                                        Response</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- End Detail -->
                @endif
            </div>
            <!-- End Ticket Details Holder -->
            @if ($ticket->hasAttachments())
                <!-- Start Attachments Holder -->
                <div class="attachements-holder main-holder">
                    <h2>Attachments</h2>
                    <div class="attachements-grid">
                        @foreach ($ticket->attachments as $attachment)
                            <!-- Start Attachement -->
                            <div class="attachement d-flex j-sp-between a-center">
                                <div class="info d-flex a-center">
                                    <i class="fa-solid fa-file"></i>
                                    <div class="name-size-holder">
                                        <p class="file-name">{{ $attachment->name }} </p>
                                        <p class="file-size">{{ $attachment->size }}</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $attachment->path) }}"
                                    download="{{ $attachment->name }}">Download</a>
                            </div>
                            <!-- End Attachement -->
                        @endforeach
                    </div>
                </div>
                <!-- End Attachments Holder -->
            @endif
        </div>

    </section>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script>
        const responseTextarea = document.getElementById('response-textarea')
        if (responseTextarea) {
            ClassicEditor
                .create(document.querySelector('#response-textarea'), {
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

            const responseForm = document.getElementById('response-form')

            const responseErrorMessage = document.getElementById('response-error-message')
            const filesInput = document.getElementById('files-input')
            const filesErrorMessage = document.getElementById('files-error-message')
            const uploadAreasWrapper = document.getElementById('upload-areas-wrapper')
            responseForm.addEventListener('submit', (e) => {
                e.preventDefault()
                let errors = 0
                errors += validateField(responseTextarea, responseErrorMessage)


                if (!errors) {
                    responseForm.submit()
                }
            })

            const buttons = document.querySelectorAll('.submit-btn')
            // buttons.forEach(btn => {
            //     btn.addEventListener('click', (e) => {
            //         if (e.target.classList.contains('close-btn')) {
            //             responseForm.submit()
            //         } else {
            //             let errors = 0
            //             errors += validateField(responseTextarea, responseErrorMessage)


            //             if (!errors) {
            //                 responseForm.submit()
            //             }
            //         }
            //     })
            // })


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
        }
    </script>
    @include('components.inc_modals-js')
@endpush
