const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

async function generateImage(title, description = '', outputPath) {
    const browser = await puppeteer.launch({
        headless: 'new',
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-accelerated-2d-canvas',
            '--no-first-run',
            '--no-zygote',
            '--disable-gpu',
            '--disable-software-rasterizer',
            '--disable-dev-tools',
            '--no-crash-upload',
            '--disable-crash-reporter',
            '--disable-extensions',
            '--disable-in-process-stack-traces',
            '--disable-logging',
            '--log-level=3',
            '--single-process'  // Run in single process mode
        ]
    });
    
    const page = await browser.newPage();
    
    // Set viewport size - adjusted height to prevent clipping
    await page.setViewport({
        width: 1200,
        height: 250,  // Increased from 200 to 250 for proper spacing
        deviceScaleFactor: 2 // Higher quality
    });
    
    // Create HTML with Myanmar font - proper spacing to prevent clipping
    const html = `
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@700&display=swap" rel="stylesheet">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                width: 1200px;
                height: 250px;
                background: white;
                display: flex;
                justify-content: center;
                align-items: center;
                font-family: 'Noto Sans Myanmar', sans-serif;
                overflow: hidden;
                padding: 30px 20px;
            }
            .content {
                text-align: center;
                width: 100%;
            }
            .title {
                font-size: 48px;
                font-weight: 700;
                color: black;
                line-height: 1.4;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="title">${title}</div>
        </div>
    </body>
    </html>
    `;
    
    await page.setContent(html, { waitUntil: 'networkidle0' });
    
    // Wait for fonts to load
    await page.evaluateHandle('document.fonts.ready');
    
    // Take screenshot
    await page.screenshot({
        path: outputPath,
        type: 'png'
    });
    
    await browser.close();
    
    return outputPath;
}

// CLI usage
if (require.main === module) {
    const args = process.argv.slice(2);
    
    if (args.length < 2) {
        console.log('Usage: node generate-image.js <title> <outputPath> [description]');
        console.log('Example: node generate-image.js "ကမ္ဘာ့သတင်း" output.png "သုံးသပ်ချက်"');
        process.exit(1);
    }
    
    const [title, outputPath, description = ''] = args;
    
    generateImage(title, description, outputPath)
        .then(() => {
            console.log(`Image generated successfully: ${outputPath}`);
        })
        .catch(error => {
            console.error('Error generating image:', error);
            process.exit(1);
        });
}

module.exports = { generateImage };
