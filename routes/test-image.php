<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/test-title-image', function () {
    // Test title extraction
    $testCases = [
        'မြန်မာစာ * ကမ္ဘာ့သတင်း သုံးသပ်ချက် * ၁၀၆',
        'သတင်း * နိုင်ငံတကာ အခြေအနေ * ၂၀၂၆',
        'ကမ္ဘာ့သတင်း သုံးသပ်ချက်',
    ];
    
    $results = [];
    foreach ($testCases as $title) {
        $extracted = trim(preg_match('/\*\s*([^*]+?)\s*\*/', $title, $m) ? $m[1] : $title);
        $results[] = [
            'original' => $title,
            'extracted' => $extracted,
        ];
    }
    
    // Test Node.js availability
    $nodeVersion = shell_exec('node --version 2>&1');
    
    // Test image generation
    $testTitle = 'ကမ္ဘာ့သတင်း သုံးသပ်ချက်';
    $filename = 'posts/thumbnails/test-' . Str::random(10) . '.png';
    $outputPath = storage_path('app/public/' . $filename);
    
    // Ensure directory exists
    $dir = dirname($outputPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    $titleEscaped = escapeshellarg($testTitle);
    $outputEscaped = escapeshellarg($outputPath);
    $scriptsDir = escapeshellarg(base_path('scripts'));
    
    $command = "cd $scriptsDir && node generate-image.js $titleEscaped $outputEscaped 2>&1";
    $output = shell_exec($command);
    
    $imageGenerated = file_exists($outputPath);
    $imageSize = $imageGenerated ? filesize($outputPath) : 0;
    
    return view('test-title-image', [
        'results' => $results,
        'nodeVersion' => trim($nodeVersion),
        'command' => $command,
        'output' => $output,
        'imageGenerated' => $imageGenerated,
        'imageSize' => $imageSize,
        'imagePath' => $imageGenerated ? asset('storage/' . $filename) : null,
    ]);
});
