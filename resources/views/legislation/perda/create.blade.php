@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('layouts.message')

        <!-- Form -->
        <form method="POST" action="{{ route('legislation.perda.store') }}" novalidate enctype="multipart/form-data">
            @csrf

            <div class="d-lg-flex align-items-lg-start">            

                <div class="flex-1">

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">

                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-reading mr-2"></i> Formulir Pengajuan Ranperda</legend>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="phone">Perangkat Daerah:</label>
                                            <div class="col-lg-9">
                                                <select name="institute_id" id="institute_id" class="select @error('institute_id') is-invalid @enderror">
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
                                                <textarea class="form-control @error('title') is-invalid @enderror" name="title" id="title" cols="30" rows="4" autofocus>{{ old('title') }}</textarea>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="background">Alasan Pengajuan:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control @error('background') is-invalid @enderror" name="background" id="background" cols="30" rows="4" >{{ old('background') }}</textarea>
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
                                                    <input id="customFile" type="file" class="custom-file-input @error('master') is-invalid @enderror" name="master" accept=".pdf, .doc, .docx">
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
                                                    <input type="text" class="form-control @error('attachments.*.title') is-invalid @enderror" name="attachments[][title]" placeholder="Judul Lampiran" value="{{ old('attachments.*.title') }}" />
                                                    @error('attachments.*.title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                                <div class="custom-file">
                                                    <input id="customFile" type="file" class="custom-file-input @error('attachments.*.file') is-invalid @enderror" name="attachments[][file]" accept=".pdf, .doc, .docx">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('attachments.*.file')
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
                                                <input type="hidden" name="requirements[][title]" value="Surat Pengantar" />
                                                <div class="custom-file">
                                                    <input id="customFile" type="file" class="custom-file-input @error('requirements.*.file') is-invalid @enderror" name="requirements[][file]" accept=".pdf">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('requirements.*.file')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                                <span class="form-text text-muted font-size-sm">Surat Pengantar Kepala Perangkat Daerah pemrakarsa Ranperda.</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="background">Naskah Akademik:</label>
                                            <div class="col-lg-9">
                                                <input type="hidden" name="requirements[][title]" value="Naskah Akademik" />
                                                <div class="custom-file">
                                                    <input id="customFile" type="file" class="custom-file-input @error('requirements.*.file') is-invalid @enderror" name="requirements[][file]" accept=".pdf">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('requirements.*.file')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                                <span class="form-text text-muted font-size-sm">Naskah Akademik Ranperda yang sudah berpedoman dengan ketentuan Lampiran I UU 12 Tahun 2011 beserta perubahannya.</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="background">Notulensi Rapat Pembahasan:</label>
                                            <div class="col-lg-9">
                                                <input type="hidden" name="requirements[][title]" value="Notulensi Rapat" />
                                                <div class="custom-file">
                                                    <input id="customFile" type="file" class="custom-file-input @error('requirements.*.file') is-invalid @enderror" name="requirements[][file]" accept=".pdf">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('requirements.*.file')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @endif
                                                </div>
                                                <span class="form-text text-muted font-size-sm">Notulensi rapat pembahasan Ranperda yg diadakan oleh Perangkat Daerah</span>
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
                                        <td class="font-weight-semibold text-nowrap"><i class="icon-pen mr-2"></i>Status:</td>
                                        <td class="text-right"><span class="badge badge-pill badge-light">Draf</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold text-nowrap"><i class="icon-user-tie mr-2"></i>Operator:</td>
                                        <td class="text-right">{{ Auth::user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold text-nowrap"><i class="icon-embed2 mr-2"></i>Nomor Registrasi:</td>
                                        <td class="text-right">{{ $nextRegNumber }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold text-nowrap"><i class="icon-calendar22 mr-2"></i>Tgl. Dibuat:</td>
                                        <td class="text-right">{{ now()->translatedFormat('j F Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                                <button type="submit" name="draft" class="btn btn-link px-0">Simpan ke Draf</button>
                                <button type="submit" name="post" class="btn btn-secondary">Simpan & Ajukan</button>
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
    @include('legislation.perda.script')
@endsection
