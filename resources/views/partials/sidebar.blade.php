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

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-400 rounded-lg hover:bg-white/5 hover:text-white transition-all {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                </svg>
                لوحة التحكم
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 text-gray-400 rounded-lg hover:bg-white/5 hover:text-white transition-all {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                إدارة المنتجات
            </a>
            <a href="{{ route('admin.invoices.index') }}" class="flex items-center px-4 py-3 text-gray-400 rounded-lg hover:bg-white/5 hover:text-white transition-all {{ request()->routeIs('admin.invoices.*') ? 'bg-gradient-to-r from-purple-600 to-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                إدارة الفواتير
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