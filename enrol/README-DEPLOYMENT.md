# Fortepiano Academy `/enrol` deployment

This folder is a standalone PHP 8.1+ landing page. It does not use a database and it does not use PHP `mail()`.

## Before upload

1. Copy `config.example.php` to `config.php`.
2. Open the new `config.php` and enter the authenticated SMTP host, port, encryption, username and password supplied by the email host.
3. Keep `from_email` on the `fortepianoacademy.au` domain. The default recipient is `contact@fortepianoacademy.au`; the visitor's validated address is used only as `Reply-To`.
4. Enter tracking IDs in the same private file if required. Leave a value blank to disable that integration.
5. Replace the three clearly named campaign assets when approved photography is ready:
   - `assets/img/hero-lesson.webp` (1200 × 900 recommended)
   - `assets/img/studio-detail.webp` (1200 × 900 recommended)
   - `assets/img/og-image.jpg` (1200 × 630 social-sharing card)
6. Replace the text wordmark in `index.php` and `thank-you.php` with an approved logo if desired.
7. Change `site.privacy_policy_url` in `config.php` if the live privacy policy uses a different path.

## Install PHPMailer

Choose one method:

### Method A — Composer on the hosting account

From the `/enrol` folder, run:

```sh
composer install --no-dev --optimize-autoloader
```

### Method B — upload the included `vendor` folder

If the supplied ZIP contains `vendor`, upload it unchanged with the rest of the folder. No Composer command is then needed on the server.

## Upload to cPanel/shared hosting

1. Back up the current site.
2. In the domain's document root (commonly `public_html`), create or replace only the `enrol` directory.
3. Upload the contents so that `public_html/enrol/index.php` exists. Do not nest a second `enrol` directory inside it.
4. Upload the private `config.php`; confirm file permissions prevent other hosting users from editing it (typically `600` or `640`, depending on the host).
5. Confirm `.htaccess` and `includes/.htaccess` were uploaded. cPanel may hide dotfiles unless “Show Hidden Files” is enabled.
6. Visit `https://fortepianoacademy.au/enrol` and submit a real controlled test enquiry.

## Post-upload test checklist

- The page loads over HTTPS at `/enrol` and remains usable at 375px, tablet and desktop widths.
- A controlled enquiry arrives at `contact@fortepianoacademy.au` and Reply works to the visitor address.
- A deliberately incorrect SMTP password shows the on-page delivery failure and does not open the thank-you page.
- Directly opening or refreshing `thank-you.php` does not record another lead.
- The privacy-policy link resolves correctly.
- Approved tracking tools show a page view on normal pages and a Lead only after delivered mail.
- The From address passes the domain's SPF/DKIM/DMARC checks.

## Seasonal update

The URL stays `/enrol`. To change the visible campaign label, update the two “Spring 2026 Piano Enrolments” strings in `index.php`, plus the Open Graph title. No route change is required.

## Safe local test mode

For local testing only, set `testing.allow_local_test_delivery` to `true` in a local `config.php`. The application then exercises the valid submission and confirmation flow without sending or storing an enquiry. Conversion scripts remain disabled for that dry run. Never enable this option on public hosting.
