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

        return view('dashboard', compact(
            'pageTitle', 
            'pageHeader', 
            'total', 
            'totalPerda',
            'totalPerbup',
            'totalSk'
        ));
    }
}
