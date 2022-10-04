<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Legislation\LegislationController;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\Legislation;

class DocumentController extends LegislationController
{
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
        $type  = $request->type;
        $order = $request->order;
        $title = $request->title;

        return view('legislation.document.create', compact('legislationId', 'type', 'order', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validated();
        $legislation = Legislation::find($request->legislation_id);

        $this->documentUpload($legislation, $request, $request->order);

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
        //
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

        $currentTime = '_' . now()->timestamp;

        $file = $request->file($document->requirement->term);
        $legislation = Legislation::find($document->legislation_id);

        $documentStorage = $this->documentStorage($legislation, $document->requirement->term);
        $file_name = $documentStorage['file_prefix_name'] . $currentTime . '.' . $file->getClientOriginalExtension();    

        $path = $file->storeAs($documentStorage['path'], $file_name, 'public');

        // Remove old file
        $this->removeDocument($document->path);

        $document->update([
            'path'  => $path,
            'name'  => $file_name,
            'revised_at' => now(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
