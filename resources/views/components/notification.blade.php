@if(session('success'))
    <div id="notification" class="fixed top-4 right-4 bg-white border-2 border-green-500 rounded-lg shadow-lg p-4 flex items-center space-x-3 z-50 animate-slide-in">
        <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="text-black font-medium">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div id="notification" class="fixed top-4 right-4 bg-white border-2 border-red-500 rounded-lg shadow-lg p-4 flex items-center space-x-3 z-50 animate-slide-in">
        <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        <span class="text-black font-medium">{{ session('error') }}</span>
    </div>
@endif

@if(session('success') || session('error'))
    <script>
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const notification = document.getElementById('notification');
            if (notification) {
                notification.style.transition = 'opacity 0.5s';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            }
        }, 5000);
    </script>
@endif
