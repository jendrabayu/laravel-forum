@extends('layouts.app')

@section('title', 'Edit Thread')

@section('content')
  <div class="row">
    <div class="col-lg-10">
      <div class="section-header">
        <h1>Edit Thread</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('home') }}">Home</a></div>
          <div class="breadcrumb-item">Edit Thread</div>
        </div>
      </div>

      <div class="section-body">
        @include('partials.alerts')
        <div class="card">
          <div class="card-body">
            <form action="{{ route('threads.update', $thread->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $thread->title }}">
              </div>

              <div class="form-group">
                <label for="category">Kategori</label>
                <select name="category_id" id="category" class="form-control">
                  @foreach ($categories as $id => $name)
                    <option {{ $thread->category_id === $id ? 'selected' : '' }} value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="body">Pertanyaan</label>
                <textarea name="body" id="body">{{ $thread->body }}</textarea>
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
