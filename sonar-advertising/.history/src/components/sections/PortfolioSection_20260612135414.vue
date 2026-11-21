<template>
  <section class="py-24 bg-brand-dark" aria-labelledby="portfolio-heading">
    <div class="container mx-auto px-4 md:px-6">
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
        <div>
          <SectionLabel text="Portfolio" />
          <h2 id="portfolio-heading" class="section-title">
            Karya <span class="text-gradient">Terbaik Kami</span>
          </h2>
        </div>
        <RouterLink to="/portfolio" class="btn-outline text-sm self-start md:self-auto">
          Lihat Semua
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </RouterLink>
      </div>

      <!-- Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <PortfolioCard
          v-for="item in portfolio"
          :key="item.title"
          :item="item"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import SectionLabel from '@/components/ui/SectionLabel.vue'
import PortfolioCard from '@/components/ui/PortfolioCard.vue'

const portfolio = [
  {
    title: 'Grand Mirage Hotel',
    location: 'Jakarta Selatan',
    type: 'Huruf Timbul Brass',
    category: 'Huruf Timbul',
    bg: 'bg-gradient-to-br from-amber-900/80 via-amber-800/60 to-brand-dark-4'
  },
  {
    title: 'The Boutique Hub',
    location: 'Bandung',
    type: 'Acrylic Signage',
    category: 'Acrylic',
    bg: 'bg-gradient-to-br from-blue-900/80 via-blue-800/60 to-brand-dark-4'
  },
  {
    title: 'Digital Flow Studio',
    location: 'Tangerang',
    type: 'Neon Flex Custom',
    category: 'Neon Flex',
    bg: 'bg-gradient-to-br from-orange-900/80 via-brand-orange/40 to-brand-dark-4'
  },
  {
    title: 'Skyline Mall',
    location: 'Surabaya',
    type: 'Billboard Reklame',
    category: 'Billboard',
    bg: 'bg-gradient-to-br from-green-900/80 via-green-800/60 to-brand-dark-4'
  },
  {
    title: 'Nusantara Bank',
    location: 'Jakarta Pusat',
    type: 'Neon Box Premium',
    category: 'Neon Box',
    bg: 'bg-gradient-to-br from-purple-900/80 via-purple-800/60 to-brand-dark-4'
  },
  {
    title: 'Kopi Nusantara',
    location: 'Yogyakarta',
    type: 'LED Display + Facad',
    category: 'LED Display',
    bg: 'bg-gradient-to-br from-rose-900/80 via-rose-800/60 to-brand-dark-4'
  },
]
</script>