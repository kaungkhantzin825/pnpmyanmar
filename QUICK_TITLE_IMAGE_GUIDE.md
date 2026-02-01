# Quick Guide: Title Image Generation

## ✅ System Status
- **Node.js:** v22.13.1 ✓ Installed
- **Puppeteer:** ✓ Installed in `scripts/`
- **Integration:** ✓ Complete
- **Myanmar Unicode:** ✓ Fully Supported

## 🚀 How to Use

### Step 1: Create/Edit a Post
Go to: **Admin Dashboard → Blog Posts → Create New Post**

### Step 2: Format Your Title
Use asterisks to mark the text you want in the image:

```
မြန်မာစာ * ကမ္ဘာ့သတင်း သုံးသပ်ချက် * ၁၀၆
         ↑                           ↑
    Text between asterisks will be used for the image
```

**Result:** Image will show: `ကမ္ဘာ့သတင်း သုံးသပ်ချက်`

### Step 3: Enable Auto-Generation
☑ Check the **"Generate from title text"** checkbox

### Step 4: Save
Click **Save** or **Update**

## 📝 Examples

| Title Format | Image Text |
|-------------|------------|
| `သတင်း * နိုင်ငံတကာ အခြေအနေ * ၂၀၂၆` | `နိုင်ငံတကာ အခြေအနေ` |
| `ကမ္ဘာ့သတင်း သုံးသပ်ချက်` | `ကမ္ဘာ့သတင်း သုံးသပ်ချက်` (full title) |
| `Politics * Government Policy Update * 2026` | `Government Policy Update` |

## 🎨 Image Specifications
- **Size:** 1200 × 250 pixels (optimized for Myanmar diacritics)
- **Format:** PNG
- **Background:** White
- **Font:** Noto Sans Myanmar Bold (Google Fonts)
- **Font Size:** 48px (prevents clipping)
- **Text Color:** Black
- **Layout:** Single line, centered, proper spacing
- **Padding:** 30px vertical (prevents header/diacritic clipping)
- **Quality:** High DPI (2x scale factor)

## 🔧 Manual Test
Test the generator directly:

```bash
cd scripts
node generate-image.js "ကမ္ဘာ့သတင်း" test.png
```

## 📍 Where Images Are Stored
- **Storage:** `storage/app/public/posts/thumbnails/`
- **Public URL:** `http://yoursite.com/storage/posts/thumbnails/filename.png`

## 💡 Tips
1. **Keep text short** - Long titles may wrap to multiple lines
2. **Use asterisks** - Extract only the important part for the image
3. **Test first** - Use the manual test command to preview
4. **Upload option** - You can still upload custom images instead

## ⚠️ Troubleshooting

**Image not showing?**
- Check if checkbox was checked
- Verify Node.js is in PATH: `node --version`
- Check Laravel logs: `storage/logs/laravel.log`

**Myanmar text broken?**
- This should NOT happen (Puppeteer uses proper fonts)
- Check internet connection (Google Fonts needs to load)

**Permission error?**
```bash
icacls storage /grant Users:F /T
```

## 📚 Full Documentation
See `TITLE_IMAGE_FEATURE.md` for complete technical details.
