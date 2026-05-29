# eNivesh Financial Services — Website

A responsive, single-page marketing website for **eNivesh Financial Services**, a SEBI-registered financial advisory firm based in Patna, Bihar. The site presents the company's services, pricing, and contact information, and includes a PHP backend for contact form handling.

---

## Project Structure

```
enivesh69-main/
├── index.html              # Main landing page (all sections)
├── enivesh-contact.html    # Standalone contact page
├── enivesh-ticker.html     # Live BSE/NSE market ticker widget
├── privacy-policy.html     # Privacy policy page
├── legal-notice.html       # Legal notice / disclaimer page
├── contact.php             # Contact form submission handler
├── send-enquiry.php        # Enquiry form mailer (PHPMailer + SMTP)
├── api.php                 # PHP proxy for third-party API calls
├── sitemap.xml             # XML sitemap for SEO
├── user.ini                # PHP runtime configuration
├── web.config              # IIS server configuration (Windows hosting)
└── favicon.ico             # Site favicon
```

---

## Tech Stack

| Layer      | Technology                                      |
|------------|-------------------------------------------------|
| Frontend   | HTML5, CSS3 (custom properties), vanilla JS     |
| Fonts      | Google Fonts — Sora, Playfair Display           |
| Backend    | PHP 7.1+ (form handling, SMTP mailer, API proxy)|
| Mailer     | PHPMailer (SMTP via `plesk-web3.webhostbox.net`)|
| Hosting    | Windows IIS (indicated by `web.config`)         |

---

## Pages & Sections

### `index.html` — Main Landing Page

Contains all primary content sections, navigable via anchor links:

- **#home** — Hero with headline, CTAs, and animated stat cards
- **Trust Bar** — Regulatory logos: SEBI, AMFI, IRDAI, BSE, NSE
- **#services** — Six service cards (Equity, Mutual Funds, PMS, Insurance, Loans, International Investing)
- **#about** — Company background, office hours
- **#process** — 4-step client onboarding process
- **#pricing** — Tabbed pricing table (Investments, Insurance, Loans)
- **#testimonials** — Client testimonials carousel
- **#faq** — Frequently asked questions accordion
- **#contact** — Contact form + address, phone, email details

### `enivesh-contact.html`
Standalone dedicated contact page with its own form.

### `enivesh-ticker.html`
Embeddable live BSE/NSE index ticker widget.

---

## Services Offered

- **Equity / Stock Broking** — Direct equity investing via BSE/NSE
- **Mutual Funds** — 1000+ schemes, SIP from ₹500/month
- **Portfolio Management Services (PMS)** — Min ₹50 Lakhs
- **Insurance** — Life, health, term; from ₹1,500/yr
- **Loans** — Home, personal, business; from 6.5% p.a.
- **International Investing** — Global equities; Min ₹1 Crore

---

## Contact & Business Details

| Field            | Value                            |
|------------------|----------------------------------|
| Phone / WhatsApp | +91-9031831828                   |
| Email            | info@enivesh.in                  |
| Address          | Bailey Road, Patna – 800014, Bihar |
| Founded          | 2006                             |
| Facebook         | facebook.com/enivesh.in          |
| Instagram        | instagram.com/enivesh.in         |

---

## Regulatory Registrations

The firm is registered with and regulated by:

- **SEBI** — Securities and Exchange Board of India
- **AMFI** — Association of Mutual Funds in India (ARN holder)
- **IRDAI** — Insurance Regulatory and Development Authority of India

---

## Backend: Contact & Enquiry Forms

### `contact.php`
Handles the main contact form POST. Validates fields and sends an email notification.

### `send-enquiry.php`
Uses PHPMailer to send enquiry submissions via SMTP:
- **SMTP Host:** `plesk-web3.webhostbox.net`
- **Sender:** `info@enivesh.in`
- **PHP compatibility:** 7.1+

> ⚠️ **Security note:** SMTP credentials are currently hard-coded in `send-enquiry.php`. Before deploying or sharing this code, move credentials to environment variables or a server-side config file outside the web root.

### `api.php`
A PHP reverse proxy that forwards requests to third-party APIs (e.g., live market data feeds). Reads `REQUEST_URI` and `HTTP_HOST` to construct the proxied URL.

---

## Deployment Notes

- The project is configured for **Windows IIS hosting** via `web.config`.
- `user.ini` sets PHP runtime options (e.g., upload limits, execution time).
- The `sitemap.xml` lists the main URLs for search engine indexing.
- All HTML pages are self-contained (fonts loaded from Google CDN; no local build step required).

---

## Local Development

No build toolchain is needed. To run locally:

1. Set up a local PHP server (e.g., XAMPP, Laragon, or PHP built-in server):
   ```bash
   php -S localhost:8000
   ```
2. Open `http://localhost:8000/index.html` in a browser.
3. For form functionality, configure SMTP credentials in `send-enquiry.php`.
