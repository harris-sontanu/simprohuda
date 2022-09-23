<div class="header-elements">
    <div class="d-flex justify-content-center">
        <button type="button" id="filter" class="btn btn-light btn-sm mr-2"><i class="icon-equalizer mr-2"></i>Filter</button>
        <div id="bulk-actions" class="btn-group mr-2" style="display: none">
            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"><span id="count-selected" class="badge badge-pill badge-pink mr-2">0</span>Aksi</button>
            <div class="dropdown-menu dropdown-menu-right">
                @if (Request::get('tab') != 'trash')
                    <div class="dropdown-submenu dropdown-submenu-left">
                        <a href="#" class="dropdown-item">Status</a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item trigger" data-action="status" data-val="active">Active</a>
                            <a href="#" class="dropdown-item trigger" data-action="status" data-val="pending">Pending</a>
                        </div>
                    </div>
                    <div class="dropdown-submenu dropdown-submenu-left">
                        <a href="#" class="dropdown-item">Level</a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item trigger" data-action="role" data-val="opd">Perangkat Daerah</a>
                            <a href="#" class="dropdown-item trigger" data-action="role" data-val="bagianhukum">Bagian Hukum</a>
                            <a href="#" class="dropdown-item trigger" data-action="role" data-val="administrator">Administrator</a>
                        </div>
                    </div>
                @endif
                <div class="dropdown-divider"></div>
                @if (Request::get('tab') == 'trash')
                    <a href="#" class="dropdown-item trigger" data-action="delete">Hapus</a>
                @else
                    <a href="#" class="dropdown-item trigger" data-action="trash">Buang</a>
                @endif
            </div>
        </div>
        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#create-modal"><i class="icon-user-plus mr-2"></i>Tambah</button>
    </div>
</div>
