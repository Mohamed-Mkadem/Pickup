@extends('layouts.Seller')

@push('title')
    <title>Pickup | Sale Details </title>
@endpush
@section('content')
    <section class="content" id="content">

        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')

        <div class="sale-holder show-holder">
            <!-- Start Header -->
            <header>
                <div class="img-holder">
                    <img src="{{ asset('storage/' . $sale->store->photo) }}" alt="">
                </div>
                <div class="info-holder w-100">
                    <div class="d-flex j-sp-between a-center wrap gap-0-5">

                        <p class=" header-title">
                            Sale - <span class=" header-id">#{{ $sale->id }}</span>
                        </p>

                        <ul class="d-flex j-center gap-0-5 a-center wrap">

                            <li>
                                <button class="deleteBtn delete-button">Delete</button>

                                <div class="modal-holder ">
                                    <form action="{{ route('seller.sales.destroy', $sale->id) }}" method="post"
                                        class="modal t-center confirm-form">
                                        @csrf
                                        @method('DELETE')
                                        <i class=" fa-light fa-trash"></i>

                                        <p> Deleting this sale will result in an adjustment to the product quantities
                                            associated with this sale
                                        </p>

                                        <p>Are You Sure You Want To Delete This Sale ?</p>
                                        <div class="buttons d-flex j-center a-center">
                                            <button class="cancelBtn">Cancel</button>
                                            <button class="confirmBtn">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class=" header-details">

                        <div class="detail">
                            <span>Created : </span>
                            <p>{{ $sale->created_at->format('M jS Y H:i') }}</p>
                        </div>
                        <div class="detail">
                            <span>Amount (DT) : </span>
                            <p>{{ number_format($sale->amount, 3, ',') }}</p>
                        </div>
                        <div class="detail">
                            <span>N° Of Items : </span>
                            <p>{{ $sale->no_items }}</p>
                        </div>

                    </div>
                </div>
            </header>
            <!-- End Header -->


            <!-- Start Sale Details Holder -->
            <div class="sale-details-holder holder">
                <h2>Sale Details</h2>
                <div class="table-responsive sale-details">
                    <table>

                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price (DT) </th>
                                <th>Quantity</th>
                                <th>Total (DT)</th>


                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($saleProducts as $product)
                                <tr>
                                    <td><img src="{{ asset($product->image) }}" alt="">
                                    </td>
                                    <td><a href="{{ route('seller.products.show', $product->id) }}">{{ $product->name }}</a>
                                    </td>
                                    <td>{{ number_format($product->price, 3, ',') }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ number_format($product->sub_total, 3, ',') }}</td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Sale Details Holder -->
            <!-- Start Pagination -->
            {!! $saleProducts->appends(request()->input())->links() !!}
            <!-- End Pagination -->
        </div>



    </section>
@endsection

@push('scripts')
    @include('components.inc_modals-js')
@endpush
