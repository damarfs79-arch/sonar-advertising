<template>
  <article class="bg-white rounded-2xl border border-neutral-200/90 hover:border-brand-orange/40 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between overflow-hidden group font-sans h-full">
    <div>
      <!-- Thumbnail Image Container -->
      <div class="relative h-48 w-full overflow-hidden bg-neutral-900">
        <img
          v-if="imgSrc && !imgFailed"
          :src="imgSrc"
          :alt="post.title"
          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
          loading="lazy"
          @error="handleImgError"
        />

        <!-- Fallback SVG Placeholder (When image fails or is absent) -->
        <div v-else class="w-full h-full bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900 flex flex-col items-center justify-center p-4 text-center">
          <div class="w-12 h-12 rounded-xl bg-brand-orange/15 border border-brand-orange/30 flex items-center justify-center text-brand-orange mb-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
          </div>
          <span class="text-xs font-semibold text-gray-300 uppercase tracking-wider">
            {{ post.category || 'Artikel & Tips' }}
          </span>
        </div>

        <!-- Category Badge -->
        <span 
          v-if="post.category" 
          class="absolute top-3 left-3 z-10 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-neutral-950/80 text-brand-orange border border-brand-orange/30 backdrop-blur-md shadow-sm"
        >
          {{ post.category }}
        </span>
      </div>

      <!-- Content -->
      <div class="p-5">
        <!-- Date Meta with SVG Calendar Icon -->
        <div class="flex items-center gap-1.5 text-neutral-400 text-xs mb-2.5">
          <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h14.25A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
          </svg>
          <time>{{ formatDate(post.published_at || post.created_at) }}</time>
        </div>

        <!-- Title -->
        <h3 class="font-bold text-base sm:text-lg text-neutral-900 group-hover:text-brand-orange transition-colors leading-snug line-clamp-2 mb-2">
          {{ post.title }}
        </h3>

        <!-- Summary -->
        <p class="text-neutral-600 text-xs sm:text-sm leading-relaxed line-clamp-2">
          {{ post.summary || cleanContent(post.content) }}
        </p>
      </div>
    </div>

    <!-- Action Link -->
    <div class="px-5 pb-5 pt-0">
      <RouterLink
        :to="'/blog/' + (post.slug || post.id)"
        class="inline-flex items-center gap-1.5 text-brand-orange hover:text-brand-orange-dark text-xs sm:text-sm font-semibold transition-colors duration-200 group/link"
      >
        <span>Baca Selengkapnya</span>
        <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover/link:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
        </svg>
      </RouterLink>
    </div>
  </article>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  post: {
    type: Object,
    required: true
  }
})

const imgFailed = ref(false)

const imgSrc = computed(() => {
  const raw = props.post.thumbnail || props.post.image
  if (!raw) return ''
  if (raw.startsWith('http')) return raw
  if (raw.startsWith('/storage/')) {
    const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8008/api'
    return apiBase.replace('/api', '') + raw
  }
  return raw
})

const handleImgError = (e) => {
  imgFailed.value = true
}

const cleanContent = (html) => {
  if (!html) return ''
  return html.replace(/<[^>]+>/g, '').substring(0, 110)
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'short', day: 'numeric' }).format(date)
}
</script>
