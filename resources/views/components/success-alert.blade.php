@if (session()->has('success'))
    <div class="alert alert-success m-1 mb-1">{{ session()->get('success') }}</div>
@endif
