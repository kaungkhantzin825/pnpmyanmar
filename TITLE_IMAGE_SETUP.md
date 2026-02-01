# Title Image (Myanmar Text) Setup

## Why Myanmar text was wrong

PHP’s GD library does **not** support Myanmar “complex script” shaping (reordering, stacking, conjuncts). So even with correct Unicode and the right font, GD draws glyphs in the wrong order and you see malformed text or empty squares.

## Current behaviour

1. **Browser rendering (Browsershot)** – tried first  
   Uses headless Chrome to render the title in HTML with Noto Sans Myanmar. The browser does proper Myanmar shaping, so text looks correct.

2. **Upload** – always available  
   You can upload a ready-made title image (e.g. from Canva or a browser screenshot) so Myanmar is correct without any generation.

3. **GD fallback** – if Browsershot fails  
   If Node/Puppeteer is not installed or Browsershot fails, the app falls back to GD. Myanmar may still look wrong there; use **Upload Title Image** instead.

## Enabling “Generate from title text” (Browsershot)

To use **“Or generate from title text”** with correct Myanmar:

1. **Install Node.js** (LTS) from https://nodejs.org/

2. **Install Puppeteer** (includes Chromium):

   ```bash
   cd d:\pnpmyanmar\pnpmyanmar
   npm init -y
   npx puppeteer install
   ```

   Or install Puppeteer in the project:

   ```bash
   npm install puppeteer
   npx puppeteer install
   ```

3. **Optional:** If Chrome/Chromium is not found, set the path in `.env`:

   ```
   PUPPETEER_EXECUTABLE_PATH=C:\Program Files\Google\Chrome\Application\chrome.exe
   ```

   Browsershot will use this if the package supports it (or set it in config if you publish Browsershot config).

4. **Re-generate** a post with “Or generate from title text” checked. The first run may take a few seconds while Chrome starts.

## If you don’t use Node/Puppeteer

Use **Upload Title Image** in the Create/Edit Post form:

- Create the title image elsewhere (e.g. Canva, Google Docs, or a simple HTML page in your browser with Noto Sans Myanmar, then screenshot).
- Upload the image in the “Upload Title Image” field.
- Leave “Or generate from title text” unchecked if you only want to use the uploaded image.

This always gives correct Myanmar without any server setup.
