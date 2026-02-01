<?php

use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

// Test route to generate image
Route::get('/test-image-generation', function () {
    $title = "Test Title for Image";
    $width = 1200;
    $height = 630;
    
    // Create image manager
    $manager = new ImageManager(new Driver());
    
    // Create blank image
    $image = $manager->create($width, $height);
    
    // Fill with blue background
    $image->fill('#1E40AF');
    
    // Add decorative bars
    $topBar = $manager->create($width, 10)->fill('#3B82F6');
    $image->place($topBar, 'top-left');
    
    $bottomBar = $manager->create($width, 10)->fill('#3B82F6');
    $image->place($bottomBar, 'bottom-left');
    
    // Font path
    $fontPath = public_path('fonts/NotoSansMyanmar-Bold.ttf');
    $fontExists = file_exists($fontPath);
    
    // Add title text
    $image->text($title, $width / 2, $height / 2, function ($font) use ($fontPath, $fontExists) {
        if ($fontExists) {
            $font->file($fontPath);
        }
        $font->size(80);
        $font->color('#FFFFFF');
        $font->align('center');
        $font->valign('middle');
    });
    
    // Add info text
    $info = $fontExists ? "Font: NotoSansMyanmar-Bold.ttf (FOUND)" : "Font: Default (NOT FOUND)";
    $image->text($info, $width / 2, $height - 50, function ($font) use ($fontPath, $fontExists) {
        if ($fontExists) {
            $font->file($fontPath);
        }
        $font->size(24);
        $font->color('#FFFFFF');
        $font->align('center');
        $font->valign('middle');
    });
    
    // Return image
    return $image->toPng();
})->name('test.image');
