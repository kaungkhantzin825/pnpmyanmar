# Quick Start Guide

## Fastest Way to Get Started

### Option 1: Automated Setup (Windows)

Simply run the setup script:
```bash
setup.bat
```

This will:
- Install all dependencies
- Set up environment
- Run migrations
- Create sample data
- Create admin user

### Option 2: Manual Setup (All Platforms)

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
# Edit .env with your database credentials

# 3. Generate key
php artisan key:generate

# 4. Run migrations
php artisan migrate

# 5. Create storage link
php artisan storage:link

# 6. Seed database (optional)
php artisan db:seed --class=BlogSeeder

# 7. Start server
php artisan serve
```

## Access Your Site

- **Frontend:** http://localhost:8000/blog
- **Admin Panel:** http://localhost:8000/admin/dashboard

## Default Login

- **Email:** admin@example.com
- **Password:** password

⚠️ **Change this password immediately in production!**

## First Steps

### 1. Create a Category
1. Login to admin panel
2. Go to "Blog Management" → "Categories"
3. Click "Add Category"
4. Enter name (e.g., "Entertainment")
5. Add icon (e.g., "fas fa-film")
6. Save

### 2. Create Your First Post
1. Go to "Blog Management" → "Add New Post"
2. Enter title: "My First Video"
3. Paste Facebook video URL
4. Select category
5. Set status to "Published"
6. Click "Create Post"

### 3. Set Up AdSense (Optional)
1. Get your AdSense code from Google
2. Go to "AdSense Ads"
3. Click "Add New Ad"
4. Select position: "Sidebar" (recommended)
5. Paste your ad code
6. Save

## Facebook Video URLs

You can use any of these formats:
- `https://www.facebook.com/watch?v=123456789`
- `https://www.facebook.com/username/videos/123456789`
- `https://fb.watch/abc123`

## Recommended Ad Setup

For best results, use these 3 ad positions:

1. **Sidebar** (300x250 or 300x600)
   - Always visible
   - Non-intrusive
   - High viewability

2. **Content Middle** (728x90 or 336x280)
   - After video
   - High engagement
   - Natural placement

3. **Footer** (728x90)
   - End of page
   - Doesn't interfere with content

## Tips for Success

### Content Strategy
- Post regularly (daily is best)
- Use engaging titles
- Add good descriptions
- Categorize properly
- Feature your best videos

### AdSense Best Practices
- Start with 2-3 ads per page
- Don't place ads near buttons
- Monitor your traffic quality
- Test different positions
- Keep content quality high

### SEO Tips
- Use descriptive titles
- Write detailed descriptions
- Add relevant categories
- Use good thumbnails
- Share on social media

## Common Tasks

### Add a New Admin User
```bash
php artisan tinker
```
Then:
```php
$user = new App\Models\User();
$user->name = 'New Admin';
$user->email = 'newadmin@example.com';
$user->password = bcrypt('password');
$user->role = 'admin';
$user->save();
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Backup Database
```bash
mysqldump -u username -p database_name > backup.sql
```

## Troubleshooting

### Videos Not Showing?
- Check if video is public on Facebook
- Try different URL format
- Clear browser cache

### Can't Upload Images?
```bash
php artisan storage:link
chmod -R 775 storage
```

### Class Not Found?
```bash
composer dump-autoload
```

### Page Expired (419)?
```bash
php artisan cache:clear
```

## Next Steps

1. ✅ Complete setup
2. ✅ Login to admin
3. ✅ Create categories
4. ✅ Add your first post
5. ✅ Set up AdSense
6. ✅ Customize design
7. ✅ Share your site!

## Need More Help?

- **Full Documentation:** See INSTALLATION_GUIDE.md
- **Features Guide:** See README_BLOG.md
- **Laravel Docs:** https://laravel.com/docs

## Production Checklist

Before going live:
- [ ] Change admin password
- [ ] Set APP_ENV=production
- [ ] Set APP_DEBUG=false
- [ ] Configure proper database
- [ ] Set up HTTPS
- [ ] Optimize application
- [ ] Set up backups
- [ ] Configure caching
- [ ] Test everything

## Support

If you encounter issues:
1. Check the error message
2. Review the documentation
3. Clear all caches
4. Check file permissions
5. Verify database connection

Happy blogging! 🎥✨
