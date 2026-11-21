# 🧪 Testing Instructions - Admin Dashboard

## 📋 Masalah CORS yang Sudah Diperbaiki

### ✅ Perbaikan yang Sudah Dilakukan:

1. **Custom CORS Middleware** - `backend/app/Http/Middleware/HandleCors.php`
   - Menangani OPTIONS preflight request dengan benar
   - Support semua HTTP methods: GET, POST, PUT, DELETE, PATCH, OPTIONS
   - Dynamic origin detection untuk localhost:5173 dan localhost:5174

2. **AdminModal Component** - Modal tidak auto-close sebelum async operation selesai

3. **AdminServicesView** - Tambah @confirm handler untuk save operation

## 🚀 Cara Menjalankan

### Terminal 1 - Laravel Backend:
```bash
cd D:\laragon\www\febe\backend
php artisan serve --port=8000
```

### Terminal 2 - Vue Frontend:
```bash
cd D:\laragon\www\febe\sonar-advertising
npm run dev
```

## 🔐 Login Credentials
- URL: http://localhost:5174/login
- Email: `admin@example.com`
- Password: `admin123`

## ✅ Checklist Testing

### 1. Authentication
- [ ] Login berhasil tanpa CORS error
- [ ] Redirect ke dashboard setelah login
- [ ] Token tersimpan di localStorage

### 2. Dashboard
- [ ] Stats cards tampil (Services, Portfolio, Blog, etc.)
- [ ] Recent activity list tampil
- [ ] Tidak ada CORS error di console

### 3. Services Module (http://localhost:5174/admin/services)
- [ ] List services tampil dengan pagination
- [ ] Search berfungsi
- [ ] Filter by status berfungsi
- [ ] Create new service (dengan upload image)
- [ ] Edit service
- [ ] Delete service
- [ ] Modal bisa save tanpa error

### 4. Portfolio Module (http://localhost:5174/admin/portfolio)
- [ ] List portfolio tampil
- [ ] Create portfolio dengan main image + gallery
- [ ] Edit portfolio
- [ ] Delete portfolio
- [ ] Image preview/lightbox berfungsi

### 5. Blog Module (http://localhost:5174/admin/blog)
- [ ] List articles tampil dalam table
- [ ] Create article dengan auto-generate slug
- [ ] Edit article
- [ ] Delete article
- [ ] Filter by status & category

### 6. Testimonials Module (http://localhost:5174/admin/testimonials)
- [ ] List testimonials tampil
- [ ] Create testimonial dengan screenshot/photo upload
- [ ] Edit testimonial
- [ ] Delete testimonial
- [ ] Rating berfungsi

### 7. Gallery Module (http://localhost:5174/admin/gallery)
- [ ] Gallery grid tampil
- [ ] Upload photo
- [ ] Edit photo info (title, description, category)
- [ ] Delete photo
- [ ] Image preview berfungsi

### 8. Messages Module (http://localhost:5174/admin/messages)
- [ ] Inbox list tampil
- [ ] Open message (mark as read otomatis)
- [ ] Filter by read/unread
- [ ] Delete message
- [ ] Reply via email link berfungsi

### 9. Settings Module (http://localhost:5174/admin/settings)
- [ ] Form settings tampil
- [ ] Edit site name, description, etc.
- [ ] Upload logo, favicon, hero banner
- [ ] Save settings tanpa error

## 🐛 Jika Masih Ada Error CORS

### Error yang Mungkin Muncul:
```
Access to XMLHttpRequest at 'http://localhost:8000/api/messages' from origin 'http://localhost:5174' 
has been blocked by CORS policy: Response to preflight request doesn't pass access control check
```

### Solusi Troubleshooting:

1. **Clear Browser Cache & Hard Reload**
   - Tekan `Ctrl + Shift + Delete`
   - Atau `Ctrl + F5` untuk hard reload
   - Browser cache preflight response, jadi perlu di-clear

2. **Pastikan Server Laravel Running**
   ```bash
   # Check if running
   netstat -ano | findstr :8000
   
   # Restart jika perlu
   cd D:\laragon\www\febe\backend
   php artisan serve --port=8000
   ```

3. **Clear Laravel Cache**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   ```

4. **Cek Network Tab di Browser DevTools**
   - Buka DevTools (F12)
   - Tab Network
   - Filter: XHR
   - Lihat OPTIONS request dan response headers
   - `Access-Control-Allow-Methods` harus ada: `GET, POST, PUT, DELETE, PATCH, OPTIONS`

5. **Test API Langsung**
   ```bash
   # Windows PowerShell
   Invoke-RestMethod -Uri "http://localhost:8000/api/auth/login" -Method POST -Body (@{email="admin@example.com"; password="admin123"} | ConvertTo-Json) -ContentType "application/json"
   ```

## 📊 Expected Results

Jika CORS sudah benar, di Network tab DevTools harus terlihat:

### OPTIONS Request (Preflight):
```
Status: 204 No Content
Access-Control-Allow-Origin: http://localhost:5174
Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS
Access-Control-Allow-Headers: Authorization, Content-Type, X-Requested-With, X-CSRF-Token, Accept
Access-Control-Allow-Credentials: true
```

### Actual Request (GET/POST/PUT/DELETE):
```
Status: 200 OK (atau 401 jika tidak ada token)
Access-Control-Allow-Origin: http://localhost:5174
Access-Control-Allow-Credentials: true
```

## 📝 File yang Sudah Dimodifikasi

1. `backend/app/Http/Middleware/HandleCors.php` - Custom CORS middleware
2. `backend/bootstrap/app.php` - Register middleware
3. `backend/config/cors.php` - CORS config (port 5174 ditambahkan)
4. `sonar-advertising/src/components/admin/AdminModal.vue` - Fix auto-close bug
5. `sonar-advertising/src/views/admin/AdminServicesView.vue` - Add @confirm handler

## 🎯 Target

Semua operasi CRUD di 7 module admin harus berfungsi tanpa CORS error!

---

**Last Updated:** 2026-06-17
**Status:** Ready for Testing
