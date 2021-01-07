@extends('layouts.app')

@section('content')
  <div class="section-body">
    <div class="row">
      <div class="col-lg-8 p-2">
        <div class="card mb-0">
          <div class="card-body">
            <ul class="nav nav-pills">
              @php $filter = request()->input('filter') ?? null @endphp
              <li class="nav-item">
                <a class="nav-link {{ !$filter ? 'active' : '' }}" href="{{ route('home') }}">All Threads</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ $filter === 'my' ? 'active' : '' }}"
                  href="{{ route('home', ['filter' => 'my', 'category' => request()->input('category')]) }}">My
                  Threads</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ $filter === 'unanswered' ? 'active' : '' }}"
                  href="{{ route('home', ['filter' => 'unanswered', 'category' => request()->input('category')]) }}">Unanswered</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ $filter === 'solved' ? 'active' : '' }}"
                  href="{{ route('home', ['filter' => 'solved', 'category' => request()->input('category')]) }}">Solved</a>
              </li>
            </ul>
          </div>
        </div>

        <div class="mt-3">
          @include('partials.alerts')
        </div>

        <div class="card mt-4">
          <div class="card-header border-bottom">
            <h4>{{ $title }}</h4>
            <div class="card-header-action">
              <span>{{ $threads->total() }} Results</span>
            </div>
          </div>
          <div class="card-body">
            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
              @foreach ($threads as $thread)
                <li class="media">
                  <img alt="image" class="mr-3 rounded-circle" width="70" src="{{ Storage::url($thread->user->avatar) }}">
                  <div class="media-body">
                    <div class="media-right">
                      <a href="{{ route('home', ['filter' => request()->input('filter'), 'category' => $thread->category->slug]) }}"
                        class="category">{{ $thread->category->name }}</a>
                      @if ($thread->is_solved)
                        <span class="solved">Solved</span>
                      @endif
                    </div>
                    <div class="media-title mb-1">{{ '@' . $thread->user->username }}</div>
                    <div class="text-time">{{ $thread->created_at->diffForHumans() }}</div>
                    <div class="media-description ">
                      <a class="text-muted" style="font-size: 1rem"
                        href="{{ route('threads.show', [$thread->id, $thread->slug]) }}">{{ $thread->title }}</a>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                      <div class="media-links mt-0">
                        <a href="{{ route('threads.show', [$thread->id, $thread->slug]) }}">Show</a>
                        @can('update', $thread)
                          <div class="bullet"></div>
                          <a href="{{ route('threads.edit', $thread->id) }}">Edit</a>
                        @endcan
                        @can('delete', $thread)
                          <div class="bullet"></div>
                          <a href="javascript:;" data-url="{{ route('threads.destroy', $thread->id) }}"
                            class="text-danger btn-delete-thread">Delete</a>
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
                          <span>{{ $thread->threadLikes->count() }}</span></a>
                      </div>
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="card-footer">
            {{ $threads->appends(request()->all())->links() }}
          </div>
        </div>
      </div>

      <div class="col-lg-4 p-2">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Kategori</h4>
              </div>
              <div class="card-body pt-0">
                <div class="list-group">
                  @foreach (\App\Category::all() as $category)
                    <a href="{{ route('home', ['filter' => request()->input('filter'), 'category' => $category->slug]) }}"
                      class="list-group-item list-group-item-action {{ request()->input('category') === $category->slug ? 'active' : '' }}">
                      <div class="d-flex justify-content-between">
                        <p class="m-0">{{ $category->name }}</p>
                        <span
                          class="badge badge-{{ request()->input('category') === $category->slug ? 'light' : 'primary' }}">{{ $category->threads->count() }}</span>
                      </div>
                    </a>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <form action="" method="POST" hidden id="form-delete-thread">@csrf @method('DELETE')</form>
  <form action="" method="POST" hidden id="form-like-thread">@csrf @method('PUT')
  </form>
@endsection


@push('javascript')
  <script>
    $('.btn-delete-thread').click(function() {
      $('#form-delete-thread').prop('action', $(this).data('url'));
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#form-delete-thread').submit();
        }
      })
    });

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

  </script>
@endpush
