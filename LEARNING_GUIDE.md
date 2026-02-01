# Laravel Blog Application - Learning Guide

## 📚 Database Structure Overview

This application has 3 main database tables for the blog system:

### 1. **post_categories** Table
Stores blog post categories (Entertainment, Music, Gaming, etc.)

**Columns:**
- `id` - Unique identifier
- `name` - Category name (e.g., "Entertainment")
- `slug` - URL-friendly version (e.g., "entertainment")
- `description` - Optional category description
- `icon` - Font Awesome icon class (e.g., "fas fa-film")
- `order` - Display order (lower numbers appear first)
- `is_active` - Whether category is visible (true/false)
- `created_at`, `updated_at` - Timestamps

**Relationships:**
- Has many Posts (one category can have multiple posts)

---

### 2. **posts** Table
Stores blog posts with video content

**Columns:**
- `id` - Unique identifier
- `title` - Post title
- `slug` - URL-friendly version for routing
- `description` - Short description/excerpt
- `content` - Full post content (optional)
- `facebook_video_url` - Original video URL
- `video_embed_code` - Extracted embed code or video ID
- `video_file_url` - Direct video file URL (for uploaded videos)
- `video_type` - Type: facebook, youtube, iframe, or direct
- `thumbnail` - Post thumbnail image
- `title_thumbnail` - Alternative thumbnail for title
- `category_id` - Foreign key to post_categories
- `user_id` - Foreign key to users (who created it)
- `status` - draft, published, or archived
- `is_featured` - Whether post appears in featured section
- `views` - View counter
- `published_at` - When post was published
- `created_at`, `updated_at` - Timestamps

**Relationships:**
- Belongs to PostCategory (each post has one category)
- Belongs to User (each post has one author)

**Indexes:**
- Combined index on (status, published_at) for fast queries
- Index on is_featured for homepage queries

---

### 3. **adsense_settings** Table
Stores advertisement configurations

**Columns:**
- `id` - Unique identifier
- `name` - Ad name/label
- `position` - Where ad appears (header, sidebar, content_top, etc.)
- `ad_code` - HTML/JavaScript ad code
- `is_active` - Whether ad is currently displayed
- `order` - Display order for multiple ads in same position
- `created_at`, `updated_at` - Timestamps

---

## 🎯 Model Relationships Explained

```
User (1) ──────> (Many) Posts
PostCategory (1) ──────> (Many) Posts
```

**Example:**
- One user can create many posts
- One category can contain many posts
- Each post belongs to one user and one category

---

## 🔧 Key Laravel Concepts Used

### 1. **Eloquent Models**
Models represent database tables and handle data logic.

**Example from Post.php:**
```php
protected $fillable = ['title', 'slug', 'content', ...];
// Defines which fields can be mass-assigned
```

### 2. **Model Events (boot method)**
Automatically runs code when creating/updating records.

**Example:**
```php
static::creating(function ($post) {
    if (empty($post->slug)) {
        $post->slug = Str::slug($post->title);
    }
});
// Auto-generates slug from title when creating a post
```

### 3. **Relationships**
```php
// In Post model
public function category() {
    return $this->belongsTo(PostCategory::class);
}

// Usage: $post->category->name
```

### 4. **Query Scopes**
Reusable query filters.

```php
public function scopePublished($query) {
    return $query->where('status', 'published');
}

// Usage: Post::published()->get();
```

### 5. **Accessors & Mutators**
The `detectVideoType()` method automatically:
- Detects if URL is YouTube, Facebook, or iframe
- Extracts video IDs
- Sets appropriate video_type

---

## 📊 Sample Data (Seeder)

The BlogSeeder creates:
- **1 Admin User** (email: admin@example.com, password: password)
- **6 Categories**: Entertainment, Music, Gaming, Sports, News, Comedy
- **20 Sample Posts** with various categories and featured status

---

## 🚀 How Data Flows

### Creating a Post:
1. User fills form with title, description, video URL
2. Post model's `boot()` method runs:
   - Auto-generates slug from title
   - Calls `detectVideoType()` to parse video URL
3. Data saved to database
4. Post appears on website based on status and published_at

### Displaying Posts:
1. Controller queries: `Post::published()->with('category')->get()`
2. Returns posts with their category data (eager loading)
3. View displays posts using Blade templates
4. When user views post, `incrementViews()` increases counter

---

## 💡 Important Features

### Auto Slug Generation
```php
$post = new Post();
$post->title = "Amazing Video";
// Slug automatically becomes "amazing-video"
```

### Video Type Detection
Supports multiple video sources:
- **Facebook**: Extracts video ID from facebook.com URLs
- **YouTube**: Extracts video ID from youtube.com/youtu.be URLs
- **Iframe**: Stores complete iframe embed code
- **Direct**: Stores direct video file URL

### Scopes for Easy Queries
```php
Post::published()->get();        // Only published posts
Post::featured()->get();          // Only featured posts
Post::published()->featured()->get(); // Both conditions
```

---

## 🗂️ File Structure

```
app/Models/
├── Post.php              # Post model with video detection logic
├── PostCategory.php      # Category model
└── AdsenseSetting.php    # Ad management model

database/migrations/
├── create_post_categories_table.php
├── create_posts_table.php
├── create_adsense_settings_table.php
└── add_*_to_posts_table.php  # Additional columns

database/seeders/
└── BlogSeeder.php        # Sample data generator
```

---

## 🎓 Learning Tips

1. **Start with Models**: Understand what data each model represents
2. **Study Relationships**: See how models connect to each other
3. **Read Migrations**: They show exact database structure
4. **Check Seeders**: See example data to understand usage
5. **Explore Controllers**: See how data is queried and displayed
6. **Practice Queries**: Try different Eloquent queries in tinker

---

## 🔍 Useful Commands

```bash
# View all posts with categories
php artisan tinker
>>> Post::with('category')->get()

# Count posts per category
>>> PostCategory::withCount('posts')->get()

# Find featured posts
>>> Post::featured()->published()->get()
```

---

## 📝 Next Steps

1. Run migrations to create tables
2. Run seeder to populate sample data
3. Explore admin panel to create/edit posts
4. Study the controllers to see CRUD operations
5. Modify views to customize appearance
