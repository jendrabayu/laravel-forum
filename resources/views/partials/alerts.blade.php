@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="m-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif


@if (session('status'))
  <div class="alert alert-success">
    {{ session('status') }}
  </div>
@endif

@if (session('status_warning'))
  <div class="alert alert-warning">
    {{ session('status_warning') }}
  </div>
@endif
