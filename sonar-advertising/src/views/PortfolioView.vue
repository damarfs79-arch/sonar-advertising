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
        <div v-else-if="portfolio.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <PortfolioCard
            v-for="item in portfolio"
            :key="item.id"
            :item="item"
          />
        </div>
        <div v-else class="text-center py-20 bg-white rounded-2xl border border-neutral-200">
          <div class="w-12 h-12 rounded-xl bg-brand-orange/10 border border-brand-orange/20 flex items-center justify-center text-brand-orange mx-auto mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
          </div>
          <p class="text-neutral-700 font-semibold">Belum Ada Karya Portofolio</p>
          <p class="text-neutral-500 text-sm mt-1">Data proyek portofolio dapat ditambahkan melalui panel admin.</p>
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
    let rawData = response?.data?.data
    if (rawData && typeof rawData === 'object' && !Array.isArray(rawData)) {
      rawData = rawData.data || []
    }
    portfolio.value = Array.isArray(rawData) && rawData.length > 0 ? rawData : []
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