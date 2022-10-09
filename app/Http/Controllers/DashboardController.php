<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Legislation;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $pageHeader = 'Dasbor';
        $pageTitle = $pageHeader . $this->pageTitle;

        $total 		  = Legislation::year($request->only(['year']))->count();
        $totalPerda   = Legislation::ranperda()->year($request->only(['year']))->count();
        $totalPerbup  = Legislation::ranperbup()->year($request->only(['year']))->count();
        $totalSk 	  = Legislation::ransk()->year($request->only(['year']))->count();

        $legislations = Legislation::posted()
							->latest()
							->take(5)
							->get();

        $plugins = [
            'assets/js/plugins/forms/selects/select2.min.js',
            'assets/js/plugins/visualization/echarts/echarts.min.js',
			'assets/js/plugins/visualization/d3/d3.min.js',
			'assets/js/plugins/visualization/d3/d3_tooltip.js',
        ];

        return view('dashboard.index', compact(
            'pageTitle', 
            'pageHeader', 
            'total', 
            'totalPerda',
            'totalPerbup',
            'totalSk',
            'legislations',
            'plugins',
        ));
    }

    public function pieChart()
	{
        $draft 		= Legislation::draft()->count();
        $posted 	= Legislation::posted()->count();
        $revised 	= Legislation::revised()->count();
        $validated 	= Legislation::validated()->count();

		$json = [
			[
				'status' => 'Draft', 
				'icon'	=> '<i class="status-mark border-blue position-left"></i>',
				'value' => $draft,
				'color' => '#f35c86'
			],
			[
				'status' => 'Aktif', 
				'icon'	=> '<i class="status-mark border-orange position-left"></i>',
				'value' => $posted,
				'color' => '#03A9F4'
			],
			[
				'status' => 'Revisi', 
				'icon'	=> '<i class="status-mark border-teal position-left"></i>',
				'value' => $revised,
				'color' => '#f58646'
			],
			[
				'status' => 'Valid', 
				'icon'	=> '<i class="status-mark border-success position-left"></i>',
				'value' => $validated,
				'color' => '#4CAF50'
			],
		];

		return response()->json($json);
	}
}
