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
                        <form action="{{ route('institute.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari nama, jenis..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>    
                @can('create', App\Models\Institute::class)                   
                    <div class="ms-sm-auto my-sm-auto">
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('institute.create') }}" class="btn btn-indigo"><i class="ph-plus me-2"></i>Tambah</a>
                        </div>
                    </div>    
                @endcan
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            @if (!empty(Request::get('sort')) AND $sort = Request::get('sort'))
                                @php $sortState = ($sort == 'asc') ? 'desc' : 'asc' @endphp
                            @else
                                @php $sortState = 'asc' @endphp
                            @endif

                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'name') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('institute.index', ['order' => 'name', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Nama</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'abbrev') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('institute.index', ['order' => 'abbrev', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Singkatan</a>
                            </th>
                            <th>Operator</th>
                            <th class="text-center sorting @if (!empty($sort) AND Request::get('order') == 'total') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('institute.index', ['order' => 'total', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block"><abbr data-bs-popup="tooltip" title="Total Rancangan yang diusulkan">Total</abbr></a>
                            </th>
                            <th class="text-center sorting @if (!empty($sort) AND Request::get('order') == 'corrector') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('institute.index', ['order' => 'corrector', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Pemeriksa</a>
                            </th>
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @forelse ($institutes as $institute)
                            <tr>
                                <td>
                                    <span class="fw-semibold d-block">{{ $institute->name }}</span>
                                    <span class="text-muted fs-sm">{{ $institute->category }}</span>
                                </td>
                                <td>{{ $institute->abbrev }}</td>
                                <td>
                                    @foreach ($institute->users as $user)
                                        <a href="#" class="me-1" data-bs-popup="tooltip" title="{{ $user->name }}">
                                            <img src="{{ $institute->userPictureUrl($user->picture, $user->name) }}" alt="{{ $user->name }}" class="rounded-circle" width="32" height="32">
                                        </a>
                                    @endforeach
                                </td>
                                <td class="text-center"><span class="badge bg-indigo rounded-pill">{{ $institute->legislations->count() }}</span></td>
                                <td class="text-center">
                                    <a href="#" data-bs-popup="tooltip" title="{{ $institute->corrector->name }}">
                                        <img src="{{ $institute->userPictureUrl($institute->corrector->picture, $institute->corrector->name) }}" alt="{{ $institute->corrector->name }}" class="rounded-circle" width="32" height="32">
                                    </a>
                                </td>
                                <td class="text-center safezone">
                                    <div class="d-inline-flex">
                                        @can('update', $institute)                                            
                                            <a href="{{ route('institute.edit', $institute->id) }}" class="text-body" data-bs-popup="tooltip" title="Ubah"><i class="ph-pen"></i></a>
                                        @endcan
                                        @can('delete', $institute)   
                                            <form class="delete-form" action="{{ route('institute.destroy', $institute->id) }}" data-name="{{ $institute->name; }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-link text-body p-0 ms-2 delete" data-bs-popup="tooltip" title="Hapus"><i class="ph-x"></i></button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                    {{ $institutes->links('layouts.pagination') }}
                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('layouts.modal')
@endsection

@section('script')
    @include('institute.script')
@endsection 