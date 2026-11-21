<template>
  <div class="privacy-page">
    <div class="container mx-auto px-4 py-16">
      <h1 class="text-4xl font-bold mb-8">Privacy Policy</h1>
      <div class="prose max-w-none">
        <p class="text-gray-600 mb-6">Last updated: June 19, 2026</p>
        
        <section class="mb-8">
          <h2 class="text-2xl font-semibold mb-4">1. Information We Collect</h2>
          <p class="text-gray-700 leading-relaxed">
            We collect information that you provide directly to us, including name, email address, phone number, and any other information you choose to provide when contacting us or using our services.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold mb-4">2. How We Use Your Information</h2>
          <p class="text-gray-700 leading-relaxed mb-4">We use the information we collect to:</p>
          <ul class="list-disc pl-6 text-gray-700 space-y-2">
            <li>Provide, maintain, and improve our services</li>
            <li>Respond to your inquiries and requests</li>
            <li>Send you technical notices and support messages</li>
            <li>Communicate with you about products, services, and events</li>
          </ul>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold mb-4">3. Information Sharing</h2>
          <p class="text-gray-700 leading-relaxed">
            We do not share your personal information with third parties except as described in this policy or with your consent.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold mb-4">4. Contact Us</h2>
          <p class="text-gray-700 leading-relaxed">
            If you have any questions about this Privacy Policy, please contact us at sonaradvertising@gmail.com
          </p>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useSeoMeta } from '@/composables/useSeoMeta'

useSeoMeta({
  title: 'Kebijakan Privasi | Sonar Advertising',
  description: 'Kebijakan privasi dan perlindungan data pengguna layanan Sonar Advertising.'
})
</script>

<style scoped>
.privacy-page {
  min-height: 100vh;
  background: #fafafa;
}

.prose {
  color: #374151;
}

h1 {
  color: #111827;
}

h2 {
  color: #1f2937;
}
</style>
