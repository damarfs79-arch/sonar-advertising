<template>
  <Teleport to="body">
  <div v-if="isOpen" class="modal-overlay" @click.self="close">
    <div class="modal-content">
      <div class="modal-header">
        <h2>{{ title }}</h2>
        <button type="button" @click="close" class="modal-close" aria-label="Tutup">×</button>
      </div>
      <div class="modal-body">
        <slot />
      </div>
      <div class="modal-footer" v-if="showFooter">
        <button type="button" @click="close" class="btn btn-secondary">
          {{ cancelText }}
        </button>
        <button 
          type="button" 
          @click="onConfirm" 
          class="btn btn-primary"
          :class="{ 'loading': loading }"
          :disabled="loading"
        >
          <span v-if="loading">Menyimpan...</span>
          <span v-else>{{ confirmText }}</span>
        </button>
      </div>
    </div>
  </div>
  </Teleport>
</template>

<script setup>
const props = defineProps({
  title: {
    type: String,
    default: 'Konfirmasi'
  },
  confirmText: {
    type: String,
    default: 'Ya'
  },
  cancelText: {
    type: String,
    default: 'Batal'
  },
  showFooter: {
    type: Boolean,
    default: true
  },
  loading: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['confirm', 'close'])

const isOpen = defineModel()

const close = () => {
  isOpen.value = false
  emit('close')
}

const onConfirm = () => {
  emit('confirm')
}
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 12px;
  padding: 24px;
  max-width: 500px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
}

.modal-header h2 {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 600;
}

.modal-close {
  background: none;
  border: none;
  font-size: 24px;
  color: #6b7280;
  cursor: pointer;
  line-height: 1;
}

.modal-body {
  margin-bottom: 24px;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

.btn {
  padding: 8px 16px;
  border-radius: 6px;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  border: none;
  transition: all 0.2s;
}

.btn-primary {
  background: #FF7A00;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #ea580c;
}

.btn-secondary {
  background: #f3f4f6;
  color: #374151;
}

.btn-secondary:hover {
  background: #e5e7eb;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn.loading {
  position: relative;
  padding-left: 32px;
}

.btn.loading::before {
  content: '';
  position: absolute;
  left: 12px;
  width: 16px;
  height: 16px;
  border: 2px solid white;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
