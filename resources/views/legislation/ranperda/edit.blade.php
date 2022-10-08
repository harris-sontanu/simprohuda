@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('layouts.message')

        @if ($errors->any())
            <div class="alert alert-danger border-0 alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <ul class="list-unstyled mb-0">
                    @foreach ($errors->all() as $error)
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
                                <form id="update-form" method="POST" action="{{ route('legislation.ranperda.update', $legislation->id) }}" novalidate>
                                    @method('PUT')
                                    @csrf
                                </form>

                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-reading mr-2"></i> Formulir Pengajuan Ranperda</legend>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="title">Judul:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control @error('title') is-invalid @enderror" form="update-form" name="title" id="title" spellcheck="false" cols="30" rows="4" autofocus>{{ $legislation->title }}</textarea>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label" for="background">Alasan Pengajuan:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control @error('background') is-invalid @enderror" form="update-form" name="background" id="background" spellcheck="false" cols="30" rows="4" >{{ $legislation->background }}</textarea>
                                                @error('background')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-lg-9 offset-lg-3">
                                                @if ($legislation->status() === 'draft')
                                                    <button type="submit" form="update-form" name="draft" class="btn btn-light mr-2">Simpan ke Draf</button>
                                                    <button type="submit" form="update-form" name="post" class="btn btn-secondary">Simpan & Ajukan</button>
                                                @else
                                                    <button type="submit" form="update-form" name="revise" class="btn btn-secondary">Ubah</button>
                                                    @if ($validateButton)  
                                                        <form id="validation-form" action="{{ route('legislation.ranperda.approve', $legislation->id) }}" method="post" class="d-inline-block" data-title="{{ $legislation->title }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success btn-labeled btn-labeled-right ml-2"><b><i class="icon-checkmark4"></i></b>Valid</button>
                                                        </form>                                                    
                                                    @endif
                                                @endif                                                    
                                            </div>
                                        </div>

                                    </fieldset>

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
                                @php $category = ''; @endphp
                                @foreach ($requirements as $requirement)
                                    @if($category !== $requirement->category AND $requirement->category === 'master')
                                        <tr class="table-active table-border-double">
                                            <td colspan="5"><span class="font-weight-semibold">Dokumen Rancangan</span></td>
                                        </tr>
                                    @elseif ($category !== $requirement->category AND $requirement->category === 'requirement')
                                        <tr class="table-active table-border-double">
                                            <td colspan="5"><span class="font-weight-semibold">Dokumen Persyaratan</span></td>
                                        </tr> 
                                    @endif
                                    @php $row = true; @endphp
                                    @foreach ($documents as $document)
                                        @if ($document->requirement_id === $requirement->id)
                                            <tr>
                                                <td>{{ $document->title }}</td>
                                                <td>
                                                    <div class="media">
                                                        <div class="mr-3">
                                                            <i class="{{ $document->extClass; }} icon-2x top-0 mt-1"></i>
                                                        </div>
                
                                                        <div class="media-body">
                                                            <a href="{{ $document->source }}" class="media-title d-block font-weight-semibold text-body m-0" title="{{ $document->name }}" target="_blank" download>{{ $document->name; }}</a>
                
                                                            <ul class="list-inline list-inline-condensed list-inline-dotted font-size-sm text-muted mb-0">
                                                                <li class="list-inline-item">{{ $document->size(); }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <abbr data-popup="tooltip" title="{{ $document->dateFormatted($document->created_at, true) }}">{{ $document->dateFormatted($document->created_at) }}</abbr>
                                                </td>
                                                <td>{!! $document->statusBadge !!}</td>
                                                <td class="text-center">
                                                    <div class="list-icons">
                                                        <a href="#" class="list-icons-item" data-popup="tooltip" title="Pratinjau"><i class="icon-file-eye"></i></a>
                                                        <a 
                                                            href="#" 
                                                            class="list-icons-item upload-document" 
                                                            data-toggle="modal" 
                                                            data-target="#upload-doc-modal" 
                                                            data-action="edit" 
                                                            data-id="{{ $document->id }}"
                                                            data-popup="tooltip" 
                                                            title="Perbaiki">
                                                            <i class="icon-file-upload"></i>
                                                        </a>
                                                        @if (!empty($legislation->posted_at) AND empty($document->validated_at)) 
                                                            <form action="{{ route('legislation.document.ratify', $document->id) }}" method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <a role="button" class="list-icons-item btn-ratify" data-title="{{ $document->title }}" data-popup="tooltip" title="Validasi"><i class="icon-file-check"></i></a>
                                                            </form>                                               
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $row = false; @endphp
                                        @endif
                                    @endforeach  
                                    @if ($row)                                        
                                        <tr @error($requirement->term) class="table-danger" @enderror>
                                            <td>{{ $requirement->title }}</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td class="text-center">
                                                <div class="list-icons">
                                                    <a 
                                                        href="#" 
                                                        class="list-icons-item" 
                                                        data-toggle="modal" 
                                                        data-target="#upload-doc-modal"
                                                        data-action="create" 
                                                        data-legislation="{{ $legislation->id }}"
                                                        data-requirement="{{ $requirement->id }}"
                                                        data-popup="tooltip" 
                                                        title="Unggah">
                                                        <i class="icon-file-plus"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    @php $category = $requirement->category; @endphp                                  
                                @endforeach                                                                        
                            </tbody>
                        </table>
                    </div>                    
                </div>

                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title font-weight-bold"><i class="icon-bubbles4 mr-2"></i>Diskusi</h5>
                    </div>

                    <div class="card-body">
                        <ul class="media-list media-chat media-chat-scrollable mb-3">
                            @forelse ($legislation->comments as $comment)
                                @if ($comment->author->getRawOriginal('role') === 'opd')
                                    <li class="media">
                                        <div class="mr-3">
                                            <img src="{{ $comment->userPictureUrl($comment->author->picture, $comment->author->name) }}" class="rounded-circle" alt="{{ $comment->author->name }}" width="40" height="40" data-popup="tooltip" title="{{ $comment->author->name }}">
                                        </div>

                                        <div class="media-body">
                                            <div class="media-chat-item">{{ $comment->comment }}</div>
                                            <div class="font-size-sm text-muted mt-2">{{ $comment->timeDifference($comment->created_at) }}</div>
                                        </div>
                                    </li>
                                @else
                                    <li class="media media-chat-item-reverse">
                                        <div class="media-body">
                                            <div class="media-chat-item">{{ $comment->comment }}</div>
                                            <div class="font-size-sm text-muted mt-2">{{ $comment->timeDifference($comment->created_at) }}</div>
                                        </div>

                                        <div class="ml-3">
                                            <img src="{{ $comment->userPictureUrl($comment->author->picture, $comment->author->name) }}" class="rounded-circle" alt="{{ $comment->author->name }}" width="40" height="40" data-popup="tooltip" title="{{ $comment->author->name }}">
                                        </div>
                                    </li>
                                @endif
                            @empty
                                <li>Belum ada diskusi</li>
                            @endforelse
                        </ul>
                        
                        <form action="{{ route('legislation.comment.store') }}" method="post" novalidate>
                            @csrf
                            <input type="hidden" name="legislation_id" value="{{ $legislation->id }}">
                            <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" rows="3" cols="1" placeholder="Ketik pesan Anda..."></textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
    
                            <div class="d-flex align-items-center mt-3">
    
                                <button type="submit" class="btn btn-secondary btn-labeled btn-labeled-right ml-auto"><b><i class="icon-paperplane"></i></b> Kirim</button>
                            </div>
                        </form>
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
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-user mr-2"></i>Operator:</td>
                                    <td class="text-right">{{ $legislation->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold text-nowrap"><i class="icon-user-tie mr-2"></i>Pemeriksa:</td>
                                    <td class="text-right">{{ $legislation->institute->corrector->name }}</td>
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

                    <div class="card">
                        <div class="card-header">
                            <h5 class="font-weight-bold">Riwayat</h5>
                        </div>

                        <div class="card-body">
                            <div class="list-feed">
                                @forelse ($legislation->logs as $log)                                    
                                    <div class="list-feed-item">
                                        <a href="#">{{ $log->user->name }}</a> {{ $log->message }}
                                        <div class="text-muted">{{ $log->timeDifference($log->created_at) }}</div>
                                    </div>
                                @empty
                                    <p>Belum ada riwayat</p>
                                @endforelse
                            </div>
                        </div>
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
    @include('legislation.ranperda.script')
@endsection
