<!-- Footer -->
<div class="navbar navbar-sm navbar-footer border-top">
    <div class="container-fluid">
        <span>&copy; 
            @if (now()->year === 2022)
                2022
            @else
                2022 - {{ now()->year }}
            @endif 
            <a href="{{ $appUrl }}">{{ $appDesc . ' (' . $appName . ')' }}</a> oleh <a href="{{ $companyUrl }}" target="_blank">{{ $company }}</a>
        </span>

        <ul class="nav">
            <li class="nav-item">beta v1.2.0</li>
        </ul>
    </div>
</div>
<!-- /footer -->

