@if(auth()->user()->role->name === 'marketer')
<div id="mobileMenu" class="fixed bottom-2 left-2 right-2 glass-effect border border-white/10 z-30 shadow-2xl md:hidden rounded-2xl">
    <div class="flex items-center justify-around py-1 px-1">
        <a href="{{ route('marketer.invoices.index') }}" class="relative flex {{ request()->routeIs('marketer.invoices.index') ? 'flex-col items-center space-y-1 -mt-5 !text-white px-6' : 'items-center justify-center text-gray-300' }} p-2.5 rounded-xl transition-all duration-300 hover:scale-105" style="{{ request()->routeIs('marketer.invoices.index') ? 'color: white !important;' : '' }}">
            @if(request()->routeIs('marketer.invoices.index'))
                <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl shadow-lg shadow-purple-500/30"></div>
            @endif
            <svg class="relative w-6 h-6 {{ request()->routeIs('marketer.invoices.index') ? '' : 'text-gray-300' }}" fill="none" stroke="{{ request()->routeIs('marketer.invoices.index') ? 'white' : 'currentColor' }}" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            @if(request()->routeIs('marketer.invoices.index'))
                <span class="relative text-xs font-semibold">فواتيري</span>
            @endif
        </a>

        <a href="{{ route('marketer.invoices.create') }}" class="relative flex {{ request()->routeIs('marketer.invoices.create') ? 'flex-col items-center space-y-1 -mt-5 !text-white px-6' : 'items-center justify-center text-gray-300' }} p-2.5 rounded-xl transition-all duration-300 hover:scale-105" style="{{ request()->routeIs('marketer.invoices.create') ? 'color: white !important;' : '' }}">
            @if(request()->routeIs('marketer.invoices.create'))
                <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl shadow-lg shadow-purple-500/30"></div>
            @endif
            <svg class="relative w-7 h-7 {{ request()->routeIs('marketer.invoices.create') ? '' : 'text-gray-300' }}" fill="none" stroke="{{ request()->routeIs('marketer.invoices.create') ? 'white' : 'currentColor' }}" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            @if(request()->routeIs('marketer.invoices.create'))
                <span class="relative text-xs font-semibold">جديد</span>
            @endif
        </a>

        <a href="{{ route('marketer.stock.index') }}" class="relative flex {{ request()->routeIs('marketer.stock.index') ? 'flex-col items-center space-y-1 -mt-5 !text-white px-6' : 'items-center justify-center text-gray-300' }} p-2.5 rounded-xl transition-all duration-300 hover:scale-105" style="{{ request()->routeIs('marketer.stock.index') ? 'color: white !important;' : '' }}">
            @if(request()->routeIs('marketer.stock.index'))
                <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl shadow-lg shadow-purple-500/30"></div>
            @endif
            <svg class="relative w-6 h-6 {{ request()->routeIs('marketer.stock.index') ? '' : 'text-gray-300' }}" fill="none" stroke="{{ request()->routeIs('marketer.stock.index') ? 'white' : 'currentColor' }}" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            @if(request()->routeIs('marketer.stock.index'))
                <span class="relative text-xs font-semibold">مخزوني</span>
            @endif
        </a>

        <a href="{{ route('marketer.earnings.index') }}" class="relative flex {{ request()->routeIs('marketer.earnings.index') ? 'flex-col items-center space-y-1 -mt-5 !text-white px-6' : 'items-center justify-center text-gray-300' }} p-2.5 rounded-xl transition-all duration-300 hover:scale-105" style="{{ request()->routeIs('marketer.earnings.index') ? 'color: white !important;' : '' }}">
            @if(request()->routeIs('marketer.earnings.index'))
                <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-blue-600 rounded-xl shadow-lg shadow-purple-500/30"></div>
            @endif
            <svg class="relative w-6 h-6 {{ request()->routeIs('marketer.earnings.index') ? '' : 'text-gray-300' }}" fill="none" stroke="{{ request()->routeIs('marketer.earnings.index') ? 'white' : 'currentColor' }}" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            @if(request()->routeIs('marketer.earnings.index'))
                <span class="relative text-xs font-semibold">أرباحي</span>
            @endif
        </a>
    </div>
</div>
@endif
