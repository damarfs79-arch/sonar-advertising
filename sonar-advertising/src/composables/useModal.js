import { ref } from 'vue'

export function useModal() {
  const isOpen = ref(false)
  const loading = ref(false)
  const data = ref(null)

  const open = (initialData = null) => {
    isOpen.value = true
    if (initialData) {
      data.value = initialData
    }
  }

  const close = () => {
    isOpen.value = false
    data.value = null
  }

  const startLoading = () => {
    loading.value = true
  }

  const stopLoading = () => {
    loading.value = false
  }

  return {
    isOpen,
    loading,
    data,
    open,
    close,
    startLoading,
    stopLoading
  }
}
