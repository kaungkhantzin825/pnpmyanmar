#!/bin/bash

# Script to install Chrome/Chromium for Puppeteer on Linux server
# Run: bash install-chrome-server.sh

echo "=== Installing Chrome/Chromium for Puppeteer ==="
echo ""

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo "Please run with sudo: sudo bash install-chrome-server.sh"
    exit 1
fi

echo "Step 1: Updating package list..."
apt update

echo ""
echo "Step 2: Installing Chromium browser..."
apt install -y chromium-browser

echo ""
echo "Step 3: Installing required dependencies..."
apt install -y \
    ca-certificates \
    fonts-liberation \
    libappindicator3-1 \
    libasound2 \
    libatk-bridge2.0-0 \
    libatk1.0-0 \
    libc6 \
    libcairo2 \
    libcups2 \
    libdbus-1-3 \
    libexpat1 \
    libfontconfig1 \
    libgbm1 \
    libgcc1 \
    libglib2.0-0 \
    libgtk-3-0 \
    libnspr4 \
    libnss3 \
    libpango-1.0-0 \
    libpangocairo-1.0-0 \
    libstdc++6 \
    libx11-6 \
    libx11-xcb1 \
    libxcb1 \
    libxcomposite1 \
    libxcursor1 \
    libxdamage1 \
    libxext6 \
    libxfixes3 \
    libxi6 \
    libxrandr2 \
    libxrender1 \
    libxss1 \
    libxtst6 \
    lsb-release \
    wget \
    xdg-utils

echo ""
echo "Step 4: Installing fonts for Myanmar Unicode..."
apt install -y fonts-noto

echo ""
echo "Step 5: Checking Chromium installation..."
if command -v chromium-browser &> /dev/null; then
    echo "✓ Chromium installed at: $(which chromium-browser)"
    chromium-browser --version
elif command -v chromium &> /dev/null; then
    echo "✓ Chromium installed at: $(which chromium)"
    chromium --version
else
    echo "✗ Chromium not found. Trying alternative installation..."
    apt install -y chromium
fi

echo ""
echo "Step 6: Setting permissions for Puppeteer cache..."
mkdir -p /var/www/.cache/puppeteer
chown -R www-data:www-data /var/www/.cache
chmod -R 755 /var/www/.cache

echo ""
echo "=== Installation Complete ==="
echo ""
echo "Test the image generation:"
echo "  cd /var/www/html/pnpmyanmar/scripts"
echo "  node generate-image.js 'Test Title' test.png"
echo ""
echo "If you still get errors, run:"
echo "  cd /var/www/html/pnpmyanmar/scripts"
echo "  npx puppeteer browsers install chrome"
