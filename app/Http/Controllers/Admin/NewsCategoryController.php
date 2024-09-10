<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $categories = Category::paginate(5);

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

        return redirect()->route('news-category.index')->with('success', 'Category created successfully.');
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

        return redirect()->route('news-category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
   {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('news-category.index')->with('success', 'Category deleted successfully.');
    }

    protected function saveCategoryData(Category $category, CategoryStoreRequest $request)
    {
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->status = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $imagePath = $request->file('image')->storeAs('images', $imageName, 'public');

            $category->image = $imagePath;
        }
        $category->save();
    }

    public function updateStatus(Request $request, $id)
    {
        $newsCategory = Category::findOrFail($id);
        $newsCategory->status = $request->status;
        $newsCategory->save();

        return response()->json(['success' => true]);

    }
}