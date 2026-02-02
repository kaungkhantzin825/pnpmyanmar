<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'title_image_upload' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:post_categories,id',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'auto_generate_thumbnail' => 'nullable|boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        // Title image: upload takes precedence, else generate from text when checkbox is on
        if ($request->hasFile('title_image_upload')) {
            $validated['title_thumbnail'] = $request->file('title_image_upload')->store('posts/thumbnails', 'public');
        } elseif ($request->boolean('auto_generate_thumbnail')) {
            $validated['title_thumbnail'] = $this->generateThumbnailFromText(
                $validated['title'],
                $validated['description'] ?? ''
            );
        }

        // Handle regular thumbnail upload
        if ($request->hasFile('thumbnail')) {
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
            'title_image_upload' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:post_categories,id',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'auto_generate_thumbnail' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        // Title image: upload takes precedence, else generate when checkbox on, else remove
        if ($request->hasFile('title_image_upload')) {
            if ($post->title_thumbnail) {
                Storage::disk('public')->delete($post->title_thumbnail);
            }
            $validated['title_thumbnail'] = $request->file('title_image_upload')->store('posts/thumbnails', 'public');
        } elseif ($request->boolean('auto_generate_thumbnail')) {
            if ($post->title_thumbnail) {
                Storage::disk('public')->delete($post->title_thumbnail);
            }
            $validated['title_thumbnail'] = $this->generateThumbnailFromText(
                $validated['title'],
                $validated['description'] ?? ''
            );
        } else {
            if ($post->title_thumbnail) {
                Storage::disk('public')->delete($post->title_thumbnail);
            }
            $validated['title_thumbnail'] = null;
        }

        // Handle regular thumbnail upload
        if ($request->hasFile('thumbnail')) {
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
     * Generate title image from text using Node.js + Puppeteer for proper Myanmar Unicode rendering.
     * Extracts text between asterisks if present: "မြန်မာစာ * English Text * ၁၀၆" → "English Text"
     */
    private function generateThumbnailFromText($title, $description = '')
    {
        // Extract text between asterisks if present
        $displayTitle = trim(preg_match('/\*\s*([^*]+?)\s*\*/', $title, $m) ? $m[1] : $title);
        
        // Generate unique filename
        $filename = 'posts/thumbnails/' . Str::random(40) . '.png';
        $outputPath = storage_path('app/public/' . $filename);
        
        // Ensure directory exists
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Path to Node.js script
        $scriptPath = base_path('scripts/generate-image.js');
        
        // Try to find node executable
        // Common paths: Windows, Linux, macOS
        $nodePaths = [
            'node',  // If in PATH
            'C:\\Program Files\\nodejs\\node.exe',  // Windows default
            'C:\\Program Files (x86)\\nodejs\\node.exe',  // Windows 32-bit
            '/usr/bin/node',  // Linux/Unix
            '/usr/local/bin/node',  // macOS/Linux
            'C:\\Users\\' . get_current_user() . '\\AppData\\Roaming\\npm\\node.exe',  // Windows user install
        ];
        
        $nodeCommand = 'node';  // Default
        
        // Test which node path works
        foreach ($nodePaths as $path) {
            $test = shell_exec("\"$path\" --version 2>&1");
            if ($test && strpos($test, 'v') === 0) {
                $nodeCommand = $path;
                break;
            }
        }
        
        // Escape arguments for shell
        $titleEscaped = escapeshellarg($displayTitle);
        $outputEscaped = escapeshellarg($outputPath);
        $descriptionEscaped = $description ? escapeshellarg($description) : '';
        
        // Build command - use full paths
        $scriptsDir = base_path('scripts');
        $command = "cd " . escapeshellarg($scriptsDir) . " && \"$nodeCommand\" generate-image.js $titleEscaped $outputEscaped $descriptionEscaped 2>&1";
        
        // Execute Node.js script
        $output = shell_exec($command);
        
        // Check if file was created
        if (file_exists($outputPath)) {
            return $filename;
        }
        
        // If Node.js failed, show error with helpful message
        $errorMsg = 'Failed to generate title image. ';
        if (strpos($output, 'not found') !== false || strpos($output, 'command not found') !== false) {
            $errorMsg .= 'Node.js is not installed or not in PATH. Please install Node.js v18+ or upload a title image manually.';
        } else {
            $errorMsg .= 'Error: ' . ($output ?? 'Unknown error');
        }
        
        request()->session()->flash('error', $errorMsg);
        
        return null;
    }


}
