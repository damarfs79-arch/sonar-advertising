<template>
  <article class="bg-white shadow-md border border-neutral-200/80 rounded-2xl group overflow-hidden flex flex-col h-full hover:shadow-lg transition-all duration-300">
    <!-- Image container with fallback -->
    <div class="relative h-52 overflow-hidden bg-neutral-900">
      <img
        v-if="hasImage && !imgFailed"
        loading="lazy"
        :src="imageUrl"
        :alt="item.title"
        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
        @error="imgFailed = true"
      />
      <!-- Safe fallback illustration (No broken image icon) -->
      <div v-else class="w-full h-full flex flex-col items-center justify-center p-6 bg-gradient-to-br from-neutral-900 via-neutral-850 to-neutral-950 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-radial-gradient from-brand-orange/20 to-transparent opacity-60"></div>
        <div class="w-12 h-12 rounded-xl bg-brand-orange/10 border border-brand-orange/20 flex items-center justify-center text-brand-orange mb-3 z-10">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
          </svg>
        </div>
        <span class="text-xs font-bold text-neutral-300 z-10">{{ item.category || 'Portofolio' }}</span>
        <span class="text-[11px] text-neutral-500 z-10 mt-0.5">Sonar Advertising</span>
      </div>
      
      <!-- Overlay badge -->
      <div v-if="item.category" class="absolute top-3 left-3 z-20">
        <span class="bg-brand-orange text-white text-[11px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-md">
          {{ item.category }}
        </span>
      </div>
    </div>

    <div class="p-5 flex-1 flex flex-col justify-between">
      <div>
        <h3 class="font-display text-lg sm:text-xl font-bold text-neutral-900 mb-1 group-hover:text-brand-orange transition-colors duration-200 line-clamp-2">
          {{ item.title }}
        </h3>
        <p class="text-neutral-500 text-sm">
          {{ item.client || 'Klien' }} <span v-if="item.location">· {{ item.location }}</span> <span v-if="item.project_date">· {{ formatDate(item.project_date) }}</span>
        </p>
      </div>
      <p v-if="item.description" class="text-neutral-600 text-xs mt-3 line-clamp-2 leading-relaxed">
        {{ item.description }}
      </p>
    </div>
  </article>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  item: {
    type: Object,
    required: true
  }
})

const imgFailed = ref(false)

const rawPath = computed(() => {
  return props.item.main_image || props.item.image || ''
})

const hasImage = computed(() => !!rawPath.value && rawPath.value.trim() !== '')

const imageUrl = computed(() => {
  const path = rawPath.value
  if (!path) return ''
  if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('data:')) {
    return path
  }
  // Frontend static assets in public/ (e.g. /hero-bg.webp, /warm-brick-wall.jpg, /logo.png)
  if (path.startsWith('/') && !path.startsWith('/storage')) {
    return path
  }
  // Backend uploaded storage path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8008/api'
  const cleanPath = path.startsWith('/') ? path : '/' + path
  return apiBase.replace(/\/api\/?$/, '') + cleanPath
})

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(date)
}
</script>
