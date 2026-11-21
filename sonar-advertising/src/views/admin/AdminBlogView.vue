<template>
  <AdminLayout>
    <div class="admin-blog">
      <div class="header">
        <h1>Blog Management</h1>
        <button @click="openCreateModal" class="btn-primary">
          <span>+ New Article</span>
        </button>
      </div>

      <div class="filters">
        <div class="search-box">
          <input v-model="searchTerm" type="text" placeholder="Search articles..." @input="debouncedSearch" />
        </div>
        <div class="filter-actions">
          <select v-model="filters.status" @change="loadBlog">
            <option value="">All Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
          </select>
          <select v-model="filters.category" @change="loadBlog">
            <option value="">All Categories</option>
            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
          </select>
        </div>
      </div>

      <div v-if="loading" class="loading">Loading articles...</div>

      <div v-else-if="items.length === 0" class="empty-state">
        No articles found. Write your first one!
      </div>

      <div v-else class="blog-table-wrapper">
        <table class="blog-table">
          <thead>
            <tr>
              <th style="width:60px">Image</th>
              <th>Title</th>
              <th>Category</th>
              <th>Status</th>
              <th>Published</th>
              <th style="width:140px">Actions</th>
            </tr>
          </thead>
          <tbody>
             <tr v-for="item in items" :key="item?.id">
               <td>
                 <div class="table-thumb">
                   <img loading="lazy" v-if="item?.thumbnail" :src="getImageUrl(item.thumbnail)" :alt="item?.title" />
                   <div v-else class="thumb-empty">—</div>
                 </div>
               </td>
               <td>
                 <div class="blog-title">{{ item?.title || 'Untitled' }}</div>
                 <div class="blog-slug">{{ item?.slug }}</div>
               </td>
               <td><span v-if="item?.category" class="category-tag">{{ item.category }}</span></td>
               <td>
                 <span class="status-badge" :class="item?.status">{{ item?.status || 'draft' }}</span>
               </td>
               <td class="date-cell">{{ item?.published_at ? formatDate(item.published_at) : '—' }}</td>
               <td>
                 <div class="action-btns">
                   <button @click="openEditModal(item)" class="btn-edit">Edit</button>
                   <button @click="confirmDelete(item?.id)" class="btn-delete">Delete</button>
                 </div>
               </td>
             </tr>
          </tbody>
        </table>
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
        @confirm="saveBlog"
      >
        <div class="modal-form">
          <div v-if="Object.keys(formErrors).length" class="error-message">
            <p v-for="(err, key) in formErrors" :key="key">{{ Array.isArray(err) ? err.join(', ') : err }}</p>
          </div>

          <div class="form-group">
            <label>Judul *</label>
            <input v-model="form.title" type="text" placeholder="Judul artikel" @input="generateSlug" />
          </div>

          <div class="form-group">
            <label>Slug (Tautan)</label>
            <input v-model="form.slug" type="text" placeholder="slug-otomatis" class="slug-input" readonly />
          </div>

          <div class="form-group">
            <label>Ringkasan</label>
            <textarea v-model="form.summary" rows="4" placeholder="Ringkasan singkat artikel"></textarea>
          </div>

          <div class="form-group quill-group">
            <label>Konten *</label>
            <div class="quill-wrapper">
              <QuillEditor v-model:content="form.content" contentType="html" theme="snow" />
            </div>
          </div>

          <div class="form-group">
            <label>Gambar Utama</label>
            <div class="media-selector" @click="openMediaPicker">
              <div v-if="form.thumbnail" class="selected-media">
                <img loading="lazy" :src="getImageUrl(form.thumbnail)" alt="Thumbnail" />
                <button type="button" @click.stop="form.thumbnail = null" class="remove-btn">✕</button>
              </div>
              <div v-else class="placeholder">Klik untuk memilih dari Galeri Media</div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Kategori</label>
              <input v-model="form.category" type="text" placeholder="misal: Teknologi, Bisnis" />
            </div>
            <div class="form-group">
              <label>Status *</label>
              <select v-model="form.status">
                <option value="draft">Draf</option>
                <option value="published">Diterbitkan</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label>Tag <small>(pisahkan dengan koma)</small></label>
            <input v-model="tagsInput" type="text" placeholder="tag1, tag2, tag3" />
          </div>

          <div class="form-group">
            <label>Tanggal Terbit</label>
            <input v-model="form.published_at" type="datetime-local" />
          </div>
        </div>
      </AdminModal>

      <!-- Delete Modal -->
      <AdminModal
        v-model="isDeleteModalOpen"
        title="Hapus Artikel"
        confirm-text="Hapus"
        cancel-text="Batal"
        @confirm="deleteBlog"
      >
        <p>Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.</p>
      </AdminModal>

      <MediaPickerModal v-model="isMediaPickerOpen" @select="handleMediaSelect" />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted, defineAsyncComponent } from 'vue'
