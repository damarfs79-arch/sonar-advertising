<template>
  <div id="app" class="bg-brand-dark min-h-screen">
    <!-- Layout publik (Navbar + Footer) hanya tampil di non-admin -->
    <template v-if="!isAdminRoute">
      <AppNavbar />
      <main>
        <RouterView />
      </main>
      <AppFooter />
      <WhatsAppButton />
    </template>

    <!-- Admin: render view langsung (AdminLayout sudah ada di dalam view) -->
    <template v-else>
      <RouterView />
    </template>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import AppNavbar from '@/components/layout/AppNavbar.vue'
import AppFooter from '@/components/layout/AppFooter.vue'
import WhatsAppButton from '@/components/ui/WhatsAppButton.vue'

const route = useRoute()

// Semua route yang path-nya mulai /admin dianggap admin route
const isAdminRoute = computed(() => route.path.startsWith('/admin'))
</script>