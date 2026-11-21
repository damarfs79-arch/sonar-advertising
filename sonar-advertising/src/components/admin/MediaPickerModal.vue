<template>
  <Teleport to="body">
    <div v-if="modelValue" class="media-picker-overlay" @click.self="close">
      <div class="media-picker-modal">
        <div class="modal-header">
          <h2>Select Media</h2>
          <button class="close-btn" @click="close">&times;</button>
        </div>
        
        <div class="tabs">
          <button :class="{ active: activeTab === 'library' }" @click="activeTab = 'library'">Media Library</button>
          <button :class="{ active: activeTab === 'upload' }" @click="activeTab = 'upload'">Upload New</button>
        </div>
        
        <div class="modal-body">
          <!-- Library Tab -->
          <div v-if="activeTab === 'library'" class="tab-content library-tab">
            <div v-if="loading" class="loading">Loading media...</div>
            <div v-else-if="items.length === 0" class="empty-state">No media available.</div>
            <div v-else class="media-grid">
              <div 
                v-for="item in items" 
                :key="item.id" 
                class="media-item" 
                :class="{ selected: selectedMedia?.id === item.id }"
                @click="selectMedia(item)"
              >
                <img :src="getImageUrl(item.image)" :alt="item.title || 'Media'" loading="lazy" />
              </div>
            </div>
            
            <div v-if="totalPages > 1" class="pagination">
              <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">Previous</button>
              <span>Page {{ currentPage }} of {{ totalPages }}</span>
              <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">Next</button>
            </div>
          </div>
          
          <!-- Upload Tab -->
          <div v-if="activeTab === 'upload'" class="tab-content upload-tab">
            <div class="upload-area">
              <div v-if="uploadError" class="error-message">{{ uploadError }}</div>
              
              <div class="form-group">
                <label>Select Photo *</label>
                <input type="file" ref="fileInput" accept="image/jpeg,image/png,image/webp" @change="handleFileSelect" />
              </div>
              
              <div v-if="previewUrl" class="preview-container">
                <img loading="lazy" :src="previewUrl" alt="Preview" />
              </div>
              
              <div class="form-group">
                <label>Title (Optional)</label>
                <input v-model="uploadForm.title" type="text" placeholder="Photo title" />
              </div>
              
              <div class="form-group">
                <label>Category (Optional)</label>
                <input v-model="uploadForm.category" type="text" placeholder="e.g. Blog, Portfolio" />
              </div>
              
              <button @click="uploadAndSelect" class="btn-primary" :disabled="!selectedFile || isUploading">
                {{ isUploading ? 'Uploading...' : 'Upload & Select' }}
              </button>
            </div>
          </div>
        </div>
        
        <div class="modal-footer" v-if="activeTab === 'library'">
          <button class="btn-secondary" @click="close">Cancel</button>
          <button class="btn-primary" @click="confirmSelection" :disabled="!selectedMedia">Select File</button>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { galleryService } from '@/services/api/gallery.service'
import { useToast } from '@/composables/useToast'

const props = defineProps({
  modelValue: Boolean
})

const emit = defineEmits(['update:modelValue', 'select'])
const { error, success } = useToast()

const activeTab = ref('library')
const loading = ref(false)
const isUploading = ref(false)
const items = ref([])
const currentPage = ref(1)
const totalPages = ref(1)
const selectedMedia = ref(null)

// Upload state
const fileInput = ref(null)
const selectedFile = ref(null)
const previewUrl = ref(null)
const uploadForm = ref({ title: '', category: '' })
const uploadError = ref('')

const getImageUrl = (path) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  return apiBase.replace('/api', '') + path
}

const loadMedia = async () => {
  loading.value = true
  try {
    const params = { page: currentPage.value, per_page: 24 }
    const response = await galleryService.getAll(params)
    
    let rawData = response.data.data
    if (rawData && typeof rawData === 'object' && !Array.isArray(rawData)) {
      rawData = rawData.data || []
    }
    
    items.value = Array.isArray(rawData) ? rawData.filter(item => item && item.id) : []
    totalPages.value = response.data.meta?.last_page || response.data.last_page || 1
  } catch (err) {
    console.error('Error loading media:', err)
    error('Failed to load media library')
  } finally {
    loading.value = false
  }
}

const changePage = (page) => {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
  loadMedia()
}

const selectMedia = (item) => {
  selectedMedia.value = item
}

const confirmSelection = () => {
  if (selectedMedia.value) {
    emit('select', selectedMedia.value.image)
    close()
  }
}

