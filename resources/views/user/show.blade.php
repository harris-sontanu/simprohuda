<div class="card-body text-center bg-secondary card-img-top text-white @if (Route::currentRouteName() == 'user.show') rounded-0 @endif" style="background-image: url(/assets/images/backgrounds/panel_bg.png); background-size: contain;">
    <div class="card-img-actions d-inline-block mb-3">
        <img class="img-fluid rounded-circle" src="{{ $user->userPictureUrl($user->picture, $user->name) }}" alt="{{ $user->name }}" width="170" height="170">
    </div>

    <h6 class="font-weight-bold mb-0">{{ $user->name }}</h6>
    <span class="d-block opacity-75">{{ Str::title($user->role) }}</span>

    <ul class="list-inline list-inline-condensed mt-3 mb-0">

        @if ( !empty($user->facebook))
            <li class="list-inline-item">
                <a href="{{ $user->facebook }}" class="btn btn-outline-white btn-icon border-2 rounded-pill">
                    <i class="icon-facebook"></i>
                </a>
            </li>
        @endif

        @if ( !empty($user->twitter))
            <li class="list-inline-item">
                <a href="{{ $user->twitter }}" class="btn btn-outline-white btn-icon border-2 rounded-pill">
                    <i class="icon-twitter"></i>
                </a>
            </li>
        @endif

        @if ( !empty($user->instagram))
            <li class="list-inline-item">
                <a href="{{ $user->instagram }}" class="btn btn-outline-white btn-icon border-2 rounded-pill">
                    <i class="icon-instagram"></i>
                </a>
            </li>
        @endif

        @if ( !empty($user->youtube))
            <li class="list-inline-item">
                <a href="{{ $user->youtube }}" class="btn btn-outline-white btn-icon border-2 rounded-pill">
                    <i class="icon-youtube"></i>
                </a>
            </li>
        @endif
    </ul>

</div>

<div class="card-body border-top-0">
    @if (!empty($user->bio))
        <h5 class="font-weight-bold text-center">Biografi</h5>
        <p>I'm a dude playing a dude disguised as another dude.</p>
    @endif

    <div class="d-sm-flex flex-sm-wrap mb-3">
        <div class="font-weight-semibold">Nama:</div>
        <div class="ml-sm-auto mt-2 mt-sm-0">{{ $user->name }}</div>
    </div>

    <div class="d-sm-flex flex-sm-wrap mb-3">
        <div class="font-weight-semibold">Email:</div>
        <div class="ml-sm-auto mt-2 mt-sm-0">{{ $user->email }}</div>
    </div>

    @if ($user->getRawOriginal('role') === 'opd')        
        <div class="d-sm-flex flex-sm-wrap mb-3">
            <div class="font-weight-semibold">Instansi:</div>
            @empty ($user->institutes->first()->name)
                <div class="ml-sm-auto mt-2 mt-sm-0">-</div>
            @else
                <div class="ml-sm-auto mt-2 mt-sm-0">{{ $user->institutes->first()->name }}</div>
            @endempty
        </div>        
    @endif

    <div class="d-sm-flex flex-sm-wrap mb-3">
        <div class="font-weight-semibold">Telepon:</div>
        <div class="ml-sm-auto mt-2 mt-sm-0">{{ $user->phone }}</div>
    </div>

    <div class="d-sm-flex flex-sm-wrap mb-3">
        <div class="font-weight-semibold">Website:</div>
        <div class="ml-sm-auto mt-2 mt-sm-0">{{ $user->www }}</div>
    </div>

    <div class="d-sm-flex flex-sm-wrap mb-3">
        <div class="font-weight-semibold">Status:</div>
        <div class="ml-sm-auto mt-2 mt-sm-0">{!! $user->statusBadgeHtml !!}</div>
    </div>

    <div class="d-sm-flex flex-sm-wrap mb-3">
        <div class="font-weight-semibold">Login Terakhir:</div>
        <div class="ml-sm-auto mt-2 mt-sm-0"><abbr data-popup="tooltip" title="{{ $user->dateFormatted($user->last_logged_in_at, true) }}">{{ $user->dateFormatted($user->last_logged_in_at) }}</abbr></div>
    </div>

    <div class="d-sm-flex flex-sm-wrap">
        <div class="font-weight-semibold">Terdaftar:</div>
        <div class="ml-sm-auto mt-2 mt-sm-0"><abbr data-popup="tooltip" title="{{ $user->dateFormatted($user->created_at, true) }}">{{ $user->dateFormatted($user->created_at) }}</abbr></div>
    </div>

</div>
