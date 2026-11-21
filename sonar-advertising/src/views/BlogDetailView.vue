<template>
  <div class="pt-24 bg-[#F8F9FA] min-h-screen font-sans">
    <!-- Header / Hero Section -->
    <section class="py-16 sm:py-20 bg-neutral-950 text-white relative overflow-hidden">
      <div class="container mx-auto px-4 md:px-6">
        <RouterLink 
          to="/blog" 
          class="inline-flex items-center gap-2 text-brand-orange text-xs sm:text-sm font-semibold hover:text-white transition-colors duration-200 mb-6 cursor-pointer"
        >
          <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
          Kembali ke Daftar Artikel
        </RouterLink>
        
        <!-- Loading State in Header -->
        <div v-if="loading" class="animate-pulse space-y-3">
          <div class="h-4 bg-neutral-800 rounded w-28"></div>
          <div class="h-8 bg-neutral-800 rounded max-w-xl"></div>
        </div>

        <!-- Not Found / Error in Header -->
        <div v-else-if="error" class="py-4">
          <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Artikel Tidak Ditemukan</h1>
        </div>

        <!-- Loaded Article Header -->
        <div v-else-if="post">
          <div class="flex items-center gap-3 mb-4 flex-wrap">
            <span v-if="post.category" class="bg-brand-orange text-white text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
              {{ post.category }}
            </span>
            <span class="text-neutral-400 text-xs sm:text-sm flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
              </svg>
              <time>{{ formatDate(post.published_at || post.created_at) }}</time>
            </span>
            <span v-if="post.views" class="text-neutral-500 text-xs flex items-center gap-1">
              • {{ post.views }} kali dibaca
            </span>
          </div>

          <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight max-w-4xl">
            {{ post.title }}
          </h1>
        </div>
      </div>
    </section>

    <!-- Main Content Area -->
    <section class="py-14">
      <div class="container mx-auto px-4 md:px-6 max-w-4xl">
        <!-- Loading Spinner / Skeleton -->
        <div v-if="loading" class="py-20 text-center">
          <div class="inline-block w-8 h-8 border-3 border-brand-orange border-t-transparent rounded-full animate-spin mb-3"></div>
          <p class="text-neutral-500 text-sm">Memuat konten artikel...</p>
        </div>

        <!-- 404 / Error State (Clean Container with Action Buttons) -->
        <div v-else-if="error" class="bg-white rounded-2xl border border-neutral-200 p-8 sm:p-12 text-center shadow-sm max-w-xl mx-auto my-8">
          <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center text-brand-orange">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
          </div>
          <h2 class="text-xl font-bold text-neutral-900 mb-2">Artikel Tidak Ditemukan</h2>
          <p class="text-neutral-500 text-sm mb-6 leading-relaxed">
            {{ error }}
          </p>
          <div class="flex items-center justify-center gap-3 flex-wrap">
            <RouterLink
              to="/blog"
              class="px-5 py-2.5 bg-brand-orange hover:bg-orange-600 text-white rounded-xl text-xs font-bold transition-colors shadow-sm"
            >
              Kembali ke Daftar Artikel
            </RouterLink>
            <RouterLink
              to="/"
              class="px-5 py-2.5 bg-neutral-100 hover:bg-neutral-200 text-neutral-800 rounded-xl text-xs font-bold transition-colors"
            >
              Halaman Utama
            </RouterLink>
          </div>
        </div>

        <!-- Loaded Content -->
        <div v-else-if="post" class="bg-white rounded-2xl border border-neutral-200 p-6 sm:p-10 shadow-sm">
          <!-- Thumbnail with graceful fallback -->
          <div class="w-full rounded-xl overflow-hidden mb-8 shadow-sm max-h-[480px] bg-neutral-900">
            <img 
              v-if="post.thumbnail && !imgFailed"
              loading="lazy" 
              :src="getImageUrl(post.thumbnail)" 
              :alt="post.title" 
              class="w-full h-full object-cover"
              @error="imgFailed = true"
            />
            <div v-else class="w-full h-64 bg-gradient-to-r from-neutral-900 via-neutral-800 to-neutral-950 flex flex-col items-center justify-center text-center p-6">
              <span class="text-brand-orange text-xs font-bold uppercase tracking-widest mb-1">{{ post.category }}</span>
              <p class="text-white font-bold text-lg max-w-md">{{ post.title }}</p>
              <span class="text-neutral-400 text-xs mt-2">Sonar Advertising Jember</span>
            </div>
          </div>

          <!-- Summary / Lead Paragraph -->
          <div v-if="post.summary" class="text-base sm:text-lg text-neutral-700 font-medium leading-relaxed mb-8 border-l-4 border-brand-orange pl-4 bg-orange-50/50 py-3 rounded-r-xl">
            {{ post.summary }}
          </div>

          <!-- Rich Article HTML Content -->
          <article 
            class="article-content leading-relaxed text-neutral-800 text-sm sm:text-base"
            v-html="post.content"
          ></article>

          <!-- Tags if any -->
          <div v-if="tagsList && tagsList.length > 0" class="mt-10 pt-6 border-t border-neutral-100 flex flex-wrap items-center gap-2">
            <span class="text-xs text-neutral-400 font-semibold mr-1">Topik Terkait:</span>
            <span 
              v-for="tag in tagsList" 
              :key="tag" 
              class="bg-neutral-100 text-neutral-700 text-xs px-3 py-1 rounded-lg font-medium hover:bg-neutral-200 transition-colors"
            >
              #{{ tag }}
            </span>
          </div>

          <!-- Back to Blog Button at Bottom -->
          <div class="mt-10 pt-6 border-t border-neutral-100 flex justify-between items-center flex-wrap gap-4">
            <RouterLink
              to="/blog"
              class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-brand-orange hover:text-orange-700 transition-colors"
            >
              <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
              </svg>
              Lihat Artikel Lainnya
            </RouterLink>
            
            <a
              href="https://wa.me/6285540000007?text=Halo%20Sonar%20Advertising%2C%20saya%20ingin%20konsultasi%20mengenai%20signage"
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center gap-2 px-4 py-2 bg-brand-orange text-white rounded-xl text-xs font-bold hover:bg-orange-600 transition-colors shadow-sm"
            >
              Konsultasi Proyek Ini
            </a>
          </div>
        </div>
      </div>
    </section>

    <CtaContactSection />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import { blogService } from '@/services/api/blog.service'
