import { ref } from 'vue'

export function useToast() {
  const toasts = ref([])
  
  const showToast = (message, type = 'success', duration = 3000) => {
    const id = Date.now()
    const toast = {
      id,
      message,
      type,
      duration
    }
    
    toasts.value.push(toast)
    
    setTimeout(() => {
      removeToast(id)
    }, duration)
    
    return id
  }
  
  const removeToast = (id) => {
    const index = toasts.value.findIndex(toast => toast.id === id)
    if (index !== -1) {
      toasts.value.splice(index, 1)
    }
  }
  
  const clearAllToasts = () => {
    toasts.value = []
  }
  
  const success = (message, duration = 3000) => {
    return showToast(message, 'success', duration)
  }
  
  const error = (message, duration = 5000) => {
    return showToast(message, 'error', duration)
  }
  
  const warning = (message, duration = 4000) => {
    return showToast(message, 'warning', duration)
  }
  
  const info = (message, duration = 3000) => {
    return showToast(message, 'info', duration)
  }
  
  return {
    toasts,
    showToast,
    removeToast,
    clearAllToasts,
    success,
    error,
    warning,
    info
  }
}
