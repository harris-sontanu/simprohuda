<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Legislation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Comment::class);
        
        $validated = $request->validate([
            'legislation_id' => 'required',
            'comment' => 'required',
        ]);

        $legislation = Legislation::find($request->legislation_id);

        if (Gate::allows('isOpd')) {
            $validated['to_id'] = $legislation->institute->corrector_id;
        } else {
            $validated['to_id'] = $legislation->user_id;
        }

        $request->user()->comments()->create($validated);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'memberikan komentar',
        ]);

        return redirect('/legislation/' . $legislation->type->slug . '/' . $legislation->id . '/edit')
            ->with('message', '<strong>Berhasil!</strong> Komentar Anda telah berhasil disimpan');
    }
}
