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
        'sekretariat dprd' => 'Sekretariat DPRD',
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
            route('institute.index') => 'Perangkat Daerah',
            'Daftar' => TRUE
        ];

        $institutes = Institute::sorted($request->only(['order', 'sort']));

        $institutes = $institutes->search($request->only(['search']));
        $count = $institutes->count();
        $limit = !empty($request->limit) ? $request->limit : $this->limit;
        $institutes = $institutes->paginate($limit)
                    ->withQueryString();

        $plugins = [
            'assets/js/plugins/notifications/bootbox.min.js',
            'assets/js/plugins/forms/selects/select2.min.js',
        ];

        return view('institute.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'institutes',
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
        $pageHeader = 'Tambah Perangkat Daerah';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            route('institute.index') => 'Perangkat Daerah',
            'Tambah' => TRUE
        ];
        
        $categories = $this->categories;
        $correctors = User::bagianHukum()->sorted()->pluck('name', 'id');
        $operators = User::opd()->sorted()->pluck('name', 'id');

        $plugins = [
            'assets/js/plugins/forms/selects/select2.min.js',
        ];

        return view('institute.create', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'correctors',
            'categories',
            'operators',
            'plugins'
        ));
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
        $pageHeader = 'Ubah Perangkat Daerah';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            route('institute.index') => 'Perangkat Daerah',
            'Ubah' => TRUE
        ];
        
        $categories = $this->categories;
        $correctors = User::bagianHukum()->sorted()->pluck('name', 'id');

        $plugins = [
            'assets/js/plugins/forms/selects/select2.min.js',
        ];

        return view('institute.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'institute',
            'categories',
            'correctors',
            'plugins'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function update(InstituteRequest $request, Institute $institute)
    {        
        $validated = $request->validated();
        $institute->update($validated);

        return redirect('/institute')->with('message', '<strong>Berhasil!</strong> Data Perangkat Daerah telah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institute $institute)
    {        
        $institute->delete();

        return redirect('/institute')->with('message', '<strong>Berhasil!</strong> Data Perangkat Daerah telah berhasil dihapus');
    }
}
