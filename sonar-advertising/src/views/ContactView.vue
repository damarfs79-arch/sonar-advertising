<template>
  <div class="pt-24 bg-brand-dark min-h-screen">
    <section class="pt-20 pb-10">
      <div class="container mx-auto px-4 md:px-6 text-center">
        <SectionLabel text="Kontak" />
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mt-4 mb-6">Hubungi <span class="text-gradient">Tim Kami</span></h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">Kami siap berdiskusi untuk mewujudkan visualisasi branding terbaik untuk bisnis Anda.</p>
      </div>
    </section>
    <CtaContactSection class="!pt-10" />
  </div>
</template>

<script setup>
import SectionLabel from '@/components/ui/SectionLabel.vue'
import CtaContactSection from '@/components/sections/CtaContactSection.vue'
import { useSeoMeta } from '@/composables/useSeoMeta'

useSeoMeta({
  title: 'Hubungi Kami | Konsultasi & Survey Reklame Sonar Advertising',
  description: 'Konsultasikan kebutuhan pembuatan Huruf Timbul, Neon Box, Papan Nama, dan Fasad ACP secara gratis. Hubungi workshop Sonar Advertising di Jember & Kediri via WhatsApp 0855-4000-0007.',
  keywords: 'kontak sonar advertising, alamat workshop sonar advertising jember, whatsapp sonar advertising, nomor telepon reklame jember, konsultasi neon box gratis'
})
</script>