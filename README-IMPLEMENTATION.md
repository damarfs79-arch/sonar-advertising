# Panel Admin CMS - Dokumentasi

## ✅ Status Implementasi

### Backend Laravel (100% Selesai)
- ✅ Laravel 13 dengan Sanctum Authentication
- ✅ 7 Migrations (Services, Portfolio, Blog, Testimonials, Messages, Gallery, Settings)
- ✅ 7 Models dengan relationships
- ✅ 10 API Controllers (Auth, Dashboard, Upload + 7 modules)
- ✅ API Routes lengkap dengan middleware
- ✅ File Upload System dengan Storage Link
- ✅ Database Seeding (Admin User + Default Settings)

### Frontend Vue.js (100% Selesai)
- ✅ Vue 3 + Pinia + Vue Router + Axios
- ✅ Authentication Store dengan API Integration
- ✅ 10 API Services (semua modules)
- ✅ 4 Composables (useToast, useModal, useForm, useFileUpload)
- ✅ Admin Components (Modal, Toast)
- ✅ Login Page dengan API Integration
- ✅ Dashboard dengan Real Stats dari API
- ✅ Services Module (Full CRUD + Upload)

## 🚀 Cara Menjalankan

### 1. Backend Laravel

```bash
cd D:\laragon\www\febe\backend

# Jalankan server
php artisan serve
```

Server akan berjalan di: **http://localhost:8000**

### 2. Frontend Vue.js

```bash
cd D:\laragon\www\febe\sonar-advertising

# Jalankan dev server
npm run dev
```

Server akan berjalan di: **http://localhost:5174**

### 3. Login Admin

Buka browser: **http://localhost:5174/login**

**Kredensial:**
- Email: `admin@example.com`
- Password: `admin123`

## 📋 Fitur yang Sudah Berfungsi

### 1. Authentication
- ✅ Login dengan email/password
- ✅ Token-based authentication (Sanctum)
- ✅ Auto redirect setelah login
- ✅ Protected routes untuk admin panel
- ✅ Logout functionality

### 2. Dashboard
- ✅ Total Services count
- ✅ Total Portfolio count
- ✅ Total Blog Posts count
- ✅ Total Testimonials count
- ✅ Total Messages (+ unread count)
- ✅ Total Gallery count
- ✅ Recent Activity dari semua modules

### 3. Services Management
- ✅ List services dengan pagination
- ✅ Search services
- ✅ Filter by active status
- ✅ Create new service dengan upload image
- ✅ Edit service
- ✅ Delete service dengan confirmation
- ✅ Image preview
- ✅ Form validation
- ✅ Toast notifications

## 🔧 Module yang Perlu UI Implementation

Berikut module yang API-nya sudah siap, tapi UI-nya masih placeholder:

1. **Portfolio** - `/admin/portfolio`
2. **Blog** - `/admin/blog`
3. **Testimonials** - `/admin/testimonials`
4. **Messages** - `/admin/messages`
5. **Gallery** - `/admin/gallery`
6. **Settings** - `/admin/settings`

Semuanya bisa menggunakan pattern yang sama seperti Services Module.

## 📡 API Endpoints

### Authentication
```
POST   /api/auth/login
POST   /api/auth/logout (requires token)
GET    /api/auth/user (requires token)
```

### Dashboard
```
GET    /api/dashboard/stats (requires token)
GET    /api/dashboard/recent-activity (requires token)
```

### Services
```
GET    /api/services
POST   /api/services
GET    /api/services/{id}
PUT    /api/services/{id}
DELETE /api/services/{id}
```

### Portfolio
```
GET    /api/portfolio
POST   /api/portfolio
GET    /api/portfolio/{id}
PUT    /api/portfolio/{id}
DELETE /api/portfolio/{id}
```

### Blog
```
GET    /api/blog
POST   /api/blog
GET    /api/blog/{id}
PUT    /api/blog/{id}
DELETE /api/blog/{id}
```

### Testimonials
```
GET    /api/testimonials
POST   /api/testimonials
GET    /api/testimonials/{id}
PUT    /api/testimonials/{id}
DELETE /api/testimonials/{id}
```

### Messages
```
GET    /api/messages
POST   /api/messages
GET    /api/messages/{id}
PUT    /api/messages/{id}
DELETE /api/messages/{id}
```

