<form id="store-document-form" action="{{ route('legislation.document.store') }}" method="post" enctype="multipart/form-data" novalidate>
    @csrf
    <input type="hidden" name="legislation_id" value="{{ $legislationId }}">
    <input type="hidden" name="requirement_id" value="{{ $requirement->id }}">
    <input type="hidden" name="post">
    <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Unggah Dokumen {{ $requirement->title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group mb-0">
            <label for="document">Dokumen</label>
            <div class="custom-file">
                <input id="document" type="file" class="custom-file-input" name="{{ $requirement->term }}">
                <label class="custom-file-label" for="document">Choose file</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-secondary">Unggah</button>
    </div>
</form>