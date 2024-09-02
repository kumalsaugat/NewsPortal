<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $news = News::all();
        return view('news.index', compact('news'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('news.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'author' => 'required|max:255',
            'published_at' => 'nullable|date',
        ]);

        News::create($validated);
        return redirect()->route('news.index')->with('success', 'News created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(News $news) {
        return view('news.show', compact('news'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news) {
        return view('news.edit', compact('news'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news) {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'author' => 'required|max:255',
            'published_at' => 'nullable|date',
        ]);

        $news->update($validated);
        return redirect()->route('news.index')->with('success', 'News updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
