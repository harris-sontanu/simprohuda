<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\InstituteRequest;

class InstituteController extends Controller
{
    protected $categories = [
        'sekretariat daerah' => 'Sekretariat Daerah',
        'sekretariat dprd' => 'Sekertariat DPRD',
        'dinas' => 'Dinas',
        'lembaga teknis daerah' => 'Lembaga Teknis Daerah',
        'kecamatan' => 'Kecamatan',
        'kelurahan' => 'Kelurahan',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Perangkat Daerah';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Perangkat Daerah',
            'Daftar' => TRUE
        ];

        $institutes = Institute::sorted($request->only(['order', 'sort']));

        $institutes = $institutes->search($request->only(['search']));
        $count = $institutes->count();
        $limit = !empty($request->limit) ? $request->limit : $this->limit;
        $institutes = $institutes->paginate($limit)
                    ->withQueryString();
        
        $categories = $this->categories;
        $operators = User::opd()->sorted()->pluck('name', 'id');

        $plugins = [
            'assets/js/plugins/notifications/bootbox.min.js',
            'assets/js/plugins/forms/selects/select2.min.js',
        ];

        return view('institute.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'institutes',
            'categories',
            'operators',
            'count',
            'plugins'
        ));
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
    public function store(InstituteRequest $request)
    {
        $validated = $request->validated();
        Institute::create($validated);

        return redirect('/institute')->with('message', '<strong>Berhasil!</strong> Data Perangkat Daerah telah berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function show(Institute $institute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function edit(Institute $institute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institute $institute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institute $institute)
    {
        //
    }
}
