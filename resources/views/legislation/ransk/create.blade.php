@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('layouts.message')

        <!-- Form -->
        <form method="POST" action="{{ route('legislation.ransk.store') }}" novalidate enctype="multipart/form-data">
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
                                        <legend class="fw-bold fs-base border-bottom pb-2 mb-3"><i class="ph-note me-2"></i>Formulir Pengajuan Rancangan SK</legend>
                                        
                                        @cannot('isOpd')                                            
                                            <div class="mb-3 row">
                                                <label class="col-lg-3 col-form-label">Perangkat Daerah:</label>
                                                <div class="col-lg-9">
                                                    <select name="institute_id" id="institute_id" class="select @error('institute_id') is-invalid @enderror" autofocus>
                                                        <option value="">Pilih Perangkat Daerah</option>
                                                        @foreach ($institutes as $key => $value)
                                                            <option value="{{ $key }}" @selected(old('institute_id') == $key)>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('institute_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endcannot

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="title">Judul:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control 
                                                    @error('title') is-invalid @enderror 
                                                    @error('slug') is-invalid @enderror" 
                                                    name="title" id="title" spellcheck="false" cols="30" rows="4">{{ old('title') }}</textarea>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                                @error('slug')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="background">Alasan Pengajuan:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control @error('background') is-invalid @enderror" name="background" id="background" spellcheck="false" cols="30" rows="4" >{{ old('background') }}</textarea>
                                                @error('background')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset>
                                        <legend class="fw-bold fs-base border-bottom pb-2 mb-3"><i class="ph-file-arrow-up me-2"></i>Dokumen Rancangan</legend>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="background">{{ $master->title }}:</label>
                                            <div class="col-lg-9">
                                                <input type="file" class="form-control @error($master->term) is-invalid @enderror" name="{{ $master->term }}">                                                
                                                @error($master->term)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset>
                                        <legend class="fw-bold fs-base border-bottom pb-2 mb-3"><i class="ph-stack me-2"></i>Dokumen Persyaratan</legend>
                                        
                                        @foreach ($requirements as $requirement)                                   
                                            <div class="mb-3 row">
                                                <label class="col-lg-3 col-form-label" for="background">{{ $requirement->title }}:</label>
                                                <div class="col-lg-9">                                                    
                                                    <input type="file" class="form-control @error($requirement->term) is-invalid @enderror" name="{{ $requirement->term }}">
                                                    @error($requirement->term)
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                    @if (!empty($requirement->desc))
                                                        <div class="form-text text-muted fs-sm">{{ $requirement->desc }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach

                                    </fieldset>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /left content -->
    
                <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent wmin-lg-350 shadow-none order-1 order-lg-2 ms-lg-3 mb-3">
    
                    <div class="sidebar-content">
                        
                        <div class="card">
                            <div class="sidebar-section-header border-bottom">
                                <h5 class="mb-0"><i class="ph-globe-hemisphere-east me-2"></i>Publikasi</h5>
                            </div>

                            <table class="table table-borderless my-2 table-xs">
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold text-nowrap"><i class="ph-pen me-2"></i>Status:</td>
                                        <td class="text-end"><span class="badge bg-info bg-opacity-20 text-info">Draf</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-nowrap"><i class="ph-user me-2"></i>Operator:</td>
                                        <td class="text-end">{{ Auth::user()->name }}</td>
                                    </tr>
                                    @can('isOpd')                                       
                                        <input name="institute_id" type="hidden" value="{{ Auth::user()->institutes->first()->id }}" />                                    
                                        <tr>
                                            <td class="fw-semibold text-nowrap"><i class="ph-buildings me-2"></i>Perangkat Daerah:</td>
                                            <td class="text-end">{{ Auth::user()->institutes->first()->name }}</td>
                                        </tr>                         
                                        <tr>
                                            <td class="fw-semibold text-nowrap"><i class="icon-user-tie me-2"></i>Pemeriksa:</td>
                                            <td class="text-end">{{ Auth::user()->institutes->first()->corrector->name }}</td>
                                        </tr>
                                    @endcan
                                    <tr>
                                        <td class="fw-semibold text-nowrap"><i class="ph-calculator me-2"></i>No. Registrasi:</td>
                                        <td class="text-end">{{ $nextRegNumber }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-nowrap"><i class="ph-calendar-blank me-2"></i>Tgl. Dibuat:</td>
                                        <td class="text-end">{{ now()->translatedFormat('j F Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-footer d-flex justify-content-between">
                                <button type="submit" name="draft" class="btn btn-link px-0">Simpan ke Draf</button>
                                <button type="submit" name="post" class="btn btn-indigo">Simpan & Ajukan</button>
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
    @include('legislation.ransk.script')
@endsection
