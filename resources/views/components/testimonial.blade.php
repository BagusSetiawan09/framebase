@props(['testimonials', 'setting'])

<section id="testimonial" class="w-full bg-[#f8f9fa] py-24 sm:py-32 relative">
    
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-gray-200 rounded-full mix-blend-multiply filter blur-[100px] opacity-40"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-gray-300 rounded-full mix-blend-multiply filter blur-[100px] opacity-30"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-20 relative z-10">
        
        <div class="text-center max-w-3xl mx-auto mb-16 md:mb-20">
            <h2 class="text-4xl md:text-5xl font-medium text-gray-900 tracking-tight leading-tight">
                {!! $setting->testimonial_title ?? 'Apa kata mereka tentang <br class="hidden md:block" /> karya visual kami.' !!}
            </h2>
        </div>

        @if($testimonials->count() > 0)
            <div class="columns-1 md:columns-2 lg:columns-3 gap-6 md:gap-8">
                
                @foreach($testimonials as $testi)
                    @php
                        $avatarUrl = $testi->avatar 
                            ? asset('storage/' . $testi->avatar) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($testi->client_name) . '&background=random';
                    @endphp

                    @if($testi->type === 'company')
                        <div class="break-inside-avoid mb-6 md:mb-8 bg-[#141414] rounded-2xl p-8 md:p-10 shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <p class="text-white text-xs font-medium tracking-widest uppercase mb-6">{{ $testi->company_name }}</p>
                            <p class="text-white text-lg md:text-xl font-regular leading-relaxed mb-10">
                                "{{ $testi->quote }}"
                            </p>
                            <div class="flex items-center gap-4 mt-auto">
                                <img src="{{ $avatarUrl }}" alt="{{ $testi->client_name }}" class="w-11 h-11 rounded-full object-cover border border-gray-700">
                                <div>
                                    <h4 class="text-white font-medium text-sm">{{ $testi->client_name }}</h4>
                                    <p class="text-gray-400 text-xs">{{ $testi->role }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="break-inside-avoid mb-6 md:mb-8 bg-white/70 backdrop-blur-xl border border-white/80 rounded-2xl p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 hover:-translate-y-1">
                            <p class="text-gray-900 text-lg md:text-xl font-regular leading-relaxed mb-10">
                                "{{ $testi->quote }}"
                            </p>
                            <div class="flex items-center gap-4 mt-auto">
                                <img src="{{ $avatarUrl }}" alt="{{ $testi->client_name }}" class="w-11 h-11 rounded-full object-cover border border-gray-200">
                                <div>
                                    <h4 class="text-gray-900 font-medium text-sm">{{ $testi->client_name }}</h4>
                                    <p class="text-gray-500 text-xs">{{ $testi->role }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        @else
            <div class="w-full bg-white/60 backdrop-blur-md rounded-3xl p-12 md:p-20 text-center border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-medium text-gray-900 mb-3">Ulasan Belum Tersedia</h3>
                <p class="text-gray-500 max-w-lg mx-auto text-lg">Kami sedang mengumpulkan pengalaman terbaik dari klien kami. Ulasan dan testimoni karya visual kami akan segera ditampilkan di sini.</p>
            </div>
        @endif

    </div>
</section>