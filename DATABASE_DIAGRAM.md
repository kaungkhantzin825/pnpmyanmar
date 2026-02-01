# 📊 Database Structure Diagram

## Visual Relationships

```
┌─────────────────────┐
│       users         │
│─────────────────────│
│ id (PK)             │
│ name                │
│ email               │
│ password            │
│ role                │
│ created_at          │
│ updated_at          │
└─────────────────────┘
         │
         │ 1
         │
         │ creates
         │
         │ Many
         ▼
┌─────────────────────────────┐         ┌──────────────────────┐
│          posts              │         │   post_categories    │
│─────────────────────────────│         │──────────────────────│
│ id (PK)                     │         │ id (PK)              │
│ title                       │         │ name                 │
│ slug (unique)               │         │ slug (unique)        │
│ description                 │         │ description          │
│ content                     │         │ icon                 │
│ facebook_video_url          │  Many   │ order                │
│ video_embed_code            │ ◄─────┐ │ is_active            │
│ video_file_url              │       │ │ created_at           │
│ video_type                  │       1 │ updated_at           │
│ thumbnail                   │ belongs │                      │
│ title_thumbnail             │    to   │                      │
│ category_id (FK) ───────────┼─────────┘                      │
│ user_id (FK) ───────────────┘                                │
│ status                                                        │
│ is_featured                                                   │
│ views                                                         │
│ published_at                                                  │
│ created_at                                                    │
│ updated_at                                                    │
└───────────────────────────────────────────────────────────────┘


┌─────────────────────────┐
│   adsense_settings      │
│─────────────────────────│
│ id (PK)                 │
│ name                    │
│ position                │
│ ad_code                 │
│ is_active               │
│ order                   │
│ created_at              │
│ updated_at              │
└─────────────────────────┘
```

---

## Relationship Explanation

### 1. User → Posts (One-to-Many)
- **One user** can create **many posts**
- Each post belongs to exactly one user (author)
- Foreign Key: `posts.user_id` → `users.id`
- On Delete: CASCADE (if user deleted, their posts are deleted)

```php
// In User model
public function posts() {
    return $this->hasMany(Post::class);
}

// Usage
$user = User::find(1);
$userPosts = $user->posts; // Get all posts by this user
```

### 2. PostCategory → Posts (One-to-Many)
- **One category** can have **many posts**
- Each post belongs to one category (optional)
- Foreign Key: `posts.category_id` → `post_categories.id`
- On Delete: SET NULL (if category deleted, posts remain but category_id becomes null)

```php
// In PostCategory model
public function posts() {
    return $this->hasMany(Post::class, 'category_id');
}

// Usage
$category = PostCategory::find(1);
$categoryPosts = $category->posts; // Get all posts in this category
```

### 3. Post → User (Belongs To)
```php
// In Post model
public function user() {
    return $this->belongsTo(User::class);
}

// Usage
$post = Post::find(1);
$author = $post->user; // Get the author of this post
```

### 4. Post → PostCategory (Belongs To)
```php
// In Post model
public function category() {
    return $this->belongsTo(PostCategory::class, 'category_id');
}

// Usage
$post = Post::find(1);
$category = $post->category; // Get the category of this post
```

---

## Data Flow Examples

### Example 1: Creating a Post
```php
$user = User::find(1); // Get admin user
$category = PostCategory::where('slug', 'entertainment')->first();

$post = Post::create([
    'title' => 'My Amazing Video',
    'description' => 'Check out this cool video',
    'facebook_video_url' => 'https://facebook.com/watch?v=123',
    'category_id' => $category->id,
    'user_id' => $user->id,
    'status' => 'published',
    'published_at' => now(),
]);

// Slug auto-generated: "my-amazing-video"
// Video type auto-detected: "facebook"
```

### Example 2: Querying Related Data
```php
// Get post with its category and author
$post = Post::with(['category', 'user'])->find(1);

echo $post->title;              // "My Amazing Video"
echo $post->category->name;     // "Entertainment"
echo $post->user->name;         // "Admin User"
```

### Example 3: Get All Posts in a Category
```php
$category = PostCategory::where('slug', 'music')->first();
$musicPosts = $category->posts()
    ->where('status', 'published')
    ->orderBy('published_at', 'desc')
    ->get();
```

### Example 4: Get All Posts by a User
```php
$user = User::find(1);
$userPosts = $user->posts()
    ->where('status', 'published')
    ->count();

echo "User has {$userPosts} published posts";
```

---

## Field Types & Constraints

### Primary Keys (PK)
- `id` - Auto-incrementing integer, unique identifier

### Foreign Keys (FK)
- `posts.user_id` → `users.id` (CASCADE on delete)
- `posts.category_id` → `post_categories.id` (SET NULL on delete)

### Unique Constraints
- `posts.slug` - Must be unique across all posts
- `post_categories.slug` - Must be unique across all categories
- `users.email` - Must be unique across all users

### Indexes
- `posts` table has index on `(status, published_at)` for fast queries
- `posts` table has index on `is_featured` for homepage queries

### Enums
- `posts.status` - Can only be: 'draft', 'published', 'archived'
- `posts.video_type` - Can only be: 'facebook', 'youtube', 'iframe', 'direct'
- `users.role` - Can only be: 'admin', 'user', 'instructor'

### Booleans
- `posts.is_featured` - true/false
- `post_categories.is_active` - true/false
- `adsense_settings.is_active` - true/false

### Nullable Fields
- `posts.description` - Optional
- `posts.content` - Optional
- `posts.category_id` - Optional (post can exist without category)
- `posts.thumbnail` - Optional
- All video-related fields are optional

---

## Sample Data After Seeding

### Users Table (1 record)
```
id | name       | email               | role
1  | Admin User | admin@example.com   | admin
```

### Post Categories Table (6 records)
```
id | name          | slug          | icon              | order
1  | Entertainment | entertainment | fas fa-film       | 1
2  | Music         | music         | fas fa-music      | 2
3  | Gaming        | gaming        | fas fa-gamepad    | 3
4  | Sports        | sports        | fas fa-football   | 4
5  | News          | news          | fas fa-newspaper  | 5
6  | Comedy        | comedy        | fas fa-laugh      | 6
```

### Posts Table (20 records)
```
id | title                          | category_id | user_id | status    | is_featured
1  | Amazing Football Highlights    | 4           | 1       | published | true
2  | Funny Cat Compilation          | 1           | 1       | published | true
3  | Latest Music Video Release     | 2           | 1       | published | true
... (17 more posts)
```

---

## Query Performance Tips

### Use Eager Loading
```php
// ❌ Bad (N+1 problem)
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->category->name; // Queries database each time
}

// ✅ Good (1 query for posts, 1 for categories)
$posts = Post::with('category')->get();
foreach ($posts as $post) {
    echo $post->category->name; // No additional queries
}
```

### Use Indexes
```php
// Fast (uses index)
Post::where('status', 'published')
    ->where('published_at', '<=', now())
    ->get();

// Fast (uses index)
Post::where('is_featured', true)->get();
```

### Count Related Records
```php
// Get categories with post counts
$categories = PostCategory::withCount('posts')->get();

foreach ($categories as $category) {
    echo "{$category->name}: {$category->posts_count} posts";
}
```
