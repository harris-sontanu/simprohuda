<div class="dropdown-menu-scrollable-lg">

    @if (!empty($ranperda))        
        <div class="dropdown-header">
            Ranperda
            <a href="{{ route('legislation.ranperda.index', ['search' => $term]) }}" class="float-end">
                See all
                <i class="ph-arrow-circle-right ms-1"></i>
            </a>
        </div>

        @foreach ($ranperda as $legislation)            
            <div class="dropdown-item cursor-pointer">
                <div class="me-3">
                    <img src="{{ $legislation->userPictureUrl($legislation->user->picture, $legislation->user->name) }}" alt="{{ $legislation->user->name }}" class="w-32px h-32px rounded-pill">
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold">{{ $legislation->title }}</div>
                    <span class="fs-sm text-muted">{{ $legislation->institute->name }}</span>
                </div>

                <div class="d-inline-flex">
                    <a href="#" class="text-body ms-2">
                        <i class="ph-user-circle"></i>
                    </a>
                </div>
            </div>
        @endforeach
    @endif

    @if (!empty($ranperbup))   
        <div class="dropdown-divider"></div>

        <div class="dropdown-header">
            Ranperbup
            <a href="#" class="float-end">
                See all
                <i class="ph-arrow-circle-right ms-1"></i>
            </a>
        </div>

        @foreach ($ranperbup as $legislation)            
            <div class="dropdown-item cursor-pointer">
                <div class="me-3">
                    <img src="{{ $legislation->userPictureUrl($legislation->user->picture, $legislation->user->name) }}" alt="{{ $legislation->user->name }}" class="w-32px h-32px rounded-pill">
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold">{{ $legislation->title }}</div>
                    <span class="fs-sm text-muted">{{ $legislation->institute->name }}</span>
                </div>

                <div class="d-inline-flex">
                    <a href="#" class="text-body ms-2">
                        <i class="ph-user-circle"></i>
                    </a>
                </div>
            </div>
        @endforeach
    @endif

    @if (!empty($ransk))   
        <div class="dropdown-divider"></div>

        <div class="dropdown-header">
            Rancangan SK
            <a href="#" class="float-end">
                See all
                <i class="ph-arrow-circle-right ms-1"></i>
            </a>
        </div>

        @foreach ($ransk as $legislation)            
            <div class="dropdown-item cursor-pointer">
                <div class="me-3">
                    <img src="{{ $legislation->userPictureUrl($legislation->user->picture, $legislation->user->name) }}" alt="{{ $legislation->user->name }}" class="w-32px h-32px rounded-pill">
                </div>

                <div class="d-flex flex-column flex-grow-1 text-truncate">
                    <div class="fw-semibold">{{ $legislation->title }}</div>
                    <span class="fs-sm text-muted">{{ $legislation->institute->name }}</span>
                </div>

                <div class="d-inline-flex">
                    <a href="#" class="text-body ms-2">
                        <i class="ph-user-circle"></i>
                    </a>
                </div>
            </div>
        @endforeach
    @endif

</div>