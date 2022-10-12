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
        <li class="nav-item nav-item-dropdown-lg dropdown">
            <a href="#" class="navbar-nav-link navbar-nav-link-toggler" data-toggle="dropdown">
                <i class="icon-bell2"></i>
                <span class="badge badge-yellow badge-pill ml-auto ml-lg-0">{{ $legislationNotifications->count() }}</span>
            </a>

            @if ( ! empty($legislationNotifications) AND count($legislationNotifications) > 0)                
                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-350">
                    <div class="dropdown-content-header">
                        <span class="font-weight-semibold">Tinjau Rancangan Produk Hukum</span>
                        <a href="#" class="text-body"><i class="icon-bell2"></i></a>
                    </div>
                    
                    <div class="dropdown-content-body dropdown-scrollable">
                        <ul class="media-list">
                            @foreach ($legislationNotifications as $legislation)                                
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="{{ $legislation->userPictureUrl($legislation->user->picture, $legislation->user->name) }}" alt="{{ $legislation->user->name }}" width="36" height="36" class="rounded-circle" data-popup="tooltip" title="{{ $legislation->user->name }}">
                                    </div>

                                    <div class="media-body">
                                        @cannot('isOpd')                                            
                                            <div class="media-title">
                                                <span class="font-weight-semibold">{{ $legislation->institute->name }}</span>
                                            </div>
                                        @endcannot

                                        <a href="#" class="text-body">{{ Str::limit($legislation->title, 75); }}</a>
                                        <ul class="list-inline list-inline-condensed list-inline-dotted mt-1 font-size-sm text-muted">
                                            <li class="list-inline-item">{{ $legislation->type->name }}</li>
                                            <li class="list-inline-item">{{ $legislation->timeDifference($legislation->posted_at) }}</li>
                                        </ul>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    
                </div>
            @endif
        </li>

        <li class="nav-item nav-item-dropdown-lg dropdown">
            <a href="#" class="navbar-nav-link navbar-nav-link-toggler" data-toggle="dropdown">
                <i class="icon-bubbles4"></i>
                <span class="badge badge-yellow badge-pill ml-auto ml-lg-0">{{ $commentNotifications->count() }}</span>
            </a>

            @if ( ! empty($commentNotifications) AND count($commentNotifications) > 0)                
                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-350">
                    <div class="dropdown-content-header">
                        <span class="font-weight-semibold">Pesan Masuk</span>
                        <a href="#" class="text-body"><i class="icon-bubbles4"></i></a>
                    </div>
                    
                    <div class="dropdown-content-body dropdown-scrollable">
                        <ul class="media-list">
                            @foreach ($commentNotifications as $comment)                                
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <img src="{{ $comment->userPictureUrl($comment->sender->picture, $comment->sender->name) }}" alt="{{ $comment->sender->name }}" width="36" height="36" class="rounded-circle" data-popup="tooltip" title="{{ $comment->sender->name }}">
                                    </div>

                                    <div class="media-body">                                     
                                        <div class="media-title">
                                            <span class="font-weight-semibold">{{ $comment->sender->name }}</span>
                                        </div>

                                        <a href="#" class="text-body">{{ Str::limit($comment->comment, 75); }}</a>
                                        <ul class="list-inline list-inline-condensed list-inline-dotted mt-1 font-size-sm text-muted">
                                            <li class="list-inline-item">{{ $comment->timeDifference($comment->created_at) }}</li>
                                        </ul>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    
                </div>
            @endif
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
