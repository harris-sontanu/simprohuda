@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

    @include('layouts.breadcrumb')

    <!-- Content area -->
    <div class="content">

        @include('layouts.message')

        <div class="d-lg-flex align-items-lg-start">

            <div class="flex-1">

                <!-- Form -->
                <form id="post-form" method="POST" action="{{ route('legislation.perda.create') }}" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">

                                    <fieldset>
                                        <legend class="font-weight-bold"><i class="icon-reading mr-2"></i> Formulir Ranperda</legend>
                                        
                                        <div class="from-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="reg_number">Nomor Registrasi:</label>
                                            <div class="col-lg-9">
                                                <input type="text" id="reg_number" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="phone">Perangkat Daerah:</label>
                                            <div class="col-lg-9">
                                                <select name="institute_id" id="institute_id" class="select">
                                                    <option value="">Pilih Perangkat Daerah</option>
                                                    @foreach ($institutes as $key => $value)
                                                        <option value="{{ $key }}" @selected(old('institute_id') == $key)>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('institute_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="title">Judul:</label>
                                            <div class="col-lg-9">
                                                <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label font-weight-semibold" for="background">Alasan Pengajuan:</label>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" name="background" id="background" cols="30" rows="4" >{{ old('background') }}</textarea>
                                                @error('background')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </fieldset>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="sidebar sidebar-light sidebar-component sidebar-component-right sidebar-expand-lg">

                <div class="sidebar-content">
                    {{--  --}}
                </div>

            </div>

        </div>

    </div>
    <!-- /content area -->

@endsection

@section('script')
    @include('legislation.perda.script')
@endsection
