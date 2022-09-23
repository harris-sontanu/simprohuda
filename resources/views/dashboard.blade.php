@extends('layouts.app')

@section('title', 'Dashboard - JDIH')
@section('content')

@include('layouts.breadcrumb')

<!-- Content area -->
<div class="content">

	<!-- Basic card -->
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">Basic card</h5>
		</div>

		<div class="card-body">
			<h6 class="font-weight-semibold">Start your development with no hassle!</h6>
			<p class="mb-3">Common problem of templates is that all code is deeply integrated into the core. This limits your freedom in decreasing amount of code, i.e. it becomes pretty difficult to remove unnecessary code from the project. Limitless allows you to remove unnecessary and extra code easily just by removing the path to specific LESS file with component styling. All plugins and their options are also in separate files. Use only components you actually need!</p>

			<h6 class="font-weight-semibold">What is this?</h6>
			<p class="mb-3">Starter kit is a set of pages, useful for developers to start development process from scratch. Each layout includes base components only: layout, page kits, color system which is still optional, bootstrap files and bootstrap overrides. No extra CSS/JS files and markup. CSS files are compiled without any plugins or components. Starter kit was moved to a separate folder for better accessibility.</p>

			<h6 class="font-weight-semibold">How does it work?</h6>
			<p>You open one of the starter pages, add necessary plugins, uncomment paths to files in components.less file, compile new CSS. That's it. I'd also recommend to open one of main pages with functionality you need and copy all paths/JS code from there to your new page, it's just faster and easier.</p>
		</div>
	</div>
	<!-- /basic card -->


	<!-- Basic table -->
	<div class="card">
		<div class="card-header">
			<h5 class="card-title">Basic table</h5>
		</div>

		<div class="card-body">
			Seed project includes the most basic components that can help you in development process - basic grid example, card, table and form layouts with standard components. Nothing extra. Easily turn on and off styles of different components in <code>_config.scss</code> file so that your CSS is always as clean as possible. Bootstrap components are always enabled though.
		</div>

		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>Eugene</td>
						<td>Kopyov</td>
						<td>@Kopyov</td>
					</tr>
					<tr>
						<td>2</td>
						<td>Victoria</td>
						<td>Baker</td>
						<td>@Vicky</td>
					</tr>
					<tr>
						<td>3</td>
						<td>James</td>
						<td>Alexander</td>
						<td>@Alex</td>
					</tr>
					<tr>
						<td>4</td>
						<td>Franklin</td>
						<td>Morrison</td>
						<td>@Frank</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- /basic table -->


	<!-- Form layouts -->
	<div class="row">
		<div class="col-lg-6">

			<!-- Horizontal form -->
			<div class="card">
				<div class="card-header header-elements-inline">
					<h5 class="card-title">Horizontal form</h5>
					<div class="header-elements">
						<div class="list-icons">
							<a class="list-icons-item" data-action="collapse"></a>
							<a class="list-icons-item" data-action="reload"></a>
							<a class="list-icons-item" data-action="remove"></a>
						</div>
					</div>
				</div>

				<div class="collapse show">
					<div class="card-body">
						<form action="#">
							<div class="form-group row">
								<label class="col-lg-3 col-form-label">Text input</label>
								<div class="col-lg-9">
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-3 col-form-label">Password</label>
								<div class="col-lg-9">
									<input type="password" class="form-control">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-3 col-form-label">Select</label>
								<div class="col-lg-9">
									<select name="select" class="custom-select">
										<option value="opt1">Basic select</option>
										<option value="opt2">Option 2</option>
										<option value="opt3">Option 3</option>
										<option value="opt4">Option 4</option>
										<option value="opt5">Option 5</option>
										<option value="opt6">Option 6</option>
										<option value="opt7">Option 7</option>
										<option value="opt8">Option 8</option>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-3 col-form-label">Textarea</label>
								<div class="col-lg-9">
									<textarea rows="5" cols="5" class="form-control" placeholder="Default textarea"></textarea>
								</div>
							</div>

							<div class="text-right">
								<button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /horizotal form -->

		</div>

		<div class="col-lg-6">

			<!-- Vertical form -->
			<div class="card">
				<div class="card-header header-elements-inline">
					<h5 class="card-title">Vertical form</h5>
					<div class="header-elements">
						<div class="list-icons">
							<a class="list-icons-item" data-action="collapse"></a>
							<a class="list-icons-item" data-action="reload"></a>
							<a class="list-icons-item" data-action="remove"></a>
						</div>
					</div>
				</div>

				<div class="collapse show">
					<div class="card-body">
						<form action="#">
							<div class="form-group">
								<label>Text input</label>
								<input type="text" class="form-control">
							</div>

							<div class="form-group">
								<label>Select</label>
								<select name="select" class="custom-select">
									<option value="opt1">Basic select</option>
									<option value="opt2">Option 2</option>
									<option value="opt3">Option 3</option>
									<option value="opt4">Option 4</option>
									<option value="opt5">Option 5</option>
									<option value="opt6">Option 6</option>
									<option value="opt7">Option 7</option>
									<option value="opt8">Option 8</option>
								</select>
							</div>

							<div class="form-group">
								<label>Textarea</label>
								<textarea rows="4" cols="4" class="form-control" placeholder="Default textarea"></textarea>
							</div>

							<div class="text-right">
								<button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /vertical form -->

		</div>
	</div>
	<!-- /form layouts -->

</div>
<!-- /content area -->

@endsection