const handleFileSelect = (e) => {
  const file = e.target.files[0]
  if (!file) return
  
  if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
    uploadError.value = 'Invalid file type. Only JPG, PNG and WEBP are allowed.'
    return
  }
  
  if (file.size > 2 * 1024 * 1024) {
    uploadError.value = 'File size exceeds 2MB limit.'
    return
  }
  
  uploadError.value = ''
  selectedFile.value = file
  
  const reader = new FileReader()
  reader.onload = (event) => {
    previewUrl.value = event.target.result
  }
  reader.readAsDataURL(file)
}

const uploadAndSelect = async () => {
  if (!selectedFile.value) return
  
  isUploading.value = true
  uploadError.value = ''
  
  try {
    const formData = {
      image: selectedFile.value,
      title: uploadForm.value.title || selectedFile.value.name,
      category: uploadForm.value.category || 'General'
    }
    
    const response = await galleryService.create(formData)
    success('Image uploaded successfully')
    
    // Automatically select the newly uploaded image (handles both wrapped and unwrapped API responses)
    const uploadedImage = response.data?.data?.image || response.data?.image || response.data?.url || response.data?.path
    if (uploadedImage) {
      emit('select', uploadedImage)
    }
    
    // Reset form
    selectedFile.value = null
    previewUrl.value = null
    uploadForm.value = { title: '', category: '' }
    if (fileInput.value) fileInput.value.value = ''
    
    // Refresh library for next time
    currentPage.value = 1
    loadMedia()
    
    close()
  } catch (err) {
    console.error('Upload error:', err)
    uploadError.value = 'Failed to upload image. Please try again.'
  } finally {
    isUploading.value = false
  }
}

const close = () => {
  selectedMedia.value = null
  uploadError.value = ''
  emit('update:modelValue', false)
}

watch(() => props.modelValue, (newVal) => {
  if (newVal && items.value.length === 0) {
    loadMedia()
  }
})
</script>

<style scoped>
.media-picker-overlay { position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center; z-index: 1500; }
.media-picker-modal { background: white; width: 90%; max-width: 800px; height: 80vh; border-radius: 8px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
.modal-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; }
.modal-header h2 { margin: 0; font-size: 1.25rem; font-weight: 600; }
.close-btn { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; }
.close-btn:hover { color: #111827; }

.tabs { display: flex; border-bottom: 1px solid #e5e7eb; background: #f9fafb; }
.tabs button { flex: 1; padding: 1rem; border: none; background: none; font-weight: 500; cursor: pointer; color: #6b7280; border-bottom: 2px solid transparent; }
.tabs button.active { color: #FF7A00; border-bottom-color: #FF7A00; background: white; }
.tabs button:hover:not(.active) { background: #f3f4f6; }

.modal-body { flex: 1; overflow-y: auto; padding: 1.5rem; background: #f9fafb; }

.library-tab { display: flex; flex-direction: column; height: 100%; }
.loading { text-align: center; padding: 2rem; color: #6b7280; }
.empty-state { text-align: center; padding: 3rem; color: #6b7280; }
.media-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
.media-item { position: relative; padding-bottom: 100%; border-radius: 6px; overflow: hidden; cursor: pointer; border: 2px solid transparent; background: #e5e7eb; }
.media-item img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
.media-item.selected { border-color: #FF7A00; box-shadow: 0 0 0 2px rgba(255, 122, 0, 0.2); }
.media-item.selected::after { content: '✓'; position: absolute; top: 0; right: 0; background: #FF7A00; color: white; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-bottom-left-radius: 6px; font-size: 12px; }

.pagination { display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: auto; padding-top: 1rem; }
.pagination button { padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 4px; background: white; cursor: pointer; }
.pagination button:disabled { opacity: 0.5; cursor: not-allowed; }

.upload-area { max-width: 500px; margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; border: 1px solid #e5e7eb; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151; font-size: 0.875rem; }
.form-group input[type="text"] { width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem; }
.form-group input[type="file"] { width: 100%; padding: 8px; border: 1px dashed #d1d5db; border-radius: 6px; background: #f9fafb; cursor: pointer; }
.preview-container { margin-bottom: 1.25rem; border-radius: 6px; overflow: hidden; background: #f3f4f6; display: flex; justify-content: center; align-items: center; min-height: 150px; }
.preview-container img { max-width: 100%; max-height: 300px; object-fit: contain; }
.error-message { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 6px; font-size: 0.875rem; margin-bottom: 1rem; }

.btn-primary { width: 100%; background: #FF7A00; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: 500; }
.btn-primary:hover:not(:disabled) { background: #ea580c; }
.btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }
.btn-secondary { background: white; color: #374151; padding: 10px 20px; border-radius: 6px; border: 1px solid #d1d5db; cursor: pointer; font-weight: 500; }
.btn-secondary:hover { background: #f9fafb; }

.modal-footer { padding: 1.25rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 1rem; background: white; }
.modal-footer .btn-primary { width: auto; }
</style>
