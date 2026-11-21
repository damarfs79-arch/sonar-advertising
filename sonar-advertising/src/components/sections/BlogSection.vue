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

      <!-- Articles Grid: 6 Articles Directly (3x2 on desktop) -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <BlogCard
          v-for="post in displayPosts"
          :key="post.id || post.slug"
          :post="post"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import SkeletonCard from '@/components/ui/SkeletonCard.vue'
import SectionLabel from '@/components/ui/SectionLabel.vue'
import BlogCard from '@/components/ui/BlogCard.vue'
import { blogService } from '@/services/api/blog.service'

const posts = ref([])
const loading = ref(true)

// Fallback high-quality articles if API is offline
const fallbackPosts = [
  {
    id: 1,
    title: 'Panduan Memilih Bahan Huruf Timbul: Stainless, Akrilik, atau Galvanis?',
    slug: 'panduan-memilih-bahan-huruf-timbul-stainless-akrilik-galvanis',
    summary: 'Panduan komprehensif menentukan bahan huruf timbul terbaik sesuai kebutuhan lokasi toko, ketahanan cuaca di Jawa Timur, dan estetika bisnis Anda.',
    thumbnail: '/hero-bg.webp',
    category: 'Tips Material',
    published_at: '2026-10-15',
  },
  {
    id: 2,
    title: 'Strategi Efektif Neon Box Akrilik LED untuk Menarik Pengunjung Cafe dan Retail',
    slug: 'strategi-efektif-neon-box-akrilik-led-cafe-toko-retail',
    summary: 'Mengapa visibilitas malam hari sangat menentukan foot traffic toko retail dan kafe, serta tips memilih modul LED hemat daya berkualitas tinggi.',
    thumbnail: '/hero-bg.webp',
    category: 'Desain & Branding',
    published_at: '2026-10-22',
  },
  {
    id: 3,
    title: 'Prosedur dan Syarat Perizinan Reklame Outdoor & Billboard di Jember dan Kediri',
    slug: 'prosedur-syarat-perizinan-reklame-outdoor-jember-kediri',
    summary: 'Langkah-langkah resmi mengurus izin penyelenggaraan reklame, pajak reklame daerah (Bapenda), dan standar keamanan konstruksi billboard di Jawa Timur.',
    thumbnail: '/hero-bg.webp',
    category: 'Regulasi & Izin',
    published_at: '2026-10-29',
  },
  {
    id: 4,
    title: 'Kelebihan Fasad ACP (Aluminium Composite Panel) untuk Modernisasi Bangunan Toko',
    slug: 'kelebihan-fasad-acp-aluminium-composite-panel-toko-kantor',
    summary: 'Ubah tampilan ruko atau kantor lama menjadi modern dan profesional dengan pelapisan ACP Seven / Alucobond tahan panas dan anti bocor.',
    thumbnail: '/hero-bg.webp',
    category: 'Fasad & Konstruksi',
    published_at: '2026-11-04',
  },
  {
    id: 5,
    title: 'Tips Perawatan Neon Flex Custom agar Awet dan Tetap Terang Bertahun-tahun',
    slug: 'tips-perawatan-neon-flex-custom-awet-terang',
    summary: 'Cara merawat instalasi neon flex interior kafe dan photobooth agar trafo stabil, silikon tidak menguning, dan cahaya LED tetap menyala rata.',
    thumbnail: '/hero-bg.webp',
    category: 'Perawatan Signage',
    published_at: '2026-11-10',
  },
  {
    id: 6,
    title: 'Membangun Identitas Visual Toko yang Menonjol di Kawasan Komersial Padat',
    slug: 'membangun-identitas-visual-toko-kawasan-komersial-padat',
    summary: 'Tips menentukan ukuran, sudut pandang (sightline), dan hierarki tipografi plang nama toko agar mudah dikenali pengendara jalan raya.',
    thumbnail: '/hero-bg.webp',
    category: 'Strategi Bisnis',
    published_at: '2026-11-16',
  }
]

const displayPosts = computed(() => {
  if (posts.value.length >= 6) {
    return posts.value.slice(0, 6)
  }
  if (posts.value.length > 0) {
    const needed = 6 - posts.value.length
    return [...posts.value, ...fallbackPosts.slice(0, needed)]
  }
  return fallbackPosts
})

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
