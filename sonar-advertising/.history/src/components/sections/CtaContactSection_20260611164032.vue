<template>
  <section class="py-24 bg-brand-dark-2" aria-labelledby="contact-heading">
    <!-- CTA Banner -->
    <div class="container mx-auto px-4 md:px-6 mb-20">
      <div class="bg-gradient-to-r from-brand-orange to-brand-orange-dark rounded-3xl p-10 md:p-16 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-grid opacity-20 pointer-events-none"></div>
        <div class="relative z-10">
          <h2 class="font-display text-4xl md:text-5xl font-extrabold text-white mb-4">
            Mulai Proyek Anda Hari Ini
          </h2>
          <p class="text-white/80 text-lg mb-8 max-w-xl mx-auto">
            Konsultasikan kebutuhan branding Anda dengan tim ahli kami secara gratis.
          </p>
          <a
            href="https://wa.me/6285540000007?text=Halo%2C%20saya%20ingin%20konsultasi%20gratis"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2 bg-white text-brand-orange font-bold px-8 py-4 rounded-xl hover:bg-white/90 transition-all duration-200 hover:scale-105 active:scale-95"
          >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Konsultasi Gratis Sekarang
          </a>
        </div>
      </div>
    </div>

    <!-- Contact Form + Info -->
    <div class="container mx-auto px-4 md:px-6">
      <div class="grid lg:grid-cols-2 gap-12">
        <!-- Form -->
        <div>
          <SectionLabel text="Hubungi Kami" />
          <h2 id="contact-heading" class="section-title mb-8">
            Kirim <span class="text-gradient">Pesan</span>
          </h2>

          <form @submit.prevent="handleSubmit" class="space-y-4" novalidate>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="name" class="block text-sm font-medium text-brand-gray-light mb-2">Nama Lengkap</label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  placeholder="John Doe"
                  required
                  class="w-full bg-brand-dark-3 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-brand-gray text-sm focus:outline-none focus:border-brand-orange transition-colors duration-200"
                />
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-brand-gray-light mb-2">Alamat Email</label>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  placeholder="you@example.com"
                  required
                  class="w-full bg-brand-dark-3 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-brand-gray text-sm focus:outline-none focus:border-brand-orange transition-colors duration-200"
                />
              </div>
            </div>

            <div>
              <label for="subject" class="block text-sm font-medium text-brand-gray-light mb-2">Subjek Layanan</label>
              <input
                id="subject"
                v-model="form.subject"
                type="text"
                placeholder="Contoh: Huruf Timbul"
                class="w-full bg-brand-dark-3 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-brand-gray text-sm focus:outline-none focus:border-brand-orange transition-colors duration-200"
              />
            </div>

            <div>
              <label for="message" class="block text-sm font-medium text-brand-gray-light mb-2">Pesan Anda</label>
              <textarea
                id="message"
                v-model="form.message"
                rows="5"
                placeholder="Ceritakan kebutuhan signage Anda..."
                required
                class="w-full bg-brand-dark-3 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-brand-gray text-sm focus:outline-none focus:border-brand-orange transition-colors duration-200 resize-none"
              ></textarea>
            </div>

            <button
              type="submit"
              :disabled="sending"
              class="btn-primary w-full justify-center py-4 text-base disabled:opacity-60 disabled:cursor-not-allowed"
            >
              {{ sending ? 'Mengirim...' : 'Kirim Pesan' }}
            </button>

            <p v-if="sent" class="text-green-400 text-sm text-center">✓ Pesan berhasil dikirim! Kami akan segera menghubungi Anda.</p>
          </form>
        </div>

        <!-- Info -->
        <div class="space-y-6">
          <div
            v-for="info in contactInfo"
            :key="info.label"
            class="flex gap-5 items-start"
          >
            <div class="w-12 h-12 bg-transparent border border-white/10 rounded-full flex items-center justify-center shrink-0">
              <span class="text-xl" aria-hidden="true">{{ info.icon }}</span>
            </div>
            <div class="pt-1">
              <p class="text-white font-medium mb-0.5">{{ info.value }}</p>
              <a
                v-if="info.link"
                :href="info.link"
                target="_blank"
                rel="noopener noreferrer"
                class="text-brand-orange text-sm hover:underline"
              >
                {{ info.linkLabel }}
              </a>
            </div>
          </div>

          <!-- Social Media Icons (matching screenshot style) -->
          <div class="flex items-center gap-3 pt-2">
            <!-- Facebook -->
            <a href="#" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full flex items-center justify-center bg-[#0d282d] hover:bg-brand-orange text-white transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
            </a>
            <!-- Twitter / X -->
            <a href="#" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full flex items-center justify-center bg-[#0d282d] hover:bg-brand-orange text-white transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06c0 2.39 1.705 4.376 3.946 4.827a4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
            </a>
            <!-- Instagram -->
            <a href="https://instagram.com/sonaradvertising" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full flex items-center justify-center bg-[#0d282d] hover:bg-brand-orange text-white transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
            </a>
            <!-- TikTok -->
            <a href="https://tiktok.com/@sonaradvertising" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full flex items-center justify-center bg-[#0d282d] hover:bg-brand-orange text-white transition-colors duration-300">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
            </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'

const form = ref({ name: '', email: '', subject: '', message: '' })
const sending = ref(false)
const sent = ref(false)

async function handleSubmit() {
  sending.value = true
  await new Promise(r => setTimeout(r, 1200))
  sending.value = false
  sent.value = true
  form.value = { name: '', email: '', subject: '', message: '' }
}

const contactInfo = [
  {
    icon: '📍',
    label: 'Workshop & Office',
    value: 'Jl. Advertising Utama No. 123, Jakarta Selatan, 12345',
    link: 'https://maps.google.com',
    linkLabel: 'Buka di Google Maps'
  },
  {
    icon: '💬',
    label: 'WhatsApp Business',
    value: '+62 855 4000 0007',
    link: 'https://wa.me/6285540000007',
    linkLabel: 'Chat Sekarang'
  },
  {
    icon: '✉️',
    label: 'Email Inquiry',
    value: 'hello@sonaradvertising.com',
    link: 'mailto:hello@sonaradvertising.com',
    linkLabel: 'Kirim Email'
  },
]
</script>