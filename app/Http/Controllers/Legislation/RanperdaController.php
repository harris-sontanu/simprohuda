<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Legislation\LegislationController;
use App\Models\Institute;
use App\Models\Legislation;
use App\Models\Type;
use App\Models\Requirement;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RanperdaRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class RanperdaController extends LegislationController
{
    protected $type;

    public function __construct()
    {
        $this->type = Type::where('slug', 'ranperda')->first();
        $this->authorizeResource(Legislation::class, 'ranperda');
    }
    
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
            $this->type->name => TRUE
        ];

        $legislations = Legislation::ranperda();

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

        if (Gate::allows('isBagianHukum')) {
            $institutes = Institute::where('corrector_id', Auth::user()->id)->sorted()->pluck('name', 'id');
        } else if (Gate::allows('isAdmin')) {
            $institutes = Institute::sorted()->pluck('name', 'id');
        } else {
            $institutes = null;
        }

        $users = User::orderBy('name')->pluck('name', 'id');

        $plugins = [
            'assets/js/plugins/notifications/bootbox.min.js',
            'assets/js/plugins/forms/selects/select2.min.js',
            'assets/js/plugins/ui/moment/moment.min.js',
            'assets/js/plugins/pickers/daterangepicker.js',
            'assets/js/plugins/table/finderSelect/jquery.finderSelect.min.js',
        ];

        return view('legislation.ranperda.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'legislations',
            'tabFilters',
            'onlyTrashed',
            'count',
            'institutes',
            'users',
            'plugins'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Legislation::ranperda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Legislation::ranperda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'aktif'     => Legislation::ranperda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->posted()
                                ->count(),
            'revisi'    => Legislation::ranperda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->revised()
                                ->count(),
            'valid'     => Legislation::ranperda()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->validated()
                                ->count(),
            'batal'     => Legislation::ranperda()
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

        $message = 'data Rancangan Peraturan Daerah telah berhasil diperbarui';
        foreach ($ids as $id)
        {
            $legislation = Legislation::withTrashed()->find($id);
            if ($request->action === 'trash')
            {
                $legislation->delete();
                $message = 'data Rancangan Peraturan Daerah telah berhasil dibatalkan';

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'membatalkan ranperda',
                ]);
            }
            else if ($request->action === 'delete')
            {
                $legislation->forceDelete();
                $message = 'data Rancangan Peraturan Daerah telah berhasil dihapus';

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'menghapus ranperda',
                ]);
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
            route('legislation.ranperda.index') => $this->type->name,
            'Pengajuan' => true
        ];

        $nextRegNumber = $this->nextRegNumber($this->type->id, now()->translatedFormat('Y'));
        $nextRegNumber = Str::padLeft($nextRegNumber, 4, '0');
        $master = Requirement::master($this->type->id)->first();
        $requirements = Requirement::requirements($this->type->id)->get();

        if (Gate::allows('isBagianHukum')) {
            $institutes = Institute::where('corrector_id', Auth::user()->id)->sorted()->pluck('name', 'id');
        } else if (Gate::allows('isAdmin')) {
            $institutes = Institute::sorted()->pluck('name', 'id');
        } else {
            $institutes = null;
        }

        $plugins = [
            'assets/js/plugins/forms/selects/select2.min.js',
        ];

        return view('legislation.ranperda.create', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'nextRegNumber',
            'institutes',
            'master',
            'requirements',
            'plugins'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RanperdaRequest $request)
    {
        $validated = $request->validated();

        $validated['type_id'] = $this->type->id;
        $validated['reg_number'] = $this->nextRegNumber($this->type->id, now()->translatedFormat('Y'));

        $msg_append = 'sebagai Draf';
        if ($request->has('post')) 
        {
            $validated['posted_at'] = now();
            $msg_append = 'dan diajukan ke Bagian Hukum';
        }

        $new_legislation = $request->user()->legislations()->create($validated);

        $new_legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'membuat ranperda ' . $msg_append,
        ]);

        $this->documentUpload($new_legislation, $request);

        return redirect('/legislation/ranperda')->with('message', '<strong>Berhasil!</strong> Data Rancangan Peraturan Daerah telah berhasil disimpan ' . $msg_append);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function show(Legislation $legislation)
    {
        $pageHeader = 'Detail Rancangan Peraturan Daerah';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('legislation.ranperda.index') => $legislation->type->name,
            'Detail' => true
        ];

        $requirements = Requirement::requirements($legislation->type_id)->get();
        $master = Document::requirements($legislation->id)->first();
        $documents = Document::requirements($legislation->id)->get();

        return view('legislation.ranperda.show', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'legislation',
            'requirements',
            'master',
            'documents',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function edit(Legislation $legislation)
    {
        if ($legislation->status() === 'validated') {
            abort(403);
        }

        $pageHeader = 'Perbaikan Rancangan Peraturan Daerah';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('legislation.ranperda.index') => $this->type->name,
            'Perbaikan' => true
        ];
        
        $requirements = Requirement::mandatory($this->type->id)->get();
        $documents = Document::requirements($legislation->id)->get();

        $validateButton = true;
        foreach ($requirements as $requirement) {
            $requiredDocument = Document::where('legislation_id', $legislation->id)
                                    ->where('requirement_id', $requirement->id)
                                    ->first();

            if (empty($requiredDocument) OR empty($requiredDocument->validated_at)) {
                $validateButton = false;
            } 
        }

        $plugins = [
            'assets/js/plugins/notifications/bootbox.min.js',
            'assets/js/plugins/forms/selects/select2.min.js',
        ];

        return view('legislation.ranperda.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'requirements',
            'documents',
            'legislation',
            'validateButton',
            'plugins',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function update(RanperdaRequest $request, Legislation $legislation)
    {
        $validated = $request->validated(); 
        $log_messsage = 'memperbaiki data ranperda';  
        
        if ($request->has('post')) 
        {
            $validated['posted_at'] = now();
            $legislation->documents()->update(['posted_at' => now()]);
            $log_messsage = 'memperbaiki data ranperda dan mengajukan ke Bagian Hukum';
        } 
        else if ($request->has('revise')) 
        {
            $validated['revised_at'] = now();
        }  
        $legislation->update($validated);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => $log_messsage,
        ]);

        return redirect('/legislation/ranperda/' . $legislation->id . '/edit')->with('message', '<strong>Berhasil!</strong> Data Pengajuan Rancangan Peraturan Daerah telah berhasil diperbarui');
    }

    public function approve(Request $request, Legislation $legislation)
    {
        $this->authorize('approve', $legislation);
        $legislation->update(['validated_at' => now()]);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'memvalidasi pengajuan ranperda',
        ]);

        return redirect('/legislation/ranperda/' . $legislation->id . '/edit')->with('message', '<strong>Berhasil!</strong> Data Pengajuan Rancangan Peraturan Daerah telah berhasil divalidasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Legislation $legislation)
    {
        $action = route('legislation.ranperda.restore', $legislation->id);
        $legislation->delete();

        $legislation->logs()->create([
            'user_id'   => Auth::user()->id,
            'message'   => 'membatalkan ranperda',
        ]);

        return redirect('/legislation/ranperda')->with('trash-message', ['<strong>Berhasil!</strong> Data Rancangan Peraturan Daerah telah dibatalkan', $action]);
    }

    public function restore($id)
    {
        $legislation = Legislation::withTrashed()->findOrFail($id);
        $legislation->restore();

        $legislation->logs()->create([
            'user_id'   => Auth::user()->id,
            'message'   => 'mengembalikan ranperda',
        ]);

        return redirect()->back()->with('message', 'Data Rancangan Peraturan Daerah telah dikembalikan');
    }

    public function forceDestroy($id)
    {
        $legislation = Legislation::withTrashed()->findOrFail($id);
        $legislation->forceDelete();

        $legislation->logs()->create([
            'user_id'   => Auth::user()->id,
            'message'   => 'menghapus ranperda',
        ]);

        foreach ($legislation->documents as $document) {
            $this->removeDocument($document->path);
        }

        return redirect('/admin/legislation/ranperda?tab=batal')->with('message', '<strong>Berhasil!</strong> Data Rancangan Peraturan Daerah telah berhasil dihapus');
    }
}