@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('layouts.message')

        <!-- Form -->
        <form id="post-form" method="POST" action="{{ route('user.store') }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">

                            <fieldset>
                                <legend class="font-weight-bold"><i class="icon-reading mr-2"></i> Personal</legend>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="name">Nama:</label>
                                    <div class="col-lg-9">
                                        <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="avatar">Foto:</label>
                                    <div class="col-lg-9">
                                        <div class="media mt-0">
                                            <div class="mr-3">
                                                <img id="avatar-img" src="/assets/images/placeholders/user.png" class="rounded-pill" width="60" height="60">
                                            </div>

                                            <div class="media-body">
                                                <div class="custom-file">
                                                    <input id="customFile" type="file" class="custom-file-input @error('picture') is-invalid @enderror" name="picture" accept=".jpg, .jpeg, .png, .gif">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    <span class="form-text text-muted">Format: gif, png, jpg. Ukuran maks: 2Mb.
                                                    @error('picture')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="phone">Telepon:</label>
                                    <div class="col-lg-9">
                                        <input id="phone" type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="www">Website:</label>
                                    <div class="col-lg-9">
                                        <input id="www" type="url" name="www" class="form-control @error('www') is-invalid @enderror" value="{{ old('www') }}">
                                        @error('www')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="bio">Biografi:</label>
                                    <div class="col-lg-9">
                                        <textarea class="form-control" name="bio" id="bio" cols="30" rows="4" placeholder="Ceritakan sedikit tentang diri Anda.">{{ old('bio') }}</textarea>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset>
                                <legend class="font-weight-bold"><i class="icon-user-lock mr-2"></i> Akun</legend>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="username">Nama Akun:</label>
                                    <div class="col-lg-9">
                                        <input id="username" type="email" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="email">Email:</label>
                                    <div class="col-lg-9">
                                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="password">Kata Sandi:</label>
                                    <div class="col-lg-9">
                                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="password_confirmation">Konfirmasi Kata Sandi:</label>
                                    <div class="col-lg-9">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="role">Level</label>
                                    <div class="col-lg-9">
                                        <select name="role" id="role" class="custom-select @error('role') is-invalid @enderror">
                                            @foreach ($roles as $key => $value)
                                                <option value="{{ $key }}" @selected(old('role') == $key)>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend class="font-weight-bold"><i class="icon-theater mr-2"></i> Akun Media Sosial</legend>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="facebook">Facebook:</label>
                                    <div class="col-lg-9">
                                        <input id="facebook" type="url" name="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ old('facebook') }}">
                                        @error('facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="twitter">Twitter:</label>
                                    <div class="col-lg-9">
                                        <input id="twitter" type="url" name="twitter" class="form-control @error('twitter') is-invalid @enderror" value="{{ old('twitter') }}">
                                        @error('twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="instagram">Instagram:</label>
                                    <div class="col-lg-9">
                                        <input id="instagram" type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram') }}">
                                        @error('instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="tiktok">TikTok:</label>
                                    <div class="col-lg-9">
                                        <input id="tiktok" type="url" name="tiktok" class="form-control @error('tiktok') is-invalid @enderror" value="{{ old('tiktok') }}">
                                        @error('tiktok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label font-weight-semibold" for="youtube">YouTube:</label>
                                    <div class="col-lg-9">
                                        <input id="youtube" type="url" name="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ old('youtube') }}">
                                        @error('youtube')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                            </fieldset>

                            <div class="form-group row mb-0">
                                <div class="col-lg-9 offset-lg-3">
                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
    <!-- /content area -->

@endsection

@section('script')
    @include('user.script')
@endsection
