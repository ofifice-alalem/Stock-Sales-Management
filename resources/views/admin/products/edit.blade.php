@extends('layouts.admin')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-white mb-6">تعديل المنتج</h1>

    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-white mb-2">اسم المنتج</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" 
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="unit" class="block text-sm font-medium text-white mb-2">الوحدة</label>
                <input type="text" id="unit" name="unit" value="{{ old('unit', $product->unit) }}" 
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white @error('unit') border-red-500 @enderror" required>
                @error('unit')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-white mb-2">الوصف</label>
                <textarea id="description" name="description" rows="4" 
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white @error('description') border-red-500 @enderror" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-6 py-3 rounded-lg transition-all shadow-lg">
                    تحديث
                </button>
                <a href="{{ route('admin.products.index') }}" class="bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-lg transition-all">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection