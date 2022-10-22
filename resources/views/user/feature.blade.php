<div class="ms-sm-auto my-sm-auto">
    <div class="d-flex justify-content-center">
        <button type="button" id="filter" class="btn btn-light me-2"><i class="ph-faders-horizontal me-2"></i>Filter</button>
        <div id="bulk-actions" class="btn-group me-2" style="display: none">
            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"><span id="count-selected" class="badge bg-yellow rounded-pill me-2 text-black">0</span>Aksi</button>
            <div class="dropdown-menu dropdown-menu-end">
                @if (Request::get('tab') != 'trash')
                    <div class="dropdown-submenu dropdown-submenu-start">
                        <a href="#" class="dropdown-item">Status</a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item trigger" data-action="status" data-val="active">Aktif</a>
                            <a href="#" class="dropdown-item trigger" data-action="status" data-val="pending">Tinjau</a>
                        </div>
                    </div>
                    <div class="dropdown-submenu dropdown-submenu-start">
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
        @can('isAdmin')
            <a href="{{ route('user.create') }}" class="btn btn-indigo"><i class="ph-user-plus me-2"></i>Tambah</a>
        @endcan
    </div>
</div>
