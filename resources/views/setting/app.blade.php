@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('layouts.message')

        <!-- Form -->
        <form id="post-form" method="POST" action="{{ route('setting.update') }}" novalidate enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">

                            <fieldset>
                                <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-strategy me-2"></i>Aplikasi</legend>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="name">Nama:</label>
                                    <div class="col-lg-9">
                                        <input id="appName" type="text" name="appName" class="form-control @error('appName') is-invalid @enderror" value="{{ $settings['appName'] }}">
                                        @error('appName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="name">Keterangan:</label>
                                    <div class="col-lg-9">
                                        <textarea id="appDesc" type="text" name="appDesc" rows="4" spellcheck="false" class="form-control @error('appDesc') is-invalid @enderror">{{ $settings['appDesc'] }}</textarea>
                                        @error('appDesc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="name">URL:</label>
                                    <div class="col-lg-9">
                                        <input id="appUrl" type="url" name="appUrl" class="form-control @error('appUrl') is-invalid @enderror" value="{{ $settings['appUrl'] }}">
                                        @error('appUrl')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="name">Logo:</label>
                                    <div class="col-lg-9">
                                        <div class="d-flex mt-0">
                                            <div class="me-3">
                                                <img id="avatar-img" src="{{ $settings['appLogo'] }}" class="rounded-pill" alt="Logo" width="60" height="60">
                                            </div>

                                            <div class="flex-fill">
                                                <div class="custom-file">
                                                    <input id="appLogo" type="file" name="appLogo" class="form-control @error('appLogo') is-invalid @enderror" value="{{ $settings['appLogo'] }}" accept=".jpg, .jpeg, .png, .gif">
                                                    <span class="form-text text-muted">Format: .jpg, .jpeg, .png, .gif, .bmp, .svg, .webp. Ukuran maks: 2Mb.
                                                    @error('appLogo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-buildings me-2"></i>Instansi</legend>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="name">Nama:</label>
                                    <div class="col-lg-9">
                                        <input id="company" type="text" name="company" class="form-control @error('company') is-invalid @enderror" value="{{ $settings['company'] }}">
                                        @error('company')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>


                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="name">URL:</label>
                                    <div class="col-lg-9">
                                        <input id="companyUrl" type="url" name="companyUrl" class="form-control @error('companyUrl') is-invalid @enderror" value="{{ $settings['companyUrl'] }}">
                                        @error('companyUrl')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>

                            </fieldset>

                            <div class="mb-3 row mb-0">
                                <div class="col-lg-9 offset-lg-3">
                                    <button type="submit" class="btn btn-indigo">Ubah</button>
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