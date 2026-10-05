# Sierra Place Apartments Website

This repository contains the static website for Sierra Place Apartments, located in Porterville, California. The live site is available at [sierraplaceapartments.com](https://sierraplaceapartments.com).

## Features

- Floor plans and pricing information
- Photo gallery
- Amenities overview
- Online rental forms and application download
- Contact and request information forms
- Schedule a tour functionality
- Online rent payment instructions
- Area information

## Tech Stack

- HTML5, CSS3, JavaScript (static site)
- [Bootstrap 3](https://getbootstrap.com/docs/3.4/) for layout and components
- [jQuery](https://jquery.com/) for DOM manipulation
- [blueimp Gallery](https://github.com/blueimp/Gallery) for image and video galleries
- [RequireJS](https://requirejs.org/) for JavaScript module loading

## Local Development

1. Install dependencies:
   ```bash
   npm install
   ```
2. Start a local server:
   ```bash
   npm start
   ```
   This uses `live-server` to serve the site at `http://localhost:8080` (or another available port).

## Project Structure

- `index.html` — Home page
- `floorplans-pricing.html` — Floor plans and pricing
- `gallery.html` — Photo gallery
- `amenities.html` — Amenities
- `rental-forms.html` — Rental forms and application
- `pay-online.html` — Rent payment info
- `request-information.html` — Information request form
- `schedule-tour.html` — Tour scheduling form
- `the-area.html` — Area information
- `css/`, `js/`, `img/`, `gallery-photos/`, `index-photos/`, `floorplans/` — Static assets

## Deployment

This site is static and can be deployed to any web server. The production domain is:

**https://sierraplaceapartments.com**
