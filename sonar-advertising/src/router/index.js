import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useLoadingStore } from '@/stores/loading'

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
    path: '/blog/:id',
    name: 'BlogDetail',
    component: () => import('@/views/BlogDetailView.vue')
  },
  {
    path: '/testimonials',
    name: 'Testimonials',
    component: () => import('@/views/TestimonialsView.vue')
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import('@/views/ContactView.vue')
  },
  {
    path: '/privacy',
    name: 'Privacy',
    component: () => import('@/views/PrivacyView.vue')
  },
  {
    path: '/terms',
    name: 'Terms',
    component: () => import('@/views/TermsView.vue')
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/LoginView.vue'),
    meta: { requiresGuest: true, hideNavigation: true }
  },

  // ── Admin routes ───────────────────────────────────────────
  // Admin routes memakai AdminLayout sendiri (bukan App.vue),
  // jadi Navbar & Footer publik tidak akan muncul di halaman admin.
  {
    path: '/admin',
    name: 'AdminDashboard',
    component: () => import('@/views/admin/AdminDashboardView.vue'),
    meta: { isAdmin: true, requiresAuth: true }
  },

  {
    path: '/admin/portfolio',
    name: 'AdminPortfolio',
    component: () => import('@/views/admin/AdminPortfolioView.vue'),
    meta: { isAdmin: true, requiresAuth: true }
  },
  {
    path: '/admin/blog',
    name: 'AdminBlog',
    component: () => import('@/views/admin/AdminBlogView.vue'),
    meta: { isAdmin: true, requiresAuth: true }
  },
  {
    path: '/admin/testimonials',
    name: 'AdminTestimonials',
    component: () => import('@/views/admin/AdminTestimonialsView.vue'),
    meta: { isAdmin: true, requiresAuth: true }
  },
  {
    path: '/admin/gallery',
    name: 'AdminGallery',
    component: () => import('@/views/admin/AdminGalleryView.vue'),
    meta: { isAdmin: true, requiresAuth: true }
  },
  {
    path: '/admin/messages',
    name: 'AdminMessages',
    component: () => import('@/views/admin/AdminMessagesView.vue'),
    meta: { isAdmin: true, requiresAuth: true }
  },
  {
    path: '/admin/settings',
    name: 'AdminSettings',
    component: () => import('@/views/admin/AdminSettingsView.vue'),
    meta: { isAdmin: true, requiresAuth: true }
  },

  // ── 404 Catch-all route ──────────────────────────────────
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('@/views/NotFoundView.vue'),
    meta: { hideNavigation: true }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) return savedPosition
    return { top: 0, behavior: 'smooth' }
  }
})

router.beforeEach((to, from, next) => {
  try {
    const loadingStore = useLoadingStore()
    loadingStore.startNavigation(to.path)
  } catch {}

  const authStore = useAuthStore()
  authStore.checkAuth()

  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
  const requiresGuest = to.matched.some(record => record.meta.requiresGuest)

  if (requiresAuth && !authStore.isAuthenticated) {
    next('/login')
  } else if (requiresGuest && authStore.isAuthenticated) {
    next('/admin')
  } else {
    next()
  }
})

router.afterEach(() => {
  try {
    const loadingStore = useLoadingStore()
    loadingStore.finishNavigation()
  } catch {}
})

router.onError(() => {
  try {
    const loadingStore = useLoadingStore()
    loadingStore.finishNavigation()
  } catch {}
})

export default router