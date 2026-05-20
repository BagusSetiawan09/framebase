@props(['footer'])

@php
    $title = $footer->title ?? 'Frame Base';
    $description = $footer->description ?? 'Merekam setiap detik momen Anda menjadi cerita visual yang tak terlupakan.';
    $copyright = $footer->copyright ?? 'Frame Base. Hak Cipta Dilindungi.';
@endphp

<footer class="w-full bg-white pt-24 pb-12 border-t border-gray-100 overflow-hidden relative">
    <div class="w-full flex flex-col items-center">
        
        <div class="w-full flex justify-center select-none overflow-hidden px-4 md:px-8">
            <h1 class="font-bold tracking-tighter leading-none text-center whitespace-nowrap bg-clip-text text-transparent bg-gradient-to-b from-gray-800 via-gray-400 via-45% to-transparent to-70%" style="font-size: clamp(4rem, 16vw, 25rem);">
                {{ $title }}
            </h1>
        </div>

        <div class="w-full px-6 md:px-16 lg:px-[10vw] xl:px-[12vw] flex flex-col md:flex-row justify-between items-center md:items-end gap-8 relative z-10 -mt-2 sm:-mt-4 md:-mt-8 lg:-mt-12">
            
            <div class="text-gray-500 text-sm md:text-base max-w-md text-center md:text-left leading-relaxed">
                <p>{{ $description }}</p>
                <p class="mt-1">&copy; {{ date('Y') }} {{ $copyright }}</p>
            </div>

            <div class="flex items-center gap-4">
                
                @if($footer && $footer->instagram_url)
                <a href="{{ $footer->instagram_url }}" target="_blank" class="w-12 h-12 bg-[#141414] rounded-full flex items-center justify-center text-white hover:bg-[#E50914] hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-[#E50914]/30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                    </svg>
                </a>
                @endif

                @if($footer && $footer->whatsapp_url)
                <a href="{{ $footer->whatsapp_url }}" target="_blank" class="w-12 h-12 bg-[#141414] rounded-full flex items-center justify-center text-white hover:bg-[#E50914] hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-[#E50914]/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </a>
                @endif

                @if($footer && $footer->tiktok_url)
                <a href="{{ $footer->tiktok_url }}" target="_blank" class="w-12 h-12 bg-[#141414] rounded-full flex items-center justify-center text-white hover:bg-[#E50914] hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-[#E50914]/30">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 448 512"><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/></svg>
                </a>
                @endif
                
                @if($footer && $footer->email)
                <a href="mailto:{{ $footer->email }}" class="w-12 h-12 bg-[#141414] rounded-full flex items-center justify-center text-white hover:bg-[#E50914] hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-[#E50914]/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </a>
                @endif

            </div>
        </div>
    </div>
</footer>