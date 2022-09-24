<!-- Main navbar -->
<div class="navbar navbar-expand-lg navbar-dark navbar-static">
    <div class="d-flex flex-1 d-lg-none">
        {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-paragraph-justify3"></i>
        </button> --}}
        <button type="button" class="navbar-toggler sidebar-mobile-main-toggle">
            <i class="icon-transmission"></i>
        </button>
        <button data-target="#navbar-search" type="button" class="navbar-toggler" data-toggle="collapse">
            <i class="icon-search4"></i>
        </button>
        <button type="button" class="navbar-toggler sidebar-mobile-component-toggle">
            <i class="icon-menu"></i>
        </button>
    </div>

    <div class="navbar-brand text-center text-lg-left p-0">
        <a href="/" class="d-inline-block navbar-text px-0 py-2 d-flex">
            <img style="margin-top: 8px" src="{{ asset('assets/images/logo_icon_light.png') }}" alt="Logo">
            <h3 class="font-title m-0 pl-2 d-none d-sm-block">
                <span class="text-pink">{{ config('app.name') }}
            </h3>
        </a>
    </div>

    <div class="collapse navbar-collapse order-2 order-lg-1" id="navbar-search">

        <div class="navbar-search d-flex align-items-center py-2 py-lg-0">
            <div class="form-group-feedback form-group-feedback-left flex-grow-1">
                <input type="text" class="form-control" placeholder="Cari Rancangan Produk Hukum...">
                <div class="form-control-feedback">
                    <i class="icon-search4"></i>
                </div>
            </div>
        </div>

    </div>

    <ul class="navbar-nav flex-row order-1 order-lg-2 flex-1 flex-lg-0 justify-content-end align-items-center">
        <li class="nav-item">
            <a href="#" class="navbar-nav-link navbar-nav-link-toggler">
                <i class="icon-bell2"></i>
                <span class="badge badge-warning badge-pill ml-auto ml-lg-0">2</span>
            </a>
        </li>

        <li class="nav-item nav-item-dropdown-lg dropdown dropdown-user h-100">
            <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle d-inline-flex align-items-center h-100" data-toggle="dropdown">
                <img src="{{ Auth::user()->userPictureUrl(Auth::user()->picture, Auth::user()->name) }}" class="rounded-pill mr-lg-2" height="34" alt="">
                <span class="d-none d-lg-inline-block">{{ Auth::user()->name }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('user.edit', Auth::user()->id) }}" class="dropdown-item"><i class="icon-user mr-2"></i>Profilku</a>
                <div class="dropdown-divider"></div>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item"><i class="icon-switch2 mr-2"></i>{{ __('Keluar') }}</a>
                </form>
            </div>
        </li>
    </ul>
</div>
<!-- /main navbar -->
