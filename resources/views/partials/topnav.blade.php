<div class="container">
  <a href="{{ route('home') }}" class="navbar-brand sidebar-gone-hide">{{ config('app.name') }}</a>
  <div class="navbar-nav">
    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
  </div>
  <form action="{{ route('home') }}" method="GET" class="form-inline ml-auto">
    <ul class="navbar-nav">
      <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
    </ul>
    <div class="search-element">
      <input class="form-control" type="search" placeholder="Cari Thread" aria-label="Search" data-width="300"
        name="search">
      <button class="btn" type="submit"><i class="fas fa-search"></i></button>
    </div>
  </form>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown">
      @if (auth()->check())
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
          <img alt="image" src="{{ Storage::url(auth()->user()->avatar) }}" class="rounded-circle mr-1">
          <div class="d-sm-none d-lg-inline-block">{{ greeting_prepend(auth()->user()->full_name) }}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="{{ route('account.index') }}" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Pengaturan Akun
          </a>
          <a href="{{ route('account.password') }}" class="dropdown-item has-icon">
            <i class="fas fa-bolt"></i> Ganti Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Keluar
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>

      @else
    <li class="dropdown ml-3">
      <a href="{{ route('login') }}" class="btn btn-light">LOGIN</a>
    </li>
    @endif

    </li>
  </ul>
</div>
