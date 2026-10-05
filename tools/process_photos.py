"""Build the site's gallery and hero images from original photo files.

Reads tools/photos.json to see which original goes into which slot, then
writes the full-size image, the thumbnail, and the hero. See tools/PHOTOS.md
for how the settings were chosen and when to run this.

Usage (from the repo root):
    python tools/process_photos.py --source "path/to/hirezphotos/Sierra Place Apartments"
    python tools/process_photos.py --source ... --only 009 hero
"""
import argparse
import io
import json
import os
import sys

from PIL import Image, ImageCms, ImageEnhance, ImageOps

REPO = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

# Color correction (see PHOTOS.md, "Color correction")
AUTOCONTRAST_CUTOFF = 0.5   # % of darkest/brightest pixels clipped at each end
SATURATION = 1.25
CONTRAST = 1.08

# Output sizes (see PHOTOS.md, "Sizes")
FULL_MAX_EDGE = 1024        # gallery lightbox image, longest edge
THUMB_SIZE = (360, 270)     # gallery thumbnail, 4:3, matches existing thumbnails
HERO_SIZE = (2048, 1365)    # background image on every page

JPEG = dict(quality=82, optimize=True, progressive=True)
SRGB = ImageCms.createProfile('sRGB')


def load(path):
    im = Image.open(path)
    # Decode camera JPEGs at reduced scale; still well above every output size.
    im.draft('RGB', (2400, 2400))
    im = ImageOps.exif_transpose(im)
    icc = im.info.get('icc_profile')
    if icc:
        src = ImageCms.ImageCmsProfile(io.BytesIO(icc))
        if 'sRGB' not in ImageCms.getProfileDescription(src):
            im = ImageCms.profileToProfile(im, src, SRGB, outputMode='RGB')
    return im.convert('RGB')


def correct(im):
    im = ImageOps.autocontrast(im, cutoff=(AUTOCONTRAST_CUTOFF, AUTOCONTRAST_CUTOFF), preserve_tone=True)
    im = ImageEnhance.Color(im).enhance(SATURATION)
    return ImageEnhance.Contrast(im).enhance(CONTRAST)


def save(im, rel):
    # No exif= argument, so all metadata (including drone GPS) is dropped.
    im.save(os.path.join(REPO, rel), 'JPEG', **JPEG)
    print(f'  {rel}  {im.width}x{im.height}  {os.path.getsize(os.path.join(REPO, rel)) // 1024} KB')


def main():
    ap = argparse.ArgumentParser(description=__doc__, formatter_class=argparse.RawDescriptionHelpFormatter)
    ap.add_argument('--source', required=True, help='directory containing the original photos')
    ap.add_argument('--only', nargs='+', metavar='SLOT', help='only these gallery slots (e.g. 009) and/or "hero"')
    args = ap.parse_args()

    with open(os.path.join(REPO, 'tools', 'photos.json'), encoding='utf-8') as f:
        manifest = json.load(f)

    def src(name):
        path = os.path.join(args.source, name)
        if not os.path.exists(path):
            sys.exit(f'missing source photo: {path}')
        return path

    wanted = set(args.only) if args.only else None

    for slot, entry in manifest['gallery'].items():
        if wanted and slot not in wanted:
            continue
        print(f'{slot} <- {entry["source"]}')
        im = correct(load(src(entry['source'])))
        full = im.copy()
        full.thumbnail((FULL_MAX_EDGE, FULL_MAX_EDGE), Image.LANCZOS)
        save(full, f'gallery-photos/image_gallery_{slot}.jpg')
        center = (0.5, entry.get('thumb_center_y', 0.5))
        save(ImageOps.fit(im, THUMB_SIZE, Image.LANCZOS, centering=center),
             f'gallery-photos/image_gallery_{slot}_sm.jpg')

    hero = manifest.get('hero')
    if hero and (not wanted or 'hero' in wanted):
        print(f'hero <- {hero["source"]}')
        im = correct(load(src(hero['source'])))
        save(ImageOps.fit(im, HERO_SIZE, Image.LANCZOS), hero['output'])


if __name__ == '__main__':
    main()
