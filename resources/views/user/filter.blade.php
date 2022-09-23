<hr class="border-dashed m-0" />

<div class="card-body bg-light">
    <form action="{{ route('user.index') }}" id="filter-form" class="filter-form" method="GET">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Nama" value="{{ Request::get('name') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{ Request::get('email') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select name="role" id="role" class="custom-select">
                        <option value="">Pilih Level</option>
                        @foreach ($roles as $key => $value)
                            <option value="{{ $key }}" @selected(Request::get('role') == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Telepon" name="phone" value="{{ Request::get('phone') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Website" name="www" value="{{ Request::get('www') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Biografi" name="bio" value="{{ Request::get('bio') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input type="text" class="form-control daterange-single" name="last_logged_in_at" value="{{ Request::get('last_logged_in_at') }}" placeholder="Login Terakhir">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input type="text" class="form-control daterange-single" name="created_at" value="{{ Request::get('created_at') }}" placeholder="Terdaftar">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <button type="submit" name="filter" value="true" class="btn btn-secondary mr-2"><i class="icon-search4 mr-2 font-size-base"></i>Cari</button>
                    <button type="button" class="btn btn-light reset">Reset</button>
                </div>
            </div>
        </div>
    </form>
</div>
