<div class="modal fade" id="create-legislation-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <!-- Form -->
            <form method="POST" action="{{ route('legislation.perda.store') }}" novalidate>
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Pengajuan Rancangan Peraturan Daerah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label" for="phone">Perangkat Daerah:</label>
                        <select name="institute_id" id="institute_id" class="select @error('institute_id') is-invalid @enderror">
                            <option value="">Pilih Perangkat Daerah</option>
                            @foreach ($institutes as $key => $value)
                                <option value="{{ $key }}" @selected(old('institute_id') == $key)>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('institute_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="title">Judul:</label>
                        <textarea class="form-control @error('title') is-invalid @enderror" name="title" id="title" cols="30" rows="4" autofocus>{{ old('title') }}</textarea>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="background">Alasan Pengajuan:</label>
                        <textarea class="form-control @error('background') is-invalid @enderror" name="background" id="background" cols="30" rows="4" >{{ old('background') }}</textarea>
                        @error('background')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="draft" class="btn btn-light">Simpan ke Draf</button>
                    <button type="submit" name="post" class="btn btn-secondary">Simpan & Proses</button>
                </div>

            </form>

        </div>
    </div>
</div>