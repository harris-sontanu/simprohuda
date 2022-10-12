<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Legislation\LegislationController;
use App\Models\Document;
use App\Models\Requirement;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\Legislation;
use Illuminate\Support\Facades\Auth;

class DocumentController extends LegislationController
{
    public function __construct()
    {
        $this->authorizeResource(Document::class, 'document');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $legislationId = $request->legislation_id;
        $requirement = Requirement::find($request->requirement_id);

        return view('legislation.document.create', compact('legislationId', 'requirement'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requirement = Requirement::find($request->requirement_id);
        $request->validate([
            $requirement->term => 'required|file|mimes:'.$requirement->format.'|max:2048',
        ]);
        $legislation = Legislation::find($request->legislation_id);

        $currentTime = '_' . now()->timestamp;

        $file = $request->file($requirement->term);

        $documentStorage = $this->documentStorage($legislation, $requirement->category, $requirement->order);
        $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $file->getClientOriginalExtension();    

        $path = $file->storeAs($documentStorage['path'], $file_name, 'public');
        
        Document::create([
            'legislation_id'    => $request->legislation_id,
            'requirement_id'    => $request->requirement_id,
            'path'              => $path,
            'name'              => $file_name,
            'posted_at'         => empty($legislation->posted_at) ? null : now(),
        ]);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'mengunggah dokumen ' . $requirement->title,
        ]);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Dokumen ' . $request->title . ' telah berhasil diunggah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return view('legislation.document.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('legislation.document.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            $document->requirement->term => 'required|file|mimes:'.$document->requirement->format.'|max:2048',
        ]);

        $old_document = $document->path;

        $currentTime = '_' . now()->timestamp;

        $file = $request->file($document->requirement->term);
        $legislation = Legislation::find($document->legislation_id);

        $documentStorage = $this->documentStorage($legislation, $document->requirement->category, $document->requirement->order);
        $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $file->getClientOriginalExtension();    

        $path = $file->storeAs($documentStorage['path'], $file_name, 'public');

        $document->update([
            'path'  => $path,
            'name'  => $file_name,
            'revised_at' => empty($legislation->posted_at) ? null : now(),
            'validated_at' => null,
        ]);

        // Remove old file
        $this->removeDocument($old_document);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'memperbaiki dokumen ' . $document->requirement->title,
        ]);

        // Update legislation revise date except for draft
        if ($legislation->status() != 'draft') {
            $legislation->update(['revised_at' => now()]);
        }
    }

    public function ratify(Request $request, Document $document)
    {
        $this->authorize('ratify', $document);
        $document->update([
            'validated_at'  => now()
        ]);

        Log::create([
            'legislation_id'=> $document->legislation->id,
            'user_id'       => $request->user()->id,
            'message'       => 'memvalidasi dokumen ' . $document->requirement->title,
        ]);

        return redirect('/legislation/' . $document->legislation->type->slug . '/' . $document->legislation->id . '/edit')
            ->with('message', '<strong>Berhasil!</strong> Dokumen ' . $document->title . ' telah berhasil divalidasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $type   = $document->legislation->type->slug;
        $id     = $document->legislation->id;
        $title  = $document->title;

        $document->delete();

        $this->removeDocument($document->path);

        Log::create([
            'legislation_id'=> $document->legislation->id,
            'user_id'       => Auth::user()->id,
            'message'       => 'menghapus dokumen ' . $document->requirement->title,
        ]);

        return redirect('/legislation/' . $type . '/' . $id . '/edit')
            ->with('message', '<strong>Berhasil!</strong> Dokumen ' . $title . ' telah berhasil dihapus');
    }
}
