<form id="store-document-form" action="{{ route('legislation.document.store') }}" method="post" enctype="multipart/form-data" novalidate>
    @csrf
    <input type="hidden" name="legislation_id" value="{{ $legislationId }}">
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="order" value="{{ $order }}">
    <input type="hidden" name="title" value="{{ $title }}">
    <input type="hidden" name="post">
    <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Unggah Dokumen {{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group mb-0">
            <label class="font-weight-semibold">Dokumen</label>
            <div class="custom-file">
                <input id="document" type="file" class="custom-file-input" name="master">
                <label class="custom-file-label" for="document">Choose file</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-secondary">Unggah</button>
    </div>
</form>