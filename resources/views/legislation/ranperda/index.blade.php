@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('layouts.message')

        <div class="card">
            <div class="card-header header-elements-sm-inline">
                <div class="card-title">
                    <div class="form-group-feedback form-group-feedback-left">
                        <form action="{{ route('legislation.ranperda.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari judul, perangkat daerah..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback">
                                <i class="icon-search4 opacity-50 font-size-base"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @include('legislation.ranperda.feature')

            </div>

            <div id="filter-options" @empty (Request::get('filter')) style="display: none" @endempty>

                @include('legislation.ranperda.filter')

            </div>

            @isset ($tabFilters)
                <div class="card-body p-0 border-top">
                    <ul class="nav nav-tabs nav-tabs-bottom mb-0 border-bottom-0">
                        @foreach ($tabFilters as $key => $value)
                            @php $active = ((empty(Request::get('tab')) AND $key === 'total') OR Request::get('tab') == $key) ? ' active' : '' @endphp
                            <li class="nav-item">
                                <a href="{{ route('legislation.ranperda.index', ['tab' => $key] + Request::all()) }}" class="nav-link{{ $active }}">
                                    {{ Str::ucfirst($key) }}<span class="badge badge-secondary badge-pill ml-2">{{ $value }}</span>
                                </a>
                            </li>
                        @endforeach
                        <li class="nav-item dropdown ml-lg-auto">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">Show
                                <span class="badge badge-pill badge-secondary ml-2">
                                    @if (!empty(Request::get('limit')) AND $limit = Request::get('limit'))
                                        {{ $limit }}
                                    @else
                                        25
                                    @endif
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="min-width: 5rem">
                                <a href="{{ route('user.index', ['limit' => 25] + Request::all()) }}" class="dropdown-item" data-rows="25">25</a>
                                <a href="{{ route('user.index', ['limit' => 50] + Request::all()) }}" class="dropdown-item" data-rows="50">50</a>
                                <a href="{{ route('user.index', ['limit' => 100] + Request::all()) }}" class="dropdown-item" data-rows="100">100</a>
                                <a href="{{ route('user.index', ['limit' => 200] + Request::all()) }}" class="dropdown-item" data-rows="200">200</a>
                            </div>
                        </li>
                    </ul>
                </div>
            @endisset

            <div class="table-responsive">
                <table class="table table-xs table-striped">
                    <thead>
                        <tr class="bg-light">
                            @if (!empty(Request::get('sort')) AND $sort = Request::get('sort'))
                                @php $sortState = ($sort == 'asc') ? 'desc' : 'asc' @endphp
                            @else
                                @php $sortState = 'asc' @endphp
                            @endif
                            <th width="1"><input type="checkbox" /></th>
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'reg_number') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('legislation.ranperda.index', ['order' => 'reg_number', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block"><abbr title="Nomor Urut Registrasi" data-popup="tooltip">Nomor</abbr></a>
                            </th>
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'title') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('legislation.ranperda.index', ['order' => 'title', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Judul</a>
                            </th>
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'institute') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('legislation.ranperda.index', ['order' => 'institute', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Perangkat Daerah</a>
                            </th>
                            <th>Status</th>
                            @if (in_array(Request::get('tab'), ['total', 'draf', 'aktif']))    
                            <th class="text-nowrap @php echo (!empty($sort) AND Request::get('order') == 'created_at') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('legislation.ranperda.index', ['order' => 'created_at', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Tgl. Dibuat</a>
                            </th>
                            @endif
                            @if (Request::get('tab') !== 'draf')                                
                                <th class="text-nowrap @php echo (!empty($sort) AND Request::get('order') == 'posted_at') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                    <a href="{{ route('legislation.ranperda.index', ['order' => 'posted_at', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Tgl. Diajukan</a>
                                </th>
                            @endif
                            @if (in_array(Request::get('tab'), ['revisi', 'valid']))                                
                                <th class="text-nowrap @php echo (!empty($sort) AND Request::get('order') == 'revised_at') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                    <a href="{{ route('legislation.ranperda.index', ['order' => 'revised_at', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Tgl. Revisi</a>
                                </th>
                            @endif
                            @if (Request::get('tab') === 'valid')                                
                                <th class="text-nowrap @php echo (!empty($sort) AND Request::get('order') == 'posted_at') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                    <a href="{{ route('legislation.ranperda.index', ['order' => 'posted_at', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Tgl. Valid</a>
                                </th>
                            @endif
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($legislations as $legislation)
                            <tr>
                                <td><input type="checkbox" class="checkbox" data-item="{{ $legislation->id }}"></td>
                                <td>{{ $legislation->reg_number }}</td>
                                <td><span class="font-weight-semibold">{{ $legislation->title }}</span></td>
                                <td>{{ $legislation->institute->name }}</td>
                                <td>{!! $legislation->statusBadge !!}</td>                                
                                @if (in_array(Request::get('tab'), ['total', 'draf', 'aktif'])) 
                                    <td><abbr data-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->created_at, true) }}">{{ $legislation->dateFormatted($legislation->created_at) }}</abbr></td>
                                @endif
                                @if (Request::get('tab') !== 'draf')    
                                    <td><abbr data-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->posted_at, true) }}">{{ $legislation->dateFormatted($legislation->posted_at) }}</abbr></td>
                                @endif
                                @if (in_array(Request::get('tab'), ['revisi', 'valid'])) 
                                    <td><abbr data-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->revised_at, true) }}">{{ $legislation->dateFormatted($legislation->revised_at) }}</abbr></td>
                                @endif
                                @if (Request::get('tab') === 'valid') 
                                    <td><abbr data-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->validated_at, true) }}">{{ $legislation->dateFormatted($legislation->validated_at) }}</abbr></td>
                                @endif
                                <td class="text-center safezone">
                                    <div class="list-icons">
                                        <a href="#" class="list-icons-item" data-popup="tooltip" title="Pratinjau" data-toggle="modal" data-target="#show-modal" data-id="{{ $legislation->id }}"><i class="icon-eye"></i></a>
                                        @if ($onlyTrashed)
                                            <form action="{{ route('legislation.ranperda.restore', $legislation->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button type="submit" class="btn btn-link list-icons-item p-0" data-popup="tooltip" title="Kembalikan"><i class="icon-undo2"></i></button>
                                            </form>
                                            <form class="delete-form" action="{{ route('legislation.ranperda.force-destroy', $legislation->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-link list-icons-item p-0" data-popup="tooltip" title="Hapus"><i class="icon-cross2"></i></button>
                                            </form>
                                        @else
                                            <a href="{{ route('legislation.ranperda.edit', $legislation->id) }}" data-popup="tooltip" title="Ubah" class="list-icons-item"><i class="icon-pencil"></i></a>
                                            <form action="{{ route('legislation.ranperda.destroy', $legislation->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-link list-icons-item p-0" data-popup="tooltip" title="Batal"><i class="icon-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="100">
                                <div class="d-flex justify-content-between">
                                    <div class="align-self-center">Total: <span class="badge badge-secondary badge-pill mr-2">{{ $count }}</span></div>
                                    {{ $legislations->links() }}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('script')
    @include('legislation.ranperda.script')
@endsection
