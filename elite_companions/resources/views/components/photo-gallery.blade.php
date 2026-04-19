@props(['photos', 'videos' => collect()])
<div x-data="{ active: 0, lightbox: false }" class="space-y-3">
    {{-- Main image --}}
    @if($photos->count())
        <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-gray-900 cursor-zoom-in relative"
             @click="lightbox = true">
            @foreach($photos as $i => $photo)
                <img x-show="active === {{ $i }}"
                     src="{{ Storage::url($photo->file_path) }}"
                     class="w-full h-full object-cover"
                     alt="Foto {{ $i + 1 }}"
                     @if($i > 0) style="display:none" @endif>
            @endforeach
            <div class="absolute bottom-3 right-3 bg-black/60 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">
                <span x-text="active + 1"></span> / {{ $photos->count() }}
            </div>
        </div>

        {{-- Thumbnails --}}
        @if($photos->count() > 1)
            <div class="grid grid-cols-{{ min($photos->count(), 5) }} gap-2">
                @foreach($photos as $i => $photo)
                    <button @click="active = {{ $i }}"
                            :class="{{ $i }} === active ? 'ring-2 ring-rose-500 opacity-100' : 'opacity-60 hover:opacity-100'"
                            class="aspect-square rounded-lg overflow-hidden transition-all">
                        <img src="{{ Storage::url($photo->file_path) }}"
                             class="w-full h-full object-cover"
                             loading="lazy"
                             alt="Miniatura {{ $i + 1 }}">
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Lightbox --}}
        <div x-show="lightbox" x-cloak style="display:none"
             class="fixed inset-0 bg-black/95 z-50 flex items-center justify-center"
             @click.self="lightbox = false"
             @keydown.escape.window="lightbox = false">
            <button @click="lightbox = false"
                    class="absolute top-5 right-5 text-white/60 hover:text-white z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            @foreach($photos as $i => $photo)
                <img x-show="active === {{ $i }}"
                     src="{{ Storage::url($photo->file_path) }}"
                     class="max-h-[90vh] max-w-[90vw] object-contain rounded-xl"
                     alt="Foto {{ $i + 1 }}"
                     @if($i > 0) style="display:none" @endif>
            @endforeach
            @if($photos->count() > 1)
                <button @click="active = (active - 1 + {{ $photos->count() }}) % {{ $photos->count() }}"
                        class="absolute left-5 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/80 text-white p-3 rounded-full backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="active = (active + 1) % {{ $photos->count() }}"
                        class="absolute right-5 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/80 text-white p-3 rounded-full backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            @endif
        </div>
    @else
        <div class="aspect-[4/3] rounded-2xl bg-gray-900 border border-gray-800 flex items-center justify-center">
            <svg class="w-20 h-20 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
            </svg>
        </div>
    @endif

    {{-- Videos section --}}
    @if($videos->count())
        <div class="pt-2">
            <h4 class="text-sm font-semibold text-gray-400 mb-3">Videos ({{ $videos->count() }})</h4>
            <div class="grid grid-cols-{{ min($videos->count(), 3) }} gap-3">
                @foreach($videos as $video)
                    <video controls class="rounded-xl border border-gray-700 w-full" preload="metadata">
                        <source src="{{ Storage::url($video->file_path) }}">
                        Tu navegador no soporta la reproducción de video.
                    </video>
                @endforeach
            </div>
        </div>
    @endif
</div>
