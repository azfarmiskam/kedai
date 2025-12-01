<div class="p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Notification Settings</h1>
            <p class="mt-2 text-sm text-gray-600">Configure Telegram and WhatsApp notifications for new seller registrations</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @php
            $settings = \App\Models\SystemSetting::first() ?? new \App\Models\SystemSetting();
        @endphp

        <form action="{{ route('superadmin.settings.notifications.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Telegram Settings -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Telegram</h2>
                                <p class="text-sm text-gray-500">Free notifications</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="telegram_enabled" value="1" 
                                   {{ $settings->telegram_enabled ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bot Token</label>
                            <input type="text" name="telegram_bot_token" 
                                   value="{{ $settings->telegram_bot_token ? '••••••••••••••••' : '' }}"
                                   placeholder="123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Get from @BotFather on Telegram</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Chat ID</label>
                            <input type="text" name="telegram_chat_id" 
                                   value="{{ $settings->telegram_chat_id ? Crypt::decryptString($settings->telegram_chat_id) : '' }}"
                                   placeholder="-1001234567890"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Your personal or group chat ID</p>
                        </div>

                        <button type="button" onclick="testTelegram()" 
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Send Test Message
                        </button>
                    </div>
                </div>

                <!-- WhatsApp Settings -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">WhatsApp</h2>
                                <p class="text-sm text-gray-500">Via Twilio</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="whatsapp_enabled" value="1" 
                                   {{ $settings->whatsapp_enabled ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Account SID</label>
                            <input type="text" name="twilio_account_sid" 
                                   value="{{ $settings->twilio_account_sid ? '••••••••••••••••' : '' }}"
                                   placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">From Twilio Console</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Auth Token</label>
                            <input type="text" name="twilio_auth_token" 
                                   value="{{ $settings->twilio_auth_token ? '••••••••••••••••' : '' }}"
                                   placeholder="your_auth_token_here"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">From Twilio Console</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp From Number</label>
                            <input type="text" name="twilio_whatsapp_from" 
                                   value="{{ $settings->twilio_whatsapp_from ?? '' }}"
                                   placeholder="whatsapp:+14155238886"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Your Twilio WhatsApp number</p>
                        </div>

                        <button type="button" onclick="testWhatsApp()" 
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Send Test Message
                        </button>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="mt-8 flex justify-end">
                <button type="submit" 
                        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-secondary transition font-semibold">
                    Save Settings
                </button>
            </div>
        </form>

        <!-- Setup Instructions -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">📚 Setup Instructions</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-semibold text-blue-800 mb-2">Telegram Setup:</h4>
                    <ol class="list-decimal list-inside space-y-1 text-sm text-blue-700">
                        <li>Open Telegram and search for @BotFather</li>
                        <li>Send /newbot and follow instructions</li>
                        <li>Copy the bot token provided</li>
                        <li>Start a chat with your bot</li>
                        <li>Get your chat ID from @userinfobot</li>
                    </ol>
                </div>
                
                <div>
                    <h4 class="font-semibold text-blue-800 mb-2">WhatsApp Setup:</h4>
                    <ol class="list-decimal list-inside space-y-1 text-sm text-blue-700">
                        <li>Create account at twilio.com</li>
                        <li>Go to Console Dashboard</li>
                        <li>Copy Account SID and Auth Token</li>
                        <li>Enable WhatsApp in Messaging</li>
                        <li>Get your WhatsApp sender number</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testTelegram() {
    const chatId = document.querySelector('input[name="telegram_chat_id"]').value;
    
    if (!chatId) {
        alert('Please enter a Chat ID first');
        return;
    }

    fetch('{{ route('superadmin.settings.notifications.test-telegram') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ chat_id: chatId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        alert('❌ Error: ' + error.message);
    });
}

function testWhatsApp() {
    const phoneNumber = document.querySelector('input[name="twilio_whatsapp_from"]').value;
    
    if (!phoneNumber) {
        alert('Please enter a WhatsApp number first');
        return;
    }

    fetch('{{ route('superadmin.settings.notifications.test-whatsapp') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ phone_number: phoneNumber })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        alert('❌ Error: ' + error.message);
    });
}
</script>
