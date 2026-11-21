<template>
  <AdminLayout>
    <div class="admin-gallery">
      <div class="header">
        <h1>Gallery Management</h1>
        <button @click="openCreateModal" class="btn-primary">
          <span>+ Upload Photos</span>
        </button>
      </div>

      <div class="filters">
        <div class="search-box">
          <input v-model="searchTerm" type="text" placeholder="Search title or category..." @input="debouncedSearch" />
        </div>
        <div class="filter-actions">
          <select v-model="filters.category" @change="loadGallery">
            <option value="">All Categories</option>
            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
          </select>
        </div>
      </div>

      <div v-if="loading" class="loading">Loading gallery...</div>

      <div v-else-if="items.length === 0" class="empty-state">
        No photos found. Upload some!
      </div>

       <div v-else class="gallery-grid">
        <div v-for="(item, index) in items" :key="item?.id" class="gallery-item">
          <div class="image-wrapper" @click="openPreview(index)">
            <img :src="getImageUrl(item?.image)" :alt="item?.title || 'Gallery Image'" loading="lazy" />
            <div class="image-overlay">
              <button @click.stop="openEditModal(item)" class="btn-icon btn-edit" title="Edit Info">✎</button>
              <button @click.stop="confirmDelete(item?.id)" class="btn-icon btn-delete" title="Delete">✕</button>
            </div>
          </div>
          <div class="item-info">
            <h4>{{ item?.title || 'Untitled' }}</h4>
            <span v-if="item?.category" class="category-tag">{{ item.category }}</span>
          </div>
        </div>
      </div>

      <div v-if="totalPages > 1" class="pagination">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">Previous</button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">Next</button>
      </div>

      <!-- Upload Modal -->
      <AdminModal
        v-model="isModalOpen"
        :title="modalMode === 'create' ? 'Upload Foto' : 'Edit Info Foto'"
        :confirm-text="modalMode === 'create' ? 'Upload' : 'Perbarui'"
        cancel-text="Batal"
        :show-footer="true"
        :loading="modalLoading"
        @confirm="saveGallery"
      >
        <div class="modal-form">
          <div v-if="Object.keys(formErrors).length" class="error-message">
            <p v-for="(err, key) in formErrors" :key="key">{{ Array.isArray(err) ? err.join(', ') : err }}</p>
          </div>

          <UploadImage
            v-if="modalMode === 'create'"
            label="Select Photo *"
            :current-image="null"
            @file-selected="(file) => form.image = file"
            @file-removed="form.image = null"
          />

          <div v-if="modalMode === 'edit'" class="current-image-preview">
            <img loading="lazy" :src="getImageUrl(currentPhoto)" alt="Current" />
          </div>

          <div class="form-group">
            <label>Title</label>
            <input v-model="form.title" type="text" placeholder="Photo title (optional)" />
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea v-model="form.description" rows="3" placeholder="Brief description (optional)"></textarea>
          </div>

          <div class="form-group">
            <label>Category</label>
            <input v-model="form.category" type="text" placeholder="e.g. Event, Office, Team" />
          </div>
        </div>
      </AdminModal>

      <!-- Delete Modal -->
      <AdminModal
        v-model="isDeleteModalOpen"
        title="Hapus Foto"
        confirm-text="Hapus"
        cancel-text="Batal"
        @confirm="deleteGallery"
      >
        <p>Apakah Anda yakin ingin menghapus foto ini?</p>
      </AdminModal>

      <!-- Image Preview -->
      <ImagePreview v-model="isPreviewOpen" :images="previewImages" :start-index="previewIndex" />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AdminLayout from '@/components/admin/AdminLayout.vue'
import AdminModal from '@/components/admin/AdminModal.vue'
import UploadImage from '@/components/admin/UploadImage.vue'
import ImagePreview from '@/components/admin/ImagePreview.vue'
import { useToast } from '@/composables/useToast'
import { galleryService } from '@/services/api/gallery.service'

const loading = ref(true)
const items = ref([])
const currentPage = ref(1)
const totalPages = ref(1)
const searchTerm = ref('')
const filters = ref({ category: '' })
const categories = ref(['Event', 'Office', 'Team', 'Product', 'Behind the Scenes'])

const isModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const isPreviewOpen = ref(false)
const modalLoading = ref(false)
const modalMode = ref('create')
const formErrors = ref({})
const selectedId = ref(null)

const form = ref({ title: '', description: '', category: '', image: null })
const currentPhoto = ref(null)

const previewImages = ref([])
const previewIndex = ref(0)

const { success, error } = useToast()

const getImageUrl = (path) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  return apiBase.replace('/api', '') + path
}

