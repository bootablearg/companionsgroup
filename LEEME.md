# Companions Group

**Plataforma B2C de acompañantes adultos verificados — marketplace de escorts — Argentina**

[![Laravel 11](https://img.shields.io/badge/Laravel-11.x-red?logo=laravel)](https://laravel.com)
[![PHP 8.2](https://img.shields.io/badge/PHP-8.2-blue?logo=php)](https://php.net)
[![Livewire 3.x](https://img.shields.io/badge/Livewire-3.x-pink)](https://livewire.laravel.com)
[![Tailwind CSS 3.4](https://img.shields.io/badge/Tailwind-3.4-38bdf8?logo=tailwindcss)](https://tailwindcss.com)
[![Redis 7.x](https://img.shields.io/badge/Redis-7.x-red?logo=redis)](https://redis.io)
[![MariaDB 10.11](https://img.shields.io/badge/MariaDB-10.11-blue?logo=mariadb)](https://mariadb.org)

---

## Descripción general

Companions Group es una plataforma B2C de nivel productivo para publicidad de acompañantes adultos verificados. El mismo código fuente impulsa múltiples despliegues de marca, cada uno con su propia identidad visual, dominio y capa de datos aislada — todos compartiendo un núcleo de aplicación único y mantenido.

---

## Funcionalidades

### Para Modelos (lado de la oferta)

- **Wizard KYC multipaso** — Carga de documentos + verificación por selfie con almacenamiento encriptado AES-256-CBC de datos personales. Cada modelo es una persona real y verificada.
- **Gestión completa de avisos** — Editor de autoservicio con 7 pestañas: información básica, apariencia, idiomas, servicios, tarifas, horarios de disponibilidad y multimedia.
- **Galería multimedia** — Fotos con reordenamiento drag & drop, designación de foto de portada, marca de agua automática, URLs de video embebidas (YouTube/Vimeo/otros) y carga directa de videos.
- **Gestión de suscripciones** — Permite crear distintos tipos de planes por tiempo y costo; las modelos hacen seguimiento de su plan activo, fechas de facturación y estado de renovación desde su dashboard.
- **Notificaciones multicanal** — Campanilla de notificaciones en la app, email transaccional (relay Postfix/Brevo SMTP) y bot de Telegram con vinculación de cuenta en un clic desde el dashboard.
- **Controles de privacidad** — Toggles de visibilidad por canal (WhatsApp, Telegram, email, teléfono, TikTok, Instagram, OnlyFans). El nombre real y el DNI nunca se exponen públicamente.
- **Perfil completo** — Página de perfil separada con selectores de ubicación en cascada (país → provincia → ciudad → barrio); todos los cambios se reflejan de inmediato en los listados públicos.
- **Visibilidad de contacto** — Las modelos eligen qué canales de contacto aparecen en su aviso público mediante toggles individuales por canal.

### Para Suscriptores (lado de la demanda)

- **Motor de búsqueda avanzada** — Más de 15 filtros simultáneos: ubicación (barrio, ciudad, provincia), tipos de servicio, atributos físicos (altura, peso, medidas, color de ojos/cabello), rango de precios, idioma, hábitos y estado de verificación.
- **Algoritmo de posicionamiento destacado** — Las modelos con suscripción "destacada" aparecen antes que los listados estándar en todas las búsquedas, así como al enviar reseñas.
- **Favoritos** — Guardá y revisitá perfiles preferidos entre sesiones.
- **Sistema de reseñas con doble moderación** — Calificaciones de 1 a 5 estrellas + comentarios de texto. El admin aprueba primero; luego la modelo decide si publicar u ocultar la reseña.
- **Historial de contactos** — Registro automático de todas las interacciones (toques en WhatsApp, aperturas de Telegram, clics en email, revelaciones de teléfono) por modelo, con log de eventos con timestamp.
- **Resultados de búsqueda ordenados** — Opciones de ordenamiento por más recientes, destacadas primero o por relevancia.

### Para Operadores de Plataforma (panel de administración)

- **Cola de revisión KYC** — Lightbox de documentos inline (DNI frente, DNI dorso, selfie, selfie con documento). Aprobar o rechazar con motivo. Desencriptado de datos personales restringido a roles `full` / `superadmin`.
- **Moderación completa de avisos** — Aprobar, rechazar (con motivo), suspender temporalmente (selector de fecha + botones rápidos: 1/3/7/14/30 días), reactivación automática al vencer. Ordenable por modelo, título, estado o fecha de publicación.
- **Gestión de suscripciones** — CRUD de ciclo de vida completo: crear suscripciones para avisos específicos, asignar plan + duración, activar, cancelar o eliminar. Activación del aviso vinculado al crear/actualizar la suscripción. Ordenable por ID, plan, estado, fecha de inicio y fin.
- **Catálogo de planes** — CRUD completo para planes de suscripción: nombre, precio, duración, feature flags, orden.
- **Procesamiento de pagos** — Revisión de comprobantes, activación manual, historial completo de pagos por usuario.
- **Dashboard de mora** — Modelos con suscripciones vencidas listadas por días de atraso e importe acumulado.
- **Sistema de temas visuales dinámico** — Personalización visual sin código: más de 270 tokens de diseño CSS, editor fullpage con 3 pestañas (Colores, Tipografía, Personalizados), múltiples temas por marca con vista previa en vivo. Cero colores hardcodeados — toda la UI se adapta desde variables CSS gestionadas en base de datos.
- **Gestión de contenido sin código** — FAQ (segmentada por rol), Términos y Condiciones, Política de Privacidad — todo editable desde la UI de administración sin tocar código.
- **Gestión de plantillas de email** — Todas las plantillas de notificaciones transaccionales editables desde el panel de administración.
- **Catálogo de servicios** — CRUD completo + toggle de activación + reordenamiento drag & drop para más de 40 tipos de servicio.
- **Gestión de usuarios admin** — Crear, editar, activar/desactivar cuentas de administrador con asignación de rol (basic / full / superadmin). Ordenable por ID, estado y último login.
- **Configuración de integraciones** — Configuración del token del bot de Telegram con panel de prueba en vivo (enviar mensaje de prueba al admin o canal directamente desde la UI).
- **Tablas ordenables en todo el admin** — Todas las tablas principales del panel (usuarios, KYC, cuentas admin, avisos, suscripciones) soportan ordenamiento multicolumna con indicadores direccionales, persistido entre páginas.
- **2FA TOTP** — Google Authenticator obligatorio para todas las sesiones de administración, por login.
- **Log de auditoría inmutable** — Cada acción de administración registrada con actor, timestamp, IP y valores antes/después.

---

## Arquitectura

### Stack tecnológico

| Capa | Tecnología |
|---|---|
| Framework backend | Laravel 11.x |
| Lenguaje | PHP 8.2 |
| Frontend reactivo | Blade + Livewire + Alpine.js 3.x |
| CSS / Build | Tailwind CSS 3.4 + Vite 5.x |
| Base de datos | MariaDB 10.11 (InnoDB, utf8mb4) |
| Cache / Sesiones / Queue | Redis 7.x |
| Autenticación web | Laravel session + bcrypt |
| Autenticación admin | Tabla DB + guard separados + TOTP 2FA |
| Autenticación API REST | JWT (PHPOpenSourceSaver) 2.0 |
| Encriptación de identidad | AES-256-CBC vía Laravel `Crypt` (APP_KEY) |
| Pagos | MercadoPago SDK 3.x |
| Email | Relay Postfix → Brevo SMTP |
| Notificaciones push | Telegram Bot API |
| Procesamiento de imágenes | Intervention Image 3.x (marca de agua) |
| Servidor | Nginx + PHP-FPM 8.2, Debian bare metal |

### Tres ambientes aislados

```
companions/
├── dev/www    →  dev.dominio.cc           DB: companions_dev    Redis: project=N, env=1
├── qa/www     →  qa.dominio.cc            DB: companions_qa     Redis: project=N, env=2
└── prod/www   →  pais.dominio.cc          DB: companions_prod   Redis: project=N, env=3
```

Todo cambio fluye estrictamente **DEV → QA → PROD**. Cada ambiente tiene su propio `.env`, slots Redis aislados (matriz proyecto × ambiente) y pools PHP-FPM independientes. Múltiples despliegues de marca comparten un servidor — aislados a nivel de capa de aplicación.

### Sistema de temas de diseño

La plataforma ejecuta un motor de temas visuales gestionado desde base de datos. En cada request HTTP, el middleware `LoadActiveTheme` obtiene el tema activo (con cache de 24h vía `ThemeService`) e inyecta ~270 propiedades CSS personalizadas en `:root {}`. Todas las vistas referencian únicamente `var(--nombre-token)` — cero colores hardcodeados en todo el código fuente.

---

## Modelo de datos (35+ tablas)

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

design_themes ──< token_definitions    ← sistema de temas visuales
site_settings                          ← configuración de la plataforma
email_templates                        ← plantillas de notificaciones
faqs                                   ← contenido FAQ segmentado por rol
provinces >── countries                ← geografía
pages                                  ← T&C, Política de Privacidad
```

Todas las tablas: motor InnoDB, `utf8mb4_unicode_ci`, indexación FK completa.

---

## Ciclos de vida principales

### Cuenta de modelo

```
Registro → Verificar email → Enviar KYC → Revisión admin → Activa
         → [Admin suspende con fecha] → Reactivación automática al vencer
         → [Admin banea] → Baneada (estado terminal)
```

### Aviso publicitario

```
Borrador → Pendiente (cola admin) → Pendiente de pago → Activo
        → [Admin suspende + días] → Reactivación automática vía cron (15 min)
        → [Suscripción vence vía cron (cada hora)] → Inactivo
        → [Suscripción renovada / admin activa] → Activo
```

### Suscripción

```
Admin crea → Activa (inmediata) → Aviso vinculado se activa
→ [Cron de vencimiento diario] → Vencida → Aviso vinculado se desactiva
→ [Admin renueva / crea nueva] → Activa nuevamente
```

### Reseña

```
Suscriptor envía → Cola de admin → Admin aprueba
→ Modelo decide → Publicada (pública) u Oculta
```

---

## Arquitectura de seguridad

| Capa | Implementación |
|---|---|
| Transporte | TLS 1.2/1.3 en todos los ambientes |
| Datos personales KYC | AES-256-CBC vía APP_KEY — nombre, fecha de nacimiento, número de documento encriptados en reposo |
| Documentos de identidad | Filesystem privado, servidos exclusivamente a través de controlador PHP con acceso controlado |
| Acceso admin | Tabla DB + guard separados + TOTP 2FA (Google Authenticator) |
| Control por rol | `basic` / `full` / `superadmin` — desencriptado de datos personales requiere `full`+ |
| Formularios | CSRF en todos los endpoints (webhook de Telegram explícitamente excluido) |
| Fuerza bruta | Rate limiting: 5 intentos de login; 60 req/min en API |
| Headers HTTP | HSTS, X-Frame-Options, X-Content-Type-Options, X-XSS-Protection (Nginx) |
| Trazabilidad | `audit_logs` inmutable — actor, acción, sujeto, valores antes/después, IP |
| RGPD | Timestamps de consentimiento explícito y verificación de edad en el registro |
| Archivos sensibles | `.env`, `.git` bloqueados a nivel Nginx |
| Secretos | Todos los tokens y claves almacenados exclusivamente en `.env`; sin secretos en el código fuente |

---

## Estructura del repositorio

Este repositorio público expone las capas de presentación y esquema de la plataforma:

```
companionsgroup/
├── database/
│   └── migrations/           ← Esquema completo de BD — 35+ tablas
├── public/
│   └── landing/              ← Landing estática (selector de país + verificación de edad)
├── resources/
│   └── views/
│       ├── pages/            ← Home, perfiles, búsqueda, FAQ, páginas legales
│       ├── components/       ← Componentes UI públicos reutilizables
│       ├── layouts/          ← Layouts públicos y admin con stack SEO
│       └── errors/           ← 403, 404, 500
└── routes/
    └── web.php               ← Definición de rutas públicas
```

La capa completa de lógica de negocio se mantiene en repositorios privados por marca: panel de administración, wizard KYC, componentes Livewire, dashboards de modelo y suscriptor, servicios de aplicación, integraciones de pago.

---

## Estado en producción

| Funcionalidad | Estado |
|---|---|
| Autenticación + verificación de email | ✅ Productivo |
| Verificación de identidad KYC (wizard + admin) | ✅ Productivo |
| Gestión de avisos del modelo (editor 7 pestañas) | ✅ Productivo |
| Perfiles públicos + galería lightbox | ✅ Productivo |
| Motor de búsqueda avanzada (15+ filtros) | ✅ Productivo |
| Algoritmo de posicionamiento destacado | ✅ Productivo |
| Sistema de reseñas con doble moderación | ✅ Productivo |
| Planes de suscripción + flujo de pago | ✅ Productivo |
| Notificaciones por email (Postfix/Brevo) | ✅ Productivo |
| Bot de Telegram + vinculación de cuenta | ✅ Productivo |
| Panel de administración completo | ✅ Productivo |
| Gestión de contenido sin código (FAQ, T&C, Privacidad) | ✅ Productivo |
| Sistema de temas de diseño dinámico (270+ tokens, editor fullpage) | ✅ Productivo |
| Tablas admin ordenables (usuarios, KYC, avisos, suscripciones) | ✅ Productivo |
| Gestión de planes y suscripciones (CRUD admin) | ✅ Productivo |
| Configuración de integraciones + panel de prueba Telegram | ✅ Productivo |
| Historial de contactos | ✅ Productivo |
| Dashboard de mora | ✅ Productivo |
| Cron de vencimiento automático (suscripciones cada hora + suspensiones cada 15 min) | ✅ Productivo |
| Backups automáticos diarios de DB + archivos | ✅ Productivo |
| SEO técnico (meta, OG, datos estructurados) | ✅ Productivo |
| PWA (manifest + service worker) | ✅ Productivo |
| Banner de consentimiento de cookies RGPD | ✅ Productivo |
| Webhook MercadoPago (verificación de firma + activación automática + recurrente) | ✅ Productivo |
| Pipeline CI/CD (GitHub Actions) | 📋 Planificado |

---

## Contacto

Esta es una plataforma comercial propietaria. El código fuente completo no es open source.

Para consultas de licenciamiento, asociaciones técnicas o inversión:

**groupcompanions.arg@gmail.com**

---

## Licencia

**Propietaria — Todos los derechos reservados**

Este repositorio es público únicamente con fines de portfolio y presentación.
Está estrictamente prohibida la copia, modificación, distribución o uso comercial no autorizado de cualquier parte de este código sin autorización escrita explícita.

© 2026 Companions Group. Todos los derechos reservados.

---

*Construido con ❤️ en Argentina · Laravel 11 · PHP 8.2 · Livewire · Tailwind CSS · Redis · MariaDB*
