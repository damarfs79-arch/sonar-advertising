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
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <PortfolioCard
            v-for="item in displayPortfolio"
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
import { ref, computed, onMounted } from 'vue'
import SkeletonCard from '@/components/ui/SkeletonCard.vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'
import PortfolioCard from '@/components/ui/PortfolioCard.vue'
import CtaContactSection from '@/components/sections/CtaContactSection.vue'
import { portfolioService } from '@/services/api/portfolio.service'
import { useSeoMeta } from '@/composables/useSeoMeta'

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
  },
  {
    id: 'f4',
    title: 'Papan Nama Toko Plat Galvanis Cat Duco',
    category: 'Papan Nama',
    image: '/hero-bg.webp',
    client: 'Minimarket Barokah Mart',
    location: 'Jember',
    description: 'Papan nama toko plat galvanis tahan cuaca dengan cat duco mobil dan finishing clear coat glossy.'
  },
  {
    id: 'f5',
    title: 'Neon Flex Custom Interior Cafe',
    category: 'Neon Flex',
    image: '/warm-brick-wall.jpg',
    client: 'Senja Roastery & Eatery',
    location: 'Kediri',
    description: 'Instalasi neon flex silikon 12V untuk backdrop photobooth dengan cahaya warm white dan pink lembut.'
  },
  {
    id: 'f6',
    title: 'Billboard Rangka Baja 4x8 Meter',
    category: 'Billboard',
    image: '/hero-bg.png',
    client: 'Perumahan Grand Permata',
    location: 'Jember',
    description: 'Konstruksi billboard tiang ganda rangka baja pipa besi kokoh standar keamanan dinas pekerjaan umum.'
  }
]

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

const displayPortfolio = computed(() => {
  return portfolio.value.length > 0 ? portfolio.value : fallbackPortfolio
})

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