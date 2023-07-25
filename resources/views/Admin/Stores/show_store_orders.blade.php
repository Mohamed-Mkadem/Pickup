@extends('layouts.Store')

@push('title')
    <title>{{ $store->name }} | Orders</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        @include('components.Stores.store-header', ['store' => $store])
        <!-- Start Store Content -->
        <div class="store-content mt-2">

            @if ($orders->count() > 0)
                <div class="results">
                    <h2 class="t-left">Results</h2>
                    <!-- Start Results Holder -->
                    <div class=" main-holder">
                        <div class="table-responsive orders">
                            <table>

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Client </th>
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
                                                    href="{{ route('admin.store.order', ['id' => $order->id, 'username' => $order->store->username]) }}">#{{ $order->id }}</a>
                                            </td>
                                            <td><a
                                                    href="{{ route('admin.clients.show', $order->client->user->id) }}">{{ ucfirst($order->client->user->full_name) }}</a>
                                            </td>
                                            <td><a
                                                    href="{{ route('admin.store.home', $order->store->username) }}">{{ ucfirst($order->store->name) }}</a>
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


                    <!-- Start Pagination -->
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
    </section>
@endsection

@push('scripts')
@endpush
