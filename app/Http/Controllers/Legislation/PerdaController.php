<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Legislation\LegislationController;
use App\Models\Legislation;
use Illuminate\Http\Request;

class PerdaController extends LegislationController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Rancangan Peraturan Daerah';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Ranperda' => TRUE
        ];

        $legislations = Legislation::perda();

        $onlyTrashed = FALSE;
        if ($tab = $request->tab)
        {
            if ($tab === 'batal') {
                $legislations->onlyTrashed();
                $onlyTrashed = TRUE;
            } else if ($tab === 'draf') {
                $legislations->draft();
            } else if ($tab === 'aktif') {
                $legislations->posted();
            } else if ($tab === 'perbaikan') {
                $legislations->repaired();
            } else if ($tab === 'revisi') {
                $legislations->revised();
            } else if ($tab === 'valid') {
                $legislations->validated();
            }
        }
        
        $legislations = $legislations->search($request->only(['search']));
        $legislations = $legislations->filter($request);
        $count = $legislations->count();
        !empty($request->order) ? $legislations->order($request) : $legislations->latest();
        $limit = !empty($request->limit) ? $request->limit : $this->limit;
        $legislations = $legislations->paginate($limit)
                    ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $plugins = [
            'assets/js/plugins/forms/selects/select2.min.js',
        ];

        return view('legislation.perda.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'legislations',
            'tabFilters',
            'onlyTrashed',
            'count',
            'plugins'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Legislation::perda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Legislation::perda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'aktif'     => Legislation::perda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->posted()
                                ->count(),
            'perbaikan' => Legislation::perda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->repaired()
                                ->count(),
            'revisi'    => Legislation::perda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->revised()
                                ->count(),
            'valid'     => Legislation::perda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->validated()
                                ->count(),
            'batal'     => Legislation::perda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->onlyTrashed()
                                ->count()
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function show(Legislation $legislation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function edit(Legislation $legislation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Legislation $legislation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Legislation $legislation)
    {
        //
    }
}
