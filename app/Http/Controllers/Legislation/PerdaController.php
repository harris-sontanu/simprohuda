<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Legislation\LegislationController;
use App\Models\Institute;
use App\Models\Legislation;
use Illuminate\Http\Request;
use App\Http\Requests\PerdaRequest;
use Illuminate\Support\Carbon;

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

        $institutes = Institute::sorted()->pluck('name', 'id');

        $plugins = [
            'assets/js/plugins/notifications/bootbox.min.js',
            'assets/js/plugins/forms/selects/select2.min.js',
            'assets/js/plugins/ui/moment/moment.min.js',
            'assets/js/plugins/pickers/daterangepicker.js',
            'assets/js/plugins/table/finderSelect/jquery.finderSelect.min.js',
        ];

        return view('legislation.perda.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'legislations',
            'tabFilters',
            'onlyTrashed',
            'count',
            'institutes',
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

    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $message = 'data Rancangan Produk Hukum telah berhasil diperbarui';
        foreach ($ids as $id)
        {
            $legislation = Legislation::withTrashed()->find($id);
            if ($request->action === 'trash')
            {
                $legislation->delete();
                $message = 'data Rancangan Produk Hukum telah berhasil dibatalkan';
            }
            else if ($request->action === 'delete')
            {
                $legislation->forceDelete();
                $message = 'data Rancangan Produk Hukum telah berhasil dihapus';
            }
        }

        $request->session()->flash('message', '<span class="badge badge-pill badge-success">' . $count . '</span> ' . $message);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Pengajuan Rancangan Peraturan Daerah';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('legislation.perda.index') => 'Ranperda',
            'Pengajuan' => true
        ];

        $institutes = Institute::sorted()->pluck('name', 'id');

        $plugins = [
            'assets/js/plugins/forms/selects/select2.min.js',
        ];

        return view('legislation.perda.create', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'institutes',
            'plugins'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerdaRequest $request)
    {
        $validated = $request->validated();

        $current_year = Carbon::now()->format('Y');
        $validated['type'] = 'perda';
        $validated['reg_number'] = $this->nextRegNumber('perda', $current_year);

        $msg_suffix = 'sebagai Draf';
        if ($request->has('post')) {
            $validated['posted_at'] = now();
            $msg_suffix = 'dan diajukan ke Bagian Hukum';
        }

        $new_legislation = Legislation::create($validated);

        $this->documentUpload($new_legislation, $request);

        return redirect('/legislation/perda')->with('message', '<strong>Berhasil!</strong> Data Rancangan Peraturan Daerah telah berhasil disimpan ' . $msg_suffix);
    }

    private function documentUpload($legislation, $request)
    {
        $file = $request->file('master');
        $currentTime = Carbon::now()->timestamp;

        $documentStorage = $this->documentStorage($legislation, 'master');
        $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $file->getClientOriginalExtension();    

        $path = $file->storeAs($documentStorage['path'], $file_name, 'public');
        
        $legislation->documents()->create([
            'type'  => 'master',
            'path'  => $path,
            'name'  => 'Ranperda',
        ]);

        if ($request->hasFile('attachment_file')) 
        {
            $files  = $request->file('attachment_file');
            $titles = $request->attachment_name;

            // Get the next order
            $currentOrder = $legislation->documents->where('type', 'attachment')->max('order');
            if (!empty($currentOrder)) {
                $i = $currentOrder + 1;
            } else {
                $i = 1;
            }
            
            $key = 0;
            foreach ($files as $attachment) {

                $documentStorage = $this->documentStorage($legislation, 'attachment', $i);    
                $file_name = $documentStorage['file_name'] . $currentTime . '.' . $attachment->getClientOriginalExtension();     

                $path = $attachment->storeAs($documentStorage['path'], $file_name, 'public');
                
                $legislation->documents()->create([
                    'type'  => 'attachment',
                    'order' => $i,
                    'path'  => $path,
                    'name'  => $titles[0],
                ]);

                $i++;
                $key++;
            }
        }
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
