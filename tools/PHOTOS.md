# Photo processing

`tools/process_photos.py` builds the site's gallery images and home page hero from the photographer's original files. `tools/photos.json` records which original goes into which slot.

The originals are **not** in this repo (the April 2026 shoot is 1.3 GB). Keep them in shared storage, and pass their location with `--source`.

## When to use it

- **Swapping a gallery photo or the hero.** Change the `source` in `photos.json`, then run the script for that slot only.
- **Adding a gallery photo.** Add an entry with the next unused slot number, run the script, then add a matching block to `gallery.html`. Copy an existing `col-md-4` block and change the slot number, caption, `title` and `alt`.
- **A new photo shoot.** Pick photos, update `photos.json` (including the `shoot` note), and run the script for all slots.
- **Changing the processing settings.** Edit the constants at the top of the script, rerun it for every slot so the gallery stays consistent, and update this file.

Don't run it on photos that are already processed, such as the files in `gallery-photos/` or the photographer's `websizephotos` set. The color correction would be applied twice and the result upscaled from a small file. Always start from the full-resolution originals.

Slots 000, 008 and 010–013 are not listed in `photos.json`. They are still the professionally edited 800×600 photos from the previous site, kept because the new shoot had no better shot of those subjects (see "How the photos were chosen"). Their originals aren't available.

## How to run it

Requires Python 3 and Pillow (`pip install Pillow`). Run from the repo root:

```bash
python tools/process_photos.py --source "path/to/hirezphotos/Sierra Place Apartments"
```

Process only some slots (gallery slot numbers and/or `hero`):

```bash
python tools/process_photos.py --source "path/to/originals" --only 009 hero
```

The script overwrites the files in `gallery-photos/` and `index-photos/`. Afterwards:

1. Look at the thumbnails. Portrait photos are cropped to a landscape thumbnail, and the crop may cut off the subject (see `thumb_center_y` below).
2. Run `npm start` and check `gallery.html` and the hero on any page.
3. Commit the images and `photos.json` together.

Rerunning with the same originals and settings reproduces the committed files exactly, so `git status` shows no changes. This is a quick way to confirm `photos.json` is in sync.

## Settings and how they were chosen

### Color correction

| Setting | Value | Effect |
|---|---|---|
| `AUTOCONTRAST_CUTOFF` | 0.5 | Stretches brightness so the darkest and brightest 0.5% of pixels reach black and white. `preserve_tone=True` stretches overall brightness only, so the color balance doesn't shift. |
| `SATURATION` | 1.25 | 25% more color. |
| `CONTRAST` | 1.08 | 8% more contrast. |

The April 2026 photos came out flat and hazy (low contrast, pale skies, muted color) next to the previous gallery, which was heavily edited and staged. These values were chosen conservatively, then checked by previewing as-delivered and corrected versions of the pool, sundeck and kitchen photos side by side with the old gallery. The aim was to close part of the gap without making the photos look processed. Stronger settings weren't tried. If you raise them, check the bright areas (pool water, white walls, sky) for washed-out highlights and the roof tiles for oversaturation.

This is a deliberately light, automatic correction. It doesn't fix the pale skies, so a bigger improvement would need a photo editor working on each photo. If you get professionally edited photos, set `SATURATION` and `CONTRAST` to 1.0 and `AUTOCONTRAST_CUTOFF` to 0 so they pass through unchanged.

### Sizes

| Output | Size | Why |
|---|---|---|
| Full-size gallery image | longest edge 1024 px | Opens in the lightbox when a thumbnail is clicked. Sharper than the old 800 px photos on modern screens, at 70–220 KB each. A first pass at 1200 px made files up to 300 KB for little visible gain. |
| Thumbnail (`_sm`) | 360×270, center crop | Same size and 4:3 shape as the existing thumbnails, so the gallery grid lines up. |
| Hero | 2048×1365 | Same size as the previous hero. It is a full-width CSS background (`background-size: cover`) on every page, so it needs the width for large monitors. |

### Thumbnail crop: `thumb_center_y`

Portrait photos lose most of their height when cropped to a 4:3 thumbnail. The crop is centered by default. If the subject sits low or high in the frame, set `thumb_center_y` on that slot in `photos.json`: `0.0` keeps the top, `0.5` is the center and `1.0` keeps the bottom. Slot 009 uses `0.8`, because a centered crop showed only the bathroom mirror and cut off the sink.

### Encoding and metadata

- JPEG quality 82, progressive and optimized. Lower quality saved little: quality 75 made the hero only about 10% smaller.
- **All metadata is removed.** The drone photos contain GPS coordinates and camera details, so don't add code that copies EXIF data to the output.
- Output is sRGB. Originals with a different color profile (such as Adobe RGB) are converted, so colors look the same in every browser. The April 2026 originals were already sRGB.

## How the photos were chosen

Each old gallery photo was compared with the closest new photos.

- **Replaced:** interior photos (kitchens, living room, bathroom) and pool photos. The old ones showed light oak cabinets, carpet and red pool furniture that are no longer there, so they misrepresented the units.
- **Kept:** exterior and grounds photos. The buildings and landscaping haven't changed, and the old photos are better than any new match.
- **Added:** a bedroom (the gallery had none), the monument sign and an overhead pool shot.

Slot 010 is a judgment call. New drone shot 112220 has nearly the same framing, but its planting beds are now mostly bare. Swap it in if the owner wants strictly current photos.
