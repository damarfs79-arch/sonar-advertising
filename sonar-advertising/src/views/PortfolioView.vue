<template>
  <div class="pt-24 bg-[#F6F6F6] min-h-screen">
    <section class="py-20 bg-brand-dark">
      <div class="container mx-auto px-4 md:px-6 text-center">
        <SectionLabel text="Portfolio" />
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mt-4 mb-6">Karya <span class="text-gradient">Terbaik Kami</span></h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">Lihat berbagai karya dan proyek unggulan yang telah kami kerjakan untuk klien-klien kami.</p>
      </div>
    </section>
    
    <section class="py-24">
      <div class="container mx-auto px-4 md:px-6">
        <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full py-10">
          <SkeletonCard v-for="n in 4" :key="n" />
        </div>
        <div v-else-if="portfolio.length === 0" class="text-center text-gray-500 py-10">Belum ada karya portofolio.</div>
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <PortfolioCard
            v-for="item in portfolio"
            :key="item.id"
            :item="item"
          />
        </div>
      </div>
    </section>
    
    <CtaContactSection />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import SkeletonCard from '@/components/ui/SkeletonCard.vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'
import PortfolioCard from '@/components/ui/PortfolioCard.vue'
import CtaContactSection from '@/components/sections/CtaContactSection.vue'
import { portfolioService } from '@/services/api/portfolio.service'
import { useSeoMeta } from '@/composables/useSeoMeta'

useSeoMeta({
  title: 'Portofolio Signage & Huruf Timbul | Sonar Advertising',
  description: 'Galeri portofolio hasil karya pembuatan Huruf Timbul, Neon Box Custom, Papan Nama Toko, Fasad ACP, dan Reklame Sonar Advertising untuk berbagai klien di Indonesia.',
  keywords: 'portofolio huruf timbul, contoh neon box, foto reklame toko, proyek signage jember, hasil karya sonar advertising',
  jsonLd: {
    '@context': 'https://schema.org',
    '@type': 'CreativeWork',
    'name': 'Portofolio Signage & Reklame Sonar Advertising',
    'creator': {
      '@type': ['LocalBusiness', 'ProfessionalService'],
      'name': 'Sonar Advertising',
      'url': 'https://sonaradvertising.com',
      'sameAs': [
        'https://www.instagram.com/sonar.advertising',
        'https://www.instagram.com/sonaradv'
      ]
    }
  }
})

const portfolio = ref([])
const loading = ref(true)

const loadPortfolio = async () => {
  loading.value = true
  try {
    const response = await portfolioService.getAll({ is_active: 1 })
    let rawData = response.data.data
    if (rawData && typeof rawData === 'object' && !Array.isArray(rawData)) {
      rawData = rawData.data || []
    }
    portfolio.value = Array.isArray(rawData) ? rawData : []
  } catch (err) {
    console.error('Error loading portfolio:', err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadPortfolio()
})
</script>