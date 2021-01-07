<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(5);
        return view('admin.category', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => ['required', 'min:3', 'max:255', 'string'],
        ]);

        $validated['slug'] = Str::slug($request->name);
        Category::create($validated);

        return back()->with('status', 'berhasil menambahkan Category baru');
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
        $cat = Category::findOrFail($id);
        $validated = $this->validate($request, [
            'name' => ['required', 'min:3', 'max:255', 'string']
        ]);
        $validated['slug'] = Str::slug($request->name);
        $cat->update($validated);

        return back()->with('status', 'Category berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Category::findOrFail($id);
        $cat->delete($cat);
        return redirect()->back()->with('status', 'Category berhasil dihapus');
    }
}
