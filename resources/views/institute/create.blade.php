@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('layouts.message')

        <!-- Form -->
        <form id="post-form" method="POST" action="{{ route('institute.store') }}" novalidate>
            @csrf

            <!-- Inner container -->
            <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

                <!-- Left content -->
                <div class="flex-1 order-2 order-lg-1">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    
                                    <fieldset>
                                        <legend class="fw-bold fs-base border-bottom pb-2 mb-3"><i class="ph-buildings me-2"></i>Profil</legend>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="name">Nama:</label>
                                            <div class="col-lg-9">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="abbrev" class="col-lg-3 col-form-label">Singkatan:</label>
                                            <div class="col-lg-9">
                                                <input id="abbrev" type="text" class="form-control @error('abbrev') is-invalid @enderror" name="abbrev" value="{{ old('abbrev') }}">
                                                @error('abbrev')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                            
                                        <div class="mb-3 row">
                                            <label for="category" class="col-lg-3 col-form-label">Jenis:</label>
                                            <div class="col-lg-9">
                                                <select name="category" id="category" class="select @error('category') is-invalid @enderror">
                                                    <option value="">Pilih Jenis</option>
                                                    @foreach ($categories as $key => $value)
                                                        <option value="{{ $key }}" @selected(old('category') == $key)>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                            
                                        <div class="mb-3 row">
                                            <label for="code" class="col-lg-3 col-form-label">Kode:</label>
                                            <div class="col-lg-9">
                                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}">
                                                @error('code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                            
                                        <div class="mb-3 row">
                                            <label for="desc" class="col-lg-3 col-form-label">Deskripsi:</label>
                                            <div class="col-lg-9">
                                                <textarea id="desc" rows="4" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ old('desc') }}</textarea>
                                                @error('desc')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>
                                    
                                    <fieldset>
                                        <legend class="fw-bold fs-base border-bottom pb-2 mb-3"><i class="ph-users me-2"></i>Akun</legend>

                                        <div class="mb-3 row">
                                            <label for="corrector_id" class="col-lg-3 col-form-label">Pemeriksa:</label>
                                            <div class="col-lg-9">
                                                <select name="corrector_id" id="corrector_id" class="select @error('corrector_id') is-invalid @enderror">
                                                    <option value="">Pilih Pemeriksa</option>
                                                    @foreach ($correctors as $key => $value)
                                                        <option value="{{ $key }}" @selected(old('corrector_id') == $key)>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('corrector_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="users" class="col-lg-3 col-form-label">Operator:</label>
                                            <div class="col-lg-9">
                                                <select name="users[]" multiple="multiple" class="form-control select @error('users.*') is-invalid @enderror">
                                                    <option value="">Pilih Operator</option>
                                                    @foreach ($users as $key => $value)          
                                                        <option value="{{ $key }}" @selected(old('users.*') == $key)>{{ $value }}</option>  
                                                    @endforeach
                                                </select>
                                                @error('users.*')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </fieldset>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent wmin-lg-350 shadow-none order-1 order-lg-2 ms-lg-3 mb-3">

                    <div class="sidebar-content">
                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <h5 class="mb-0"><i class="ph-globe-hemisphere-east me-2"></i>Publikasi</h5>
                            </div>

                            <table class="table table-borderless my-2 table-xs">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap"><i class="ph-calendar-blank me-2"></i>Tgl. Dibuat:</td>
                                        <td class="text-end">{{ now()->translatedFormat('j F Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-indigo">Simpan</button>
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
    @include('institute.script')
@endsection 