<form id="store-document-form" action="{{ route('legislation.document.update', $document->id) }}" method="post" enctype="multipart/form-data" novalidate>
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Perbaiki Dokumen {{ $document->requirement->title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-0">
            <label for="document" class="form-label">Unggah Perbaikan</label>
            <input id="document" type="file" class="form-control" name="{{ $document->requirement->term }}">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-indigo">Unggah</button>
    </div>
</form>