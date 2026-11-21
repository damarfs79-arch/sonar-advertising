<template>
  <section class="py-24 bg-neutral-50 relative overflow-hidden" aria-labelledby="testimonials-heading">
    <!-- Background accents -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[350px] bg-brand-orange/5 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="container mx-auto px-4 md:px-6 relative z-10">
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-4">
        <div>
          <SectionLabel text="Bukti Kepuasan Klien" />
          <h2 id="testimonials-heading" class="section-title text-brand-text-primary">
            Apa Kata <span class="text-gradient">Klien Kami?</span>
          </h2>
          <p class="text-gray-600 text-sm sm:text-base mt-2 max-w-2xl">
            Tangkapan layar percakapan asli dan bukti kepuasan pelanggan dari berbagai pelaku usaha, kafe, klinik, dan instansi di seluruh Jawa Timur.
          </p>
        </div>

        <RouterLink
          to="/testimonials"
          class="border border-neutral-300 hover:border-brand-orange text-neutral-800 hover:text-brand-orange font-semibold px-6 py-2.5 rounded-xl transition-all duration-200 inline-flex items-center gap-2 text-sm self-start md:self-auto cursor-pointer group"
        >
          Lihat Semua Testimoni
          <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </RouterLink>
      </div>

      <!-- Loading Skeleton -->
      <div v-if="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full py-4">
        <div v-for="n in 4" :key="n" class="bg-white rounded-2xl border border-neutral-200 overflow-hidden animate-pulse">
          <div class="aspect-[3/4] bg-neutral-200"></div>
          <div class="p-4 space-y-2">
            <div class="h-4 bg-neutral-200 rounded w-3/4"></div>
            <div class="h-3 bg-neutral-200 rounded w-1/2"></div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else-if="testimonials.length === 0" class="text-center py-16 px-4 bg-white rounded-2xl border border-neutral-200 max-w-xl mx-auto shadow-sm">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center text-brand-orange">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
          </svg>
        </div>
        <p class="text-neutral-900 font-bold text-base mb-1">Belum Ada Bukti Testimoni</p>
        <p class="text-neutral-500 text-sm">Screenshot chat dan bukti serah terima proyek akan segera diperbarui melalui panel admin.</p>
      </div>

      <!-- Testimonial Screenshot Grid (1-2 cols mobile, 3-4 cols desktop) -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 max-w-7xl mx-auto">
        <div 
          v-for="(item, index) in testimonials" 
          :key="item.id" 
          class="group relative rounded-2xl overflow-hidden bg-white border border-neutral-200/90 hover:border-brand-orange/50 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col cursor-pointer"
          @click="openLightbox(index)"
        >
          <!-- Screenshot Container (Uniform 3:4 aspect ratio) -->
          <div class="relative w-full aspect-[3/4] bg-neutral-100 overflow-hidden">
            <img 
              :src="getImageUrl(item.screenshot_path || item.photo)" 
              :alt="item.client_name || item.name || 'Bukti Kepuasan Klien'" 
              class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105"
              loading="lazy"
            />

            <!-- Platform Badge -->
            <div 
              class="absolute top-3 left-3 z-10 flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold backdrop-blur-md shadow-sm border"
              :class="getBadgeStyles(item.platform)"
            >
              <!-- WhatsApp SVG -->
              <svg v-if="normalizePlatform(item.platform) === 'whatsapp'" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              <!-- Instagram SVG -->
              <svg v-else-if="normalizePlatform(item.platform) === 'instagram'" class="w-3.5 h-3.5 fill-none stroke-current stroke-2" viewBox="0 0 24 24">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
              </svg>
              <!-- Google SVG -->
              <svg v-else-if="normalizePlatform(item.platform) === 'google_review'" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" />
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" />
              </svg>
              <!-- Camera / Foto Serah Terima SVG -->
              <svg v-else class="w-3.5 h-3.5 fill-none stroke-current stroke-2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <circle cx="12" cy="13" r="4" />
              </svg>
              <span>{{ getPlatformLabel(item.platform) }}</span>
            </div>

            <!-- Hover Zoom Hint Overlay -->
            <div class="absolute inset-0 bg-neutral-950/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
              <div class="w-10 h-10 rounded-full bg-white/95 text-neutral-900 flex items-center justify-center shadow-md transform scale-90 group-hover:scale-100 transition-transform duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Bottom Card Info -->
          <div class="p-4 flex flex-col justify-between flex-1 bg-white border-t border-neutral-100">
            <div>
              <p class="font-bold text-neutral-900 text-sm sm:text-base leading-snug line-clamp-1 group-hover:text-brand-orange transition-colors">
                {{ item.client_name || item.name || 'Klien Sonar Advertising' }}
              </p>
              <p v-if="item.project_type || item.company" class="text-xs text-neutral-500 font-medium mt-0.5 line-clamp-1">
                {{ item.project_type || item.company }}
              </p>
            </div>
            <p v-if="item.caption || item.content" class="text-xs text-neutral-600 mt-2.5 line-clamp-2 leading-relaxed bg-neutral-50 p-2 rounded-lg border border-neutral-100">
              "{{ item.caption || item.content }}"
            </p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Lightbox Zoom Modal for full view without cropping -->
    <ImagePreview 
      v-model="isPreviewOpen" 
      :images="previewImages" 
      :start-index="previewIndex" 
    />
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'
import ImagePreview from '@/components/ui/ImagePreview.vue'
import { testimonialService } from '@/services/api/testimonial.service'

