<div class="relative inline-block text-left">
    <select onchange="window.location.href='?lang=' + this.value" 
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇬🇧 English</option>
        <option value="ms" {{ app()->getLocale() == 'ms' ? 'selected' : '' }}>🇲🇾 Bahasa Malaysia</option>
        <option value="id" {{ app()->getLocale() == 'id' ? 'selected' : '' }}>🇮🇩 Bahasa Indonesia</option>
        <option value="zh" {{ app()->getLocale() == 'zh' ? 'selected' : '' }}>🇨🇳 中文</option>
        <option value="hi" {{ app()->getLocale() == 'hi' ? 'selected' : '' }}>🇮🇳 हिन्दी</option>
    </select>
</div>
