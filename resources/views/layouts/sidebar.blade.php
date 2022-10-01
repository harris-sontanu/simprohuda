<!-- Main sidebar -->
<div id="sidebar-main" class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-section sidebar-user my-1">
            <div class="sidebar-section-body">
                <div class="media">
                    <a href="#" class="mr-3">
                        <img src="{{ Auth::user()->userPictureUrl(Auth::user()->picture, Auth::user()->name) }}"" class="rounded-circle" alt="{{ Auth::user()->name }}">
                    </a>

                    <div class="media-body">
                        <div class="font-weight-semibold">{{ Auth::user()->name }}</div>
                        <div class="font-size-sm line-height-sm opacity-50">
                            {{ Str::ucfirst(Auth::user()->role) }}
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                            <i class="icon-transmission"></i>
                        </button>

                        <button type="button" class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                            <i class="icon-cross2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>
                            Dasbor
                        </span>
                    </a>
                </li>

                <li class="nav-item nav-item-submenu nav-item-expanded nav-item-open">
                    <a href="#" class="nav-link"><i class="icon-stack2"></i> <span>Produk Hukum</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Produk Hukum">
                        <li class="nav-item"><a href="{{ route('legislation.ranperda.index') }}" class="nav-link {{ (request()->is('legislation/ranperda*')) ? 'active' : '' }}">Ranperda</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Ranperbup</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Rancangan SK</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu {{ request()->is('institute*') ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="icon-office"></i> <span>Perangkat Daerah</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Perangkat Daerah">
                        <li class="nav-item"><a href="{{ route('institute.create') }}" class="nav-link {{ (request()->is('institute/create')) ? 'active' : '' }}">Tambah</a></li>
                        <li class="nav-item"><a href="{{ route('institute.index') }}" class="nav-link {{ (request()->is('institute')) ? 'active' : '' }}">Daftar Perangkat Daerah</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu {{ request()->is('user*') ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="icon-users"></i> <span>Operator</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Operator">
                        <li class="nav-item"><a href="{{ route('user.create') }}" class="nav-link {{ (request()->is('user/create')) ? 'active' : '' }}">Tambah</a></li>
                        <li class="nav-item"><a href="{{ route('user.index') }}" class="nav-link {{ (request()->is('user')) ? 'active' : '' }}">Daftar Operator</a></li>
                        <li class="nav-item"><a href="{{ route('user.edit', Auth::user()->id) }}" class="nav-link">Profilku</a></li>
                    </ul>
                </li>

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-cog"></i> <span>Pengaturan</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Page layouts">
                        <li class="nav-item"><a href="#" class="nav-link">Aplikasi</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="icon-book3"></i>
                        <span>
                            Panduan
                        </span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
