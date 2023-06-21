@extends('layouts.Store')

@push('title')
    <title>{{ $store->name }} | Reviews</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @include('components.Stores.store-header', ['store' => $store])
    </section>
@endsection

@push('scripts')
@endpush
