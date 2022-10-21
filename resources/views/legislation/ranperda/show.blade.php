@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        <!-- Inner container -->
        <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

            <!-- Left content -->
            <div class="flex-1 order-2 order-lg-1">

                <div class="card">

                    <div class="card-body">

                        <h4 class="card-title">{{ $legislation->title }}</h4>

                        <div class="row mb-3">
                            <div class="col">
                                @if ($master)     
                                    @if ($master->ext === 'pdf')
                                        <iframe
                                            src="{{ asset('assets/js/plugins/pdfjs/web/viewer.html') }}?file={{ $master->source }}" 
                                            width="100%"
                                            height="600px"
                                        ></iframe>
                                    @else                                        
                                        <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{ asset($master->source) }}' width='100%' height='650px' frameborder='0'></iframe>
                                    @endif                           
                                @else
                                    <img src="{{ asset('assets/images/placeholders/file-not-found.jpg') }}" class="img-fluid rounded">
                                @endif
                            </div>

                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td class="fw-semibold text-nowrap">Nomor Registrasi</td>
                                            <td>:</td>
                                            <td>{{ $legislation->reg_number }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-nowrap">Perangkat Daerah</td>
                                            <td>:</td>
                                            <td>{{ $legislation->institute->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-nowrap">Operator</td>
                                            <td>:</td>
                                            <td>{{ $legislation->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-nowrap">Pemeriksa</td>
                                            <td>:</td>
                                            <td>{{ $legislation->institute->corrector->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-nowrap">Alasan Pengajuan</td>
                                            <td>:</td>
                                            <td>{{ $legislation->background }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-nowrap">Tanggal Dibuat</td>
                                            <td>:</td>
                                            <td>{{ $legislation->dateFormatted($legislation->created_at, true) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-nowrap">Tanggal Diajukan</td>
                                            <td>:</td>
                                            <td>{{ $legislation->dateFormatted($legislation->posted_at, true) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-nowrap">Tanggal Revisi</td>
                                            <td>:</td>
                                            <td>{{ $legislation->dateFormatted($legislation->revised_at, true) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-nowrap">Tanggal Divalidasi</td>
                                            <td>:</td>
                                            <td>{{ $legislation->dateFormatted($legislation->validated_at, true) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold text-nowrap">Waktu Proses</td>
                                            <td>:</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Dokumen Persyaratan</th>
                                    <th>Tgl. Unggah</th>
                                    <th>Tgl. Revisi</th>
                                    <th>Tgl. Valid</th>
                                </tr>
                            </thead>
                            <tbody id="status-relation-table-body">
                                @foreach ($requirements as $requirement)
                                    @php $row = true; @endphp
                                    @foreach ($documents as $document)
                                        @if ($document->requirement_id === $requirement->id)
                                            <tr>
                                                <td>{{ $document->title }}</td>
                                                <td>
                                                    <div class="media">
                                                        <div class="me-3">
                                                            <i class="{{ $document->extClass; }} icon-2x top-0 mt-1"></i>
                                                        </div>
                
                                                        <div class="media-body">
                                                            <a href="{{ $document->source }}" class="media-title d-block fw-semibold text-body m-0" title="{{ $document->name }}" target="_blank" download>{{ $document->name; }}</a>
                
                                                            <ul class="list-inline list-inline-condensed list-inline-dotted font-size-sm text-muted mb-0">
                                                                <li class="list-inline-item">{{ $document->size(); }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <abbr data-bs-popup="tooltip" title="{{ $document->dateFormatted($document->created_at, true) }}">{{ $document->dateFormatted($document->created_at) }}</abbr>
                                                </td>
                                                <td>
                                                    <abbr data-bs-popup="tooltip" title="{{ $document->dateFormatted($document->revised_at, true) }}">{{ $document->dateFormatted($document->revised_at) }}</abbr>
                                                </td>
                                                <td>
                                                    <abbr data-bs-popup="tooltip" title="{{ $document->dateFormatted($document->validated_at, true) }}">{{ $document->dateFormatted($document->validated_at) }}</abbr>
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
                                            <td>-</td>
                                        </tr>
                                    @endif                               
                                @endforeach                                                                        
                            </tbody>
                        </table>
                    </div>                    
                </div>

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
                                    <span>Belum ada diskusi</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3">
    
                <div class="sidebar-content">

                    <div class="card">
                        <div class="sidebar-section-header border-bottom">
                            <h5 class="mb-0"><i class="ph-arrow-counter-clockwise me-2"></i>Riwayat</h5>
                        </div>

                        <div class="sidebar-section-body">
                            <div class="list-feed">
                                @forelse ($legislation->logs->take(10) as $log)                                    
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
@endsection

@section('script')
    @include('legislation.ranperda.script')
@endsection
