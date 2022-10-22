@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

<!-- Breadcrumb -->
{{-- <div class="page-header page-header-light">

	<div class="breadcrumb-line breadcrumb-line-light header-elements-sm-inline border-top-0 py-sm-0">
		<div class="d-flex">
			<h3 class="breadcrumb-elements-item mb-0 font-weight-bold">{{ $pageHeader }}</h3>
			<a href="#" class="header-elements-toggle text-body d-sm-none"><i class="icon-more2"></i></a>
		</div>

		<div class="header-elements">
			<form action="{{ route('dashboard') }}" method="get">
				<ul class="list-inline-condensed mb-0">
					<li class="list-inline-item">
						<select name="year" id="year" class="form-control select d-inline-block">
							<option value="">Pilih Tahun</option>
							<option value="2022" @selected(Request::get('year') == 2022)>2022</option>
							<option value="2021" @selected(Request::get('year') == 2021)>2021</option>
							<option value="2020" @selected(Request::get('year') == 2020)>2020</option>
						</select>
					</li>
					<li class="list-inline-item">
						<button type="submit" class="btn btn-secondary">OK</button>
					</li>
				</ul>				
			</form>
		</div>
	</div>
</div> --}}
<!-- /breadcrumb -->

<!-- Content area -->
<div class="content pt-0">

	<div class="row">
		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="d-flex align-items-center">
					<i class="ph-scales ph-2x text-success me-3"></i>

					<div class="flex-fill text-end">
						<h4 class="mb-0">{{ $total }}</h4>
						<span class="text-muted">Total Rancangan</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="d-flex align-items-center">
					<i class="ph-stack ph-2x text-indigo me-3"></i>

					<div class="flex-fill text-end">
						<h4 class="mb-0">{{ $totalPerda }}</h4>
						<span class="text-muted">Total Ranperda</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="d-flex align-items-center">
					<div class="flex-fill">
						<h4 class="mb-0">{{ $totalPerbup }}</h4>
						<span class="text-muted">Total Ranperbup</span>
					</div>

					<i class="ph-books ph-2x text-primary ms-3"></i>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="d-flex align-items-center">
					<div class="flex-fill">
						<h4 class="mb-0">{{ $totalSk }}</h4>
						<span class="text-muted">Total Rancangan SK</span>
					</div>

					<i class="ph-note ph-2x text-danger ms-3"></i>
				</div>
			</div>
		</div>
	</div>

	<!-- Inner container -->
	<div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

		<!-- Left content -->
		<div class="flex-1 order-2 order-lg-1">

			<!-- Basic table -->
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Pengajuan Rancangan Produk Hukum Terbaru</h5>
				</div>

				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th><abbr title="Nomor Urut Registrasi" data-bs-popup="tooltip">Nomor</abbr></th>
								<th>Jenis</th>
								<th>Judul</th>
								@cannot('isOpd')
									<th>Perangkat Daerah</th>
								@endcannot
								<th class="text-center">Status</th>
								<th>Tgl. Diajukan</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($legislations as $legislation)
								<tr>
									<td>{{ $legislation->reg_number }}</td>
									<td>{{ $legislation->type->name }}</td>
									<td><a href="{{ route('legislation.' . $legislation->type->slug . '.edit', $legislation->id) }}" class="fw-semibold text-body">{{ $legislation->title }}</a></td>
									@cannot('isOpd')
										<td>{{ $legislation->institute->name }}</td>
									@endcannot
									<td class="text-center">{!! $legislation->statusBadge !!}</td>
									<td><abbr data-bs-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->posted_at, true) }}">{{ $legislation->dateFormatted($legislation->posted_at) }}</abbr></td>
								</tr>
							@empty
								<tr class="table-warning"><td colspan="100">Belum ada data</td></tr>
							@endforelse							
						</tbody>
					</table>
				</div>
			</div>
			<!-- /basic table -->

		</div>
            
		<div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3">

			<div class="sidebar-content">

				<div class="card text-center">
                    <div class="sidebar-section-body">
						<h5 class="mb-3">Status Rancangan Produk Hukum</h5>

                        <div class="svg-center" id="donut_basic_details"></div>

                    </div>
                </div>

			</div>

		</div>
	</div>

</div>
<!-- /content area -->

@endsection

@section('script')
    @include('dashboard.script')
@endsection
