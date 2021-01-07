@extends('layouts.app')

@section('title', 'Ganti Password')

@section('content')
  <div class="row">
    <div class="col-lg-10">
      <div class="section-header">
        <h1>Ganti Password</h1>
      </div>

      <div class="section-body">
        @include('partials.alerts')
        <div class="card">
          <div class="card-body">
            <form action="{{ route('account.update_password') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="form-group">
                <label for="current_password">Password saat ini <code>*</code></label>
                <input id="current_password" type="password" class="form-control" name="current_password" tabindex="1">
              </div>

              <div class="form-group">
                <label for="password">Password <code>*</code></label>
                <input id="password" type="password" class="form-control" name="password" tabindex="2">
              </div>

              <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password <code>*</code></label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"
                  tabindex="3">
              </div>

              <div class="form-group mb-0 text-right">
                <button type="submit" class="btn btn-primary">
                  Ganti Password
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
