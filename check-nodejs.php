<?php
/**
 * Check Node.js installation and find the correct path
 * Run: php check-nodejs.php
 */

echo "=== Node.js Installation Check ===\n\n";

// Test different node paths
$nodePaths = [
    'node',
    'nodejs',
    '/usr/bin/node',
    '/usr/local/bin/node',
    '/opt/node/bin/node',
    'C:\\Program Files\\nodejs\\node.exe',
    'C:\\Program Files (x86)\\nodejs\\node.exe',
];

echo "Testing Node.js paths...\n";
echo "------------------------\n";

$foundPath = null;

foreach ($nodePaths as $path) {
    echo "Testing: $path ... ";
    $output = shell_exec("\"$path\" --version 2>&1");
    
    if ($output && strpos($output, 'v') === 0) {
        echo "✓ FOUND - Version: " . trim($output) . "\n";
        if (!$foundPath) {
            $foundPath = $path;
        }
    } else {
        echo "✗ Not found\n";
    }
}

echo "\n";

if ($foundPath) {
    echo "✓ Node.js is installed!\n";
    echo "  Path: $foundPath\n";
    
    // Test if we can run the script
    echo "\nTesting image generation script...\n";
    echo "-----------------------------------\n";
    
    $scriptPath = __DIR__ . '/scripts/generate-image.js';
    if (file_exists($scriptPath)) {
        echo "✓ Script found: $scriptPath\n";
        
        // Test generation
        $testTitle = 'Test Title';
        $testOutput = __DIR__ . '/test-node-check.png';
        
        $command = "cd " . escapeshellarg(__DIR__ . '/scripts') . " && \"$foundPath\" generate-image.js " . escapeshellarg($testTitle) . " " . escapeshellarg($testOutput) . " 2>&1";
        
        echo "Running: $command\n\n";
        $result = shell_exec($command);
        echo "Output: $result\n";
        
        if (file_exists($testOutput)) {
            echo "✓ Test image generated successfully!\n";
            echo "  File: $testOutput\n";
            echo "  Size: " . filesize($testOutput) . " bytes\n";
            unlink($testOutput);  // Clean up
        } else {
            echo "✗ Test image generation failed\n";
        }
    } else {
        echo "✗ Script not found: $scriptPath\n";
    }
    
    echo "\n=== SOLUTION ===\n";
    echo "Update BlogAdminController.php line ~180:\n";
    echo "Change: \$nodePath = 'node';\n";
    echo "To:     \$nodePath = '$foundPath';\n";
    
} else {
    echo "✗ Node.js is NOT installed or not accessible\n\n";
    echo "=== SOLUTION ===\n";
    echo "Install Node.js:\n";
    echo "  - Windows: Download from https://nodejs.org/\n";
    echo "  - Linux: sudo apt install nodejs npm\n";
    echo "  - macOS: brew install node\n";
    echo "\nAfter installation, run this script again.\n";
}

echo "\n=== System Information ===\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Operating System: " . PHP_OS . "\n";
echo "Current User: " . get_current_user() . "\n";
echo "Working Directory: " . getcwd() . "\n";

// Check if shell_exec is enabled
if (function_exists('shell_exec')) {
    echo "shell_exec: ✓ Enabled\n";
} else {
    echo "shell_exec: ✗ DISABLED (required for title image generation)\n";
}

echo "\n=== Complete ===\n";
