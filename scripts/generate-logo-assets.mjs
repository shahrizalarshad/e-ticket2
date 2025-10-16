// Generate PNG and JPG logo assets from SVG masters using Sharp
import { mkdir, readFile, writeFile } from 'node:fs/promises';
import { join } from 'node:path';
import sharp from 'sharp';

const root = process.cwd();
const srcDir = join(root, 'public', 'assets', 'logo');
const outDir = srcDir; // write alongside SVGs

const svgs = [
  { name: 'e-ticket-mark-color', file: 'e-ticket-mark-color.svg', transparentPNG: true },
  { name: 'e-ticket-mark-black', file: 'e-ticket-mark-black.svg', transparentPNG: true },
  { name: 'e-ticket-mark-white', file: 'e-ticket-mark-white.svg', transparentPNG: true },
  { name: 'e-ticket-logotype-color', file: 'e-ticket-logotype-color.svg', transparentPNG: true },
];

const sizes = [64, 128, 256, 512];

async function ensureDir(path) {
  try {
    await mkdir(path, { recursive: true });
  } catch {}
}

async function generate() {
  await ensureDir(outDir);

  for (const s of svgs) {
    const svgPath = join(srcDir, s.file);
    const svg = await readFile(svgPath);

    for (const size of sizes) {
      // PNG (transparent where applicable)
      const pngOut = join(outDir, `${s.name}-${size}.png`);
      const png = sharp(svg, { density: 300 })
        .resize(size, size, { fit: 'contain', background: { r: 0, g: 0, b: 0, alpha: 0 } })
        .png({ compressionLevel: 9 });
      await png.toFile(pngOut);

      // JPG (white background)
      const jpgOut = join(outDir, `${s.name}-${size}.jpg`);
      const jpg = sharp(svg, { density: 300 })
        .resize(size, size, { fit: 'contain', background: '#ffffff' })
        .flatten({ background: '#ffffff' })
        .jpeg({ quality: 90 });
      await jpg.toFile(jpgOut);
    }
  }

  // Also provide favicon-sized mark
  const faviconSvg = join(srcDir, 'e-ticket-mark-color.svg');
  const faviconPng = await sharp(await readFile(faviconSvg))
    .resize(64, 64, { fit: 'contain', background: { r: 0, g: 0, b: 0, alpha: 0 } })
    .png({ compressionLevel: 9 })
    .toBuffer();
  await writeFile(join(outDir, 'favicon.png'), faviconPng);

  console.log('Logo assets generated in', outDir);
}

generate().catch((err) => {
  console.error('Error generating logo assets:', err);
  process.exitCode = 1;
});
