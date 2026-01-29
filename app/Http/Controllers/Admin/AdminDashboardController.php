<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\AdsenseSetting;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_views' => Post::sum('views'),
            'categories' => PostCategory::count(),
            'active_ads' => AdsenseSetting::where('is_active', true)->count(),
        ];
        
        $recentPosts = Post::latest()->take(10)->get();
        
        return view('admin.dashboard', compact('stats', 'recentPosts'));
    }
}
