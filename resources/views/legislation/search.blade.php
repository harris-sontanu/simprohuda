<div class="dropdown-menu-scrollable-lg">

    @if (!empty($ranperda) AND count($ranperda) > 0)        
        <div class="dropdown-header">
            Ranperda
            @if (count($ranperda) > 3)
                <a href="{{ route('legislation.ranperda.index', ['search' => $term]) }}" class="float-end">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($ranperda as $legislation)            
            <a href="{{ route('legislation.ranperda.show', $legislation->id) }}" class="text-body dropdown-item">
                <div class="me-3">
                    <img src="{{ $legislation->userPictureUrl($legislation->user->picture, $legislation->user->name) }}" alt="{{ $legislation->user->name }}" class="w-32px h-32px rounded-pill">
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{{ $legislation->title }}</div>
                    <span class="fs-sm text-muted text-truncate">{{ $legislation->institute->name }}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if (!empty($ranperbup) AND count($ranperbup) > 0)   
        <div class="dropdown-divider"></div>

        <div class="dropdown-header">
            Ranperbup
            @if (count($ranperbup) > 3)
                <a href="{{ route('legislation.ranperbup.index', ['search' => $term]) }}" class="float-end">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($ranperbup as $legislation)            
            <a href="{{ route('legislation.ranperbup.show', $legislation->id) }}" class="dropdown-item text-body">
                <div class="me-3">
                    <img src="{{ $legislation->userPictureUrl($legislation->user->picture, $legislation->user->name) }}" alt="{{ $legislation->user->name }}" class="w-32px h-32px rounded-pill">
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{{ $legislation->title }}</div>
                    <span class="fs-sm text-muted text-truncate">{{ $legislation->institute->name }}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if (!empty($ransk) AND count($ransk) > 0)   
        <div class="dropdown-divider"></div>

        <div class="dropdown-header">
            Rancangan SK
            @if (count($ransk) > 3)
                <a href="{{ route('legislation.ransk.index', ['search' => $term]) }}" class="float-end">
                    Lihat semua
                    <i class="ph-arrow-circle-right ms-1"></i>
                </a>
            @endif
        </div>

        @foreach ($ransk as $legislation)            
            <a href="{{ route('legislation.ransk.show', $legislation->id) }}" class="text-body dropdown-item">
                <div class="me-3">
                    <img src="{{ $legislation->userPictureUrl($legislation->user->picture, $legislation->user->name) }}" alt="{{ $legislation->user->name }}" class="w-32px h-32px rounded-pill">
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold text-truncate">{{ $legislation->title }}</div>
                    <span class="fs-sm text-muted text-truncate">{{ $legislation->institute->name }}</span>
                </div>
            </a>
        @endforeach
    @endif

    @if (count($ranperda) == 0 AND count($ranperbup) == 0 AND count($ransk) == 0)
        <div class="dropdown-header">Data tidak ditemukan...</div>
    @endif

</div>