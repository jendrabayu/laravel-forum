<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;;

class AnswerController extends Controller
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
            'thread_id' => ['required', 'numeric', 'exists:threads,id'],
            'body' => ['required', 'min:5'],
        ]);

        $validated['user_id'] = auth()->id();

        Answer::create($validated);
        return back()->with('status', 'Berhasil menambahkan jawaban');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $answer = Answer::findOrFail($id);
        return view('thread.edit_answer', compact('answer'));
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
        $answer = Answer::findOrFail($id);
        $request->validate([
            'body' => ['required', 'min:5'],
        ]);

        $answer->update($request->only('body'));
        return back()->with('status', 'Jawaban berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return back()->with('status', 'Jawaban Anda berhasil dihapus');
    }


    public function like(Request $request, $id)
    {

        $request->validate([
            'is_like' => ['required', 'boolean']
        ]);

        $answer = Answer::findOrFail($id);

        if ($request->is_like === true) {
            auth()->user()->answerLikes()->create(['answer_id' => $id]);
            return response()->json([
                'likes_count' => $answer->answerLikes->count(),
                'is_like' => true
            ], 201);
        }

        auth()->user()->answerLikes()->where('answer_id', $id)->delete();

        return response()->json([
            'likes_count' => $answer->answerLikes->count(),
            'is_like' => false
        ], 201);
    }
}
