<template>
  <div class="pt-24 bg-[#F6F6F6] min-h-screen">
    <!-- Header/Hero -->
    <section class="py-20 bg-brand-dark">
      <div class="container mx-auto px-4 md:px-6">
        <RouterLink 
          to="/blog" 
          class="inline-flex items-center gap-2 text-brand-orange text-sm font-medium hover:text-white transition-colors duration-200 mb-6"
        >
          <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
          Kembali ke Blog
        </RouterLink>
        
        <div v-if="loading" class="text-white/50 text-sm">Memuat detail artikel...</div>
        <div v-else-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div v-else-if="post">
          <div class="flex items-center gap-2 mb-4">
            <span v-if="post.category" class="bg-brand-orange/20 text-brand-orange text-[10px] sm:text-xs font-semibold uppercase tracking-wide px-2.5 py-1 rounded-full">
              {{ post.category }}
            </span>
            <time class="text-white/60 text-xs sm:text-sm">{{ formatDate(post.published_at || post.created_at) }}</time>
          </div>
          <h1 class="font-display text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
            {{ post.title }}
          </h1>
        </div>
      </div>
    </section>

    <!-- Content Area -->
    <section class="py-16">
      <div class="container mx-auto px-4 md:px-6 max-w-4xl">
        <div v-if="loading" class="text-center text-gray-500 py-20">
          Memuat konten artikel...
        </div>
        <div v-else-if="error" class="text-center text-red-500 py-20">
          {{ error }}
        </div>
        <div v-else-if="post">
          <!-- Thumbnail -->
          <div v-if="post.thumbnail && !imgFailed" class="w-full rounded-2xl overflow-hidden mb-10 shadow-lg max-h-[500px]">
            <img loading="lazy" 
              :src="getImageUrl(post.thumbnail)" 
              :alt="post.title" 
              class="w-full h-full object-cover"
              @error="imgFailed = true"
            />
          </div>

          <!-- Summary/Sub-heading -->
          <p v-if="post.summary" class="text-xl text-gray-600 font-medium leading-relaxed mb-8 border-l-4 border-brand-orange pl-4 italic">
            {{ post.summary }}
          </p>

          <!-- HTML Content -->
          <article 
            class="prose prose-lg max-w-none text-gray-800 leading-relaxed font-sans"
            v-html="post.content"
          ></article>

          <!-- Tags if any -->
          <div v-if="tagsList && tagsList.length > 0" class="mt-12 pt-8 border-t border-gray-100 flex flex-wrap gap-2">
            <span 
              v-for="tag in tagsList" 
              :key="tag" 
              class="bg-gray-100 text-gray-600 text-xs px-3 py-1.5 rounded-md font-medium"
            >
              #{{ tag }}
            </span>
          </div>
        </div>
      </div>
    </section>

    <CtaContactSection />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { blogService } from '@/services/api/blog.service'
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
  const title = `${post.value.title} | Blog Sonar Advertising`
  const description = post.value.summary || 'Artikel terbaru dari Sonar Advertising.'
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
        },
        {
          '@type': 'BreadcrumbList',
          'itemListElement': [
            { '@type': 'ListItem', 'position': 1, 'name': 'Home', 'item': 'https://sonaradvertising.com/' },
            { '@type': 'ListItem', 'position': 2, 'name': 'Blog', 'item': 'https://sonaradvertising.com/blog' },
            { '@type': 'ListItem', 'position': 3, 'name': post.value.title, 'item': canonicalUrl }
          ]
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
  if (path.startsWith('http')) return path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  return apiBase.replace('/api', '') + path
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(date)
}

const fetchPostDetail = async () => {
  loading.value = true
  error.value = null
  try {
    const id = route.params.id
    const response = await blogService.getById(id)
    post.value = response.data.data || response.data
  } catch (err) {
    console.error('Error fetching blog detail:', err)
    error.value = 'Gagal memuat artikel. Artikel mungkin tidak ditemukan atau terjadi masalah server.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchPostDetail()
})
</script>

<style scoped>
/* Basic content styles to make rich-text look great */
:deep(p) {
  margin-bottom: 1.5rem;
}
:deep(h2) {
  font-size: 1.5rem;
  font-weight: 700;
  margin-top: 2rem;
  margin-bottom: 1rem;
  color: #111827;
}
:deep(h3) {
  font-size: 1.25rem;
  font-weight: 600;
  margin-top: 1.75rem;
  margin-bottom: 0.75rem;
  color: #1f2937;
}
:deep(ul), :deep(ol) {
  margin-bottom: 1.5rem;
  padding-left: 1.5rem;
}
:deep(ul) {
  list-style-type: disc;
}
:deep(ol) {
  list-style-type: decimal;
}
:deep(li) {
  margin-bottom: 0.5rem;
}
:deep(strong) {
  font-weight: 700;
  color: #111827;
}
:deep(a) {
  color: #FF7A00;
  text-decoration: underline;
}
:deep(blockquote) {
  border-left: 4px solid #FF7A00;
  padding-left: 1rem;
  font-style: italic;
  color: #4b5563;
  margin: 1.5rem 0;
}
</style>
