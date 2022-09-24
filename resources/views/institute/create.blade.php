<div class="card">
    <div class="card-header">
        <h5 class="card-title font-weight-bold">Tambah Perangkat Daerah</h5>
    </div>
    <div class="card-body">

        <form action="{{ route('institute.store') }}" method="post" novalidate>
            @csrf
            <div class="form-group">
                <label for="name" class="font-weight-semibold">Nama:</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="abbrev" class="font-weight-semibold">Singkatan:</label>
                <input id="abbrev" type="text" class="form-control @error('abbrev') is-invalid @enderror" name="abbrev" value="{{ old('abbrev') }}">
                @error('abbrev')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="category" class="font-weight-semibold">Jenis:</label>
                <select name="category" id="category" class="select @error('category') is-invalid @enderror">
                    <option value="">Pilih Jenis</option>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}" @selected(old('category') == $key)>{{ $value }}</option>
                    @endforeach
                </select>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="code" class="font-weight-semibold">Kode:</label>
                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}">
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="desc" class="font-weight-semibold">Deskripsi:</label>
                <textarea id="desc" rows="4" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ old('desc') }}</textarea>
                @error('desc')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="operator_id" class="font-weight-semibold">Jenis:</label>
                <select name="operator_id" id="operator_id" class="select @error('operator_id') is-invalid @enderror">
                    <option value="">Pilih Operator</option>
                    @foreach ($operators as $key => $value)
                        <option value="{{ $key }}" @selected(old('category') == $key)>{{ $value }}</option>
                    @endforeach
                </select>
                @error('operator_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-secondary">Simpan<i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>

    </div>
</div>