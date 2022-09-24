@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('layouts.message')

        <!-- Form -->
        <form id="post-form" method="POST" action="{{ route('institute.store') }}" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold" for="name">Nama:</label>
                                <div class="col-lg-9">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="abbrev" class="col-lg-3 col-form-label font-weight-semibold">Singkatan:</label>
                                <div class="col-lg-9">
                                    <input id="abbrev" type="text" class="form-control @error('abbrev') is-invalid @enderror" name="abbrev" value="{{ old('abbrev') }}">
                                    @error('abbrev')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>
                            </div>
                
                            <div class="form-group row">
                                <label for="category" class="col-lg-3 col-form-label font-weight-semibold">Jenis:</label>
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
                
                            <div class="form-group row">
                                <label for="code" class="col-lg-3 col-form-label font-weight-semibold">Kode:</label>
                                <div class="col-lg-9">
                                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>
                            </div>
                
                            <div class="form-group row">
                                <label for="desc" class="col-lg-3 col-form-label font-weight-semibold">Deskripsi:</label>
                                <div class="col-lg-9">
                                    <textarea id="desc" rows="4" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ old('desc') }}</textarea>
                                    @error('desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>
                            </div>
                
                            <div class="form-group row">
                                <label for="operator_id" class="col-lg-3 col-form-label font-weight-semibold">Jenis:</label>
                                <div class="col-lg-9">
                                    <select name="operator_id" id="operator_id" class="select @error('operator_id') is-invalid @enderror">
                                        <option value="">Pilih Operator</option>
                                        @foreach ($operators as $key => $value)
                                            <option value="{{ $key }}" @selected(old('category') == $key)>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('operator_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-lg-9 offset-lg-3">
                                    <button type="submit" class="btn btn-secondary">Simpan<i class="icon-paperplane ml-2"></i></button>
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
    @include('institute.script')
@endsection 