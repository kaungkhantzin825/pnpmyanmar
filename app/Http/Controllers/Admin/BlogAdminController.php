<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogAdminController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->latest()
            ->paginate(20);
        
        return view('admin.blog.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = PostCategory::active()->get();
        return view('admin.blog.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video_type' => 'required|in:facebook,youtube,iframe,direct',
            'facebook_video_url' => 'nullable|string',
            'video_embed_code' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:post_categories,id',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'auto_generate_thumbnail' => 'nullable|boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        // Auto-generate thumbnail from title if requested
        if ($request->has('auto_generate_thumbnail') && $request->auto_generate_thumbnail) {
            $validated['title_thumbnail'] = $this->generateThumbnailFromText($validated['title'], $validated['description'] ?? '');
        } elseif ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts/thumbnails', 'public');
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        Post::create($validated);

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        $categories = PostCategory::active()->get();
        return view('admin.blog.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video_type' => 'required|in:facebook,youtube,iframe,direct',
            'facebook_video_url' => 'nullable|string',
            'video_embed_code' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:post_categories,id',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'auto_generate_thumbnail' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Auto-generate thumbnail from title if requested
        if ($request->has('auto_generate_thumbnail') && $request->auto_generate_thumbnail) {
            if ($post->title_thumbnail) {
                Storage::disk('public')->delete($post->title_thumbnail);
            }
            $validated['title_thumbnail'] = $this->generateThumbnailFromText($validated['title'], $validated['description'] ?? '');
        } elseif ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts/thumbnails', 'public');
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = $post->published_at ?? now();
        }

        $post->update($validated);

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }
        
        if ($post->title_thumbnail) {
            Storage::disk('public')->delete($post->title_thumbnail);
        }
        
        $post->delete();

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    /**
     * Generate thumbnail image from text using Intervention Image
     */
    private function generateThumbnailFromText($title, $description = '')
    {
        // Image dimensions
        $width = 1200;
        $height = 630;
        
        // Create image manager with GD driver
        $manager = new ImageManager(new Driver());
        
        // Create blank image with blue gradient background
        $image = $manager->create($width, $height);
        
        // Fill with gradient (blue)
        $image->fill('#3B82F6');
        
        // Add semi-transparent overlay for better text visibility
        $image->place(
            $manager->create($width, $height)->fill('rgba(0, 0, 0, 0.2)'),
            'top-left'
        );
        
        // Prepare title text (wrap if too long)
        $titleLines = $this->wrapText($title, 40);
        $titleText = implode("\n", array_slice($titleLines, 0, 3)); // Max 3 lines
        
        // Add title text
        $image->text($titleText, $width / 2, $height / 2 - 50, function ($font) {
            $font->file(public_path('fonts/arial.ttf')); // Will use default if not found
            $font->size(60);
            $font->color('#FFFFFF');
            $font->align('center');
            $font->valign('middle');
        });
        
        // Add description if provided
        if (!empty($description)) {
            $descLines = $this->wrapText($description, 60);
            $descText = implode("\n", array_slice($descLines, 0, 2)); // Max 2 lines
            
            $image->text($descText, $width / 2, $height / 2 + 100, function ($font) {
                $font->file(public_path('fonts/arial.ttf'));
                $font->size(30);
                $font->color('#E5E7EB');
                $font->align('center');
                $font->valign('middle');
            });
        }
        
        // Save image
        $filename = 'posts/thumbnails/' . Str::random(40) . '.png';
        $path = storage_path('app/public/' . $filename);
        
        // Ensure directory exists
        $directory = dirname($path);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $image->save($path);
        
        return $filename;
    }

    /**
     * Wrap text to fit within specified width
     */
    private function wrapText($text, $maxChars)
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';
        
        foreach ($words as $word) {
            if (strlen($currentLine . ' ' . $word) <= $maxChars) {
                $currentLine .= ($currentLine ? ' ' : '') . $word;
            } else {
                if ($currentLine) {
                    $lines[] = $currentLine;
                }
                $currentLine = $word;
            }
        }
        
        if ($currentLine) {
            $lines[] = $currentLine;
        }
        
        return $lines;
    }
}
