<template>
  <div id="app" class="bg-brand-dark min-h-screen overflow-x-hidden w-full relative">
    <!-- Global Top Loading Progress Bar (aktif saat navigasi & fetch API) -->
    <GlobalLoadingBar />

    <!-- Indikator Lag / Koneksi Lambat (aktif jika proses > 320ms) -->
    <GlobalLagLoader />

    <!-- Toast notifications (global) -->
    <AdminToast />
    
    <!-- Layout publik (Navbar + Footer) hanya tampil di non-admin & non-login -->
    <template v-if="!isAuthOrAdminRoute">
      <AppNavbar />
      <main>
        <RouterView />
      </main>
      <AppFooter />
      <WhatsAppButton />
    </template>

    <!-- Admin & Login: render view langsung (AdminLayout sudah ada di dalam view admin) -->
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
import AdminToast from '@/components/admin/AdminToast.vue'
import GlobalLoadingBar from '@/components/ui/GlobalLoadingBar.vue'
import GlobalLagLoader from '@/components/ui/GlobalLagLoader.vue'

const route = useRoute()

// Route admin atau login tidak menampilkan navbar/footer publik
const isAuthOrAdminRoute = computed(() => {
  return route.path.startsWith('/admin') || route.path === '/login' || Boolean(route.meta?.hideNavigation)
})
</script>
