<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\NewsDataTable;
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
use Illuminate\Support\Str;
use DB;

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
    // public function index()
    // {
    //     $news = News::latest()->get();

    //     return view('admin.news.index', [
    //         'news' => $news,
    //         'pageTitle' => $this->pageTitle,
    //     ]);
    // }

    public function index(NewsDataTable $dataTable)
    {
        return $dataTable->render('admin.news.index', [
            'pageTitle' => $this->pageTitle,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = Category::where('status',1)->get();

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
        // Retrieve the news data
        $newsData = News::findOrFail($id);

        // Fetch only active categories
        $categories = Category::where('status', '=', '1') // Only active categories
            ->whereNull('deleted_at')
            ->get();

        // Fetch the selected category of the current news (whether inactive or soft-deleted)
        $selectedCategory = Category::withTrashed()->find($newsData->category_id);

        // If the selected category is inactive or soft-deleted, add it to the list
        if ($selectedCategory && ($selectedCategory->trashed() || $selectedCategory->status == 0)) {
            $categories->push($selectedCategory);
        }

        // Handle the published_at date format
        $newsData->published_at = $newsData->published_at ? Carbon::parse($newsData->published_at) : null;

        // Pass data to the view
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
    $news->description = $request->description;
    $news->category_id = $request->category_id;
    $news->status = $request->has('status') ? 1 : 0;
    $news->published_at = $request->published_at ? Carbon::parse($request->published_at) : $news->published_at;

    // Check if slug is empty and auto-generate from title
    if (empty($request->slug)) {
        $news->slug = Str::slug($news->title);
    } else {
        $news->slug = $request->slug;
    }


    if (!$news->exists) {
        $news->created_by = Auth::id();
        $news->updated_at = null;
    }else {
        $news->updated_by = Auth::id();
    }

        $existimage = '800px_'.basename($news->image);
        $currentimage = basename($request->image);
            // Delete old images
              // Delete old images if they exist
                if ($existimage != $currentimage) {

            if ($news->image) {

                // Delete original and thumbnail images if they exist
                if (Storage::exists(public_path('storage/'.$news->image))) {
                    Storage::delete(public_path('storage/'.$news->image));
                }
                if (Storage::exists(public_path('storage/images/thumbnails/800px_'.basename($news->image)))) {
                    Storage::delete(public_path('storage/images/thumbnails/800px_'.basename($news->image)));
                }
                if (Storage::exists(public_path('storage/images/thumbnails/100px_'.basename($news->image)))) {
                    Storage::delete(public_path('storage/images/thumbnails/100px_'.basename($news->image)));
                }
            }


            $imagePath = $request->input('image');
            $filename = basename($imagePath);

            // Define paths
            $originalPath = 'images/'.$filename;
            $thumbnail100Path = 'images/thumbnails/100px_'.$filename;
            $thumbnail800Path = 'images/thumbnails/800px_'.$filename;

            // Move the file from 'tmp' to 'images'
            Storage::disk('public')->move($imagePath, $originalPath);

            // Resize the image using Intervention Image

            // 100px width image
            $resized100Image = Image::make(storage_path('app/public/'.$originalPath))->resize(100, null, function ($constraint) {
                $constraint->aspectRatio(); // Keep aspect ratio
                $constraint->upsize(); // Prevent upsizing
            });
            Storage::disk('public')->put($thumbnail100Path, (string) $resized100Image->encode());

            // 800px width image
            $resized800Image = Image::make(storage_path('app/public/'.$originalPath))->resize(800, null, function ($constraint) {
                $constraint->aspectRatio(); // Keep aspect ratio
                $constraint->upsize(); // Prevent upsizing
            });
            Storage::disk('public')->put($thumbnail800Path, (string) $resized800Image->encode());


                $news->image = $originalPath;
           } else {

            $news->image = $news->image;
        }


    $news->save();
}

    public function updateStatus(Request $request, $id)
    {
        try {
            $news = News::findOrFail($id);
            $news->status = $request->status;
            $news->updated_by = Auth::id();
            $news->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }

    public function bulkUpdateStatus(Request $request)
    {
        $ids = $request->ids;
        News::whereIn('id', $ids)->update(['status' => DB::raw('NOT status')]);

        return response()->json(['success' => 'Status updated successfully!']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        News::whereIn('id', $ids)->delete();

        return response()->json(['success' => 'Selected rows deleted successfully!']);
    }
}
