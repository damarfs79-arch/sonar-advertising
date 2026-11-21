<template>
  <section class="py-24 bg-brand-dark" aria-labelledby="services-heading">
    <div class="container mx-auto px-4 md:px-6">
      <!-- Header -->
      <div class="text-center mb-14">
        <SectionLabel text="Layanan Kami" />
        <h2 id="services-heading" class="section-title">
          Solusi Advertising <span class="text-gradient">Terlengkap</span>
        </h2>
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
import SectionLabel from '@/components/ui/SectionLabel.vue'
import ServiceCard from '@/components/ui/ServiceCard.vue'

const services = [
  {
    icon: '🔆',
    name: 'Neon Box',
    description: 'Visualisasi brand yang menyala 24 jam dengan material akrilik atau backlite berkualitas tinggi.',
  },
  {
    icon: '🔠',
    name: 'Huruf Timbul',
    description: 'Efek 3D eksklusif menggunakan Galvanis, Stainless Steel, Kuningan, atau Akrilik untuk kesan mewah.',
  },
  {
    icon: '🪟',
    name: 'Acrylic Signage',
    description: 'Papan informasi dan dekorasi ruangan dengan teknik cutting laser presisi tinggi.',
  },
  {
    icon: '🏗️',
    name: 'Billboard',
    description: 'Media promosi luar ruang skala besar dengan struktur rangka besi yang kokoh dan aman.',
  },
  {
    icon: '💡',
    name: 'Neon Flex',
    description: 'Dekorasi modern fleksibel yang hemat energi, cocok untuk interior cafe atau kantor kekinian.',
  },
  {
    icon: '🏢',
    name: 'Facad Acp',
    description: 'Cladding eksterior gedung dengan aluminium composite panel untuk tampilan modern dan profesional.',
  },
]
</script>