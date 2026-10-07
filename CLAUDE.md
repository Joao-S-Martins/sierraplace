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

## Shell: PowerShell for Windows tasks, gh for GitHub

This is a Windows machine. The Bash tool is Git Bash, which has no terminal for interactive prompts.

- **Use the PowerShell tool first** for Windows-specific queries: the registry (for example the default browser under `HKCU:\...\UrlAssociations`), installed apps (`Get-AppxPackage`), and anything else using cmdlets or Windows paths.
- **Don't run bare `git push`, `pull` or `fetch` against GitHub.** In Git Bash they fail with `/dev/tty: No such device or address` because the credential prompt has nowhere to go. Use the `gh` route below instead.

**Pushing and GitHub API calls:** git itself has no credential helper, so plain `git push` fails in both shells (in PowerShell with `terminal prompts disabled`). The GitHub CLI is installed and signed in (`gh auth status`), but the folder winget installed it to may be missing from the tool's PATH. Call it by its full path:

```
C:\Users\johnm\AppData\Local\Microsoft\WinGet\Packages\GitHub.cli_Microsoft.Winget.Source_8wekyb3d8bbwe\bin\gh.exe
```

To push without changing git config, pass `gh` as a one-off credential helper. This works from Bash:

```bash
GH=/c/Users/johnm/AppData/Local/Microsoft/WinGet/Packages/GitHub.cli_Microsoft.Winget.Source_8wekyb3d8bbwe/bin/gh.exe
git -c credential.helper= -c "credential.helper=!$GH auth git-credential" push origin main
```

If `gh` isn't signed in, ask the user to run the command in their own terminal; don't try other ways to authenticate.

Bash is fine for local git (log, diff, commit, merge), Python scripts (`python` is on PATH, with Pillow installed) and file work.

## Architecture notes

- **No shared layout.** The `<head>`, the header, the nav, the "Homes for Rent" sidebar and the footer are copied into each `*.html` page. A content change (hours, amenities, pet policy) has to be made in every page that has that block. Grep across `*.html`, `thankyou.php` and `llms.txt` to find every copy.
  - Facts also appear in the home page's JSON-LD (`openingHoursSpecification`, `amenityFeature`, floor plans), the "at a glance" list on the home page, `faq.html`, `llms.txt` and the footer. Office hours, for example, are in the sidebar, the footer, the JSON-LD, `faq.html`, `contact-us.html` and `llms.txt`. Grep for both `9:00 AM` and `9 AM`.
  - The FAQ text in `faq.html` and `apartments-near-sierra-view-medical-center.html` is duplicated in each page's `FAQPage` JSON-LD. Change both together; the JSON-LD must match the visible text.
- **SEO conventions** (see [SEO.md](SEO.md) for the plan and the reasons):
  - Every public page has a unique `<title>` and meta description (keep descriptions under about 155 characters), a `<link rel="canonical">` to `https://sierraplaceapartments.com/<page>`, Open Graph tags and one `<h1>`. The home page's canonical is `https://sierraplaceapartments.com/`; link to it as `/`, not `index.html`.
  - In this site's CSS, `<h2>` inside `.property-container` renders as a small italic subtitle under the `<h1>`. Use `<h3>` for section headings in page content.
  - Adding a page: copy the head, header, nav and footer from an existing page, add it to `sitemap.xml` and `llms.txt`, and link it from the footer or related pages.
  - `thankyou.php` and `404.html` are `noindex`. `404.html` uses `<base href="/">` so its relative links work at any path.
- **JS:** `js/require.js` loads `js/optimized.js`, which bundles jQuery, Bootstrap and blueimp. `bower.json`, `bower_components/`, `blueimp-gallery/` and `lib/` are legacy copies of that library. The bundle's startup `require([...])` callback was hand-edited in October 2026 to stop loading the Aspen Square map and search modules, and to send Call and Email clicks to GA4 (`gtag`) when it's present. When CSS or JS changes, bump the `?v=` on the stylesheet and script tags in every page.
- **The Area page** shows a Google Maps embed (`<iframe>`, no API key needed). The old JS map needed an API key and no longer works.
- **Forms:** `request-information.html` and `schedule-tour.html` POST to `thankyou.php`, which emails `management@sierraplaceapartments.com` with PHP `mail()`. These forms only work on the PHP host, not under live-server. The downloadable PDFs are in `forms/`.
- **Images:**
  - The hero/background image `index-photos/pool-aerial-view.jpg` is set as an inline `background-image` style on every page, including `thankyou.php`. Swap the file in place to change it everywhere.
  - Each gallery photo is a pair: `gallery-photos/image_gallery_NNN.jpg` (full size) and `image_gallery_NNN_sm.jpg` (thumbnail). Each pair is referenced from a blueimp `<a href>`/`<img src>` block in `gallery.html`. Adding or removing a photo means editing those blocks as well as the files.
  - New gallery and hero images are generated by `tools/process_photos.py` from originals that are kept outside the repo. `tools/photos.json` maps each slot to its source photo. See [tools/PHOTOS.md](tools/PHOTOS.md) before replacing or adding photos; don't hand-edit those images.
  - Floor plan images are in `floorplans/`.
- **`sitemap.xml`** lists the public pages. Update it when you add or remove a page.

## Branches and work in progress

- `main` is the published site (renamed from `master` in October 2026). The Fall 2025 content update (`fall_2025`) was merged into it in October 2026. [TODO.md](TODO.md) tracks the property owner's requested changes.
- Deployment is a manual FTP upload from a `main` checkout. Upload only the changed pages and asset folders. Never upload `forms/` (it contains a rental application the owner asked to take down), `new-photos/`, `tools/`, `react/`, `node_modules/` or the repo's docs and config files (`*.md`, `package*.json`, `bower.json`).
  - `robots.txt`, `sitemap.xml`, `llms.txt`, `.htaccess` and `404.html` are site files and do get uploaded.
  - Before uploading `.htaccess`, merge in any `.htaccess` already on the server. Its http-to-https rule is commented out until it's tested (see SEO.md).
- `react/` and the local `react` branch are an unfinished React migration (WIP, not on `main`). Don't mix that work into content changes.
- Business facts are set by the owner's requests in TODO.md. For example: no pricing, no fitness room, small to medium pets only, no move-in specials, no instant application processing, and office hours of 9am–4pm Monday–Friday. Copy shouldn't contradict them.
  - Square footage: the website's figures (Cedar 654, Sierra 859, Sequoia 1,110, Redwood 1,133 sq ft) were confirmed in October 2026. The brochure and the AppFolio listings use older figures.
  - Until the owner answers the questions in TODO.md, don't advertise lease terms (short-term, furnished), dishwashers, included utilities or Spanish-speaking staff, and don't add a Spanish page. Don't mention housing vouchers (the client's decision, October 2026).
  - Don't call the community luxury or luxurious.
