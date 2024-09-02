<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsStoreRequest;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $news = News::paginate(5);

        return view('admin.news.index',[
            'news' => $news,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('admin.news.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsStoreRequest $request)
    {


        $news = new News();
        $news->title = $request->title;
        $news->slug = $request->slug;
        $news->description = $request->description;
        $news->category_id = $request->category_id;
        $news->user_id = $request->user_id;
        $news->status = $request->status;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->storeAs('images', $imageName, 'public');

            $news->image = $imagePath;
        }
        $news->published_at = $request->published_at;
        $news->save();

        return redirect()->route('news.index')->with('success', 'News created successfully.');

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.show',[
            'news' => $news,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $newsData = News::findOrFail($id);

        return view('admin.news.edit',[
            'newsData' => $newsData,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(NewsStoreRequest $request, string $id)
    {

        $newsData = News::findOrFail($id);

        $newsData->title = $request->title;
        $newsData->slug = $request->slug;
        $newsData->description = $request->description;
        $newsData->category_id = $request->category_id;
        $newsData->user_id = $request->user_id;
        $newsData->status = $request->status;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->storeAs('images', $imageName, 'public');

            $newsData->image = $imagePath;
        }
        $newsData->published_at = $request->published_at;
        $newsData->save();

        return redirect()->route('news.index')->with('success', 'News updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);

        $news->delete();

        return redirect()->route('news.index')->with('success', 'News deleted successfully.');
    }
}
