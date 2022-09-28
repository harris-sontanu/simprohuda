<hr class="border-dashed m-0" />

<div class="card-body bg-light">
    <form action="{{ route('legislation.perda.index') }}" id="filter-form" class="filter-form" method="GET">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" name="title" placeholder="Judul" value="{{ Request::get('title') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select name="institute" id="institute" class="select">
                        <option value="">Pilih Perangkat Daerah</option>
                        @foreach ($institutes as $key => $value)
                            <option value="{{ $key }}" @selected(Request::get('institute') == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input type="text" class="form-control daterange-single" name="created_at" value="{{ Request::get('created_at') }}" placeholder="Tgl. Dibuat">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input type="text" class="form-control daterange-single" name="posted_at" value="{{ Request::get('posted_at') }}" placeholder="Tgl. Diusulkan">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input type="text" class="form-control daterange-single" name="revised_at" value="{{ Request::get('revised_at') }}" placeholder="Tgl. Revisi">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input type="text" class="form-control daterange-single" name="validated_at" value="{{ Request::get('validated_at') }}" placeholder="Tgl. Valid">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <button type="submit" name="filter" value="true" class="btn btn-secondary mr-2"><i class="icon-search4 mr-2 font-size-base"></i>Cari</button>
                    <button type="button" class="btn btn-light reset">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>
