<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Media;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts'      => Post::count(),
            'pages'      => Page::count(),
            'categories' => Category::count(),
            'media'      => Media::count(),
            'users'      => User::count(),
            'published'  => Post::where('status', 'published')->count(),
            'drafts'     => Post::where('status', 'draft')->count(),
        ];

        $recentPosts = Post::with('author')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts'));
    }
}
