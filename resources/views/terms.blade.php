@extends('layouts.app')

@section('title', 'Terms of Service — RDAPLook')
@section('meta_description', 'RDAPLook Terms of Service. Read the terms and conditions for using the RDAPLook domain intelligence API.')

@section('content')
<main class="pt-32 pb-24 px-4 sm:px-6">
    <div class="max-w-3xl mx-auto">

        <a href="/" class="inline-flex items-center gap-1.5 text-sm text-[#71717a] hover:text-[#09090b] dark:hover:text-[#f4f4f5] transition-colors mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to home
        </a>

        <h1 class="text-3xl font-semibold tracking-tight mb-2">Terms of Service</h1>
        <p class="text-sm text-[#71717a] mb-10">Last updated: May 2025</p>

        <div class="prose prose-zinc dark:prose-invert max-w-none space-y-8 text-[#3f3f46] dark:text-[#a1a1aa] leading-relaxed">

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">1. Acceptance of Terms</h2>
                <p>By accessing or using the RDAPLook API and website (collectively, the "Service"), you agree to be bound by these Terms of Service. If you do not agree to these terms, do not use the Service.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">2. Description of Service</h2>
                <p>RDAPLook provides a domain intelligence API powered by RDAP (Registration Data Access Protocol) and DNS lookups. The Service enables programmatic access to domain registration data, DNS records, and availability information.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">3. API Usage</h2>
                <p>Access to the RDAPLook API is provided through RapidAPI. By using the API you also agree to RapidAPI's terms of service. Free tier usage is subject to rate limits as described on the pricing page. We reserve the right to modify rate limits at any time.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">4. Acceptable Use</h2>
                <p>You agree not to use the Service to:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>Violate any applicable law or regulation</li>
                    <li>Infringe upon intellectual property rights of others</li>
                    <li>Conduct spam, phishing, or any form of fraud</li>
                    <li>Attempt to circumvent rate limits or access controls</li>
                    <li>Resell or redistribute API access without written permission</li>
                    <li>Engage in any activity that disrupts or degrades the Service</li>
                </ul>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">5. Data Accuracy</h2>
                <p>RDAPLook retrieves data from public RDAP registries and DNS servers. We do not guarantee the accuracy, completeness, or timeliness of the information returned. Domain registration data is provided by third-party registries and may be incomplete or delayed.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">6. Availability</h2>
                <p>We strive to maintain high uptime but do not guarantee uninterrupted access. The Service is provided "as is" without warranties of any kind, either express or implied. We reserve the right to modify, suspend, or discontinue the Service at any time.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">7. Limitation of Liability</h2>
                <p>To the fullest extent permitted by law, RDAPLook shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use of the Service, even if advised of the possibility of such damages.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">8. Changes to Terms</h2>
                <p>We may update these Terms of Service from time to time. Continued use of the Service after changes constitutes acceptance of the updated terms. We will update the "Last updated" date at the top of this page when changes are made.</p>
            </section>

            <section>
                <h2 class="text-lg font-semibold text-[#09090b] dark:text-[#f4f4f5] mb-3">9. Contact</h2>
                <p>For questions regarding these terms, please reach out via RapidAPI or the contact information listed in your API dashboard.</p>
            </section>

        </div>
    </div>
</main>
@endsection
