<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $categories = Category::paginate(5);

        return view('admin.newsCategory.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.newsCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {

        $category = new Category;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->status = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $imagePath = $request->file('image')->storeAs('images', $imageName, 'public');

            $category->image = $imagePath;
        }

        $category->save();

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
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryStoreRequest $request, string $id)
    {
        $categoryData = Category::findOrFail($id);

        $categoryData->name = $request->name;
        $categoryData->slug = $request->slug;
        $categoryData->description = $request->description;
        $categoryData->status = $request->has('status') ? 1 : 0;


        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $imagePath = $request->file('image')->storeAs('images', $imageName, 'public');

            $categoryData->image = $imagePath;
        }

        $categoryData->save();

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
}