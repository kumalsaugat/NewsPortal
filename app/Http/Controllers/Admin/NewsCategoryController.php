<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DB;

class NewsCategoryController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Category';
    }
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {

    //     $categories = Category::latest()->get();

    //     return view('admin.newsCategory.index', [
    //         'categories' => $categories,
    //         'pageTitle' => $this->pageTitle,
    //     ]);
    // }
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.newsCategory.index', [
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.newsCategory.create',[
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {

        $category = new Category;
        $this->saveCategoryData($category, $request);

        return redirect()->route('news-category.show',$category->id)->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories = Category::findOrFail($id);

        return view('admin.newsCategory.show', [
            'category' => $categories,
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoryData = Category::findOrFail($id);

        return view('admin.newsCategory.edit', [
            'categoryData' => $categoryData,
            'pageTitle' => $this->pageTitle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryStoreRequest $request, string $id)
    {
        $categoryData = Category::findOrFail($id);

        $this->saveCategoryData($categoryData, $request);

        return redirect()->route('news-category.show',$categoryData->id)->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
   {
        $category = Category::findOrFail($id);

        $category->deleted_by = Auth::id();
        $category->save();

        $category->delete();

        return redirect()->route('news-category.index')->with('success', 'Category deleted successfully.');
    }

    protected function saveCategoryData(Category $category, CategoryStoreRequest $request)
    {
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->has('status') ? 1 : 0;

        // Check if slug is empty and auto-generate from title
        if (empty($request->slug)) {
            $category->slug = Str::slug($category->name);
        } else {
            $category->slug = $request->slug;
        }

        if (!$category->exists) {
            $category->created_by = Auth::id();
            $category->updated_at = null;
        }else {
            $category->updated_by = Auth::id();
        }

        $category->updated_by = Auth::id();

        $existimage = '800px_'.basename($category->image);
        $currentimage = basename($request->image);
            // Delete old images
              // Delete old images if they exist
                if ($existimage != $currentimage) {

            if ($category->image) {

                // Delete original and thumbnail images if they exist
                if (Storage::exists(public_path('storage/'.$category->image))) {
                    Storage::delete(public_path('storage/'.$category->image));
                }
                if (Storage::exists(public_path('storage/images/thumbnails/800px_'.basename($category->image)))) {
                    Storage::delete(public_path('storage/images/thumbnails/800px_'.basename($category->image)));
                }
                if (Storage::exists(public_path('storage/images/thumbnails/100px_'.basename($category->image)))) {
                    Storage::delete(public_path('storage/images/thumbnails/100px_'.basename($category->image)));
                }
            }

            if ($request->input('image')) {


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


                        $category->image = $originalPath;
                } else {

                    $category->image = $category->image;
                }
            }

        $category->save();
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $newsCategory = Category::findOrFail($id);
            $newsCategory->status = $request->status;
            $newsCategory->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }

    }
    public function bulkUpdateStatus(Request $request)
    {
        $ids = $request->ids;
        Category::whereIn('id', $ids)->update(['status' => DB::raw('NOT status')]);

        return response()->json(['success' => 'Status updated successfully!']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        Category::whereIn('id', $ids)->delete();

        return response()->json(['success' => 'Selected rows deleted successfully!']);
    }
}
