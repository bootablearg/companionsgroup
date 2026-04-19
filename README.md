<div align="center">

# Companions Group

### Dual-brand adult companionship platform — Argentina

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Redis](https://img.shields.io/badge/Redis-7.x-DC382D?style=for-the-badge&logo=redis&logoColor=white)](https://redis.io)
[![MariaDB](https://img.shields.io/badge/MariaDB-10.11-003545?style=for-the-badge&logo=mariadb&logoColor=white)](https://mariadb.org)

**[🌐 Elite Companions](https://argentina.elitecompanions.cc)** · **[🌐 VIP Companions](https://argentina.vipcompanions.cc)**

</div>

---

## 📌 Overview

**Companions Group** is a production-grade, dual-brand B2C platform for verified adult companionship advertising in Argentina. Two independent brands run on the same codebase, each targeting a different market segment and SEO keyword space to eliminate cannibalization.

| Brand | Domain | Live URL | Positioning | Color |
|-------|--------|----------|-------------|-------|
| 🌟 Elite Companions | `elitecompanions.cc` | [argentina.elitecompanions.cc](https://argentina.elitecompanions.cc) | Premium, exclusive, high-profile | Violet `#7C3AED` |
| 💎 VIP Companions | `vipcompanions.cc` | [argentina.vipcompanions.cc](https://argentina.vipcompanions.cc) | Variety, social, diverse | Gold `#C8A235` |

Both platforms are live in production, serving real users.

---

## ✨ Feature Set

### For Models (supply side)
- 📋 **Multi-step KYC wizard** — Document upload + selfie verification with AES-256-CBC encrypted PII storage. Every model is a real, verified person.
- 📝 **Full ad management** — 7-tab self-service editor: basic info, appearance, languages, services, rates, availability schedule, and media.
- 📸 **Media gallery** — Up to 10 photos with drag & drop reordering, automatic watermarking, and up to 3 embedded video URLs (YouTube/Vimeo).
- 💳 **Subscription management** — Monthly and quarterly plans with bank transfer payment + digital receipt upload.
- 🔔 **Multi-channel notifications** — In-app bell, transactional email (Postfix/Brevo SMTP relay), and Telegram bot with one-click account linking.
- 🔒 **Privacy controls** — Per-channel visibility toggles (WhatsApp, Telegram, email, phone). Real name and ID never exposed publicly.

### For Subscribers (demand side)
- 🔍 **Advanced search engine** — 15+ simultaneous filters: location, service types, physical attributes (height, weight, measurements, eye/hair color), price range, language, habits.
- ⭐ **Featured placement algorithm** — Subscribed "featured" models surface before standard listings across all search queries.
- ❤️ **Favorites** — Save and revisit preferred profiles across sessions.
- 💬 **Double-moderated review system** — 1–5 star ratings + text comments. Admin approves first, then model decides to publish or hide.
- 📊 **Contact history** — Automatic tracking of interactions (WhatsApp taps, Telegram opens, email clicks, phone reveals) per model.

### For Platform Operators (admin panel)
- 🛡 **KYC review queue** — Inline document lightbox (front ID, back ID, selfie, selfie-with-doc). Approve or reject with reason. PII decryption gated to `full`/`superadmin` roles.
- 📢 **Full ad moderation** — Approve, reject (with reason), suspend temporarily (date picker + quick buttons: 1/3/7/14/30 days), auto-reactive on expiry.
- 💰 **Payment processing** — Receipt review, manual activation, full payment history per user.
- 📉 **Delinquency dashboard** — Models with expired subscriptions listed by days overdue and accumulated amount.
- 📝 **No-code content management** — FAQ (segmented by role), Terms & Conditions, Privacy Policy — all editable from admin UI without touching code.
- 🗂 **Service catalog** — Full CRUD + active toggle + drag & drop reorder for 40+ service types.
- 🔑 **2FA TOTP** — Google Authenticator enforced for all admin sessions, per-login.
- 📋 **Immutable audit log** — Every admin action recorded with actor, timestamp, IP, and before/after values.

---

## 🏗 Architecture

### Tech Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| Backend framework | Laravel | 11.x |
| Language | PHP | 8.2 |
| Reactive frontend | Blade + Livewire + Alpine.js | 3.x |
| CSS / Build | Tailwind CSS + Vite | 3.4 / 5.x |
| Database | MariaDB (InnoDB, utf8mb4) | 10.11 |
| Cache / Sessions / Queue | Redis | 7.x |
| Web auth | Laravel session + bcrypt | — |
| Admin auth | Separate guard + TOTP 2FA | — |
| REST API auth | JWT (PHPOpenSourceSaver) | 2.0 |
| Identity encryption | AES-256-CBC via Laravel Crypt | — |
| Payments | MercadoPago SDK | 3.x |
| Email | Postfix relay → Brevo SMTP | — |
| Push notifications | Telegram Bot API | — |
| Image processing | Intervention Image (watermarking) | 3.x |
| Server | Nginx + PHP-FPM 8.2, Debian bare metal | — |

### Six Isolated Environments

```
/var/www/companions/
├── elite_companions/
│   ├── dev/www    →  dev.elitecompanions.cc         DB: elite_companions_dev
│   ├── qa/www     →  qa.elitecompanions.cc          DB: elite_companions_qa
│   └── prod/www   →  argentina.elitecompanions.cc   DB: elite_companions_prod_arg
│
└── vip_companions/
    ├── dev/www    →  dev.vipcompanions.cc            DB: vip_companions_dev
    ├── qa/www     →  qa.vipcompanions.cc             DB: vip_companions_qa
    └── prod/www   →  argentina.vipcompanions.cc      DB: vip_companions_prod_arg
```

Every change flows strictly `DEV → QA → PROD`. Each environment has its own `.env`, isolated Redis DB slots, and independent PHP-FPM pools. Both brands share one server — isolated at the application layer.

### Data Model (33+ tables)

```
users ──< escort_profiles ──< avisos ──< aviso_photos
               │                    └──< aviso_videos
               ├──< escort_rates
               ├──< escort_services >── service_types
               ├──< escort_languages
               └──< weekly_schedules

users ──< kyc_submissions ──────────── admin_users (reviewed_by)
users ──< subscriptions  >──────────── subscription_plans
users ──< payments
users ──< reviews        ──────────── escort_profiles
users ──< favorites      ──────────── avisos
users ──< contact_events ──────────── escort_profiles

admin_users ──< audit_logs
            ──< moderation_actions
```

All tables: InnoDB engine, utf8mb4_unicode_ci, full FK indexing.

### Key Lifecycles

**Model account:**
```
Register → Verify email → Submit KYC → Admin review → Active
         → [Admin suspend with date] → Auto-reactive on expiry
         → [Admin ban] → Banned (terminal)
```

**Ad listing:**
```
Draft → Pending (admin queue) → Pending payment → Active
     → [Admin suspend + days] → Auto-reactive via cron (15 min)
     → [Subscription expires via cron (hourly)] → Inactive
```

**Review:**
```
Subscriber submits → Admin queue → Admin approves
→ Model decides → Published (public) or Hidden
```

### Security Architecture

| Layer | Measure |
|-------|---------|
| Transport | TLS 1.2/1.3 on all 6 environments |
| KYC PII | AES-256-CBC via `APP_KEY` — name, DOB, ID number encrypted at rest |
| Identity documents | Private filesystem storage, served exclusively through gated PHP controller |
| Admin access | Separate DB table + guard + TOTP 2FA (Google Authenticator) |
| Role gating | `basic` / `full` / `superadmin` — PII decryption requires `full`+ |
| Forms | CSRF on all endpoints (Telegram webhook explicitly excluded) |
| Brute force | Rate limiting: 5 login attempts; 60 req/min API |
| HTTP headers | HSTS, X-Frame-Options, CSP (Nginx) + nosniff, Referrer-Policy (middleware) |
| Audit trail | Immutable `audit_logs` — actor, action, subject, old/new values, IP |
| GDPR | Explicit consent + age verification timestamps on registration |
| Sensitive files | `.env`, `.git` blocked at Nginx level |

---

## 📂 Repository Structure

This public repository exposes only the **presentational layer** of both brands:

```
companionsgroup/
├── elite_companions/
│   ├── database/migrations/          ← Full DB schema — 33+ tables
│   ├── public/landing/               ← Static landing (country selector + age gate)
│   ├── resources/views/
│   │   ├── pages/                    ← Home, profiles, search, FAQ, legal pages
│   │   ├── components/               ← Reusable public UI components
│   │   ├── layouts/app.blade.php     ← Public layout with SEO meta stack
│   │   └── errors/                   ← 403, 404, 500
│   └── routes/web.php                ← Public route definitions
│
└── vip_companions/
    └── (mirrors elite_companions structure — gold branding)
```

> **The full business logic layer is maintained in private branches** (per-brand repositories):  
> admin panel, KYC wizard, Livewire components, model & subscriber dashboards, application services.

---

## 📊 Production Status

| Module | Status |
|--------|--------|
| Authentication + email verification | ✅ Live |
| KYC identity verification (wizard + admin) | ✅ Live |
| Model ad management (7-tab editor) | ✅ Live |
| Public profiles + lightbox gallery | ✅ Live |
| Advanced search engine (15+ filters) | ✅ Live |
| Featured model placement algorithm | ✅ Live |
| Double-moderated review system | ✅ Live |
| Subscription plans + payment flow | ✅ Live |
| Email notifications (Postfix/Brevo) | ✅ Live |
| Telegram bot notifications | ✅ Live |
| Full admin panel | ✅ Live |
| No-code content management (FAQ, T&C) | ✅ Live |
| Technical SEO (meta, OG, JSON-LD, sitemap) | ✅ Live |
| PWA (manifest + service worker) | ✅ Live |
| GDPR cookie consent banner | ✅ Live |
| Automated daily DB + file backups | ✅ Live |
| Auto-expiry cron (subscriptions + suspensions) | ✅ Live |
| Contact history tracking | ✅ Live |
| MercadoPago webhook (auto-activation) | 🔄 In progress |
| CI/CD pipeline (GitHub Actions) | 📋 Planned |

---

## 📬 Contact

This is a **proprietary commercial platform**. The full codebase is not open source.

For licensing inquiries, technical partnerships, or investment:

- 📧 Elite Companions: [elitecompanions.arg@gmail.com](mailto:elitecompanions.arg@gmail.com)
- 📧 VIP Companions: [vipcompanions.arg@gmail.com](mailto:vipcompanions.arg@gmail.com)

---

## 📄 License

**Proprietary — All Rights Reserved**

This repository is made public for portfolio and presentation purposes only.  
Unauthorized copying, modification, distribution, or commercial use of any part  
of this codebase is strictly prohibited without explicit written permission.

© 2026 Companions Group (Elite Companions · VIP Companions). All rights reserved.

---

<div align="center">

Built with ❤️ in Argentina · Laravel 11 · PHP 8.2 · Livewire · Tailwind CSS · Redis · MariaDB

</div>
