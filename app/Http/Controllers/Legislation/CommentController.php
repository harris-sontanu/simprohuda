<?php

namespace App\Http\Controllers\Legislation;

use App\Http\Controllers\Controller;
use App\Models\Legislation;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'legislation_id' => 'required',
            'comment' => 'required',
        ]);

        $legislation = Legislation::find($request->legislation_id);

        $request->user()->comments()->create($validated);

        $legislation->logs()->create([
            'user_id'   => $request->user()->id,
            'message'   => 'memberikan komentar',
        ]);

        return redirect('/legislation/' . $legislation->type->slug . '/' . $legislation->id . '/edit')
            ->with('message', '<strong>Berhasil!</strong> Komentar Anda telah berhasil disimpan');
    }
}
