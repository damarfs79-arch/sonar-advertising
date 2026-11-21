<template>
  <header
    :class="[
      'fixed top-0 left-0 right-0 z-50 h-[78px] transition-[background,backdrop-filter,box-shadow] duration-500',
      isScrolled ? 'scrolled' : ''
    ]"
  >
    <div class="nav">
      <!-- Logo -->
      <RouterLink to="/" class="brand" aria-label="Sonar Advertising">
        <img
          src="/logo.png"
          alt="Sonar Advertising"
          class="h-9 w-auto object-contain"
          width="160"
          height="36"
        />
      </RouterLink>

      <!-- Desktop Nav -->
      <nav class="links" aria-label="Navigasi Utama">
        <RouterLink
          v-for="item in navItems"
          :key="item.path"
          :to="item.path"
        >
          {{ item.label }}
        </RouterLink>
      </nav>

      <!-- CTA Button -->
      <div class="hidden md:flex items-center gap-3">
        <button
          @click="handleConsultation"
          class="btn primary"
        >
          Konsultasi Gratis
        </button>
      </div>

      <!-- Mobile Menu Toggle -->
      <button
        class="md:hidden p-2 text-white hover:text-brand-orange transition-colors cursor-pointer"
        @click="mobileOpen = !mobileOpen"
        :aria-expanded="mobileOpen"
        aria-label="Toggle menu"
      >
        <svg v-if="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <Transition name="slide-down">
      <div
        v-if="mobileOpen"
        class="md:hidden bg-[#141516]/98 backdrop-blur-xl border-t border-white/10 px-4 py-4 max-h-[calc(100vh-5rem)] overflow-y-auto shadow-2xl"
      >
        <nav class="flex flex-col gap-1 pb-4" aria-label="Navigasi Mobile">
          <RouterLink
            v-for="item in navItems"
            :key="item.path"
            :to="item.path"
            class="text-gray-300 hover:text-white hover:bg-white/5 px-4 py-3 rounded-lg transition-colors duration-200 font-medium"
            @click="mobileOpen = false"
          >
            {{ item.label }}
          </RouterLink>
          <button
            @click="handleConsultationMobile"
            class="btn primary mt-3 justify-center w-full"
          >
            Konsultasi Gratis
          </button>
        </nav>
      </div>
    </Transition>
  </header>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useScrolled } from '@/composables/useScrolled'

const route = useRoute()
const router = useRouter()
const { isScrolled } = useScrolled(24)
const mobileOpen = ref(false)

const navItems = [
  { label: 'Beranda', path: '/' },
  { label: 'Layanan', path: '/services' },
  { label: 'Portofolio', path: '/portfolio' },
  { label: 'Artikel', path: '/blog' },
  { label: 'Kontak', path: '/contact' },
  { label: 'Tentang Kami', path: '/about' }
]

const handleConsultation = () => {
  if (route.path === '/') {
    const contactSection = document.getElementById('contact')
    if (contactSection) {
      contactSection.scrollIntoView({ behavior: 'smooth' })
      return
    }
  }
  router.push('/contact')
}

const handleConsultationMobile = () => {
  mobileOpen.value = false
  handleConsultation()
}

watch(
  () => route.path,
  () => {
    mobileOpen.value = false
  }
)
</script>

<style scoped>
header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 30;
  height: 78px;
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  transition: background .5s ease, backdrop-filter .5s ease, box-shadow .5s ease;
  animation: dropIn .9s var(--ease) both;
}
header.scrolled {
  background: rgba(20,21,22,.82);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  box-shadow: 0 1px 0 rgba(255,255,255,.07);
}
.nav {
  max-width: 1280px;
  height: 100%;
  margin: 0 auto;
  padding: 0 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.brand {
  display: flex;
  align-items: center;
}
.links {
  display: flex;
  gap: 32px;
  font-size: 14px;
  color: #e5e7eb;
}
.links a {
  position: relative;
  padding: 6px 0;
  transition: color .3s;
}
.links a::after {
  content: "";
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  height: 2px;
  background: var(--o, #ff7a00);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform .45s var(--ease);
}
.links a:hover {
  color: #fff;
}
.links a:hover::after {
  transform: scaleX(1);
}
.btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 13px 22px;
  border-radius: 10px;
  font-weight: 700;
  font-size: 14px;
  border: 1px solid transparent;
  cursor: pointer;
  transition: transform .45s var(--ease), box-shadow .45s var(--ease), background .3s, border-color .3s;
}
.btn.primary {
  background: linear-gradient(135deg, #ff8a1f, #ff6a00);
  color: #fff;
  box-shadow: 0 12px 26px -14px rgba(255,122,0,.8);
}
.btn.primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 18px 30px -14px rgba(255,122,0,.95);
}

@keyframes dropIn {
  from { opacity: 0; transform: translate3d(0,-14px,0); }
  to { opacity: 1; transform: none; }
}

@media (max-width: 900px) {
  .links {
    display: none;
  }
}
@media (prefers-reduced-motion: reduce) {
  header {
    animation: none !important;
  }
}
</style>
