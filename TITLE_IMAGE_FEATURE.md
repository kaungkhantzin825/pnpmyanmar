# Title Image Generation Feature

## Overview
The PNP Myanmar News system can automatically generate beautiful title images with proper Myanmar Unicode text rendering using Node.js + Puppeteer.

## How It Works

### 1. Text Extraction from Title
If your post title contains asterisks, the system will extract the text between them for the image:

**Example:**
- Title: `မြန်မာစာ * ကမ္ဘာ့သတင်း သုံးသပ်ချက် * ၁၀၆`
- Extracted text for image: `ကမ္ဘာ့သတင်း သုံးသပ်ချက်`

If no asterisks are present, the entire title will be used.

### 2. Image Specifications
- **Size:** 1200x630 pixels (optimized for social media)
- **Format:** PNG
- **Background:** Blue gradient (#1E40AF to #3B82F6)
- **Font:** Noto Sans Myanmar (loaded from Google Fonts)
- **Branding:** "PNP Myanmar News" at the bottom

### 3. Myanmar Unicode Support
The system uses Puppeteer (headless Chrome) to render text, which provides:
- ✅ Proper Myanmar Unicode shaping (characters display correctly)
- ✅ Myanmar numerals (၀-၉) render correctly
- ✅ Complex text layout support
- ✅ All Myanmar Unicode characters supported

## Usage

### Creating a New Post with Title Image

1. Go to Admin Dashboard → Blog Posts → Create New Post
2. Enter your title with asterisks if you want to extract specific text:
   - Example: `သတင်း * ကမ္ဘာ့စီးပွားရေး အခြေအနေ * ၂၀၂၆`
3. Check the **"Generate from title text"** checkbox
4. Fill in other fields (description, content, etc.)
5. Click **Save**

The system will automatically:
- Extract text between asterisks
- Generate a 1200x630 PNG image with proper Myanmar text
- Save it to `storage/app/public/posts/thumbnails/`
- Display it above the title on the post page

### Updating an Existing Post

1. Go to Admin Dashboard → Blog Posts → Edit
2. Modify the title if needed
3. Check **"Generate from title text"** to regenerate the image
4. Click **Update**

The old title image will be deleted and a new one will be generated.

### Manual Upload Option

If you prefer to use your own image:
1. Uncheck **"Generate from title text"**
2. Use the **"Upload Title Image"** field to upload your custom image
3. Uploaded images take precedence over generated ones

## Technical Details

### System Requirements
- ✅ Node.js v22.13.1 (installed)
- ✅ Puppeteer package (installed in `scripts/` directory)
- ✅ Internet connection (for Google Fonts)

### File Locations
- **Node.js Script:** `scripts/generate-image.js`
- **PHP Controller:** `app/Http/Controllers/Admin/BlogAdminController.php`
- **Generated Images:** `storage/app/public/posts/thumbnails/`
- **Public Access:** `http://yoursite.com/storage/posts/thumbnails/filename.png`

### How PHP Calls Node.js

The `generateThumbnailFromText()` method in BlogAdminController:
1. Extracts text between asterisks using regex
2. Generates a unique filename
3. Calls Node.js script via `shell_exec()`:
   ```bash
   cd scripts && node generate-image.js "ကမ္ဘာ့သတင်း" output.png
   ```
4. Checks if the file was created successfully
5. Returns the filename to save in the database

## Testing

### Manual Test
You can test the image generation directly:

```bash
cd scripts
node generate-image.js "ကမ္ဘာ့သတင်း သုံးသပ်ချက်" test.png
```

This will create `test.png` in the scripts directory.

### Test with Different Text
```bash
# Myanmar text
node generate-image.js "နိုင်ငံတကာ သတင်းများ" output1.png

# Myanmar with numerals
node generate-image.js "သတင်း ၂၀၂၆ ခုနှစ်" output2.png

# Mixed Myanmar and English
node generate-image.js "PNP Myanmar News Update" output3.png
```

## Troubleshooting

### Image Not Generated
**Symptoms:** Checkbox is checked but no image appears

**Solutions:**
1. Check if Node.js is in PATH:
   ```bash
   node --version
   ```
   Should show: `v22.13.1` or similar

2. Check if Puppeteer is installed:
   ```bash
   cd scripts
   dir node_modules\puppeteer
   ```

3. Check Laravel logs:
   ```bash
   type storage\logs\laravel.log
   ```

### Myanmar Text Shows as Boxes
**Cause:** This should NOT happen with the new system (Puppeteer uses Google Fonts)

**If it still happens:**
1. Check internet connection (Google Fonts needs to load)
2. Verify the script is using Puppeteer, not GD fallback
3. Check the generated image directly in `storage/app/public/posts/thumbnails/`

### Permission Errors
**Symptoms:** "Failed to create directory" or "Permission denied"

**Solution:**
```bash
# Give write permissions to storage
icacls storage /grant Users:F /T
```

## Examples

### Example 1: Politics News
**Title:** `နိုင်ငံရေး * အစိုးရ မူဝါဒ အသစ် ထုတ်ပြန် * ၂၀၂၆`
**Extracted:** `အစိုးရ မူဝါဒ အသစ် ထုတ်ပြန်`
**Result:** Blue gradient image with Myanmar text centered

### Example 2: Business News
**Title:** `စီးပွားရေး * ရန်ကုန် စတော့အိတ်ချိန်း မြင့်တက် * ဖေဖော်ဝါရီ`
**Extracted:** `ရန်ကုန် စတော့အိတ်ချိန်း မြင့်တက်`
**Result:** Professional title image with proper Myanmar shaping

### Example 3: Simple Title (No Asterisks)
**Title:** `ကမ္ဘာ့သတင်း သုံးသပ်ချက်`
**Extracted:** `ကမ္ဘာ့သတင်း သုံးသပ်ချက်` (entire title)
**Result:** Full title rendered in image

## Display on Frontend

The title image is displayed on the post detail page (`resources/views/blog/show.blade.php`):

```php
@if($post->title_thumbnail)
    <div class="mb-4">
        <img src="{{ Storage::url($post->title_thumbnail) }}" 
             alt="{{ $post->title }}" 
             class="img-fluid rounded shadow-sm">
    </div>
@endif
```

The image appears:
- Above the text title
- Full width (responsive)
- With rounded corners and shadow
- Only if `title_thumbnail` field is not null

## Future Enhancements

Possible improvements:
- [ ] Add color scheme options (blue, red, green, etc.)
- [ ] Support for custom background images
- [ ] Multiple font choices
- [ ] Text size adjustment based on length
- [ ] Preview before saving
- [ ] Batch regeneration for existing posts

## Summary

✅ **Working:** Node.js + Puppeteer integration complete
✅ **Working:** Myanmar Unicode text renders correctly
✅ **Working:** Asterisk extraction feature implemented
✅ **Working:** Auto-generation on create/update
✅ **Working:** Manual upload option available
✅ **Working:** Frontend display configured

The title image generation feature is fully functional and ready to use!
