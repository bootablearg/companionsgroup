# Companions Group

**Brand adult companionship platform — escort marketplace — Argentina**

[![Laravel 11](https://img.shields.io/badge/Laravel-11.x-red?logo=laravel)](https://laravel.com)
[![PHP 8.2](https://img.shields.io/badge/PHP-8.2-blue?logo=php)](https://php.net)
[![Livewire 3.x](https://img.shields.io/badge/Livewire-3.x-pink)](https://livewire.laravel.com)
[![Tailwind CSS 3.4](https://img.shields.io/badge/Tailwind-3.4-38bdf8?logo=tailwindcss)](https://tailwindcss.com)
[![Redis 7.x](https://img.shields.io/badge/Redis-7.x-red?logo=redis)](https://redis.io)
[![MariaDB 10.11](https://img.shields.io/badge/MariaDB-10.11-blue?logo=mariadb)](https://mariadb.org)

---

## Overview

Companions Group is a production-grade, B2C platform for verified adult companionship advertising. The same codebase powers multiple branded deployments, each with its own visual identity, domain, and isolated data layer — all sharing a single, maintained application core.

---

## Feature Set

### For Models (supply side)

- **Multi-step KYC wizard** — Document upload + selfie verification with AES-256-CBC encrypted PII storage. Every model is a real, verified person.
- **Full ad management** — 7-tab self-service editor: basic info, appearance, languages, services, rates, availability schedule, and media.
- **Media gallery** — Photos with drag & drop reordering, cover photo designation, automatic watermarking, embedded video URLs (YouTube/Vimeo/other), upload videos too.
- **Subscription management** — Permit create many type of plans related with time and cost; models track their active plan, billing dates, and renewal status from their dashboard.
- **Multi-channel notifications** — In-app notification bell, transactional email (Postfix/Brevo SMTP relay), and Telegram bot with one-click account linking from model dashboard.
- **Privacy controls** — Per-channel visibility toggles (WhatsApp, Telegram, email, phone, TikTok, Instagram, Only Fans). Real name and ID never exposed publicly.
- **Profile completeness** — Separate profile page with cascaded location selectors (country → province → city → neighborhood); all changes reflected instantly across public listings.
- **Contact visibility** — Models choose which contact channels appear on their public ad with per-channel toggles.

### For Subscribers (demand side)

- **Advanced search engine** — 15+ simultaneous filters: location (neighborhood, city, province), service types, physical attributes (height, weight, measurements, eye/hair color), price range, language, habits, and verification status.
- **Featured placement algorithm** — Subscribed "featured" models surface before standard listings across all search queries, like submit reviews.
- **Favorites** — Save and revisit preferred profiles across sessions.
- **Double-moderated review system** — 1–5 star ratings + text comments. Admin approves first, then model decides to publish or hide.
- **Contact history** — Automatic tracking of all interactions (WhatsApp taps, Telegram opens, email clicks, phone reveals) per model, with timestamped event log.
- **Sorted search results** — Most recent, featured-first, and relevance-based ordering options.

### For Platform Operators (admin panel)

- **KYC review queue** — Inline document lightbox (front ID, back ID, selfie, selfie-with-doc). Approve or reject with reason. PII decryption gated to `full` / `superadmin` roles.
- **Full ad moderation** — Approve, reject (with reason), suspend temporarily (date picker + quick buttons: 1/3/7/14/30 days), auto-reactive on expiry. Sortable by model, title, status, or publication date.
- **Subscription management** — Full lifecycle CRUD: create subscriptions for specific ads, assign plan + duration, activate, cancel, or delete. Linked ad activation on subscription create/update. Sortable by ID, plan, status, start and end date.
- **Plan catalog** — Full CRUD for subscription plans: name, price, duration, feature flags, sort order.
- **Payment processing** — Receipt review, manual activation, full payment history per user.
- **Delinquency dashboard** — Models with expired subscriptions listed by days overdue and accumulated amount.
- **Dynamic Design Theme System** — No-code visual customization: 270+ CSS design tokens, fullpage editor with 3 tabs (Colors, Typography, Custom), multiple themes per brand, live preview. Zero hardcoded colors — the entire UI adapts from DB-driven CSS variables.
- **No-code content management** — FAQ (segmented by role), Terms & Conditions, Privacy Policy — all editable from admin UI without touching code.
- **Email template management** — All transactional notification templates editable from admin panel.
- **Service catalog** — Full CRUD + active toggle + drag & drop reorder for 40+ service types.
- **Admin user management** — Create, edit, activate/deactivate admin accounts with role assignment (basic / full / superadmin). Sortable by ID, status, and last login.
- **Integration settings** — Telegram bot token configuration with live test panel (send test message to admin or channel directly from UI).
- **Sortable tables across admin** — All major admin tables (users, KYC, admin accounts, ads, subscriptions) support multi-column sorting with directional indicators, persisted across pagination.
- **2FA TOTP** — Google Authenticator enforced for all admin sessions, per-login.
- **Immutable audit log** — Every admin action recorded with actor, timestamp, IP, and before/after values.

---

## Architecture

### Tech Stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 11.x |
| Language | PHP 8.2 |
| Reactive frontend | Blade + Livewire + Alpine.js 3.x |
| CSS / Build | Tailwind CSS 3.4 + Vite 5.x |
| Database | MariaDB 10.11 (InnoDB, utf8mb4) |
| Cache / Sessions / Queue | Redis 7.x |
| Web auth | Laravel session + bcrypt |
| Admin auth | Separate DB table + guard + TOTP 2FA |
| REST API auth | JWT (PHPOpenSourceSaver) 2.0 |
| Identity encryption | AES-256-CBC via Laravel `Crypt` (APP_KEY) |
| Payments | MercadoPago SDK 3.x |
| Email | Postfix relay → Brevo SMTP |
| Push notifications | Telegram Bot API |
| Image processing | Intervention Image 3.x (watermarking) |
| Server | Nginx + PHP-FPM 8.2, Debian bare metal |

### Three Isolated Environments

```
companions/
├── dev/www    →  dev.domain.cc           DB: companions_dev    Redis: project=N, env=1
├── qa/www     →  qa.domain.cc            DB: companions_qa     Redis: project=N, env=2
└── prod/www   →  country.domain.cc       DB: companions_prod   Redis: project=N, env=3
```

Every change flows strictly **DEV → QA → PROD**. Each environment has its own `.env`, isolated Redis DB slots (project × environment matrix), and independent PHP-FPM pools. Multiple branded deployments share one server — isolated at the application layer.

### Design Theme System

The platform runs a DB-driven visual theming engine. On every HTTP request, `LoadActiveTheme` middleware fetches the active theme (cached 24h via `ThemeService`) and injects ~270 CSS custom properties into `:root {}`. All views reference only `var(--token-name)` — zero hardcoded colors anywhere in the codebase.

---

## Data Model (35+ tables)

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
users ──< contact_links  ──< contact_events

admin_users ──< audit_logs
            ──< moderation_actions

design_themes ──< token_definitions    ← visual theming system
site_settings                          ← platform-level config
email_templates                        ← notification templates
faqs                                   ← segmented FAQ content (by role)
provinces >── countries                ← geography
pages                                  ← T&C, Privacy Policy
```

All tables: InnoDB engine, `utf8mb4_unicode_ci`, full FK indexing.

---

## Key Lifecycles

### Model account

```
Register → Verify email → Submit KYC → Admin review → Active
         → [Admin suspend with date] → Auto-reactive on expiry
         → [Admin ban] → Banned (terminal)
```

### Ad listing

```
Draft → Pending (admin queue) → Pending payment → Active
     → [Admin suspend + days] → Auto-reactive via cron (15 min)
     → [Subscription expires via cron (hourly)] → Inactive
     → [Subscription renewed / admin activates] → Active
```

### Subscription

```
Admin creates → Active (immediate) → Linked ad activated
→ [Expiry cron daily] → Expired → Linked ad deactivated
→ [Admin renews / creates new] → Active again
```

### Review

```
Subscriber submits → Admin queue → Admin approves
→ Model decides → Published (public) or Hidden
```

---

## Security Architecture

| Layer | Implementation |
|---|---|
| Transport | TLS 1.2/1.3 on all environments |
| KYC PII | AES-256-CBC via APP_KEY — name, DOB, ID number encrypted at rest |
| Identity documents | Private filesystem, served exclusively through gated PHP controller |
| Admin access | Separate DB table + guard + TOTP 2FA (Google Authenticator) |
| Role gating | `basic` / `full` / `superadmin` — PII decryption requires `full`+ |
| Forms | CSRF on all endpoints (Telegram webhook explicitly excluded) |
| Brute force | Rate limiting: 5 login attempts; 60 req/min API |
| HTTP headers | HSTS, X-Frame-Options, X-Content-Type-Options, X-XSS-Protection (Nginx) |
| Audit trail | Immutable `audit_logs` — actor, action, subject, old/new values, IP |
| GDPR | Explicit consent + age verification timestamps on registration |
| Sensitive files | `.env`, `.git` blocked at Nginx level |
| Secrets | All tokens and keys stored exclusively in `.env`; no secrets in codebase |

---

## Repository Structure

This public repository exposes the presentational and schema layers of the platform:

```
companionsgroup/
├── database/
│   └── migrations/           ← Full DB schema — 35+ tables
├── public/
│   └── landing/              ← Static landing (country selector + age gate)
├── resources/
│   └── views/
│       ├── pages/            ← Home, profiles, search, FAQ, legal pages
│       ├── components/       ← Reusable public UI components
│       ├── layouts/          ← Public + admin layouts with SEO meta stack
│       └── errors/           ← 403, 404, 500
└── routes/
    └── web.php               ← Public route definitions
```

The full business logic layer is maintained in private per-brand repositories:
admin panel, KYC wizard, Livewire components, model & subscriber dashboards, application services, payment integrations.

---

## Production Status

| Feature | Status |
|---|---|
| Authentication + email verification | ✅ Live |
| KYC identity verification (wizard + admin) | ✅ Live |
| Model ad management (7-tab editor) | ✅ Live |
| Public profiles + lightbox gallery | ✅ Live |
| Advanced search engine (15+ filters) | ✅ Live |
| Featured model placement algorithm | ✅ Live |
| Double-moderated review system | ✅ Live |
| Subscription plans + payment flow | ✅ Live |
| Email notifications (Postfix/Brevo) | ✅ Live |
| Telegram bot notifications + account linking | ✅ Live |
| Full admin panel | ✅ Live |
| No-code content management (FAQ, T&C, Privacy) | ✅ Live |
| Dynamic Design Theme System (270+ tokens, fullpage editor) | ✅ Live |
| Admin sortable tables (users, KYC, ads, subscriptions) | ✅ Live |
| Plan + subscription management (admin CRUD) | ✅ Live |
| Integration settings + Telegram test panel | ✅ Live |
| Contact history tracking | ✅ Live |
| Delinquency dashboard | ✅ Live |
| Auto-expiry cron (subscriptions hourly + suspensions 15 min) | ✅ Live |
| Automated daily DB + file backups | ✅ Live |
| Technical SEO (meta, OG, structured data) | ✅ Live |
| PWA (manifest + service worker) | ✅ Live |
| GDPR cookie consent banner | ✅ Live |
| MercadoPago webhook (auto-activation) | ✅ Live |
| CI/CD pipeline (GitHub Actions) | 📋 Planned |

---

## Contact

This is a proprietary commercial platform. The full codebase is not open source.

For licensing inquiries, technical partnerships, or investment:

**groupcompanions.arg@gmail.com**

---

## License

**Proprietary — All Rights Reserved**

This repository is made public for portfolio and presentation purposes only.
Unauthorized copying, modification, distribution, or commercial use of any part
of this codebase is strictly prohibited without explicit written permission.

© 2026 Companions Group. All rights reserved.

---

*Built with ❤️ in Argentina · Laravel 11 · PHP 8.2 · Livewire · Tailwind CSS · Redis · MariaDB*
