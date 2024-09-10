<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //For Category
        $totalCategories = Category::count();
        $totalActiveCategories = Category::where('status', 1)->count();
        $totalInactiveCategories = Category::where('status', 0)->count();

        //For News
        $totalNews = News::count();
        $totalActive = News::where('status', 1)->count();
        $totalInactive = News::where('status', 0)->count();
        return view('admin.dashboard.index',[
            'totalNews' => $totalNews,
            'totalActive' => $totalActive,
            'totalInactive' => $totalInactive,
            'totalCategories' => $totalCategories,
            'totalActiveCategories' => $totalActiveCategories,
            'totalInactiveCategories' => $totalInactiveCategories,

        ]);
    }
}