const testimonials = ref([])
const loading = ref(true)

const isPreviewOpen = ref(false)
const previewIndex = ref(0)

const previewImages = computed(() => {
  return testimonials.value.map((item) => ({
    src: getImageUrl(item.screenshot_path || item.photo),
    alt: `${item.client_name || item.name || 'Klien'} — ${item.project_type || item.company || 'Bukti Kepuasan'}`
  }))
})

const getImageUrl = (path) => {
  if (!path) return ''
  if (path.startsWith('http') || path.startsWith('data:')) return path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  return apiBase.replace('/api', '') + path
}

const normalizePlatform = (platform) => {
  if (!platform) return 'whatsapp'
  const p = platform.toLowerCase()
  if (p.includes('wa') || p.includes('whatsapp')) return 'whatsapp'
  if (p.includes('ig') || p.includes('instagram')) return 'instagram'
  if (p.includes('google') || p.includes('review')) return 'google_review'
  return 'foto_lokasi'
}

const getPlatformLabel = (platform) => {
  const norm = normalizePlatform(platform)
  switch (norm) {
    case 'whatsapp':
      return 'Chat WhatsApp'
    case 'instagram':
      return 'DM Instagram'
    case 'google_review':
      return 'Google Review'
    default:
      return 'Foto Serah Terima'
  }
}

const getBadgeStyles = (platform) => {
  const norm = normalizePlatform(platform)
  switch (norm) {
    case 'whatsapp':
      return 'bg-emerald-500/90 text-white border-emerald-400/40'
    case 'instagram':
      return 'bg-gradient-to-r from-purple-600 to-pink-600 text-white border-pink-400/40'
    case 'google_review':
      return 'bg-blue-600/90 text-white border-blue-400/40'
    default:
      return 'bg-amber-600/90 text-white border-amber-400/40'
  }
}

const openLightbox = (index) => {
  previewIndex.value = index
  isPreviewOpen.value = true
}

const loadTestimonials = async () => {
  loading.value = true
  try {
    const response = await testimonialService.getAll({ is_featured: 1, per_page: 8 })
    let rawData = response.data?.data
    if (rawData && typeof rawData === 'object' && !Array.isArray(rawData)) {
      rawData = rawData.data || []
    }
    const items = Array.isArray(rawData) ? rawData : []
    // Filter items with valid screenshot
    testimonials.value = items.filter(item => item && (item.screenshot_path || item.photo))
  } catch (err) {
    console.error('Error loading testimonials:', err)
    testimonials.value = []
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadTestimonials()
})
</script>
