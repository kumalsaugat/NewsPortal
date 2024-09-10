<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsStoreRequest;
use App\Models\Category;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'News';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::paginate(5);

        return view('admin.news.index', [
            'news' => $news,
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = Category::all();

        return view('admin.news.create', [
            'categories' => $categories,
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsStoreRequest $request)
    {

        $news = new News;
        $news->title = $request->title;
        $news->slug = $request->slug;
        $news->description = $request->description;
        $news->category_id = $request->category_id;
        $news->status = $request->has('status') ? 1 : 0;
        $news->user_id = Auth::id();
        $news->published_at = $request->published_at ? Carbon::parse($request->published_at) : Carbon::now();

        if ($request->input('image')) {
            $imagePath = $request->input('image');
            $filename = basename($imagePath);

            $newPath = 'images/'.$filename;

            Storage::disk('public')->move($imagePath, $newPath);

            $news->image = $newPath;
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'News created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::findOrFail($id);

        return view('admin.news.show', [
            'news' => $news,
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $newsData = News::findOrFail($id);
        $categories = Category::all();

        $newsData->published_at = $newsData->published_at ? Carbon::parse($newsData->published_at) : null;

        return view('admin.news.edit', [
            'newsData' => $newsData,
            'categories' => $categories,
            'pageTitle' => $this->pageTitle,
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
        $newsData->status = $request->has('status') ? 1 : 0;
        $newsData->user_id = Auth::id();

        $newsData->published_at = $request->published_at
            ? Carbon::parse($request->published_at)
            : $newsData->published_at;

        if ($request->input('image')) {
            if ($newsData->image && Storage::disk('public')->exists($newsData->image)) {
                Storage::disk('public')->delete($newsData->image);
            }

            $imagePath = $request->input('image');
            $filename = basename($imagePath);
            $newPath = 'images/'.$filename;

            Storage::disk('public')->move($imagePath, $newPath);

            $newsData->image = $newPath;
        }

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

    public function upload(Request $request)
    {
        if ($request->file('image')) {
            $path = $request->file('image')->store('tmp', 'public');
            return response()->json(['path' => $path]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function revert(Request $request)
    {
        $path = $request->getContent();
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return response()->json(['success' => true]);
    }

    public function load($filename)
    {
        return response()->file(storage_path('app/public/images/'.$filename));

    }

    // Handle fetching image (e.g., after upload or on form load)
    public function fetch($filename)
    {
        return response()->json(['filename' => $filename, 'url' => Storage::url('images/'.$filename)]);
    }

    public function updateStatus(Request $request, $id)
    {
        $newsCategory = News::findOrFail($id);
        $newsCategory->status = $request->status;
        $newsCategory->save();

        return response()->json(['success' => true]);

    }
}