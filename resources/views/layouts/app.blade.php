@extends('layouts.skeleton')

@section('app')
  <div class="main-wrapper container">
    <div class="navbar-bg"></div>
    <nav class="navbar navbar-expand-lg main-navbar">
      @include('partials.topnav')
    </nav>

    <nav class="navbar navbar-secondary navbar-expand-lg">
      <div class="container">
        <ul class="navbar-nav">
          @include('partials.navbar')
        </ul>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        @yield('content')
      </section>

    </div>
    <footer class="main-footer">
      @include('partials.footer')
    </footer>

    @yield('modal')
  </div>
@endsection



@section('body-class', 'layout-3')
