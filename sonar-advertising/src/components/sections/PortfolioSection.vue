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

      <!-- Portfolio Grid (Active CMS Data) -->
      <div v-else-if="portfolio.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <PortfolioCard
          v-for="item in portfolio"
          :key="item.id"
          :item="item"
        />
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-16 bg-neutral-50 rounded-2xl border border-neutral-200/80">
        <div class="w-12 h-12 rounded-xl bg-brand-orange/10 border border-brand-orange/20 flex items-center justify-center text-brand-orange mx-auto mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
          </svg>
        </div>
        <p class="text-neutral-700 font-semibold">Belum Ada Proyek Portofolio</p>
        <p class="text-neutral-500 text-sm mt-1">Data proyek portofolio dapat ditambahkan melalui panel admin.</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import SkeletonCard from '@/components/ui/SkeletonCard.vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'
import PortfolioCard from '@/components/ui/PortfolioCard.vue'
import { portfolioService } from '@/services/api/portfolio.service'

const portfolio = ref([])
const loading = ref(true)

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
    portfolio.value = []
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadPortfolio()
})
</script>