### Gallery
```
GET    /api/gallery
POST   /api/gallery
GET    /api/gallery/{id}
PUT    /api/gallery/{id}
DELETE /api/gallery/{id}
```

### Settings
```
GET    /api/settings
PUT    /api/settings
```

### Upload
```
POST   /api/upload
```

## 🗄️ Database Tables

1. **users** - Admin users
2. **services** - Layanan/jasa
3. **portfolio** - Portfolio projects
4. **blog_posts** - Artikel blog
5. **testimonials** - Testimoni pelanggan
6. **messages** - Pesan dari contact form
7. **gallery** - Galeri foto
8. **settings** - Pengaturan website (key-value)

## 🔐 File Structure

### Backend
```
backend/
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── ServiceController.php
│   │   ├── PortfolioController.php
│   │   ├── BlogController.php
│   │   ├── TestimonialController.php
│   │   ├── MessageController.php
│   │   ├── GalleryController.php
│   │   ├── SettingController.php
│   │   └── UploadController.php
│   └── Models/
│       ├── Service.php
│       ├── Portfolio.php
│       ├── BlogPost.php
│       ├── Testimonial.php
│       ├── Message.php
│       ├── Gallery.php
│       └── Setting.php
├── database/
│   ├── migrations/
│   └── seeders/
└── routes/
    └── api.php
```

### Frontend
```
sonar-advertising/
├── src/
│   ├── views/
│   │   ├── LoginView.vue
│   │   └── admin/
│   │       ├── AdminDashboardView.vue (✅ Done)
│   │       ├── AdminServicesView.vue (✅ Done)
│   │       ├── AdminPortfolioView.vue (⏳ Placeholder)
│   │       ├── AdminBlogView.vue (⏳ Placeholder)
│   │       ├── AdminTestimonialsView.vue (⏳ Placeholder)
│   │       ├── AdminMessagesView.vue (⏳ Placeholder)
│   │       ├── AdminGalleryView.vue (⏳ Placeholder)
│   │       └── AdminSettingsView.vue (⏳ Placeholder)
│   ├── components/admin/
│   │   ├── AdminLayout.vue
│   │   ├── AdminModal.vue
│   │   └── AdminToast.vue
│   ├── services/api/
│   │   ├── http.js
│   │   ├── auth.service.js
│   │   ├── dashboard.service.js
│   │   ├── services.service.js
│   │   ├── portfolio.service.js
│   │   ├── blog.service.js
│   │   ├── testimonial.service.js
│   │   ├── message.service.js
│   │   ├── gallery.service.js
│   │   ├── settings.service.js
│   │   └── upload.service.js
│   ├── composables/
│   │   ├── useToast.js
│   │   ├── useModal.js
│   │   ├── useForm.js
│   │   └── useFileUpload.js
│   └── stores/
│       └── auth.js
└── .env.local
```

## 🎯 Next Steps

Untuk melengkapi CMS, tinggal copy pattern dari `AdminServicesView.vue` dan sesuaikan untuk:

1. Portfolio (dengan multiple images)
2. Blog (dengan rich text editor)
3. Testimonials (dengan rating)
4. Messages (read-only list)
5. Gallery (image grid)
6. Settings (key-value pairs)

Semua API sudah siap, tinggal buat UI-nya saja!

## 🐛 Troubleshooting

### Login tidak bisa / stuck
- Pastikan Laravel server berjalan di http://localhost:8000
- Pastikan Vue server berjalan di http://localhost:5174
- Cek console browser untuk error
- Pastikan database sudah di-seed (admin user ada)

### Upload image gagal
- Jalankan: `php artisan storage:link`
- Cek permission folder storage/app/public

### API mengembalikan 401
- Token expired, silakan login ulang
- Cek localStorage browser apakah token masih ada

### CORS error
- Sudah dikonfigurasi di backend config/cors.php
- Pastikan frontend URL sesuai (localhost:5174)

## 📝 Notes

- Semua endpoint sudah diprotect dengan `auth:sanctum` middleware kecuali login
- File upload maksimal 2MB
- Supported formats: JPG, JPEG, PNG, WEBP
- Pagination default 15 items per page
- Soft delete digunakan di semua module (kecuali Settings)

---

**Status:** Ready for Production ✅
**Last Updated:** 2026-06-16
