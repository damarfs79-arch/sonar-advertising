<template>
  <AdminLayout>
    <div class="admin-portfolio">
      <div class="header">
        <h1>Portfolio Management</h1>
        <button @click="openCreateModal" class="btn-primary">
          <span>+ Add New Portfolio</span>
        </button>
      </div>

      <div class="filters">
        <div class="search-box">
          <input
            v-model="searchTerm"
            type="text"
            placeholder="Search portfolio..."
            @input="debouncedSearch"
          />
        </div>
        <div class="filter-actions">
          <select v-model="filters.category" @change="loadPortfolio">
            <option value="">All Categories</option>
            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
          </select>
        </div>
      </div>

      <div v-if="loading" class="loading">Loading portfolio...</div>

      <div v-else-if="items.length === 0" class="empty-state">
        No portfolio items found. Create your first one!
      </div>

       <div v-else class="portfolio-grid">
        <div v-for="item in items" :key="item?.id" class="portfolio-card">
          <div class="portfolio-image" @click="openPreview(item)">
            <img loading="lazy" v-if="item?.main_image" :src="getImageUrl(item.main_image)" :alt="item?.title" />
            <div v-else class="no-image">No Image</div>
            <div v-if="item?.gallery_images && item.gallery_images.length" class="gallery-badge">
              +{{ item.gallery_images.length }} photos
            </div>
          </div>
          <div class="portfolio-info">
            <h3>{{ item?.title || 'Untitled' }}</h3>
            <p class="description">{{ truncateText(item?.description, 100) }}</p>
            <div class="portfolio-meta">
              <span v-if="item?.category" class="category-tag">{{ item.category }}</span>
              <span class="status" :class="{ active: item?.is_active, inactive: !item?.is_active }">
                {{ item?.is_active ? 'Active' : 'Inactive' }}
              </span>
            </div>
          </div>
          <div class="portfolio-actions">
            <button @click="openEditModal(item)" class="btn-edit">Edit</button>
            <button @click="confirmDelete(item?.id)" class="btn-delete">Delete</button>
          </div>
        </div>
      </div>

      <div v-if="totalPages > 1" class="pagination">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">Previous</button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">Next</button>
      </div>

      <!-- Create/Edit Modal -->
      <AdminModal
        v-model="isModalOpen"
        :title="modalTitle"
        :confirm-text="modalMode === 'create' ? 'Simpan' : 'Perbarui'"
        cancel-text="Batal"
        :show-footer="true"
        :loading="modalLoading"
        @confirm="savePortfolio"
      >
        <div class="modal-form">
          <div v-if="Object.keys(formErrors).length" class="error-message">
            <p v-for="(error, key) in formErrors" :key="key">{{ Array.isArray(error) ? error.join(', ') : error }}</p>
          </div>

          <div class="form-group">
            <label>Judul *</label>
            <input v-model="form.title" type="text" placeholder="Judul portofolio" />
          </div>

          <div class="form-group">
            <label>Deskripsi *</label>
            <textarea v-model="form.description" rows="4" placeholder="Deskripsi portofolio"></textarea>
          </div>

          <div class="form-group">
            <label>Kategori</label>
            <input v-model="form.category" type="text" list="portfolio-categories" placeholder="Pilih atau ketik kategori..." />
            <datalist id="portfolio-categories">
              <option v-for="cat in categories" :key="cat" :value="cat" />
            </datalist>
          </div>

          <div class="form-group">
            <label>Klien</label>
            <input v-model="form.client" type="text" placeholder="Nama klien" />
          </div>

          <div class="form-group">
            <label>Link / URL Proyek (Opsional)</label>
            <input v-model="form.link" type="url" placeholder="https://example.com" />
          </div>

          <div class="form-group">
            <label>Tanggal Proyek</label>
            <input v-model="form.project_date" type="date" />
          </div>

          <div class="form-group">
            <label>Gambar Utama *</label>
            <div class="media-selector" @click="openMediaPicker('main')">
              <div v-if="form.main_image" class="selected-media">
                <img loading="lazy" :src="getImageUrl(form.main_image)" alt="Thumbnail" />
                <button type="button" @click.stop="form.main_image = null" class="remove-btn">✕</button>
              </div>
              <div v-else class="placeholder">Klik untuk memilih dari Galeri Media</div>
            </div>
          </div>

          <div class="form-group">
            <label>Galeri Foto</label>
            <div class="media-selector" @click="openMediaPicker('gallery')">
              <div class="placeholder">+ Tambah foto dari Galeri Media</div>
            </div>
            <div v-if="form.gallery_images.length" class="gallery-previews">
              <div v-for="(img, idx) in form.gallery_images" :key="idx" class="gallery-thumb">
                <img loading="lazy" :src="getImageUrl(img)" alt="Gallery image" />
                <button type="button" @click="form.gallery_images.splice(idx, 1)" class="gallery-remove">✕</button>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Urutan</label>
              <input v-model="form.sort_order" type="number" min="0" />
            </div>
            <div class="form-group">
              <label class="checkbox-label">
                <input v-model="form.is_active" type="checkbox" />
                <span>Aktif</span>
              </label>
            </div>
          </div>
        </div>
      </AdminModal>

      <!-- Delete Modal -->
      <AdminModal
        v-model="isDeleteModalOpen"
        title="Hapus Portofolio"
        confirm-text="Hapus"
        cancel-text="Batal"
        @confirm="deletePortfolio"
      >
        <p>Apakah Anda yakin ingin menghapus portofolio ini? Tindakan ini tidak dapat dibatalkan.</p>
      </AdminModal>

      <!-- Image Preview Lightbox -->
      <ImagePreview v-model="isPreviewOpen" :images="previewImages" :start-index="previewIndex" />
      
      <!-- Media Picker Modal -->
      <MediaPickerModal v-model="isMediaPickerOpen" @select="handleMediaSelect" />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AdminLayout from '@/components/admin/AdminLayout.vue'
