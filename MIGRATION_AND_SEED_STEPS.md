# 🚀 Migration and Seeding Steps

## Prerequisites
1. Make sure MySQL/MariaDB is running
2. Database `pnpblg` should exist (or create it)
3. Composer dependencies installed

---

## Step 1: Install Dependencies (if not done)
```bash
composer install
```

---

## Step 2: Generate Application Key
```bash
php artisan key:generate
```

---

## Step 3: Run Migrations
This creates all database tables.

### Option A: Fresh Migration (Recommended for first time)
```bash
php artisan migrate:fresh
```
This drops all tables and recreates them.

### Option B: Regular Migration
```bash
php artisan migrate
```
This only runs new migrations.

---

## Step 4: Run Seeder
This populates the database with sample data.

```bash
php artisan db:seed --class=BlogSeeder
```

### Or combine migration + seeding:
```bash
php artisan migrate:fresh --seed
```

---

## 🎯 What Gets Created

### After Migration:
- ✅ `post_categories` table (empty)
- ✅ `posts` table (empty)
- ✅ `adsense_settings` table (empty)
- ✅ `users` table (empty)
- ✅ Other system tables

### After Seeding:
- ✅ 1 Admin user (email: admin@example.com, password: password)
- ✅ 6 Categories (Entertainment, Music, Gaming, Sports, News, Comedy)
- ✅ 20 Sample blog posts with videos

---

## 🔍 Verify Data

### Check tables exist:
```bash
php artisan tinker
>>> Schema::hasTable('posts')
>>> Schema::hasTable('post_categories')
```

### Count records:
```bash
php artisan tinker
>>> \App\Models\Post::count()
>>> \App\Models\PostCategory::count()
>>> \App\Models\User::count()
```

### View sample data:
```bash
php artisan tinker
>>> \App\Models\PostCategory::all()
>>> \App\Models\Post::with('category')->first()
```

---

## 🐛 Troubleshooting

### Error: "Database does not exist"
Create the database first:
```sql
CREATE DATABASE pnpblg CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Error: "Access denied for user"
Check your .env file:
```
DB_DATABASE=pnpblg
DB_USERNAME=root
DB_PASSWORD=
```

### Error: "Class not found"
Run:
```bash
composer dump-autoload
```

### Error: "No application encryption key"
Run:
```bash
php artisan key:generate
```

---

## 📊 Database Structure Quick Reference

```
users
├── id
├── name
├── email
├── password
└── role (admin/user)

post_categories
├── id
├── name (Entertainment, Music, etc.)
├── slug (entertainment, music, etc.)
├── icon (fas fa-film, etc.)
└── is_active

posts
├── id
├── title
├── slug
├── description
├── facebook_video_url
├── video_type (facebook/youtube/iframe/direct)
├── video_embed_code
├── thumbnail
├── category_id → post_categories.id
├── user_id → users.id
├── status (draft/published/archived)
├── is_featured
├── views
└── published_at

adsense_settings
├── id
├── name
├── position (header/sidebar/footer/etc.)
├── ad_code
└── is_active
```

---

## 🎓 Next Steps After Seeding

1. **Login to admin panel:**
   - URL: http://localhost/login
   - Email: admin@example.com
   - Password: password

2. **View blog posts:**
   - URL: http://localhost/blog

3. **Explore the data:**
   ```bash
   php artisan tinker
   >>> $post = \App\Models\Post::first()
   >>> $post->title
   >>> $post->category->name
   >>> $post->user->name
   ```

4. **Create your own post:**
   - Go to admin panel
   - Navigate to Blog Posts
   - Click "Create New Post"

---

## 💡 Useful Artisan Commands

```bash
# View all routes
php artisan route:list

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Reset database and reseed
php artisan migrate:fresh --seed

# Run specific seeder
php artisan db:seed --class=BlogSeeder

# Create new migration
php artisan make:migration create_table_name

# Create new model
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName
```
