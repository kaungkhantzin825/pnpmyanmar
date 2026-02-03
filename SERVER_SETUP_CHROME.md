# Server Setup: Install Chrome for Title Image Generation

## Problem

Error: `Could not find Chrome (ver. 121.0.6167.85)`

This means Puppeteer cannot find Chrome/Chromium browser on your Linux server.

## Solution

### Option 1: Quick Install (Recommended)

SSH into your server and run:

```bash
# Upload the install script to your server, then:
sudo bash install-chrome-server.sh
```

### Option 2: Manual Installation

SSH into your server and run these commands:

```bash
# 1. Update package list
sudo apt update

# 2. Install Chromium
sudo apt install -y chromium-browser

# 3. Install dependencies
sudo apt install -y \
    ca-certificates \
    fonts-liberation \
    fonts-noto \
    libappindicator3-1 \
    libasound2 \
    libatk-bridge2.0-0 \
    libatk1.0-0 \
    libgbm1 \
    libgtk-3-0 \
    libnss3 \
    libxss1

# 4. Set permissions
sudo mkdir -p /var/www/.cache/puppeteer
sudo chown -R www-data:www-data /var/www/.cache
sudo chmod -R 755 /var/www/.cache

# 5. Test installation
cd /var/www/html/pnpmyanmar/scripts
node generate-image.js "Test Title" test.png
```

### Option 3: Use Puppeteer's Chrome

```bash
# Go to scripts directory
cd /var/www/html/pnpmyanmar/scripts

# Install Chrome via Puppeteer
npx puppeteer browsers install chrome

# This will download Chrome to:
# /var/www/.cache/puppeteer/chrome/
```

## Verify Installation

After installation, test the image generation:

```bash
cd /var/www/html/pnpmyanmar/scripts
node generate-image.js "ကမ္ဘာ့သတင်း" test.png
```

If successful, you should see:
```
Image generated successfully: test.png
```

## Troubleshooting

### Error: Permission denied

```bash
sudo chown -R www-data:www-data /var/www/html/pnpmyanmar
sudo chmod -R 755 /var/www/html/pnpmyanmar/storage
```

### Error: Chrome still not found

Check where Chromium is installed:

```bash
which chromium-browser
which chromium
which google-chrome
```

Then update `scripts/generate-image.js` line 3 with the correct path.

### Error: Missing dependencies

Install all dependencies:

```bash
sudo apt install -y \
    chromium-browser \
    fonts-noto \
    fonts-noto-cjk \
    fonts-noto-color-emoji
```

## Server Requirements

- **OS:** Ubuntu 20.04+ or Debian 10+
- **RAM:** Minimum 1GB (2GB recommended)
- **Disk:** 500MB free space for Chrome
- **Node.js:** v18+ (already installed ✓)
- **PHP:** 8.0+ (already installed ✓)

## What Gets Installed

1. **Chromium Browser** (~200MB) - Headless browser for rendering
2. **System Fonts** (~50MB) - Including Noto Sans Myanmar
3. **Dependencies** (~100MB) - Required libraries for Chrome
4. **Total:** ~350MB disk space

## After Installation

Once Chrome is installed, the title image generation will work automatically:

1. Create/edit post in admin panel
2. Enter title with asterisks: `သတင်း * ကမ္ဘာ့သတင်း * ၂၀၂၆`
3. Check "Generate from title text"
4. Save
5. Image automatically generated! ✓

## Alternative: Manual Upload

If you cannot install Chrome on the server:

1. Generate images locally on your Windows machine
2. Upload them manually using "Upload Title Image" field
3. This works without Chrome on the server

---

**Need help?** Check the error logs:
```bash
tail -f /var/www/html/pnpmyanmar/storage/logs/laravel.log
```
