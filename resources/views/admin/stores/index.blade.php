@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">المحلات</h1>
    <div class="w-full md:w-80">
        <div class="relative">
            <input id="storeSearch" type="text" placeholder="ابحث باسم المحل، الهاتف أو العنوان" class="w-full bg-white border border-gray-300 dark:bg-white/5 dark:border-white/10 focus:border-blue-500/40 focus:ring-2 focus:ring-blue-500/20 outline-none text-gray-900 dark:text-white placeholder-gray-400 rounded-xl py-2.5 pr-10 pl-4">
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 absolute right-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
    @php
        $totalRemaining = 0;
        foreach ($stores as $s) { $totalRemaining += $s->remaining; }
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-2 gap-3 w-full md:w-auto">
        <div class="stat-card rounded-xl px-4 py-3 border border-gray-200 bg-white dark:bg-transparent dark:border-white/5">
            <p class="text-xs text-gray-600 dark:text-gray-400">عدد المحلات</p>
            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ count($stores) }}</p>
        </div>
        <div class="stat-card rounded-xl px-4 py-3 border border-gray-200 bg-white dark:bg-transparent dark:border-white/5">
            <p class="text-xs text-gray-600 dark:text-gray-400">إجمالي المتبقي</p>
            <p class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($totalRemaining, 2) }} دينار</p>
        </div>
    </div>
</div>

<div id="storesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($stores as $store)
    @php
        $remaining = $store->remaining;
        // Light mode: stronger readable colors, Dark mode: previous translucent tones
        $badgeClasses = 'text-red-700 bg-red-50 border-red-200 dark:text-red-400 dark:bg-red-500/10 dark:border-red-500/20';
        if ($remaining <= 5000) { $badgeClasses = 'text-yellow-700 bg-yellow-50 border-yellow-200 dark:text-yellow-400 dark:bg-yellow-500/10 dark:border-yellow-500/20'; }
        if ($remaining <= 2000) { $badgeClasses = 'text-emerald-700 bg-emerald-50 border-emerald-200 dark:text-emerald-400 dark:bg-emerald-500/10 dark:border-emerald-500/20'; }
        $initials = mb_substr($store->name, 0, 1);
    @endphp
    <div class="stat-card rounded-2xl p-6 border border-gray-200 bg-white bg-gradient-to-b from-gray-50 to-white shadow-lg hover:shadow-xl hover:border-blue-500/30 transition-all dark:border-white/5 dark:bg-gradient-to-b dark:from-white/2 dark:to-white/0"
         data-name="{{ Str::lower($store->name) }}" data-phone="{{ Str::lower($store->phone) }}" data-address="{{ Str::lower($store->address) }}">
        <div class="flex flex-col h-full">
            <div class="mb-4 flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-200 text-blue-600 dark:bg-blue-500/20 dark:border-blue-500/30 dark:text-blue-300 flex items-center justify-center font-bold">
                    {{ $initials }}
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $store->name }}</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>{{ $store->phone }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ $store->address }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4 p-3 rounded-lg border {{ $badgeClasses }}">
                <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">المتبقي</p>
                <p class="text-2xl font-bold text-inherit">{{ number_format($store->remaining, 2) }} دينار</p>
            </div>

            <div class="flex flex-col gap-2 mt-auto">
                <div class="flex gap-2">
                    <a href="tel:{{ $store->phone }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 01.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        اتصال
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $store->phone) }}" target="_blank" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        واتساب
                    </a>
                </div>
                <a href="{{ route('admin.store-debts.show', $store->id) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    التفاصيل
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if(count($stores) === 0)
<div class="stat-card rounded-2xl p-12 border border-gray-200 bg-white shadow-lg text-center dark:border-white/5 dark:bg-transparent">
    <svg class="w-16 h-16 mx-auto text-gray-500 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
    </svg>
    <p class="text-gray-600 dark:text-gray-400 text-lg">لا توجد محلات بديون حالياً</p>
</div>
@endif

<script>
    (function(){
        const input = document.getElementById('storeSearch');
        if (!input) return;
        const cards = Array.from(document.querySelectorAll('#storesGrid > div'));
        const normalize = (s) => (s || '').toString().toLowerCase().trim();
        input.addEventListener('input', function(){
            const q = normalize(this.value);
            cards.forEach(card => {
                const name = normalize(card.getAttribute('data-name'));
                const phone = normalize(card.getAttribute('data-phone'));
                const address = normalize(card.getAttribute('data-address'));
                const match = !q || name.includes(q) || phone.includes(q) || address.includes(q);
                card.style.display = match ? '' : 'none';
            });
        });
    })();
</script>
@endsection
