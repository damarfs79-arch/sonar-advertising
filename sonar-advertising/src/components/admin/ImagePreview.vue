<template>
  <Teleport to="body">
    <div v-if="isOpen" class="lightbox-overlay" @click.self="close">
      <div class="lightbox-container">
        <button @click="close" class="lightbox-close">✕</button>

        <button
          v-if="images.length > 1"
          @click="prev"
          class="lightbox-nav lightbox-prev"
          :disabled="currentIndex === 0"
        >‹</button>

        <div class="lightbox-image-wrapper">
          <img loading="lazy" :src="getImageUrl(currentSrc)" :alt="currentAlt" class="lightbox-image" />
          <p v-if="currentAlt" class="lightbox-caption">{{ currentAlt }}</p>
          <p v-if="images.length > 1" class="lightbox-counter">
            {{ currentIndex + 1 }} / {{ images.length }}
          </p>
        </div>

        <button
          v-if="images.length > 1"
          @click="next"
          class="lightbox-nav lightbox-next"
          :disabled="currentIndex === images.length - 1"
        >›</button>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  images: {
    type: Array,
    default: () => []
    // each item: string (url) or { src: string, alt?: string }
  },
  startIndex: { type: Number, default: 0 }
})

const isOpen = defineModel({ type: Boolean, default: false })
const currentIndex = ref(0)

const currentSrc = computed(() => {
  const img = props.images[currentIndex.value]
  return typeof img === 'string' ? img : img?.src || ''
})

const currentAlt = computed(() => {
  const img = props.images[currentIndex.value]
  return typeof img === 'string' ? '' : img?.alt || ''
})

const getImageUrl = (path) => {
  if (!path) return ''
  if (path.startsWith('http') || path.startsWith('data:')) return path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  const baseUrl = apiBase.replace('/api', '')
  return baseUrl + path
}

const close = () => {
  isOpen.value = false
}

const prev = () => {
  if (currentIndex.value > 0) currentIndex.value--
}

const next = () => {
  if (currentIndex.value < props.images.length - 1) currentIndex.value++
}

const handleKeydown = (e) => {
  if (!isOpen.value) return
  if (e.key === 'Escape') close()
  if (e.key === 'ArrowLeft') prev()
  if (e.key === 'ArrowRight') next()
}

watch(isOpen, (val) => {
  if (val) currentIndex.value = props.startIndex
})

onMounted(() => document.addEventListener('keydown', handleKeydown))
onUnmounted(() => document.removeEventListener('keydown', handleKeydown))
</script>

<style scoped>
.lightbox-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.85);
  z-index: 2000;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: fadeIn 0.2s ease;
}

.lightbox-container {
  position: relative;
  display: flex;
  align-items: center;
  gap: 1rem;
  max-width: 90vw;
  max-height: 90vh;
}

.lightbox-close {
  position: absolute;
  top: -40px;
  right: 0;
  background: none;
  border: none;
  color: white;
  font-size: 24px;
  cursor: pointer;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: background 0.2s;
}

.lightbox-close:hover {
  background: rgba(255, 255, 255, 0.15);
}

.lightbox-image-wrapper {
  text-align: center;
}

.lightbox-image {
  max-width: 80vw;
  max-height: 80vh;
  object-fit: contain;
  border-radius: 4px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
}

.lightbox-caption {
  color: rgba(255, 255, 255, 0.8);
  font-size: 0.875rem;
  margin-top: 0.75rem;
}

.lightbox-counter {
  color: rgba(255, 255, 255, 0.5);
  font-size: 0.75rem;
  margin-top: 0.25rem;
}

.lightbox-nav {
  background: rgba(255, 255, 255, 0.1);
  border: none;
  color: white;
  font-size: 36px;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  flex-shrink: 0;
}

.lightbox-nav:hover:not(:disabled) {
  background: rgba(255, 255, 255, 0.25);
}

.lightbox-nav:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>
