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
                        <form action="{{ route('user.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari nama, email..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback">
                                <i class="icon-search4 opacity-50 font-size-base"></i>
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
                <div class="card-body p-0 border-top">
                    <ul class="nav nav-tabs nav-tabs-bottom mb-0 border-bottom-0">
                        @foreach ($tabFilters as $key => $value)
                            @php $active = ((empty(Request::get('tab')) AND $key === 'all') OR Request::get('tab') == $key) ? ' active' : '' @endphp
                            <li class="nav-item">
                                <a href="{{ route('user.index', ['tab' => $key] + Request::all()) }}" class="nav-link{{ $active }}">
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
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'name') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('user.index', ['order' => 'name', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Nama</a>
                            </th>
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'email') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('user.index', ['order' => 'email', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Email</a>
                            </th>
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'role') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('user.index', ['order' => 'role', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Level</a>
                            </th>
                            <th>Status</th>
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'last_logged_in_at') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('user.index', ['order' => 'last_logged_in_at', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Login Terakhir</a>
                            </th>
                            <th class="@php echo (!empty($sort) AND Request::get('order') == 'created_at') ? 'sorting_' . $sort : 'sorting'; @endphp">
                                <a href="{{ route('user.index', ['order' => 'created_at', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Terdaftar</a>
                            </th>
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td><input type="checkbox" class="checkbox" data-item="{{ $user->id }}"></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <img src="{{ $user->userPictureUrl($user->picture, $user->name) }}" alt="{{ $user->name }}" class="rounded-circle" width="32" height="32">
                                        </div>
                                        <div class="div"><span class="font-weight-bold">{{ $user->name }}</span></div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ Str::ucfirst($user->role) }}</td>
                                <td>{!! $user->statusBadgeHtml !!}</td>
                                <td><abbr data-popup="tooltip" title="{{ $user->dateFormatted($user->last_logged_in_at, true) }}">{{ $user->dateFormatted($user->last_logged_in_at) }}</abbr></td>
                                <td><abbr data-popup="tooltip" title="{{ $user->dateFormatted($user->created_at, true) }}">{{ $user->dateFormatted($user->created_at) }}</abbr></td>
                                <td class="safezone">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-light btn-sm rounded-pill rounded-right-0" data-toggle="modal" data-target="#show-modal" data-id="{{ $user->id }}" data-name="{{ $user->name }}"><i class="icon-eye2"></i></button>
                                        <button type="button" class="btn btn-light btn-sm dropdown-toggle rounded-pill rounded-left-0" data-toggle="dropdown"></button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if ($onlyTrashed)
                                                <form action="{{ route('user.restore', $user->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" class="dropdown-item"><i class="icon-undo"></i> Restore</button>
                                                </form>
                                                <form class="delete-form" action="{{ route('user.force-destroy', $user->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" title="Hapus"><i class="icon-cross2"></i> Hapus</button>
                                                </form>
                                            @else
                                                <a href="{{ route('user.edit', $user->id) }}" class="dropdown-item"><i class="icon-pencil"></i> Ubah</a>
                                                @php $disabled = ($user->id == 1 OR $user->id == Auth::user()->id) ? 'disabled' : ''; @endphp
                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" {{ $disabled }} title="Hapus"><i class="icon-trash"></i> Buang</button>
                                                </form>
                                            @endif
                                        </div>
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
                                    {{ $users->links() }}
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
    @include('user.show_modal')
    @include('user.create')
@endsection

@section('script')
    @include('user.script')
@endsection
