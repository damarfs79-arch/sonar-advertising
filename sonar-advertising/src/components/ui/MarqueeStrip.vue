<template>
  <div class="bg-brand-orange py-4 overflow-hidden border-y border-brand-orange-dark/30 select-none relative z-20" aria-hidden="true">
    <div class="flex whitespace-nowrap overflow-hidden">
      <!-- First copy -->
      <div class="flex items-center animate-marquee shrink-0">
        <span
          v-for="(item, index) in items"
          :key="`a-${index}`"
          class="flex items-center gap-3 px-6 text-white font-sans font-bold text-xs sm:text-sm tracking-wider uppercase"
        >
          <span class="w-1.5 h-1.5 bg-white/70 rounded-full shrink-0"></span>
          {{ item }}
        </span>
      </div>
      <!-- Second copy for seamless continuous loop -->
      <div class="flex items-center animate-marquee2 shrink-0">
        <span
          v-for="(item, index) in items"
          :key="`b-${index}`"
          class="flex items-center gap-3 px-6 text-white font-sans font-bold text-xs sm:text-sm tracking-wider uppercase"
        >
          <span class="w-1.5 h-1.5 bg-white/70 rounded-full shrink-0"></span>
          {{ item }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
const items = [
  'Spesialis Neon Box Akrilik',
  'Huruf Timbul Stainless & LED',
  'Free Desain & Konsultasi',
  'Survei Lokasi Gratis',
  'Pemasangan Rapi & Bergaransi',
  'Material Premium Standar Agency',
  'Fasad ACP Gedung & Ruko',
  'Pengerjaan Cepat & Tepat Waktu',
]
</script>
