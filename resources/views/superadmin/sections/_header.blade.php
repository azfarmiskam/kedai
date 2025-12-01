<!-- Top Bar -->
<header class="bg-white shadow-sm z-10">
    <div class="px-8 py-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
            </div>
            <div class="flex items-center space-x-4">
                <x-language-switcher />
                <div class="text-sm text-gray-600">
                    {{ now()->format('l, F j, Y') }}
                </div>
            </div>
        </div>
    </div>
</header>
