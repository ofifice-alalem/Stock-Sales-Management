<div class="fixed inset-y-0 right-0 w-64 glass-effect border-l border-white/5 transform transition-transform duration-300 ease-in-out z-30 shadow-2xl">
    <div class="flex flex-col h-full">
        <div class="flex items-center justify-center h-16 border-b border-white/5">
            <div class="flex items-center space-x-2 space-x-reverse">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <span class="text-white font-bold text-lg">نظام المبيعات</span>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3.5 text-gray-300 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg shadow-purple-500/20 pointer-events-none' : 'hover:bg-white/10 hover:text-white' }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg transition-all duration-200 ml-3 {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <span class="font-medium">لوحة التحكم</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="group flex items-center px-4 py-3.5 text-gray-300 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg shadow-purple-500/20 pointer-events-none' : 'hover:bg-white/10 hover:text-white' }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg transition-all duration-200 ml-3 {{ request()->routeIs('admin.products.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="font-medium">إدارة المنتجات</span>
            </a>
            <a href="{{ route('admin.invoices.index') }}" class="group flex items-center px-4 py-3.5 text-gray-300 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.invoices.*') ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg shadow-purple-500/20 pointer-events-none' : 'hover:bg-white/10 hover:text-white' }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg transition-all duration-200 ml-3 {{ request()->routeIs('admin.invoices.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="font-medium">إدارة الفواتير</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="group flex items-center px-4 py-3.5 text-gray-300 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg shadow-purple-500/20 pointer-events-none' : 'hover:bg-white/10 hover:text-white' }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg transition-all duration-200 ml-3 {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : 'bg-white/5 group-hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span class="font-medium">إدارة المستخدمين</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/5">
            <div class="flex items-center space-x-3 space-x-reverse mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-white font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="flex-1">
                    <p class="text-white font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-gray-400 text-sm">{{ auth()->user()->role->display_name }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors shadow-lg">
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    تسجيل الخروج
                </button>
            </form>
        </div>
    </div>
</div>