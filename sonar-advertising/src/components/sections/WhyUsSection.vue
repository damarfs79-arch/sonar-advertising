<template>
  <section class="py-24 bg-brand-dark-2 relative overflow-hidden" aria-labelledby="why-us-heading">
    <!-- Decorative subtle glow -->
    <div class="absolute -left-40 top-1/2 -translate-y-1/2 w-96 h-96 bg-brand-orange/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-4 md:px-6">
      <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
        <!-- Left: Text -->
        <div>
          <SectionLabel text="Keunggulan Kami" />
          <h2 id="why-us-heading" class="section-title text-white mb-6">
            Mengapa <span class="text-gradient">Sonar Advertising?</span>
          </h2>
          <p class="text-gray-300 text-sm sm:text-base leading-relaxed mb-10">
            Lebih dari sekadar produsen reklame, kami adalah mitra identitas visual yang memastikan signage brand Anda rapi, kokoh, dan berdaya pikat tinggi.
          </p>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div
              v-for="feature in features"
              :key="feature.title"
              class="bg-neutral-900 border border-white/10 rounded-2xl p-5 hover:border-brand-orange/30 transition-all duration-300"
            >
              <div class="w-10 h-10 bg-brand-orange/10 border border-brand-orange/20 rounded-xl flex items-center justify-center mb-3 text-brand-orange">
                <!-- SVG Icon -->
                <component :is="feature.iconComponent" class="w-5 h-5" aria-hidden="true" />
              </div>
              <h3 class="text-white font-bold text-sm sm:text-base mb-1.5">{{ feature.title }}</h3>
              <p class="text-gray-400 text-xs sm:text-sm leading-relaxed">{{ feature.desc }}</p>
            </div>
          </div>
        </div>

        <!-- Right: Visual Highlights (Strictly SVG icons, No emojis) -->
        <div class="relative">
          <div class="bg-neutral-900 border border-white/10 rounded-3xl p-7 md:p-8 relative overflow-hidden shadow-2xl">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-orange/5 via-transparent to-transparent pointer-events-none"></div>

            <div class="space-y-4 relative z-10">
              <!-- Item 1: Konsultasi & Desain Gratis -->
              <div class="flex items-center gap-4 p-4 bg-neutral-950/80 rounded-2xl border border-white/10">
                <div class="w-11 h-11 bg-emerald-500/15 border border-emerald-500/30 rounded-xl flex items-center justify-center text-emerald-400 shrink-0">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-white font-semibold text-sm">Konsultasi & Desain Gratis</p>
                  <p class="text-gray-400 text-xs">Simulasi visual 3D tanpa biaya tersembunyi</p>
                </div>
              </div>

              <!-- Item 2: Pengerjaan Tepat Waktu -->
              <div class="flex items-center gap-4 p-4 bg-neutral-950/80 rounded-2xl border border-white/10">
                <div class="w-11 h-11 bg-brand-orange/15 border border-brand-orange/30 rounded-xl flex items-center justify-center text-brand-orange shrink-0">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                  </svg>
                </div>
                <div>
                  <p class="text-white font-semibold text-sm">Pengerjaan Tepat Waktu</p>
                  <p class="text-gray-400 text-xs">Jadwal produksi terstruktur dan bergaransi</p>
                </div>
              </div>

              <!-- Item 3: Material & Konstruksi Bergaransi -->
              <div class="flex items-center gap-4 p-4 bg-neutral-950/80 rounded-2xl border border-white/10">
                <div class="w-11 h-11 bg-blue-500/15 border border-blue-500/30 rounded-xl flex items-center justify-center text-blue-400 shrink-0">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                  </svg>
                </div>
                <div>
                  <p class="text-white font-semibold text-sm">Garansi Material & Lampu LED</p>
                  <p class="text-gray-400 text-xs">Jaminan mutu material outdoor tahan cuaca</p>
                </div>
              </div>

              <!-- Item 4: Pemasangan Rapi & Presisi -->
              <div class="flex items-center gap-4 p-4 bg-neutral-950/80 rounded-2xl border border-white/10">
                <div class="w-11 h-11 bg-purple-500/15 border border-purple-500/30 rounded-xl flex items-center justify-center text-purple-400 shrink-0">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.07a4.5 4.5 0 004.486-6.32l-3.27 3.287a1.5 1.5 0 01-2.122-2.122l3.287-3.27a4.5 4.5 0 00-6.32 4.486c.118.58.094 1.193-.07 1.743" />
                  </svg>
                </div>
                <div>
                  <p class="text-white font-semibold text-sm">Pemasangan Rapi & Bergaransi</p>
                  <p class="text-gray-400 text-xs">Dikerjakan teknisi berpengalaman dengan safety standar</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { h } from 'vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'

// Inline SVG Icon Renderers
const ShieldCheckIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z' })
])

const SparklesIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z' })
])

const ClockIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z' })
])

const MapPinIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z' }),
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z' })
])

const features = [
  {
    iconComponent: ShieldCheckIcon,
    title: 'Material Berkualitas',
    desc: 'Stainless steel 304, akrilik murni, dan cat oven anti karat untuk ketahanan outdoor maksimal.'
  },
  {
    iconComponent: SparklesIcon,
    title: 'Free Desain & Mockup',
    desc: 'Konsultasi gratis serta pembuatan mockup 3D proporsional sesuai identitas brand Anda.'
  },
  {
    iconComponent: ClockIcon,
    title: 'Pengerjaan Cepat',
    desc: 'Didukung workshop sendiri dengan teknisi profesional untuk hasil presisi dan tepat waktu.'
  },
  {
    iconComponent: MapPinIcon,
    title: 'Survei Lokasi Gratis',
    desc: 'Layanan pengukuran dan survei langsung ke lokasi usaha Anda tanpa pungutan biaya.'
  },
]
</script>
