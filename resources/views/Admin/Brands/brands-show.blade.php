@extends('layouts.Admin')

@push('title')
    <title>Pickup | Brand Details</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">


            <h1>{{ $brand->name }}</h1>
        </div>
        <!-- End Starter Header -->

        <!-- Start Show Header -->
        <div class="show-header brands d-flex j-start  a-center  col main-holder">
            <div class="img-holder">
                <img src="{{ asset('storage/' . $brand->logo) }}" alt="">

            </div>
            <div class="info-holder">
                <div class="top-header d-flex col j-center a-center">
                    <h2>{{ $brand->name }} </h2>
                    <ul class="horizontal-actions-holder d-flex j-sp-between a-center">
                        <li>

                            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="penEditBtn"
                                aria-label="Edit Brand">
                                <i class="fa-light fa-pen"></i>
                            </a>
                        </li>
                        <li>
                            <button class="deleteBtn delete-button">Delete</button>
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
                </div>
                <div class="details">
                    <p class="p-span">Status : <span>{{ $brand->status }}</span></p>
                    <p class="p-span">Created : <span>{{ $brand->created_at }}</span></p>
                    <p class="p-span">N° Of Products : <span>18</span></p>
                </div>
            </div>
        </div>
        <!-- End Show Header -->

        <!-- Start Description Holder -->
        <div class="description-holder  main-holder sm">
            <header class="d-flex j-sp-between a-center">
                <h2>Description</h2>
                <!-- <button id="description-holder-controller" aria-controls="#description-body"><i
                                                            class="fa-light fa-circle-caret-down"></i></button> -->
            </header>
            <div class="description-body" id="description-body">
                {!! $brand->description !!}
            </div>
        </div>
        <!-- End Description Holder -->






        
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('dist/JS/modals.js') }}"></script>
@endpush
