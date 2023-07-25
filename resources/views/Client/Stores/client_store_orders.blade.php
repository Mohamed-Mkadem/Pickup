@extends('layouts.client-store')

@push('title')
    <title>{{ $store->name }} | Orders</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @if ($store->status == 'unpublished' || $store->status == 'banned')
            <div class="unavailable-wrapper d-flex col a-center ">
                <img src="{{ asset('dist/Assets/404_error.svg') }}" alt="">
                <p class="info-message">This store's subscription has expired, and it is no
                    longer available for browsing or making purchases. It will remain inaccessible until the
                    store owner purchases a new subscription. We apologize for any inconvenience caused. In the
                    meantime, feel free to check out our other active stores for your shopping needs.</p>
                <div class="buttons d-flex j-sp-between a-center gap-1 wrap mt-1">
                    <a href="{{ url()->previous() }}" class="go-back">Go Back</a>
                    <a href="{{ route('client.shopping') }}" class="shopping">Shopping</a>
                </div>
            </div>
        @elseif($store->status == 'maintenance')
            <div class="unavailable-wrapper d-flex col a-center ">
                <img src="{{ asset('dist/Assets/maintenance.svg') }}" alt="">
                <p class="info-message">This store is currently undergoing maintenance to improve your shopping
                    experience. The store owner is working diligently
                    to complete the necessary fixes and updates. Once the maintenance is finished, the store
                    will be published again. Thank you for your patience and understanding</p>
                <div class="buttons d-flex j-sp-between a-center gap-1 wrap mt-1">
                    <a href="{{ url()->previous() }}" class="go-back">Go Back</a>
                    <a href="{{ route('client.shopping') }}" class="shopping">Shopping</a>
                </div>
            </div>
        @else
            @include('components.errors-alert')
            @include('components.session-errors-alert')
            @include('components.success-alert')
            @include('components.Stores.client-store-header', ['store' => $store])

            <!-- Start Store Content -->
            <div class="store-content mt-2">
                @if ($orders->count() > 0)
                    <!-- Strt Results -->
                    <div class="results">
                        <h2 class="t-left">Results</h2>
                        <!-- Start Results Holder -->
                        <div class=" main-holder">
                            <div class="table-responsive client-orders">
                                <table>

                                    <thead>
                                        <tr>
                                            <th>ID</th>

                                            <th>Store </th>
                                            <th>Amount (DT)</th>
                                            <th>Status </th>
                                            <th>Date </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td><a
                                                        href="{{ route('client.store.order', ['id' => $order->id, 'username' => $store->username]) }}">#{{ $order->id }}</a>
                                                </td>

                                                <td><a
                                                        href="{{ route('client.store.home', $order->store->username) }}">{{ ucfirst($order->store->name) }}</a>
                                                </td>
                                                <td>{{ number_format($order->amount, 3, ',') }}</td>
                                                <td class="status {{ $order->status }} ">
                                                    <span>{{ ucfirst($order->status) }}</span>
                                                </td>
                                                <td>{{ $order->created_at->format('M jS Y H:i') }}</td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Results Holder -->


                        <!-- Start Pagination   -->
                        {!! $orders->appends(request()->input())->links() !!}
                        <!-- End Pagination -->
                    </div>
                    <!-- End Results -->
                @else
                    <!-- Start Not found -->
                    <div class="not-found-holder show">
                        <div class="wrapper">
                            <i class="fa-light fa-circle-info"></i>
                            <p>There Is No Results Found</p>
                        </div>
                    </div>
                    <!-- End Not found -->
                @endif

            </div>
            <!-- End Store Content -->
        @endif
    </section>
@endsection

@push('scripts')
@endpush
