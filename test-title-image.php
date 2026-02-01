<?php
/**
 * Test script to verify title image generation works
 * Run: php test-title-image.php
 */

// Test 1: Extract text between asterisks
echo "Test 1: Text Extraction\n";
echo "=======================\n";

$testTitles = [
    'မြန်မာစာ * ကမ္ဘာ့သတင်း သုံးသပ်ချက် * ၁၀၆',
    'သတင်း * နိုင်ငံတကာ အခြေအနေ * ၂၀၂၆',
    'ကမ္ဘာ့သတင်း သုံးသပ်ချက်', // No asterisks
];

foreach ($testTitles as $title) {
    $extracted = trim(preg_match('/\*\s*([^*]+?)\s*\*/', $title, $m) ? $m[1] : $title);
    echo "Title: $title\n";
    echo "Extracted: $extracted\n\n";
}

// Test 2: Check if Node.js is available
echo "\nTest 2: Node.js Availability\n";
echo "=============================\n";

$nodeVersion = shell_exec('node --version 2>&1');
if ($nodeVersion) {
    echo "✓ Node.js found: " . trim($nodeVersion) . "\n";
} else {
    echo "✗ Node.js not found in PATH\n";
}

// Test 3: Check if script exists
echo "\nTest 3: Script Files\n";
echo "====================\n";

$scriptPath = __DIR__ . '/scripts/generate-image.js';
if (file_exists($scriptPath)) {
    echo "✓ generate-image.js exists\n";
} else {
    echo "✗ generate-image.js not found\n";
}

$puppeteerPath = __DIR__ . '/scripts/node_modules/puppeteer';
if (is_dir($puppeteerPath)) {
    echo "✓ Puppeteer installed\n";
} else {
    echo "✗ Puppeteer not installed\n";
}

// Test 4: Generate a test image
echo "\nTest 4: Generate Test Image\n";
echo "============================\n";

$testTitle = 'ကမ္ဘာ့သတင်း သုံးသပ်ချက်';
$outputPath = __DIR__ . '/test-output.png';

// Remove old test file if exists
if (file_exists($outputPath)) {
    unlink($outputPath);
}

$titleEscaped = escapeshellarg($testTitle);
$outputEscaped = escapeshellarg($outputPath);
$scriptsDir = escapeshellarg(__DIR__ . '/scripts');

$command = "cd $scriptsDir && node generate-image.js $titleEscaped $outputEscaped 2>&1";
echo "Command: $command\n\n";

$output = shell_exec($command);
echo "Output: $output\n";

if (file_exists($outputPath)) {
    $fileSize = filesize($outputPath);
    echo "✓ Image generated successfully!\n";
    echo "  File: $outputPath\n";
    echo "  Size: " . number_format($fileSize) . " bytes\n";
} else {
    echo "✗ Image generation failed\n";
}

echo "\n=== Test Complete ===\n";
