@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('layouts.message')

        <div class="card">
            <div class="card-header card-header d-sm-flex py-sm-0">
                <div class="py-sm-3 mb-sm-0 mb-3">
                    <div class="form-control-feedback form-control-feedback-end">
                        <form action="{{ route('legislation.ranperbup.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari judul..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @include('legislation.ranperbup.feature')

            </div>

            <div id="filter-options" @empty (Request::get('filter')) style="display: none" @endempty>

                @include('legislation.ranperbup.filter')

            </div>

            @isset ($tabFilters)
                <div class="navbar navbar-expand-lg border-bottom py-2">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav flex-row flex-fill">
                            @foreach ($tabFilters as $key => $value)
                                @php $active = ((empty(Request::get('tab')) AND $key === 'total') OR Request::get('tab') == $key) ? ' active' : '' @endphp
                                <li class="nav-item me-1">
                                    <a href="{{ route('legislation.ranperbup.index', ['tab' => $key] + Request::all()) }}" class="navbar-nav-link rounded{{ $active }}">
                                        <span class="d-lg-inline-block ms-2">
                                            {{ Str::ucfirst($key) }}
                                            <span class="badge bg-indigo rounded-pill ms-auto ms-lg-2">{{ $value }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endforeach                     
                        </ul>
                        <div class="navbar-collapse collapse" id="profile_nav">
                            <ul class="navbar-nav ms-lg-auto mt-2 mt-lg-0">
                                <li class="nav-item dropdown ms-lg-1">
                                    <a href="#" class="navbar-nav-link rounded dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="ph-list-dashes"></i>
                                        <span class="d-none d-lg-inline-block ms-2">
                                            @if (!empty(Request::get('limit')) AND $limit = Request::get('limit'))
                                                {{ $limit }}
                                            @else
                                                25
                                            @endif
                                        </span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('legislation.ranperbup.index', ['limit' => 25] + Request::all()) }}" class="dropdown-item" data-rows="25">25</a>
                                        <a href="{{ route('legislation.ranperbup.index', ['limit' => 50] + Request::all()) }}" class="dropdown-item" data-rows="50">50</a>
                                        <a href="{{ route('legislation.ranperbup.index', ['limit' => 100] + Request::all()) }}" class="dropdown-item" data-rows="100">100</a>
                                        <a href="{{ route('legislation.ranperbup.index', ['limit' => 200] + Request::all()) }}" class="dropdown-item" data-rows="200">200</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endisset

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            @if (!empty(Request::get('sort')) AND $sort = Request::get('sort'))
                                @php $sortState = ($sort == 'asc') ? 'desc' : 'asc' @endphp
                            @else
                                @php $sortState = 'asc' @endphp
                            @endif
                            <th width="1"><input type="checkbox" /></th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'reg_number') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('legislation.ranperbup.index', ['order' => 'reg_number', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block"><abbr title="Nomor Urut Registrasi" data-bs-popup="tooltip">Nomor</abbr></a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'title') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('legislation.ranperbup.index', ['order' => 'title', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Judul</a>
                            </th>
                            @cannot('isOpd')                                
                                <th class="sorting @if (!empty($sort) AND Request::get('order') == 'institute') {{ 'sorting_' . $sort }} @endif">
                                    <a href="{{ route('legislation.ranperbup.index', ['order' => 'institute', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Perangkat Daerah</a>
                                </th>
                            @endcannot
                            <th>Status</th>
                            @if (in_array(Request::get('tab'), ['total', 'draf', 'aktif']))    
                            <th class="text-nowrap sorting @if (!empty($sort) AND Request::get('order') == 'created_at') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('legislation.ranperbup.index', ['order' => 'created_at', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Tgl. Dibuat</a>
                            </th>
                            @endif
                            @if (Request::get('tab') !== 'draf')                                
                                <th class="text-nowrap sorting @if (!empty($sort) AND Request::get('order') == 'posted_at') {{ 'sorting_' . $sort }} @endif">
                                    <a href="{{ route('legislation.ranperbup.index', ['order' => 'posted_at', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Tgl. Diajukan</a>
                                </th>
                            @endif
                            @if (in_array(Request::get('tab'), ['revisi', 'valid']))                                
                                <th class="text-nowrap sorting @if (!empty($sort) AND Request::get('order') == 'revised_at') {{ 'sorting_' . $sort }} @endif">
                                    <a href="{{ route('legislation.ranperbup.index', ['order' => 'revised_at', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Tgl. Revisi</a>
                                </th>
                            @endif
                            @if (Request::get('tab') === 'valid')                                
                                <th class="text-nowrap sorting @if (!empty($sort) AND Request::get('order') == 'posted_at') {{ 'sorting_' . $sort }} @endif">
                                    <a href="{{ route('legislation.ranperbup.index', ['order' => 'posted_at', 'sort' => $sortState] + Request::all()) }}" class="text-body d-block">Tgl. Valid</a>
                                </th>
                            @endif
                            <th class="text-center">Pengusul</th>
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($legislations as $legislation)
                            <tr>
                                <td><input type="checkbox" class="checkbox" data-item="{{ $legislation->id }}"></td>
                                <td>{{ $legislation->reg_number }}</td>
                                <td><span class="fw-semibold">{{ $legislation->title }}</span></td>
                                @cannot('isOpd')                                    
                                    <td>{{ $legislation->institute->name }}</td>
                                @endcannot
                                <td>{!! $legislation->statusBadge !!}</td>                                
                                @if (in_array(Request::get('tab'), ['total', 'draf', 'aktif'])) 
                                    <td><abbr data-bs-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->created_at, true) }}">{{ $legislation->dateFormatted($legislation->created_at) }}</abbr></td>
                                @endif
                                @if (Request::get('tab') !== 'draf')    
                                    <td><abbr data-bs-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->posted_at, true) }}">{{ $legislation->dateFormatted($legislation->posted_at) }}</abbr></td>
                                @endif
                                @if (in_array(Request::get('tab'), ['revisi', 'valid'])) 
                                    <td><abbr data-bs-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->revised_at, true) }}">{{ $legislation->dateFormatted($legislation->revised_at) }}</abbr></td>
                                @endif
                                @if (Request::get('tab') === 'valid') 
                                    <td><abbr data-bs-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->validated_at, true) }}">{{ $legislation->dateFormatted($legislation->validated_at) }}</abbr></td>
                                @endif
                                <td class="text-center">
                                    <a href="#" data-bs-popup="tooltip" title="{{ $legislation->user->name }}">
                                        <img src="{{ $legislation->userPictureUrl($legislation->user->picture, $legislation->user->name) }}" alt="{{ $legislation->user->name }}" class="rounded-circle" width="32" height="32">
                                    </a>
                                </td>
                                <td class="text-center safezone">
                                    <div class="d-inline-flex">
                                        <a href="{{ route('legislation.ranperbup.show', $legislation->id) }}" class="text-body" data-bs-popup="tooltip" title="Pratinjau"><i class="ph-eye"></i></a>
                                        @if ($onlyTrashed)
                                            <form action="{{ route('legislation.ranperbup.restore', $legislation->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0 text-body mx-2" data-bs-popup="tooltip" title="Kembalikan"><i class="ph-arrow-arc-left"></i></button>
                                            </form>
                                            <form class="delete-form" action="{{ route('legislation.ranperbup.force-destroy', $legislation->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0 text-body" data-bs-popup="tooltip" title="Hapus"><i class="ph-x"></i></button>
                                            </form>
                                        @else
                                            @if ($legislation->status() !== 'validated')  
                                                <a href="{{ route('legislation.ranperbup.edit', $legislation->id) }}" class="text-body mx-2" data-bs-popup="tooltip" title="Ubah"><i class="ph-pen"></i></a>
                                                <form action="{{ route('legislation.ranperbup.destroy', $legislation->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 text-body" data-bs-popup="tooltip" title="Buang"><i class="ph-trash"></i></button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                    {{ $legislations->links('layouts.pagination') }}
                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('script')
    @include('legislation.ranperbup.script')
@endsection
