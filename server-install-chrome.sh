#!/bin/bash

# Complete Chrome Installation Script for PNP Myanmar News
# Run from: /var/www/html/pnpmyanmar
# Command: bash server-install-chrome.sh

echo "=========================================="
echo "  Chrome Installation for Title Images"
echo "  PNP Myanmar News"
echo "=========================================="
echo ""

# Check current directory
CURRENT_DIR=$(pwd)
echo "Current directory: $CURRENT_DIR"
echo ""

# Check if we're in the right place
if [[ ! -d "scripts" ]]; then
    echo "ERROR: scripts directory not found!"
    echo "Please run this from: /var/www/html/pnpmyanmar"
    exit 1
fi

echo "✓ Found scripts directory"
echo ""

# Check Node.js
echo "Step 1: Checking Node.js..."
if command -v node &> /dev/null; then
    NODE_VERSION=$(node --version)
    echo "✓ Node.js installed: $NODE_VERSION"
else
    echo "✗ Node.js not found!"
    echo "Installing Node.js..."
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
    apt-get install -y nodejs
fi
echo ""

# Check npm
echo "Step 2: Checking npm..."
if command -v npm &> /dev/null; then
    NPM_VERSION=$(npm --version)
    echo "✓ npm installed: $NPM_VERSION"
else
    echo "✗ npm not found!"
    exit 1
fi
echo ""

# Go to scripts directory
cd scripts
echo "Step 3: Installing Puppeteer dependencies..."
if [[ ! -d "node_modules" ]]; then
    echo "Installing npm packages..."
    npm install
else
    echo "✓ node_modules already exists"
fi
echo ""

# Install Chrome via Puppeteer
echo "Step 4: Installing Chrome browser..."
echo "This may take 2-3 minutes (downloading ~150MB)..."
echo ""
npx puppeteer browsers install chrome
echo ""

# Check if Chrome was installed
if [[ -d "$HOME/.cache/puppeteer/chrome" ]]; then
    echo "✓ Chrome installed successfully!"
    CHROME_PATH=$(find $HOME/.cache/puppeteer/chrome -name "chrome" -type f | head -1)
    echo "  Location: $CHROME_PATH"
else
    echo "⚠ Chrome installation may have failed"
fi
echo ""

# Test image generation
echo "Step 5: Testing image generation..."
echo "Generating test image with Myanmar text..."
echo ""

node generate-image.js "ကမ္ဘာ့သတင်း သုံးသပ်ချက်" test-server.png

if [[ -f "test-server.png" ]]; then
    FILE_SIZE=$(du -h test-server.png | cut -f1)
    echo ""
    echo "✓✓✓ SUCCESS! ✓✓✓"
    echo "Test image generated: test-server.png"
    echo "File size: $FILE_SIZE"
    echo ""
    
    # Clean up test file
    rm test-server.png
    echo "Test file cleaned up."
else
    echo ""
    echo "✗✗✗ FAILED ✗✗✗"
    echo "Image generation failed!"
    echo ""
    echo "Trying to diagnose the problem..."
    echo ""
    
    # Check Chrome installation
    echo "Checking Chrome installation:"
    find $HOME/.cache/puppeteer -name "chrome" -type f 2>/dev/null || echo "Chrome not found in cache"
    echo ""
    
    # Check permissions
    echo "Checking permissions:"
    ls -la $HOME/.cache/puppeteer 2>/dev/null || echo "Puppeteer cache not accessible"
    echo ""
fi

# Set proper permissions
echo ""
echo "Step 6: Setting permissions..."
cd ..
chown -R www-data:www-data storage
chmod -R 755 storage
chown -R www-data:www-data scripts
echo "✓ Permissions set"
echo ""

# Summary
echo "=========================================="
echo "  Installation Summary"
echo "=========================================="
echo ""
echo "Project path: /var/www/html/pnpmyanmar"
echo "Scripts path: /var/www/html/pnpmyanmar/scripts"
echo "Node.js: $(node --version)"
echo "npm: $(npm --version)"
echo ""

if [[ -f "scripts/test-server.png" ]]; then
    echo "Status: ✓ READY TO USE"
    echo ""
    echo "You can now:"
    echo "1. Go to admin panel"
    echo "2. Create/edit a post"
    echo "3. Check 'Generate from title text'"
    echo "4. Save - image will be generated automatically!"
else
    echo "Status: ⚠ NEEDS ATTENTION"
    echo ""
    echo "Manual installation needed:"
    echo "  cd /var/www/html/pnpmyanmar/scripts"
    echo "  npx puppeteer browsers install chrome"
    echo "  node generate-image.js 'Test' test.png"
fi

echo ""
echo "=========================================="
echo "  Installation Complete"
echo "=========================================="
