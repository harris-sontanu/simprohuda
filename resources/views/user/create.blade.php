<!-- Modal -->
<div class="modal fade" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.user.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Tambah Operator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-semibold">Nama</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="username" class="font-weight-semibold">Nama Akun</label>
                        <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}">
                    </div>
                    <div class="form-group">
                        <label for="email" class="font-weight-semibold">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="password" class="font-weight-semibold">Kata Sandi</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="font-weight-semibold">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                    </div>
                    <div class="form-group mb-0">
                        <label for="role" class="font-weight-semibold">Level</label>
                        <select name="role" id="role" class="custom-select">
                            <option value="">Pilih Level</option>
                            @foreach ($roles as $key => $value)
                                <option value="{{ $key }}" @selected(old('role') == $key)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                    <button id="save-btn" type="button" class="btn btn-secondary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
