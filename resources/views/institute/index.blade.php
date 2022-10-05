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
                        <form action="{{ route('institute.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari nama, jenis..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback">
                                <i class="icon-search4 opacity-50 font-size-base"></i>
                            </div>
                        </form>
                    </div>
                </div>    
                <div class="header-elements">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('institute.create') }}" class="btn btn-secondary btn-sm"><i class="icon-plus22 mr-2"></i>Tambah</a>
                    </div>
                </div>    
            </div>

            <div class="table-responsive">
                <table class="table table-xs table-striped">
                    <thead>
                        <tr class="bg-light">
                            @if (!empty(Request::get('sort')) AND $sort = Request::get('sort'))
                                @php $sortState = ($sort == 'asc') ? 'desc' : 'asc' @endphp
                            @else
                                @php $sortState = 'asc' @endphp
                            @endif

                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'name') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('institute.index', ['order' => 'name', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Nama</a>
                            </th>
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'abbrev') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('institute.index', ['order' => 'abbrev', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Singkatan</a>
                            </th>
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'code') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('institute.index', ['order' => 'code', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Kode</a>
                            </th>
                            <th class="text-center @php echo (!empty($sort) AND Request::get('order') == 'total') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('institute.index', ['order' => 'total', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block"><abbr data-popup="tooltip" title="Total Rancangan yang diusulkan">Total</abbr></a>
                            </th>
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'corrector') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('institute.index', ['order' => 'corrector', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Pemeriksa</a>
                            </th>
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @forelse ($institutes as $institute)
                            <tr>
                                <td>
                                    <span class="font-weight-bold d-block">{{ $institute->name }}</span>
                                    <span class="text-muted">{{ $institute->category }}</span>
                                </td>
                                <td>{{ $institute->abbrev }}</td>
                                <td>{{ $institute->code }}</td>
                                <td class="text-center"><span class="badge badge-dark badge-pill">{{ $institute->legislations->count() }}</span></td>
                                <td>
                                    
                                    @empty ($institute->corrector)
                                        <button type="button" class="btn btn-icon btn-light btn-sm rounded-pill"><i class="icon-user-plus"></i></button>    
                                    @else 
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2">
                                                <img src="{{ $institute->userPictureUrl($institute->corrector->picture, $institute->corrector->name) }}" alt="{{ $institute->corrector->name }}" class="rounded-circle" width="32" height="32">
                                            </div>
                                            <div class="div">{{ $institute->corrector->name }}</div>
                                        </div>                                            
                                    @endempty
                                </td>
                                <td class="text-center safezone">
                                    <div class="list-icons">
                                        <a href="{{ route('institute.edit', $institute->id) }}" class="list-icons-item" data-popup="tooltip" title="Ubah"><i class="icon-pencil"></i></a>
                                        <form class="delete-form" action="{{ route('institute.destroy', $institute->id) }}" data-name="{{ $institute->name; }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-link list-icons-item p-0 delete" data-popup="tooltip" title="Hapus"><i class="icon-trash"></i></button>
                                        </form>
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
                                    {{ $institutes->links() }}
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

@section('modal')
    @include('layouts.modal')
@endsection

@section('script')
    @include('institute.script')
@endsection 