import AdminModal from '@/components/admin/AdminModal.vue'
import ImagePreview from '@/components/admin/ImagePreview.vue'
import MediaPickerModal from '@/components/admin/MediaPickerModal.vue'
import { portfolioService } from '@/services/api/portfolio.service'
import { useToast } from '@/composables/useToast'

const loading = ref(true)
const items = ref([])
const currentPage = ref(1)
const totalPages = ref(1)
const searchTerm = ref('')
const filters = ref({ category: '' })
const categories = ref(['Web Design', 'Branding', 'Photography', 'Marketing', 'Print'])

const isModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const isPreviewOpen = ref(false)
const modalLoading = ref(false)
const modalMode = ref('create')
const formErrors = ref({})
const selectedId = ref(null)

const isMediaPickerOpen = ref(false)
const mediaPickerTarget = ref('main')

const form = ref({
  title: '', description: '', category: '', main_image: null,
  gallery_images: [], client: '', link: '', project_date: '', is_active: true, sort_order: 0
})

const previewImages = ref([])
const previewIndex = ref(0)

const { success, error } = useToast()

const modalTitle = computed(() => modalMode.value === 'create' ? 'Tambah Portofolio' : 'Edit Portofolio')

const getImageUrl = (path) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  return apiBase.replace('/api', '') + path
}

const loadPortfolio = async () => {
  loading.value = true
  try {
    const params = {
      page: currentPage.value, per_page: 12,
      search: searchTerm.value || undefined,
      category: filters.value.category || undefined
    }
    const response = await portfolioService.getAll(params)
    
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
    console.error('Error loading portfolio:', err)
    error('Failed to load portfolio')
    items.value = []
  } finally {
    loading.value = false
  }
}

const openCreateModal = () => {
  modalMode.value = 'create'
  form.value = { title: '', description: '', category: '', main_image: null, gallery_images: [], client: '', link: '', project_date: '', is_active: true, sort_order: 0 }
  formErrors.value = {}
  isModalOpen.value = true
}

const openEditModal = (item) => {
  modalMode.value = 'edit'
  selectedId.value = item.id
  form.value = {
    title: item.title, description: item.description, category: item.category || '',
    main_image: item.main_image, gallery_images: item.gallery_images || [], client: item.client || '', link: item.link || '',
    project_date: item.project_date ? item.project_date.substring(0, 10) : '',
    is_active: item.is_active, sort_order: item.sort_order
  }
  formErrors.value = {}
  isModalOpen.value = true
}

const openMediaPicker = (target) => {
  mediaPickerTarget.value = target
  isMediaPickerOpen.value = true
}

const handleMediaSelect = (path) => {
  if (mediaPickerTarget.value === 'main') {
    form.value.main_image = path
  } else if (mediaPickerTarget.value === 'gallery') {
    form.value.gallery_images.push(path)
  }
}

const savePortfolio = async () => {
  modalLoading.value = true
  formErrors.value = {}
  
  const payload = { ...form.value }
  // Cegah error validasi Laravel dengan mengubah string kosong menjadi null
  if (!payload.project_date) {
    payload.project_date = null
  }
  if (!payload.link) {
    payload.link = null
  }

  try {
    if (modalMode.value === 'create') {
      await portfolioService.create(payload)
      success('Portfolio created successfully')
    } else {
      await portfolioService.update(selectedId.value, payload)
      success('Portfolio updated successfully')
    }
    isModalOpen.value = false
    loadPortfolio()
  } catch (err) {
    if (err.response?.status === 422) {
      formErrors.value = err.response.data.errors
    } else {
      error('Failed to save portfolio')
    }
  } finally {
    modalLoading.value = false
  }
}

const confirmDelete = (id) => {
  selectedId.value = id
  isDeleteModalOpen.value = true
}

