# SEO and AI search plan

October 2026. Covers Google, Bing, Apple Maps, rental listing sites and AI assistants (Google AI Overviews and AI Mode, ChatGPT, Perplexity, Gemini, Copilot). Business facts follow the owner's rules in [TODO.md](TODO.md) and [CLAUDE.md](CLAUDE.md).

## Where things stood

Research done on October 4, 2026.

**What was working.** Sierra Place shows up third in Google's map results for "apartments porterville ca", ahead of most competitors. It ranks there despite an unclaimed profile and only 7 reviews (4.6 stars).

**What was hurting the site:**

| Problem | Effect |
|---|---|
| The Google Business Profile is unclaimed ("Own this business?"). It's categorized as "Apartment building" and shows hours opening at 8 AM. | Nobody controls the hours, photos, description or category of your most important listing. |
| Yelp marks the property **"Closed"**. | Apple Maps, Siri and AI assistants read Yelp data. |
| Apartments.com describes the property as "Fox Hollow Apartments" with "granite countertops" and says it isn't advertising. | A wrong name and wrong features on the biggest listing site. |
| Google's AI Overview gives office hours of 8:00 AM to 5:30 PM, taken from Rentable. A 211 directory (icarol.info) lists phone (559) 781-1280. | AI answers repeat third-party mistakes because the site didn't state its facts in a machine-readable way. |
| `sitemap.xml` listed `www.sierraplace.com`, a different domain. There was no `robots.txt` and no canonical tags. Every page answered on http, https, www and non-www, and the home page also at `/index.html`. | Search engines saw up to five copies of every page, and the sitemap pointed nowhere. |
| On HTTPS, the browser blocked the Open Sans fonts and the area map script as mixed content, so the area map was blank. The JS bundle also requested a missing `/api/locations` on every page and threw errors on Call and Email clicks. | The site looked broken and loaded dead requests. |
| Menus were hidden below 992 px wide. | Phone and tablet visitors had no page navigation. |
| Copy broke owner rules: "Large Breeds Welcome" (amenities description), "washer and dryer units in most homes", "luxurious". | Wrong expectations for renters, plus conflicting facts for search engines. |
| Floor plan copy contradicted itself (the Redwood listed as both 1,133 and 1,016 sq ft) and had a "Sequoa" typo. | Inconsistent facts. |
| There was no analytics. The bundle still called Universal Analytics, which was retired in 2024. | No way to measure results. |

## Audience and positioning

**Who rents here:**
1. **Healthcare workers.** Sierra View Medical Center (a 167-bed acute care hospital) is 0.7 miles away, about a 15-minute walk.
2. **Staff at Porterville's other big employers.** Porterville Developmental Center is about 12 minutes away, the Walmart Distribution Center about 10, Eagle Mountain Casino about 15 (1,000+ staff since its 2023 move), and Porterville College and PUSD 3 to 7.
3. **People relocating** from Bakersfield (1 hr), Fresno (1 hr 20 min) and Visalia or Tulare (35 to 40 min), usually for one of the jobs above.
4. **Local renters** who want a pool community with central air conditioning and covered parking.

**Competitors on Google** (map results and listing sites):

| Community | What it offers | Google rating |
|---|---|---|
| The Village at Henderson, 1711 W Henderson Ave | Built 2015, 168 units, 1 and 2 BR from about $1,500. Pool, gym, clubhouse, gated. | 3.8 (47) |
| Park View Village, 550 W Springville Ave | Income-restricted 2 and 3 BR. Pool, gym. | 4.8 (19) |
| Villa Siena, 200 N E St | Tax-credit/USDA (agricultural income required), 1 to 3 BR | 4.1 (30) |
| Villa Robles, 450 W Springville Ave | 2 to 4 BR, about $1,176 to $1,483 | n/a |
| Fox Hollow, 1040 W Grand Ave | 2 and 3 BR, about $1,313 to $1,696 | n/a |
| Sierra View Apartments, 554 W Morton Ave | Small complex, 0.4 mi from the hospital | 4.7 (3) |

