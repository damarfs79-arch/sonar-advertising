import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  // ── Public routes ──────────────────────────────────────────
  {
    path: '/',
    name: 'Home',
    component: () => import('@/views/HomeView.vue')
  },
  {
    path: '/about',
    name: 'About',
    component: () => import('@/views/AboutView.vue')
  },
  {
    path: '/services',
    name: 'Services',
    component: () => import('@/views/ServicesView.vue')
  },
  {
    path: '/portfolio',
    name: 'Portfolio',
    component: () => import('@/views/PortfolioView.vue')
  },
  {
    path: '/blog',
    name: 'Blog',
    component: () => import('@/views/BlogView.vue')
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import('@/views/ContactView.vue')
  },

  // ── Admin routes ───────────────────────────────────────────
  // Admin routes memakai AdminLayout sendiri (bukan App.vue),
  // jadi Navbar & Footer publik tidak akan muncul di halaman admin.
  {
    path: '/admin',
    name: 'AdminDashboard',
    component: () => import('@/views/admin/AdminDashboardView.vue'),
    meta: { isAdmin: true }
  },
  {
    path: '/admin/services',
    name: 'AdminServices',
    component: () => import('@/views/admin/AdminServicesView.vue'),
    meta: { isAdmin: true }
  },
  {
    path: '/admin/portfolio',
    name: 'AdminPortfolio',
    component: () => import('@/views/admin/AdminPortfolioView.vue'),
    meta: { isAdmin: true }
  },
  {
    path: '/admin/blog',
    name: 'AdminBlog',
    component: () => import('@/views/admin/AdminBlogView.vue'),
    meta: { isAdmin: true }
  },
  {
    path: '/admin/testimonials',
    name: 'AdminTestimonials',
    component: () => import('@/views/admin/AdminTestimonialsView.vue'),
    meta: { isAdmin: true }
  },
  {
    path: '/admin/gallery',
    name: 'AdminGallery',
    component: () => import('@/views/admin/AdminGalleryView.vue'),
    meta: { isAdmin: true }
  },
  {
    path: '/admin/messages',
    name: 'AdminMessages',
    component: () => import('@/views/admin/AdminMessagesView.vue'),
    meta: { isAdmin: true }
  },
  {
    path: '/admin/settings',
    name: 'AdminSettings',
    component: () => import('@/views/admin/AdminSettingsView.vue'),
    meta: { isAdmin: true }
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    return { top: 0, behavior: 'smooth' }
  }
})

export default router