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
use App\Http\Requests\RanperbupRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class RanperbupController extends LegislationController
{
    protected $type;

    public function __construct()
    {
        $this->type = Type::where('slug', 'ranperbup')->first();
        $this->authorizeResource(Legislation::class, 'ranperbup');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Rancangan Peraturan Bupati';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            $this->type->name => TRUE
        ];

        $legislations = Legislation::ranperbup();

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

        $vendors = [
            'assets/js/vendor/notifications/bootbox.min.js',
            'assets/js/vendor/forms/selects/select2.min.js',
            'assets/js/vendor/ui/moment/moment.min.js',
            'assets/js/vendor/pickers/daterangepicker.js',
            'assets/js/vendor/tables/finderSelect/jquery.finderSelect.min.js',
        ];

        return view('legislation.ranperbup.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'legislations',
            'tabFilters',
            'onlyTrashed',
            'count',
            'institutes',
            'users',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Legislation::ranperbup()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Legislation::ranperbup()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'aktif'     => Legislation::ranperbup()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->posted()
                                ->count(),
            'revisi'    => Legislation::ranperbup()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->revised()
                                ->count(),
            'valid'     => Legislation::ranperbup()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->validated()
                                ->count(),
            'batal'     => Legislation::ranperbup()
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

        $message = 'data Rancangan Peraturan Bupati telah berhasil diperbarui';
        foreach ($ids as $id)
        {
            $legislation = Legislation::withTrashed()->find($id);
            if ($request->action === 'trash')
            {
                $legislation->delete();
                $message = 'data Rancangan Peraturan Bupati telah berhasil dibatalkan';

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'membatalkan ranperbup',
                ]);
            }
            else if ($request->action === 'delete')
            {
                $legislation->forceDelete();
                $message = 'data Rancangan Peraturan Bupati telah berhasil dihapus';

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'menghapus ranperbup',
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
        $pageHeader = 'Pengajuan Rancangan Peraturan Bupati';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('legislation.ranperbup.index') => $this->type->name,
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

        $vendors = [
            'assets/js/vendor/forms/selects/select2.min.js',
        ];

        return view('legislation.ranperbup.create', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'nextRegNumber',
            'institutes',
            'master',
            'requirements',
            'vendors'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RanperbupRequest $request)
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
            'message'   => 'membuat ranperbup ' . $msg_append,
        ]);

        $this->documentUpload($new_legislation, $request);

        return redirect('/legislation/ranperbup')->with('message', '<strong>Berhasil!</strong> Data Rancangan Peraturan Bupati telah berhasil disimpan ' . $msg_append);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function show(Legislation $legislation)
    {
        $pageHeader = 'Detail Rancangan Peraturan Bupati';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('legislation.ranperbup.index') => $legislation->type->name,
            'Detail' => true
        ];

        $requirements = Requirement::requirements($legislation->type_id)->get();
        $master = Document::requirements($legislation->id)->first();
        $documents = Document::requirements($legislation->id)->get();

        return view('legislation.ranperbup.show', compact(
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

        $pageHeader = 'Perbaikan Rancangan Peraturan Bupati';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('legislation.ranperbup.index') => $this->type->name,
            'Perbaikan' => true
        ];
        
        $requirements = Requirement::mandatory($this->type->id)->get();
        $documents = Document::requirements($legislation->id)->get();

        // Read the comments
        foreach ($legislation->unreadComments()->get() as $comment) {
            $comment->update(['read' => 1]);
        }                

        // Check if all the requirements are validated
        $validateButton = true;
        foreach ($requirements as $requirement) {
            $requiredDocument = Document::where('legislation_id', $legislation->id)
                                    ->where('requirement_id', $requirement->id)
                                    ->first();

            if (empty($requiredDocument) OR empty($requiredDocument->validated_at)) {
                $validateButton = false;
            } 
        }

        $vendors = [
            'assets/js/vendor/notifications/bootbox.min.js',
            'assets/js/vendor/forms/selects/select2.min.js',
        ];

        return view('legislation.ranperbup.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'requirements',
            'documents',
            'legislation',
            'validateButton',
            'vendors',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function update(RanperbupRequest $request, Legislation $legislation)
    {
        $validated = $request->validated(); 
        $log_messsage = 'memperbaiki data ranperbup';  
        
        if ($request->has('post')) 
        {
            $validated['posted_at'] = now();
            $legislation->documents()->update(['posted_at' => now()]);
            $log_messsage = 'memperbaiki data ranperbup dan mengajukan ke Bagian Hukum';
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

        return redirect('/legislation/ranperbup/' . $legislation->id . '/edit')->with('message', '<strong>Berhasil!</strong> Data Pengajuan Rancangan Peraturan Bupati telah berhasil diperbarui');
    }

    public function approve(Request $request, Legislation $legislation)
    {
        $this->authorize('approve', $legislation);
        $legislation->update(['validated_at' => now()]);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'memvalidasi pengajuan ranperbup',
        ]);

        return redirect('/legislation/ranperbup/' . $legislation->id . '/edit')->with('message', '<strong>Berhasil!</strong> Data Pengajuan Rancangan Peraturan Bupati telah berhasil divalidasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Legislation $legislation)
    {
        $action = route('legislation.ranperbup.restore', $legislation->id);
        $legislation->delete();

        $legislation->logs()->create([
            'user_id'   => Auth::user()->id,
            'message'   => 'membatalkan ranperbup',
        ]);

        return redirect('/legislation/ranperbup')->with('trash-message', ['<strong>Berhasil!</strong> Data Rancangan Peraturan Bupati telah dibatalkan', $action]);
    }

    public function restore($id)
    {
        $legislation = Legislation::withTrashed()->findOrFail($id);
        $legislation->restore();

        $legislation->logs()->create([
            'user_id'   => Auth::user()->id,
            'message'   => 'mengembalikan ranperbup',
        ]);

        return redirect()->back()->with('message', 'Data Rancangan Peraturan Bupati telah dikembalikan');
    }

    public function forceDestroy($id)
    {
        $legislation = Legislation::withTrashed()->findOrFail($id);
        $legislation->forceDelete();

        $legislation->logs()->create([
            'user_id'   => Auth::user()->id,
            'message'   => 'menghapus ranperbup',
        ]);

        foreach ($legislation->documents as $document) {
            $this->removeDocument($document->path);
        }

        return redirect('/admin/legislation/ranperbup?tab=batal')->with('message', '<strong>Berhasil!</strong> Data Rancangan Peraturan Bupati telah berhasil dihapus');
    }
}