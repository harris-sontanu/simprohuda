@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('layouts.message')

        @if ($errors->any())
            <div class="alert alert-danger border-0 alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <ul class="list-unstyled mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Inner container -->
        <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

            <!-- Left content -->
            <div class="flex-1 order-2 order-lg-1">

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
                                        <legend class="fw-bold fs-base border-bottom pb-2 mb-3"><i class="ph-note me-2"></i>Formulir Pengajuan Ranperda</legend>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="title">Judul:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control @error('title') is-invalid @enderror" form="update-form" name="title" id="title" spellcheck="false" cols="30" rows="4" autofocus>{{ $legislation->title }}</textarea>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-lg-3 col-form-label" for="background">Alasan Pengajuan:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control @error('background') is-invalid @enderror" form="update-form" name="background" id="background" spellcheck="false" cols="30" rows="4" >{{ $legislation->background }}</textarea>
                                                @error('background')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 row mb-0">
                                            <div class="col-lg-9 offset-lg-3">
                                                @if ($legislation->status() === 'draft')
                                                    <button type="submit" form="update-form" name="draft" class="btn btn-light me-2">Simpan ke Draf</button>
                                                    <button type="submit" form="update-form" name="post" class="btn btn-indigo">Simpan & Ajukan</button>
                                                @else
                                                    <button type="submit" form="update-form" name="revise" class="btn btn-indigo">Ubah</button>
                                                    @if ($validateButton)  
                                                        @cannot('isOpd')                                                            
                                                            <form id="validation-form" action="{{ route('legislation.ranperda.approve', $legislation->id) }}" method="post" class="d-inline-block" data-title="{{ $legislation->title }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-success btn-labeled btn-labeled-start ms-2">
                                                                    <span class="btn-labeled-icon bg-black bg-opacity-20"><i class="ph-check"></i></span>Valid
                                                                </button>
                                                            </form>                                                    
                                                        @endcannot
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
                                <tr>
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
                                            <td colspan="5"><span class="fw-semibold">Dokumen Rancangan</span></td>
                                        </tr>
                                    @elseif ($category !== $requirement->category AND $requirement->category === 'requirement')
                                        <tr class="table-active table-border-double">
                                            <td colspan="5"><span class="fw-semibold">Dokumen Persyaratan</span></td>
                                        </tr> 
                                    @endif
                                    @php $row = true; @endphp
                                    @foreach ($documents as $document)
                                        @if ($document->requirement_id === $requirement->id)
                                            <tr>
                                                <td>{{ $document->title }}</td>
                                                <td>
                                                    <div class="d-flex align-items-start">
                                                        <div class="me-2">
                                                            <i class="{{ $document->extClass; }} ph-2x"></i>
                                                        </div>
                
                                                        <div class="flex-fill overflow-hidden">
                                                            <a href="{{ $document->source }}" class="fw-semibold text-body text-truncate" target="_blank" download>{{ $document->name; }}</a>
                                                            <ul class="list-inline list-inline-bullet fs-sm text-muted mb-0">
                                                                <li class="list-inline-item me-1">{{ $document->size() }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <abbr data-bs-popup="tooltip" title="{{ $document->dateFormatted($document->created_at, true) }}">{{ $document->dateFormatted($document->created_at) }}</abbr>
                                                </td>
                                                <td>{!! $document->statusBadge !!}</td>
                                                <td class="text-center">
                                                    <div class="d-inline-flex">
                                                        <a 
                                                            href="#" 
                                                            class="text-body" 
                                                            data-route="{{ route('legislation.document.show', $document->id) }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#preview-doc-modal"
                                                            data-bs-popup="tooltip"
                                                            title="Pratinjau">
                                                            <i class="icon-file-eye"></i>
                                                        </a>
                                                        <a 
                                                            href="#" 
                                                            class="text-body mx-2 upload-document" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#upload-doc-modal" 
                                                            data-action="edit" 
                                                            data-id="{{ $document->id }}"
                                                            data-bs-popup="tooltip" 
                                                            title="Perbaiki">
                                                            <i class="icon-file-upload"></i>
                                                        </a>
                                                        @if (empty($legislation->posted_at)) 
                                                            <form action="{{ route('legislation.document.destroy', $document->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <a 
                                                                    role="button" 
                                                                    class="text-body btn-delete" 
                                                                    data-title="{{ $document->title }}" 
                                                                    data-bs-popup="tooltip" 
                                                                    title="Hapus">
                                                                    <i class="icon-file-minus"></i>
                                                                </a>
                                                            </form>
                                                        @endif
                                                        @if (!empty($legislation->posted_at) AND empty($document->validated_at)) 
                                                            @cannot('isOpd')                                                                
                                                                <form action="{{ route('legislation.document.ratify', $document->id) }}" method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <a 
                                                                        role="button" 
                                                                        class="text-body btn-ratify" 
                                                                        data-title="{{ $document->title }}" 
                                                                        data-bs-popup="tooltip" 
                                                                        title="Validasi">
                                                                        <i class="icon-file-check"></i>
                                                                    </a>
                                                                </form>                                               
                                                            @endcannot
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
                                                <div class="d-inline-flex">
                                                    <a 
                                                        href="#" 
                                                        class="text-body" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#upload-doc-modal"
                                                        data-action="create" 
                                                        data-legislation="{{ $legislation->id }}"
                                                        data-requirement="{{ $requirement->id }}"
                                                        data-bs-popup="tooltip" 
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

                @if ($legislation->status() !== 'draft')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="ph-chats me-2"></i>Diskusi</h5>
                        </div>

                        <div class="card-body">
                            <div class="media-chat-scrollable mb-3">
                                <div class="media-chat vstack gap-2">
                                    @forelse ($legislation->comments as $comment)
                                        @if ($comment->sender->getRawOriginal('role') === 'opd')
                                            <div class="media-chat-item hstack align-items-start gap-3">
                                                <a href="#" class="d-block">
                                                    <img src="{{ $comment->userPictureUrl($comment->sender->picture, $comment->sender->name) }}" class="rounded-circle" alt="{{ $comment->sender->name }}" width="40" height="40" data-bs-popup="tooltip" title="{{ $comment->sender->name }}">
                                                </a>

                                                <div>
                                                    <div class="media-chat-message">{{ $comment->comment }}</div>
                                                    <div class="fs-sm text-muted mt-2">{{ $comment->timeDifference($comment->created_at) }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="media-chat-item media-chat-item-reverse hstack align-items-start gap-3">
                                                <a href="#" class="d-block">
                                                    <img src="{{ $comment->userPictureUrl($comment->sender->picture, $comment->sender->name) }}" class="rounded-circle" alt="{{ $comment->sender->name }}" width="40" height="40" data-bs-popup="tooltip" title="{{ $comment->sender->name }}">
                                                </a>

                                                <div>
                                                    <div class="media-chat-message">{{ $comment->comment }}</div>
                                                    <div class="fs-sm text-muted mt-2">{{ $comment->timeDifference($comment->created_at) }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <li>Belum ada diskusi</li>
                                    @endforelse
                                </div>
                            </div>
                            
                            <form action="{{ route('legislation.comment.store') }}" method="post" novalidate>
                                @csrf
                                <input type="hidden" name="legislation_id" value="{{ $legislation->id }}">
                                <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" rows="3" cols="1" spellcheck="false" placeholder="Ketik pesan Anda..."></textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
        
                                <div class="d-flex align-items-center mt-3">
        
                                    <button type="submit" class="btn btn-indigo btn-labeled btn-labeled-start">
                                        <span class="btn-labeled-icon bg-black bg-opacity-20"><i class="ph-paper-plane-tilt"></i></span>Kirim
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
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
                                    <td class="fw-semibold text-nowrap"><i class="ph-tag me-2"></i>Status:</td>
                                    <td class="text-end">{!! $legislation->statusBadge !!}</td>
                                </tr><tr>
                                    <td class="fw-semibold text-nowrap"><i class="ph-buildings me-2"></i>Perangkat Daerah:</td>
                                    <td class="text-end">{{ $legislation->institute->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-nowrap"><i class="ph-user me-2"></i>Operator:</td>
                                    <td class="text-end">{{ $legislation->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-nowrap"><i class="icon-user-tie me-2"></i>Pemeriksa:</td>
                                    <td class="text-end">{{ $legislation->institute->corrector->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-nowrap"><i class="ph-calculator me-2"></i>No. Registrasi:</td>
                                    <td class="text-end">{{ $legislation->reg_number }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-nowrap"><i class="ph-calendar-blank me-2"></i>Tgl. Dibuat:</td>
                                    <td class="text-end">{{ $legislation->dateFormatted($legislation->created_at) }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="card">
                        <div class="sidebar-section-header border-bottom">
                            <h5 class="mb-0"><i class="ph-arrow-counter-clockwise me-2"></i>Riwayat</h5>
                        </div>

                        <div class="sidebar-section-body">
                            <div class="list-feed">
                                @forelse ($legislation->logs->take(5) as $log)                                    
                                    <div class="list-feed-item">
                                        <span class="fw-semibold">{{ $log->user->name }}</span> {{ $log->message }}
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
    @include('legislation.document.preview-modal')
@endsection

@section('script')
    @include('legislation.ranperda.script')
@endsection
