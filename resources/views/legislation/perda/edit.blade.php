@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('layouts.message')

        <div class="d-lg-flex align-items-lg-start">            

            <div class="flex-1">

                <div class="card">
                    <div class="card-body">

                        <!-- Form -->
                        <form method="POST" action="{{ route('legislation.perda.update', $legislation->id) }}" novalidate enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">

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

                                        <div class="form-group row">
                                            <div class="col-lg-9 offset-lg-3">
                                                <button type="submit" class="btn btn-secondary">Ubah</button>
                                            </div>
                                        </div>

                                    </fieldset>

                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="table-responsive">
                        <table class="table table-xs table-striped">
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
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="mr-3">
                                                <i class="icon-file-pdf text-danger icon-2x top-0"></i>
                                            </div>
    
                                            <div class="media-body">
                                                <a href="{{ $master->source }}" class="media-title d-block font-weight-semibold text-dark" title="{{ $master->name }}" target="_blank" download="">{{ $master->name }}</a>
    
                                                <ul class="list-inline list-inline-condensed list-inline-dotted font-size-sm text-muted mb-0">
                                                    <li class="list-inline-item">Batang Tubuh</li>
                                                    <li class="list-inline-item">
                                                        <button type="button" data-toggle="modal" data-target="#edit-modal" class="btn btn-link btn-sm p-0" data-id="1">Ubah</button>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <button type="button" class="btn btn-link btn-sm p-0 delete-document" title="Hapus" data-route="http://jdih.test/admin/legislation/document/1">Hapus</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $master->name }}</td>
                                    <td>{{ $master->dateFormatted($master->created_at) }}</td>
                                    <td></td>
                                </tr>
                                <tr class="table-warning">
                                    <td colspan="6" class="text-center">
                                        <span class="text-muted">Belum ada Dokumen</span>
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

@section('script')
    @include('legislation.perda.script')
@endsection
