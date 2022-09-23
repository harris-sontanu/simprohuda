<!-- Modal -->
<div class="modal fade" id="new-password-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.user.set-new-password', $user->id) }}" method="post" autocomplete="off">
                @method('PUT')
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="exampleModalLabel">Ganti Kata Sandi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password_current">Kata Sandi saat ini</label>
                        <input type="password" name="password_current" id="password_current" class="form-control @error('password_current') is-invalid @enderror">
                        @error('password_current')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password">Kata Sandi baru</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi kata Sandi baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                    <button id="update-new-password" type="button" class="btn btn-secondary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
