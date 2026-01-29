# Video Blog - Facebook Video Sharing Platform

A Laravel-based video blog platform for sharing Facebook videos with AdSense integration and AdminLTE admin panel.

## Features

### Frontend
- Clean, responsive design with Tailwind CSS
- Facebook video embedding
- Category browsing
- Search functionality
- View counter
- Featured posts
- Related videos

### Admin Panel (AdminLTE)
- Dashboard with statistics
- Post management (Create, Edit, Delete)
- Category management
- AdSense ad management with position control
- User-friendly interface

### AdSense Integration
- Strategic ad placement to avoid invalid traffic
- 6 ad positions:
  - Header (top of page)
  - Sidebar (recommended)
  - Content Top (before video)
  - Content Middle (after video - recommended)
  - Content Bottom (after description)
  - Footer (bottom of page)
- Ad management system
- Best practices built-in

## Installation

1. **Run Migrations**
```bash
php artisan migrate
```

2. **Run Seeder (Optional - creates sample data)**
```bash
php artisan db:seed --class=BlogSeeder
```

3. **Create Storage Link**
```bash
php artisan storage:link
```

4. **Update .env file**
Add these if not present:
```
APP_NAME="VideoShare"
```

## Usage

### Admin Access
- URL: `/admin/dashboard`
- Default credentials (if using seeder):
  - Email: admin@example.com
  - Password: password

### Creating Posts
1. Go to Admin Panel → Blog Management → Add New Post
2. Enter title and description
3. Paste Facebook video URL (e.g., https://www.facebook.com/watch?v=123456789)
4. Select category
5. Upload thumbnail (optional)
6. Set status to "Published"
7. Click "Create Post"

### Managing AdSense Ads
1. Go to Admin Panel → AdSense Ads
2. Click "Add New Ad"
3. Enter ad name
4. Select position (recommended: sidebar, content_middle, footer)
5. Paste your AdSense code
6. Set as Active
7. Click "Save Ad"

## AdSense Best Practices

### Recommended Ad Placements
- **Sidebar**: Always visible, non-intrusive
- **Content Middle**: High visibility after video
- **Footer**: Natural placement at page end

### Avoid Invalid Traffic
- Don't place too many ads (max 2-3 per page)
- Keep ads away from navigation/buttons
- Don't encourage clicks
- Monitor traffic quality
- Use natural placements

### Ad Position Guide
- **Header**: Use sparingly, can be intrusive
- **Sidebar**: Best for desktop users (recommended)
- **Content Top**: Before video, moderate visibility
- **Content Middle**: After video, high engagement (recommended)
- **Content Bottom**: After all content
- **Footer**: Natural end-of-page placement (recommended)

## Routes

### Public Routes
- `/blog` - Homepage with all videos
- `/blog/{slug}` - Single video page
- `/blog/category/{slug}` - Category page
- `/blog/search?q=query` - Search results

### Admin Routes (requires authentication + admin role)
- `/admin/dashboard` - Admin dashboard
- `/admin/blog/posts` - Manage posts
- `/admin/blog/categories` - Manage categories
- `/admin/adsense` - Manage ads

## Facebook Video URL Formats Supported
- https://www.facebook.com/watch?v=VIDEO_ID
- https://www.facebook.com/username/videos/VIDEO_ID
- https://fb.watch/SHORT_CODE

## Security Features
- Role-based access control
- CSRF protection
- XSS protection
- SQL injection prevention
- Secure file uploads

## Tips for Success

### Content Strategy
1. Post regularly (daily if possible)
2. Use engaging titles
3. Add detailed descriptions
4. Categorize properly
5. Feature your best content

### SEO Optimization
- Use descriptive titles
- Write good descriptions
- Add relevant categories
- Use proper thumbnails
- Monitor view counts

### AdSense Optimization
- Start with 2-3 ads per page
- Test different positions
- Monitor click-through rates
- Avoid ad blindness
- Keep content quality high

## Troubleshooting

### Videos not showing
- Check Facebook video URL is correct
- Ensure video is public
- Try different URL format

### Ads not displaying
- Verify ad code is correct
- Check ad is set to "Active"
- Ensure position is correct
- Clear browser cache

### Permission errors
- Run: `php artisan storage:link`
- Check storage folder permissions
- Verify user has admin role

## Support

For issues or questions, check:
- Laravel documentation: https://laravel.com/docs
- AdminLTE documentation: https://adminlte.io/docs
- Google AdSense help: https://support.google.com/adsense

## License

This project is open-sourced software licensed under the MIT license.
