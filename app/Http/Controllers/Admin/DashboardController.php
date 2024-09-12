<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Dashboard';
    }
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

        //For Users
        $totalUsers = User::count();

        return view('admin.dashboard.index',[
            'pageTitle' => $this->pageTitle,
            'totalNews' => $totalNews,
            'totalActive' => $totalActive,
            'totalInactive' => $totalInactive,
            'totalCategories' => $totalCategories,
            'totalActiveCategories' => $totalActiveCategories,
            'totalInactiveCategories' => $totalInactiveCategories,
            'totalUsers' => $totalUsers,

        ]);
    }
}