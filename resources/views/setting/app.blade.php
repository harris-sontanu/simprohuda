@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('layouts.message')

        <!-- Form -->
        <form id="post-form" method="POST" action="{{ route('user.store') }}" novalidate enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">

                            <fieldset>
                                <legend class="fs-base fw-bold border-bottom pb-2 mb-3"><i class="ph-strategy me-2"></i>Profil</legend>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label" for="name">Nama Aplikasi:</label>
                                    <div class="col-lg-9">
                                        <input id="appName" type="text" name="appName" class="form-control @error('appName') is-invalid @enderror" value="{{ $settings['appName'] }}" required>
                                        @error('appName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
    <!-- /content area -->

@endsection