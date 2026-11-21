<template>
  <section id="kontak" class="py-24 bg-brand-dark-2 scroll-mt-20" aria-labelledby="contact-heading">
    <!-- CTA Banner -->
    <div class="container mx-auto px-4 md:px-6 mb-20">
      <div class="bg-gradient-to-r from-brand-orange to-brand-orange-dark rounded-3xl p-10 md:p-16 text-center relative overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-grid opacity-15 pointer-events-none"></div>
        <div class="relative z-10 max-w-2xl mx-auto">
          <h2 class="font-sans text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
            Mulai Proyek Anda Hari Ini
          </h2>
          <p class="text-white/90 text-sm sm:text-base lg:text-lg mb-8 leading-relaxed">
            Konsultasikan kebutuhan branding dan signage Anda langsung dengan tim ahli kami secara gratis.
          </p>
          <a
            href="https://wa.me/6285540000007?text=Halo%20Sonar%20Advertising%2C%20saya%20ingin%20konsultasi%20gratis"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2.5 bg-white hover:bg-neutral-100 text-brand-orange font-bold text-sm sm:text-base px-8 py-4 rounded-xl transition-all duration-200 hover:scale-[1.02] active:scale-95 shadow-lg cursor-pointer"
          >
            <!-- WhatsApp SVG -->
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            Konsultasi Gratis Sekarang
          </a>
        </div>
      </div>
    </div>

    <!-- Contact Info -->
    <div class="container mx-auto px-4 md:px-6 max-w-5xl">
      <div class="text-center mb-12">
        <SectionLabel text="Hubungi Kami" class="justify-center" />
        <h2 id="contact-heading" class="section-title text-white">
          Informasi <span class="text-gradient">Kontak & Workshop</span>
        </h2>
      </div>

      <div class="grid md:grid-cols-3 gap-6 mb-12">
        <div
          v-for="info in contactInfo"
          :key="info.label"
          class="bg-neutral-900 border border-white/10 rounded-2xl p-6 text-center flex flex-col justify-between items-center transition-all duration-300 hover:border-brand-orange/30 shadow-xl"
        >
          <div class="flex flex-col items-center">
            <!-- SVG Icon Container -->
            <div class="w-13 h-13 bg-brand-orange/10 border border-brand-orange/20 rounded-xl flex items-center justify-center mb-4 text-brand-orange">
              <component :is="info.iconComponent" class="w-6 h-6" aria-hidden="true" />
            </div>
            <h3 class="text-white font-bold text-base sm:text-lg mb-2">{{ info.label }}</h3>
            <p class="text-gray-400 text-xs sm:text-sm leading-relaxed mb-4">{{ info.value }}</p>
          </div>
          
          <a
            v-if="info.link"
            :href="info.link"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2 bg-white/5 border border-white/10 hover:border-brand-orange hover:bg-brand-orange/10 text-white font-semibold text-xs px-4 py-2.5 rounded-xl transition-all duration-200 mt-2 cursor-pointer"
          >
            {{ info.linkLabel }}
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { h } from 'vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'

const MapPinIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z' }),
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z' })
])

const EnvelopeIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75' })
])

const contactInfo = [
  {
    iconComponent: MapPinIcon,
    label: 'Workshop Jember',
    value: 'Jl. Gajah Mada XX, Kaliwates, Kec. Kaliwates, Kabupaten Jember, Jawa Timur 68133',
    link: 'https://maps.app.goo.gl/NaSrUoXDWAqDSc1M9?g_st=iw',
    linkLabel: 'Buka di Google Maps'
  },
  {
    iconComponent: MapPinIcon,
    label: 'Workshop Kediri',
    value: 'Lingkungan Jl. Raya Kleco, RT.31/RW.07, Jamsaren, Kec. Pesantren, Kota Kediri, Jawa Timur 64132',
    link: 'https://maps.google.com/?q=Lingkungan+Jl.+Raya+Kleco,+RT.31/RW.07,+Jamsaren,+Kec.+Pesantren,+Kota+Kediri,+Jawa+Timur+64132',
    linkLabel: 'Buka di Google Maps'
  },
  {
    iconComponent: EnvelopeIcon,
    label: 'Konsultasi Email',
    value: 'sonaradvertising@gmail.com',
    link: 'mailto:sonaradvertising@gmail.com',
    linkLabel: 'Kirim Email'
  }
]
</script>
