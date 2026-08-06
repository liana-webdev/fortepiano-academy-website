# Tracking configuration

All tracking placeholders live in one marked `tracking` section in the private `config.php`. No real IDs are committed to public project files.

Supported values:

- `gtm_container_id` — Google Tag Manager container (`GTM-…`)
- `ga4_measurement_id` — GA4 web stream (`G-…`)
- `google_ads_conversion_id` — Google Ads destination (`AW-…`)
- `google_ads_conversion_label` — the matching lead conversion label
- `meta_pixel_id` — Meta Pixel/Dataset ID

Leave an unused value blank. If Google Tag Manager manages GA4, Google Ads or Meta itself, leave the corresponding direct-tag value blank to avoid duplicate events.

## Events

Every page may record its normal page view after its relevant ID is configured:

- Google Tag Manager container load
- GA4/Google tag page view
- Meta Pixel `PageView`

Only the first valid, unexpired confirmation immediately following successful SMTP delivery can record:

- data layer event `generate_lead`
- GA4 event `generate_lead`
- Google Ads conversion using `AW-ID/LABEL`
- Meta standard event `Lead`

The server stores a one-use, five-minute confirmation in the PHP session. A direct visit, stale link, browser refresh or local dry run cannot fire those conversion calls.

## Click hooks

The page pushes `engagement_click` with `link_type` for:

- `assessment-cta`
- `phone` (ready if a telephone link is added later)
- `email`
- `whatsapp` (ready if a WhatsApp link is added later)

## Attribution sent with the enquiry email

The page captures and safely length-limits `utm_source`, `utm_medium`, `utm_campaign`, `utm_content`, `utm_term`, `gclid`, `gbraid`, `wbraid`, `fbclid`, landing-page URL and referrer URL. Attribution is held in the current browser tab's session storage only to preserve it while the visitor remains on the page. It is not written to a lead database.

## Privacy note

This package provides tag placeholders, not a consent-management platform. Confirm the site's privacy and consent requirements before enabling advertising or analytics tags. Tracking values rendered to a browser are technically observable, as required for client-side tag operation, but they are kept out of versioned public files.
