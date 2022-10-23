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
                        <form action="{{ route('user.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari nama, email..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @include('user.feature')

            </div>

            <div id="filter-options" @empty (Request::get('filter')) style="display: none" @endempty>

                @include('user.filter')

            </div>

            @isset ($tabFilters)
                <div class="navbar navbar-expand-lg border-bottom py-2">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav flex-row flex-fill">
                            @foreach ($tabFilters as $key => $value)
                                @php $active = ((empty(Request::get('tab')) AND $key === 'total') OR Request::get('tab') == $key) ? ' active' : '' @endphp
                                <li class="nav-item me-1">
                                    <a href="{{ route('user.index', ['tab' => $key] + Request::all()) }}" class="navbar-nav-link rounded{{ $active }}">
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
                                        <a href="{{ route('user.index', ['limit' => 25] + Request::all()) }}" class="dropdown-item" data-rows="25">25</a>
                                        <a href="{{ route('user.index', ['limit' => 50] + Request::all()) }}" class="dropdown-item" data-rows="50">50</a>
                                        <a href="{{ route('user.index', ['limit' => 100] + Request::all()) }}" class="dropdown-item" data-rows="100">100</a>
                                        <a href="{{ route('user.index', ['limit' => 200] + Request::all()) }}" class="dropdown-item" data-rows="200">200</a>
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
                            @can('isAdmin')                                
                                <th width="1"><input type="checkbox" /></th>
                            @endcan
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'name') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('user.index', ['order' => 'name', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Nama</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'email') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('user.index', ['order' => 'email', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Email</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'role') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('user.index', ['order' => 'role', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Level</a>
                            </th>
                            <th class="text-center">Status</th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'last_logged_in_at') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('user.index', ['order' => 'last_logged_in_at', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Login Terakhir</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'created_at') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('user.index', ['order' => 'created_at', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Terdaftar</a>
                            </th>
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                @can('isAdmin')                                    
                                    <td><input type="checkbox" class="checkbox" data-item="{{ $user->id }}"></td>
                                @endcan
                                <td>
                                    <div class="d-flex">
                                        <div class="d-block me-3">
                                            <img src="{{ $user->userPictureUrl($user->picture, $user->name) }}" alt="{{ $user->name }}" class="rounded-circle" width="32" height="32">
                                        </div>

                                        <div class="align-self-center">
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td class="text-center">{!! $user->statusBadgeHtml !!}</td>
                                <td><abbr data-bs-popup="tooltip" title="{{ $user->dateFormatted($user->last_logged_in_at, true) }}">{{ $user->dateFormatted($user->last_logged_in_at) }}</abbr></td>
                                <td><abbr data-bs-popup="tooltip" title="{{ $user->dateFormatted($user->created_at, true) }}">{{ $user->dateFormatted($user->created_at) }}</abbr></td>
                                <td class="text-center safezone">
                                    <div class="d-inline-flex">
                                        <a href="#" class="text-body" data-bs-popup="tooltip" title="Pratinjau" data-bs-toggle="modal" data-bs-target="#show-modal" data-id="{{ $user->id }}" data-name="{{ $user->name }}"><i class="ph-eye"></i></a>
                                        @if ($onlyTrashed)
                                            <form action="{{ route('user.restore', $user->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0 text-body mx-2" data-bs-popup="tooltip" title="Kembalikan"><i class="ph-arrow-arc-left"></i></button>
                                            </form>
                                            <form class="delete-form" action="{{ route('user.force-destroy', $user->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0 text-body" data-bs-popup="tooltip" title="Hapus"><i class="ph-x"></i></button>
                                            </form>
                                        @else
                                            @can('update', $user)
                                                <a href="{{ route('user.edit', $user->id) }}" class="text-body ms-2" data-bs-popup="tooltip" title="Ubah"><i class="ph-pen"></i></a>
                                            @endcan
                                            @php $disabled = ($user->id == 1 OR $user->id == Auth::user()->id) ? 'disabled' : ''; @endphp
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0 text-body ms-2" {{ $disabled }} data-bs-popup="tooltip" title="Buang"><i class="ph-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>
                    {{ $users->links('layouts.pagination') }}
                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('user.show_modal')
@endsection

@section('script')
    @include('user.script')
@endsection
