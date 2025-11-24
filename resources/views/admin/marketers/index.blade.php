@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">المسوقين والبضاعة</h1>
</div>

<div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
    <form method="GET" action="{{ route('admin.marketers.index') }}" class="flex gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالاسم أو رقم الهاتف..." class="w-full h-[42px] px-4 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-all h-[42px]">
            <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            بحث
        </button>
        <a href="{{ route('admin.marketers.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-all h-[42px] flex items-center">
            إعادة تعيين
        </a>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($marketers as $marketer)
    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl hover:border-purple-500/30 transition-all">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-white">{{ $marketer->marketerName }}</h3>
                <p class="text-sm text-gray-400">{{ $marketer->marketerPhone }}</p>
            </div>
        </div>

        <div class="border-t border-white/10 pt-4 mb-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-400">إجمالي البضاعة</span>
                <span class="text-2xl font-bold text-purple-400">{{ $marketer->totalQuantity }}</span>
            </div>
        </div>

        <div class="flex gap-2 mb-4">
            <a href="{{ route('admin.marketers.add-stock', $marketer->marketerId) }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-all text-center text-sm">
                <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة بضاعة
            </a>
            <a href="{{ route('admin.marketers.return-stock', $marketer->marketerId) }}" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-all text-center text-sm">
                <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
                ترجيع بضاعة
            </a>
        </div>

        @if(count($marketer->products) > 0)
        <div class="space-y-2">
            <h4 class="text-sm font-medium text-gray-400 mb-3">البضاعة المتوفرة:</h4>
            @foreach($marketer->products as $product)
            <div class="flex items-center justify-between bg-white/5 rounded-lg p-3">
                <span class="text-white">{{ $product->name }}</span>
                <span class="px-3 py-1 rounded-full text-xs bg-blue-500/20 text-blue-400 font-medium">
                    {{ $product->quantity }} قطعة
                </span>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-4">
            <p class="text-gray-500 text-sm">لا توجد بضاعة حالياً</p>
        </div>
        @endif
    </div>
    @empty
    <div class="col-span-full">
        <div class="stat-card rounded-2xl p-12 border border-white/5 shadow-xl text-center">
            <svg class="w-16 h-16 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <p class="text-gray-400 text-lg">لا يوجد مسوقين نشطين حالياً</p>
        </div>
    </div>
    @endforelse
</div>
@endsection
