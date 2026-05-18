@extends('layouts.app')

@section('title', 'RDAPLook — Domain Intelligence API | WHOIS Replacement')
@section('meta_description', 'RDAP-native domain intelligence API. Clean JSON, 2,000 free requests/day, $4/mo to upgrade. The modern replacement for WHOIS API.')
@section('og_title', 'RDAPLook — Domain Intelligence API | WHOIS Replacement')
@section('og_description', 'RDAP-native domain intelligence API. Clean JSON, 2,000 free requests/day, $4/mo to upgrade. The modern replacement for WHOIS API.')
@section('og_url', 'https://rdaplook.com')

@section('content')
<main>

    {{-- ── Hero ──────────────────────────────────────────────────────────── --}}
    <section class="relative min-h-screen flex flex-col justify-center px-4 sm:px-6 pt-16 pb-24 bg-[#fafafa] dark:bg-[#050505] border-b border-[#e4e4e7] dark:border-[#1a1a1a]">

        {{-- Dot grid --}}
        <div class="dot-grid absolute inset-0 pointer-events-none"></div>

        {{-- Badge + headline + subtitle --}}
        <div class="relative max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 mb-8 text-xs font-medium bg-white dark:bg-[#111111] text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-500/30 rounded-full shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 shrink-0"></span>
                RDAP-native &middot; REST API &middot; Free to start
            </div>

            <h1 class="text-5xl sm:text-6xl font-semibold tracking-tight leading-[1.1]">
                Domain intelligence<br>
                <span class="text-[#71717a]">API. WHOIS is dead.</span>
            </h1>
            <p class="mt-6 text-base sm:text-lg text-[#71717a] max-w-xl mx-auto leading-relaxed">
                RDAP-native. Clean JSON. 2,000 free requests/day.<br class="hidden sm:block"> No credit card required.
            </p>
        </div>

        {{-- Search widget --}}
        <div class="relative max-w-5xl w-full mx-auto mt-10">
            @livewire('domain-lookup')
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
            <a href="#features" class="flex items-center justify-center w-8 h-8 rounded-full border border-[#d4d4d8] dark:border-[#2a2a2a] text-[#a1a1aa] hover:text-[#71717a] hover:border-[#a1a1aa] dark:hover:border-[#444] transition-colors animate-bounce">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </a>
        </div>
    </section>

    {{-- ── Features ──────────────────────────────────────────────────────── --}}
    <section id="features" class="py-16 px-4 sm:px-6 border-t border-[#e4e4e7] dark:border-[#1f1f1f]">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg p-6 shadow-sm dark:shadow-none">
                <div class="w-8 h-8 mb-4 flex items-center justify-center rounded-md bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="font-medium mb-2">No vcardArray hell</h3>
                <p class="text-sm text-[#71717a] leading-relaxed">Every response is flat, normalized JSON. Same schema for every TLD. No surprises.</p>
            </div>

            <div class="bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg p-6 shadow-sm dark:shadow-none">
                <div class="w-8 h-8 mb-4 flex items-center justify-center rounded-md bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-medium mb-2">Most generous free tier</h3>
                <p class="text-sm text-[#71717a] leading-relaxed">2,000 requests/day. No credit card. No trial expiry. Just sign up and start building.</p>
            </div>

            <div class="bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg p-6 shadow-sm dark:shadow-none">
                <div class="w-8 h-8 mb-4 flex items-center justify-center rounded-md bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-medium mb-2">Cheapest paid plan</h3>
                <p class="text-sm text-[#71717a] leading-relaxed">Upgrade to $4/mo for 50,000 requests/day. Less than a coffee. Cancel anytime.</p>
            </div>

        </div>
    </section>

    {{-- ── Code Examples ──────────────────────────────────────────────────── --}}
    <section class="py-16 px-4 sm:px-6 border-t border-[#e4e4e7] dark:border-[#1f1f1f]">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                {{-- Left: copy --}}
                <div>
                    <p class="text-xs font-medium text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">Developer-first</p>
                    <h2 class="text-3xl font-semibold tracking-tight mb-4">Works with any language</h2>
                    <p class="text-[#71717a] leading-relaxed mb-6">
                        One endpoint, one API key. Drop RDAPLook into your existing stack in under a minute.
                        Same predictable JSON regardless of TLD or registrar.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-[#71717a]">REST API — no SDK required</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-[#71717a]">Single <code class="font-mono text-xs bg-[#f4f4f5] dark:bg-[#1f1f1f] px-1 py-0.5 rounded">X-API-Key</code> header auth</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-[#71717a]">JSON response — flat, typed, documented</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-[#71717a]">Rate limit headers on every response</span>
                        </li>
                    </ul>
                </div>

                {{-- Right: code editor window --}}
                <div
                    x-data="{
                        tab: 'curl',
                        copied: false,
                        copy() {
                            const pre = this.$root.querySelector('pre[data-tab=' + this.tab + ']');
                            navigator.clipboard.writeText(pre.textContent.trim());
                            this.copied = true;
                            setTimeout(() => this.copied = false, 2000);
                        }
                    }"
                    class="rounded-xl overflow-hidden shadow-2xl border border-[#252525]"
                >
                    {{-- Window chrome --}}
                    <div class="bg-[#1c1c1c] px-4 py-3 flex items-center gap-3 border-b border-[#2a2a2a]">
                        {{-- Traffic lights --}}
                        <div class="flex gap-1.5 shrink-0">
                            <div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div>
                            <div class="w-3 h-3 rounded-full bg-[#febc2e]"></div>
                            <div class="w-3 h-3 rounded-full bg-[#28c840]"></div>
                        </div>

                        {{-- Language tabs --}}
                        <div class="editor-scroll flex gap-0.5 overflow-x-auto flex-1 min-w-0">
                            @foreach([
                                ['curl',   'cURL',   '#e97316'],
                                ['js',     'Node.js','#eab308'],
                                ['php',    'PHP',    '#8b5cf6'],
                                ['python', 'Python', '#3b82f6'],
                                ['ruby',   'Ruby',   '#ef4444'],
                                ['go',     'Go',     '#22d3ee'],
                            ] as [$key, $label, $color])
                            <button
                                @click="tab = '{{ $key }}'"
                                :class="tab === '{{ $key }}' ? 'bg-[#2a2a2a] text-[#f4f4f5]' : 'text-[#71717a] hover:text-[#a1a1aa] hover:bg-[#222]'"
                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs rounded-md transition-colors whitespace-nowrap shrink-0"
                            >
                                <span class="w-2 h-2 rounded-full shrink-0" style="background:{{ $color }}"></span>
                                {{ $label }}
                            </button>
                            @endforeach
                        </div>

                        {{-- Copy --}}
                        <button
                            @click="copy()"
                            class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 text-xs text-[#71717a] hover:text-[#f4f4f5] bg-[#252525] hover:bg-[#2a2a2a] border border-[#333] rounded-md transition-colors"
                        >
                            <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copied" style="display:none" class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>

                    {{-- Code body --}}
                    <div class="editor-scroll bg-[#0d0d0d] p-5 overflow-x-auto font-mono text-[13px] leading-relaxed min-h-[200px] text-[#a1a1aa]">

                        {{-- cURL --}}
                        <pre data-tab="curl" x-show="tab==='curl'" class="whitespace-pre"><code
><span class="text-amber-400">curl</span> <span class="text-emerald-400">https://rdaplook.com/api/v1/domain/google.com</span> \
  <span class="text-sky-400">-H</span> <span class="text-emerald-400">"X-API-Key: your_api_key"</span></code></pre>

                        {{-- Node.js --}}
                        <pre data-tab="js" x-show="tab==='js'" style="display:none" class="whitespace-pre"><code
><span class="text-purple-400">const</span> res = <span class="text-purple-400">await</span> <span class="text-amber-400">fetch</span>(
  <span class="text-emerald-400">'https://rdaplook.com/api/v1/domain/google.com'</span>,
  { headers: { <span class="text-emerald-400">'X-API-Key'</span>: <span class="text-emerald-400">'your_api_key'</span> } }
);

<span class="text-purple-400">const</span> domain = <span class="text-purple-400">await</span> res.<span class="text-amber-400">json</span>();
<span class="text-sky-400">console</span>.<span class="text-amber-400">log</span>(domain.registrar.name);</code></pre>

                        {{-- PHP --}}
                        <pre data-tab="php" x-show="tab==='php'" style="display:none" class="whitespace-pre"><code
><span class="text-sky-400">$response</span> = Http::<span class="text-amber-400">withHeaders</span>([
    <span class="text-emerald-400">'X-API-Key'</span> <span class="text-[#71717a]">=></span> <span class="text-emerald-400">'your_api_key'</span>
])-><span class="text-amber-400">get</span>(<span class="text-emerald-400">'https://rdaplook.com/api/v1/domain/google.com'</span>);

<span class="text-sky-400">$domain</span> = <span class="text-sky-400">$response</span>-><span class="text-amber-400">json</span>();
<span class="text-purple-400">echo</span> <span class="text-sky-400">$domain</span>[<span class="text-emerald-400">'registrar'</span>][<span class="text-emerald-400">'name'</span>];</code></pre>

                        {{-- Python --}}
                        <pre data-tab="python" x-show="tab==='python'" style="display:none" class="whitespace-pre"><code
><span class="text-purple-400">import</span> requests

response = requests.<span class="text-amber-400">get</span>(
    <span class="text-emerald-400">'https://rdaplook.com/api/v1/domain/google.com'</span>,
    headers={<span class="text-emerald-400">'X-API-Key'</span>: <span class="text-emerald-400">'your_api_key'</span>}
)
domain = response.<span class="text-amber-400">json</span>()
<span class="text-amber-400">print</span>(domain[<span class="text-emerald-400">'registrar'</span>][<span class="text-emerald-400">'name'</span>])</code></pre>

                        {{-- Ruby --}}
                        <pre data-tab="ruby" x-show="tab==='ruby'" style="display:none" class="whitespace-pre"><code
><span class="text-purple-400">require</span> <span class="text-emerald-400">'net/http'</span>
<span class="text-purple-400">require</span> <span class="text-emerald-400">'json'</span>

uri = <span class="text-amber-400">URI</span>(<span class="text-emerald-400">'https://rdaplook.com/api/v1/domain/google.com'</span>)
req = Net::HTTP::Get.<span class="text-amber-400">new</span>(uri)
req[<span class="text-emerald-400">'X-API-Key'</span>] = <span class="text-emerald-400">'your_api_key'</span>

res = Net::HTTP.<span class="text-amber-400">start</span>(uri.hostname, uri.port, use_ssl: <span class="text-purple-400">true</span>) { |h| h.<span class="text-amber-400">request</span>(req) }
domain = JSON.<span class="text-amber-400">parse</span>(res.body)
<span class="text-amber-400">puts</span> domain[<span class="text-emerald-400">'registrar'</span>][<span class="text-emerald-400">'name'</span>]</code></pre>

                        {{-- Go --}}
                        <pre data-tab="go" x-show="tab==='go'" style="display:none" class="whitespace-pre"><code
><span class="text-sky-400">req</span>, _ := http.<span class="text-amber-400">NewRequest</span>(<span class="text-emerald-400">"GET"</span>,
    <span class="text-emerald-400">"https://rdaplook.com/api/v1/domain/google.com"</span>, <span class="text-purple-400">nil</span>)
<span class="text-sky-400">req</span>.Header.<span class="text-amber-400">Set</span>(<span class="text-emerald-400">"X-API-Key"</span>, <span class="text-emerald-400">"your_api_key"</span>)

client := &http.Client{}
<span class="text-sky-400">resp</span>, _ := client.<span class="text-amber-400">Do</span>(<span class="text-sky-400">req</span>)
<span class="text-purple-400">defer</span> <span class="text-sky-400">resp</span>.Body.<span class="text-amber-400">Close</span>()

<span class="text-purple-400">var</span> domain <span class="text-purple-400">map</span>[<span class="text-purple-400">string</span>]<span class="text-purple-400">any</span>
json.<span class="text-amber-400">NewDecoder</span>(<span class="text-sky-400">resp</span>.Body).<span class="text-amber-400">Decode</span>(&domain)
fmt.<span class="text-amber-400">Println</span>(domain[<span class="text-emerald-400">"registrar"</span>])</code></pre>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Response Viewer ──────────────────────────────────────────────────── --}}
    <section class="py-16 px-4 sm:px-6 border-t border-[#e4e4e7] dark:border-[#1f1f1f]">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                {{-- Right col: description --}}
                <div class="lg:order-2">
                    <p class="text-xs font-medium text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">Live data · google.com</p>
                    <h2 class="text-3xl font-semibold tracking-tight mb-4">Actual API responses</h2>
                    <p class="text-[#71717a] leading-relaxed mb-8">
                        Every field is typed, documented, and consistent across all TLDs.
                        No vcard arrays. No nested surprises. What you see here is exactly what your code receives.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 text-sm">
                            <span class="shrink-0 mt-0.5 px-1.5 py-0.5 text-[10px] font-mono font-medium bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 rounded">GET</span>
                            <span class="text-[#71717a]"><code class="font-mono text-xs text-[#52525b] dark:text-[#a1a1aa]">/api/v1/domain/{domain}</code> — full RDAP data, flat JSON</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm">
                            <span class="shrink-0 mt-0.5 px-1.5 py-0.5 text-[10px] font-mono font-medium bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 rounded">GET</span>
                            <span class="text-[#71717a]"><code class="font-mono text-xs text-[#52525b] dark:text-[#a1a1aa]">/api/v1/dns/{domain}</code> — A, MX, NS, TXT, CNAME, SOA</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm">
                            <span class="shrink-0 mt-0.5 px-1.5 py-0.5 text-[10px] font-mono font-medium bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 rounded">GET</span>
                            <span class="text-[#71717a]"><code class="font-mono text-xs text-[#52525b] dark:text-[#a1a1aa]">/api/v1/availability/{domain}</code> — registered or free</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm">
                            <span class="shrink-0 mt-0.5 px-1.5 py-0.5 text-[10px] font-mono font-medium bg-sky-50 dark:bg-sky-500/10 text-sky-700 dark:text-sky-400 border border-sky-200 dark:border-sky-500/20 rounded">POST</span>
                            <span class="text-[#71717a]"><code class="font-mono text-xs text-[#52525b] dark:text-[#a1a1aa]">/api/v1/bulk</code> — up to 20 domains in one call</span>
                        </li>
                    </ul>
                </div>

                {{-- Left col: response window --}}
                <div
                    class="lg:order-1"
                    x-data="{
                        tab: 'domain',
                        copied: false,
                        copy() {
                            const pre = this.$root.querySelector('pre[data-tab=' + this.tab + ']');
                            navigator.clipboard.writeText(pre.textContent.trim());
                            this.copied = true;
                            setTimeout(() => this.copied = false, 2000);
                        }
                    }"
                >
                    <div class="rounded-xl overflow-hidden shadow-2xl border border-[#252525]">

                        {{-- Chrome --}}
                        <div class="bg-[#1c1c1c] px-4 py-3 flex items-center gap-3 border-b border-[#2a2a2a]">
                            <div class="flex gap-1.5 shrink-0">
                                <div class="w-3 h-3 rounded-full bg-[#ff5f57]"></div>
                                <div class="w-3 h-3 rounded-full bg-[#febc2e]"></div>
                                <div class="w-3 h-3 rounded-full bg-[#28c840]"></div>
                            </div>

                            <div class="editor-scroll flex gap-0.5 overflow-x-auto flex-1 min-w-0">
                                @foreach([
                                    ['domain',       'GET',  '/domain',       '#6366f1'],
                                    ['dns',          'GET',  '/dns',          '#22d3ee'],
                                    ['availability', 'GET',  '/availability', '#22c55e'],
                                    ['bulk',         'POST', '/bulk',         '#f59e0b'],
                                ] as [$key, $method, $path, $color])
                                <button
                                    @click="tab = '{{ $key }}'"
                                    :class="tab === '{{ $key }}' ? 'bg-[#2a2a2a] text-[#f4f4f5]' : 'text-[#71717a] hover:text-[#a1a1aa] hover:bg-[#222]'"
                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs rounded-md transition-colors whitespace-nowrap shrink-0"
                                >
                                    <span class="text-[10px] font-mono font-bold" style="color:{{ $color }}">{{ $method }}</span>
                                    <span>{{ $path }}</span>
                                </button>
                                @endforeach
                            </div>

                            <button
                                @click="copy()"
                                class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 text-xs text-[#71717a] hover:text-[#f4f4f5] bg-[#252525] hover:bg-[#2a2a2a] border border-[#333] rounded-md transition-colors"
                            >
                                <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <svg x-show="copied" style="display:none" class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                            </button>
                        </div>

                        {{-- Response body --}}
                        <div class="editor-scroll bg-[#0d0d0d] overflow-auto font-mono text-[12.5px] leading-relaxed text-[#a1a1aa]" style="max-height:480px">

                            {{-- GET /domain --}}
                            <pre data-tab="domain" x-show="tab==='domain'" class="whitespace-pre p-5"><code
>{
  <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"google.com"</span>,
  <span class="text-sky-400">"registrar"</span>: {
    <span class="text-sky-400">"name"</span>: <span class="text-emerald-400">"MarkMonitor Inc."</span>,
    <span class="text-sky-400">"iana_id"</span>: <span class="text-emerald-400">"292"</span>,
    <span class="text-sky-400">"url"</span>: <span class="text-emerald-400">"http://www.markmonitor.com"</span>
  },
  <span class="text-sky-400">"dates"</span>: {
    <span class="text-sky-400">"registered"</span>: <span class="text-emerald-400">"1997-09-15T04:00:00Z"</span>,
    <span class="text-sky-400">"updated"</span>:    <span class="text-emerald-400">"2019-09-09T15:39:04Z"</span>,
    <span class="text-sky-400">"expires"</span>:    <span class="text-emerald-400">"2028-09-14T04:00:00Z"</span>
  },
  <span class="text-sky-400">"nameservers"</span>: [
    <span class="text-emerald-400">"ns1.google.com"</span>,
    <span class="text-emerald-400">"ns2.google.com"</span>,
    <span class="text-emerald-400">"ns3.google.com"</span>,
    <span class="text-emerald-400">"ns4.google.com"</span>
  ],
  <span class="text-sky-400">"status"</span>: [
    <span class="text-emerald-400">"client delete prohibited"</span>,
    <span class="text-emerald-400">"client transfer prohibited"</span>,
    <span class="text-emerald-400">"client update prohibited"</span>,
    <span class="text-emerald-400">"server delete prohibited"</span>,
    <span class="text-emerald-400">"server transfer prohibited"</span>,
    <span class="text-emerald-400">"server update prohibited"</span>
  ],
  <span class="text-sky-400">"dnssec"</span>: <span class="text-red-400">false</span>
}</code></pre>

                            {{-- GET /dns --}}
                            <pre data-tab="dns" x-show="tab==='dns'" style="display:none" class="whitespace-pre p-5"><code
>{
  <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"google.com"</span>,
  <span class="text-sky-400">"records"</span>: {
    <span class="text-sky-400">"A"</span>: [
      { <span class="text-sky-400">"ip"</span>: <span class="text-emerald-400">"142.250.4.113"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">79</span> },
      { <span class="text-sky-400">"ip"</span>: <span class="text-emerald-400">"142.250.4.101"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">79</span> },
      { <span class="text-sky-400">"ip"</span>: <span class="text-emerald-400">"142.250.4.139"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">79</span> },
      { <span class="text-sky-400">"ip"</span>: <span class="text-emerald-400">"142.250.4.100"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">79</span> },
      { <span class="text-sky-400">"ip"</span>: <span class="text-emerald-400">"142.250.4.102"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">79</span> },
      { <span class="text-sky-400">"ip"</span>: <span class="text-emerald-400">"142.250.4.138"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">79</span> }
    ],
    <span class="text-sky-400">"MX"</span>: [
      { <span class="text-sky-400">"priority"</span>: <span class="text-amber-400">10</span>, <span class="text-sky-400">"target"</span>: <span class="text-emerald-400">"smtp.google.com"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">273</span> }
    ],
    <span class="text-sky-400">"NS"</span>: [
      { <span class="text-sky-400">"target"</span>: <span class="text-emerald-400">"ns1.google.com"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">152939</span> },
      { <span class="text-sky-400">"target"</span>: <span class="text-emerald-400">"ns2.google.com"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">152939</span> },
      { <span class="text-sky-400">"target"</span>: <span class="text-emerald-400">"ns3.google.com"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">152939</span> },
      { <span class="text-sky-400">"target"</span>: <span class="text-emerald-400">"ns4.google.com"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">152939</span> }
    ],
    <span class="text-sky-400">"TXT"</span>: [
      { <span class="text-sky-400">"txt"</span>: <span class="text-emerald-400">"v=spf1 include:_spf.google.com ~all"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">300</span> },
      { <span class="text-sky-400">"txt"</span>: <span class="text-emerald-400">"facebook-domain-verification=22rm551cu4k0ab0bxsw536tlds4h95"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">300</span> },
      { <span class="text-sky-400">"txt"</span>: <span class="text-emerald-400">"apple-domain-verification=30afIBcvSuDV2PLX"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">300</span> },
      { <span class="text-sky-400">"txt"</span>: <span class="text-emerald-400">"MS=E4A68B9AB2BB9670BCE15412F62916164C0B20BB"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">300</span> },
      { <span class="text-sky-400">"txt"</span>: <span class="text-emerald-400">"docusign=05958488-4752-4ef2-95eb-aa7ba8a3bd0e"</span>, <span class="text-sky-400">"ttl"</span>: <span class="text-amber-400">300</span> }
    ]
  }
}</code></pre>

                            {{-- GET /availability --}}
                            <pre data-tab="availability" x-show="tab==='availability'" style="display:none" class="whitespace-pre p-5"><code
>{
  <span class="text-sky-400">"domain"</span>:     <span class="text-emerald-400">"google.com"</span>,
  <span class="text-sky-400">"registered"</span>: <span class="text-green-400">true</span>,
  <span class="text-sky-400">"expires"</span>:    <span class="text-emerald-400">"2028-09-14T04:00:00Z"</span>,
  <span class="text-sky-400">"checked_at"</span>: <span class="text-emerald-400">"2026-05-18T11:08:22+00:00"</span>
}</code></pre>

                            {{-- POST /bulk --}}
                            <pre data-tab="bulk" x-show="tab==='bulk'" style="display:none" class="whitespace-pre p-5"><code
>{
  <span class="text-sky-400">"domains"</span>: [
    { <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"google.com"</span>, <span class="text-sky-400">"registered"</span>: <span class="text-green-400">true</span>,  <span class="text-sky-400">"expires"</span>: <span class="text-emerald-400">"2028-09-14T04:00:00Z"</span> },
    { <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"google.net"</span>, <span class="text-sky-400">"registered"</span>: <span class="text-green-400">true</span>,  <span class="text-sky-400">"expires"</span>: <span class="text-emerald-400">"2027-03-15T04:00:00Z"</span> },
    { <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"google.org"</span>, <span class="text-sky-400">"registered"</span>: <span class="text-green-400">true</span>,  <span class="text-sky-400">"expires"</span>: <span class="text-emerald-400">"2026-10-20T04:00:00Z"</span> },
    { <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"google.io"</span>,  <span class="text-sky-400">"registered"</span>: <span class="text-red-400">false</span>, <span class="text-sky-400">"expires"</span>: <span class="text-purple-400">null</span> },
    { <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"google.dev"</span>, <span class="text-sky-400">"registered"</span>: <span class="text-green-400">true</span>,  <span class="text-sky-400">"expires"</span>: <span class="text-emerald-400">"2027-06-13T22:30:20Z"</span> },
    { <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"google.app"</span>, <span class="text-sky-400">"registered"</span>: <span class="text-green-400">true</span>,  <span class="text-sky-400">"expires"</span>: <span class="text-emerald-400">"2027-03-29T16:02:13Z"</span> },
    { <span class="text-sky-400">"domain"</span>: <span class="text-emerald-400">"google.co"</span>,  <span class="text-sky-400">"registered"</span>: <span class="text-red-400">false</span>, <span class="text-sky-400">"expires"</span>: <span class="text-purple-400">null</span> }
  ]
}</code></pre>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── Pricing ────────────────────────────────────────────────────────── --}}
    <section id="pricing" class="py-16 px-4 sm:px-6 border-t border-[#e4e4e7] dark:border-[#1f1f1f]">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl font-semibold tracking-tight mb-2">Pricing</h2>
            <p class="text-[#71717a] text-sm mb-10">Start for free. Upgrade when you need to.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-start">

                <div class="bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg p-6 shadow-sm dark:shadow-none">
                    <p class="text-sm font-medium text-[#71717a] mb-1">Free</p>
                    <div class="flex items-end gap-1 mb-6">
                        <span class="text-3xl font-semibold">$0</span>
                        <span class="text-sm text-[#71717a] mb-1">/mo</span>
                    </div>
                    <ul class="space-y-3 text-sm mb-6">
                        <li class="flex justify-between"><span class="text-[#71717a]">Daily requests</span><span class="font-mono">2,000</span></li>
                        <li class="flex justify-between"><span class="text-[#71717a]">Bulk endpoint</span><span class="text-[#71717a]">No</span></li>
                        <li class="flex justify-between"><span class="text-[#71717a]">Support</span><span>Community</span></li>
                    </ul>
                    <a href="/register" class="block w-full text-center px-4 py-2 text-sm text-[#52525b] dark:text-[#a1a1aa] bg-[#f4f4f5] dark:bg-[#1f1f1f] hover:bg-[#e4e4e7] dark:hover:bg-[#2a2a2a] border border-[#e4e4e7] dark:border-[#2a2a2a] rounded-md transition-colors">Get started</a>
                </div>

                <div class="relative">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 text-xs font-medium bg-indigo-500 text-white rounded-full whitespace-nowrap z-10">most popular</div>
                    <div class="bg-white dark:bg-[#111111] border border-indigo-400 dark:border-indigo-500 rounded-lg p-6 pt-8 shadow-sm dark:shadow-none">
                        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-1">Starter</p>
                        <div class="flex items-end gap-1 mb-6">
                            <span class="text-3xl font-semibold">$4</span>
                            <span class="text-sm text-[#71717a] mb-1">/mo</span>
                        </div>
                        <ul class="space-y-3 text-sm mb-6">
                            <li class="flex justify-between"><span class="text-[#71717a]">Daily requests</span><span class="font-mono">50,000</span></li>
                            <li class="flex justify-between"><span class="text-[#71717a]">Bulk endpoint</span><span>Yes (20 domains)</span></li>
                            <li class="flex justify-between"><span class="text-[#71717a]">Support</span><span>Email</span></li>
                        </ul>
                        <a href="/register" class="block w-full text-center px-4 py-2 text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded-md transition-colors">Get started</a>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg p-6 shadow-sm dark:shadow-none">
                    <p class="text-sm font-medium text-[#71717a] mb-1">Pro</p>
                    <div class="flex items-end gap-1 mb-6">
                        <span class="text-3xl font-semibold">$14</span>
                        <span class="text-sm text-[#71717a] mb-1">/mo</span>
                    </div>
                    <ul class="space-y-3 text-sm mb-6">
                        <li class="flex justify-between"><span class="text-[#71717a]">Daily requests</span><span class="font-mono">500,000</span></li>
                        <li class="flex justify-between"><span class="text-[#71717a]">Bulk endpoint</span><span>Yes</span></li>
                        <li class="flex justify-between"><span class="text-[#71717a]">Support</span><span>Priority</span></li>
                    </ul>
                    <a href="/register" class="block w-full text-center px-4 py-2 text-sm text-[#52525b] dark:text-[#a1a1aa] bg-[#f4f4f5] dark:bg-[#1f1f1f] hover:bg-[#e4e4e7] dark:hover:bg-[#2a2a2a] border border-[#e4e4e7] dark:border-[#2a2a2a] rounded-md transition-colors">Get started</a>
                </div>

                <div class="bg-white dark:bg-[#111111] border border-[#e4e4e7] dark:border-[#1f1f1f] rounded-lg p-6 shadow-sm dark:shadow-none">
                    <p class="text-sm font-medium text-[#71717a] mb-1">Business</p>
                    <div class="flex items-end gap-1 mb-6">
                        <span class="text-3xl font-semibold">$39</span>
                        <span class="text-sm text-[#71717a] mb-1">/mo</span>
                    </div>
                    <ul class="space-y-3 text-sm mb-6">
                        <li class="flex justify-between"><span class="text-[#71717a]">Daily requests</span><span>Unlimited</span></li>
                        <li class="flex justify-between"><span class="text-[#71717a]">Bulk endpoint</span><span>Yes</span></li>
                        <li class="flex justify-between"><span class="text-[#71717a]">Support</span><span>Dedicated</span></li>
                    </ul>
                    <a href="/register" class="block w-full text-center px-4 py-2 text-sm text-[#52525b] dark:text-[#a1a1aa] bg-[#f4f4f5] dark:bg-[#1f1f1f] hover:bg-[#e4e4e7] dark:hover:bg-[#2a2a2a] border border-[#e4e4e7] dark:border-[#2a2a2a] rounded-md transition-colors">Get started</a>
                </div>

            </div>
        </div>
    </section>

</main>
@endsection
