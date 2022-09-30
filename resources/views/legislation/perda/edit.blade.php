@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('layouts.message')

        @if ($errors->has(['master', 'surat_pengantar', 'naskah_akademik', 'notulensi_rapat']))
            <div class="alert alert-danger border-0 alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <ul class="list-unstyled mb-0">
                    @foreach ($errors->get('master') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach ($errors->get('attachments.*') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach ($errors->get('surat_pengantar') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach ($errors->get('naskah_akademik') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @foreach ($errors->get('notulensi_rapat') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-lg-flex align-items-lg-start">            

            <div class="flex-1">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">

                                <!-- Form -->
                                <form method="POST" action="{{ route('legislation.perda.update', $legislation->id) }}" novalidate>
                                    @method('PUT')
                                    @csrf

                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-reading mr-2"></i> Formulir Pengajuan Ranperda</legend>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="title">Judul:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control @error('title') is-invalid @enderror" name="title" id="title" cols="30" rows="4" autofocus>{{ $legislation->title }}</textarea>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="background">Alasan Pengajuan:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control @error('background') is-invalid @enderror" name="background" id="background" cols="30" rows="4" >{{ $legislation->background }}</textarea>
                                                @error('background')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-lg-9 offset-lg-3">
                                                @if ($legislation->status() === 'draft')
                                                    <button type="submit" name="draft" class="btn btn-light mr-2">Simpan ke Draf</button>
                                                    <button type="submit" name="post" class="btn btn-secondary">Simpan & Ajukan</button>
                                                @else
                                                    <button type="submit" name="post" class="btn btn-secondary">Ubah</button>
                                                @endif                                                    
                                            </div>
                                        </div>

                                    </fieldset>
                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="bg-light">
                                    <th>Nama</th>
                                    <th>Dokumen</th>
                                    <th>Tgl. Unggah</th>
                                    <th>Status</th>
                                    <th class="text-center" width="1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="status-relation-table-body">
                                <tr class="table-active table-border-double">
                                    <td colspan="2"><span class="font-weight-semibold">Dokumen Rancangan</span></td>
                                    <td colspan="3" class="text-right">
                                        <button type="button" class="btn btn-sm btn-light"><i class="icon-file-upload mr-2"></i>Unggah Lampiran</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Draf Ranperda</td>
                                    <td>
                                        @empty ($master)
                                            @php $action = 'create'; @endphp
                                        @else
                                            @php $action = 'edit'; @endphp
                                            <div class="media">
                                                <div class="mr-3">
                                                    <i class="{{ $master->extClass; }} icon-2x top-0"></i>
                                                </div>
        
                                                <div class="media-body">
                                                    <a href="{{ $master->source }}" class="media-title d-block font-weight-semibold text-body" title="{{ $master->name }}" target="_blank" download>{{ $master->name; }}</a>
        
                                                    <ul class="list-inline list-inline-condensed list-inline-dotted font-size-sm text-muted mb-0">
                                                        <li class="list-inline-item">{{ $master->size() }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endempty
                                    </td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm rounded-pill rounded-right-0" data-popup="tooltip" title="Pratinjau Dokumen"><i class="icon-eye2"></i></a>
                                            <button 
                                                type="button" 
                                                class="btn btn-light btn-sm rounded-pill rounded-left-0 upload-document" 
                                                data-toggle="modal" 
                                                data-target="#upload-doc-modal" 
                                                data-action="{{ $action }}" 
                                                @if ($action == 'edit')
                                                    data-id="{{ $master->id }}";
                                                @else    
                                                    data-legislation="{{ $legislation->id }}" 
                                                    data-title="Draf Ranperda" 
                                                    data-type="master" 
                                                    data-order="1" 
                                                @endif
                                                data-popup="tooltip" 
                                                title="Unggah Dokumen">
                                                <i class="icon-file-upload"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-active table-border-double">
                                    <td colspan="5"><span class="font-weight-semibold">Dokumen Persyaratan</span></td>
                                </tr> 
                                <tr>
                                    <td>Surat Pengantar</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm rounded-pill rounded-right-0"><i class="icon-eye2"></i></a>
                                            <button type="button" class="btn btn-light btn-sm rounded-pill rounded-left-0"><i class="icon-file-upload"></i></button>
                                        </div>
                                    </td>
                                </tr>        
                                <tr>
                                    <td>Naskah Akademik</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm rounded-pill rounded-right-0"><i class="icon-eye2"></i></a>
                                            <button type="button" class="btn btn-light btn-sm rounded-pill rounded-left-0"><i class="icon-file-upload"></i></button>
                                        </div>
                                    </td>
                                </tr>                                 
                                <tr>
                                    <td>Notulensi Rapat Pembahasan</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm rounded-pill rounded-right-0"><i class="icon-eye2"></i></a>
                                            <button type="button" class="btn btn-light btn-sm rounded-pill rounded-left-0"><i class="icon-file-upload"></i></button>
                                        </div>
                                    </td>
                                </tr>                                                                        
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right wmin-lg-350 border-0 shadow-none order-1 order-lg-2 sidebar-expand-lg">

                <div class="sidebar-content">
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title font-weight-bold"><i class="icon-earth mr-2"></i>Publikasi</h5>
                        </div>

                        <table class="table table-borderless border-0 table-xs mb-3">
                            <tbody>
                                <tr>
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-pen mr-2"></i>Status:</td>
                                    <td class="text-right">{!! $legislation->statusBadge !!}</td>
                                </tr><tr>
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-office mr-2"></i>Perangkat Daerah:</td>
                                    <td class="text-right">{{ $legislation->institute->name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-user-tie mr-2"></i>Operator:</td>
                                    <td class="text-right">{{ $legislation->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-embed2 mr-2"></i>Nomor Registrasi:</td>
                                    <td class="text-right">{{ $legislation->reg_number }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-calendar22 mr-2"></i>Tgl. Dibuat:</td>
                                    <td class="text-right">{{ $legislation->dateFormatted($legislation->created_at) }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
                
        </div>


    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('legislation.document.upload-modal')
@endsection

@section('script')
    @include('legislation.perda.script')
@endsection
