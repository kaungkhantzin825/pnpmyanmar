<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'facebook_video_url',
        'video_embed_code',
        'video_file_url',
        'video_type',
        'thumbnail',
        'title_thumbnail',
        'category_id',
        'user_id',
        'status',
        'is_featured',
        'views',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            
            // Detect video type and extract embed code
            if ($post->facebook_video_url) {
                $post->detectVideoType();
            }
        });
        
        static::updating(function ($post) {
            if ($post->isDirty('facebook_video_url')) {
                $post->detectVideoType();
            }
        });
    }

    public function detectVideoType()
    {
        $url = $this->facebook_video_url;
        
        // Check if it's an iframe embed code
        if (strpos($url, '<iframe') !== false) {
            $this->video_type = 'iframe';
            $this->video_embed_code = $url;
            return;
        }
        
        // Check if it's YouTube
        if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
            $this->video_type = 'youtube';
            $this->video_embed_code = $this->extractYouTubeId($url);
            return;
        }
        
        // Check if it's Facebook
        if (strpos($url, 'facebook.com') !== false || strpos($url, 'fb.watch') !== false) {
            $this->video_type = 'facebook';
            $this->video_embed_code = self::extractFacebookVideoId($url);
            return;
        }
        
        // Default to direct video URL
        $this->video_type = 'direct';
        $this->video_file_url = $url;
    }

    public function extractYouTubeId($url)
    {
        // Extract YouTube video ID from various URL formats
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        return $url;
    }

    public static function extractFacebookVideoId($url)
    {
        // Extract video ID from various Facebook URL formats
        if (preg_match('/facebook\.com\/.*\/videos\/(\d+)/', $url, $matches)) {
            return $matches[1];
        }
        if (preg_match('/fb\.watch\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        return $url;
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
