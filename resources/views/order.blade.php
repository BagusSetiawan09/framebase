@extends('layouts.app')

@section('title', 'Booking Order - Frame Base')

@section('content')
<section class="w-full bg-white py-24 sm:py-32">
    <div class="max-w-4xl mx-auto px-6">
        
        <div class="mb-16">
            {{-- <a href="/" class="text-sm font-bold text-gray-400 hover:text-black transition-colors mb-8 inline-block">← KEMBALI KE BERANDA</a> --}}
            <h1 class="text-5xl font-medium text-gray-900 tracking-tight mb-4">Mulai Proyek Anda</h1>
            <p class="text-lg text-gray-500">Isi detail kebutuhan visual Anda di bawah ini. Kami akan menganalisis brief Anda dan memberikan penawaran terbaik dalam 1x24 jam.</p>
        </div>

        @if(session('success'))
            <div x-data="{ showModal: true }" 
                 x-show="showModal"
                 class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-6"
                 x-cloak>
                
                <div x-show="showModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 bg-black/60 backdrop-blur-sm"
                     @click="showModal = false">
                </div>

                <div x-show="showModal" 
                     x-transition:enter="transition ease-out duration-400"
                     x-transition:enter-start="opacity-0 translate-y-12 scale-90"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-12 scale-90"
                     class="relative bg-white rounded-3xl p-8 md:p-12 max-w-lg w-full shadow-2xl text-center z-10 flex flex-col items-center">
                    
                    <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mb-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>

                    <h2 class="text-3xl font-medium text-gray-900 mb-4 tracking-tight">Penawaran Terkirim!</h2>
                    <p class="text-gray-500 text-lg leading-relaxed mb-10">
                        {{ session('success') }}
                    </p>

                    <div class="w-full flex flex-col gap-3">
                        <a href="/" class="w-full py-4 bg-[#141414] hover:bg-black text-white rounded-xl font-bold text-base transition-transform transform hover:-translate-y-1 shadow-lg">
                            Kembali ke Beranda
                        </a>
                        <button @click="showModal = false" type="button" class="w-full py-4 bg-gray-50 hover:bg-gray-100 text-gray-500 rounded-xl font-medium text-base transition-colors">
                            Tutup Modal
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('order.submit') }}" method="POST" class="space-y-12">
            @csrf
            
            <div class="space-y-6">
                <h3 class="text-xs font-bold tracking-widest text-red-600 uppercase">01. Informasi Klien</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="text" name="name" placeholder="Nama Lengkap / PIC *" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-gray-900 transition-all text-gray-900">
                    <input type="text" name="company_name" placeholder="Nama Perusahaan (Opsional)" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-gray-900 transition-all text-gray-900">
                    <input type="email" name="email" placeholder="Alamat Email Profesional *" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-gray-900 transition-all text-gray-900">
                    <input type="number" name="phone" placeholder="Nomor WhatsApp *" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-gray-900 transition-all text-gray-900">
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-xs font-bold tracking-widest text-red-600 uppercase">02. Detail Kebutuhan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

                    <div x-data="{ 
                        open: false, 
                        selectedText: '', 
                        selectedId: '', 
                        services: @js($services), 
                        getIcon(name) {
                            let svgBase = '<svg class=\'w-6 h-6 text-gray-400 group-hover:text-red-500 transition-colors\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'';
                            let svgEnd = '\'/></svg>';
                            
                            // Heroicons mapping berdasarkan keyword nama paket
                            if(name.includes('Wedding') && !name.includes('Pre-Wedding')) return svgBase + 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z' + svgEnd; // heart
                            if(name.includes('Pre-Wedding')) return svgBase + 'M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z' + svgEnd; // video-camera
                            if(name.includes('Product')) return svgBase + 'M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z\'/><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z' + svgEnd; // camera
                            if(name.includes('Corporate')) return svgBase + 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z' + svgEnd; // briefcase
                            if(name.includes('Brand')) return svgBase + 'M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.82 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.496 1.508 1.333 1.508 2.316V18' + svgEnd; // light-bulb
                            if(name.includes('Graduation')) return svgBase + 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5' + svgEnd; // academic-cap
                            
                            return svgBase + 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z' + svgEnd; // sparkles fallback
                        }
                    }" class="relative w-full">
                        <input type="hidden" name="service_id" :value="selectedId" required>
                        
                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-full flex items-center justify-between px-6 py-4 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-gray-900 transition-all text-left">
                            <span x-show="selectedText" class="flex items-center gap-3">
                                <span class="flex-shrink-0 [&>svg]:text-gray-900" x-html="getIcon(selectedText)"></span>
                                <span x-text="selectedText" class="text-gray-900 font-medium"></span>
                            </span>
                            <span x-show="!selectedText" class="text-gray-400">Pilih Paket Layanan *</span>
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute top-full left-0 right-0 mt-3 p-3 bg-white/70 backdrop-blur-xl border border-white/80 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] z-50 max-h-96 overflow-y-auto hide-scrollbar" x-cloak>
                            
                            <template x-for="service in services" :key="service.id">
                                <button type="button" 
                                        @click="selectedId = service.id; selectedText = service.name; open = false" 
                                        class="w-full flex items-center gap-4 px-5 py-4 rounded-xl hover:bg-red-50 text-left transition-colors duration-200 group">
                                    <span class="flex-shrink-0" x-html="getIcon(service.name)"></span>
                                    <div>
                                        <p class="font-medium text-gray-900 group-hover:text-red-700 transition-colors" x-text="service.name"></p>
                                        <p class="text-xs text-red-600 mt-1">Rp <span x-text="new Intl.NumberFormat('id-ID').format(service.price)"></span></p>
                                    </div>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div x-data="{ 
                        open: false, 
                        selectedScale: '', 
                        svgBase: '<svg class=\'w-6 h-6 text-gray-400 group-hover:text-red-500 transition-colors\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'',
                        svgEnd: '\'/></svg>',
                        scales: [] 
                    }" 
                    x-init="scales = [
                        { text: 'Personal / Skala Kecil (1 Hari)', icon: svgBase + 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z' + svgEnd },
                        { text: 'Corporate / Skala Menengah', icon: svgBase + 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z' + svgEnd },
                        { text: 'Campaign / Skala Besar', icon: svgBase + 'M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.499 4.499 0 001.415-1.515m3.38 3.38a4.499 4.499 0 001.515-1.415M10.5 12.25a1.75 1.75 0 11-3.5 0 1.75 1.75 0 013.5 0z' + svgEnd }
                    ]" class="relative w-full">
                        <input type="hidden" name="scale" :value="selectedScale" required>
                        
                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-full flex items-center justify-between px-6 py-4 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-gray-900 transition-all text-left">
                            <span x-show="selectedScale" class="flex items-center gap-3">
                                <span class="flex-shrink-0 [&>svg]:text-gray-900" x-html="scales.find(s => s.text === selectedScale)?.icon"></span>
                                <span x-text="selectedScale" class="text-gray-900 font-medium"></span>
                            </span>
                            <span x-show="!selectedScale" class="text-gray-400">Skala Proyek *</span>
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute top-full left-0 right-0 mt-3 p-3 bg-white/70 backdrop-blur-xl border border-white/80 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] z-50 overflow-hidden" x-cloak>
                            
                            <template x-for="scale in scales" :key="scale.text">
                                <button type="button" 
                                        @click="selectedScale = scale.text; open = false" 
                                        class="w-full flex items-center gap-4 px-5 py-4 rounded-xl hover:bg-red-50 text-left transition-colors duration-200 group">
                                    <span class="flex-shrink-0" x-html="scale.icon"></span>
                                    <span class="font-medium text-gray-900 group-hover:text-red-700 transition-colors" x-text="scale.text"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                </div>
                <textarea name="description" placeholder="Ceritakan visi atau detail kebutuhan proyek Anda secara lengkap..." required rows="5" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-gray-900 transition-all text-gray-900"></textarea>
            </div>

            <div class="space-y-6">
                <h3 class="text-xs font-bold tracking-widest text-red-600 uppercase">03. Logistik & Anggaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs text-gray-400 ml-2">Tanggal Pelaksanaan *</label>
                        <input type="date" name="event_date" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-gray-900 transition-all text-gray-900">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs text-gray-400 ml-2">Lokasi / Venue *</label>
                        <input type="text" name="location" placeholder="Kota atau Alamat Spesifik" required class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-gray-900 transition-all text-gray-900">
                    </div>
                    
                    <div x-data="{ 
                        open: false, 
                        selectedBudget: '',
                        svgBase: '<svg class=\'w-6 h-6 text-gray-400 group-hover:text-red-500 transition-colors\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'',
                        svgEnd: '\'/></svg>',
                        budgets: [] 
                    }" 
                    x-init="budgets = [
                        { text: 'Di bawah Rp 5.000.000', icon: svgBase + 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z' + svgEnd },
                        { text: 'Rp 5.000.000 - Rp 15.000.000', icon: svgBase + 'M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3' + svgEnd },
                        { text: 'Di atas Rp 15.000.000 (Premium)', icon: svgBase + 'M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0' + svgEnd }
                    ]" class="relative w-full">
                        <input type="hidden" name="budget_range" :value="selectedBudget" required>
                        
                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-full flex items-center justify-between px-6 py-4 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-gray-900 transition-all text-left">
                            <span x-show="selectedBudget" class="flex items-center gap-3">
                                <span class="flex-shrink-0 [&>svg]:text-gray-900" x-html="budgets.find(b => b.text === selectedBudget)?.icon"></span>
                                <span x-text="selectedBudget" class="text-gray-900 font-medium"></span>
                            </span>
                            <span x-show="!selectedBudget" class="text-gray-400">Estimasi Anggaran *</span>
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 text-gray-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute top-full left-0 right-0 mt-3 p-3 bg-white/70 backdrop-blur-xl border border-white/80 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] z-50 overflow-hidden" x-cloak>
                            
                            <template x-for="budget in budgets" :key="budget.text">
                                <button type="button" 
                                        @click="selectedBudget = budget.text; open = false" 
                                        class="w-full flex items-center gap-4 px-5 py-4 rounded-xl hover:bg-red-50 text-left transition-colors duration-200 group">
                                    <span class="flex-shrink-0" x-html="budget.icon"></span>
                                    <span class="font-medium text-gray-900 group-hover:text-red-700 transition-colors" x-text="budget.text"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <input type="url" name="reference_url" placeholder="Link Referensi Visual (G-Drive/IG/Pinterest)" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-gray-900 transition-all text-gray-900">
                </div>
            </div>

            <div class="flex items-start gap-3 pt-4">
                <input type="checkbox" required class="w-5 h-5 mt-0.5 rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                <label class="text-sm text-gray-500 leading-relaxed">Saya menyetujui bahwa data yang dikirimkan akan digunakan oleh Frame Base untuk keperluan penyusunan penawaran proyek. Kami menjamin kerahasiaan brief Anda.</label>
            </div>

            <button type="submit" class="w-full py-5 bg-[#141414] hover:bg-black text-white rounded-2xl font-bold text-lg tracking-wide transition-all transform hover:-translate-y-1 shadow-xl">
                Kirim Penawaran Sekarang
            </button>
        </form>
    </div>
</section>

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
@endsection