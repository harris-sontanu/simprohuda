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

        $legislations = Legislation::inProgress()
							->year($request->only(['year']))
							->take(5)
							->get();

        $vendors = [
            'assets/js/vendor/forms/selects/select2.min.js',
            'assets/js/vendor/visualization/echarts/echarts.min.js',
			'assets/js/vendor/visualization/d3/d3.min.js',
			'assets/js/vendor/visualization/d3/d3_tooltip.js',
        ];

        return view('dashboard.index', compact(
            'pageTitle', 
            'pageHeader', 
            'total', 
            'totalPerda',
            'totalPerbup',
            'totalSk',
            'legislations',
            'vendors',
        ));
    }

    public function pieChart(Request $request)
	{	
        $draft 		= Legislation::draft()->year($request->only(['year']))->count();
        $posted 	= Legislation::posted()->year($request->only(['year']))->count();
        $revised 	= Legislation::revised()->year($request->only(['year']))->count();
        $validated 	= Legislation::validated()->year($request->only(['year']))->count();

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
