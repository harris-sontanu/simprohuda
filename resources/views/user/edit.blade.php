@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('admin.layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('admin.layouts.message')

        <div class="d-lg-flex align-items-lg-start">

            <div class="flex-1">

                <!-- Form -->
                <form id="post-form" method="POST" action="{{ route('admin.user.update', $user->id) }}" novalidate enctype="multipart/form-data">
                    @method('PUT')
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
                                                <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}" required>
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
                                                        <img id="avatar-img" src="{{ $user->userPictureUrl($user->picture, $user->name) }}" class="rounded-pill" alt="{{ $user->name }}" width="60" height="60">
                                                    </div>

                                                    <div class="media-body">
                                                        <div class="custom-file">
                                                            <input id="customFile" type="file" class="custom-file-input @error('picture') is-invalid @enderror" name="picture" accept=".jpg, .jpeg, .png, .gif">
                                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                                            <span class="form-text text-muted">Format: gif, png, jpg. Ukuran maks: 2Mb.
                                                            @if ($user->picture)
                                                                <a href="{{ route('admin.user.delete-avatar', $user->id) }}" class="remove-avatar" role="button" data-id="{{ $user->id }}">Hapus foto?</a>
                                                            @endif</span>
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
                                                <input id="phone" type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $user->phone }}" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="www">Website:</label>
                                            <div class="col-lg-9">
                                                <input id="www" type="url" name="www" class="form-control @error('www') is-invalid @enderror" value="{{ $user->www }}" required>
                                                @error('www')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="bio">Biografi:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" name="bio" id="bio" cols="30" rows="4" placeholder="Ceritakan tentang diri Anda.">{{ $user->bio }}</textarea>
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
                                                <input id="username" type="email" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Nama Akun" value="{{ $user->username }}" required>
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="email">Email:</label>
                                            <div class="col-lg-9">
                                                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" value="{{ $user->email }}" required>
                                                <span class="form-text text-muted">Jika Anda mengubah email, sistem akan mengirimkan konfirmasi ke alamat email yang baru. <strong>Alamat email yang baru tidak akan aktif sebelum dikonfirmasi.</strong></span>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="email">Kata Sandi:</label>
                                            <div class="col-lg-9">
                                                <button type="button" data-toggle="modal" data-target="#new-password-modal" class="btn btn-outline-warning btn-sm new-password">Ubah Kata Sandi</button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="role">Level</label>
                                            <div class="col-lg-9">
                                                <select name="role" id="role" class="custom-select @error('role') is-invalid @enderror">
                                                    @foreach ($roles as $key => $value)
                                                        <option value="{{ $key }}" @selected($user->role == $key)>{{ $value }}</option>
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
                                                <input id="facebook" type="url" name="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ $user->facebook }}" required>
                                                @error('facebook')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="twitter">Twitter:</label>
                                            <div class="col-lg-9">
                                                <input id="twitter" type="url" name="twitter" class="form-control @error('twitter') is-invalid @enderror" value="{{ $user->twitter }}" required>
                                                @error('twitter')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="instagram">Instagram:</label>
                                            <div class="col-lg-9">
                                                <input id="instagram" type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ $user->instagram }}" required>
                                                @error('instagram')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="tiktok">TikTok:</label>
                                            <div class="col-lg-9">
                                                <input id="tiktok" type="url" name="tiktok" class="form-control @error('tiktok') is-invalid @enderror" value="{{ $user->tiktok }}" required>
                                                @error('tiktok')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="youtube">YouTube:</label>
                                            <div class="col-lg-9">
                                                <input id="youtube" type="url" name="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ $user->youtube }}" required>
                                                @error('youtube')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </fieldset>

                                    <div class="form-group row mb-0">
                                        <div class="col-lg-9 offset-lg-3">
                                            <button type="submit" class="btn btn-secondary">Ubah</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="sidebar sidebar-light sidebar-component sidebar-component-right sidebar-expand-lg">

                <div class="sidebar-content">@include('admin.user.show')</div>

            </div>

        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.user.new_password')
@endsection

@section('script')
    @include('admin.user.script')
@endsection
