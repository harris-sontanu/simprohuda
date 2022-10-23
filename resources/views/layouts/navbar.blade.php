<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="/dashboard" class="d-inline-flex align-items-center">
                <img src="{{ asset('assets/images/logo_icon.svg') }}" alt="{{ config('app.name') }}">
                <h3 class="fw-bold m-0 ps-2 d-none d-sm-block font-title">
                    <span class="text-pink">{{ config('app.name') }}
                </h3>
            </a>
        </div>

        <ul class="nav flex-row">
            <li class="nav-item d-lg-none">
                <a href="#navbar_search" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="collapse">
                    <i class="ph-magnifying-glass"></i>
                </a>
            </li>

            <li class="nav-item">
                <label class="btn btn-flat-white btn-icon border-transparent rounded-pill" for="btncheck1">
                    <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
                    <i class="ph-moon"></i>
                </label>
            </li>
            
        </ul>

        <div class="navbar-collapse justify-content-center flex-lg-1 order-2 order-lg-1 collapse" id="navbar_search">
            <div class="navbar-search flex-fill position-relative mt-2 mt-lg-0 mx-lg-3">
                <div class="form-control-feedback form-control-feedback-start flex-grow-1" data-color-theme="dark">
                    <input type="text" class="form-control bg-transparent rounded-pill" placeholder="Cari Rancangan Produk Hukum" data-bs-toggle="dropdown">
                    <div class="form-control-feedback-icon">
                        <i class="ph-magnifying-glass"></i>
                    </div>
                </div>

                <a href="#" class="navbar-nav-link align-items-center justify-content-center w-40px h-32px rounded-pill position-absolute end-0 top-50 translate-middle-y p-0 me-1" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                    <i class="ph-faders-horizontal"></i>
                </a>

                <div class="dropdown-menu w-100 p-3">
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-0">Search options</h6>
                        <a href="#" class="text-body rounded-pill ms-auto">
                            <i class="ph-clock-counter-clockwise"></i>
                        </a>
                    </div>

                    <div class="mb-3">
                        <label class="d-block form-label">Category</label>
                        <label class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" checked>
                            <span class="form-check-label">Invoices</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input">
                            <span class="form-check-label">Files</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input">
                            <span class="form-check-label">Users</span>
                        </label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Addition</label>
                        <div class="input-group">
                            <select class="form-select w-auto flex-grow-0">
                                <option value="1" selected>has</option>
                                <option value="2">has not</option>
                            </select>
                            <input type="text" class="form-control" placeholder="Enter the word(s)">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <div class="input-group">
                            <select class="form-select w-auto flex-grow-0">
                                <option value="1" selected>is</option>
                                <option value="2">is not</option>
                            </select>
                            <select class="form-select">
                                <option value="1" selected>Active</option>
                                <option value="2">Inactive</option>
                                <option value="3">New</option>
                                <option value="4">Expired</option>
                                <option value="5">Pending</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex">
                        <button type="button" class="btn btn-light">Reset</button>

                        <div class="ms-auto">
                            <button type="button" class="btn btn-light">Cancel</button>
                            <button type="button" class="btn btn-primary ms-2">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav flex-row justify-content-end order-1 order-lg-2">

            @if ( ! empty($legislationNotifications) AND count($legislationNotifications) > 0)
                <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                    <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="ph-bell"></i>
                        <span class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">{{ $legislationNotifications->count() }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end wmin-lg-400 p-0">
                        <div class="d-flex align-items-center p-3">
                            <h6 class="mb-0">Tinjau Rancangan Produk Hukum</h6>
                        </div>

                        <div class="dropdown-menu-scrollable pb-2">

                            @foreach ($legislationNotifications as $legislation)
                                <a href="{{ route('legislation.' . $legislation->type->slug . '.edit', $legislation->id) }}" class="dropdown-item align-items-start text-wrap py-2">
                                    <div class="me-3">
                                        <img src="{{ $legislation->userPictureUrl($legislation->user->picture, $legislation->user->name) }}" alt="{{ $legislation->user->name }}" class="w-40px h-40px rounded-pill">
                                    </div>

                                    <div class="flex-1">
                                        @cannot('isOpd') 
                                            <span class="fw-semibold">{{ $legislation->institute->name }}</span>
                                        @endcannot
                                        <div>{{ Str::limit($legislation->title, 75); }}</div>
                                        <ul class="list-inline list-inline-bullet mt-1 fs-sm text-muted mb-0">
                                            <li class="list-inline-item">{{ $legislation->type->name }}</li>
                                            <li class="list-inline-item">{{ $legislation->timeDifference($legislation->posted_at) }}</li>
                                        </ul>
                                    </div>
                                </a>
                            @endforeach                            
                        </div>

                    </div>
                </li>
            @endif

            @if ( ! empty($commentNotifications) AND count($commentNotifications) > 0)
                <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                    <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="ph-chats"></i>
                        <span class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">{{ $commentNotifications->count() }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end wmin-lg-400 p-0">
                        <div class="d-flex align-items-center p-3">
                            <h6 class="mb-0">Pesan Masuk</h6>
                        </div>

                        <div class="dropdown-menu-scrollable pb-2">

                            @foreach ($commentNotifications as $comment)
                                <a href="{{ route('legislation.' . $comment->legislation->type->slug . '.edit', $comment->legislation_id) }}" class="dropdown-item align-items-start text-wrap py-2">
                                    <div class="me-3">
                                        <img src="{{ $comment->userPictureUrl($comment->sender->picture, $comment->sender->name) }}" alt="{{ $comment->sender->name }}" class="w-40px h-40px rounded-pill">
                                    </div>

                                    <div class="flex-1">
                                        <span class="fw-semibold">{{ $comment->sender->name }}</span>
                                        <div>{{ Str::limit($comment->comment, 75); }}</div>
                                        <ul class="list-inline list-inline-bullet mt-1 fs-sm text-muted mb-0">
                                            <li class="list-inline-item">{{ $comment->timeDifference($comment->created_at) }}</li>
                                        </ul>
                                    </div>
                                </a>
                            @endforeach                            
                        </div>

                    </div>
                </li>
            @endif

            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        <img src="{{ Auth::user()->userPictureUrl(Auth::user()->picture, Auth::user()->name) }}" class="w-32px h-32px rounded-pill" alt="Auth::user()->name">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">{{ Auth::user()->name }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('user.edit', Auth::user()->id) }}" class="dropdown-item">
                        <i class="ph-user-gear me-2"></i>
                        Profilku
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item"><i class="ph-sign-out me-2"></i>{{ __('Keluar') }}</a>
                    </form>
                </div>
            </li>
        </ul>

    </div>
</div>
<!-- /main navbar -->
