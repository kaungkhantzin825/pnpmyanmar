# Myanmar Font Setup for Title Image Generation

## Step 1: Download Myanmar Font

Download **Noto Sans Myanmar** font from Google Fonts:
https://fonts.google.com/noto/specimen/Noto+Sans+Myanmar

Or download directly:
https://github.com/googlefonts/noto-fonts/raw/main/hinted/ttf/NotoSansMyanmar/NotoSansMyanmar-Bold.ttf

## Step 2: Place Font File

Save the font file to:
```
public/fonts/NotoSansMyanmar-Bold.ttf
```

## Step 3: The Code is Ready!

The BlogAdminController is already configured to use the font automatically when you:
1. Create/Edit a post
2. Add title with asterisks: `မြန်မာစာ * English Text * ၁၀၆`
3. Save the post
4. Image will be generated automatically with "English Text"

## Font File Location

```
D:\pnpmyanmar\pnpmyanmar\public\fonts\NotoSansMyanmar-Bold.ttf
```

## How to Download Font

### Option 1: Manual Download
1. Go to: https://fonts.google.com/noto/specimen/Noto+Sans+Myanmar
2. Click "Download family"
3. Extract the ZIP file
4. Find `NotoSansMyanmar-Bold.ttf`
5. Copy to `public/fonts/` folder

### Option 2: Direct Download
```bash
# Using PowerShell
Invoke-WebRequest -Uri "https://github.com/googlefonts/noto-fonts/raw/main/hinted/ttf/NotoSansMyanmar/NotoSansMyanmar-Bold.ttf" -OutFile "public/fonts/NotoSansMyanmar-Bold.ttf"
```

## Verify Font is Working

After placing the font file:
1. Go to admin panel
2. Edit any post
3. Change title to: `မြန်မာစာ * Test Title * ၁၀၆`
4. Save
5. View the post - you should see a nice image with "Test Title" in large, readable text

## Alternative Fonts (if Noto Sans doesn't work)

- **Pyidaungsu**: https://github.com/khmertype/pyidaungsu/releases
- **Padauk**: https://github.com/khmertype/padauk/releases

Just rename the file to match the code or update the font path in BlogAdminController.php
