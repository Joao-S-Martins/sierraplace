# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Static marketing site for Sierra Place Apartments (Porterville, CA), live at https://sierraplaceapartments.com. Plain HTML pages with Bootstrap 3, jQuery, RequireJS and blueimp Gallery. There is no build step, linter or test suite.

The site began as a mirror of a site hosted by Aspen Square (a property management company). That's where the `cdn.aspensquare.com/`, `img.youtube.com/`, `backblue.gif` and `fade.gif` leftovers and the minified `css/custom.min0ff5.css` come from. Edit pages directly; nothing generates them.

## Commands

```bash
npm install
npm start        # live-server . (http://localhost:8080)
```

Serve from the repo root. Pages load scripts with root-absolute paths (`/js/require.js`, `data-main="/js/optimized.js"`), so opening the files with `file://` breaks the JS.

## Architecture notes

- **No shared layout.** The header, the contact block, the "Homes for Rent" sidebar and the office hours are copied into each `*.html` page. A content change (hours, amenities, pet policy) has to be made in every page that has that block. Grep across `*.html` and `thankyou.php` to find every copy.
- **JS:** `js/require.js` loads `js/optimized.js`, which bundles jQuery, Bootstrap and blueimp. `bower.json`, `bower_components/`, `blueimp-gallery/` and `lib/` are legacy copies of that library.
- **Forms:** `request-information.html` and `schedule-tour.html` POST to `thankyou.php`, which emails `management@sierraplaceapartments.com` with PHP `mail()`. These forms only work on the PHP host, not under live-server. The downloadable PDFs are in `forms/`.
- **Images:**
  - The hero/background image `index-photos/pool-aerial-view.jpg` is set as an inline `background-image` style on every page, including `thankyou.php`. Swap the file in place to change it everywhere.
  - Each gallery photo is a pair: `gallery-photos/image_gallery_NNN.jpg` (full size) and `image_gallery_NNN_sm.jpg` (thumbnail). Each pair is referenced from a blueimp `<a href>`/`<img src>` block in `gallery.html`. Adding or removing a photo means editing those blocks as well as the files.
  - Floor plan images are in `floorplans/`.
- **`sitemap.xml`** lists the public pages. Update it when you add or remove a page.

## Branches and work in progress

- `master` is the published site. `fall_2025` holds the Fall 2025 content update. [TODO.md](TODO.md) tracks the property owner's requested changes; only the photo refresh is still open.
- `react/` and the local `react` branch are an unfinished React migration (WIP, not on `master`). Don't mix that work into content changes.
- Business facts are set by the owner's requests in TODO.md. For example: no pricing, no fitness room, small to medium pets only, no move-in specials, no instant application processing, and office hours of 9am–4pm Monday–Friday. Copy shouldn't contradict them.