import { fallbackPosts } from '@/data/blogData'
import CtaContactSection from '@/components/sections/CtaContactSection.vue'
import { useSeoMeta } from '@/composables/useSeoMeta'

const route = useRoute()
const post = ref(null)
const loading = ref(true)
const error = ref(null)
const imgFailed = ref(false)

useSeoMeta(() => {
  if (!post.value) {
    return { title: 'Artikel Blog | Sonar Advertising' }
  }
  const title = `${post.value.title} | Sonar Advertising`
  const description = post.value.summary || 'Artikel wawasan advertising dan reklame dari Sonar Advertising.'
  const image = getImageUrl(post.value.thumbnail)
  const canonicalUrl = `https://sonaradvertising.com/blog/${post.value.slug || post.value.id}`

  return {
    title,
    description,
    image,
    url: canonicalUrl,
    type: 'article',
    jsonLd: {
      '@context': 'https://schema.org',
      '@graph': [
        {
          '@type': 'Article',
          'headline': post.value.title,
          'description': description,
          'image': image ? [image] : [],
          'datePublished': post.value.published_at || post.value.created_at,
          'dateModified': post.value.updated_at || post.value.published_at,
          'author': {
            '@type': 'Organization',
            'name': 'Sonar Advertising'
          },
          'publisher': {
            '@type': 'Organization',
            'name': 'Sonar Advertising',
            'logo': {
              '@type': 'ImageObject',
              'url': 'https://sonaradvertising.com/favicon.png'
            }
          }
        }
      ]
    }
  }
})

const tagsList = computed(() => {
  if (!post.value || !post.value.tags) return []
  if (Array.isArray(post.value.tags)) return post.value.tags
  try {
    return JSON.parse(post.value.tags)
  } catch (e) {
    if (typeof post.value.tags === 'string') {
      return post.value.tags.split(',').map(t => t.trim())
    }
    return []
  }
})

const getImageUrl = (path) => {
  if (!path) return ''
  if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('data:')) {
    return path
  }
  // Frontend static assets
  if (path.startsWith('/') && !path.startsWith('/storage')) {
    return path
  }
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8008/api'
  const cleanPath = path.startsWith('/') ? path : '/' + path
  return apiBase.replace(/\/api\/?$/, '') + cleanPath
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(date)
}

const fetchPostDetail = async () => {
  loading.value = true
  error.value = null
  const slugOrId = route.params.id

  // 1. Try to fetch from backend API
  try {
    const response = await blogService.getById(slugOrId)
    const data = response?.data?.data || response?.data
    if (data && (data.id || data.title)) {
      post.value = data
      loading.value = false
      return
    }
  } catch (err) {
    // API failed or returned non-JSON, fallback to local dataset
  }

  // 2. Check local rich dataset matching slug or id
  const found = fallbackPosts.find(p => p.slug === slugOrId || String(p.id) === String(slugOrId))
  if (found) {
    post.value = found
    loading.value = false
    return
  }

  // 3. Article truly does not exist
  error.value = 'Artikel tidak ditemukan. Alamat tautan mungkin salah atau artikel sudah tidak tersedia.'
  loading.value = false
}

onMounted(() => {
  fetchPostDetail()
})
</script>

<style scoped>
.article-content :deep(p) {
  margin-bottom: 1.25rem;
  line-height: 1.75;
}
.article-content :deep(h2) {
  font-size: 1.35rem;
  font-weight: 700;
  margin-top: 1.85rem;
  margin-bottom: 0.85rem;
  color: #171717;
}
.article-content :deep(h3) {
  font-size: 1.15rem;
  font-weight: 600;
  margin-top: 1.5rem;
  margin-bottom: 0.75rem;
  color: #262626;
}
.article-content :deep(ul), .article-content :deep(ol) {
  margin-bottom: 1.25rem;
  padding-left: 1.25rem;
}
.article-content :deep(ul) {
  list-style-type: disc;
}
.article-content :deep(ol) {
  list-style-type: decimal;
}
.article-content :deep(li) {
  margin-bottom: 0.5rem;
}
.article-content :deep(strong) {
  font-weight: 700;
  color: #171717;
}
.article-content :deep(a) {
  color: #FF7A00;
  text-decoration: underline;
}
.article-content :deep(blockquote) {
  border-left: 4px solid #FF7A00;
  padding-left: 1rem;
  font-style: italic;
  color: #525252;
  margin: 1.5rem 0;
}
</style>
