@extends('layouts.app')

@section('title', $pageTitle)
@section('content')

@include('layouts.breadcrumb')

<!-- Content area -->
<div class="content">

	<div class="row">
		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="media">
					<div class="mr-3 align-self-center">
						<i class="icon-library2 icon-3x text-pink"></i>
					</div>

					<div class="media-body text-right">
						<h3 class="font-weight-semibold mb-0">{{ $total }}</h3>
						<span class="text-uppercase font-size-sm text-muted">total rancangan</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="media">
					<div class="mr-3 align-self-center">
						<i class="icon-stack2 icon-3x text-primary"></i>
					</div>

					<div class="media-body text-right">
						<h3 class="font-weight-semibold mb-0">{{ $totalPerda }}</h3>
						<span class="text-uppercase font-size-sm text-muted">total ranperda</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="media">
					<div class="media-body">
						<h3 class="font-weight-semibold mb-0">{{ $totalPerbup }}</h3>
						<span class="text-uppercase font-size-sm text-muted">total ranperbup</span>
					</div>

					<div class="ml-3 align-self-center">
						<i class="icon-archive icon-3x text-warning"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-xl-3">
			<div class="card card-body">
				<div class="media">
					<div class="media-body">
						<h3 class="font-weight-semibold mb-0">{{ $totalSk }}</h3>
						<span class="text-uppercase font-size-sm text-muted">total sk</span>
					</div>

					<div class="ml-3 align-self-center">
						<i class="icon-book3 icon-3x text-danger"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="d-lg-flex align-items-lg-start">            

		<div class="flex-1">

			<!-- Basic table -->
			<div class="card">
				<div class="card-header">
					<h5 class="card-title font-weight-bold">Rancangan Produk Hukum Terbaru</h5>
				</div>

				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr class="bg-light">
								<th><abbr title="Nomor Urut Registrasi" data-popup="tooltip">Nomor</abbr></th>
								<th>Jenis</th>
								<th>Judul</th>
								<th>Perangkat Daerah</th>
								<th>Tgl. Diajukan</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($legislations as $legislation)
								<tr>
									<td>{{ $legislation->reg_number }}</td>
									<td>{{ $legislation->type->name }}</td>
									<td>{{ $legislation->title }}</td>
									<td>{{ $legislation->institute->name }}</td>
									<td><abbr data-popup="tooltip" title="{{ $legislation->dateFormatted($legislation->posted_at, true) }}">{{ $legislation->dateFormatted($legislation->posted_at) }}</abbr></td>
								</tr>
							@empty
								
							@endforelse							
						</tbody>
					</table>
				</div>
			</div>
			<!-- /basic table -->

		</div>
            
		<div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right wmin-lg-350 border-0 shadow-none order-1 order-lg-2 sidebar-expand-lg">

			<div class="sidebar-content">

				<div class="card">
                    <div class="card-header">
                        <h5 class="card-title font-weight-bold">Status Rancangan</h6>
                    </div>
                    <div class="card-body">

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
