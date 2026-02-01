# 🔧 Troubleshooting Guide

## ✅ Fixed: Redirect Error on /blog

### Problem
When visiting `http://127.0.0.1:8000/blog`, you were getting a redirect error.

### Root Cause
The `RouteServiceProvider` had `HOME` constant set to `/home`, but that route doesn't exist in your application.

### Solution Applied
Changed `app/Providers/RouteServiceProvider.php`:
```php
// Before
public const HOME = '/home';

// After
public const HOME = '/blog';
```

### Additional Fixes Applied
1. ✅ Cleared application cache
2. ✅ Cleared configuration cache
3. ✅ Cleared route cache
4. ✅ Cleared view cache
5. ✅ Created storage symlink

---

## 🚀 How to Start Your Application

### Option 1: Using PHP Built-in Server
```bash
php artisan serve
```
Then visit: http://127.0.0.1:8000/blog

### Option 2: Using XAMPP/WAMP
1. Make sure Apache and MySQL are running
2. Point your virtual host to the `public` folder
3. Visit: http://localhost/blog

---

## 🔍 Common Issues & Solutions

### Issue 1: "Target class [DatabaseSeeder] does not exist"
**Solution:**
```bash
composer dump-autoload
php artisan db:seed
```

### Issue 2: "No application encryption key"
**Solution:**
```bash
php artisan key:generate
```

### Issue 3: "Database connection error"
**Solution:**
Check your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pnpblg
DB_USERNAME=root
DB_PASSWORD=
```
Make sure MySQL is running and database exists.

### Issue 4: "Storage link not found" or images not showing
**Solution:**
```bash
php artisan storage:link
```

### Issue 5: "Class not found" errors
**Solution:**
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Issue 6: Changes not reflecting
**Solution:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Issue 7: "419 Page Expired" on form submission
**Solution:**
Make sure your forms have CSRF token:
```blade
@csrf
```

### Issue 8: Redirect loop
**Solution:**
Check middleware in routes and `RouteServiceProvider::HOME` constant.

---

## 📊 Verify Everything is Working

### 1. Check Database Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### 2. Check if Data Exists
```bash
php artisan tinker
>>> \App\Models\Post::count()
>>> \App\Models\PostCategory::count()
>>> \App\Models\User::count()
```

### 3. Check Routes
```bash
php artisan route:list
```

### 4. Check if Blog Page Loads
Visit: http://127.0.0.1:8000/blog

You should see:
- Featured video carousel at the top
- 3 featured posts section
- Grid of all blog posts
- Pagination at the bottom

---

## 🎯 Test Your Application

### Test 1: View Blog Homepage
```
URL: http://127.0.0.1:8000/blog
Expected: See list of 20 posts with categories
```

### Test 2: View Single Post
```
URL: http://127.0.0.1:8000/blog/amazing-football-highlights-2024
Expected: See post details with video
```

### Test 3: View Category
```
URL: http://127.0.0.1:8000/blog/category/sports
Expected: See all posts in Sports category
```

### Test 4: Search Posts
```
URL: http://127.0.0.1:8000/blog/search?q=football
Expected: See search results for "football"
```

### Test 5: Admin Login
```
URL: http://127.0.0.1:8000/login
Email: admin@example.com
Password: password
Expected: Redirect to admin dashboard
```

---

## 🛠️ Useful Commands Reference

### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Reset Database
```bash
php artisan migrate:fresh --seed
```

### Check Application Status
```bash
php artisan about
```

### View All Routes
```bash
php artisan route:list
```

### Interactive Shell
```bash
php artisan tinker
```

### Generate New Key
```bash
php artisan key:generate
```

### Create Storage Link
```bash
php artisan storage:link
```

---

## 📝 Development Tips

### Enable Debug Mode
In `.env`:
```env
APP_DEBUG=true
```

### Check Laravel Logs
Location: `storage/logs/laravel.log`

### View SQL Queries
Add to any controller:
```php
DB::enableQueryLog();
// Your code here
dd(DB::getQueryLog());
```

### Test Email Locally
Use Mailtrap or MailHog for testing emails without sending real emails.

---

## 🆘 Still Having Issues?

1. Check `storage/logs/laravel.log` for error details
2. Make sure all file permissions are correct
3. Verify PHP version (Laravel 10 requires PHP 8.1+)
4. Check if all required PHP extensions are installed
5. Run `composer install` to ensure all dependencies are installed

### Check PHP Version
```bash
php -v
```

### Check Required Extensions
```bash
php -m
```

Required extensions:
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
