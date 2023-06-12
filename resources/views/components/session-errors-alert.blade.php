@if (session()->has('error'))
    <div class="alert alert-error m-1 mb-1">{{ session()->get('error') }}</div>
@endif
