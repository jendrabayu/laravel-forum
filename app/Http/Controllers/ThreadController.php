<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Thread\ThreadStoreRequest;
use App\Http\Requests\Thread\ThreadUpdateRequest;
use App\Thread;
use App\ThreadLike;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     * @see https://packagist.org/packages/justbetter/laravel-pagination-with-havings (Mengatasi masalah paginate dengan having) 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $threads = Thread::query();
        $title = 'All Threads';

        if ($request->has('filter')) {
            switch ($request->get('filter')) {
                case 'my':
                    if (!auth()->check()) return redirect()->route('login');
                    $threads->where('user_id', auth()->id());
                    $title = 'My Threads';
                    break;
                case 'unanswered':
                    $threads->where('is_solved', false)->withCount(['answers'])->having('answers_count', '=', 0)->get();
                    $title = 'Unanswered';
                    break;
                case 'solved':
                    $threads->where('is_solved', true);
                    $title = 'Solved';
                    break;
                default:
                    abort(404, 'Thread tidak ditemukan');
                    break;
            }
        }

        if ($request->has('category')) {
            $category = Category::where('slug', $request->get('category'))->firstOrFail();
            $threads = $threads->whereHas('category', function ($c) use ($request) {
                $c->where('slug', $request->get('category'));
            });
            $title = 'Kategori: ' . $category->name;
        }

        if ($request->has('search')) {
            $threads =  $threads->where('title', 'like', "%{$request->get('search')}%");
            $title = 'Pencarian: ' . Str::limit($request->get('search'), 30);
        }

        $threads =  $threads->latest()->paginate(5);
        return view('thread.index', compact('threads', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('thread.create', [
            'categories' => Category::all()->pluck('name', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadStoreRequest $request)
    {
        $thread = Thread::create($request->validated());
        return redirect()->route('threads.show', [$thread->id, $thread->slug])->with('status', 'Berhasil membuat thread baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug)
    {
        $thread = Thread::findOrFail($id);
        return view('thread.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $thread = Thread::findOrFail($id);
        $this->authorize('update', $thread);

        $categories =  Category::all()->pluck('name', 'id');
        return view('thread.edit', compact('thread', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ThreadUpdateRequest $request, $id)
    {
        $thread = Thread::findOrFail($id);
        $this->authorize('update', $thread);

        $thread->update($request->validated());
        return back()->with('status', 'Thread berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $thread = Thread::findOrFail($id);

        $this->authorize('delete', $thread);

        $thread->delete();
        return redirect()->route('home')->with('status', 'Thread berhasil dihapus');
    }


    public function like(Request $request, $id)
    {
        $request->validate([
            'is_like' => ['required', 'boolean']
        ]);

        $thread = Thread::findOrFail($id);

        if ($request->is_like === true) {
            auth()->user()->threadLikes()->create(['thread_id' => $id]);
            return response()->json([
                'likes_count' => $thread->threadLikes->count(),
                'is_like' => true
            ], 201);
        }

        auth()->user()->threadLikes()->where('thread_id', $id)->delete();

        return response()->json([
            'likes_count' => $thread->threadLikes->count(),
            'is_like' => false
        ], 201);
    }

    public function solved(Request $request, $id)
    {

        $request->validate([
            'is_solved' => ['required', 'boolean']
        ]);
        $thread = Thread::findOrFail($id);
        $this->authorize('update', $thread);
        $thread->update([
            'is_solved' => $request->is_solved === '1' ? true : false
        ]);

        // dd($thread->toArray());

        return back()->with('status', 'Thread sudah solved');
    }
}
