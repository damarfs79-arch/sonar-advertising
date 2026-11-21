<template>
  <div class="upload-image">
    <label v-if="label" class="upload-label">{{ label }}</label>

    <!-- Drop Zone -->
    <div
      class="drop-zone"
      :class="{ 'drag-over': isDragOver, 'has-error': errorMessage }"
      @dragover.prevent="isDragOver = true"
      @dragleave.prevent="isDragOver = false"
      @drop.prevent="handleDrop"
      @click="triggerInput"
    >
      <!-- Preview -->
      <div v-if="previewUrl" class="preview-container">
        <img loading="lazy" :src="previewUrl" alt="Preview" class="preview-img" />
        <div class="preview-overlay">
          <button type="button" @click.stop="removeFile" class="btn-remove" title="Hapus">
            ✕
          </button>
          <button type="button" @click.stop="triggerInput" class="btn-change" title="Ganti">
            ⟳
          </button>
        </div>
      </div>

      <!-- Current Image (edit mode, no new file selected) -->
      <div v-else-if="currentImage" class="preview-container">
        <img loading="lazy" :src="getImageUrl(currentImage)" alt="Current" class="preview-img" />
        <div class="preview-overlay">
          <button type="button" @click.stop="triggerInput" class="btn-change" title="Ganti">
            ⟳
          </button>
        </div>
        <span class="current-badge">Current</span>
      </div>

      <!-- Empty State -->
      <div v-else class="drop-placeholder">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
          <polyline points="17 8 12 3 7 8"/>
          <line x1="12" y1="3" x2="12" y2="15"/>
        </svg>
        <p class="drop-text">Drag & drop atau <span class="browse-link">pilih file</span></p>
        <p class="drop-hint">JPG, JPEG, PNG, WEBP — Max {{ maxSizeMB }}MB</p>
      </div>

      <input
        ref="fileInputRef"
        type="file"
        :accept="acceptTypes"
        class="file-input-hidden"
        @change="handleInputChange"
      />
    </div>

    <!-- Progress -->
    <div v-if="uploading" class="progress-bar">
      <div class="progress-fill" :style="{ width: progress + '%' }"></div>
      <span class="progress-text">{{ progress }}%</span>
    </div>

    <!-- Error -->
    <p v-if="errorMessage" class="error-text">{{ errorMessage }}</p>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
  label: { type: String, default: '' },
  currentImage: { type: String, default: null },
  maxSize: { type: Number, default: 2 * 1024 * 1024 },
  allowedTypes: {
    type: Array,
    default: () => ['image/jpeg', 'image/jpg', 'image/png', 'image/webp']
  },
  uploading: { type: Boolean, default: false },
  progress: { type: Number, default: 0 }
})

const emit = defineEmits(['file-selected', 'file-removed'])

const fileInputRef = ref(null)
const previewUrl = ref(null)
const isDragOver = ref(false)
const errorMessage = ref(null)

const maxSizeMB = computed(() => props.maxSize / 1024 / 1024)
const acceptTypes = computed(() => props.allowedTypes.join(','))

const getImageUrl = (path) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  const baseUrl = apiBase.replace('/api', '')
  return baseUrl + path
}

const validate = (file) => {
  if (!props.allowedTypes.includes(file.type)) {
    return 'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau WEBP.'
  }
  if (file.size > props.maxSize) {
    return `Ukuran file maksimal ${maxSizeMB.value} MB.`
  }
  return null
}

const processFile = (file) => {
  errorMessage.value = null
  const err = validate(file)
  if (err) {
    errorMessage.value = err
    return
  }

  const reader = new FileReader()
  reader.onload = (e) => {
    previewUrl.value = e.target.result
  }
  reader.readAsDataURL(file)
  emit('file-selected', file)
}

const triggerInput = () => {
  fileInputRef.value?.click()
}

const handleInputChange = (e) => {
  const file = e.target.files[0]
  if (file) processFile(file)
  e.target.value = ''
}

const handleDrop = (e) => {
  isDragOver.value = false
  const file = e.dataTransfer.files[0]
  if (file) processFile(file)
}

const removeFile = () => {
  previewUrl.value = null
  errorMessage.value = null
  emit('file-removed')
}

// Reset preview when currentImage changes (e.g. modal reopened)
watch(() => props.currentImage, () => {
  previewUrl.value = null
  errorMessage.value = null
})

defineExpose({ removeFile, previewUrl })
</script>

<style scoped>
.upload-image {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.upload-label {
  font-weight: 500;
  color: #374151;
  font-size: 0.875rem;
}

.drop-zone {
  border: 2px dashed #d1d5db;
  border-radius: 8px;
  padding: 1.5rem;
  text-align: center;
  cursor: pointer;
  transition: all 0.2s ease;
  background: #fafafa;
  min-height: 140px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.drop-zone:hover {
  border-color: #FF7A00;
  background: #fff7ed;
}

.drop-zone.drag-over {
  border-color: #FF7A00;
  background: #dbeafe;
  transform: scale(1.01);
}

.drop-zone.has-error {
  border-color: #ef4444;
}

.drop-placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  color: #9ca3af;
}

.drop-text {
  margin: 0;
  font-size: 0.875rem;
  color: #6b7280;
}

.browse-link {
  color: #FF7A00;
  font-weight: 500;
  text-decoration: underline;
}

.drop-hint {
  margin: 0;
  font-size: 0.75rem;
  color: #9ca3af;
}

.file-input-hidden {
  display: none;
}

.preview-container {
  position: relative;
  width: 100%;
  max-width: 280px;
}

.preview-img {
  width: 100%;
  max-height: 200px;
  object-fit: contain;
  border-radius: 6px;
}

.preview-overlay {
  position: absolute;
  top: 6px;
  right: 6px;
  display: flex;
  gap: 4px;
  opacity: 0;
  transition: opacity 0.2s;
}

.preview-container:hover .preview-overlay {
  opacity: 1;
}

.btn-remove, .btn-change {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  border: none;
  cursor: pointer;
  font-size: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.15s;
}

.btn-remove {
  background: rgba(239, 68, 68, 0.9);
  color: white;
}

.btn-change {
  background: rgba(59, 130, 246, 0.9);
  color: white;
  font-size: 16px;
}

.btn-remove:hover, .btn-change:hover {
  transform: scale(1.1);
}

.current-badge {
  position: absolute;
  bottom: 6px;
  left: 6px;
  background: rgba(0,0,0,0.6);
  color: white;
  font-size: 0.65rem;
  padding: 2px 8px;
  border-radius: 4px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.progress-bar {
  height: 6px;
  background: #e5e7eb;
  border-radius: 3px;
  overflow: hidden;
  position: relative;
}

.progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #FF7A00, #FF7A00);
  border-radius: 3px;
  transition: width 0.3s ease;
}

.progress-text {
  position: absolute;
  right: 0;
  top: -18px;
  font-size: 0.7rem;
  color: #6b7280;
}

.error-text {
  margin: 0;
  font-size: 0.8rem;
  color: #ef4444;
}
</style>
