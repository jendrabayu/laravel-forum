@extends('layouts.app')

@section('title', 'Edit Jawaban')

@section('content')
  <div class="row">
    <div class="col-lg-10">
      <div class="section-header">
        <h1>Edit Jawaban</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="{{ route('home') }}">Home</a></div>
          <div class="breadcrumb-item">Edit Jawaban</div>
        </div>
      </div>

      <div class="section-body">
        @include('partials.alerts')
        <div class="card">
          <div class="card-body">
            <form action="{{ route('answers.update', $answer->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="body">Jawaban Kamu</label>
                <textarea name="body" id="body">{{ $answer->body }}</textarea>
              </div>

              <div class="form-group mb-0 text-right">
                <a href="{{ route('threads.show', [
                      'id' => $answer->thread->id,
                      'slug' => $answer->thread->slug,
                  ]) }}" class="btn btn-warning mr-1">
                  Kembali ke thread
                </a>
                <button type="submit" class="btn btn-primary">
                  Simpan perubahan
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
        placeholder: 'Tulis jawaban Anda disini..',
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
