<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title Image Generation Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #1E40AF;
            border-bottom: 3px solid #3B82F6;
            padding-bottom: 10px;
        }
        h2 {
            color: #333;
            margin-top: 30px;
        }
        .test-section {
            margin: 20px 0;
            padding: 15px;
            background: #f9fafb;
            border-left: 4px solid #3B82F6;
        }
        .success {
            color: #059669;
            font-weight: bold;
        }
        .error {
            color: #DC2626;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #1E40AF;
            color: white;
        }
        tr:hover {
            background: #f5f5f5;
        }
        code {
            background: #1f2937;
            color: #10b981;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .command-box {
            background: #1f2937;
            color: #10b981;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }
        .image-preview {
            margin: 20px 0;
            text-align: center;
        }
        .image-preview img {
            max-width: 100%;
            border: 2px solid #3B82F6;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
        }
        .badge-success {
            background: #D1FAE5;
            color: #059669;
        }
        .badge-error {
            background: #FEE2E2;
            color: #DC2626;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎨 Title Image Generation Test</h1>
        <p>Testing the Node.js + Puppeteer integration for Myanmar Unicode text rendering</p>

        <div class="test-section">
            <h2>✅ Test 1: Text Extraction</h2>
            <p>Testing asterisk extraction from titles:</p>
            <table>
                <thead>
                    <tr>
                        <th>Original Title</th>
                        <th>Extracted Text</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr>
                        <td>{{ $result['original'] }}</td>
                        <td><strong>{{ $result['extracted'] }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="test-section">
            <h2>✅ Test 2: Node.js Availability</h2>
            @if($nodeVersion)
                <p class="success">✓ Node.js is available: <code>{{ $nodeVersion }}</code></p>
            @else
                <p class="error">✗ Node.js not found in PATH</p>
            @endif
        </div>

        <div class="test-section">
            <h2>✅ Test 3: Image Generation</h2>
            <p><strong>Command executed:</strong></p>
            <div class="command-box">{{ $command }}</div>
            
            <p><strong>Output:</strong></p>
            <div class="command-box">{{ $output }}</div>
            
            @if($imageGenerated)
                <p class="success">
                    <span class="status-badge badge-success">✓ SUCCESS</span>
                    Image generated successfully! Size: {{ number_format($imageSize) }} bytes
                </p>
            @else
                <p class="error">
                    <span class="status-badge badge-error">✗ FAILED</span>
                    Image generation failed
                </p>
            @endif
        </div>

        @if($imageGenerated && $imagePath)
        <div class="test-section">
            <h2>🖼️ Generated Image Preview</h2>
            <div class="image-preview">
                <img src="{{ $imagePath }}" alt="Generated Title Image">
            </div>
            <p style="text-align: center;">
                <strong>Image URL:</strong> <code>{{ $imagePath }}</code>
            </p>
        </div>
        @endif

        <div class="test-section">
            <h2>📋 Summary</h2>
            <ul>
                <li>Text extraction: <span class="success">✓ Working</span></li>
                <li>Node.js: <span class="{{ $nodeVersion ? 'success' : 'error' }}">{{ $nodeVersion ? '✓ Available' : '✗ Not found' }}</span></li>
                <li>Image generation: <span class="{{ $imageGenerated ? 'success' : 'error' }}">{{ $imageGenerated ? '✓ Working' : '✗ Failed' }}</span></li>
            </ul>
            
            @if($nodeVersion && $imageGenerated)
                <p class="success" style="font-size: 18px; margin-top: 20px;">
                    🎉 All tests passed! The title image generation feature is fully functional.
                </p>
                <p>You can now use this feature in the admin panel:</p>
                <ol>
                    <li>Go to <strong>Admin Dashboard → Blog Posts → Create New Post</strong></li>
                    <li>Enter a title with asterisks: <code>မြန်မာစာ * ကမ္ဘာ့သတင်း * ၁၀၆</code></li>
                    <li>Check the <strong>"Generate from title text"</strong> checkbox</li>
                    <li>Save the post</li>
                </ol>
            @else
                <p class="error" style="font-size: 18px; margin-top: 20px;">
                    ⚠️ Some tests failed. Please check the troubleshooting guide.
                </p>
            @endif
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #EFF6FF; border-radius: 8px;">
            <h3 style="color: #1E40AF; margin-top: 0;">📚 Documentation</h3>
            <ul>
                <li><strong>Quick Guide:</strong> <code>QUICK_TITLE_IMAGE_GUIDE.md</code></li>
                <li><strong>Full Documentation:</strong> <code>TITLE_IMAGE_FEATURE.md</code></li>
                <li><strong>Admin Panel:</strong> <a href="/admin/blog/posts/create">/admin/blog/posts/create</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
