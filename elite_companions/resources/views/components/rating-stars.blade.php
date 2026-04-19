@props([
    'rating' => 0,
    'size' => 'h-4 w-4',
    'label' => 'Valoración',
])

@php
    $clamped = max(0, min(5, (float) $rating));
@endphp

<div class="inline-flex items-center gap-1" role="img" aria-label="{{ $label }} {{ number_format($clamped, 1) }} de 5">
    @for ($i = 1; $i <= 5; $i++)
        @php
            $isFull = $clamped >= $i;
            $isPartial = $clamped >= ($i - 0.5) && $clamped < $i;
        @endphp
        <svg
            viewBox="0 0 20 20"
            fill="currentColor"
            class="{{ $size }} {{ $isFull ? 'text-rose-400' : ($isPartial ? 'text-rose-400/60' : 'text-gray-700') }}"
        >
            <path fill-rule="evenodd" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.163c.969 0 1.371 1.24.588 1.81l-3.376 2.455a1 1 0 00-.364 1.118l1.29 3.977c.3.924-.755 1.688-1.54 1.118l-3.378-2.453a1 1 0 00-1.175 0l-3.378 2.453c-.784.57-1.84-.194-1.54-1.118l1.29-3.977a1 1 0 00-.364-1.118L2.018 9.383c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.957z" clip-rule="evenodd"></path>
        </svg>
    @endfor
</div>
