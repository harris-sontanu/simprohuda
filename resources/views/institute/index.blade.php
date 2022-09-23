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
                                        <a href="{{ route('institute.index', ['order' => 'total', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Total</a>
                                    </th>
                                    <th class="@php echo (!empty($sort) AND Request::get('order') == 'operator') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                        <a href="{{ route('institute.index', ['order' => 'operator', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Operator</a>
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
                                        <td class="text-center"><span class="badge badge-dark badge-pill">0</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <img src="{{ $institute->userPictureUrl($institute->operator->picture, $institute->operator->name) }}" alt="{{ $institute->operator->name }}" class="rounded-circle" width="32" height="32">
                                                </div>
                                                <div class="div"><span class="font-weight-bold">{{ $institute->operator->name }}</span></div>
                                            </div>
                                        </td>
                                        <td class="safezone">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-light btn-sm rounded-pill rounded-right-0" data-toggle="modal" data-target="#edit-modal" data-id="{{ $institute->id }}" data-name="{{ $institute->name }}"><i class="icon-pencil"></i></button>
                                                <form class="delete-form" action="{{ route('institute.destroy', $institute->id) }}" data-name="{{ $institute->name; }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-light btn-sm rounded-pill rounded-left-0 border-left-0 delete"><i class="icon-cross2"></i></button>
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

            <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right border-0 shadow-none order-1 order-lg-2 sidebar-expand-lg">

                <div class="sidebar-content">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title font-weight-bold">Tambah Perangkat Daerah</h5>
                        </div>
                        <div class="card-body">

                            <form action="{{ route('institute.store') }}" method="post" novalidate>
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="font-weight-semibold">Nama:</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="abbrev" class="font-weight-semibold">Singkatan:</label>
                                    <input id="abbrev" type="text" class="form-control @error('abbrev') is-invalid @enderror" name="abbrev" value="{{ old('abbrev') }}">
                                    @error('abbrev')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label for="code" class="font-weight-semibold">Kode:</label>
                                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="desc" class="font-weight-semibold">Deskripsi:</label>
                                    <textarea id="desc" rows="4" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ old('desc') }}</textarea>
                                    @error('desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-secondary">Simpan<i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                    
                        </div>
                    </div>
                </div>

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