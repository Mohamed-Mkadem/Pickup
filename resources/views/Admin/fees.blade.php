@extends('layouts.Admin')

@push('title')
    <title>Pickup | Fees </title>
@endpush

@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Fees</h1>


            <!-- Start Add Form -->
            <button class="header-btn add-btn pop-up-controller" id="add-btn"> <i class="fa-light fa-plus"></i> New
                Fee</button>
            <div class="pop-up-holder ">
                <div class="pop-up form-pop-up">
                    <div class="pop-up-header d-flex j-sp-between a-center">
                        <h2>Add Fee</h2>
                        <button class="close-pop-up-btn"><i class="fa-light fa-close"></i></button>
                    </div>
                    <div class="pop-up-body">
                        <!-- Start Form -->
                        <form action="{{ route('admin.fees.store') }}" method="post" id="add-form">
                            @csrf
                            <div class="form-control">
                                <label for="" class="d-block required form-label">
                                    Name :
                                </label>
                                <input type="text" name="name" id="name-input" placeholder="Fee Name"
                                    class="form-element">
                                <p class="error-message">This Field is Required</p>
                            </div>
                            <div class="form-control">
                                <label for="" class="form-label required">Value (DT)</label>
                                <input type="number" name="value" id="value-input" class="form-element"
                                    placeholder="eg: 100 ">
                                <p class="error-message">This Field Is Required</p>
                            </div>
                            <div class="form-control">
                                <label for="" class="form-label required">Method</label>
                                <input type="text" name="method" id="method-input"
                                    placeholder="Fee Method eg:Monthly, Yearly, One Time" class="form-element">
                                <p class="error-message">This Field Is
                                    Required</p>
                            </div>
                            <div class="editor-holder">
                                <label for="" class="form-label required">Features</label>
                                <textarea name="features" id="features" cols="30" rows="10"></textarea>
                                <p class="error-message" id="features-error-message">This Field Is Required
                                </p>
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
        @if ($fees->count() > 0)
            <div class="results">
                <div class="results-holder main-holder fees">
                    @foreach ($fees as $fee)
                        <!-- Start Fee -->

                        <div class="card simple fee">
                            <header>
                                <button class="actions-controller ml-auto"><i
                                        class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="actions-holder ">
                                    <li>
                                        <button class="editBtn">Edit</button>
                                        <div class="modal-holder">
                                            <div class=" form-modal modal">
                                                <div class="modal-header d-flex j-sp-between a-center">
                                                    <h2>Edit Fee</h2>
                                                    <button class="close-modal-holder-btn"><i
                                                            class="fa-light fa-close"></i></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Start Form -->
                                                    <form action="{{ route('admin.fees.update', $fee->id) }}" method="post"
                                                        class="edit-form">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="form-control">
                                                            <label for="" class="form-label required">Value
                                                                (DT)
                                                            </label>
                                                            <input type="number" name="value" class="form-element"
                                                                value="{{ $fee->value }}" placeholder="eg: 100 ">
                                                            <p class="error-message">This Field Is Required</p>
                                                        </div>

                                                        <div class="form-control">
                                                            <label for="" class="form-label required">Method</label>
                                                            <input type="text" name="method" value="{{ $fee->method }}"
                                                                placeholder="Fee Method eg:Monthly, Yearly, One Time"
                                                                class="form-element">
                                                            <p class="error-message">This Field Is
                                                                Required</p>
                                                        </div>

                                                        <div class="editor-holder">
                                                            <label for=""
                                                                class="form-label required">Features</label>
                                                            <textarea class="editor-textarea" name="features" cols="30" rows="10">
                                                    {!! $fee->features !!}
                                                </textarea>
                                                            <p class="error-message">This Field Is Required
                                                            </p>
                                                        </div>


                                                        <div class="form-control d-flex j-end">
                                                            <button type="submit" class="submit-btn">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </header>
                            <div class="top-header">
                                <h3>{{ $fee->name }}</h3>
                                <p class="price">{{ $fee->value }} DT<small>/{{ $fee->method }}</small> </p>
                            </div>
                            {!! $fee->features !!}
                        </div>
                        <!-- End Fee -->
                    @endforeach
                </div>

                {{ $fees->appends(request()->input())->links() }}
            </div>
        @else
            <div class="not-found-holder show">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p>No Results Found!</p>
                </div>
            </div>
        @endif
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#features'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'blockQuote'],
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



        const textareaInputs = Array.from(document.querySelectorAll('.editor-textarea'))
        textareaInputs.forEach((textarea, index) => {

            textarea.setAttribute('id', `editor-${index}`)
            let textareaId = textarea.getAttribute('id')
            ClassicEditor
                .create(document.querySelector(`#${textareaId}`), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'blockQuote'],
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
                let valueInput = form.elements[2]
                let valueInputErrorMessage = valueInput.nextElementSibling
                let methodInput = form.elements[3]
                let methodErrorMsg = methodInput.nextElementSibling
                let textareaInput = form.elements[4]

                let textareaInputErrorMessage = form.children[4].lastElementChild

                errors += validateField(valueInput, valueInputErrorMessage)
                errors += validateField(methodInput, methodErrorMsg)
                errors += validateField(textareaInput, textareaInputErrorMessage)
                if (!errors) {
                    form.submit()
                }
            })
        })
    </script>

    <script>
        const addForm = document.getElementById('add-form')
        const featuresInput = document.getElementById('features')
        const featuresInputErrorMessage = document.getElementById('features-error-message')
        const nameInput = document.getElementById('name-input')
        const methodInput = document.getElementById('method-input')

        const valueInput = document.getElementById('value-input')

        addForm.addEventListener('submit', (e) => {
            e.preventDefault()
            let errors = 0
            errors += validateField(nameInput, nameInput.nextElementSibling)
            errors += validateField(valueInput, valueInput.nextElementSibling)
            errors += validateField(featuresInput, featuresInputErrorMessage)

            errors += validateField(methodInput, methodInput.nextElementSibling)
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
