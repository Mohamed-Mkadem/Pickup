@extends('layouts.Admin')

@push('title')
    <title>Pickup | Verification Request Details </title>
@endpush

@push('light-box')
    <div class="light-box" id="light-box">
        <div class="main-image">
            <button id="close-light-box"><i class="fa-light fa-close"></i></button>
            <button class="arrow-btn" id="prev-btn"><i class="fa-light fa-circle-arrow-left"></i></button>
            <img src="{{ asset('storage/' . $request->photo) }}" alt="">
            <button class="arrow-btn" id="next-btn"><i class="fa-light fa-circle-arrow-right"></i></button>
        </div>

    </div>
    @section('content')
        <section class="content" id="content">
            <!-- Start Starter Header -->
            <div class="starter-header wrap d-flex a-center j-sp-between col" id="starter-header">
                <h1 class="t-center">Verification Request Details</h1>

                <!-- Start Link -->
                <a href="{{ url()->previous() }}" class="action-btn d-block">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Go Back</span> </a>
                <!-- End Link -->
            </div>


            <!-- End Starter Header -->


            @include('components.errors-alert')
            @include('components.session-errors-alert')
            @include('components.success-alert')

            <!-- Start Show Header -->
            <div class="show-header clients d-flex j-start  a-center  col main-holder">
                <div class="img-holder">
                    <img src="{{ asset('storage/' . $request->seller->user->photo) }}" alt="">
                </div>
                <div class="info-holder">
                    <div class="top-header d-flex col j-center a-center">
                        <h2>{{ $request->seller->user->full_name }} ({{ $request->seller->user->status }}) </h2>
                        <ul
                            class="horizontal-actions-holder  d-flex  j-center a-center  {{ $request->status == 'pending' ? 'gap-1 wrap' : '' }} ">

                            @if ($request->status == 'pending')
                                <li>
                                    <button class="deleteBtn delete-button">Reject</button>

                                    <div class="modal-holder ">
                                        <form action="{{ route('admin.verification-requests.reject', $request->id) }}"
                                            method="post" class="modal t-center confirm-form">
                                            @method('PATCH')
                                            @csrf
                                            <i class=" fa-light fa-trash"></i>
                                            <p>Are You Sure You Want To Reject This Request ?</p>
                                            <div class="buttons d-flex j-center a-center">
                                                <button class="cancelBtn">Cancel</button>
                                                <button class="confirmBtn">Yes</button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                <li>
                                    <button class="activateBtn activate-button">Approve</button>
                                    <div class="modal-holder ">
                                        <form action="{{ route('admin.verification-requests.approve', $request->id) }}"
                                            method="post" class="modal t-center confirm-form">
                                            @method('PATCH')
                                            @csrf
                                            <i class=" fa-light fa-trash"></i>
                                            <p>Are You Sure You Want To Approve This Request ?</p>
                                            <div class="buttons d-flex j-center a-center">
                                                <button class="cancelBtn">Cancel</button>
                                                <button class="confirmBtn">Yes</button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            @else
                                <li>
                                    <p>
                                        {{ $request->statusHistories()->latest()->first()->action }} :
                                        {{ $request->statusHistories()->latest()->first()->created_at }}
                                    </p>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="details">
                        <p class="mb-1">{{ $request->seller->user->state_city }}</p>
                        <p class="p-span mb-1">Created : <span>{{ $request->created_at }}</span></p>
                    </div>
                </div>
            </div>
            <!-- End Show Header -->


            <!-- Start Info -->
            <div class="results">


                <h2 class="t-left mb-0-5 ">Request History</h2>
                <!-- Start Quick Stats Holder -->
                <div class="quick-stats-holder ">
                    <!-- Start Quick Stats Holder -->
                    <div class="quick-stats-holder ">
                        @foreach ($request->statusHistories as $history)
                            <!-- Start Stat -->
                            <div class="stat-item">
                                <!-- Start Top Info -->
                                <div class="top-info mb-0 d-flex a-start j-sp-between">
                                    <div class="title-value-box">
                                        <p class="box-title">{{ $history->action }}</p>
                                        <p class="box-value light">{{ $history->created_at }}</p>
                                    </div>

                                    @if ($history->action == 'Placed')
                                        <div class="icon-holder">
                                            <i class="fa-solid fa-timer placed"></i>
                                        </div>
                                    @elseif ($history->action == 'Approved')
                                        <div class="icon-holder">

                                            <i class="fa-solid fa-badge-check accepted"></i>
                                        </div>
                                    @else
                                        <div class="icon-holder">

                                            <i class="fa-solid fa-xmark rejected"></i>


                                        </div>
                                    @endif


                                </div>
                                <!-- End Top Info -->

                            </div>
                            <!-- End Stat -->
                        @endforeach

                    </div>
                    <!-- End Quick Stats Holder -->

                </div>
                <!-- End Quick Stats Holder -->

                <h2 class="t-left mb-0-5 ">Documents</h2>
                <div class="results-holder documents-grid mt-0">

                    <!-- Start Document -->
                    <div class="document main-holder p-0 m-0">
                        <div class="document-header">
                            <h3>Photo</h3>
                        </div>
                        <div class="document-img">
                            <img src="{{ asset('storage/' . $request->photo) }}" alt="">
                            <div class="document-overlay">
                                <button class="viewBtn" data-img="0">View</button>
                                <a href="{{ asset('storage/' . $request->photo) }}"
                                    download="{{ $request->seller->user->first_name . '_' . $request->seller->user->last_name . '_photo_' . pathinfo($request->photo, PATHINFO_EXTENSION) }}">Download</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Document -->
                    <!-- Start Document -->
                    <div class="document main-holder p-0 m-0">
                        <div class="document-header">
                            <h3>N.I.D Front Face</h3>
                        </div>
                        <div class="document-img">
                            <img src="{{ asset('storage/' . $request->nid_front) }}" alt="">
                            <div class="document-overlay">
                                <button class="viewBtn" data-img="1">View</button>
                                <a href="{{ asset('storage/' . $request->nid_front) }}"
                                    download="{{ $request->seller->user->first_name . '_' . $request->seller->user->last_name . '_nid_front_' . pathinfo($request->photo, PATHINFO_EXTENSION) }}">Download</a>
                            </div>
                        </div>

                    </div>
                    <!-- End Document -->
                    <!-- Start Document -->
                    <div class="document main-holder p-0 m-0">
                        <div class="document-header">
                            <h3>N.I.D Back Face</h3>
                        </div>
                        <div class="document-img">
                            <img src="{{ asset('storage/' . $request->nid_back) }}" alt="">
                            <div class="document-overlay">
                                <button class="viewBtn" data-img="2">View</button>
                                <a href="{{ asset('storage/' . $request->nid_back) }}"
                                    download="{{ $request->seller->user->first_name . '_' . $request->seller->user->last_name . '_nid_back_' . pathinfo($request->photo, PATHINFO_EXTENSION) }}">Download</a>
                            </div>
                        </div>

                    </div>
                    <!-- End Document -->
                    <!-- Start Document -->
                    <div class="document main-holder p-0 m-0">
                        <div class="document-header">
                            <h3>Commercial Register</h3>
                        </div>
                        <div class="document-img">
                            <img src="{{ asset('storage/' . $request->commercial_register) }}" alt="">
                            <div class="document-overlay">
                                <button class="viewBtn" data-img="3">View</button>
                                <a href="{{ asset('storage/' . $request->commercial_register) }}"
                                    download="{{ $request->seller->user->first_name . '_' . $request->seller->user->last_name . '_commercial_register_' . pathinfo($request->photo, PATHINFO_EXTENSION) }}">Download</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Document -->


                </div>

                <h2 class="t-left mb-0-5 ">General Info</h2>
                <div class=" results-holder mt-0 client-seller-show ">
                    <!-- Start Info Card -->
                    <div class="info-card main-holder ">

                        <!-- Start Card Info -->
                        <div class="card-info">

                            <!-- Start Info -->
                            <div class="info">
                                <div class="info-label">
                                    <i class="fa-light fa-envelope"></i>
                                    <h3>Email</h3>
                                </div>
                                <div class="info-value">
                                    <p>
                                        {{ $request->seller->user->email }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Info -->
                            <!-- Start Info -->
                            <div class="info">
                                <div class="info-label">
                                    <i class="fa-light fa-phone"></i>
                                    <h3>Phone</h3>
                                </div>
                                <div class="info-value">
                                    <p>
                                        {{ $request->seller->user->phone }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Info -->
                            <!-- Start Info -->
                            <div class="info">
                                <div class="info-label">
                                    <i class="fa-light fa-calendar"></i>
                                    <h3>Date Of Birth</h3>
                                </div>
                                <div class="info-value">
                                    <p>
                                        {{ $request->seller->user->d_o_b }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Info -->
                            <!-- Start Info -->
                            <div class="info">
                                <div class="info-label">
                                    <i class="fa-light fa-venus-mars"></i>
                                    <h3>Gender</h3>
                                </div>
                                <div class="info-value">
                                    <p>
                                        {{ $request->seller->user->gender }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Info -->





                        </div>
                        <!-- End Card Info -->
                    </div>
                    <!-- End Info Card -->

                    <!-- Start Info Card -->
                    <div class="info-card main-holder ">

                        <!-- Start Card Info -->
                        <div class="card-info">
                            <!-- Start Info -->
                            <div class="info">
                                <div class="info-label">
                                    <i class="fa-light fa-badge-check"></i>
                                    <h3>Verification</h3>
                                </div>
                                <div class="info-value">
                                    <p>
                                        {{ $request->seller->verification }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Info -->
                            <!-- Start Info -->
                            <div class="info">
                                <div class="info-label">
                                    <i class="fa-light fa-address-card"></i>
                                    <h3>N.I.D</h3>
                                </div>
                                <div class="info-value">
                                    <p>
                                        {{ $request->seller->nid }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Info -->
                            <!-- Start Info -->
                            <div class="info">
                                <div class="info-label">
                                    <i class="fa-light fa-map-location-dot"></i>
                                    <h3>Address</h3>
                                </div>
                                <div class="info-value">
                                    <p>
                                        {{ $request->seller->user->address }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Info -->
                            <!-- Start Info -->
                            <div class="info">
                                <div class="info-label">
                                    <i class="fa-light fa-timer"></i>
                                    <h3>Joined At</h3>
                                </div>
                                <div class="info-value">
                                    <p>
                                        {{ \Carbon\Carbon::parse($request->seller->user->created_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Info -->

                        </div>
                        <!-- End Card Info -->

                    </div>
                    <!-- End Info Card -->

                </div>

                <h2 class="t-left mb-0-5 ">Bank Info</h2>
                <div class="results-holder bank-info">
                    <!-- Start Info -->
                    <div class="info main-holder p-1 radius-10 shadow-1 m-0">
                        <div class="info-title d-flex j-start a-center ">
                            <i class="fa-light fa-bank"></i>
                            <h3>Bank</h3>
                        </div>
                        <div class="info-value">
                            <p>{{ $request->seller->bank }}</p>
                        </div>
                    </div>
                    <!-- End Info -->
                    <!-- Start Info -->
                    <div class="info main-holder p-1 radius-10 shadow-1 m-0">
                        <div class="info-title d-flex j-start a-center ">
                            <i class="fa-light fa-user"></i>
                            <h3>Account Holer</h3>
                        </div>
                        <div class="info-value">
                            <p>{{ $request->seller->account_name }}</p>
                        </div>
                    </div>
                    <!-- End Info -->
                    <!-- Start Info -->
                    <div class="info main-holder p-1 radius-10 shadow-1 m-0">
                        <div class="info-title d-flex j-start a-center ">
                            <i class="fa-light fa-bank"></i>
                            <h3>R.I.B</h3>
                        </div>
                        <div class="info-value">
                            <p>{{ $request->seller->rib }}</p>
                        </div>
                    </div>
                    <!-- End Info -->
                </div>


            </div>
            <!-- End Info -->
        </section>
    @endsection

    @push('scripts')
        <script>
            const viewBtns = Array.from(document.querySelectorAll(".viewBtn"));
            let lightBoxPrevBtn = document.getElementById("prev-btn");

            let lightBoxNextBtn = document.getElementById("next-btn");
            const lightBox = document.getElementById("light-box");
            const lightboxImages = Array.from(
                document.querySelectorAll(".document-img img")
            );
            const mainLightBoxImg = lightBox.querySelector(".main-image img");
            lightBox.addEventListener("click", (e) => {
                if (e.target.classList.contains("light-box")) {
                    lightBox.classList.remove("show");
                    document.body.classList.remove("no-scroll");
                }
            });

            viewBtns.forEach((btn) => {
                btn.addEventListener("click", (e) => {
                    let currentImage = e.target.parentElement.parentElement.firstElementChild;
                    mainLightBoxImg.src = currentImage.getAttribute("src");
                    mainLightBoxImg.setAttribute("data-img", btn.dataset.img);
                    lightBox.classList.add("show");
                    document.body.classList.add("no-scroll");
                    removeActive();
                    btn.classList.add("active");
                });
            });
            const closeLightBoxBtn = document.getElementById("close-light-box");
            closeLightBoxBtn.addEventListener("click", () => {
                lightBox.classList.remove("show");
                document.body.classList.remove("no-scroll");
            });

            function moveToSlide(currentImgIndex, targetImgIndex) {
                viewBtns[currentImgIndex].classList.remove("active");
                viewBtns[targetImgIndex].classList.add("active");
                mainLightBoxImg.src = lightboxImages[targetImgIndex].src;
            }

            lightBoxNextBtn.addEventListener("click", () => {
                currentImgIndex = Number(
                    document.querySelector(".viewBtn.active").dataset.img
                );

                targetImgIndex = currentImgIndex + 1;
                if (currentImgIndex == 3) return;
                moveToSlide(currentImgIndex, targetImgIndex);
                // mainLightBoxImg.src = images[targetImgIndex].src;
            });
            lightBoxPrevBtn.addEventListener("click", () => {
                currentImgIndex = Number(
                    document.querySelector(".viewBtn.active").dataset.img
                );

                targetImgIndex = currentImgIndex - 1;
                if (currentImgIndex == 0) return;
                moveToSlide(currentImgIndex, targetImgIndex);
                // mainLightBoxImg.src = images[targetImgIndex].src;
            });

            function removeActive() {
                viewBtns.forEach((btn) => {
                    btn.classList.remove("active");
                });
            }
        </script>
        @include('components.inc_modals-js')
    @endpush
