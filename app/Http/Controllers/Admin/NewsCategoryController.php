<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;


class NewsCategoryController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'News Category';
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $categories = Category::latest()->get();

        return view('admin.newsCategory.index', [
            'categories' => $categories,
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
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->status = $request->has('status') ? 1 : 0;

        if (!$category->exists) {
            $category->created_by = Auth::id();
            $category->updated_at = null;
        }else {
            $category->updated_by = Auth::id();
        }

        $category->updated_by = Auth::id();

        if ($request->input('image')) {

            // Delete old images if they exist
            if ($category->image) {

                if (Storage::exists(public_path('storage/'.$category->image))) {
                    Storage::delete(public_path('storage/'.$category->image));
                }
                if (Storage::exists(public_path('storage/images/thumbnails/'.basename($category->image)))) {
                    Storage::delete(public_path('storage/images/thumbnails/'.basename($category->image)));
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
            $category->image = $originalPath;
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
}
