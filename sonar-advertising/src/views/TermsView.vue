<template>
  <div class="terms-page">
    <div class="container mx-auto px-4 py-16">
      <h1 class="text-4xl font-bold mb-8">Terms of Service</h1>
      <div class="prose max-w-none">
        <p class="text-gray-600 mb-6">Effective: June 19, 2026</p>
        
        <section class="mb-8">
          <h2 class="text-2xl font-semibold mb-4">1. Acceptance of Terms</h2>
          <p class="text-gray-700 leading-relaxed">
            By accessing and using SONAR ADVERTISING's services, you agree to be bound by these Terms of Service and all applicable laws and regulations.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold mb-4">2. Services Description</h2>
          <p class="text-gray-700 leading-relaxed">
            SONAR ADVERTISING provides signage and branding solutions including neon boxes, letter signs, LED signage, and billboards. All services are subject to availability and may require consultation.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold mb-4">3. Quotes and Pricing</h2>
          <p class="text-gray-700 leading-relaxed">
            All quotes provided are estimates based on current information. Final pricing may vary based on actual requirements, materials, and project complexity.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold mb-4">4. Intellectual Property</h2>
          <p class="text-gray-700 leading-relaxed">
            All designs, concepts, and materials created by SONAR ADVERTISING remain our intellectual property until full payment is received. Upon completion of payment, clients receive usage rights for the delivered materials.
          </p>
        </section>

        <section class="mb-8">
          <h2 class="text-2xl font-semibold mb-4">5. Contact Information</h2>
          <p class="text-gray-700 leading-relaxed">
            For questions about these Terms, contact us at:<br>
            Email: sonaradvertising@gmail.com<br>
            WhatsApp: +62 855 4000 0007
          </p>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useSeoMeta } from '@/composables/useSeoMeta'

useSeoMeta({
  title: 'Syarat & Ketentuan | Sonar Advertising',
  description: 'Syarat dan ketentuan penggunaan layanan pembuatan signage dan reklame Sonar Advertising.'
})
</script>

<style scoped>
.terms-page {
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
