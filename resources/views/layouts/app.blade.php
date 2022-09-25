<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="layout-static">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title', 'Dashboard - JDIH')</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    @isset ($styles)
        @foreach ($styles as $style)
            <link href="{{ asset($style) }}" rel="stylesheet" type="text/css">
        @endforeach
    @endisset
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	@isset($plugins)
        @foreach ($plugins as $plugin)
            <script src="{{ asset($plugin) }}"></script>
        @endforeach
    @endisset

	<script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('script')
	
	<script>
		$(function() {
			var $window = $(window),
				$html = $('#sidebar-main');

			console.log($window.width());

			function resize() {
				if ($window.width() > 960 && $window.width() < 1600) {
					console.log('sdasd');
					return $html.addClass('sidebar-main-resized');
				}

				$html.removeClass('sidebar-main-resized');
			}

			$window
				.resize(resize)
				.trigger('resize');
		});
	</script>
	<!-- /theme JS files -->

</head>

<body>

    @include('layouts.navbar')

    <!-- Page content -->
	<div class="page-content">

        @include('layouts.sidebar')

        <!-- Main content -->
		<div class="content-wrapper">

            @yield('content')

            @include('layouts.footer')

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    @yield('modal')

</body>
</html>
