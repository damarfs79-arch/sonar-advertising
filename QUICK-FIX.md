# 🔧 Quick Fix - Restore CORS to Working State

## Status Server
- ✅ Laravel: Running on http://127.0.0.1:8000
- ✅ Vue: Running on http://localhost:5174

## Solusi Cepat

### Opsi 1: Gunakan Laravel Built-in CORS (RECOMMENDED)

Laravel 13 sudah punya CORS middleware bawaan. Mari kita gunakan itu saja:

1. **Kembalikan bootstrap/app.php** - Hapus custom middleware:

```php
// di bootstrap/app.php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->trustProxies(at: '*');
    $middleware->trustHosts(at: ['localhost:5173', 'localhost:5174', '127.0.0.1:5173', '127.0.0.1:5174']);
    // HAPUS line ini: $middleware->prepend(\App\Http\Middleware\HandleCors::class);
})
```

2. **Pastikan config/cors.php sudah benar**:
```php
'allowed_origins' => ['http://localhost:5173', 'http://localhost:5174', 'http://127.0.0.1:5173', 'http://127.0.0.1:5174'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => true,
```

3. **Restart Laravel**:
```bash
php artisan serve --port=8000
```

---

### Opsi 2: Hapus Custom Middleware Sepenuhnya

Jika masih ada masalah:

1. **Hapus file custom middleware**:
```
D:\laragon\www\febe\backend\app\Http\Middleware\HandleCors.php
```

2. **Pastikan bootstrap/app.php tidak memanggil middleware custom**

3. **Restart Laravel server**

---

### Opsi 3: Clear Semua Cache

```bash
cd D:\laragon\www\febe\backend
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 🔍 Quick Test

Setelah restart Laravel:

1. Buka `http://localhost:5174/login` di browser
2. Login dengan: `admin@example.com` / `admin123`
3. Buka DevTools → Network tab → Filter XHR
4. Klik Services menu
5. Cari request ke `http://localhost:8000/api/services`
6. Check response headers - harus ada:
   - `Access-Control-Allow-Origin: http://localhost:5174`
   - `Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS`

---

## 📝 Catatan

Masalah CORS yang Anda alami:
- Error 204 No Content
- Response headers hanya menunjukkan `GET` di Allow-Methods

Kemungkinan penyebab:
1. Laravel CORS middleware tidak ter-load
2. Conflicts antara middleware
3. Cache

Solusi paling aman: Gunakan Laravel built-in CORS, bukan custom middleware.
