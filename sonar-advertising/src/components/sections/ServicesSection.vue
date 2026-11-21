<template>
  <section class="py-24 bg-white" aria-labelledby="services-heading">
    <div class="container mx-auto px-4 md:px-6">
      <!-- Header -->
      <div class="text-center mb-14">
        <SectionLabel text="Layanan Kami" class="justify-center" />
        <h2 id="services-heading" class="section-title text-brand-text-primary">
          Solusi Advertising <span class="text-gradient">Terlengkap</span>
        </h2>
        <p class="text-gray-600 text-sm sm:text-base max-w-xl mx-auto mt-3">
          Koleksi layanan signage dan reklame profesional dengan standar presisi tinggi dan material tahan cuaca.
        </p>
      </div>

      <!-- Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <ServiceCard
          v-for="service in services"
          :key="service.name"
          :service="service"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { h } from 'vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'
import ServiceCard from '@/components/ui/ServiceCard.vue'

// Clean SVG Icons for Services
const NeonBoxIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.516 0c.85.493 1.508 1.333 1.508 2.316V18' })
])

const HurufTimbulIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9' })
])

const AcrylicIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z' })
])

const BillboardIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M2.25 7.125C2.25 6.504 2.754 6 3.375 6h17.25c.621 0 1.125.504 1.125 1.125v7.5c0 .621-.504 1.125-1.125 1.125H3.375A1.125 1.125 0 012.25 14.625v-7.5zM6 15.75v4.5m12-4.5v4.5' })
])

const NeonFlexIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z' })
])

const FacadAcpIcon = () => h('svg', { fill: 'none', stroke: 'currentColor', 'stroke-width': '2', viewBox: '0 0 24 24' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21' })
])

const services = [
  {
    iconComponent: NeonBoxIcon,
    name: 'Neon Box',
    description: 'Visualisasi brand yang menyala 24 jam dengan material akrilik atau backlite berkualitas tinggi.',
  },
  {
    iconComponent: HurufTimbulIcon,
    name: 'Huruf Timbul',
    description: 'Efek 3D eksklusif menggunakan Galvanis, Stainless Steel, Kuningan, atau Akrilik untuk kesan mewah.',
  },
  {
    iconComponent: AcrylicIcon,
    name: 'Acrylic Signage',
    description: 'Papan informasi dan dekorasi ruangan dengan teknik cutting laser presisi tinggi.',
  },
  {
    iconComponent: BillboardIcon,
    name: 'Billboard & Pylon Sign',
    description: 'Media promosi luar ruang skala besar dengan struktur rangka besi yang kokoh, berizin, dan aman.',
  },
  {
    iconComponent: NeonFlexIcon,
    name: 'Neon Flex',
    description: 'Dekorasi modern fleksibel yang hemat energi, cocok untuk interior cafe, barbershop, atau kantor kekinian.',
  },
  {
    iconComponent: FacadAcpIcon,
    name: 'Fasad ACP Gedung',
    description: 'Cladding eksterior ruko dan gedung dengan aluminium composite panel untuk tampilan modern dan profesional.',
  },
]
</script>