import AdminLayout from '@/components/admin/AdminLayout.vue'
import AdminModal from '@/components/admin/AdminModal.vue'
import MediaPickerModal from '@/components/admin/MediaPickerModal.vue'
import { blogService } from '@/services/api/blog.service'
import { useToast } from '@/composables/useToast'

const QuillEditor = defineAsyncComponent(async () => {
  await import('@vueup/vue-quill/dist/vue-quill.snow.css')
  const mod = await import('@vueup/vue-quill')
  return mod.QuillEditor
})

const loading = ref(true)
const items = ref([])
const currentPage = ref(1)
const totalPages = ref(1)
const searchTerm = ref('')
const filters = ref({ status: '', category: '' })
const categories = ref(['Technology', 'Business', 'Design', 'Marketing', 'News'])

const isModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const modalLoading = ref(false)
const modalMode = ref('create')
const formErrors = ref({})
const selectedId = ref(null)
const tagsInput = ref('')

const isMediaPickerOpen = ref(false)

const form = ref({
  title: '', slug: '', summary: '', content: '', thumbnail: null,
  category: '', tags: [], status: 'published', published_at: new Date().toISOString().substring(0, 16)
})

const { success, error } = useToast()

const modalTitle = computed(() => modalMode.value === 'create' ? 'Artikel Baru' : 'Edit Artikel')

const getImageUrl = (path) => {
  if (!path) return ''
  if (path.startsWith('http')) return path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  return apiBase.replace('/api', '') + path
}

const slugify = (text) => text.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')

const generateSlug = () => {
  if (modalMode.value === 'create') {
    form.value.slug = slugify(form.value.title)
  }
}

const loadBlog = async () => {
  loading.value = true
  try {
    const params = {
      page: currentPage.value, per_page: 15,
      search: searchTerm.value || undefined,
      status: filters.value.status || undefined,
      category: filters.value.category || undefined
    }
    const response = await blogService.getAll(params)
    
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
    console.error('Error loading blog:', err)
    error('Failed to load articles')
    items.value = []
  } finally {
    loading.value = false
  }
}

const openCreateModal = () => {
  modalMode.value = 'create'
  form.value = { title: '', slug: '', summary: '', content: '', thumbnail: null, category: '', tags: [], status: 'published', published_at: new Date().toISOString().substring(0, 16) }
  tagsInput.value = ''
  formErrors.value = {}
  isModalOpen.value = true
}

const openEditModal = (item) => {
  modalMode.value = 'edit'
  selectedId.value = item.id
  form.value = {
    title: item.title, slug: item.slug, summary: item.summary || '',
    content: item.content || '', thumbnail: item.thumbnail || null, category: item.category || '',
    tags: item.tags || [], status: item.status,
    published_at: item.published_at ? item.published_at.substring(0, 16) : ''
  }
  tagsInput.value = (item.tags || []).join(', ')
  formErrors.value = {}
  isModalOpen.value = true
}

const openMediaPicker = () => {
  isMediaPickerOpen.value = true
}

const handleMediaSelect = (path) => {
  form.value.thumbnail = path
}

const saveBlog = async () => {
  modalLoading.value = true
  formErrors.value = {}
  form.value.tags = tagsInput.value.split(',').map(t => t.trim()).filter(Boolean)

  // Auto-set published_at if status is published but no date provided
  const payload = { ...form.value }
  if (payload.status === 'published' && !payload.published_at) {
    payload.published_at = new Date().toISOString().substring(0, 16)
  }
  // Don't send empty published_at string — send null instead
  if (!payload.published_at) {
    payload.published_at = null
  }

  try {
    if (modalMode.value === 'create') {
      await blogService.create(payload)
      success('Article created successfully')
    } else {
      await blogService.update(selectedId.value, payload)
      success('Article updated successfully')
    }
    isModalOpen.value = false
    loadBlog()
  } catch (err) {
    if (err.response?.status === 422) {
      formErrors.value = err.response.data.errors
    } else {
      error('Failed to save article')
    }
  } finally {
    modalLoading.value = false
  }
}

const confirmDelete = (id) => {
  selectedId.value = id
  isDeleteModalOpen.value = true
}

