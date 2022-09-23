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
                <form id="post-form" method="POST" action="{{ route('admin.setting.update'); }}" novalidate>
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">

                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-reading mr-2"></i>Profil</legend>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="app_name">Nama Aplikasi:</label>
                                            <div class="col-lg-9">
                                                <input id="app_name" type="text" name="app_name" class="form-control @error('app_name') is-invalid @enderror" value="{{ $settings['app_name'] }}">
                                                @error('app_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="phone">Tentang Aplikasi:</label>
                                            <div class="col-lg-9">
                                                <textarea name="app_desc" id="app_desc" class="form-control @error('app_desc') is-invalid @enderror"" rows="3">{{ $settings['app_desc'] }}</textarea>
                                                @error('app_desc')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="company">Institusi:</label>
                                            <div class="col-lg-9">
                                                <input id="company" type="text" name="company" class="form-control @error('company') is-invalid @enderror" value="{{ $settings['company'] }}">
                                                @error('company')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="company">Kode Wilayah:</label>
                                            <div class="col-lg-9">
                                                <input id="region_code" type="number" name="region_code" class="form-control @error('region_code') is-invalid @enderror" value="{{ $settings['region_code'] }}">
                                                @error('region_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                                <span class="form-text text-muted">Temukan referensi kode wilayah di <a href="https://jdih.baliprov.go.id/produk-hukum/peraturan-perundang-undangan/permenkumham/24804" target="_blank">PERMENKUMHAN Nomor 8 Tahun 2019</a>.</span>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-office mr-2"></i>Kontak</legend>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="address">Alamat:</label>
                                            <div class="col-lg-9 mb-3">
                                                <input id="address" type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ $settings['address'] }}" placeholder="Alamat kantor">
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                            <div class="offset-lg-3 col">
                                                <div class="mb-3">
                                                    <input id="province" type="text" name="province" class="form-control @error('province') is-invalid @enderror" value="{{ $settings['province'] }}" placeholder="Provinsi">
                                                    @error('province')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                                <input id="district" type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ $settings['district'] }}" placeholder="Kecamatan">
                                                @error('district')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <input id="regency" type="text" name="regency" class="form-control @error('regency') is-invalid @enderror" value="{{ $settings['regency'] }}" placeholder="Kabupaten">
                                                    @error('regency')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                                <input id="city" type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ $settings['city'] }}" placeholder="Desa / Kelurahan">
                                                @error('city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="address">Email:</label>
                                            <div class="col-lg-9">
                                                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $settings['email'] }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="address">Website:</label>
                                            <div class="col-lg-9">
                                                <input id="url" type="url" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ $settings['url'] }}" required>
                                                @error('url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="address">Telepon:</label>
                                            <div class="col-lg-9">
                                                <input id="phone" type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $settings['phone'] }}" required>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="address">Fax:</label>
                                            <div class="col-lg-9">
                                                <input id="fax" type="text" name="fax" class="form-control @error('fax') is-invalid @enderror" value="{{ $settings['fax'] }}" required>
                                                @error('fax')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="address">Kode Pos:</label>
                                            <div class="col-lg-9">
                                                <input id="zip" type="number" name="zip" class="form-control @error('zip') is-invalid @enderror" value="{{ $settings['zip'] }}" required>
                                                @error('zip')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-theater mr-2"></i>Media Sosial</legend>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="facebook">Facebook:</label>
                                            <div class="col-lg-9">
                                                <input id="facebook" type="url" name="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ $settings['facebook'] }}" required>
                                                @error('facebook')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="twitter">Twitter:</label>
                                            <div class="col-lg-9">
                                                <input id="twitter" type="url" name="twitter" class="form-control @error('twitter') is-invalid @enderror" value="{{ $settings['twitter'] }}" required>
                                                @error('twitter')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="instagram">Instagram:</label>
                                            <div class="col-lg-9">
                                                <input id="instagram" type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ $settings['instagram'] }}" required>
                                                @error('instagram')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="tiktok">TikTok:</label>
                                            <div class="col-lg-9">
                                                <input id="tiktok" type="url" name="tiktok" class="form-control @error('tiktok') is-invalid @enderror" value="{{ $settings['tiktok'] }}" required>
                                                @error('tiktok')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="youtube">YouTube:</label>
                                            <div class="col-lg-9">
                                                <input id="youtube" type="url" name="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ $settings['youtube'] }}" required>
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

        </div>

    </div>
    <!-- /content area -->

@endsection
