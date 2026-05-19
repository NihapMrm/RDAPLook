@extends('layouts.app')

@section('title', 'Privacy Policy — RDAPLook')
@section('meta_description', 'RDAPLook Privacy Policy. Learn how we collect, use, and protect your data when using the RDAPLook domain intelligence API.')

@section('content')
<main class="pt-32 pb-24 px-4 sm:px-6">
    <div class="max-w-3xl mx-auto">

        <a href="/" class="inline-flex items-center gap-1.5 text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to home
        </a>

        <h1 class="text-3xl font-semibold tracking-tight mb-2">Privacy Policy</h1>
        <p class="text-sm text-[#71717a] mb-10">Last updated: May 2025</p>

        <div class="prose prose-zinc dark:prose-invert max-w-none space-y-8 text-[#3f3f46] dark:text-[#a1a1aa] leading-relaxed">

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">1. Overview</h2>
                <p>RDAPLook ("we", "us", or "our") is committed to protecting your privacy. This Privacy Policy explains how we handle information when you use our website and API. API access is managed through RapidAPI, and their privacy policy also applies to account and billing data.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">2. Information We Collect</h2>
                <p>We collect minimal information necessary to operate the Service:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li><strong class="text-[#09090b] dark:text-[#f4f4f5]">API requests:</strong> Domain names submitted in lookup requests, timestamps, and IP addresses for rate limiting and abuse prevention</li>
                    <li><strong class="text-[#09090b] dark:text-[#f4f4f5]">Server logs:</strong> Standard web server logs including IP addresses, request paths, and response codes, retained for up to 30 days</li>
                    <li><strong class="text-[#09090b] dark:text-[#f4f4f5]">Analytics:</strong> Aggregate, anonymized usage statistics to monitor service health</li>
                </ul>
                <p class="mt-3">We do not collect personal information beyond what is inherent in standard HTTP requests. Account registration and billing are handled entirely by RapidAPI.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">3. How We Use Information</h2>
                <p>Information collected is used exclusively to:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>Process and respond to API requests</li>
                    <li>Enforce rate limits and prevent abuse</li>
                    <li>Monitor service availability and performance</li>
                    <li>Investigate security incidents</li>
                </ul>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">4. Data Sharing</h2>
                <p>We do not sell, rent, or share your personal data with third parties for marketing purposes. We may share data only in the following circumstances:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>When required by law or valid legal process</li>
                    <li>To protect the rights, property, or safety of RDAPLook or its users</li>
                    <li>With infrastructure providers (hosting, CDN) under data processing agreements, solely to deliver the Service</li>
                </ul>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">5. Public RDAP Data</h2>
                <p>Domain registration data returned by the API is sourced from publicly available RDAP registries. This data is not collected or stored by RDAPLook — it is retrieved in real time from authoritative sources and passed directly to you.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">6. Cookies</h2>
                <p>The RDAPLook website uses only a single functional item stored in <code class="text-xs font-mono bg-[#f4f4f5] dark:bg-[#1f1f1f] px-1 py-0.5 rounded">localStorage</code> to remember your light/dark theme preference. No tracking cookies or third-party cookies are set.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">7. Data Retention</h2>
                <p>Server logs are retained for up to 30 days for security and operational purposes, after which they are deleted. Rate-limiting counters stored in Redis expire automatically.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">8. Your Rights</h2>
                <p>Because we collect minimal identifiable data, most rights requests (access, deletion, portability) can be addressed by simply not using the Service. For questions or specific requests, please contact us via the RapidAPI platform or your API dashboard.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">9. Changes to This Policy</h2>
                <p>We may update this Privacy Policy from time to time. We will update the "Last updated" date at the top of this page. Continued use of the Service after changes constitutes acceptance of the updated policy.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">10. Contact</h2>
                <p>For privacy-related questions, please contact us through RapidAPI or the contact information in your API dashboard.</p>
            </section>

        </div>
    </div>
</main>
@endsection
