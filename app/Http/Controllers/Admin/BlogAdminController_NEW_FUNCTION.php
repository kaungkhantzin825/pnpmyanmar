<?php
// Replace the generateThumbnailFromText function with this:

private function generateThumbnailFromText($title, $description = '')
{
    // Extract text between asterisks if present
    if (preg_match('/\*\s*([^*]+?)\s*\*/', $title, $matches)) {
        $displayTitle = trim($matches[1]);
    } else {
        $displayTitle = $title;
    }
    
    // Image dimensions
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
    
    // Add overlay
    $overlay = $manager->create($width, $height)->fill('rgba(0, 0, 0, 0.25)');
    $image->place($overlay, 'top-left');
    
    // Font path
    $fontPath = public_path('fonts/NotoSansMyanmar-Bold.ttf');
    
    // Wrap text
    $titleLines = $this->wrapText($displayTitle, 25);
    $wrappedTitle = implode("\n", array_slice($titleLines, 0, 3));
    
    // Add title text with Myanmar font
    $image->text($wrappedTitle, $width / 2, $height / 2 - 50, function ($font) use ($fontPath) {
        if (file_exists($fontPath)) {
            $font->file($fontPath);
        }
        $font->size(80);
        $font->color('#FFFFFF');
        $font->align('center');
        $font->valign('middle');
    });
    
    // Add description if provided
    if (!empty($description)) {
        $descLines = $this->wrapText($description, 50);
        $descText = implode("\n", array_slice($descLines, 0, 2));
        
        $image->text($descText, $width / 2, $height / 2 + 120, function ($font) use ($fontPath) {
            if (file_exists($fontPath)) {
                $font->file($fontPath);
            }
            $font->size(36);
            $font->color('#DBEAFE');
            $font->align('center');
            $font->valign('middle');
        });
    }
    
    // Add branding background
    $brandBg = $manager->create($width, 70)->fill('rgba(0, 0, 0, 0.4)');
    $image->place($brandBg, 'bottom-left');
    
    // Add branding text
    $image->text('PNP Myanmar News', $width / 2, $height - 35, function ($font) use ($fontPath) {
        if (file_exists($fontPath)) {
            $font->file($fontPath);
        }
        $font->size(32);
        $font->color('#FFFFFF');
        $font->align('center');
        $font->valign('middle');
    });
    
    // Save image
    $filename = 'posts/thumbnails/' . Str::random(40) . '.png';
    $path = storage_path('app/public/' . $filename);
    
    // Ensure directory exists
    $directory = dirname($path);
    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }
    
    $image->save($path);
    
    return $filename;
}
