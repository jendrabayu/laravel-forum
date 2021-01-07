<li class="nav-item">
  <a href="{{ route('threads.create') }}" class="nav-link"><i class="fas fa-plus-circle"></i><span>Buat
      Thread</span></a>
</li>
<li class="nav-item dropdown">
  <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i
      class="far fa-question-circle"></i><span>Thread</span></a>
  <ul class="dropdown-menu">
    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Semua Thread</a>
    </li>
    <li class="nav-item"><a href="{{ route('home', ['filter' => 'my', 'category' => request()->input('category')]) }}"
        class="nav-link">Thread Saya</a></li>
    <li class="nav-item"><a
        href="{{ route('home', ['filter' => 'unanswered', 'category' => request()->input('category')]) }}"
        class="nav-link">Belum Dijawab</a></li>
    <li class="nav-item"><a
        href="{{ route('home', ['filter' => 'solved', 'category' => request()->input('category')]) }}"
        class="nav-link">Selesai</a></li>
  </ul>
</li>


@if (auth()->check() && auth()->user()->role === \App\User::ROLE_ADMIN)
  <li class="nav-item dropdown">
    <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-user-shield"></i><span>Admin
        Menu</span></a>
    <ul class="dropdown-menu">
      <li class="nav-item"><a href="{{ route('admin.users') }}" class="nav-link">Pengguna</a></li>
      <li class="nav-item"><a href="{{ route('admin.categories.index') }}" class="nav-link">Kategori</a></li>
    </ul>
  </li>
@endif
