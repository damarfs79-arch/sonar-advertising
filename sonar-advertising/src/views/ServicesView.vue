<template>
  <div class="pt-24 bg-[#F6F6F6] min-h-screen">
    <ServicesSection />
    <WhyUsSection />
    <CtaContactSection />
  </div>
</template>

<script setup>
import SectionLabel from '@/components/ui/SectionLabel.vue'
import ServicesSection from '@/components/sections/ServicesSection.vue'
import WhyUsSection from '@/components/sections/WhyUsSection.vue'
import CtaContactSection from '@/components/sections/CtaContactSection.vue'
import { useSeoMeta } from '@/composables/useSeoMeta'

useSeoMeta({
  title: 'Layanan Reklame & Signmaker | Sonar Advertising Jember',
  description: 'Layanan lengkap pembuatan Huruf Timbul 3D, Neon Box Custom, Neon Flex, Papan Nama Toko, Fasad ACP, dan Billboard dengan pengerjaan presisi dan bergaransi.',
  keywords: 'layanan reklame jember, jasa huruf timbul, bikin neon box akrilik, neon flex custom, pasang fasad acp, papan nama toko, billboard advertising, signmaker jawa timur',
  jsonLd: {
    '@context': 'https://schema.org',
    '@type': 'Service',
    'name': 'Jasa Signage, Huruf Timbul & Reklame Komersial',
    'provider': {
      '@type': ['LocalBusiness', 'ProfessionalService'],
      'name': 'Sonar Advertising',
      'url': 'https://sonaradv.fsss.my.id',
      'telephone': '+6285540000007',
      'sameAs': [
        'https://www.instagram.com/sonar.advertising',
        'https://www.instagram.com/sonaradv'
      ]
    },
    'serviceType': 'Signage & Advertising Fabrication',
    'areaServed': ['Jember', 'Kediri', 'Surabaya', 'Banyuwangi', 'Jawa Timur', 'Bali'],
    'hasOfferCatalog': {
      '@type': 'OfferCatalog',
      'name': 'Katalog Layanan Signage Sonar Advertising',
      'itemListElement': [
        { '@type': 'Offer', 'itemOffered': { '@type': 'Service', 'name': 'Huruf Timbul (Stainless, Akrilik LED, Galvanis, Kuningan)' } },
        { '@type': 'Offer', 'itemOffered': { '@type': 'Service', 'name': 'Neon Box (Akrilik Custom, Backlite, Dua Sisi)' } },
        { '@type': 'Offer', 'itemOffered': { '@type': 'Service', 'name': 'Neon Flex LED Custom Estetik' } },
        { '@type': 'Offer', 'itemOffered': { '@type': 'Service', 'name': 'Papan Nama Toko, Plang Kantor & Instansi' } },
        { '@type': 'Offer', 'itemOffered': { '@type': 'Service', 'name': 'Fasad ACP (Aluminium Composite Panel) & Laser Cutting' } },
        { '@type': 'Offer', 'itemOffered': { '@type': 'Service', 'name': 'Billboard, Pylon Sign & Konstruksi Reklame Luar Ruang' } }
      ]
    }
  }
})
</script>