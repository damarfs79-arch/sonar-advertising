# Sonar Advertising - Company Profile & CMS

A full-stack web application built with **Laravel 11** (Backend API) and **Vue 3 + Vite + Tailwind CSS** (Frontend). This project serves as a modern company profile and content management system for Sonar Advertising.

## 🚀 Tech Stack

### Backend (API)
- **Framework:** Laravel 11.x
- **Authentication:** Laravel Sanctum (Token-based SPA Auth)
- **Architecture Pattern:** Repository-Service Pattern
- **Database:** MySQL / SQLite
- **PHP Version:** 8.2+

### Frontend (SPA)
- **Framework:** Vue 3 (Composition API)
- **Build Tool:** Vite
- **State Management:** Pinia
- **Styling:** Tailwind CSS + PostCSS
- **Routing:** Vue Router
- **HTTP Client:** Axios (Centralized via BaseApiService)
- **Rich Text Editor:** Vue Quill

---

## 🏗️ Architecture Design (Refactored)

This codebase has undergone a full architectural refactor to meet production-ready standards:

1. **Controller Layer:** Controllers are now thin entry points that solely handle HTTP Requests and Responses using standard Laravel Form Requests and API Resources.
2. **Service Layer:** Business logic is isolated in `app/Services`, making the code reusable and testable.
3. **Repository Layer:** Database queries and Eloquent interactions are centralized in `app/Repositories`, separating data access logic from business logic.
4. **Frontend API Layer:** HTTP requests in Vue are centralized in `src/services/api/BaseApiService.js`, using ES6 Classes to handle CRUD operations dynamically across entities.
5. **Pinia Stores:** State management is streamlined and strictly separated from UI components.

---

## 🛠️ Local Setup Instructions

### Prerequisites
- PHP 8.2+
- Composer
- Node.js (v18+)
- MySQL

### 1. Backend Setup

```bash
cd backend

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate Application Key
php artisan key:generate

# Configure Database in .env
# DB_CONNECTION=mysql
# DB_DATABASE=your_database_name
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations and seeders (if any)
php artisan migrate

# Start Laravel Development Server
php artisan serve
```

### 2. Frontend Setup

```bash
cd sonar-advertising

# Install dependencies
npm install

# Configure API URL in .env
# Create a .env file and add:
# VITE_API_URL=http://localhost:8000/api

# Start Vite Development Server
npm run dev
```

---

## 📁 Directory Structure

```
├── backend/
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/Api/   # Thin API Controllers
│   │   │   ├── Requests/          # Form Request Validations
│   │   │   └── Resources/         # JSON API Resources
│   │   ├── Models/                # Eloquent Models
│   │   ├── Repositories/          # Data Access Layer
│   │   └── Services/              # Business Logic Layer
│   ├── database/
│   │   └── migrations/            # Database schemas
│   └── routes/
│       └── api.php                # Structured API Routes
│
└── sonar-advertising/
    ├── src/
    │   ├── assets/                # Images & CSS (Tailwind)
    │   ├── components/            # Vue Components
    │   │   ├── admin/             # Dashboard UI
    │   │   ├── layout/            # Layout wrappers
    │   │   ├── sections/          # Landing Page sections
    │   │   └── ui/                # Reusable UI elements
    │   ├── services/
    │   │   └── api/               # API Service Classes (BaseApiService)
    │   ├── stores/                # Pinia State Management
    │   └── views/                 # Vue Pages/Routes
    └── tailwind.config.js
```

## ✨ Code Quality & Maintenance
- **Do not bypass the Service Layer:** If you add new features, ensure Controllers do not contain business logic.
- **Form Validation:** Always use `FormRequest` classes for validation instead of inline validation in controllers.
- **API Responses:** Use `JsonResource` collections to format responses consistently.
- **Tailwind CSS:** Keep custom CSS in `src/assets/css/main.css` minimal and utilize Tailwind utility classes in `.vue` files.
# sonar-advertising
