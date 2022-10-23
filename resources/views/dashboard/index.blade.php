@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

<!-- Breadcrumb -->
<div class="page-header">
    <div class="page-header-content d-lg-flex">
        <div class="d-flex">
            <h4 class="page-title mb-0">
                {{ $pageHeader }}
            </h4>

            <a href="#page_header" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
            <div class="btn-group my-auto ms-auto">
				<button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Tahun</button>

				<div class="dropdown-menu dropdown-menu-end">
					<a href="{{ route('dashboard', ['year' => 2022]) }}" class="dropdown-item">2022</a>
					<a href="{{ route('dashboard', ['year' => 2021]) }}" class="dropdown-item">2021</a>
					<a href="{{ route('dashboard', ['year' => 2020]) }}" class="dropdown-item">2020</a>
				</div>
			</div>
        </div>
    </div>
</div>

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