const loadGallery = async () => {
  loading.value = true
  try {
    const params = {
      page: currentPage.value, per_page: 20,
      search: searchTerm.value || undefined,
      category: filters.value.category || undefined
    }
    const response = await galleryService.getAll(params)
    
    // Handle berbagai format response dari Laravel API
    let rawData = response.data.data
    
    // Jika response.data.data adalah object pagination, ambil array-nya
    if (rawData && typeof rawData === 'object' && !Array.isArray(rawData)) {
      rawData = rawData.data || []
    }
    
    // Pastikan rawData adalah array dan filter null/undefined
    items.value = Array.isArray(rawData) 
      ? rawData.filter(item => item && item.id)
      : []
    
    totalPages.value = response.data.meta?.last_page || response.data.last_page || 1
  } catch (err) {
    console.error('Error loading gallery:', err)
    error('Failed to load gallery')
    items.value = []
  } finally {
    loading.value = false
  }
}

const openCreateModal = () => {
  modalMode.value = 'create'
  form.value = { title: '', description: '', category: '', image: null }
  formErrors.value = {}
  currentPhoto.value = null
  isModalOpen.value = true
}

const openEditModal = (item) => {
  modalMode.value = 'edit'
  selectedId.value = item.id
  form.value = { title: item.title || '', description: item.description || '', category: item.category || '', image: null }
  currentPhoto.value = item.image
  formErrors.value = {}
  isModalOpen.value = true
}

const saveGallery = async () => {
  modalLoading.value = true
  formErrors.value = {}
  try {
    if (modalMode.value === 'create') {
      if (!form.value.image) {
        formErrors.value = { image: ['Please select an image'] }
        modalLoading.value = false
        return
      }
      await galleryService.create(form.value)
      success('Photo uploaded successfully')
    } else {
      const updateData = { title: form.value.title, description: form.value.description, category: form.value.category }
      await galleryService.update(selectedId.value, updateData)
      success('Photo info updated successfully')
    }
    isModalOpen.value = false
    loadGallery()
  } catch (err) {
    if (err.response?.status === 422) {
      formErrors.value = err.response.data.errors
    } else {
      error('Failed to save photo')
    }
  } finally {
    modalLoading.value = false
  }
}

const confirmDelete = (id) => {
  selectedId.value = id
  isDeleteModalOpen.value = true
}

const deleteGallery = async () => {
  try {
    await galleryService.delete(selectedId.value)
    success('Photo deleted successfully')
    isDeleteModalOpen.value = false
    loadGallery()
  } catch (err) {
    error('Failed to delete photo')
    isDeleteModalOpen.value = false
  }
}

const openPreview = (index) => {
  previewImages.value = items.value.map(item => ({
    src: item.image,
    alt: item.title || item.category || ''
  }))
  previewIndex.value = index
  isPreviewOpen.value = true
}

const changePage = (page) => {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
  loadGallery()
}

let searchTimeout
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => { currentPage.value = 1; loadGallery() }, 500)
}

onMounted(() => loadGallery())
</script>

<style scoped>

.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;   flex-wrap: wrap;
  gap: 1rem;
}
.header h1 { margin: 0; font-size: 1.875rem; font-weight: 600; }
.btn-primary { background: #FF7A00; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: 500; }
.btn-primary:hover { background: #ea580c; }
.filters { display: flex; gap: 1rem; margin-bottom: 2rem; }
.search-box input { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; width: 100%;
  max-width: 300px; }
.filter-actions select { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; background: white; }
.loading { text-align: center; padding: 2rem; color: #6b7280; }
.empty-state { text-align: center; padding: 3rem; background: #f9fafb; border-radius: 8px; color: #6b7280; }

.gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 200px), 1fr)); gap: 1rem; }
.gallery-item { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; }
.image-wrapper { position: relative; padding-bottom: 100%; cursor: pointer; overflow: hidden; background: #f3f4f6; }
.image-wrapper img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
.image-wrapper:hover img { transform: scale(1.05); }
.image-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.5); opacity: 0; display: flex; align-items: center; justify-content: center; gap: 1rem; transition: opacity 0.2s; }
.image-wrapper:hover .image-overlay { opacity: 1; }
.btn-icon { width: 36px; height: 36px; border-radius: 50%; border: none; color: white; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: transform 0.2s; }
.btn-icon:hover { transform: scale(1.1); }
.btn-edit { background: #FF7A00; }
.btn-delete { background: #ef4444; }
.item-info { padding: 0.75rem; }
.item-info h4 { margin: 0 0 0.25rem 0; font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.category-tag { font-size: 0.75rem; color: #6b7280; background: #f3f4f6; padding: 2px 6px; border-radius: 4px; }

.pagination { display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 2rem; }
.pagination button { padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 4px; background: white; cursor: pointer; }
.pagination button:disabled { opacity: 0.5; cursor: not-allowed; }

.modal-form { display: flex; flex-direction: column; gap: 1rem; }
.form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151; font-size: 0.875rem; }
.form-group input, .form-group textarea { width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem; }
.form-group textarea { resize: vertical; }
.error-message { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 6px; font-size: 0.875rem; }
.current-image-preview { text-align: center; background: #f3f4f6; padding: 1rem; border-radius: 6px; }
.current-image-preview img { max-width: 100%; max-height: 200px; border-radius: 4px; }
</style>
