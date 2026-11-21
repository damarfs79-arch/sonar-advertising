<template>
  <article class="bg-white shadow-md border border-black/5 rounded-2xl group overflow-hidden">
    <!-- Image placeholder with gradient -->
    <div class="relative h-52 overflow-hidden bg-neutral-900">
      <img loading="lazy"
        v-if="item.main_image || item.image"
        :src="getImageUrl(item.main_image || item.image)"
        :alt="item.title"
        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
      />
      <div v-else class="w-full h-full bg-gradient-to-br from-brand-orange/20 to-neutral-800"></div>
      
      <!-- Overlay badge -->
      <div v-if="item.category" class="absolute top-3 left-3">
        <span class="bg-brand-orange text-white text-xs font-semibold px-2.5 py-1 rounded-full uppercase tracking-wide shadow-md">
          {{ item.category }}
        </span>
      </div>
    </div>

    <div class="p-5">
      <h3 class="font-display text-lg sm:text-xl font-bold text-brand-text-primary mb-1 group-hover:text-brand-orange transition-colors duration-200">
        {{ item.title }}
      </h3>
      <p class="text-brand-text-secondary text-sm sm:text-base">{{ item.client || 'Client' }} <span v-if="item.project_date">· {{ formatDate(item.project_date) }}</span></p>
    </div>
  </article>
</template>

<script setup>
defineProps({
  item: {
    type: Object,
    required: true
  }
})

const getImageUrl = (path) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8008/api'
  return apiBase.replace('/api', '') + path
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long' }).format(date)
}
</script> 