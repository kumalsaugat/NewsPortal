<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsStoreRequest;
use App\Models\Category;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


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
        $this->saveNewsData($news, $request);

        return redirect()->route('news.show',$news->id)->with('success', 'News created successfully.');

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
        $this->saveNewsData($newsData, $request);

        return redirect()->route('news.show',$newsData->id)->with('success', 'News updated successfully.');
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


    protected function saveNewsData(News $news, NewsStoreRequest $request)
{
    $news->title = $request->title;
    $news->slug = $request->slug;
    $news->description = $request->description;
    $news->category_id = $request->category_id;
    $news->status = $request->has('status') ? 1 : 0;
    $news->published_at = $request->published_at ? Carbon::parse($request->published_at) : $news->published_at;

    if (!$news->exists) {
        $news->created_by = Auth::id();
    }

    $news->updated_by = Auth::id();

    if ($request->input('image')) {

        // Delete old images if they exist
        if ($news->image) {

            // Check if the original image exists before deleting it
            // $oldImagePath = public_path('storage/'.$news->image);
            // $oldThumbnailPath = public_path('storage/images/thumbnails/'.basename($news->image));

            // if (File::exists($oldImagePath)) {
            //     File::delete($oldImagePath);
            // }

            // if (File::exists($oldThumbnailPath)) {
            //     File::delete($oldThumbnailPath);
            // }

            if (Storage::exists(public_path('storage/'.$news->image))) {
                Storage::delete(public_path('storage/'.$news->image));
            }
            if (Storage::exists(public_path('storage/images/thumbnails/'.basename($news->image)))) {
                Storage::delete(public_path('storage/images/thumbnails/'.basename($news->image)));
            }

        }

        $imagePath = $request->input('image');
        $filename = basename($imagePath);

        // Define paths
        $originalPath = 'images/'.$filename;
        $resizedPath = 'images/thumbnails/'.$filename;

        // Move the file from 'tmp' to 'images'
        Storage::disk('public')->move($imagePath, $originalPath);

        // Resize the image using Intervention Image
        $resizedImage = Image::make(storage_path('app/public/'.$originalPath))->resize(300, 200);

        // Store the resized image
        Storage::disk('public')->put($resizedPath, (string) $resizedImage->encode());

        // Save the new image path in the database
        $news->image = $originalPath;
    }

    $news->save();
}

    public function updateStatus(Request $request, $id)
    {
        try {
            $news = News::findOrFail($id);
            $news->status = $request->status;
            $news->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }
}
