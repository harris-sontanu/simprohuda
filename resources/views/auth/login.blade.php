@extends('layouts.auth.app')

@section('content')
    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Login card -->
                    <form class="login-form" method="POST" action="{{ route('login') }}" novalidate>
                        @csrf
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <i class="icon-reading icon-2x text-indigo border-indigo border-3 rounded-pill p-3 mb-3 mt-1"></i>
                                    <h4 class="mb-0 font-weight-bold font-title text-indigo"><span class="text-pink">{{ config('app.name') }}</span></h4>
                                    <span class="d-block">Sistem Pembentukan Produk Hukum Daerah Kabupaten Klungkung</span>
                                </div>


                                <div class="form-group form-group-feedback form-group-feedback-left">

                                    <input id="username" type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Nama Akun" value="{{ old('username') }}" required autofocus>
                                    <div class="form-control-feedback">
                                        <i class="icon-user text-muted"></i>
                                    </div>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>

                                <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata sandi" required autocomplete="current-password">
                                    <div class="form-control-feedback">
                                        <i class="icon-lock2 text-muted"></i>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>

                                <div class="form-group d-flex align-items-center">
                                    <label class="custom-control custom-checkbox">
                                        <input id="remember_me" type="checkbox" name="remember"
                                            class="custom-control-input">
                                        <span class="custom-control-label">Ingat saya</span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a class="ml-auto" href="{{ route('password.request') }}">
                                            Lupa kata sandi?
                                        </a>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-indigo btn-block">Masuk<i class="icon-enter ml-2"></i></button>
                                </div>

                                <span class="form-text text-center text-muted">© Hak cipta 2022<br><a href="https://jdih.klungkungkab.go.id" target="_blank">Bagian Hukum Setda Kabupaten Klungkung</a></span>
                            </div>
                        </div>
                    </form>
                    <!-- /login card -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
@endsection
