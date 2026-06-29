<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-indigo-600">MowingWash</a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-700 hover:text-gray-900">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>