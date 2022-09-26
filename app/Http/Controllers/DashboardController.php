<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Legislation;

class DashboardController extends Controller
{
    public function index()
    {
        $pageHeader = 'Dasbor';
        $pageTitle = $pageHeader . $this->pageTitle;

        $total = Legislation::all()->count();
        $totalPerda = Legislation::perda()->count();
        $totalPerbup = Legislation::perbup()->count();
        $totalSk = Legislation::sk()->count();

        $legislations = Legislation::posted()
							->latest()
							->take(5)
							->get();

        $plugins = [
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
        $draft = Legislation::draft()->count();
        $posted = Legislation::posted()->count();
        $revised = Legislation::revised()->count();
        $validated = Legislation::validated()->count();

		$json = [
			[
				'status' => 'Draft', 
				'icon'	=> '<i class="status-mark border-blue position-left"></i>',
				'value' => $draft,
				'color' => '#03A9F4'
			],
			[
				'status' => 'Aktif', 
				'icon'	=> '<i class="status-mark border-orange position-left"></i>',
				'value' => $posted,
				'color' => '#FF9800'
			],
			[
				'status' => 'Revisi', 
				'icon'	=> '<i class="status-mark border-teal position-left"></i>',
				'value' => $revised,
				'color' => '#009688'
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
