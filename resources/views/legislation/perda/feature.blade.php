<div class="header-elements">
    <div class="d-flex justify-content-center">
        <button type="button" id="filter" class="btn btn-light btn-sm mr-2"><i class="icon-equalizer mr-2"></i>Filter</button>
        <div id="bulk-actions" class="btn-group mr-2" style="display: none">
            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"><span id="count-selected" class="badge badge-pill badge-pink mr-2">0</span>Aksi</button>
            <div class="dropdown-menu dropdown-menu-right">
                @if (Request::get('tab') == 'trash')
                    <a href="#" class="dropdown-item trigger" data-action="delete">Hapus</a>
                @else
                    <a href="#" class="dropdown-item trigger" data-action="trash">Buang</a>
                @endif
            </div>
        </div>
        <a href="{{ route('legislation.perda.create') }}" class="btn btn-secondary btn-sm"><i class="icon-plus22 mr-2"></i>Ajukan Rancangan</a>
    </div>
</div>
