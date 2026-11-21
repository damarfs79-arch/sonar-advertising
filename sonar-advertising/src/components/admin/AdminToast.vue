<template>
  <div v-if="toasts.length > 0" class="toast-container">
    <div 
      v-for="toast in toasts" 
      :key="toast.id"
      class="toast"
      :class="toast.type"
    >
      <span>{{ toast.message }}</span>
      <button @click="removeToast(toast.id)" class="toast-close">
        ×
      </button>
    </div>
  </div>
</template>

<script setup>
import { useToast } from '@/composables/useToast'

const { toasts, removeToast } = useToast()

// Re-export toasts ref agar bisa digunakan di parent component
defineExpose({ toasts, removeToast })
</script>

<style scoped>
.toast-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 9999;
}

.toast {
  background: white;
  border-radius: 8px;
  padding: 12px 16px;
  margin-bottom: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border-left: 4px solid;
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-width: 300px;
  max-width: 400px;
  animation: slideIn 0.3s ease-out;
}

.toast.success {
  border-left-color: #10b981;
  background: #f0fdf4;
}

.toast.error {
  border-left-color: #ef4444;
  background: #fef2f2;
}

.toast.warning {
  border-left-color: #f59e0b;
  background: #fffbeb;
}

.toast.info {
  border-left-color: #FF7A00;
  background: #fff7ed;
}

.toast-close {
  background: none;
  border: none;
  font-size: 20px;
  color: #6b7280;
  cursor: pointer;
  margin-left: 10px;
}

@keyframes slideIn {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}
</style>
