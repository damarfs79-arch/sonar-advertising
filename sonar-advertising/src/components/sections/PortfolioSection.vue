<template>
  <section class="py-24 bg-white" aria-labelledby="portfolio-heading">
    <div class="container mx-auto px-4 md:px-6">
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
        <div>
          <SectionLabel text="Portofolio" />
          <h2 id="portfolio-heading" class="section-title text-brand-text-primary">
            Karya <span class="text-gradient">Terbaik Kami</span>
          </h2>
          <p class="text-gray-600 text-sm sm:text-base mt-2">
            Dokumentasi proyek signage, huruf timbul, dan neon box yang telah kami selesaikan.
          </p>
        </div>
        <RouterLink
          to="/portfolio"
          class="border border-neutral-300 hover:border-brand-orange text-neutral-800 hover:text-brand-orange font-semibold px-6 py-2.5 rounded-xl transition-all duration-200 inline-flex items-center gap-2 text-sm self-start md:self-auto cursor-pointer"
        >
          Lihat Semua Portofolio
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </RouterLink>
      </div>

      <!-- Loading Skeleton -->
      <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full py-6">
        <SkeletonCard v-for="n in 3" :key="n" />
      </div>

      <!-- Portfolio Grid (Active CMS Data or Structured Fallback Showcase) -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <PortfolioCard
          v-for="item in displayPortfolio"
          :key="item.id"
          :item="item"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import SkeletonCard from '@/components/ui/SkeletonCard.vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'
import PortfolioCard from '@/components/ui/PortfolioCard.vue'
import { portfolioService } from '@/services/api/portfolio.service'

const portfolio = ref([])
const loading = ref(true)

// Structured fallback projects when database is empty
const fallbackPortfolio = [
  {
    id: 'f1',
    title: 'Huruf Timbul Stainless Backlit',
    category: 'Huruf Timbul',
    image: '/hero-bg.webp',
    client: 'Klinik Estetika Glow',
    location: 'Jember',
    description: 'Huruf timbul stainless steel 304 dengan pencahayaan LED warm white untuk estetika elegan.'
  },
  {
    id: 'f2',
    title: 'Neon Box Akrilik Bulat Dua Sisi',
    category: 'Neon Box',
    image: '/warm-brick-wall.jpg',
    client: 'Kopi Kenangan Sejahtera',
    location: 'Kediri',
    description: 'Neon box akrilik profil aluminium dengan stiker oracal tembus cahaya berdaya tahan tinggi.'
  },
  {
    id: 'f3',
    title: 'Fasad ACP & Signboard Ruko',
    category: 'Fasad ACP',
    image: '/hero-bg.png',
    client: 'Apotek Sahabat Medika',
    location: 'Banyuwangi',
    description: 'Renovasi fasad gedung ruko modern menggunakan ACP seven dan logo laser akrilik timbul.'
  }
]

const displayPortfolio = computed(() => {
  return portfolio.value.length > 0 ? portfolio.value : fallbackPortfolio
})

const loadPortfolio = async () => {
  loading.value = true
  try {
    const response = await portfolioService.getAll({ per_page: 6, is_active: 1 })
    let rawData = response?.data?.data
    if (rawData && typeof rawData === 'object' && !Array.isArray(rawData)) {
      rawData = rawData.data || []
    }
    portfolio.value = Array.isArray(rawData) ? rawData.slice(0, 6) : []
  } catch (err) {
    // If backend returns empty/error, keep empty and fallback will automatically render
    portfolio.value = []
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadPortfolio()
})
</script>
