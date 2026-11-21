<template>
  <div class="pt-24 bg-[#F8F9FA] min-h-screen font-sans">
    <!-- Hero Header -->
    <section class="py-20 bg-neutral-950 text-white relative overflow-hidden">
      <div class="container mx-auto px-4 md:px-6 text-center relative z-10">
        <SectionLabel text="Artikel & Tips Reklame" class="justify-center" />
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mt-2 mb-4">
          Inspirasi & <span class="text-gradient">Tips Branding</span>
        </h1>
        <p class="text-gray-300 text-sm sm:text-base lg:text-lg max-w-2xl mx-auto leading-relaxed">
          Temukan berbagai panduan teknis, tips material signage, regulasi reklame, dan strategi branding visual bisnis Anda.
        </p>
      </div>
    </section>

    <!-- Main Content Area -->
    <section class="py-16">
      <div class="container mx-auto px-4 md:px-6" id="blog-list">
        <!-- Search & Category Filters -->
        <div class="mb-10 space-y-6">
          <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Category Pills -->
            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 no-scrollbar">
              <button
                v-for="cat in categories"
                :key="cat"
                @click="selectCategory(cat)"
                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200 shrink-0 cursor-pointer border"
                :class="selectedCategory === cat ? 'bg-brand-orange text-white border-brand-orange shadow-md shadow-brand-orange/20' : 'bg-white text-neutral-700 hover:text-brand-orange border-neutral-200 hover:border-brand-orange/40'"
              >
                {{ cat }}
              </button>
            </div>

            <!-- Search Bar -->
            <div class="relative w-full md:w-72">
              <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
              </svg>
              <input
                v-model="searchTerm"
                type="text"
                placeholder="Cari artikel..."
                class="w-full pl-10 pr-4 py-2 text-sm rounded-xl border border-neutral-200 bg-white focus:outline-none focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20"
                @input="handleSearchInput"
              />
            </div>
          </div>
        </div>

        <!-- Slide Action Header (Counter & Navigation Buttons) -->
        <div v-if="!loading && filteredPosts.length > 0" class="flex items-center justify-between mb-8 pb-4 border-b border-neutral-200/80">
          <div class="text-sm text-neutral-600 font-medium">
            Menampilkan slide <span class="font-bold text-neutral-900">{{ currentSlide + 1 }}</span> dari <span class="font-bold text-neutral-900">{{ totalSlides }}</span> 
            <span class="text-neutral-400 ml-1">({{ filteredPosts.length }} total artikel)</span>
          </div>

          <!-- Slide Arrows -->
          <div v-if="totalSlides > 1" class="flex items-center gap-2">
            <button
              @click="prevSlide"
              :disabled="currentSlide === 0"
              class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl border border-neutral-300 bg-white text-xs font-semibold text-neutral-700 hover:border-brand-orange hover:text-brand-orange disabled:opacity-30 disabled:hover:border-neutral-300 disabled:hover:text-neutral-700 disabled:cursor-not-allowed transition-all cursor-pointer shadow-sm"
              aria-label="Slide sebelumnya"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
              </svg>
              <span class="hidden sm:inline">Sebelumnya</span>
            </button>

            <button
              @click="nextSlide"
              :disabled="currentSlide === totalSlides - 1"
              class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl border border-neutral-300 bg-white text-xs font-semibold text-neutral-700 hover:border-brand-orange hover:text-brand-orange disabled:opacity-30 disabled:hover:border-neutral-300 disabled:hover:text-neutral-700 disabled:cursor-not-allowed transition-all cursor-pointer shadow-sm"
              aria-label="Slide berikutnya"
            >
              <span class="hidden sm:inline">Berikutnya</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Loading Skeleton (3 items) -->
        <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full py-6">
          <SkeletonCard v-for="n in 3" :key="n" />
        </div>

        <!-- Empty State -->
        <div v-else-if="filteredPosts.length === 0" class="text-center py-20 px-4 bg-white rounded-2xl border border-neutral-200 max-w-xl mx-auto shadow-sm">
          <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center text-brand-orange">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
          </div>
          <p class="text-neutral-900 font-bold text-base mb-1">Belum Ada Artikel yang Sesuai</p>
          <p class="text-neutral-500 text-sm mb-4">Coba cari dengan kata kunci lain atau pilih kategori berbeda.</p>
          <button
            @click="resetFilters"
            class="px-4 py-2 bg-neutral-100 hover:bg-neutral-200 text-neutral-800 rounded-xl text-xs font-semibold transition-colors cursor-pointer"
          >
            Reset Filter
          </button>
        </div>

        <!-- Slide Content (Grid 3 Columns per Slide with Smooth Transition) -->
        <div v-else>
          <Transition name="fade-slide" mode="out-in">
            <div :key="currentSlide" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <BlogCard
                v-for="post in visiblePosts"
                :key="post.id || post.slug"
                :post="post"
              />
            </div>
          </Transition>

          <!-- Interactive Slide Indicators & Numbers -->
          <div v-if="totalSlides > 1" class="flex items-center justify-center mt-12 pt-6">
            <!-- Number Buttons -->
            <div class="flex items-center gap-1.5 flex-wrap justify-center">
              <button
                v-for="(slideNum, idx) in visibleSlideNumbers"
                :key="'num-' + idx"
                @click="typeof slideNum === 'number' ? goToSlide(slideNum - 1) : null"
                class="w-10 h-10 rounded-xl text-sm font-bold transition-all flex items-center justify-center border shadow-sm"
                :class="[
                  typeof slideNum !== 'number' ? 'cursor-default border-transparent text-neutral-400 bg-transparent shadow-none' : 'cursor-pointer',
                  currentSlide === slideNum - 1 ? 'bg-brand-orange text-white border-brand-orange shadow-brand-orange/20 scale-105' : 'bg-white text-neutral-700 hover:text-brand-orange border-neutral-200 hover:border-brand-orange/40'
                ]"
              >
                {{ slideNum }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <CtaContactSection />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'
import SkeletonCard from '@/components/ui/SkeletonCard.vue'
import BlogCard from '@/components/ui/BlogCard.vue'
import CtaContactSection from '@/components/sections/CtaContactSection.vue'
import { blogService } from '@/services/api/blog.service'
import { fallbackPosts } from '@/data/blogData.js'
import { useSeoMeta } from '@/composables/useSeoMeta'

useSeoMeta({
  title: 'Blog Sonar Advertising | Tips Reklame, Signage & Branding',
  description: 'Artikel, panduan teknis, dan wawasan terbaru seputar pembuatan Neon Box, Huruf Timbul, Fasad ACP, dan perizinan reklame di Jawa Timur.',
  keywords: 'tips reklame, panduan huruf timbul, cara memilih neon box, artikel branding signage, info advertising jember, izin reklame kediri'
})

const posts = ref([])
const loading = ref(true)
const currentSlide = ref(0)
const itemsPerSlide = 3
const searchTerm = ref('')
const selectedCategory = ref('Semua')

const categories = [
  'Semua',
  'Tips Material',
  'Desain & Branding',
  'Regulasi & Izin',
  'Fasad & Konstruksi',
  'Perawatan Signage',
  'Strategi Bisnis'
]

// Fallback high-quality articles if API is offline (imported from @/data/blogData)

let searchTimeout = null
const handleSearchInput = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    currentSlide.value = 0
  }, 300)
}

