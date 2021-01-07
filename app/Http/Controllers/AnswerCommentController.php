<?php

namespace App\Http\Controllers;

use App\AnswerComment;
use Illuminate\Http\Request;

class AnswerCommentController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'answer_id' => ['required', 'numeric', 'exists:answers,id'],
            'body' => ['required', 'min:3', 'string']
        ]);

        $validated['user_id'] = auth()->id();
        AnswerComment::create($validated);
        return back()->with('status', 'Berhasil menambahkan komentar');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'body' => ['required', 'min:3', 'string']
        ]);

        $comment = AnswerComment::findOrFail($id);
        $comment->update($request->all());
        return back()->with('status', 'Komentar Anda berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = AnswerComment::findOrFail($id);
        $comment->delete();
        return back()->with('status', 'Komentar Anda berhasil dihapus');
    }

  
}
