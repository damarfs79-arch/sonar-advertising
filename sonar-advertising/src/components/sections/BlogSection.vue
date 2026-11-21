<template>
  <section class="py-24 bg-white font-sans relative overflow-hidden" aria-labelledby="blog-heading">
    <div class="container mx-auto px-4 md:px-6">
      <!-- Section Header -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
        <div>
          <SectionLabel text="Artikel & Wawasan" />
          <h2 id="blog-heading" class="section-title text-brand-text-primary">
            Inspirasi & <span class="text-gradient">Tips Branding</span>
          </h2>
          <p class="text-gray-600 text-sm sm:text-base mt-2 max-w-2xl">
            Wawasan seputar material reklame, strategi signage toko, dan tips perizinan reklame di Jawa Timur.
          </p>
        </div>

        <RouterLink
          to="/blog"
          class="border border-neutral-300 hover:border-brand-orange text-neutral-800 hover:text-brand-orange font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 inline-flex items-center gap-2 text-sm self-start md:self-auto cursor-pointer group"
        >
          Lihat Semua Artikel
          <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </RouterLink>
      </div>

      <!-- Loading Skeleton (6 items) -->
      <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full py-6">
        <SkeletonCard v-for="n in 6" :key="n" />
      </div>

      <!-- Articles Grid -->
      <div v-else-if="posts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <BlogCard
          v-for="post in posts"
          :key="post.id || post.slug"
          :post="post"
        />
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-16 bg-neutral-50 rounded-2xl border border-neutral-200/80">
        <div class="w-12 h-12 rounded-xl bg-brand-orange/10 border border-brand-orange/20 flex items-center justify-center text-brand-orange mx-auto mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
          </svg>
        </div>
        <p class="text-neutral-700 font-semibold">Belum Ada Artikel</p>
        <p class="text-neutral-500 text-sm mt-1">Artikel dapat ditambahkan melalui panel admin.</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import SkeletonCard from '@/components/ui/SkeletonCard.vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'
import BlogCard from '@/components/ui/BlogCard.vue'
import { blogService } from '@/services/api/blog.service'

const posts = ref([])
const loading = ref(true)

const loadBlog = async () => {
  loading.value = true
  try {
    const response = await blogService.getAll({ per_page: 6, status: 'published' })
    let rawData = response?.data?.data
    if (rawData && typeof rawData === 'object' && !Array.isArray(rawData)) {
      rawData = rawData.data || []
    }
    posts.value = Array.isArray(rawData) ? rawData : []
  } catch (err) {
    posts.value = []
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadBlog()
})
</script>
