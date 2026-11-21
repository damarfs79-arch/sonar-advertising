<template>
  <div class="admin-layout">
    <button class="mobile-menu-btn" @click="isSidebarOpen = !isSidebarOpen">
      <svg v-if="!isSidebarOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
      <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>

    <div class="sidebar-overlay" :class="{ 'active': isSidebarOpen }" @click="isSidebarOpen = false"></div>

    <div class="sidebar" :class="{ 'open': isSidebarOpen }">
      <div class="sidebar-header">
        <h2>Admin Panel</h2>
      </div>
      <nav @click="isSidebarOpen = false">
        <RouterLink to="/admin" class="nav-item" exact-active-class="router-link-active">Dashboard</RouterLink>

        <RouterLink to="/admin/portfolio" class="nav-item" active-class="router-link-active">Portfolio</RouterLink>
        <RouterLink to="/admin/blog" class="nav-item" active-class="router-link-active">Blog</RouterLink>
        <RouterLink to="/admin/testimonials" class="nav-item" active-class="router-link-active">Testimonials</RouterLink>
        <RouterLink to="/admin/messages" class="nav-item" active-class="router-link-active">Messages</RouterLink>
        <RouterLink to="/admin/gallery" class="nav-item" active-class="router-link-active">Gallery</RouterLink>
        <RouterLink to="/admin/settings" class="nav-item" active-class="router-link-active">Settings</RouterLink>
      </nav>
      <div class="sidebar-footer">
        <button type="button" @click="handleLogout" class="nav-item logout w-full text-left">Logout</button>
        <RouterLink to="/" class="nav-item back">Back to Site</RouterLink>
      </div>
    </div>
    <div class="content">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()
const isSidebarOpen = ref(false)

const handleLogout = async () => {
  try {
    await authStore.logout()
  } catch (e) {
    // continue
  }
  router.push('/login')
}
</script>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
  background: #f8fafc;
}

.mobile-menu-btn {
  display: none;
  position: fixed;
  top: 1rem;
  left: 1rem;
  z-index: 100;
  background: white;
  color: #1f2937;
  border: 1px solid #e5e7eb;
  padding: 0.5rem;
  border-radius: 8px;
  cursor: pointer;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.sidebar-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(15, 23, 42, 0.5);
  backdrop-filter: blur(4px);
  z-index: 98;
}

.sidebar {
  width: 260px;
  background: white;
  border-right: 1px solid #e5e7eb;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  z-index: 99;
}

.sidebar-header {
  margin-bottom: 2rem;
  padding: 0 0.5rem;
}

.sidebar-header h2 {
  color: #111827;
  margin: 0;
  font-weight: 700;
  font-size: 1.25rem;
  letter-spacing: -0.025em;
}

nav {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  flex: 1;
}

.nav-item {
  display: block;
  padding: 0.75rem 1rem;
  color: #4b5563;
  text-decoration: none;
  border-radius: 8px;
  transition: all 0.2s ease;
  cursor: pointer;
  font-weight: 500;
  font-size: 0.95rem;
}

.nav-item:hover {
  background: #fff7ed;
  color: #ea580c;
}

.nav-item.router-link-active {
  background: #FF7A00;
  color: white;
  box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.2), 0 2px 4px -1px rgba(249, 115, 22, 0.1);
}

.sidebar-footer {
  margin-top: auto;
  padding-top: 1.5rem;
  border-top: 1px solid #e5e7eb;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.nav-item.logout {
  background: #fef2f2;
  color: #ef4444;
}

.nav-item.logout:hover {
  background: #fee2e2;
  color: #dc2626;
}

.nav-item.back {
  background: #f0fdf4;
  color: #16a34a;
}

.nav-item.back:hover {
  background: #dcfce7;
  color: #15803d;
}

.content {
  flex: 1;
  padding: 2rem;
  background: #f8fafc;
  width: 100%;
  min-width: 0;
  overflow-x: hidden;
}

@media (max-width: 768px) {
  .mobile-menu-btn {
    display: block;
  }
  
  .sidebar-overlay.active {
    display: block;
  }

  .sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    transform: translateX(-100%);
  }

  .sidebar.open {
    transform: translateX(0);
  }

  .content {
    padding-top: 5rem;
    padding-left: 1rem;
    padding-right: 1rem;
  }
}
</style>