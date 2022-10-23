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
                            <div class="card-body p-4">
                                <div class="text-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
										<img src="{{ asset('assets/images/logo_icon.svg') }}" class="h-48px" alt="">
									</div>
                                    <h3 class="mb-0 fw-bold font-title text-pink">{{ config('app.name') }}</h3>
                                    <span class="d-block">Sistem Pembentukan Produk Hukum Daerah Kabupaten Klungkung</span>
                                </div>

                                <div class="mb-3">
									<label class="form-label">Username</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Nama Akun" value="{{ old('username') }}" required autofocus>
										<div class="form-control-feedback-icon">
											<i class="ph-user-circle text-muted"></i>
										</div>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
									</div>
								</div>

								<div class="mb-3">
									<label class="form-label">Password</label>
									<div class="form-control-feedback form-control-feedback-start">
										<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata sandi" required autocomplete="current-password">
										<div class="form-control-feedback-icon">
											<i class="ph-lock text-muted"></i>
										</div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @endif
									</div>
								</div>

                                <div class="d-flex align-items-center mb-3">
									<label class="form-check">
										<input id="remember_me" type="checkbox" name="remember" class="form-check-input">
										<span class="form-check-label">Ingat saya</span>
									</label>
                                    
                                    @if (Route::has('password.request'))
									    <a href="{{ route('password.request') }}" class="ms-auto link-indigo">Lupa kata sandi?</a>
                                    @endif
								</div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-indigo w-100">Masuk<i class="ph-sign-in ps-2"></i></button>
                                </div>

                                <span class="d-block text-center text-muted">© Hak cipta 2022<br><a href="https://jdih.klungkungkab.go.id" target="_blank">Bagian Hukum Setda Kabupaten Klungkung</span>
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