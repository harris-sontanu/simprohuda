<div class="modal-header">
    <h5 class="modal-title">Unggah Dokumen {{ $requirement->title }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<form id="store-document-form" action="{{ route('legislation.document.store') }}" method="post" enctype="multipart/form-data" novalidate>
    @csrf
    <input type="hidden" name="legislation_id" value="{{ $legislationId }}">
    <input type="hidden" name="requirement_id" value="{{ $requirement->id }}">
    <input type="hidden" name="post">
    <div class="modal-body">
        <div class="mb-0">
            <label for="document" class="form-label">Dokumen</label>
            <input id="document" type="file" class="form-control" name="{{ $requirement->term }}">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-indigo">Unggah</button>
    </div>
</form>