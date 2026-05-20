@props(['portfolios', 'setting'])

<section id="portfolio" class="w-full bg-white py-24 sm:py-32 relative overflow-hidden" x-data="{ 
    modalOpen: false, 
    activeTitle: '', 
    activeCategory: '', 
    activeDesc: '', 
    activeImages: [], 
    activeMainImg: '' 
}">
    
    <div class="w-full flex flex-col lg:flex-row gap-12 lg:gap-16 items-start pl-6 sm:pl-10 lg:pl-20 xl:pl-[calc((100vw-1280px)/2+5rem)]">
        
        <div class="w-full lg:w-[380px] xl:w-[420px] flex-shrink-0 lg:sticky lg:top-32 text-left z-30 pr-6 sm:pr-10 lg:pr-0">
            <h2 class="text-5xl md:text-6xl font-medium text-gray-900 tracking-tight leading-tight">
                {{ $setting->portfolio_title_white ?? 'Karya terbaik' }}
            </h2>
            <h3 class="text-5xl md:text-6xl font-medium text-gray-400 tracking-tight leading-tight mt-1">
                {{ $setting->portfolio_title_gray ?? 'visual kami' }}
            </h3>
            <p class="mt-6 text-lg text-gray-500 leading-relaxed max-w-sm">
                {{ $setting->portfolio_subtitle ?? 'Lihat bagaimana kami menangkap momen dan mengubahnya menjadi cerita visual yang tak terlupakan. Klik pada karya untuk melihat detailnya.' }}
            </p>
        </div>

        <div class="flex-grow relative w-full lg:w-[calc(100%-420px)]">
            
            <div class="hidden lg:block absolute left-0 top-0 bottom-0 w-12 bg-gradient-to-r from-white to-transparent z-20 pointer-events-none"></div>

            <div class="flex overflow-x-auto snap-x snap-mandatory gap-6 md:gap-8 pb-10 hide-scrollbar pr-6 sm:pr-10 lg:pr-32 w-full">
                
                @forelse($portfolios as $portfolio)
                    @php
                        $imagesArray = is_string($portfolio->images) ? json_decode($portfolio->images, true) : $portfolio->images;
                        
                        $coverImage = is_array($imagesArray) && count($imagesArray) > 0 
                            ? asset('storage/' . $imagesArray[0]) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($portfolio->title) . '&background=141414&color=fff&size=512';
                            
                        $categoryName = $portfolio->service ? $portfolio->service->name : 'Uncategorized';
                        $cleanPreview = strip_tags($portfolio->description);
                    @endphp

                    <div class="snap-start shrink-0 w-[280px] sm:w-[340px] cursor-pointer group"
                         @click="
                            modalOpen = true; 
                            activeTitle = @js($portfolio->title); 
                            activeCategory = @js($categoryName);
                            activeDesc = @js($portfolio->description);
                            activeImages = @js($imagesArray);
                            activeMainImg = @js($coverImage);
                         ">
                        <div class="w-full aspect-[4/5] bg-[#141414] rounded-2xl overflow-hidden mb-6 shadow-md">
                            <img src="{{ $coverImage }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out opacity-90 group-hover:opacity-100">
                        </div>
                        <p class="text-gray-400 text-sm font-medium mb-1">{{ $categoryName }}</p>
                        <h4 class="text-2xl font-medium text-gray-900 mb-2">{{ $portfolio->title }}</h4>
                        <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">
                            {{ Str::limit($cleanPreview, 100) }}
                        </p>
                    </div>
                @empty
                    <div class="w-full text-center text-gray-400 py-20 italic">
                        Belum ada karya portofolio yang diunggah.
                    </div>
                @endforelse

            </div>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" x-cloak>
            
            <div x-show="modalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 bg-black/80 backdrop-blur-sm" 
                 @click="modalOpen = false">
            </div>

            <div x-show="modalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                 class="relative bg-white rounded-3xl w-full max-w-5xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col md:flex-row z-10">
                
                <button @click="modalOpen = false" class="absolute top-4 right-4 z-20 bg-black/50 hover:bg-black text-white rounded-full p-2 backdrop-blur-md transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="w-full md:w-3/5 flex flex-col h-64 md:h-auto bg-gray-100">
                    <div class="flex-grow overflow-hidden">
                        <img :src="activeMainImg" :alt="activeTitle" class="w-full h-full object-cover">
                    </div>

                    <template x-if="activeImages && activeImages.length > 1">
                        <div class="flex items-center gap-3 p-4 bg-white/50 backdrop-blur-sm border-t border-gray-200 overflow-x-auto hide-scrollbar flex-none">
                            <template x-for="(image, index) in activeImages" :key="index">
                                @php
                                    $storagePath = asset('storage');
                                @endphp
                                <img :src="`${@js($storagePath)}/${image}`" 
                                     :alt="`Thumbnail ${index + 1}`"
                                     class="w-16 h-16 object-cover rounded-lg cursor-pointer border-2 transition-all duration-300 flex-none"
                                     :class="activeMainImg === `${@js($storagePath)}/${image}` ? 'border-[#E50914]' : 'border-transparent hover:border-gray-300'"
                                     @click="activeMainImg = `${@js($storagePath)}/${image}`">
                            </template>
                        </div>
                    </template>
                </div>

                <div class="w-full md:w-2/5 p-8 md:p-12 flex flex-col justify-center overflow-y-auto bg-white">
                    <p class="text-[#E50914] text-sm font-semibold tracking-widest uppercase mb-3" x-text="activeCategory"></p>
                    <h3 class="text-3xl font-medium text-gray-900 mb-6 leading-snug" x-text="activeTitle"></h3>
                    <div class="text-gray-600 leading-relaxed mb-8 prose prose-sm max-w-none" x-html="activeDesc"></div>
                    
                    <a href="#order" @click="modalOpen = false" class="inline-block px-8 py-4 bg-[#141414] hover:bg-black text-white font-medium rounded-xl transition-colors text-center shadow-lg w-max">
                        Pesan Layanan Serupa
                    </a>
                </div>
            </div>
        </div>
    </template>

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