const deleteBlog = async () => {
  try {
    await blogService.delete(selectedId.value)
    success('Article deleted successfully')
    isDeleteModalOpen.value = false
    loadBlog()
  } catch (err) {
    error('Failed to delete article')
    isDeleteModalOpen.value = false
  }
}

const changePage = (page) => {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
  loadBlog()
}

const formatDate = (dateStr) => {
  if (!dateStr) return ''
  const d = new Date(dateStr)
  return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
}

let searchTimeout
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => { currentPage.value = 1; loadBlog() }, 500)
}

onMounted(() => loadBlog())
</script>

<style scoped>

.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
.header h1 { margin: 0; font-size: 1.875rem; font-weight: 600; }
.btn-primary { background: #FF7A00; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: 500; }
.btn-primary:hover { background: #ea580c; }
.filters { display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; }
.search-box input { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; width: 100%;
  max-width: 300px; }
.filter-actions { display: flex; gap: 0.5rem; }
.filter-actions select { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; background: white; }
.loading { text-align: center; padding: 2rem; color: #6b7280; }
.empty-state { text-align: center; padding: 3rem; background: #f9fafb; border-radius: 8px; color: #6b7280; }

.blog-table-wrapper { overflow-x: auto; width: 100%; }
.blog-table { width: 100%; min-width: 800px; border-collapse: collapse; background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; }
.blog-table thead th { background: #f9fafb; padding: 12px 16px; text-align: left; font-size: 0.75rem; text-transform: uppercase; color: #6b7280; font-weight: 600; border-bottom: 1px solid #e5e7eb; }
.blog-table tbody td { padding: 12px 16px; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
.blog-table tbody tr:hover { background: #f9fafb; }
.table-thumb { width: 48px; height: 36px; border-radius: 4px; overflow: hidden; background: #f3f4f6; }
.table-thumb img { width: 100%; height: 100%; object-fit: cover; }
.thumb-empty { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #d1d5db; font-size: 0.75rem; }
.blog-title { font-weight: 600; font-size: 0.875rem; color: #1f2937; }
.blog-slug { font-size: 0.75rem; color: #9ca3af; margin-top: 2px; }
.category-tag { background: #fff7ed; color: #FF7A00; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 500; }
.status-badge { padding: 2px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 500; text-transform: capitalize; }
.status-badge.published { background: #d1fae5; color: #065f46; }
.status-badge.draft { background: #fef3c7; color: #92400e; }
.date-cell { font-size: 0.8rem; color: #6b7280; white-space: nowrap; }
.action-btns { display: flex; gap: 0.5rem; }
.btn-edit { background: #FF7A00; color: white; padding: 4px 10px; border-radius: 4px; border: none; cursor: pointer; font-size: 0.8rem; }
.btn-edit:hover { background: #FF7A00; }
.btn-delete { background: #ef4444; color: white; padding: 4px 10px; border-radius: 4px; border: none; cursor: pointer; font-size: 0.8rem; }
.btn-delete:hover { background: #dc2626; }

.pagination { display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 2rem; }
.pagination button { padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 4px; background: white; cursor: pointer; }
.pagination button:disabled { opacity: 0.5; cursor: not-allowed; }

.modal-form { display: flex; flex-direction: column; gap: 1rem; }
.form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151; font-size: 0.875rem; }
.form-group label small { font-weight: 400; color: #9ca3af; }
.form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem; }
.form-group textarea { resize: vertical; font-family: inherit; }
.slug-input { background: #f3f4f6; color: #6b7280; }
.form-row { display: flex; gap: 1rem; }
.form-row .form-group { flex: 1; }
.error-message { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 6px; font-size: 0.875rem; }

.quill-group { display: flex; flex-direction: column; }
.quill-wrapper { background: white; }
.media-selector { border: 2px dashed #d1d5db; border-radius: 8px; padding: 1rem; text-align: center; cursor: pointer; background: #fafafa; transition: border-color 0.2s; min-height: 80px; display: flex; align-items: center; justify-content: center; }
.media-selector:hover { border-color: #FF7A00; }
.placeholder { color: #6b7280; font-size: 0.875rem; }
.selected-media { position: relative; width: 100px; height: 100px; border-radius: 6px; overflow: hidden; }
.selected-media img { width: 100%; height: 100%; object-fit: cover; }
.remove-btn { position: absolute; top: 4px; right: 4px; width: 20px; height: 20px; background: rgba(239,68,68,0.9); color: white; border: none; border-radius: 50%; cursor: pointer; font-size: 10px; display: flex; align-items: center; justify-content: center; }
</style>
