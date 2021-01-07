@extends('layouts.skeleton')

@section('app')
  <section class="section">
    <div class="container mt-5">
      <div class="row">
        @yield('content')
      </div>
    </div>
  </section>
@endsection
