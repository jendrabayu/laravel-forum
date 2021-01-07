@extends('layouts.auth')

@section('content')
  <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
    <div class="login-brand">
      <img src="{{ asset('img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
    </div>
    @include('partials.alerts')

    <div class="card card-primary">
      <div class="card-header">
        <h4>Register</h4>
      </div>

      <div class="card-body">
        <form action="{{ route('register') }}" method="POST">
          @csrf
          <div class="row">
            <div class="form-group col-6">
              <label for="first_name">First Name</label>
              <input id="first_name" type="text" class="form-control" name="first_name" tabindex="1" autofocus>
            </div>
            <div class="form-group col-6">
              <label for="last_name">Last Name</label>
              <input id="last_name" type="text" class="form-control" name="last_name" tabindex="2">
            </div>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control" name="email" tabindex="3">
          </div>

          <div class="form-group">
            <label for="username">Username</label>
            <input id="username" type="username" class="form-control" name="username" tabindex="4">
          </div>

          <div class="row">
            <div class="form-group col-6">
              <label for="password" class="d-block">Password</label>
              <input id="password" type="password" class="form-control" name="password" tabindex="5">
            </div>
            <div class="form-group col-6">
              <label for="password_confirmation" class="d-block">Password Confirmation</label>
              <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"
                tabindex="6">
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">
              Register
            </button>
          </div>
        </form>
      </div>
    </div>
    <div class="mt-5 text-muted text-center">
      Already have an account? <a href="{{ route('login') }}">Login</a>
    </div>
    <div class="simple-footer">
      Copyright &copy; {{ config('app.name') }} 2020
    </div>
  </div>

@endsection
