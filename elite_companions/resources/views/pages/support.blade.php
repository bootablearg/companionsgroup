@extends('layouts.app')
@section('title', 'Soporte — Elite Companions Argentina')
@section('meta_description', 'Centro de soporte de Elite Companions. Contactanos por WhatsApp o Telegram para resolver cualquier consulta sobre la plataforma.')
@section('canonical', 'https://elitecompanions.cc/soporte')
@section('content')

<div style="background:#F7F5FF;min-height:70vh;padding:60px 16px;">
<div style="max-width:680px;margin:0 auto;">

    {{-- Header --}}
    <div style="text-align:center;margin-bottom:40px;">
        <div style="display:inline-flex;align-items:center;gap:8px;background:#EDE9FE;border:1px solid #DDD6FE;border-radius:999px;padding:5px 16px;font-size:12px;font-weight:600;color:#6D28D9;letter-spacing:.04em;margin-bottom:16px;">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            Centro de Ayuda
        </div>
        <h1 style="font-size:36px;font-weight:800;letter-spacing:-.5px;background:linear-gradient(135deg,#7C3AED,#EC4899,#F472B6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1.15;margin:0 0 12px;">
            ¿En qué podemos ayudarte?
        </h1>
        <p style="font-size:15px;color:#6B7280;max-width:440px;margin:0 auto;line-height:1.6;">
            Nuestro equipo está disponible para asistirte con cualquier consulta o inconveniente.
        </p>
    </div>

    {{-- Contact card --}}
    <div style="background:#fff;border:1px solid #EDE9FE;border-radius:20px;padding:32px;margin-bottom:20px;box-shadow:0 4px 24px rgba(124,58,237,.07);">

        <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
            <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#7C3AED,#EC4899);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(124,58,237,.3);">
                <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 style="font-size:18px;font-weight:700;color:#111827;margin:0 0 3px;">Contactanos</h2>
                <p style="font-size:13px;color:#6B7280;margin:0;">Respondemos dentro de las 24 hs hábiles</p>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

            {{-- Email --}}
            <div style="background:#F7F5FF;border:1px solid #EDE9FE;border-radius:14px;padding:18px 20px;">
                <div style="font-size:11px;font-weight:700;color:#A78BFA;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;">Correo electrónico</div>
                <a href="mailto:elitecompanions.arg@gmail.com"
                   style="font-size:14px;font-weight:600;color:#7C3AED;text-decoration:none;word-break:break-all;">
                    elitecompanions.arg@gmail.com
                </a>
                <p style="font-size:12px;color:#9CA3AF;margin:6px 0 0;">Consultas generales y soporte</p>
            </div>

            {{-- Horario --}}
            <div style="background:#F7F5FF;border:1px solid #EDE9FE;border-radius:14px;padding:18px 20px;">
                <div style="font-size:11px;font-weight:700;color:#A78BFA;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;">Horario de atención</div>
                <div style="font-size:14px;font-weight:600;color:#111827;">Lun — Vie</div>
                <div style="font-size:13px;color:#6B7280;margin-top:3px;">9:00 – 18:00 hs (ARG)</div>
            </div>
        </div>

        <a href="mailto:elitecompanions.arg@gmail.com"
           style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:20px;width:100%;padding:13px;background:linear-gradient(135deg,#7C3AED,#EC4899);color:#fff;border-radius:12px;font-size:14px;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(124,58,237,.3);transition:opacity .15s;"
           onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Enviar un mensaje
        </a>
    </div>

    {{-- FAQ card --}}
    <div style="background:#fff;border:1px solid #EDE9FE;border-radius:20px;padding:28px 32px;box-shadow:0 4px 24px rgba(124,58,237,.07);">
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
            <div style="width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#7C3AED,#EC4899);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(124,58,237,.3);">
                <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 style="font-size:18px;font-weight:700;color:#111827;margin:0 0 3px;">Preguntas frecuentes</h2>
                <p style="font-size:13px;color:#6B7280;margin:0;">Respuestas rápidas a las consultas más comunes</p>
            </div>
        </div>
        <p style="font-size:14px;color:#6B7280;margin:0 0 16px;line-height:1.6;">
            Antes de contactarnos, revisá nuestra sección de FAQ donde encontrarás respuestas a las preguntas más frecuentes sobre el uso de la plataforma.
        </p>
        <a href="{{ route('faq') }}"
           style="display:inline-flex;align-items:center;gap:7px;padding:10px 20px;background:#F5F3FF;border:1px solid #DDD6FE;color:#7C3AED;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;transition:background .15s;"
           onmouseover="this.style.background='#EDE9FE'" onmouseout="this.style.background='#F5F3FF'">
            Ver preguntas frecuentes
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

</div>
</div>

@endsection
