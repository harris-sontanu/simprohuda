<div class="card-body bg-light pb-0">
    <form action="{{ route('legislation.ranperda.index') }}" id="filter-form" class="filter-form" method="GET">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" placeholder="Judul" value="{{ Request::get('title') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="number" class="form-control" name="reg_number" placeholder="Nomor Registrasi" value="{{ Request::get('reg_number') }}">
                </div>
            </div>
            @if (!empty($institutes))                
                <div class="col-md-3">
                    <div class="mb-3">
                        <select name="institute" id="institute" class="select">
                            <option value="">Pilih Perangkat Daerah</option>
                            @foreach ($institutes as $key => $value)
                                <option value="{{ $key }}" @selected(Request::get('institute') == $key)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif   
            @cannot('isOpd')                
                <div class="col-md-3">
                    <div class="mb-3">
                        <select name="user" id="user" class="select">
                            <option value="">Pilih Pengusul</option>
                            @foreach ($users as $key => $value)
                                <option value="{{ $key }}" @selected(Request::get('user') == $key)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endcannot             
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="created_at" value="{{ Request::get('created_at') }}" placeholder="Tgl. Dibuat">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="posted_at" value="{{ Request::get('posted_at') }}" placeholder="Tgl. Diusulkan">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="revised_at" value="{{ Request::get('revised_at') }}" placeholder="Tgl. Revisi">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="validated_at" value="{{ Request::get('validated_at') }}" placeholder="Tgl. Valid">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <button type="submit" name="filter" value="true" class="btn btn-indigo"><i class="ph-magnifying-glass me-2"></i>Cari</button>
                </div>
            </div>
        </div>

    </form>
</div>
