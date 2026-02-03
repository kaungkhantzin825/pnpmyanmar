#!/bin/bash

# ============================================
# AUTOMATIC SETUP SCRIPT
# Run this on your server at /var/www/html/pnpmyanmar
# ============================================

set -e  # Exit on any error

echo "============================================"
echo "  PNP Myanmar News - Chrome Setup"
echo "  Location: /var/www/html/pnpmyanmar"
echo "============================================"
echo ""

# Check if we're in the right directory
if [[ ! -f "artisan" ]]; then
    echo "ERROR: Not in Laravel project directory!"
    echo "Please run from: /var/www/html/pnpmyanmar"
    exit 1
fi

echo "✓ Confirmed Laravel project directory"
echo ""

# Step 1: Check Node.js
echo "[1/6] Checking Node.js..."
if ! command -v node &> /dev/null; then
    echo "Installing Node.js..."
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
    apt-get install -y nodejs
fi
echo "✓ Node.js: $(node --version)"
echo ""

# Step 2: Check npm packages
echo "[2/6] Checking npm packages..."
cd scripts
if [[ ! -d "node_modules/puppeteer" ]]; then
    echo "Installing Puppeteer..."
    npm install
fi
echo "✓ Puppeteer installed"
echo ""

# Step 3: Install Chrome
echo "[3/6] Installing Chrome browser..."
echo "Downloading Chrome (this may take 2-3 minutes)..."
npx puppeteer browsers install chrome
echo "✓ Chrome installed"
echo ""

# Step 4: Test image generation
echo "[4/6] Testing image generation..."
node generate-image.js "ကမ္ဘာ့သတင်း သုံးသပ်ချက်" test-auto.png

if [[ -f "test-auto.png" ]]; then
    SIZE=$(du -h test-auto.png | cut -f1)
    echo "✓ Test successful! Generated image: $SIZE"
    rm test-auto.png
else
    echo "✗ Test failed!"
    exit 1
fi
echo ""

# Step 5: Set permissions
echo "[5/6] Setting permissions..."
cd /var/www/html/pnpmyanmar
chown -R www-data:www-data storage
chmod -R 755 storage
chown -R www-data:www-data scripts
chmod -R 755 scripts
echo "✓ Permissions set"
echo ""

# Step 6: Verify setup
echo "[6/6] Verifying setup..."
cd scripts
node generate-image.js "Test Final" test-final.png
if [[ -f "test-final.png" ]]; then
    echo "✓ Final test passed!"
    rm test-final.png
else
    echo "✗ Final test failed!"
    exit 1
fi
echo ""

echo "============================================"
echo "  ✓✓✓ SETUP COMPLETE ✓✓✓"
echo "============================================"
echo ""
echo "Title image generation is now working!"
echo ""
echo "Next steps:"
echo "1. Go to: http://your-domain.com/admin/blog/posts/create"
echo "2. Enter title: သတင်း * ကမ္ဘာ့သတင်း * ၂၀၂၆"
echo "3. Check: 'Generate from title text'"
echo "4. Click: Save"
echo "5. Image will be generated automatically!"
echo ""
echo "============================================"