const selectCategory = (cat) => {
  selectedCategory.value = cat
  currentSlide.value = 0
}

const resetFilters = () => {
  selectedCategory.value = 'Semua'
  searchTerm.value = ''
  currentSlide.value = 0
}

const allPosts = computed(() => {
  if (posts.value.length > 0) {
    return posts.value
  }
  return fallbackPosts
})

const filteredPosts = computed(() => {
  let list = allPosts.value

  if (selectedCategory.value !== 'Semua') {
    list = list.filter(p => p.category === selectedCategory.value)
  }

  if (searchTerm.value && searchTerm.value.trim() !== '') {
    const q = searchTerm.value.toLowerCase().trim()
    list = list.filter(p => {
      const title = (p.title || '').toLowerCase()
      const summary = (p.summary || '').toLowerCase()
      const category = (p.category || '').toLowerCase()
      return title.includes(q) || summary.includes(q) || category.includes(q)
    })
  }

  return list
})

const totalSlides = computed(() => {
  if (filteredPosts.value.length === 0) return 1
  return Math.ceil(filteredPosts.value.length / itemsPerSlide)
})

const visibleSlideNumbers = computed(() => {
  const total = totalSlides.value
  if (total <= 7) {
    return Array.from({ length: total }, (_, i) => i + 1)
  }
  const curr = currentSlide.value + 1
  const pages = []

  pages.push(1)
  if (curr > 3) pages.push('...')
  
  const start = Math.max(2, curr - 1)
  const end = Math.min(total - 1, curr + 1)

  for (let i = start; i <= end; i++) {
    pages.push(i)
  }

  if (curr < total - 2) pages.push('...')
  pages.push(total)

  return pages
})

const visiblePosts = computed(() => {
  const start = currentSlide.value * itemsPerSlide
  return filteredPosts.value.slice(start, start + itemsPerSlide)
})

const goToSlide = (slideIndex) => {
  if (slideIndex < 0 || slideIndex >= totalSlides.value) return
  currentSlide.value = slideIndex
  scrollToTop()
}

const nextSlide = () => {
  if (currentSlide.value < totalSlides.value - 1) {
    currentSlide.value++
    scrollToTop()
  }
}

const prevSlide = () => {
  if (currentSlide.value > 0) {
    currentSlide.value--
    scrollToTop()
  }
}

const scrollToTop = () => {
  const el = document.getElementById('blog-list')
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' })
  }
}

const loadBlog = async () => {
  loading.value = true
  try {
    const response = await blogService.getAll({ status: 'published', per_page: 100 })
    let rawData = response.data?.data
    if (rawData && typeof rawData === 'object' && !Array.isArray(rawData)) {
      rawData = rawData.data || []
    }
    posts.value = Array.isArray(rawData) ? rawData : []
  } catch (err) {
    console.error('Error loading blog articles:', err)
    posts.value = []
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadBlog()
})
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: opacity 0.28s ease, transform 0.28s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateX(14px);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateX(-14px);
}
</style>
