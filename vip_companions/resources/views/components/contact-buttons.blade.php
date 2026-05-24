@props(['aviso'])

@php
    use Illuminate\Support\Str;
@endphp

@php
    $modelo = $aviso->escortProfile ?? null;
    $phone = $modelo?->contact_phone;
    $whatsapp = $modelo?->contact_whatsapp;
    $telegram = $modelo?->contact_telegram;

    $normalizePhone = fn($value) => $value ? preg_replace('/\D+/', '', $value) : null;
    $whatsappLink = $whatsapp ? 'https://wa.me/' . $normalizePhone($whatsapp) : null;
    $telegramLink = $telegram ? (str_starts_with($telegram, '@') ? 'https://t.me/' . ltrim($telegram, '@') : 'https://t.me/' . $telegram) : null;
    $hasContact = ($modelo?->show_phone && $phone) ||
                  ($modelo?->show_whatsapp && $whatsapp) ||
                  ($modelo?->show_telegram && $telegram);
@endphp

@if($modelo && $hasContact)
    <div class="bg-page-background border border-border-default rounded-lg p-5 space-y-3">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-400">Contacta directamente</h3>
        <p class="text-sm text-gray-500 leading-relaxed">
            Estas vía directa está disponible para visitantes verificados. Conservamos la privacidad de tus datos.
        </p>
        <div class="space-y-2">
            @if($modelo->show_phone && $phone)
                <a
                    href="tel:{{ $phone }}"
                    class="flex items-center justify-between gap-3 w-full border border-border-default bg-page-background hover:border-status-error-light-border rounded-xl px-4 py-3 text-sm text-text-primary transition-all"
                >
                    <span>Teléfono</span>
                    <span class="text-rose-400 font-semibold">{{ $phone }}</span>
                </a>
            @endif

            @if($modelo->show_whatsapp && $whatsapp && $whatsappLink)
                <a
                    href="{{ $whatsappLink }}"
                    target="_blank"
                    rel="noopener"
                    class="flex items-center justify-between gap-3 w-full border border-border-default bg-green-900/40 text-green-200 hover:border-green-500 rounded-xl px-4 py-3 text-sm font-semibold transition-all"
                >
                    <span>WhatsApp</span>
                    <span class="text-green-200">{{ $whatsapp }}</span>
                </a>
            @endif

            @if($modelo->show_telegram && $telegram && $telegramLink)
                <a
                    href="{{ $telegramLink }}"
                    target="_blank"
                    rel="noopener"
                    class="flex items-center justify-between gap-3 w-full border border-border-default bg-blue-800/40 text-blue-200 hover:border-blue-500 rounded-xl px-4 py-3 text-sm font-semibold transition-all"
                >
                    <span>Telegram</span>
                    <span class="text-blue-200">{{ Str::startsWith($telegram, '@') ? $telegram : "@{$telegram}" }}</span>
                </a>
            @endif
        </div>
        <p class="text-xs text-gray-500">Elite Companions protege la información personal y no revela datos sensibles sin consentimiento.</p>
    </div>
@endif
