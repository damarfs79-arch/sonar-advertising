<template>
  <div
    class="fixed top-0 left-0 right-0 z-[9999] pointer-events-none transition-opacity duration-300"
    :class="[loadingStore.isVisible ? 'opacity-100' : 'opacity-0']"
    aria-hidden="true"
  >
    <!-- Progress Bar Track Background (subtle hint when active) -->
    <div class="h-[3px] w-full bg-transparent overflow-hidden relative">
      <!-- Active Progress Bar with Gradient and Neon Glow -->
      <div
        class="h-full bg-gradient-to-r from-[#FF7A00] via-[#FFA347] to-[#FF5500] relative transition-all ease-out"
        :style="{
          width: `${loadingStore.progress}%`,
          transitionDuration: loadingStore.progress === 100 ? '200ms' : '250ms'
        }"
      >
        <!-- Glow Leading Tip (Glow shadow on edge) -->
        <div
          class="absolute right-0 top-0 bottom-0 w-28 bg-gradient-to-r from-transparent to-white/70 shadow-[0_0_12px_#FF7A00,0_0_6px_#FFA347]"
        >
        
        <!-- Shimmering Pulse Ray -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { useLoadingStore } from '@/stores/loading'

const loadingStore = useLoadingStore()
</script>

<style scoped>
@keyframes shimmer {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

.animate-shimmer {
  animation: shimmer 1.2s infinite ease-in-out;
}
</style>
