<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(12);
        
        $featuredPosts = Post::published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();
        
        $categories = PostCategory::active()
            ->withCount('posts')
            ->get();
        
        return view('blog.index', compact('posts', 'featuredPosts', 'categories'));
    }

    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }
        
        $post->incrementViews();
        $post->load(['category', 'user']);
        
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->take(4)
            ->get();
        
        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function category(PostCategory $category)
    {
        $posts = Post::published()
            ->where('category_id', $category->id)
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(12);
        
        $categories = PostCategory::active()
            ->withCount('posts')
            ->get();
        
        return view('blog.category', compact('posts', 'category', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $posts = Post::published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(12);
        
        return view('blog.search', compact('posts', 'query'));
    }
}
