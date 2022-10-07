@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        <div class="d-lg-flex align-items-lg-start">            

            <div class="flex-1">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title font-weight-bold text-uppercase">{{ $legislation->title }}</h5>
                    </div>

                    <div class="card-body">

                        <div class="row">
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
                                    <img src="{{ asset('assets/images/placeholders/file-not-found.jpg') }}" class="img-fluid">
                                @endif
                            </div>

                            <div class="col">
                                <table class="table">
                                    <tr>
                                        <td class="font-weight-semibold">Nomor Registrasi</td>
                                        <td>:</td>
                                        <td>{{ $legislation->reg_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">Perangkat Daerah</td>
                                        <td>:</td>
                                        <td>{{ $legislation->institute->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">Operator</td>
                                        <td>:</td>
                                        <td>{{ $legislation->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">Pemeriksa</td>
                                        <td>:</td>
                                        <td>{{ $legislation->institute->corrector->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">Alasan Pengajuan</td>
                                        <td>:</td>
                                        <td>{{ $legislation->background }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">Tanggal Dibuat</td>
                                        <td>:</td>
                                        <td>{{ $legislation->dateFormatted($legislation->created_at, true) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">Tanggal Diajukan</td>
                                        <td>:</td>
                                        <td>{{ $legislation->dateFormatted($legislation->posted_at, true) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">Tanggal Revisi</td>
                                        <td>:</td>
                                        <td>{{ $legislation->dateFormatted($legislation->revised_at, true) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">Tanggal Divalidasi</td>
                                        <td>:</td>
                                        <td>{{ $legislation->dateFormatted($legislation->validated_at, true) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-semibold">Waktu Proses</td>
                                        <td>:</td>
                                        <td>-</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="bg-light">
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
                                                <td>
                                                    <abbr data-popup="tooltip" title="{{ $document->dateFormatted($document->revised_at, true) }}">{{ $document->dateFormatted($document->revised_at) }}</abbr>
                                                </td>
                                                <td>
                                                    <abbr data-popup="tooltip" title="{{ $document->dateFormatted($document->validated_at, true) }}">{{ $document->dateFormatted($document->validated_at) }}</abbr>
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
                    </div>
                </div>
            </div>
            
            <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right wmin-lg-350 border-0 shadow-none order-1 order-lg-2 sidebar-expand-lg">

                <div class="sidebar-content">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="font-weight-bold">Riwayat</h5>
                        </div>

                        <div class="card-body">
                            <div class="list-feed">
                                <div class="list-feed-item">
                                    <a href="#">David Linner</a> requested refund for a double bank card charge
                                    <div class="text-muted">Jan 12, 12:47</div>
                                </div>

                                <div class="list-feed-item">
                                    User <a href="#">Christopher Wallace</a> from Google is awaiting for staff reply
                                    <div class="text-muted">Jan 11, 10:25</div>
                                </div>

                                <div class="list-feed-item">
                                    Ticket <strong>#43683</strong> has been resolved by <a href="#">Victoria Wilson</a>
                                    <div class="text-muted">Jan 10, 09:37</div>
                                </div>

                                <div class="list-feed-item">
                                    <a href="#">Eugene Kopyov</a> merged <strong>Master</strong>, <strong>Demo</strong> and <strong>Dev</strong> branches
                                    <div class="text-muted">Jan 9, 08:28</div>
                                </div>

                                <div class="list-feed-item">
                                    All sellers have received payouts for December, 2016!
                                    <div class="text-muted">Jan 8, 07:58</div>
                                </div>

                                <div class="list-feed-item">
                                    <a href="#">Chris Arney</a> created a new ticket <strong>#43136</strong> and assigned to <a href="#">John Nod</a>
                                    <div class="text-muted">Jan 7, 06:32</div>
                                </div>
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