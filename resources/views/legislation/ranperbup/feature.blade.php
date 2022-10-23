<div class="ms-sm-auto my-sm-auto">
    <div class="d-flex justify-content-center">
        <button type="button" id="filter" class="btn btn-light me-2"><i class="ph-faders-horizontal me-2"></i>Filter</button>
        <div id="bulk-actions" class="btn-group me-2" style="display: none">
            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"><span id="count-selected" class="badge bg-yellow rounded-pill me-2 text-black">0</span>Aksi</button>
            <div class="dropdown-menu dropdown-menu-end">
                @if (Request::get('tab') == 'batal')
                    <a href="#" class="dropdown-item trigger" data-action="delete">Hapus</a>
                @else
                    <a href="#" class="dropdown-item trigger" data-action="trash">Batalkan</a>
                @endif
            </div>
        </div>
        <a href="{{ route('legislation.ranperbup.create') }}" class="btn btn-indigo"><i class="ph-plus me-2"></i>Ajukan Ranperbup</a>
    </div>
</div>
