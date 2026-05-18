<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'RDAPLook — Domain Intelligence API | WHOIS Replacement')</title>
    <meta name="description" content="@yield('meta_description', 'RDAP-native domain intelligence API. Clean JSON, 2,000 free requests/day, $4/mo to upgrade. The modern replacement for WHOIS API.')">
    <meta property="og:title" content="@yield('og_title', 'RDAPLook — Domain Intelligence API | WHOIS Replacement')">
    <meta property="og:description" content="@yield('og_description', 'RDAP-native domain intelligence API. Clean JSON, 2,000 free requests/day, $4/mo to upgrade. The modern replacement for WHOIS API.')">
    <meta property="og:url" content="@yield('og_url', 'https://rdaplook.com')">
    <meta property="og:type" content="website">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    {{-- Inline: apply dark class before first paint to prevent flash --}}
    <script>if(localStorage.getItem('theme')==='dark')document.documentElement.classList.add('dark')</script>
</head>
<body class="bg-white dark:bg-[#0a0a0a] text-[#09090b] dark:text-[#f4f4f5] font-sans antialiased transition-colors duration-150">

    {{-- Navbar --}}
    <nav class="fixed top-0 left-0 right-0 z-50 border border-[#e4e4e7] dark:border-[#1f1f1f] bg-white/80 dark:bg-[#0a0a0a]/80 backdrop-blur-md w-11/12 m-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="/" class="font-mono text-base font-medium tracking-tight">RDAPLook</a>

            <div class="flex items-center gap-5">
                <div class="hidden sm:flex items-center gap-5">
                    <a href="/docs" class="text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors">Docs</a>
                    <a href="#pricing" class="text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors">Pricing</a>
                    <a href="https://github.com/rdaplook" target="_blank" rel="noopener" class="text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors">GitHub</a>
                    <a href="https://rapidapi.com/rdaplook/api/rdaplook" target="_blank" rel="noopener" class="px-4 py-1.5 text-sm font-medium bg-indigo-500 hover:bg-indigo-600 text-white rounded-md transition-colors">Get API Key</a>
                </div>

                {{-- Theme toggle --}}
                <button
                    onclick="const d=document.documentElement;d.classList.toggle('dark');localStorage.setItem('theme',d.classList.contains('dark')?'dark':'light')"
                    class="p-1.5 rounded-md text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] hover:bg-[#f4f4f5] dark:hover:bg-[#1f1f1f] transition-colors"
                    title="Toggle theme"
                >
                    {{-- Sun — shown in dark mode --}}
                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    {{-- Moon — shown in light mode --}}
                    <svg class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <a href="https://rapidapi.com/rdaplook/api/rdaplook" target="_blank" rel="noopener" class="sm:hidden px-3 py-1.5 text-xs font-medium bg-indigo-500 hover:bg-indigo-600 text-white rounded-md transition-colors">Get API Key</a>
            </div>
        </div>
    </nav>

    @yield('content')

    {{-- Footer --}}
    <footer class="border-t border-[#e4e4e7] dark:border-[#1f1f1f] mt-24">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12">
            <div class="flex flex-col sm:flex-row justify-between gap-6">
                <p class="text-sm text-[#71717a]">RDAPLook — RDAP-native domain intelligence API</p>
                <div class="flex flex-wrap gap-x-5 gap-y-2">
                    <a href="/docs" class="text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors">Docs</a>
                    <a href="#pricing" class="text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors">Pricing</a>
                    <a href="#" class="text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors">RapidAPI</a>
                    <a href="https://github.com/rdaplook" target="_blank" rel="noopener" class="text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors">GitHub</a>
                    <a href="/terms" class="text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors">Terms</a>
                    <a href="/privacy" class="text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors">Privacy</a>
                </div>
            </div>
            <p class="mt-8 text-xs text-[#a1a1aa]">© 2025 RDAPLook. Built with Laravel.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
