<!-- Main sidebar -->
<div id="sidebar-main" class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <a href="#" class="sidebar-resize-hide me-3">
                    <img src="{{ Auth::user()->userPictureUrl(Auth::user()->picture, Auth::user()->name) }}"" class="rounded-circle" alt="{{ Auth::user()->name }}" width="40" height="40">
                </a>

                <div class="sidebar-resize-hide flex-fill">
                    <div class="fw-semibold">{{ Auth::user()->name }}</div>
                    <div class="fs-sm line-height-sm opacity-50">
                        {{ Str::ucfirst(Auth::user()->role) }}
                    </div>
                </div>

                <div>
                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button" class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="ph-house"></i>
                        <span>
                            Dasbor
                        </span>
                    </a>
                </li>

                <li class="nav-item nav-item-submenu nav-item-expanded nav-item-open">
                    <a href="#" class="nav-link"><i class="ph-stack"></i> <span>Produk Hukum</span></a>

                    <ul class="nav-group-sub collapse show">
                        <li class="nav-item"><a href="{{ route('legislation.ranperda.index') }}" class="nav-link {{ (request()->is('legislation/ranperda*')) ? 'active' : '' }}">Ranperda</a></li>
                        <li class="nav-item"><a href="{{ route('legislation.ranperbup.index') }}" class="nav-link {{ (request()->is('legislation/ranperbup*')) ? 'active' : '' }}">Ranperbup</a></li>
                        <li class="nav-item"><a href="{{ route('legislation.ransk.index') }}" class="nav-link {{ (request()->is('legislation/ransk*')) ? 'active' : '' }}">Rancangan SK</a></li>
                    </ul>
                </li>

                @cannot('isOpd')                    
                    <li class="nav-item nav-item-submenu {{ request()->is('institute*') ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link"><i class="ph-buildings"></i> <span>Perangkat Daerah</span></a>

                        <ul class="nav-group-sub {{ request()->is('institute*') ? 'show' : 'collapse' }}">
                            @can('isAdmin')                                
                                <li class="nav-item"><a href="{{ route('institute.create') }}" class="nav-link {{ (request()->is('institute/create')) ? 'active' : '' }}">Tambah</a></li>
                            @endcan
                            <li class="nav-item"><a href="{{ route('institute.index') }}" class="nav-link {{ (request()->is('institute')) ? 'active' : '' }}">Daftar Perangkat Daerah</a></li>
                        </ul>
                    </li>
                @endcannot

                <li class="nav-item nav-item-submenu {{ request()->is('user*') ? 'nav-item-expanded nav-item-open' : '' }}">
                    <a href="#" class="nav-link"><i class="ph-users"></i> <span>Operator</span></a>

                    <ul class="nav-group-sub {{ request()->is('user*') ? 'show' : 'collapse' }}">
                        @can('isAdmin')                                
                            <li class="nav-item"><a href="{{ route('user.create') }}" class="nav-link {{ (request()->is('user/create')) ? 'active' : '' }}">Tambah</a></li>
                        @endcan
                        @cannot('isOpd')                            
                            <li class="nav-item"><a href="{{ route('user.index') }}" class="nav-link {{ (request()->is('user')) ? 'active' : '' }}">Daftar Operator</a></li>
                        @endcannot
                        <li class="nav-item"><a href="{{ route('user.edit', Auth::user()->id) }}" class="nav-link">Profilku</a></li>
                    </ul>
                </li>
                
                @can('isAdmin')  
                    <li class="nav-item nav-item-submenu {{ request()->is('setting*') ? 'nav-item-expanded nav-item-open' : '' }}">
                        <a href="#" class="nav-link"><i class="ph-gear"></i> <span>Pengaturan</span></a>

                        <ul class="nav-group-sub {{ request()->is('setting*') ? 'show' : 'collapse' }}">
                            <li class="nav-item"><a href="{{ route('setting.app') }}" class="nav-link {{ (request()->is('setting')) ? 'active' : '' }}">Aplikasi</a></li>
                        </ul>
                    </li>
                @endcan

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="ph-book"></i>
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
