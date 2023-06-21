@extends('layouts.Seller')

@push('title')
    <title>Pickup | Edit Store</title>
@endpush
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Edit Store</h1>
        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')

        <form action="{{ route('seller.stores.update', $store->id) }}" id="store-form" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="main-holder">
                <h2 class="mb-1 form-holder-title">General Info</h2>
                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="form-label required">Name</label>
                        <input type="text" name="name" value="{{ $store->name }}" id="name-input"
                            class="form-element" placeholder="eg: Magico Store">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label for="" class="form-label ">Username (Not Editable)</label>
                        <input type="text" readonly value="{{ $store->username }}" id="username-input"
                            class="form-element" placeholder="eg: magico">

                    </div>
                </div>
                <div class="form-row">
                    <div class="form-control">
                        <label class="form-label required">Sector :</label>
                        <div class="select-box">
                            <select name="sector_id" id="sector-select" class="form-element">
                                @foreach ($sectors as $sector)
                                    <option value="{{ $sector->id }}"
                                        {{ $store->sector_id ?? $sector->id ? 'selected' : '' }}>
                                        {{ $sector->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label for="" class="form-label required">Phone</label>
                        <input type="number" name="phone" value="{{ $store->phone }}" class="form-element"
                            id="phone-input" placeholder="eg: 25412145" maxlength="8" inputmode="numeric">

                        <p class="error-message">This Field Is Required</p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-control">
                        <label class="form-label required">State :</label>
                        <div class="select-box">
                            <select name="state_id" id="state-select" class="form-element" onchange="getCities()">


                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ $store->state_id == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label class="form-label required">City :</label>
                        <div class="select-box">
                            <select name="city_id" value="{{ old('city_id') }}" class="form-element" id="city-select">




                                @foreach ($store->city->state->cities as $city)
                                    <option {{ $city->id == $store->city_id ? 'selected' : '' }}
                                        value="{{ $city->id }}">{{ $city->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label for="" class="form-label required">Address</label>
                        <input type="text" name="address" value="{{ $store->address }}" class="form-element"
                            id="address-input" placeholder="eg: 25 Awesome Street Name">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="editor-holder pop-up-editor">
                        <label for="" class="form-label required">Bio</label>
                        <textarea name="bio" class="form-element" id="bio-input" cols="30" rows="10">{{ $store->bio }}</textarea>
                        <p class="error-message" id="bio-error-message">This Field
                            Is Required
                        </p>
                    </div>
                </div>
            </div>
            <div class="main-holder">
                <h2 class="form-holder-title mb-1">Media</h2>
                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="form-label ">Avatar : </label>
                        <div class="drop-zone form-element">
                            <label for="avatar-image" class="drop-zone-label form-label">
                                <i class="fa-light fa-cloud-arrow-up d-block"></i>
                                <p>Drop File Here Or Click To Upload File</p>
                                <p>Allowed Formats are jpg, jpeg</p>
                            </label>
                            <input type="file" name="photo" id="avatar-image" accept="image/jpeg , image/jpg">
                        </div>
                        <p class="error-message" id="avatar-error-message">This Field Is Required</p>
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
                    <div class="form-control">
                        <label for="" class="form-label ">Cover : </label>
                        <div class="drop-zone form-element">
                            <label for="" class="drop-zone-label form-label">
                                <i class="fa-light fa-image"></i>
                                <p>Click To Choose A cover</p>

                            </label>
                            <button class="covers-modal-btn" id="covers-modal-btn"></button>
                            <div class="modal-holder ">
                                <div class="modal lg">
                                    <div class="modal-header d-flex j-sp-between a-center">
                                        <h2>Choose A Cover</h2>
                                        <button class="close-modal-holder-btn"><i class="fa-light fa-close"></i></button>
                                    </div>
                                    <div class="modal-body ">
                                        <div class="grid covers-grid">
                                            @foreach ($fileNames as $fileName)
                                                <!-- Start Grid Item -->
                                                <div class="grid-item  ">
                                                    <img class="radius-10"
                                                        src="{{ Storage::url('public/stores/covers/' . $fileName) }}"
                                                        alt="">
                                                    <input type="radio" data-img="{{ $fileName }}" name="cover"
                                                        value=" {{ 'public/stores/covers/' . $fileName }} ) }}">
                                                </div>
                                                <!-- End Grid Item -->
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="upload-area d-flex j-start a-center " style="    min-height: 61px;"
                            id="cover-upload-aree">
                            <i class="fa-solid fa-image"></i>
                            <div class="file-info">
                                <p class="file-name">
                                    FileName.png </p>


                            </div>
                            <i class="fa-light fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-holder">
                <h2 class="form-holder-title mb-1">Opening Hours</h2>
                <div class="form-control">
                    <div class="hours-wrapper">
                        <div class="form-row">
                            <!-- Start Day -->
                            <div class="day">
                                <h3>Monday</h3>
                                <div class="hours-holder">
                                    <div class="hour">
                                        <label for="" class="form-label required">Open</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[0]->opening_time)->format('H:i') }}"
                                            name="openingHours[monday][opening_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>
                                    <div class="hour">
                                        <label for="" class="form-label required">Close</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[0]->closing_time)->format('H:i') }}"
                                            name="openingHours[monday][closing_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>

                                </div>
                            </div>
                            <!-- End Day -->
                            <!-- Start Day -->
                            <div class="day">
                                <h3>Tuesday</h3>
                                <div class="hours-holder">
                                    <div class="hour">
                                        <label for="" class="form-label required">Open</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[1]->opening_time)->format('H:i') }}"
                                            name="openingHours[tuesday][opening_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>
                                    <div class="hour">
                                        <label for="" class="form-label required">Close</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[1]->closing_time)->format('H:i') }}"
                                            {{-- value="{{ $store->openingHours[1]->closing_time }}" --}} {{-- value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $store->openingHours[1]->closing_time)->format('h:i') }}" --}}
                                            name="openingHours[tuesday][closing_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>

                                </div>
                            </div>
                            <!-- End Day -->


                            <!-- Start Day -->
                            <div class="day">
                                <h3>Wednesday</h3>
                                <div class="hours-holder">
                                    <div class="hour">
                                        <label for="" class="form-label required">Open</label>
                                        <input type="time"
                                            class="form-element"value="{{ \Carbon\Carbon::parse($store->openingHours[2]->opening_time)->format('H:i') }}"
                                            name="openingHours[wednesday][opening_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>
                                    <div class="hour">
                                        <label for="" class="form-label required">Close</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[2]->closing_time)->format('H:i') }}"
                                            name="openingHours[wednesday][closing_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>

                                </div>
                            </div>
                            <!-- End Day -->
                            <!-- Start Day -->

                            <div class="day">
                                <h3>Thursday</h3>
                                <div class="hours-holder">
                                    <div class="hour">
                                        <label for="" class="form-label required">Open</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[3]->opening_time)->format('H:i') }}"
                                            name="openingHours[thursday][opening_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>
                                    <div class="hour">
                                        <label for="" class="form-label required">Close</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[3]->closing_time)->format('H:i') }}"
                                            name="openingHours[thursday][closing_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>

                                </div>
                            </div>
                            <!-- End Day -->


                            <!-- Start Day -->
                            <div class="day">
                                <h3>Friday</h3>
                                <div class="hours-holder">
                                    <div class="hour">
                                        <label for="" class="form-label required">Open</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[4]->opening_time)->format('H:i') }}"
                                            name="openingHours[friday][opening_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>
                                    <div class="hour">
                                        <label for="" class="form-label required">Close</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[4]->closing_time)->format('H:i') }}"
                                            name="openingHours[friday][closing_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>

                                </div>
                            </div>
                            <!-- End Day -->

                            <!-- Start Day -->
                            <div class="day">
                                <h3>Saturday</h3>
                                <div class="hours-holder">
                                    <div class="hour">
                                        <label for="" class="form-label required">Open</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[5]->opening_time)->format('H:i') }}"
                                            name="openingHours[saturday][opening_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>
                                    <div class="hour">
                                        <label for="" class="form-label required">Close</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[5]->closing_time)->format('H:i') }}"
                                            name="openingHours[saturday][closing_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>

                                </div>
                            </div>

                            <!-- End Day -->

                            <!-- Start Day -->
                            <div class="day">
                                <h3>Sunday</h3>
                                <div class="hours-holder">
                                    <div class="hour">
                                        <label for="" class="form-label required">Open</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[6]->opening_time)->format('H:i') }}"
                                            name="openingHours[sunday][opening_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>
                                    <div class="hour">
                                        <label for="" class="form-label required">Close</label>
                                        <input type="time" class="form-element"
                                            value="{{ \Carbon\Carbon::parse($store->openingHours[6]->closing_time)->format('H:i') }}"
                                            name="openingHours[sunday][closing_time]"
                                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                    </div>

                                </div>
                            </div>
                            <!-- End Day -->
                        </div>
                    </div>
                    <p class="error-message" id="hours-error-message">This Field Is Required</p>
                </div>

                <div class="buttons d-flex j-end gap-1 wrap mt-1">
                    <button type="reset" class="resetBtn">Reset</button>
                    <button type="submit" id="submitBtn" class="submitBtn">Save Changes</button>

                </div>
            </div>
        </form>

    </section>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script>
        const storeForm = document.getElementById('store-form')
        if (storeForm) {


            ClassicEditor
                .create(document.querySelector('#bio-input'), {
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


            const nameInput = document.getElementById('name-input')

            const sectorInput = document.getElementById('sector-select')
            const stateInput = document.getElementById('state-select')
            const cityInput = document.getElementById('city-select')
            const phoneInput = document.getElementById('phone-input')
            const addressInput = document.getElementById('address-input')
            const bioInput = document.getElementById('bio-input')
            const avatarInput = document.getElementById('avatar-image')
            const avatarInputErrorMessage = document.getElementById('avatar-error-message')

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


            storeForm.addEventListener('submit', (e) => {
                e.preventDefault()
                let errors = 0
                errors += validateField(nameInput, nameInput.nextElementSibling)

                errors += validateField(addressInput, addressInput.nextElementSibling)
                errors += validateField(phoneInput, phoneInput.nextElementSibling)
                errors += validateField(sectorInput, sectorInput.parentElement.nextElementSibling)
                errors += validateField(stateInput, stateInput.parentElement.nextElementSibling)
                errors += validateField(cityInput, cityInput.parentElement.nextElementSibling)
                errors += validateField(bioInput, bioInput.parentElement.lastElementChild)

                // errors += validateField(avatarInput, avatarInputErrorMessage)
                if (!errors) storeForm.submit()
            })
            const resetBtn = document.querySelector('.resetBtn')
            resetBtn.addEventListener('click', () => {
                let errorMessages = document.querySelectorAll('p.error-message')
                errorMessages.forEach(msg => {
                    msg.classList.remove('show')
                    msg.textContent = ''
                })
            })
            const closeBtns = document.querySelectorAll('.close-modal-holder-btn')
            closeBtns.forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault()
                })
            })
            const coversModalBtn = document.getElementById('covers-modal-btn')
            coversModalBtn.addEventListener('click', (e) => {
                e.preventDefault()
                let modalHolder = coversModalBtn.nextElementSibling
                modalHolder.classList.add('show')
                document.body.classList.add('no-scroll')
            })
            document.addEventListener('keydown', (e) => {
                if (e.key == 'Enter') {
                    e.preventDefault()
                }
            })
            avatarInput.addEventListener('change', () => {
                if (validateFileType(avatarInput)) {
                    showFileInfo(avatarInput)

                } else {
                    showFileTypeError(avatarInput)
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
                errorMessage.textContent = 'We Only Accept Jpeg, Jpg'
                errorMessage.classList.add('show')
            }
            const coverUploadArea = document.getElementById('cover-upload-aree')
            const coverInputs = document.querySelectorAll('input[name=cover]')
            coverInputs.forEach((btn) => {
                btn.addEventListener('change', () => {
                    let imgName = btn.dataset.img
                    let fileName = coverUploadArea.querySelector('.file-name')
                    fileName.textContent = imgName
                    coverUploadArea.classList.add('show')


                })
            })

            const cityField = document.getElementById('city-select')

            function getCities() {
                // Get the selected state value
                var stateId = document.getElementById('state-select').value;

                // Make an AJAX request to the server to fetch the cities based on the selected state
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        // Handle the response from the server
                        var cities = JSON.parse(xhr.responseText);

                        // Update the city select input options

                        cityField.innerHTML = ''; // Clear existing options

                        // Create new option elements for each city
                        cities.forEach(function(city) {
                            var option = document.createElement('option');
                            option.value = city.id;
                            option.text = city.name;
                            cityField.appendChild(option);
                        });
                    }
                };

                // Send the AJAX request
                xhr.open('GET', '/api/cities/' + stateId, true);
                xhr.send();
            }
        }
    </script>
    @include('components.inc_modals-js')
@endpush
