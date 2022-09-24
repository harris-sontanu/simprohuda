@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('layouts.message')

        <div class="d-lg-flex align-items-lg-start">

            <div class="flex-1">

                <!-- Form -->
                <form id="post-form" method="POST" action="{{ route('legislation.perda.create') }}" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">

                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-reading mr-2"></i> Formulir Pengajuan Ranperda</legend>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="phone">Perangkat Daerah:</label>
                                            <div class="col-lg-9">
                                                <select name="institute_id" id="institute_id" class="select">
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

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="title">Judul:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" name="title" id="title" cols="30" rows="4" autofocus>{{ old('title') }}</textarea>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="background">Alasan Pengajuan:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" name="background" id="background" cols="30" rows="4" >{{ old('background') }}</textarea>
                                                @error('background')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-file-text2 mr-2"></i>Dokumen Rancangan</legend>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="background">Batang Tubuh:</label>
                                            <div class="col-lg-9">
                                                <div class="custom-file">
                                                    <input id="customFile" type="file" class="custom-file-input @error('master') is-invalid @enderror" name="master" accept=".doc, .docx">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('master')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Lampiran:</label>
                                            <div class="col-lg-9">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" name="name[]" placeholder="Judul Lampiran" />
                                                </div>
                                                <div class="custom-file">
                                                    <input id="customFile" type="file" class="custom-file-input @error('attachment') is-invalid @enderror" name="attachment" accept=".doc, .docx">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('attachment')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                                
                                                <button type="button" class="btn btn-link p-0 form-text new-attachment">+ Tambah Lampiran</button>
                                            </div>
                                        </div>

                                    </fieldset>

                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-stack mr-2"></i>Dokumen Persyaratan</legend>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="background">Surat Pengantar:</label>
                                            <div class="col-lg-9">
                                                <input type="hidden" name="name[]" value="Surat Pengantar" />
                                                <div class="custom-file">
                                                    <input id="customFile" type="file" class="custom-file-input @error('requirement') is-invalid @enderror" name="requirement[]" accept=".pdf">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('requirement')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="background">Berita Acara:</label>
                                            <div class="col-lg-9">
                                                <input type="hidden" name="name[]" value="Berita Acara" />
                                                <div class="custom-file">
                                                    <input id="customFile" type="file" class="custom-file-input @error('requirement') is-invalid @enderror" name="requirement[]" accept=".pdf">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('requirement')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>
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
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-pen mr-2"></i>Status:</td>
                                    <td class="text-right"><span class="badge badge-pill badge-light">Draf</span></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-user-tie mr-2"></i>Operator:</td>
                                    <td class="text-right">{{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-embed2 mr-2"></i>Nomor Registrasi:</td>
                                    <td class="text-right">0043</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-calendar22 mr-2"></i>Tgl. Dibuat:</td>
                                    <td class="text-right">{{ now()->translatedFormat('j F Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                            <button type="submit" name="draft" class="btn btn-link px-0">Simpan ke Draf</button>
                            <button type="submit" name="publish" class="btn btn-secondary">Simpan & Ajukan</button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /content area -->

@endsection

@section('script')
    @include('legislation.perda.script')
@endsection
