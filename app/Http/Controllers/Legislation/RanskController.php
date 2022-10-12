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
use App\Http\Requests\RanskRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class RanskController extends LegislationController
{
    protected $type;

    public function __construct()
    {
        $this->type = Type::where('slug', 'ransk')->first();
        $this->authorizeResource(Legislation::class, 'ransk');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Rancangan SK';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            $this->type->name => TRUE
        ];

        $legislations = Legislation::ransk();

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

        return view('legislation.ransk.index', compact(
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
            'total'     => Legislation::ransk()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Legislation::ransk()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'aktif'     => Legislation::ransk()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->posted()
                                ->count(),
            'revisi'    => Legislation::ransk()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->revised()
                                ->count(),
            'valid'     => Legislation::ransk()
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->validated()
                                ->count(),
            'batal'     => Legislation::ransk()
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

        $message = 'data Rancangan SK telah berhasil diperbarui';
        foreach ($ids as $id)
        {
            $legislation = Legislation::withTrashed()->find($id);
            if ($request->action === 'trash')
            {
                $legislation->delete();
                $message = 'data Rancangan SK telah berhasil dibatalkan';

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'membatalkan ransk',
                ]);
            }
            else if ($request->action === 'delete')
            {
                $legislation->forceDelete();
                $message = 'data Rancangan SK telah berhasil dihapus';

                $legislation->logs()->create([
                    'user_id'   => $request->user()->id,
                    'message'   => 'menghapus ransk',
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
        $pageHeader = 'Pengajuan Rancangan SK';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('legislation.ransk.index') => $this->type->name,
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

        return view('legislation.ransk.create', compact(
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
    public function store(RanskRequest $request)
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
            'message'   => 'membuat ransk ' . $msg_append,
        ]);

        $this->documentUpload($new_legislation, $request);

        return redirect('/legislation/ransk')->with('message', '<strong>Berhasil!</strong> Data Rancangan SK telah berhasil disimpan ' . $msg_append);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function show(Legislation $legislation)
    {
        $pageHeader = 'Detail Rancangan SK';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('legislation.ransk.index') => $legislation->type->name,
            'Detail' => true
        ];

        $requirements = Requirement::requirements($legislation->type_id)->get();
        $master = Document::requirements($legislation->id)->first();
        $documents = Document::requirements($legislation->id)->get();

        return view('legislation.ransk.show', compact(
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

        $pageHeader = 'Perbaikan Rancangan SK';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            route('legislation.ransk.index') => $this->type->name,
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

        $plugins = [
            'assets/js/plugins/notifications/bootbox.min.js',
            'assets/js/plugins/forms/selects/select2.min.js',
        ];

        return view('legislation.ransk.edit', compact(
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
    public function update(RanskRequest $request, Legislation $legislation)
    {
        $validated = $request->validated(); 
        $log_messsage = 'memperbaiki data ransk';  
        
        if ($request->has('post')) 
        {
            $validated['posted_at'] = now();
            $legislation->documents()->update(['posted_at' => now()]);
            $log_messsage = 'memperbaiki data ransk dan mengajukan ke Bagian Hukum';
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

        return redirect('/legislation/ransk/' . $legislation->id . '/edit')->with('message', '<strong>Berhasil!</strong> Data Pengajuan Rancangan SK telah berhasil diperbarui');
    }

    public function approve(Request $request, Legislation $legislation)
    {
        $this->authorize('approve', $legislation);
        $legislation->update(['validated_at' => now()]);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'memvalidasi pengajuan ransk',
        ]);

        return redirect('/legislation/ransk/' . $legislation->id . '/edit')->with('message', '<strong>Berhasil!</strong> Data Pengajuan Rancangan SK telah berhasil divalidasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Legislation  $legislation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Legislation $legislation)
    {
        $action = route('legislation.ransk.restore', $legislation->id);
        $legislation->delete();

        $legislation->logs()->create([
            'user_id'   => Auth::user()->id,
            'message'   => 'membatalkan ransk',
        ]);

        return redirect('/legislation/ransk')->with('trash-message', ['<strong>Berhasil!</strong> Data Rancangan SK telah dibatalkan', $action]);
    }

    public function restore($id)
    {
        $legislation = Legislation::withTrashed()->findOrFail($id);
        $legislation->restore();

        $legislation->logs()->create([
            'user_id'   => Auth::user()->id,
            'message'   => 'mengembalikan ransk',
        ]);

        return redirect()->back()->with('message', 'Data Rancangan SK telah dikembalikan');
    }

    public function forceDestroy($id)
    {
        $legislation = Legislation::withTrashed()->findOrFail($id);
        $legislation->forceDelete();

        $legislation->logs()->create([
            'user_id'   => Auth::user()->id,
            'message'   => 'menghapus ransk',
        ]);

        foreach ($legislation->documents as $document) {
            $this->removeDocument($document->path);
        }

        return redirect('/admin/legislation/ransk?tab=batal')->with('message', '<strong>Berhasil!</strong> Data Rancangan SK telah berhasil dihapus');
    }
}
