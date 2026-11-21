<template>
  <AdminLayout>
    <div class="admin-messages">
      <div class="header">
        <h1>Messages Inbox</h1>
      </div>

      <div class="filters">
        <div class="search-box">
          <input v-model="searchTerm" type="text" placeholder="Search name, email, or subject..." @input="debouncedSearch" />
        </div>
        <div class="filter-actions">
          <select v-model="filters.is_read" @change="loadMessages">
            <option value="">All Messages</option>
            <option value="0">Unread</option>
            <option value="1">Read</option>
          </select>
        </div>
      </div>

      <div v-if="loading" class="loading">Loading messages...</div>

      <div v-else-if="items.length === 0" class="empty-state">
        <div class="empty-icon">📭</div>
        <p>No messages found in your inbox.</p>
      </div>

       <div v-else class="message-list">
        <div 
          v-for="item in items" 
          :key="item?.id" 
          class="message-item"
          :class="{ 'unread': !item?.is_read }"
          @click="openMessage(item)"
        >
          <div class="msg-indicator"></div>
          <div class="msg-sender">
            <span class="sender-name">{{ item?.name || 'Unknown' }}</span>
            <span class="sender-email">&lt;{{ item?.email || 'no-email' }}&gt;</span>
          </div>
          <div class="msg-subject">{{ item?.subject || 'No Subject' }}</div>
          <div class="msg-snippet">- {{ truncateText(item?.message, 50) }}</div>
          <div class="msg-date">{{ formatDate(item?.created_at) }}</div>
          <div class="msg-actions">
            <button @click.stop="confirmDelete(item?.id)" class="btn-delete-icon" title="Delete">🗑️</button>
          </div>
        </div>
      </div>

      <div v-if="totalPages > 1" class="pagination">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">Previous</button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">Next</button>
      </div>

      <!-- View Message Modal -->
      <AdminModal v-model="isModalOpen" title="Message Details" :show-footer="false">
        <div v-if="selectedMessage" class="message-detail">
          <div class="detail-header">
            <div class="detail-info">
              <h3>{{ selectedMessage.subject || 'No Subject' }}</h3>
              <p class="sender">From: <strong>{{ selectedMessage.name }}</strong> ({{ selectedMessage.email }})</p>
              <p v-if="selectedMessage.phone" class="phone">Phone: {{ selectedMessage.phone }}</p>
              <p class="date">Received: {{ formatDateTime(selectedMessage.created_at) }}</p>
            </div>
          </div>
          <div class="detail-body">
            <p>{{ selectedMessage.message }}</p>
          </div>
          <div class="detail-footer">
            <a :href="'mailto:' + selectedMessage.email" class="btn-reply">Reply via Email</a>
            <button @click="confirmDelete(selectedMessage.id)" class="btn-delete-full">Delete Message</button>
          </div>
        </div>
      </AdminModal>

      <!-- Delete Modal -->
      <AdminModal
        v-model="isDeleteModalOpen"
        title="Hapus Pesan"
        confirm-text="Hapus"
        cancel-text="Batal"
        @confirm="deleteMessage"
      >
        <p>Apakah Anda yakin ingin menghapus pesan ini? Tindakan ini tidak dapat dibatalkan.</p>
      </AdminModal>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AdminLayout from '@/components/admin/AdminLayout.vue'
import AdminModal from '@/components/admin/AdminModal.vue'
import { useToast } from '@/composables/useToast'
import { messageService } from '@/services/api/message.service'

const loading = ref(true)
const items = ref([])
const currentPage = ref(1)
const totalPages = ref(1)
const searchTerm = ref('')
const filters = ref({ is_read: '' })

const isModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const selectedId = ref(null)
const selectedMessage = ref(null)

const { success, error } = useToast()

const loadMessages = async () => {
  loading.value = true
  try {
    const params = {
      page: currentPage.value, per_page: 15,
      search: searchTerm.value || undefined,
      is_read: filters.value.is_read !== '' ? filters.value.is_read : undefined
    }
    const response = await messageService.getAll(params)
    
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
    console.error('Error loading messages:', err)
    error('Failed to load messages')
    items.value = []
  } finally {
    loading.value = false
  }
}

const openMessage = async (item) => {
  selectedMessage.value = item
  isModalOpen.value = true
  
  if (!item.is_read) {
    try {
      await messageService.markAsRead(item.id)
      item.is_read = true // update local state
    } catch (err) {
      console.error('Failed to mark message as read', err)
    }
  }
}

