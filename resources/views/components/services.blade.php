@props(['services', 'setting'])

<section id="order" class="w-full bg-white py-24 sm:py-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-20 text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-medium text-gray-900 tracking-tight">{{ $setting->services_title ?? 'Layanan & Paket' }}</h2>
        <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">{{ $setting->services_subtitle ?? 'Pilih paket dokumentasi yang paling sesuai dengan kebutuhan visual Anda. Geser untuk melihat selengkapnya.' }}</p>
    </div>

    <div class="flex items-start overflow-x-auto snap-x snap-mandatory gap-6 md:gap-8 px-6 sm:px-10 lg:px-20 pt-10 pb-16 hide-scrollbar">
        
        @forelse($services as $service)
        <div class="snap-center shrink-0 w-[85vw] sm:w-[380px] bg-[#141414] rounded-[2rem] p-8 md:p-10 flex flex-col shadow-xl transition-all duration-500 hover:-translate-y-4 hover:shadow-2xl">
            
            <div class="flex-none">
                <p class="text-gray-500 text-xs font-semibold tracking-widest uppercase mb-4">Paket Visual</p>
                <h3 class="text-2xl md:text-[1.75rem] font-medium text-white mb-6 leading-normal line-clamp-3 min-h-[5rem]" title="{{ $service->name }}">
                    {{ $service->name }}
                </h3>
                
                <div class="mb-8">
                    <span class="text-2xl font-semibold text-white tracking-tight">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                </div>
                
                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20memesan%20paket%20{{ urlencode($service->name) }}" target="_blank" class="block w-full py-4 rounded-xl bg-[#E50914] hover:bg-red-700 text-white font-medium text-sm text-center transition-all duration-300 mb-8 shadow-lg shadow-red-500/20">
                    Pesan Sekarang
                </a>
            </div>
            
            <div x-data="{ expanded: false }" class="border-t border-gray-800 pt-8 mt-auto flex flex-col flex-grow">
                
                @if(is_array($service->deliverables) && count($service->deliverables) > 0)
                    <ul class="space-y-4 text-gray-400 text-sm">
                        @foreach($service->deliverables as $index => $item)
                            <li class="flex items-start gap-4" 
                                @if($index >= 3) 
                                    x-show="expanded" 
                                    x-transition.opacity.duration.300ms
                                    x-cloak
                                @endif
                            >
                                <svg class="w-5 h-5 text-gray-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="leading-relaxed">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>

                    @if(count($service->deliverables) > 3)
                        <button @click="expanded = !expanded" class="mt-auto pt-8 w-full flex items-center justify-between text-sm text-gray-500 hover:text-white transition-colors duration-300 focus:outline-none">
                            <span x-text="expanded ? 'Sembunyikan' : 'Lihat Selengkapnya'"></span>
                            <svg :class="{'rotate-180': expanded}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    @endif
                    
                @else
                    <p class="text-gray-500 text-sm italic">Detail paket belum tersedia.</p>
                @endif
            </div>

        </div>
        @empty
        <div class="w-full text-center text-gray-500 py-10">
            Belum ada paket layanan yang ditambahkan dari dashboard.
        </div>
        @endforelse
        
    </div>
    
    <style>
        .hide-scrollbar {
            -ms-overflow-style: none; 
            scrollbar-width: none; 
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none; 
        }
        [x-cloak] { display: none !important; }
    </style>
</section>