**Positioning:** Sierra Place is the established, central pool community with 1 and 2 bedroom apartments a short walk from Sierra View Medical Center. Its strengths are the commute, landscaped grounds, covered parking, local management and thorough screening.
- Against Henderson, compete on location and value, not on newness or a gym.
- Against the income-restricted communities, Sierra Place serves working professionals. Confirm there are no income limits before saying so anywhere.

## What changed on the site (`seo` branch)

**Technical:**
- **Every page got a `<head>` rewrite:** a unique title and description, a canonical URL on `https://sierraplaceapartments.com`, Open Graph tags for link previews (Facebook, iMessage, Slack), a viewport that allows zoom, and a preload for the hero image.
- **Structured data (JSON-LD):**
  - Home page: an `ApartmentComplex` and `LocalBusiness` entity with address, coordinates, phone, office hours, amenities, pet policy, tour page and the four floor plans.
  - Floor plans page: `FloorPlan` data.
  - FAQ and hospital pages: `FAQPage` data.
  - Every other page: breadcrumbs.
  - The stale microdata in the header was removed.
- **Fixed files:**
  - `sitemap.xml` now uses the correct domain, lists the new pages and includes gallery and floor plan images.
  - New `robots.txt` that allows all search engines and AI crawlers.
  - New `llms.txt`, a plain-text fact sheet for AI assistants.
  - New `404.html`.
- **`.htaccess`:** redirects www to non-www and `/index.html` to `/`, sets the 404 page and browser caching. A tested-before-enabling http-to-https rule is included but turned off.
- **Fonts load over HTTPS** (`css/custom.min0ff5.css`).
- **JS bundle (`js/optimized.js`):** stopped loading the keyless Google Maps API and the missing `/api/locations`. Call and Email clicks now send a GA4 `call_to_action` event once GA4 is installed, instead of throwing errors.
- **Mobile:** the page menu shows on phones and tablets, and content text is larger and easier to read.
- **Phone links** use `tel:+15597818000`, and logo and nav links point to `/` instead of `index.html`.
- **Gallery thumbnails** have dimensions and load lazily below the fold.

**Content:**
- **Home:** rewritten around the facts and audiences, with a "Sierra Place at a glance" fact list that AI assistants can quote, a "why renters choose us" section, and links to the new pages.
- **New: [apartments-near-sierra-view-medical-center.html](apartments-near-sierra-view-medical-center.html).** Commute table, reasons for shift workers, floor plans for roommates, and an FAQ. Nobody ranks for this search today.
- **New: [moving-to-porterville.html](moving-to-porterville.html).** Relocation guide for renters coming from Bakersfield, Fresno and Visalia, with employers and how to tour from out of town.
- **New: [faq.html](faq.html).** 17 answers covering location, sizes, pricing policy, pets, laundry, fitness center (none), parking, A/C, hours, tours, applying, schools, rent payment and maintenance.
- **The Area:** the broken map was replaced with a working Google Maps embed, plus measured distance and drive-time tables for employers, schools, cities, airports and outdoor destinations. The old map plotted several places at wrong coordinates (Porterville High was about 50 miles west).
- **Amenities:** description fixed, plus a "Good to know" section that is clear about washers and dryers and the pet size rule.
- **Floor plans:** intro text, fixed Sequoia and Redwood descriptions, and descriptive image alt text.
- **Contact:** phone, email, address, hours and the emergency maintenance number shown above the form.
- **Forms:** the bedroom choices are now One and Two only. "How did you hear about us?" adds Google Maps, Zillow/Trulia/HotPads, Facebook, "ChatGPT or another AI assistant" and "Employer or coworker referral", so you can see which channels work.
- **New footer on every page:** name, address, phone, hours and links to the new pages.

**Keyword map:**

