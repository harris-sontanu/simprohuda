@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('layouts.message')

        <!-- Form -->
        <form id="post-form" method="POST" action="{{ route('institute.update', $institute->id) }}" novalidate>
            @method('PUT')
            @csrf

            <div class="d-lg-flex align-items-lg-start">            

                <div class="flex-1">

                    <div class="card">
                        <div class="card-body">
        
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    
                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-office mr-2"></i>Profil</legend>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="name">Nama:</label>
                                            <div class="col-lg-9">
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $institute->name }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
            
                                        <div class="form-group row">
                                            <label for="abbrev" class="col-lg-3 col-form-label font-weight-semibold">Singkatan:</label>
                                            <div class="col-lg-9">
                                                <input id="abbrev" type="text" class="form-control @error('abbrev') is-invalid @enderror" name="abbrev" value="{{ $institute->abbrev }}">
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
                                                        <option value="{{ $key }}" @selected($institute->getRawOriginal('category') == $key)>{{ $value }}</option>
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
                                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ $institute->code }}">
                                                @error('code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                            
                                        <div class="form-group row">
                                            <label for="desc" class="col-lg-3 col-form-label font-weight-semibold">Deskripsi:</label>
                                            <div class="col-lg-9">
                                                <textarea id="desc" rows="4" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ $institute->desc }}</textarea>
                                                @error('desc')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>
                                    
                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-users4 mr-2"></i>Akun</legend>
                                        <div class="form-group row">
                                            <label for="corrector_id" class="col-lg-3 col-form-label font-weight-semibold">Pemeriksa:</label>
                                            <div class="col-lg-9">
                                                <select name="corrector_id" id="corrector_id" class="select @error('corrector_id') is-invalid @enderror">
                                                    <option value="">Pilih Pemeriksa</option>
                                                    @foreach ($correctors as $key => $value)
                                                        <option value="{{ $key }}" @selected($institute->corrector_id == $key)>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('corrector_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>
        
                                </div>
                            </div>
        
                        </div>
                    </div>
                </div>

                <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right wmin-lg-350 border-0 shadow-none order-1 order-lg-2 sidebar-expand-lg">

                    <div class="sidebar-content">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title font-weight-bold"><i class="icon-earth mr-2"></i>Publikasi</h5>
                            </div>

                            <table class="table table-borderless border-0 table-xs">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-semibold text-nowrap"><i class="icon-calendar22 mr-2"></i>Tgl. Dibuat:</td>
                                        <td class="text-right">{{ $institute->dateFormatted($institute->created_at) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-footer bg-white border-0 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-secondary">Ubah</button>
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