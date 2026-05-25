# Companions Group

**Verified adult companion B2C platform — escort marketplace — Argentina**

[![Laravel 11](https://img.shields.io/badge/Laravel-11.x-red?logo=laravel)](https://laravel.com)
[![PHP 8.2](https://img.shields.io/badge/PHP-8.2-blue?logo=php)](https://php.net)
[![Livewire 3.x](https://img.shields.io/badge/Livewire-3.x-pink)](https://livewire.laravel.com)
[![Tailwind CSS 3.4](https://img.shields.io/badge/Tailwind-3.4-38bdf8?logo=tailwindcss)](https://tailwindcss.com)
[![Redis 7.x](https://img.shields.io/badge/Redis-7.x-red?logo=redis)](https://redis.io)
[![MariaDB 10.11](https://img.shields.io/badge/MariaDB-10.11-blue?logo=mariadb)](https://mariadb.org)

---

## Overview

Companions Group is a production-grade B2C platform for advertising verified adult companions. The same codebase powers multiple brand deployments, each with its own visual identity, domain, and isolated data layer — all sharing a single maintained application core.

---

## Features

### For Models (supply side)

- **Multi-step KYC wizard** — Document upload + selfie verification with AES-256-CBC encrypted storage of personal data. Every model is a real, verified person.
- **Full listing management** — Self-service editor with 7 tabs: basic info, appearance, languages, services, rates, availability schedule, and media.
- **Media gallery** — Photos with drag & drop reordering, cover photo designation, automatic watermarking, embedded video URLs (YouTube/Vimeo/other), and direct video uploads.
- **Subscription management** — Models track their active plan, billing dates, and renewal status from their dashboard.
- **Multi-channel notifications** — In-app notification bell, transactional email (Postfix/Brevo SMTP relay), and Telegram bot with one-click account linking from the dashboard.
- **Privacy controls** — Per-channel visibility toggles (WhatsApp, Telegram, email, phone, TikTok, Instagram, OnlyFans). Real name and ID number are never publicly exposed.
- **Full profile** — Dedicated profile page with cascading location selectors (country → province → city → neighborhood); all changes reflected immediately in public listings.
- **Contact visibility** — Models choose which contact channels appear on their public listing via individual per-channel toggles.
- **SEO-optimized listing URLs** — Each active listing has a clean, human-readable slug URL for better organic search visibility.

### For Subscribers (demand side)

- **Advanced search engine** — 15+ simultaneous filters: location (neighborhood, city, province), service types, physical attributes (height, weight, measurements, eye/hair color), price range, language, habits, and verification status.
- **Featured positioning algorithm** — Models with a "featured" subscription appear ahead of standard listings across all searches.
- **Favorites** — Save and revisit preferred profiles across sessions.
- **Dual-moderation review system** — 1–5 star ratings + text comments. Admin approves first; then the model decides whether to publish or hide the review.
- **Contact history** — Automatic logging of all interactions per model: WhatsApp taps, Telegram opens, email clicks, phone reveals, and listing view events — with timestamped event log.
- **Sorted search results** — Sort by most recent, featured first, or by relevance.

### For Platform Operators (admin panel)

- **KYC review queue** — Inline document lightbox (front ID, back ID, selfie, selfie with document). Approve or reject with reason. Personal data decryption restricted to `full` / `superadmin` roles.
- **Full listing moderation** — Approve, reject (with reason), temporarily suspend (date picker + quick buttons: 1/3/7/14/30 days), automatic reactivation on expiry. Sortable by model, title, status, or publication date.
- **Subscription management** — Full lifecycle CRUD: create subscriptions for specific listings, assign plan + duration, activate, cancel, or delete. Linked listing activation on create/update. Sortable by ID, plan, status, start and end date.
- **Plan catalog** — Full CRUD for subscription plans: name, price, duration, feature flags, sort order.
- **Payment processing** — Voucher review, manual activation, full payment history per user.
- **Arrears dashboard** — Models with expired subscriptions listed by days overdue and accumulated amount.
- **Dynamic visual theme system** — No-code visual customization: 270+ CSS design tokens, fullpage editor with 3 tabs (Colors, Typography, Custom), multiple themes per brand with live preview. Zero hardcoded colors — the entire UI adapts from database-managed CSS variables.
- **No-code content management** — FAQ (segmented by role), Terms & Conditions, Privacy Policy — all editable from the admin UI without touching code.
- **Email template management** — All transactional notification templates editable from the admin panel.
- **Service catalog** — Full CRUD + activation toggle + drag & drop reordering for 40+ service types.
- **Admin user management** — Create, edit, activate/deactivate admin accounts with role assignment (basic / full / superadmin). Sortable by ID, status, and last login.
- **Integration settings** — Telegram bot token configuration with a live test panel (send test message to admin or channel directly from the UI).
- **Sortable tables across admin** — All major panel tables (users, KYC, admin accounts, listings, subscriptions) support multi-column sorting with directional indicators, persisted across pages.
- **Blog management** — Full CRUD for blog posts: create, edit, publish/archive, manage categories and tags. Posts appear on the public blog listing page and are indexed in the sitemap.
- **2FA TOTP** — Google Authenticator mandatory for every admin session, per login.
- **Immutable audit log** — Every admin action recorded with actor, timestamp, IP, and before/after values.

---

## Architecture

### Technology stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 11.x |
| Language | PHP 8.2 |
| Reactive frontend | Blade + Livewire + Alpine.js 3.x |
| CSS / Build | Tailwind CSS 3.4 + Vite 5.x |
| Database | MariaDB 10.11 (InnoDB, utf8mb4) |
| Cache / Sessions / Queue | Redis 7.x |
| Web authentication | Laravel session + bcrypt |
| Admin authentication | Separate DB table + guard + TOTP 2FA |
| REST API authentication | JWT (PHPOpenSourceSaver) 2.0 |
| Identity encryption | AES-256-CBC via Laravel `Crypt` (APP_KEY) |
| Payments | MercadoPago SDK 3.x |
| Email | Postfix relay → Brevo SMTP |
| Push notifications | Telegram Bot API |
| Image processing | Intervention Image 3.x (watermarking) |
| Server | Nginx + PHP-FPM 8.2, Debian bare metal |

### Three isolated environments

```
companions/
├── dev/www    →  dev.domain.cc           DB: companions_dev    Redis: project=N, env=1
├── qa/www     →  qa.domain.cc            DB: companions_qa     Redis: project=N, env=2
└── prod/www   →  country.domain.cc       DB: companions_prod   Redis: project=N, env=3
```

Every change flows strictly **DEV → QA → PROD**. Each environment has its own `.env`, isolated Redis slots (project × environment matrix), and independent PHP-FPM pools. Multiple brand deployments share a single server — isolated at the application layer.

### Design theme system

The platform runs a database-managed visual theme engine. On every HTTP request, the `LoadActiveTheme` middleware retrieves the active theme (24h cache via `ThemeService`) and injects ~270 custom CSS properties into `:root {}`. All views reference only `var(--token-name)` — zero hardcoded colors anywhere in the source code.

### SEO architecture

- **Schema.org JSON-LD** on all public listing pages (Person, Service, and Review structured data for Google rich results).
- **Neighborhood landing pages** — 52 CABA neighborhood-specific pages with geo-targeted content, targeting hyperlocal search intent.
- **Dynamic sitemap** — Auto-generated XML sitemap includes active listings, model profiles, neighborhood pages, static pages, and blog posts.
- **Open Graph / Twitter Cards** — Full og:image, og:title, og:description metadata on all public pages.
- **Canonical URLs** — Correct canonical tags on all brand deployments to prevent cross-domain duplicate content.

---

## Data model (35+ tables)

```
users ──< escort_profiles ──< avisos ──< aviso_photos
               │                    ├──< aviso_videos
               │                    ├──< aviso_languages
               │                    └──< aviso_services >── service_types
               ├──< escort_rates
               ├──< escort_languages
               └──< weekly_schedules

users ──< kyc_submissions ──────────── admin_users (reviewed_by)
users ──< subscriptions  >──────────── subscription_plans
users ──< payments
users ──< reviews        ──────────── escort_profiles
users ──< favorites      ──────────── avisos
users ──< contact_links  ──< contact_events   ← manual + auto view tracking (F3)

admin_users ──< audit_logs
            ──< moderation_actions

design_themes ──< token_definitions    ← visual theme system
blog_posts >── blog_categories         ← blog module
site_settings                          ← platform configuration
email_templates                        ← notification templates
faqs                                   ← role-segmented FAQ content
provinces >── countries                ← geography
pages                                  ← T&C, Privacy Policy
```

All tables: InnoDB engine, `utf8mb4_unicode_ci`, full FK indexing.

---

## Core lifecycle flows

### Model account

```
Register → Verify email → Submit KYC → Admin review → Active
         → [Admin suspends with date] → Auto-reactivation on expiry
         → [Admin bans] → Banned (terminal state)
```

### Listing

```
Draft → Pending (admin queue) → Pending payment → Active
     → [Admin suspends + days] → Auto-reactivation via cron (15 min)
     → [Subscription expires via cron (every hour)] → Inactive
     → [Subscription renewed / admin activates] → Active
```

### Subscription

```
Admin creates → Active (immediate) → Linked listing activates
→ [Daily expiry cron] → Expired → Linked listing deactivates
→ [Admin renews / creates new] → Active again
```

### Review

```
Subscriber submits → Admin queue → Admin approves
→ Model decides → Published (public) or Hidden
```

---

## Security architecture

| Layer | Implementation |
|---|---|
| Transport | TLS 1.2/1.3 on all environments |
| KYC personal data | AES-256-CBC via APP_KEY — name, date of birth, document number encrypted at rest |
| Identity documents | Private filesystem, served exclusively through PHP controller with controlled access |
| Admin access | Separate DB table + guard + TOTP 2FA (Google Authenticator) |
| Role control | `basic` / `full` / `superadmin` — personal data decryption requires `full`+ |
| Forms | CSRF on all endpoints (Telegram webhook explicitly excluded) |
| Brute force protection | Rate limiting on all auth endpoints: web login (5/min), register (5/10min), password reset (5/10min), email resend (3/10min), 2FA challenge (5/5min), admin password reset (5/10min), listing view tracking (60/min), API login (5/2min), API register (5/10min) |
| HTTP headers | HSTS, X-Frame-Options, X-Content-Type-Options, X-XSS-Protection (Nginx) |
| Traceability | Immutable `audit_logs` — actor, action, subject, before/after values, IP |
| GDPR | Explicit consent and age verification timestamps on registration |
| Sensitive files | `.env`, `.git` blocked at Nginx level |
| Secrets | All tokens and keys stored exclusively in `.env`; no secrets in source code |

---

## Repository structure

This public repository exposes the presentation and schema layers of the platform:

```
companionsgroup/
├── database/
│   └── migrations/           ← Full DB schema — 35+ tables
├── public/
│   └── landing/              ← Static landing (country selector + age verification)
├── resources/
│   └── views/
│       ├── pages/            ← Home, profiles, search, FAQ, legal pages
│       ├── components/       ← Reusable public UI components
│       ├── layouts/          ← Public and admin layouts with SEO stack
│       └── errors/           ← 403, 404, 500
└── routes/
    └── web.php               ← Public route definitions
```

The full business logic layer is maintained in private per-brand repositories: admin panel, KYC wizard, Livewire components, model and subscriber dashboards, application services, payment integrations.

---

## Production status

| Feature | Status |
|---|---|
| Authentication + email verification | ✅ Production |
| KYC identity verification (wizard + admin) | ✅ Production |
| Model listing management (7-tab editor) | ✅ Production |
| Public profiles + lightbox gallery | ✅ Production |
| Advanced search engine (15+ filters) | ✅ Production |
| Featured positioning algorithm | ✅ Production |
| Dual-moderation review system | ✅ Production |
| Subscription plans + payment flow | ✅ Production |
| Email notifications (Postfix/Brevo) | ✅ Production |
| Telegram bot + account linking | ✅ Production |
| Full admin panel | ✅ Production |
| No-code content management (FAQ, T&C, Privacy) | ✅ Production |
| Dynamic design theme system (270+ tokens, fullpage editor) | ✅ Production |
| Sortable admin tables (users, KYC, listings, subscriptions) | ✅ Production |
| Plan and subscription management (admin CRUD) | ✅ Production |
| Integration settings + Telegram live test panel | ✅ Production |
| Contact history + auto view tracking (F3) | ✅ Production |
| Arrears dashboard | ✅ Production |
| Automatic expiry cron (subscriptions hourly + suspensions every 15 min) | ✅ Production |
| Automatic daily DB + file backups | ✅ Production |
| Technical SEO (meta, OG, structured data) | ✅ Production |
| Schema.org JSON-LD (Person, Service, Review) | ✅ Production |
| Neighborhood landing pages (52 CABA barrios) | ✅ Production |
| Dynamic XML sitemap (listings + profiles + barrios + blog) | ✅ Production |
| Blog module (admin CRUD + public listing) | ✅ Production |
| Rate limiting on all auth endpoints | ✅ Production |
| PWA (manifest + service worker) | ✅ Production |
| GDPR cookie consent banner | ✅ Production |
| MercadoPago webhook (signature verification + auto-activation + recurring) | ✅ Production |
| CI/CD pipeline (GitHub Actions) | 📋 Planned |

---

## Contact

This is a proprietary commercial platform. The full source code is not open source.

For licensing inquiries, technical partnerships, or investment:

**groupcompanions.arg@gmail.com**

---

## License

**Proprietary — All rights reserved**

This repository is public for portfolio and presentation purposes only.
Unauthorized copying, modification, distribution, or commercial use of any part of this code without explicit written authorization is strictly prohibited.

© 2026 Companions Group. All rights reserved.

---

*Built with ❤️ in Argentina · Laravel 11 · PHP 8.2 · Livewire · Tailwind CSS · Redis · MariaDB*