const confirmDelete = (id) => {
  selectedId.value = id
  isDeleteModalOpen.value = true
  isModalOpen.value = false
}

const deleteMessage = async () => {
  try {
    await messageService.delete(selectedId.value)
    success('Message deleted successfully')
    isDeleteModalOpen.value = false
    loadMessages()
  } catch (err) {
    error('Failed to delete message')
    isDeleteModalOpen.value = false
  }
}

const changePage = (page) => {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
  loadMessages()
}

const truncateText = (text, length) => {
  if (!text) return ''
  return text.length <= length ? text : text.substring(0, length) + '...'
}

const formatDate = (dateStr) => {
  if (!dateStr) return ''
  const d = new Date(dateStr)
  return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })
}

const formatDateTime = (dateStr) => {
  if (!dateStr) return ''
  const d = new Date(dateStr)
  return d.toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })
}

let searchTimeout
const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => { currentPage.value = 1; loadMessages() }, 500)
}

onMounted(() => loadMessages())
</script>

<style scoped>

.header { margin-bottom: 2rem;   flex-wrap: wrap;
  gap: 1rem;
}
.header h1 { margin: 0; font-size: 1.875rem; font-weight: 600; }
.filters { display: flex; gap: 1rem; margin-bottom: 2rem; }
.search-box input { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; width: 100%;
  max-width: 300px; }
.filter-actions select { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; background: white; }
.loading { text-align: center; padding: 2rem; color: #6b7280; }
.empty-state { text-align: center; padding: 4rem; background: #f9fafb; border-radius: 8px; color: #6b7280; }
.empty-icon { font-size: 3rem; margin-bottom: 1rem; }

.message-list { display: flex; flex-direction: column; background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow-x: auto; }
.message-item { display: flex; align-items: center; padding: 12px 16px; border-bottom: 1px solid #f3f4f6; cursor: pointer; transition: background 0.2s; position: relative; min-width: 700px; }
.message-item:last-child { border-bottom: none; }
.message-item:hover { background: #f9fafb; }
.message-item.unread { background: #fff7ed; }
.message-item.unread .sender-name { font-weight: 700; color: #111827; }
.message-item.unread .msg-subject { font-weight: 600; color: #111827; }

.msg-indicator { width: 8px; height: 8px; border-radius: 50%; background: transparent; margin-right: 12px; flex-shrink: 0; }
.message-item.unread .msg-indicator { background: #FF7A00; }

.msg-sender { width: 220px; flex-shrink: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; flex-direction: column; }
.sender-name { font-size: 0.9rem; color: #4b5563; }
.sender-email { font-size: 0.75rem; color: #9ca3af; }

.msg-subject { font-size: 0.9rem; color: #4b5563; margin-right: 8px; white-space: nowrap; }
.msg-snippet { flex: 1; font-size: 0.9rem; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.msg-date { width: 80px; text-align: right; font-size: 0.8rem; color: #6b7280; flex-shrink: 0; margin-left: 16px; }

.msg-actions { margin-left: 16px; opacity: 0; transition: opacity 0.2s; }
.message-item:hover .msg-actions { opacity: 1; }
.btn-delete-icon { background: none; border: none; cursor: pointer; font-size: 1rem; opacity: 0.6; padding: 4px; border-radius: 4px; }
.btn-delete-icon:hover { opacity: 1; background: #fee2e2; }

.pagination { display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 2rem; }
.pagination button { padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 4px; background: white; cursor: pointer; }
.pagination button:disabled { opacity: 0.5; cursor: not-allowed; }

.message-detail { display: flex; flex-direction: column; gap: 1.5rem; }
.detail-header { border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem; }
.detail-info h3 { margin: 0 0 0.5rem 0; font-size: 1.25rem; color: #111827; }
.detail-info p { margin: 0 0 0.25rem 0; font-size: 0.875rem; color: #4b5563; }
.detail-info .sender { font-size: 0.95rem; }
.detail-info .date { color: #6b7280; font-size: 0.8rem; margin-top: 0.5rem; }
.detail-body { font-size: 0.95rem; line-height: 1.6; color: #374151; white-space: pre-wrap; padding: 1rem 0; }
.detail-footer { display: flex; gap: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1.5rem; }
.btn-reply { background: #FF7A00; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; text-align: center; }
.btn-reply:hover { background: #FF7A00; }
.btn-delete-full { background: white; color: #ef4444; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 6px; font-weight: 500; cursor: pointer; }
.btn-delete-full:hover { background: #fef2f2; }
</style>
