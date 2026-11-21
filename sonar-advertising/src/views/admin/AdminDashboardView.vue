<template>
  <AdminLayout>
    <div class="admin-dashboard">
      <h1>Dashboard</h1>
      
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6M2 20h20"/>
            </svg>
          </div>
          <div class="stat-content">
            <h3>Total Services</h3>
            <p class="stat-value">{{ stats.total_services || 0 }}</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="20" height="14" x="2" y="5" rx="2"/>
              <path d="M2 10h20"/>
            </svg>
          </div>
          <div class="stat-content">
            <h3>Total Portfolio</h3>
            <p class="stat-value">{{ stats.total_portfolio || 0 }}</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
            </svg>
          </div>
          <div class="stat-content">
            <h3>Total Blog Posts</h3>
            <p class="stat-value">{{ stats.total_blog_posts || 0 }}</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.1.243-2.184.7-3.126C6.303 10.788 7.07 12.083 8.5 14.5Z"/>
            </svg>
          </div>
          <div class="stat-content">
            <h3>Total Testimonials</h3>
            <p class="stat-value">{{ stats.total_testimonials || 0 }}</p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
          </div>
          <div class="stat-content">
            <h3>Total Messages</h3>
            <p class="stat-value">{{ stats.total_messages || 0 }}</p>
            <p class="stat-subtext" v-if="stats.total_unread_messages">
              {{ stats.total_unread_messages }} unread
            </p>
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
              <circle cx="8.5" cy="8.5" r="1.5"/>
              <path d="M21 15l-5-5L5 21"/>
            </svg>
          </div>
          <div class="stat-content">
            <h3>Total Gallery</h3>
            <p class="stat-value">{{ stats.total_gallery || 0 }}</p>
          </div>
        </div>
      </div>

      <h2 class="section-title">Recent Activity</h2>
      
      <div v-if="recentActivity" class="activity-list">
        <div v-if="recentActivity.recent_services.length > 0" class="activity-section">
          <h3>Services</h3>
          <ul>
            <li v-for="item in recentActivity.recent_services" :key="item.id">
              {{ item.title }}
              <span class="timestamp">{{ formatDate(item.updated_at) }}</span>
            </li>
          </ul>
        </div>

        <div v-if="recentActivity.recent_portfolio.length > 0" class="activity-section">
          <h3>Portfolio</h3>
          <ul>
            <li v-for="item in recentActivity.recent_portfolio" :key="item.id">
              {{ item.title }}
              <span class="timestamp">{{ formatDate(item.updated_at) }}</span>
            </li>
          </ul>
        </div>

        <div v-if="recentActivity.recent_blog_posts.length > 0" class="activity-section">
          <h3>Blog Posts</h3>
          <ul>
            <li v-for="item in recentActivity.recent_blog_posts" :key="item.id">
              {{ item.title }}
              <span class="timestamp">{{ formatDate(item.updated_at) }}</span>
            </li>
          </ul>
        </div>

        <div v-if="recentActivity.recent_testimonials.length > 0" class="activity-section">
          <h3>Testimonials</h3>
          <ul>
            <li v-for="item in recentActivity.recent_testimonials" :key="item.id">
              {{ item.name }}
              <span class="timestamp">{{ formatDate(item.updated_at) }}</span>
            </li>
          </ul>
        </div>

        <div v-if="recentActivity.recent_messages.length > 0" class="activity-section">
          <h3>Messages</h3>
          <ul>
            <li v-for="item in recentActivity.recent_messages" :key="item.id">
              {{ item.name }}: {{ item.subject || 'No subject' }}
              <span class="timestamp">{{ formatDate(item.updated_at) }}</span>
            </li>
          </ul>
        </div>
      </div>

      <div v-else class="empty-activity">
        No recent activity found.
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AdminLayout from '@/components/admin/AdminLayout.vue'
import { dashboardService } from '@/services/api/dashboard.service'
import { useToast } from '@/composables/useToast'

const loading = ref(true)
const stats = ref({})
const recentActivity = ref(null)
const { success, error } = useToast()

const loadDashboard = async () => {
  loading.value = true
  try {
    const [statsResponse, activityResponse] = await Promise.all([
      dashboardService.getStats(),
      dashboardService.getRecentActivity()
    ])
    
    stats.value = statsResponse.data
    recentActivity.value = activityResponse.data
  } catch (err) {
    console.error('Error loading dashboard:', err)
    error('Failed to load dashboard data')
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric', 
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

onMounted(() => {
  loadDashboard()
})
</script>

<style scoped>


.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(min(100%, 200px), 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.stat-icon {
  width: 48px;
  height: 48px;
  background: #fff7ed; /* orange-50 */
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FF7A00; /* brand.orange */
}

.stat-content h3 {
  margin: 0 0 0.25rem 0;
  font-size: 0.875rem;
  color: #6b7280;
}

.stat-value {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
}

.stat-subtext {
  font-size: 0.75rem;
  color: #ef4444;
  margin: 0.25rem 0 0 0;
}

.section-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1rem;
  color: #1f2937;
}

.activity-list {
  background: white;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  overflow: hidden;
}

.activity-section {
  border-bottom: 1px solid #e5e7eb;
}

.activity-section:last-child {
  border-bottom: none;
}

.activity-section h3 {
  margin: 0;
  padding: 1rem 1.5rem;
  font-size: 0.875rem;
  color: #6b7280;
  background: #f9fafb;
}

.activity-section ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

.activity-section li {
  padding: 0.75rem 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #f3f4f6;
}

.activity-section li:last-child {
  border-bottom: none;
}

.timestamp {
  color: #9ca3af;
  font-size: 0.75rem;
}

.empty-activity {
  text-align: center;
  padding: 3rem;
  color: #6b7280;
}
</style>