const deletePortfolio = async () => {
  try {
    await portfolioService.delete(selectedId.value)
    success('Portfolio deleted successfully')
    isDeleteModalOpen.value = false
    loadPortfolio()
  } catch (err) {
    error('Failed to delete portfolio')
    isDeleteModalOpen.value = false
  }
}

const openPreview = (item) => {
  const imgs = []
  if (item.main_image) imgs.push({ src: item.main_image, alt: item.title + ' - Thumbnail' })
  if (item.gallery_images) {
    item.gallery_images.forEach((img, i) => imgs.push({ src: img, alt: item.title + ' - Gallery ' + (i + 1) }))
  }
  if (imgs.length) {
    previewImages.value = imgs
    previewIndex.value = 0
    isPreviewOpen.value = true
  }
}

const changePage = (page) => {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
  loadPortfolio()
}

const truncateText = (text, length) => {
  if (!text) return ''
  return text.length <= length ? text : text.substring(0, length) + '...'
}

let searchTimeout
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => { currentPage.value = 1; loadPortfolio() }, 500)
}

onMounted(() => loadPortfolio())
</script>

<style scoped>

.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
.header h1 { margin: 0; font-size: 1.875rem; font-weight: 600; }
.btn-primary { background: #FF7A00; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: 500; display: flex; align-items: center; gap: 8px; }
.btn-primary:hover { background: #ea580c; }
.filters { display: flex; gap: 1rem; margin-bottom: 2rem; }
.search-box input { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; width: 100%;
  max-width: 300px; }
.filter-actions select { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; background: white; }
.loading { text-align: center; padding: 2rem; color: #6b7280; }
.empty-state { text-align: center; padding: 3rem; background: #f9fafb; border-radius: 8px; color: #6b7280; }

.portfolio-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr)); gap: 1.5rem; }
.portfolio-card { background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.portfolio-image { height: 200px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; cursor: pointer; position: relative; overflow: hidden; }
.portfolio-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
.portfolio-image:hover img { transform: scale(1.05); }
.no-image { color: #9ca3af; }
.gallery-badge { position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.7); color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; }
.portfolio-info { padding: 1rem; }
.portfolio-info h3 { margin: 0 0 0.5rem 0; font-size: 1.125rem; font-weight: 600; }
.description { color: #6b7280; font-size: 0.875rem; line-height: 1.4; margin-bottom: 0.75rem; }
.portfolio-meta { display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; }
.category-tag { background: #fff7ed; color: #FF7A00; padding: 2px 8px; border-radius: 4px; font-weight: 500; }
.status { padding: 2px 8px; border-radius: 12px; font-weight: 500; }
.status.active { background: #d1fae5; color: #065f46; }
.status.inactive { background: #fef3c7; color: #92400e; }
.portfolio-actions { padding: 1rem; border-top: 1px solid #e5e7eb; display: flex; gap: 0.5rem; }
.btn-edit { background: #FF7A00; color: white; padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer; font-size: 0.875rem; }
.btn-edit:hover { background: #FF7A00; }
.btn-delete { background: #ef4444; color: white; padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer; font-size: 0.875rem; }
.btn-delete:hover { background: #dc2626; }

.pagination { display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 2rem; }
.pagination button { padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 4px; background: white; cursor: pointer; }
.pagination button:disabled { opacity: 0.5; cursor: not-allowed; }

.modal-form { display: flex; flex-direction: column; gap: 1rem; }
.form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151; }
.form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem; }
.form-group textarea { resize: vertical; }
.form-row { display: flex; gap: 1rem; align-items: flex-end; }
.form-row .form-group { flex: 1; }
.checkbox-label { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
.checkbox-label input { width: auto; }
.error-message { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 6px; font-size: 0.875rem; }

.media-selector { border: 2px dashed #d1d5db; border-radius: 8px; padding: 1rem; text-align: center; cursor: pointer; background: #fafafa; transition: border-color 0.2s; min-height: 80px; display: flex; align-items: center; justify-content: center; }
.media-selector:hover { border-color: #FF7A00; }
.placeholder { color: #6b7280; font-size: 0.875rem; }
.selected-media { position: relative; width: 100px; height: 100px; border-radius: 6px; overflow: hidden; }
.selected-media img { width: 100%; height: 100%; object-fit: cover; }
.remove-btn { position: absolute; top: 4px; right: 4px; width: 20px; height: 20px; background: rgba(239,68,68,0.9); color: white; border: none; border-radius: 50%; cursor: pointer; font-size: 10px; display: flex; align-items: center; justify-content: center; }
.gallery-previews { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem; }
.gallery-thumb { position: relative; width: 80px; height: 80px; border-radius: 6px; overflow: hidden; }
.gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }
.gallery-remove { position: absolute; top: 2px; right: 2px; width: 20px; height: 20px; background: rgba(239,68,68,0.9); color: white; border: none; border-radius: 50%; cursor: pointer; font-size: 10px; display: flex; align-items: center; justify-content: center; }

</style>
