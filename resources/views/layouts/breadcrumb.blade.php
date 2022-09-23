<!-- Breadcrumb -->
<div class="page-header page-header-light">

	<div class="breadcrumb-line breadcrumb-line-light header-elements-sm-inline border-top-0">
		<div class="d-flex">
			<h3 class="breadcrumb-elements-item mb-0 font-weight-bold">{{ $pageHeader }}</h3>
			<a href="#" class="header-elements-toggle text-body d-sm-none"><i class="icon-more2"></i></a>
		</div>

		<div class="header-elements d-none">
            @isset($breadCrumbs)
                <div class="breadcrumb">
                    @foreach ($breadCrumbs as $key => $value)
                        @if ($value === TRUE)
                            <span class="breadcrumb-item active">{!! $key !!}</span>
                        @else
                            <a href="{{ $key }}" class="breadcrumb-item">{!! $value !!}</a>
                        @endif
                    @endforeach
                </div>
            @endisset
		</div>
	</div>
</div>
<!-- /breadcrumb -->
