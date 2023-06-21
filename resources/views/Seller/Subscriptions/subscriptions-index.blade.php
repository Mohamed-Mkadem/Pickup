@extends('layouts.Seller')

@push('title')
    <title>Pickup | Subscriptions</title>
@endpush
@section('content')
    @include('components.errors-alert')
    @include('components.session-errors-alert')
    @include('components.success-alert')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Subscriptions</h1>
            <!-- Start Link  -->
            <a href="{{ route('seller.stores.subscriptions.create') }}" class="header-btn d-block add-btn">
                <i class="fa-light fa-plus"></i>
                <span>New Subscription</span>
            </a>
            <!-- End Link  -->


        </div>
        <!-- End Starter Header -->


        @if ($subscriptions->count() > 0)
            <div class="results">
                <h2 class="t-left">Results</h2>
                <!-- Start Results Holder -->
                <div class=" main-holder">
                    <div class="table-responsive seller-subscriptions">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>

                                    <th>Duration </th>
                                    <th>Amount <span>(DT)</span></th>
                                    <th>Date </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr>
                                        <td>#{{ $subscription->id }}</td>

                                        <td>{{ $subscription->duration }}</td>
                                        <td>{{ $subscription->amount }}</td>
                                        <td>{{ \Carbon\Carbon::parse($subscription->created_at)->format('M jS Y - H:i') }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Results Holder -->


                <!-- Start Pagination -->
                {!! $subscriptions->appends(request()->input())->links() !!}
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

    </section>
@endsection

@push('scripts')
@endpush
