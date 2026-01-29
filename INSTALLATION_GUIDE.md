# Installation Guide - Video Blog Platform

## Step-by-Step Installation

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Environment Setup

Copy the `.env.example` to `.env`:
```bash
copy .env.example .env
```

Update your `.env` file with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Create Storage Link

```bash
php artisan storage:link
```

### 6. Seed Database (Optional)

This creates sample data including an admin user:
```bash
php artisan db:seed --class=BlogSeeder
```

**Default Admin Credentials:**
- Email: admin@example.com
- Password: password

### 7. Compile Assets

```bash
npm run build
```

For development:
```bash
npm run dev
```

### 8. Start Development Server

```bash
php artisan serve
```

Visit: http://localhost:8000/blog

## Post-Installation Setup

### Create Admin User Manually (if not using seeder)

```bash
php artisan tinker
```

Then run:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = bcrypt('your-password');
$user->role = 'admin';
$user->save();
```

### Configure File Permissions (Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Setting Up AdSense

### 1. Get Your AdSense Account
- Sign up at https://www.google.com/adsense
- Wait for approval
- Create ad units

### 2. Add Ads in Admin Panel
1. Login to admin panel: `/admin/dashboard`
2. Go to "AdSense Ads"
3. Click "Add New Ad"
4. Paste your AdSense code
5. Select position
6. Save

### 3. Recommended Ad Setup

**For Best Results:**
1. **Sidebar Ad** (300x600 or 300x250)
   - Position: Sidebar
   - Always visible on desktop

2. **Content Middle Ad** (728x90 or 336x280)
   - Position: Content Middle
   - High engagement after video

3. **Footer Ad** (728x90)
   - Position: Footer
   - Natural placement

**Avoid:**
- Too many ads (max 3 per page)
- Ads near navigation
- Misleading placements

## Creating Your First Post

1. Login to admin panel
2. Go to "Blog Management" → "Add New Post"
3. Enter title and description
4. Paste Facebook video URL
5. Select category
6. Upload thumbnail (optional)
7. Set status to "Published"
8. Click "Create Post"

## Facebook Video URL Examples

Valid formats:
- `https://www.facebook.com/watch?v=123456789`
- `https://www.facebook.com/username/videos/123456789`
- `https://fb.watch/abc123`

## Troubleshooting

### Videos Not Showing
**Problem:** Facebook videos not embedding
**Solution:** 
- Ensure video is public
- Check URL format
- Try different URL format from Facebook

### Storage Link Error
**Problem:** Images not showing
**Solution:**
```bash
php artisan storage:link
```

### Permission Denied
**Problem:** Can't upload files
**Solution:**
```bash
chmod -R 775 storage
chmod -R 775 public
```

### Migration Error
**Problem:** Table already exists
**Solution:**
```bash
php artisan migrate:fresh
```
⚠️ Warning: This will delete all data!

### Composer Autoload Error
**Problem:** Class not found
**Solution:**
```bash
composer dump-autoload
```

## Production Deployment

### 1. Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

### 2. Set Environment

Update `.env`:
```
APP_ENV=production
APP_DEBUG=false
```

### 3. Security Checklist

- [ ] Change APP_KEY
- [ ] Set strong database password
- [ ] Update admin password
- [ ] Enable HTTPS
- [ ] Set proper file permissions
- [ ] Configure firewall
- [ ] Enable rate limiting

### 4. Performance Tips

- Use Redis for caching
- Enable OPcache
- Use CDN for assets
- Optimize images
- Enable Gzip compression

## Maintenance

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Backup Database
```bash
mysqldump -u username -p database_name > backup.sql
```

### Update Application
```bash
git pull
composer install
php artisan migrate
php artisan cache:clear
```

## Support & Resources

- Laravel Docs: https://laravel.com/docs
- AdminLTE: https://adminlte.io
- Tailwind CSS: https://tailwindcss.com
- Google AdSense: https://support.google.com/adsense

## Common Issues

### Issue: "Class 'AdHelper' not found"
**Solution:**
```bash
composer dump-autoload
```

### Issue: "SQLSTATE[HY000] [2002] Connection refused"
**Solution:** Check database credentials in `.env`

### Issue: "The stream or file could not be opened"
**Solution:**
```bash
chmod -R 775 storage
```

### Issue: "419 Page Expired"
**Solution:** Clear browser cache or run:
```bash
php artisan cache:clear
```

## Next Steps

1. ✅ Install and configure
2. ✅ Create admin account
3. ✅ Add categories
4. ✅ Create first post
5. ✅ Set up AdSense
6. ✅ Test everything
7. ✅ Go live!

## Need Help?

Check the README_BLOG.md file for detailed feature documentation.
