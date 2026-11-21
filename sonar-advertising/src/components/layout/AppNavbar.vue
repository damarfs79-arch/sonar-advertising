<template>
  <header
    :class="[
      'fixed top-0 left-0 right-0 z-50 h-[78px] transition-[background,backdrop-filter,box-shadow] duration-300',
      isScrolled ? 'scrolled' : '',
      mobileOpen ? 'menu-open' : ''
    ]"
  >
    <div class="nav">
      <!-- Logo -->
      <RouterLink to="/" class="brand" aria-label="Sonar Advertising" @click="mobileOpen = false">
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
        class="md:hidden p-2 text-white hover:text-brand-orange transition-colors cursor-pointer focus:outline-none rounded-lg"
        @click="mobileOpen = !mobileOpen"
        :aria-expanded="mobileOpen"
        :aria-label="mobileOpen ? 'Tutup menu' : 'Buka menu'"
      >
        <svg v-if="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </header>

  <!-- Mobile Menu Overlay & Panel (Teleported to body to avoid header containing-block constraint) -->
  <Teleport to="body">
    <Transition name="slide-down">
      <div
        v-if="mobileOpen"
        class="md:hidden fixed top-[78px] inset-x-0 bottom-0 bg-[#121315] border-t border-neutral-800/80 px-6 py-6 overflow-y-auto flex flex-col justify-between z-[9999] shadow-2xl"
        style="height: calc(100dvh - 78px);"
      >
        <nav class="flex flex-col gap-1.5" aria-label="Navigasi Mobile">
          <RouterLink
            v-for="item in navItems"
            :key="item.path"
            :to="item.path"
            class="text-neutral-200 hover:text-white hover:bg-neutral-800/60 active:bg-neutral-800 px-4 py-3.5 rounded-xl transition-colors duration-150 font-medium text-base flex items-center justify-between"
            @click="mobileOpen = false"
          >
            <span>{{ item.label }}</span>
            <svg class="w-4 h-4 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </RouterLink>
        </nav>

        <div class="pt-6 pb-4 border-t border-neutral-800/80 mt-6">
          <button
            @click="handleConsultationMobile"
            class="btn primary justify-center w-full py-3.5 text-base font-semibold rounded-xl bg-gradient-to-r from-[#ff8a1f] to-[#ff6a00] text-white cursor-pointer shadow-lg"
          >
            Konsultasi Gratis
          </button>
          <p class="text-center text-xs text-neutral-500 mt-4 font-normal">
            Sonar Advertising · Signage & Reklame Jawa Timur
          </p>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, watch, onUnmounted } from 'vue'
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

watch(mobileOpen, (isOpen) => {
  if (typeof document !== 'undefined') {
    document.body.style.overflow = isOpen ? 'hidden' : ''
  }
})

onUnmounted(() => {
  if (typeof document !== 'undefined') {
    document.body.style.overflow = ''
  }
})
</script>

<style scoped>
header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 50;
  height: 78px;
  font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
  transition: background .3s ease, backdrop-filter .3s ease, box-shadow .3s ease;
  animation: dropIn .9s var(--ease) both;
}
header.scrolled {
  background: rgba(18, 19, 21, 0.98);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.5), 0 1px 0 rgba(255, 255, 255, 0.08);
}
header.menu-open {
  background: #121315 !important;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  z-index: 10000 !important;
}

:global(.slide-down-enter-active),
:global(.slide-down-leave-active) {
  transition: opacity 0.2s ease, transform 0.2s ease;
}
:global(.slide-down-enter-from),
:global(.slide-down-leave-to) {
  opacity: 0;
  transform: translateY(-8px);
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
