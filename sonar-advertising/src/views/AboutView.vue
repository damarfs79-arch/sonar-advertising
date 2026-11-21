<template>
  <div class="pt-24">
    <!-- Hero -->
    <section class="py-20 bg-white relative overflow-hidden">
      <!-- Light grid for subtle texture -->
      <div class="absolute inset-0 bg-grid opacity-10"></div>
      <div class="container mx-auto px-4 md:px-6 relative z-10 text-center">
        <SectionLabel text="Tentang Kami" />
        <h1 class="section-title mt-2 mb-6 text-brand-dark-2">
          Kami Adalah <span class="text-gradient">Sonar Advertising</span>
        </h1>
        <p class="text-brand-text-secondary text-sm sm:text-base lg:text-lg max-w-2xl mx-auto leading-relaxed">
          Lebih dari 5 tahun kami telah membantu ratusan bisnis di Indonesia menghadirkan identitas visual yang kuat melalui signage premium berkualitas tinggi.
        </p>
      </div>
    </section>

    <!-- Story -->
    <section class="py-20 bg-[#f8f9fa]">
      <div class="container mx-auto px-4 md:px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
          <div>
            <SectionLabel text="Cerita Kami" />
            <h2 class="section-title mb-6 text-brand-dark-2">Lahir dari Passion <span class="text-gradient">untuk Branding</span></h2>
            <p class="text-brand-text-secondary text-sm sm:text-base leading-relaxed mb-4">
              Sonar Advertising berdiri pada 2019 dengan satu misi sederhana: menghadirkan signage berkualitas premium yang sebelumnya hanya bisa diakses oleh brand-brand besar, kini bisa dinikmati oleh semua kalangan bisnis.
            </p>
            <p class="text-brand-text-secondary text-sm sm:text-base leading-relaxed">
              Dengan tim berpengalaman di bidang desain, fabrikasi, dan instalasi, kami telah menyelesaikan lebih dari 350 proyek di seluruh Indonesia — dari kedai kopi lokal hingga hotel bintang lima.
            </p>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div v-for="stat in stats" :key="stat.label" class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6 text-center transition-all hover:shadow-md">
              <p class="font-display text-4xl font-extrabold text-gradient mb-1">{{ stat.value }}</p>
              <p class="text-brand-text-secondary font-medium text-sm">{{ stat.label }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import SectionLabel from '@/components/ui/SectionLabel.vue'
import { useSeoMeta } from '@/composables/useSeoMeta'

useSeoMeta({
  title: 'Tentang Sonar Advertising | Signmaker & Reklame Jember & Kediri',
  description: 'Profil Sonar Advertising, spesialis jasa pembuatan huruf timbul, neon box custom, fasad ACP dan reklame promosi bisnis sejak 2019 dengan workshop di Jember dan Kediri.',
  keywords: 'tentang sonar advertising, profil sonar advertising, workshop reklame jember, signmaker kediri, vendor signage jawa timur'
})
const stats = [
  { value: '350+', label: 'Projects Completed' },
  { value: '100+', label: 'Happy Clients' },
  { value: '5+', label: 'Years Experience' },
  { value: '6', label: 'Jenis Layanan' },
]
</script>