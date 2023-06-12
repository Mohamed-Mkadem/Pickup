@if ($errors->any())
    <ul class="alert alert-error mb-1">
        @foreach ($errors->all() as $error)
            <li> {{ $error }} </li>
        @endforeach
    </ul>
@endif
