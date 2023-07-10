@extends('layouts.Store')

@push('title')
    <title>{{ $store->name }} | Sale Details</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        @include('components.Stores.store-header', ['store' => $store])
        <!-- Start Store Content -->
        <div class="store-content mt-2">
            <div class="sale-holder show-holder">
                <!-- Start Header -->
                <header>
                    <div class="img-holder">
                        <img src="{{ asset('storage/' . $sale->store->photo) }}" alt="">
                    </div>
                    <div class="info-holder">
                        <p class=" header-title">
                            Sale - <span class=" header-id">#{{ $sale->id }}</span>


                        </p>
                        <div class=" header-details">
                            <div class="detail">
                                <span><i class="fa-light fa-shop"></i> </span> <a
                                    href="{{ route('admin.store.home', $sale->store->username) }}">
                                    {{ $sale->store->name }} ({{ $sale->store->status }})</a>
                            </div>
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
                                        <td><img src="{{ $product->image }}" alt=""></td>
                                        <td>{{ $product->name }}</td>
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
        </div>
        <!-- End Store Content -->

    </section>
@endsection

@push('scripts')
@endpush
