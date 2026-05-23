<nav class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-max">
    <div class="bg-[#1a1a1a] rounded-full p-1.5 flex items-center shadow-2xl border border-gray-800">
        
        <a href="{{ url('/') }}" 
           class="{{ request()->is('/') ? 'bg-[#333333] text-white' : 'text-gray-400 hover:text-white' }} px-8 py-2.5 rounded-full font-medium text-sm transition-all duration-300">
            Home
        </a>
        
        <a href="{{ route('order.page') }}" 
           class="{{ request()->routeIs('order.page') ? 'bg-[#333333] text-white' : 'text-gray-400 hover:text-white' }} px-8 py-2.5 rounded-full font-medium text-sm transition-all duration-300">
            Order
        </a>

        @auth
            @if(!$sectionSetting)
                <a href="{{ route('filament.admin.resources.section-settings.index') }}" 
                   class="ml-2 bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-full font-regular text-xs tracking-wider transition-all duration-300 animate-pulse flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                    Text Section Not Set
                </a>
            @endif
        @endauth
        
    </div>
</nav>