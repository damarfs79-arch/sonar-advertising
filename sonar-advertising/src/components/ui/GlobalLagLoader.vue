<template>
  <Transition name="lag-slide">
    <div
      v-if="loadingStore.isLagging"
      class="fixed bottom-24 right-4 sm:right-6 z-[9990] max-w-sm w-[calc(100vw-2rem)] sm:w-auto"
      role="status"
      aria-live="polite"
    >
      <div
        class="bg-[#16171B]/95 backdrop-blur-xl border border-brand-orange/40 text-white rounded-2xl p-4 shadow-[0_10px_35px_rgba(0,0,0,0.6),0_0_20px_rgba(255,122,0,0.15)] flex flex-col gap-2.5 transition-all"
      >
        <div class="flex items-center gap-3.5">
          <!-- Sonar Pulse Radar Icon -->
          <div class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-brand-orange/10 border border-brand-orange/30 shrink-0">
            <!-- Concentric Pulse Wave -->
            <span class="absolute inline-flex h-full w-full rounded-xl bg-brand-orange/20 animate-ping opacity-75" />
            
            <!-- Modern Circular Spinner -->
            <svg class="animate-spin w-5 h-5 text-brand-orange relative z-10" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
          </div>

          <!-- Message & Progress -->
          <div class="flex-1 min-w-0 pr-2">
            <div class="flex items-center gap-2">
              <span class="text-sm font-semibold text-white tracking-wide truncate">
                {{ loadingStore.message }}
              </span>
              <!-- Typing / Pulsing Dots -->
              <span class="inline-flex gap-1">
                <span class="w-1 h-1 rounded-full bg-brand-orange animate-bounce" style="animation-delay: 0ms"></span>
                <span class="w-1 h-1 rounded-full bg-brand-orange animate-bounce" style="animation-delay: 150ms"></span>
                <span class="w-1 h-1 rounded-full bg-brand-orange animate-bounce" style="animation-delay: 300ms"></span>
              </span>
            </div>
            
            <p class="text-xs text-white/60 mt-0.5 line-clamp-1">
              {{ loadingStore.isVerySlow ? 'Koneksi jaringan agak lambat...' : 'Mohon tunggu beberapa saat...' }}
            </p>
          </div>
        </div>

        <!-- Extended Lag / Slow Connection Helper (appears if > 4s) -->
        <div
          v-if="loadingStore.isVerySlow"
          class="pt-2 border-t border-white/10 flex items-center justify-between gap-3 text-xs"
        >
          <span class="text-brand-orange-light font-medium flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Respon server lambat
          </span>
          <div class="flex items-center gap-2">
            <button
              type="button"
              @click="handleReload"
              class="px-2.5 py-1 bg-brand-orange/20 hover:bg-brand-orange/30 text-brand-orange-light hover:text-white rounded-lg transition-colors font-medium cursor-pointer"
            >
              Muat Ulang
            </button>
            <button
              type="button"
              @click="loadingStore.reset"
              class="px-2 py-1 text-white/50 hover:text-white transition-colors cursor-pointer"
              title="Abaikan"
            >
              ✕
            </button>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { useLoadingStore } from '@/stores/loading'

const loadingStore = useLoadingStore()

const handleReload = () => {
  window.location.reload()
}
</script>

<style scoped>
.lag-slide-enter-active,
.lag-slide-leave-active {
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.lag-slide-enter-from,
.lag-slide-leave-to {
  opacity: 0;
  transform: translateY(16px) scale(0.96);
}
</style>
