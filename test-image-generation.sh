#!/bin/bash

# Quick test script for image generation
# Run from: /var/www/html/pnpmyanmar
# Command: bash test-image-generation.sh

echo "=== Testing Image Generation ==="
echo ""

cd scripts

echo "Test 1: Simple English text"
node generate-image.js "Test Title" test1.png
if [[ -f "test1.png" ]]; then
    echo "✓ Test 1 passed ($(du -h test1.png | cut -f1))"
    rm test1.png
else
    echo "✗ Test 1 failed"
fi
echo ""

echo "Test 2: Myanmar Unicode text"
node generate-image.js "ကမ္ဘာ့သတင်း သုံးသပ်ချက်" test2.png
if [[ -f "test2.png" ]]; then
    echo "✓ Test 2 passed ($(du -h test2.png | cut -f1))"
    rm test2.png
else
    echo "✗ Test 2 failed"
fi
echo ""

echo "Test 3: Mixed text with numbers"
node generate-image.js "သတင်း ၂၀၂၆ ခုနှစ်" test3.png
if [[ -f "test3.png" ]]; then
    echo "✓ Test 3 passed ($(du -h test3.png | cut -f1))"
    rm test3.png
else
    echo "✗ Test 3 failed"
fi
echo ""

echo "=== Test Complete ==="
