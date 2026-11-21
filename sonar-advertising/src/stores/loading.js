import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useLoadingStore = defineStore('loading', () => {
  const activeRequests = ref(0)
  const isNavigating = ref(false)
  const progress = ref(0)
  const isVisible = ref(false)
  const isLagging = ref(false)
  const isVerySlow = ref(false)
  const message = ref('Sedang memuat...')

  let progressInterval = null
  let lagTimer = null
  let slowTimer = null

  const isLoading = computed(() => activeRequests.value > 0 || isNavigating.value)

  const startProgress = (customMsg = 'Sedang memuat...') => {
    message.value = customMsg
    isVisible.value = true

    if (progress.value === 0) {
      progress.value = 15
    }

    if (!progressInterval) {
      progressInterval = setInterval(() => {
        if (progress.value < 55) {
          progress.value += Math.random() * 10 + 5
        } else if (progress.value < 85) {
          progress.value += Math.random() * 4 + 1
        } else if (progress.value < 95) {
          progress.value += 0.4
        }
      }, 140)
    }

    // Jika proses memakan waktu > 320ms, tandai sebagai "lag"
    if (!lagTimer) {
      lagTimer = setTimeout(() => {
        if (isLoading.value) {
          isLagging.value = true
        }
      }, 320)
    }

    // Jika proses memakan waktu > 4000ms, tandai koneksi sangat lambat
    if (!slowTimer) {
      slowTimer = setTimeout(() => {
        if (isLoading.value) {
          isVerySlow.value = true
        }
      }, 4000)
    }
  }

  const completeProgress = () => {
    if (progressInterval) {
      clearInterval(progressInterval)
      progressInterval = null
    }
    if (lagTimer) {
      clearTimeout(lagTimer)
      lagTimer = null
    }
    if (slowTimer) {
      clearTimeout(slowTimer)
      slowTimer = null
    }

    progress.value = 100
    isLagging.value = false
    isVerySlow.value = false

    setTimeout(() => {
      if (!isLoading.value) {
        isVisible.value = false
        setTimeout(() => {
          if (!isVisible.value) {
            progress.value = 0
            message.value = 'Sedang memuat...'
          }
        }, 220)
      }
    }, 280)
  }

  const startNavigation = (toPath = '') => {
    isNavigating.value = true
    startProgress(toPath.startsWith('/admin') ? 'Membuka panel admin...' : 'Membuka halaman...')
  }

  const finishNavigation = () => {
    isNavigating.value = false
    if (activeRequests.value <= 0) {
      completeProgress()
    }
  }

  const startRequest = (customMsg) => {
    activeRequests.value++
    startProgress(customMsg || 'Mengambil data...')
  }

  const endRequest = () => {
    activeRequests.value = Math.max(0, activeRequests.value - 1)
    if (!isLoading.value) {
      completeProgress()
    }
  }

  const reset = () => {
    activeRequests.value = 0
    isNavigating.value = false
    completeProgress()
  }

  return {
    activeRequests,
    isNavigating,
    isLoading,
    progress,
    isVisible,
    isLagging,
    isVerySlow,
    message,
    startNavigation,
    finishNavigation,
    startRequest,
    endRequest,
    startProgress,
    completeProgress,
    reset
  }
})