| Page | Searches it targets |
|---|---|
| `/` | apartments porterville ca, sierra place apartments, 1 bedroom / 2 bedroom apartments porterville |
| `apartments-near-sierra-view-medical-center.html` | apartments near sierra view medical center, housing near sierra view hospital, apartments for nurses porterville |
| `floorplans-pricing.html` | 2 bedroom 2 bath apartment porterville, townhome style apartment porterville |
| `amenities.html` | apartments with pool porterville, pet friendly apartments porterville |
| `the-area.html` | porterville commute, apartments near porterville college / developmental center |
| `moving-to-porterville.html` | moving to porterville ca, porterville from bakersfield / fresno |
| `faq.html` | question-style searches and AI assistant answers |

## Deploying the `seo` branch

Merge `seo` into `main`, then upload these from the repo root by FTP:

- Changed pages: `index.html`, `amenities.html`, `floorplans-pricing.html`, `gallery.html`, `the-area.html`, `contact-us.html`, `rental-forms.html`, `request-information.html`, `schedule-tour.html`, `pay-online.html`, `work-order.html`, `thankyou.php`
- New pages: `apartments-near-sierra-view-medical-center.html`, `moving-to-porterville.html`, `faq.html`, `404.html`
- `css/custom.min0ff5.css`, `js/optimized.js`
- `robots.txt`, `sitemap.xml`, `llms.txt`
- `.htaccess`: **first download any existing `.htaccess` from the server** and merge its contents into ours, so host settings aren't lost.

Don't upload `SEO.md` or the other repo docs (see CLAUDE.md).

**While you're connected, delete these from the server's `forms/` folder.** They're publicly downloadable, and the owner asked for the rental application to come down:
- `Application 2025.pdf` (rental application)
- `sierra_place_application.pdf` (rental application)
- `119_form_15.pdf` (old rental application)
- `119_form_16.pdf` (lease guaranty) and `119_form_17.pdf` (card authorization form), unless the office still sends people to them

Keep `brochure.pdf`; it's linked from every page. `Layouts.pdf` isn't linked from any page.

**Test after uploading:**

```bash
curl -sI https://www.sierraplaceapartments.com/
```

Expect `301` with `Location: https://sierraplaceapartments.com/`.

```bash
curl -sI https://sierraplaceapartments.com/index.html
```

Expect `301` with `Location: https://sierraplaceapartments.com/`.

```bash
curl -sI https://sierraplaceapartments.com/no-such-page
```

Expect `404`. Open that URL in a browser and you should see the new "Page Not Found" page.

**Turning on the http-to-https redirect:** remove the `#` from the three lines at the end of the rewrite block in `.htaccess` and upload it again. Then:

```bash
curl -sI http://sierraplaceapartments.com/
```

Expect `301` to `https://`.

```bash
curl -sI https://sierraplaceapartments.com/
```

Expect `200`. If this returns another `301`, or the browser says "too many redirects", the host terminates HTTPS in a proxy. Put the `#` back and upload again right away. The canonical tags already point search engines to the https URLs, so the site is fine without this rule.

## Off-site action plan

In priority order. Most of these need the owner's or Homes for Rent's logins, so they can't be done from the code.

1. **Claim the Google Business Profile.** Search "Sierra Place Porterville", click "Own this business?" and verify.
   - Primary category: **Apartment complex**.
   - Hours: Monday to Friday 9 AM to 4 PM, closed weekends.
   - Website: `https://sierraplaceapartments.com/?utm_source=google&utm_medium=organic&utm_campaign=gbp`, so profile visits show up separately in analytics.
   - Add the attributes that apply, upload 10 or more gallery photos (pool, grounds, interiors, carports) and paste the description below.
   - Post an update monthly.

   Suggested description (Google allows 750 characters and no links):

   > Sierra Place Apartments is a garden-style community in central Porterville with one- and two-bedroom apartments in four floor plans, including a two-story townhome-style plan and a two-bedroom, two-bath plan. Residents enjoy an enclosed swimming pool and sundeck, landscaped grounds, covered parking, central air conditioning, on-site laundry facilities and 24-hour emergency maintenance. Small to medium pets are welcome. We're 0.7 miles from Sierra View Medical Center and less than a mile from Highway 65, with Porterville College, Porterville Developmental Center and downtown Main Street minutes away. Managed by Homes for Rent, with the leasing office open Monday to Friday, 9 AM to 4 PM.

