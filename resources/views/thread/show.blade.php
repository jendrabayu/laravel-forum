@extends('layouts.app')

@section('title', $thread->title)


  @push('stylesheet')
    <style>
      .media .media-body .media-title {
        font-size: 1.2rem;
        font-weight: 600
      }

      .answer-container .media-body h5 {
        color: rgb(65, 65, 65);
        margin-bottom: 10px;
      }

    </style>
  @endpush

@section('content')
  <section class="section">

    <div class="section-header">
      <h1>Detail</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('home') }}">Home</a></div>
        <div class="breadcrumb-item">Detail</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-md-12">
          @include('partials.alerts')
          <div class="card">
            <div class="card-body">
              <!-- Main Thread -->
              <div class="media">
                <img alt="image" class="mr-3 rounded-circle" width="70" src="{{ Storage::url($thread->user->avatar) }}">
                <div class="media-body">
                  <div class="media-right">
                    <a href="{{ route('home', ['filter' => request()->input('filter'), 'category' => $thread->category->slug]) }}"
                      class="category">{{ $thread->category->name }}</a>
                    @if ($thread->is_solved)
                      <span class="solved">Solved</span>
                    @endif
                  </div>
                  <div class="media-title mb-1">{{ $thread->title }}</div>
                  <div class="media-description text-muted">
                    Ditanyakan oleh <a class="mx-1" href="javascript:;"> {{ $thread->user->full_name }} </a>
                    pada {{ $thread->created_at->isoFormat('D MMMM Y') }}
                  </div>
                  <div class="media-content mt-3">
                    {!! $thread->body !!}
                  </div>
                  <div class="d-flex justify-content-between align-items-center mt-2">
                    <div class="media-links mt-0">
                      @can('update', $thread)
                        @if ($thread->is_solved)
                          <a class="text-warning btn-solved-thread" href="#"><i class="fas fa-times"></i> Buka Kembali</a>
                          <div class="bullet"></div>
                        @else
                          <a class="text-success btn-solved-thread" href="#"><i class="fas fa-check"></i> Tandai Selesai</a>
                          <div class="bullet"></div>
                        @endif
                        <a class="text-info" href="{{ route('threads.edit', $thread->id) }}"><i
                            class="fas fa-pencil-alt"></i> Edit</a>
                        <div class="bullet"></div>
                      @endcan
                      @can('delete', $thread)
                        <a class="text-danger" href="#" id="btn-delete-thread"><i class="far fa-trash-alt"></i> Hapus</a>
                      @endcan
                    </div>
                    <div class="media-stats">
                      @php
                      $commentsCount = $thread->answers->count();
                      foreach ($thread->answers as $answer) {
                      $commentsCount += $answer->answerComments->count();
                      }


                      $userLike = (auth()->check() && $thread->threadLikes->firstWhere('user_id', auth()->id()))
                      ? true : false;
                      @endphp
                      <a href="javascript:;" class="mr-1"><i class="far fa-comment"></i>
                        <span>{{ $commentsCount }}</span></a>
                      <a class="btn-like" data-like="{{ $userLike ? '0' : '1' }}"
                        data-url="{{ route('threads.like', $thread->id) }}" href="javascript:;"><i
                          class=" {{ $userLike ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                        <span>{{ $thread->threadLikes->count() }}</span> Suka</a>
                    </div>
                  </div>
                  @if (!$thread->is_solved)
                    <div class="answer-container w-100 mt-3">
                      <div class="media">
                        <img class="mr-3 rounded-circle" width="50" src="{{ asset('img/avatar.png') }}"
                          alt="Generic placeholder image">
                        <div class="media-body">
                          <h5>Berikan Jawaban</h5>
                          <form action="{{ route('answers.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                            <div class="form-group">
                              <textarea name="body" id="answer-body"></textarea>
                            </div>
                            <div class="form-group text-right mb-0">
                              <button type="submit" class="btn btn-primary">Reply</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
              <!-- End Main Thread -->
            </div>
          </div>

          <div class="card">

            <div class="card-header">
              <h4>{{ $thread->answers->count() }} Answers</h4>
            </div>

            <div class="card-body">
              @foreach ($thread->answers as $answer)
                <div class="media mb-3 pb-3 answer-container">
                  <img class="mr-3 avatar" src="{{ Storage::url($answer->user->avatar) }}"
                    alt="{{ $answer->user->full_name }}">
                  <div class="media-body">
                    <div class="title">
                      <span>{{ $answer->user->full_name }}</span>
                      @if (auth()->check() && auth()->id() === $answer->user->id)
                        <span class="text-secondary">(You)</span>
                      @endif
                      <span class="bullet"></span>
                      <span>{{ $answer->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="answer-action">
                      <div class="media-links mt-0">
                        @can('update', $answer)
                          <a href="{{ route('answers.edit', $answer->id) }}">Edit</a>
                        @endcan
                        @can('delete', $answer)
                          <div class="bullet"></div>
                          <a href="#" class="text-danger btn-delete-answer"
                            data-url="{{ route('answers.destroy', $answer->id) }}">Hapus</a>
                        @endcan
                      </div>
                      <div class="answer-like">
                        @php
                        $userAnswerLike = (auth()->check() && $answer->answerLikes->firstWhere('user_id', auth()->id()))
                        ? true : false;
                        @endphp
                        <a class="btn-answer-like" data-like="{{ $userAnswerLike ? '0' : '1' }}"
                          data-url="{{ route('answers.like', $answer->id) }}" href="javascript:;"><i
                            class=" {{ $userAnswerLike ? 'fas fa-heart text-danger' : 'far fa-heart' }}"></i>
                          <span>{{ $answer->answerLikes->count() }}</span> Likes</a>
                      </div>
                    </div>
                    <div class="content">
                      {!! $answer->body !!}
                    </div>

                    @foreach ($answer->answerComments as $comment)
                      <div class="media mt-3 comment-container">
                        <a class="pr-3" href="#">
                          <img class="avatar" src="{{ Storage::url($comment->user->avatar) }}"
                            alt="Generic placeholder image">
                        </a>
                        <div class="media-body">
                          <p class="mb-0">{{ $comment->user->full_name }}
                            @if (auth()->check() && auth()->id() === $comment->user->id)
                              <span class="text-secondary">(You)</span>
                            @endif
                            <span class="bullet"></span>
                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                          </p>
                          <div id="comment-{{ $comment->id }}" class="mb-0">{{ $comment->body }}
                          </div>
                          <div class="media-links mt-0">
                            @can('update', $comment)
                              <a href="#" class="btn-edit-comment" data-id="{{ $comment->id }}"
                                data-url="{{ route('answer_comments.update', $comment->id) }}">Edit</a>
                            @endcan
                            @can('delete', $comment)
                              <div class="bullet"></div>
                              <a href="#" class="text-danger btn-delete-comment"
                                data-url="{{ route('answer_comments.destroy', $comment->id) }}">Hapus</a>
                            @endcan
                          </div>
                        </div>
                      </div>
                    @endforeach

                    @if (!$thread->is_solved)
                      <div class="media mt-3">
                        <a class="pr-3" href="#">
                          <img class="avatar" src="{{ asset('img/avatar.png') }}" alt="Generic placeholder image">
                        </a>
                        <div class="media-body">
                          <form action="{{ route('answer_comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="answer_id" value="{{ $answer->id }}">
                            <div class="form-group mb-0">
                              <textarea name="body" class="form-control h-100" rows="3"></textarea>
                              <button type="submit" class="btn btn-primary mt-2">Reply</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- Hidden Form -->
  <form hidden action="{{ route('threads.destroy', $thread->id) }}" method="POST" id="form-delete-thread">
    @csrf @method('DELETE')
  </form>
  <form hidden action="{{ route('answers.destroy', $thread->id) }}" method="POST" id="form-delete-answer">
    @csrf @method('DELETE')
  </form>
  <form hidden action="{{ route('threads.solved', $thread->id) }}" method="POST" id="form-solved-thread">
    @csrf @method('PUT')
    <input type="hidden" name="is_solved" value="{{ $thread->is_solved ? 0 : 1 }}">
  </form>
  <form hidden method="POST" id="form-delete-comment">
    @csrf @method('DELETE')
  </form>
  <!-- End hidden Form -->
@endsection


@push('javascript')
  <script>
    //Thread delete
    $('#btn-delete-thread').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Hapus Thread ?',
        text: 'Thread yang dihapus tidak bisa dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#fc544b',
        cancelButtonColor: '#cdd3d8',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form-delete-thread').submit();
        }
      })
    });

    //Thread solved or unsolved
    $('.btn-solved-thread').click(function(e) {
      e.preventDefault();
      $('#form-solved-thread').submit();
    });

    //Answer comment edit modal dan form
    $('.btn-edit-comment').on('click', function(e) {
      e.preventDefault();
      $('#modal-edit-comment #form-edit-comment').prop('action', $(this).data('url'));
      $('#modal-edit-comment #form-edit-comment textarea[name=body]').val($('#comment-' + ($(this).data('id')))
        .text());
      $('#modal-edit-comment').modal('show');
    });

    //Answer comment delete
    $('.btn-delete-comment').click(function(e) {
      e.preventDefault();
      $('#form-delete-comment').prop('action', $(this).data('url'))
      $('#form-delete-comment').submit();
    });

    //Init summernote answer textarea
    if (($('#answer-body').length) > 0) {
      $('#answer-body').summernote({
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
    }

    //Delete answer
    $('.btn-delete-answer').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Hapus Jawaban ?',
        text: 'Jawaban yang dihapus tidak bisa dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#fc544b',
        cancelButtonColor: '#cdd3d8',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form-delete-answer').prop('action', $(this).data('url'))
          $('#form-delete-answer').submit();
        }
      })
    });



    //Ajax for like or unlike thread
    $('.btn-like').click(function() {
      Swal.fire({
        title: 'Tunggu Sebentar...',
        backdrop: true,
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: function() {
          Swal.showLoading()
        }
      });

      const url = $(this).data('url');
      const like = $(this).data('like');
      axios.put(url, {
        'is_like': like == 1 ? true : false
      }).then(res => {
        $(this).children('span').text(res.data.likes_count);
        $(this).children('i').prop('class', res.data.is_like ? 'fas fa-heart text-danger' : 'far fa-heart');
        $(this).data('like', res.data.is_like ? '0' : '1')
        Swal.close()
      }).catch(err => {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: err.response && err.response.status === 401 ? 'Anda harus login' : err,
          showConfirmButton: false,
          timer: 1000
        })
      })
    });

    //Ajax for like or unlike answer
    $('.btn-answer-like').click(function() {
      Swal.fire({
        title: 'Tunggu Sebentar...',
        backdrop: true,
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: function() {
          Swal.showLoading()
        }
      });

      const url = $(this).data('url');
      const like = $(this).data('like');
      axios.put(url, {
        'is_like': like == 1 ? true : false
      }).then(res => {
        $(this).children('span').text(res.data.likes_count);
        $(this).children('i').prop('class', res.data.is_like ? 'fas fa-heart text-danger' : 'far fa-heart');
        $(this).data('like', res.data.is_like ? '0' : '1')
        Swal.close()
      }).catch(err => {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: err.response && err.response.status === 401 ? 'Anda harus login' : err,
          showConfirmButton: false,
          timer: 1000
        })
      })
    });

  </script>
@endpush



@section('modal')
  <div class="modal fade" id="modal-edit-comment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Komentar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" id="form-edit-comment" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <textarea style="height: 200px" name="body" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group text-right mb-0">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
