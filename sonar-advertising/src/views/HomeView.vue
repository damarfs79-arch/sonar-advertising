<template>
  <div>
    <HeroSection />
    <StatsSection />
    <MarqueeStrip />
    <ServicesSection />
    
    <div ref="belowTheFoldTarget" class="min-h-[200px]">
      <template v-if="showBelowTheFold">
        <WhyUsSection />
        <PortfolioSection />
        <TestimonialsSection />
        <BlogSection />
        <CtaContactSection />
      </template>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, defineAsyncComponent } from 'vue'
import HeroSection from '@/components/sections/HeroSection.vue'
import StatsSection from '@/components/sections/StatsSection.vue'
import MarqueeStrip from '@/components/ui/MarqueeStrip.vue'
import ServicesSection from '@/components/sections/ServicesSection.vue'
import { useSeoMeta } from '@/composables/useSeoMeta'

useSeoMeta({
  title: 'Sonar Advertising | Jasa Pembuatan Huruf Timbul & Neon Box Jember & Jawa Timur',
  description: 'Spesialis pembuatan Huruf Timbul (Akrilik, Stainless, Galvanis), Neon Box Custom, Neon Flex, Papan Nama Toko, Fasad ACP & Billboard profesional di Jember, Kediri, Jawa Timur hingga Bali.',
  keywords: 'sonar advertising, jasa huruf timbul jember, neon box jember, signmaker jember, advertising jember, huruf timbul stainless, huruf timbul akrilik, neon flex custom, papan nama toko, fasad acp, billboard jawa timur, advertising kediri, reklame jember',
  jsonLd: {
    '@context': 'https://schema.org',
    '@graph': [
      {
        '@type': ['LocalBusiness', 'ProfessionalService'],
        '@id': 'https://sonaradvertising.com/#localbusiness',
        'name': 'Sonar Advertising',
        'alternateName': 'Sonar Advertising Signmaker & Promotion',
        'url': 'https://sonaradvertising.com',
        'logo': 'https://sonaradvertising.com/logo.png',
        'image': 'https://sonaradvertising.com/logo.png',
        'telephone': '+6285540000007',
        'priceRange': '$$',
        'address': {
          '@type': 'PostalAddress',
          'streetAddress': 'Kalimalang, Mayangan, Gumukmas',
          'addressLocality': 'Jember',
          'addressRegion': 'Jawa Timur',
          'postalCode': '68165',
          'addressCountry': 'ID'
        },
        'sameAs': [
          'https://www.instagram.com/sonaradv',
          'https://www.instagram.com/sonar.advertising',
          'https://www.tiktok.com/@sonar.adv',
          'https://www.facebook.com/share/195r6jnMJE/?mibextid=wwXIfr'
        ]
      },
      {
        '@type': ['LocalBusiness', 'ProfessionalService'],
        '@id': 'https://sonaradvertising.com/#workshop-kediri',
        'name': 'Sonar Advertising - Workshop Kediri',
        'telephone': '+6285540000007',
        'address': {
          '@type': 'PostalAddress',
          'streetAddress': 'Lingkungan Jl. Raya Kleco, RT.31/RW.07, Jamsaren, Kec. Pesantren',
          'addressLocality': 'Kediri',
          'addressRegion': 'Jawa Timur',
          'postalCode': '64132',
          'addressCountry': 'ID'
        }
      },
      {
        '@type': 'WebSite',
        '@id': 'https://sonaradvertising.com/#website',
        'url': 'https://sonaradvertising.com',
        'name': 'Sonar Advertising',
        'publisher': { '@id': 'https://sonaradvertising.com/#localbusiness' }
      }
    ]
  }
})

const WhyUsSection = defineAsyncComponent(() => import('@/components/sections/WhyUsSection.vue'))
const PortfolioSection = defineAsyncComponent(() => import('@/components/sections/PortfolioSection.vue'))
const TestimonialsSection = defineAsyncComponent(() => import('@/components/sections/TestimonialsSection.vue'))
const BlogSection = defineAsyncComponent(() => import('@/components/sections/BlogSection.vue'))
const CtaContactSection = defineAsyncComponent(() => import('@/components/sections/CtaContactSection.vue'))

const showBelowTheFold = ref(false)
const belowTheFoldTarget = ref(null)

onMounted(() => {
  if ('IntersectionObserver' in window && belowTheFoldTarget.value) {
    const observer = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting) {
        showBelowTheFold.value = true
        observer.disconnect()
      }
    }, { rootMargin: '300px' })
    observer.observe(belowTheFoldTarget.value)
  } else {
    showBelowTheFold.value = true
  }
})
</script>