2. **Reviews.** Ask happy residents for a Google review at move-in, at lease renewal and after a completed work order, using the profile's review link. Reply to every review.
   - Don't offer anything in exchange: Google prohibits it, and the owner doesn't allow specials.
   - Goal: 25 or more reviews within six months. The Village at Henderson has 47 at 3.8 stars, so a higher rating with real volume puts Sierra Place first.
3. **Yelp.** Claim the listing at biz.yelp.com and mark it open, with the correct hours, phone and website. Yelp feeds Apple Maps and Siri.
4. **Apple Business Connect** (businessconnect.apple.com). Claim the Apple Maps place card and set the hours.
5. **Bing.** Set up Bing Places (it can import from Google) and Bing Webmaster Tools, and submit `https://sierraplaceapartments.com/sitemap.xml`. ChatGPT search and Copilot rely on Bing's index.
6. **Google Search Console.** Verify the domain with a DNS TXT record, submit the sitemap and request indexing for the four new pages. After about four weeks, check Page indexing to confirm the www and http copies are consolidated.
7. **Fix the listing sites:**
   - **Apartments.com, ApartmentFinder, ForRent (CoStar):** use "Report an Issue" on the Apartments.com page to remove the "Fox Hollow Apartments" description and "granite countertops". There are also duplicate "333 N Indiana St" listings.
   - **Rent.com, ApartmentGuide, Redfin, Zillow, HotPads, Trulia:** these get unit listings from Homes for Rent's AppFolio account. Those listings use 588 / 832 / 1,016 sq ft, the old brochure numbers. **Change them to the website's sizes** (654 / 859 / 1,110 / 1,133 sq ft, confirmed October 2026) so every source agrees. Also name the property "Sierra Place Apartments" in AppFolio and use the same features list.
   - **Zumper and PadMapper:** claim the building page.
   - **Rentable:** ask them to correct the office hours. This is where Google's AI Overview got 8:00 to 5:30.
   - **icarol.info** (Tulare County 211): correct the phone number.
8. **Local citations and links.** Join the Porterville Chamber of Commerce; Park View Village and The Village at Henderson are members, and it gives a directory listing and a link. Make sure Homes for Rent's website links to sierraplaceapartments.com.
9. **Employer outreach.** Give a one-page flyer to Sierra View Medical Center HR and recruiting (new-hire relocation packets), travel-nurse agency housing coordinators, Porterville College and PUSD new-staff onboarding. Wait until the brochure is updated (see TODO.md).
10. **Analytics.** Create a GA4 property and add its tag to every page. The site already sends a `call_to_action` event for Call, Email and form buttons once `gtag` exists. Review the "How did you hear about us?" answers monthly.
11. **Speed.** The hero image (`index-photos/pool-aerial-view.jpg`, about 600 KB) is the largest download on every page. Add a WebP output or a lower quality setting to `tools/process_photos.py` rather than editing the image by hand (see tools/PHOTOS.md).

## Checking AI answers

Once a month, ask Google (AI Mode), ChatGPT, Perplexity and Gemini:
- "apartments near Sierra View Medical Center"
- "Sierra Place Apartments Porterville office hours"
- "pet friendly apartments in Porterville CA with a pool"
- "best apartments in Porterville for nurses"

Note wrong facts and trace them to the source: usually a listing site or directory from the list above. The fix is almost always correcting that source, since AI answers cite it.

## What to measure

| Metric | Where | Baseline (Oct 2026) |
|---|---|---|
| Google reviews and rating | Business Profile | 7 reviews, 4.6 |
| Map ranking for "apartments porterville ca" | Google | 3rd |
| Calls, direction requests and website clicks | Business Profile performance | Not available (unclaimed) |
| Impressions and clicks for the keyword map above | Search Console | Not set up |
| Lead sources | "How did you hear about us?" in lead emails | n/a |
