@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-white">إدارة المستخدمين</h1>
    <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-6 py-3 rounded-lg transition-all shadow-lg">
        <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        إضافة مستخدم جديد
    </a>
</div>

@if(session('success'))
<div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالاسم، اسم المستخدم أو رقم الهاتف..." class="w-full h-[42px] px-4 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-all h-[42px]">
            <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            بحث
        </button>
        <a href="{{ route('admin.users.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-all h-[42px] flex items-center">
            إعادة تعيين
        </a>
    </form>
</div>

<div class="stat-card rounded-2xl border border-white/5 shadow-xl">
    <div class="overflow-x-auto">
    <table class="w-full">
        <thead class="bg-white/5">
            <tr>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">#</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الاسم</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">اسم المستخدم</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الدور</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الهاتف</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">واتساب</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الحالة</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($users as $user)
            <tr class="hover:bg-white/5 transition-colors">
                <td class="px-6 py-4 text-white">{{ $user->id }}</td>
                <td class="px-6 py-4 text-white font-medium">{{ $user->name }}</td>
                <td class="px-6 py-4 text-gray-400">{{ $user->username }}</td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-xs bg-purple-500/20 text-purple-400">
                        {{ $user->role->display_name ?? $user->role->name }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-400">{{ $user->phone }}</td>
                <td class="px-6 py-4 text-gray-400">{{ $user->whatsapp_number }}</td>
                <td class="px-6 py-4">
                    @if($user->is_active)
                        <span class="px-3 py-1 rounded-full text-xs bg-green-500/20 text-green-400">نشط</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs bg-red-500/20 text-red-400">غير نشط</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-400 hover:text-blue-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
