@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="section-header">
        <h1>Pengaturan Akun</h1>
      </div>

      <div class="section-body">
        @include('partials.alerts')
        <div class="card">
          <div class="card-body">
            <form action="{{ route('account.update_account') }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="row">
                <div class="col-md-5">
                  <div class="d-flex justify-content-center align-items-center flex-column">
                    <div id="avatar-preview">
                      <img src="{{ Storage::url($user->avatar) }}" alt="" width="100%">
                    </div>
                    <div class="mt-3">
                      <label for="input-avatar" class="text-primary" id="input-avatar-label">Change avatar image</label>
                      <input type="file" name="avatar" id="input-avatar" accept="image/*">
                    </div>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="form-group">
                    <label for="first_name">First Name <code>*</code></label>
                    <input id="first_name" type="text" class="form-control" name="first_name" tabindex="1" autofocus
                      value="{{ $user->first_name }}">
                  </div>
                  <div class="form-group">
                    <label for="last_name">Last Name <code>*</code></label>
                    <input id="last_name" type="text" class="form-control" name="last_name" tabindex="2"
                      value="{{ $user->last_name }}">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="email">Email <code>*</code></label>
                <input id="email" type="email" class="form-control" name="email" tabindex="3" value="{{ $user->email }}">
              </div>

              <div class="form-group">
                <label for="username">Username <code>*</code></label>
                <input id="username" type="username" class="form-control" name="username" tabindex="4"
                  value="{{ $user->username }}">
              </div>

              <div class="form-group mb-0 text-right">
                <button type="submit" class="btn btn-primary">
                  Simpan Perubahan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('stylesheet')
  <style>
    #input-avatar {
      width: 0.1px;
      height: 0.1px;
      opacity: 0;
      overflow: hidden;
      position: absolute;
      z-index: -1;
    }

    #input-avatar-label {
      cursor: pointer;
      text-decoration: underline
    }

    #avatar-preview {
      border-radius: 50% !important;
      width: 120px !important;
      overflow: hidden;
    }

  </style>
@endpush

@push('javascript')
  <script>
    $(function() {
      $('#input-avatar').on('change', function() {
        if (($(this)[0].files) && ($(this)[0].files[0])) {
          const reader = new FileReader();
          reader.onload = function(e) {
            $('#avatar-preview img').attr('src', e.target.result)
          }

          reader.readAsDataURL((($(this))[0]).files[0]);
        }
      });
    });

  </script>
@endpush
