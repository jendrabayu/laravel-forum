@extends('layouts.app')

@section('title', 'Buat Thread Baru')

@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="section-header">
        <h1>Buat Thread Baru</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('home') }}">Home</a></div>
          <div class="breadcrumb-item">Buat Thread Baru</div>
        </div>
      </div>

      <div class="section-body">
        @include('partials.alerts')
        <div class="card">
          <div class="card-body">
            <form action="{{ route('threads.store') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="title">Judul <code>*</code> </label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}"
                  placeholder="Masukkan judul pertanyaan Anda">
              </div>
              <div class="form-group">
                <label for="category">Kategori <code>*</code></label>
                <select name="category_id" id="category" class="form-control">
                  <option disabled selected>--Pilih Kategori--</option>
                  @foreach ($categories as $id => $name)
                    <option {{ old('category_id') === $id ? 'selected' : '' }} value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="body">Pertanyaan <code>*</code></label>
                <textarea name="body" id="body">{{ old('body') }}</textarea>
              </div>
              <div class="form-group text-right mb-0">
                <button type="submit" class="btn btn-primary">
                  Posting Pertanyaan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('javascript')
  <script>
    $(function() {
      $('#body').summernote({
        height: 200,
        placeholder: 'Tulis pertanyaan Anda disini..',
        dialogsInBody: true,
        dialogsFade: true,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline']],
          ['fontsize', ['fontsize']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol']],
          ['insert', ['link', 'picture']],
        ]
      });
    });

  </script>
@endpush
