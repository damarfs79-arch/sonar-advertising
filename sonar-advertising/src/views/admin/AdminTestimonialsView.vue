<template>
  <AdminLayout>
    <div class="space-y-6 font-sans">
      <!-- Top Action Bar -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-neutral-200 shadow-sm">
        <div>
          <h1 class="text-2xl font-bold text-neutral-900 tracking-tight">Manajemen Testimoni & Bukti Chat</h1>
          <p class="text-sm text-neutral-500 mt-1">
            Kelola galeri bukti screenshot chat WhatsApp, DM Instagram, dan serah terima proyek dari klien.
          </p>
        </div>
        <button
          @click="openCreateModal"
          class="inline-flex items-center gap-2 bg-brand-orange hover:bg-brand-orange-dark text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-all duration-200 hover:scale-[1.02] active:scale-95 shadow-md shadow-brand-orange/20 cursor-pointer self-start sm:self-auto"
        >
          <svg class="w-4 h-4 stroke-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Tambah Bukti Testimoni
        </button>
      </div>

      <!-- Filters & Search -->
      <div class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-2xl border border-neutral-200 shadow-sm">
        <div class="relative flex-1">
          <svg class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
          <input
            v-model="searchTerm"
            type="text"
            placeholder="Cari nama klien, jenis proyek, atau isi catatan..."
            class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-neutral-200 focus:outline-none focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 bg-neutral-50/50"
            @input="handleSearchInput"
          />
        </div>
        <div class="flex flex-wrap items-center gap-3">
          <select
            v-model="filters.platform"
            @change="loadTestimonials"
            class="px-3.5 py-2.5 text-sm rounded-xl border border-neutral-200 bg-white focus:outline-none focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 cursor-pointer text-neutral-700"
          >
            <option value="">Semua Platform</option>
            <option value="whatsapp">Chat WhatsApp</option>
            <option value="instagram">DM Instagram</option>
            <option value="google_review">Google Review</option>
            <option value="foto_lokasi">Foto Serah Terima</option>
          </select>

          <select
            v-model="filters.status"
            @change="loadTestimonials"
            class="px-3.5 py-2.5 text-sm rounded-xl border border-neutral-200 bg-white focus:outline-none focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 cursor-pointer text-neutral-700"
          >
            <option value="">Semua Status</option>
            <option value="1">Aktif di Beranda</option>
            <option value="0">Nonaktif</option>
          </select>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="bg-white p-12 rounded-2xl border border-neutral-200 text-center">
        <div class="w-8 h-8 border-3 border-brand-orange border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
        <p class="text-neutral-500 text-sm">Memuat data testimoni...</p>
      </div>

      <!-- Empty State -->
      <div v-else-if="items.length === 0" class="bg-white p-12 rounded-2xl border border-neutral-200 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-neutral-100 flex items-center justify-center text-neutral-400">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
          </svg>
        </div>
        <h3 class="text-base font-bold text-neutral-800 mb-1">Tidak Ada Bukti Testimoni</h3>
        <p class="text-neutral-500 text-sm mb-6">Mulai tambahkan tangkapan layar bukti kepuasan klien untuk ditampilkan di website.</p>
        <button
          @click="openCreateModal"
          class="inline-flex items-center gap-2 bg-brand-orange hover:bg-brand-orange-dark text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition-all cursor-pointer"
        >
          Tambah Bukti Sekarang
        </button>
      </div>

      <!-- Testimonial Grid / Cards -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div
          v-for="(item, index) in items"
          :key="item.id"
          class="bg-white rounded-2xl border border-neutral-200 overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between"
        >
          <!-- Image Thumbnail with Action Overlay -->
          <div class="relative w-full aspect-[3/4] bg-neutral-100 overflow-hidden group cursor-pointer" @click="openImagePreview(index)">
            <img
              v-if="item.screenshot_path || item.photo"
              :src="getImageUrl(item.screenshot_path || item.photo)"
              :alt="item.client_name || item.name"
              class="w-full h-full object-cover object-top transition-transform duration-300 group-hover:scale-105"
              loading="lazy"
            />
            <div v-else class="w-full h-full flex items-center justify-center text-neutral-400 text-xs font-medium">
              Tanpa Gambar
            </div>

            <!-- Platform Badge -->
            <div
              class="absolute top-3 left-3 z-10 flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold backdrop-blur-md shadow-sm border"
              :class="getBadgeStyles(item.platform)"
            >
              <svg v-if="normalizePlatform(item.platform) === 'whatsapp'" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
              <svg v-else-if="normalizePlatform(item.platform) === 'instagram'" class="w-3.5 h-3.5 fill-none stroke-current stroke-2" viewBox="0 0 24 24">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
              </svg>
              <svg v-else-if="normalizePlatform(item.platform) === 'google_review'" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
              </svg>
              <svg v-else class="w-3.5 h-3.5 fill-none stroke-current stroke-2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <circle cx="12" cy="13" r="4" />
              </svg>
              <span>{{ getPlatformLabel(item.platform) }}</span>
            </div>

            <!-- Click to preview icon -->
            <div class="absolute inset-0 bg-neutral-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
              <span class="p-2 rounded-full bg-white/90 text-neutral-800 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                </svg>
              </span>
            </div>
          </div>

          <!-- Card Details -->
          <div class="p-4 flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-start justify-between gap-2">
                <div>
                  <h3 class="font-bold text-neutral-900 text-sm leading-tight line-clamp-1">
                    {{ item.client_name || item.name || 'Klien Tanpa Nama' }}
                  </h3>
                  <p class="text-xs text-neutral-500 font-medium mt-0.5 line-clamp-1">
                    {{ item.project_type || item.company || 'Umum / Signage' }}
                  </p>
                </div>
                <span class="text-[11px] font-semibold text-neutral-400 bg-neutral-100 px-2 py-0.5 rounded shrink-0">
                  #{{ item.sort_order ?? 0 }}
                </span>
              </div>

              <p v-if="item.caption || item.content" class="text-xs text-neutral-600 mt-2 bg-neutral-50 p-2 rounded-lg border border-neutral-100 line-clamp-2 leading-relaxed">
                "{{ item.caption || item.content }}"
              </p>
            </div>

            <!-- Quick Status Toggle & Actions -->
            <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between gap-2">
              <!-- Quick Toggle Status -->
              <button
                @click="toggleFeaturedStatus(item)"
                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium cursor-pointer transition-colors"
                :class="item.is_featured ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200 border border-neutral-200'"
                :title="item.is_featured ? 'Klik untuk nonaktifkan di Beranda' : 'Klik untuk tampilkan di Beranda'"
              >
                <span class="w-2 h-2 rounded-full" :class="item.is_featured ? 'bg-emerald-500' : 'bg-neutral-400'"></span>
                {{ item.is_featured ? 'Tampil di Beranda' : 'Disembunyikan' }}
              </button>

              <!-- Edit & Delete Buttons -->
              <div class="flex items-center gap-1">
                <button
                  @click="openEditModal(item)"
                  class="p-1.5 text-neutral-500 hover:text-brand-orange hover:bg-brand-orange/10 rounded-lg transition-colors cursor-pointer"
                  title="Edit Data"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                </button>
                <button
                  @click="confirmDelete(item.id)"
                  class="p-1.5 text-neutral-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                  title="Hapus"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="totalPages > 1" class="flex items-center justify-between bg-white px-4 py-3 rounded-2xl border border-neutral-200">
        <button
          @click="changePage(currentPage - 1)"
          :disabled="currentPage === 1"
          class="px-4 py-2 text-sm font-medium rounded-xl border border-neutral-200 bg-white text-neutral-700 hover:bg-neutral-50 disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer"
        >
          Sebelumnya
        </button>
        <span class="text-sm text-neutral-600 font-medium">
          Halaman {{ currentPage }} dari {{ totalPages }}
        </span>
        <button
          @click="changePage(currentPage + 1)"
          :disabled="currentPage === totalPages"
          class="px-4 py-2 text-sm font-medium rounded-xl border border-neutral-200 bg-white text-neutral-700 hover:bg-neutral-50 disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer"
        >
          Selanjutnya
        </button>
      </div>

      <!-- Create / Edit Modal -->
      <AdminModal
        v-model="isModalOpen"
        :title="modalMode === 'create' ? 'Tambah Bukti Testimoni' : 'Edit Bukti Testimoni'"
        :confirm-text="modalMode === 'create' ? 'Simpan' : 'Perbarui'"
        cancel-text="Batal"
        :show-footer="true"
        :loading="modalLoading"
        @confirm="saveTestimonial"
      >
        <form @submit.prevent="saveTestimonial" class="space-y-4">
          <!-- Error Alerts -->
          <div v-if="Object.keys(formErrors).length" class="p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-xs space-y-1">
            <p v-for="(err, key) in formErrors" :key="key">{{ Array.isArray(err) ? err.join(', ') : err }}</p>
          </div>

          <!-- Screenshot Upload & Preview Area -->
          <div>
            <label class="block text-xs font-semibold text-neutral-700 mb-1.5">
              Screenshot Chat / Bukti Serah Terima <span class="text-red-500">*</span>
            </label>

            <!-- Active Preview if present -->
            <div v-if="previewUrl || form.photo" class="relative rounded-xl border border-neutral-200 overflow-hidden bg-neutral-900 mb-3 max-w-[200px] aspect-[3/4] mx-auto">
              <img
                :src="previewUrl || getImageUrl(form.photo)"
                alt="Preview Bukti"
                class="w-full h-full object-cover object-top"
              />
              <button
                type="button"
                @click="clearImage"
                class="absolute top-2 right-2 w-7 h-7 bg-black/70 hover:bg-black text-white rounded-full flex items-center justify-center text-xs cursor-pointer transition-colors"
                title="Hapus gambar"
              >
                ✕
              </button>
            </div>

            <!-- Upload Controls -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
              <label class="flex flex-col items-center justify-center p-3 border-2 border-dashed border-neutral-300 hover:border-brand-orange rounded-xl cursor-pointer bg-neutral-50 hover:bg-orange-50/20 transition-colors text-center">
                <svg class="w-5 h-5 text-neutral-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <span class="text-xs font-semibold text-neutral-700">Upload File Baru</span>
                <span class="text-[10px] text-neutral-500">JPG, PNG, WebP (Maks 3MB)</span>
                <input
                  type="file"
                  accept="image/png,image/jpeg,image/webp"
                  class="hidden"
                  @change="handleFileUpload"
                />
              </label>

              <button
                type="button"
                @click="isMediaPickerOpen = true"
                class="flex flex-col items-center justify-center p-3 border border-neutral-200 hover:border-brand-orange rounded-xl cursor-pointer bg-white hover:bg-neutral-50 transition-colors text-center"
              >
                <svg class="w-5 h-5 text-neutral-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-xs font-semibold text-neutral-700">Pilih dari Media Library</span>
                <span class="text-[10px] text-neutral-500">File galeri yang sudah ada</span>
              </button>
            </div>
          </div>

          <!-- Form Fields Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-neutral-700 mb-1">
                Nama Klien / Instansi
              </label>
              <input
                v-model="form.client_name"
                type="text"
                placeholder="Contoh: Owner Cafe Koma Jember"
                class="w-full px-3.5 py-2 text-sm rounded-xl border border-neutral-200 focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange"
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-neutral-700 mb-1">
                Jenis Proyek / Signage
              </label>
              <input
                v-model="form.project_type"
                type="text"
                placeholder="Contoh: Huruf Timbul Akrilik LED"
                class="w-full px-3.5 py-2 text-sm rounded-xl border border-neutral-200 focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange"
              />
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-neutral-700 mb-1">
                Platform Sumber Bukti
              </label>
              <select
                v-model="form.platform"
                class="w-full px-3.5 py-2 text-sm rounded-xl border border-neutral-200 focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange bg-white text-neutral-800"
              >
                <option value="whatsapp">Chat WhatsApp</option>
                <option value="instagram">DM Instagram</option>
                <option value="google_review">Google Review</option>
                <option value="foto_lokasi">Foto Serah Terima</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-semibold text-neutral-700 mb-1">
                Urutan Tampil (Sort Order)
              </label>
              <input
                v-model.number="form.sort_order"
                type="number"
                min="0"
                placeholder="0"
                class="w-full px-3.5 py-2 text-sm rounded-xl border border-neutral-200 focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange"
              />
            </div>
          </div>

          <div>
            <label class="block text-xs font-semibold text-neutral-700 mb-1">
              Catatan / Kutipan Singkat Klien
            </label>
            <textarea
              v-model="form.caption"
              rows="3"
              placeholder="Tuliskan rangkuman ulasan kepuasan klien atau poin penting dalam chat..."
              class="w-full px-3.5 py-2 text-sm rounded-xl border border-neutral-200 focus:outline-none focus:border-brand-orange focus:ring-1 focus:ring-brand-orange resize-none"
            ></textarea>
          </div>

          <!-- Feature Toggle Checkbox -->
          <div class="pt-2">
            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
              <input
                v-model="form.is_featured"
                type="checkbox"
                class="w-4 h-4 rounded text-brand-orange focus:ring-brand-orange border-neutral-300 cursor-pointer"
              />
              <span class="text-xs font-semibold text-neutral-800">
                Tampilkan di Beranda (Halaman Utama)
              </span>
            </label>
          </div>
        </form>
      </AdminModal>

      <!-- Delete Confirmation Modal -->
      <AdminModal
        v-model="isDeleteModalOpen"
        title="Konfirmasi Hapus Testimoni"
        confirm-text="Hapus Permanen"
        cancel-text="Batal"
        :show-footer="true"
        @confirm="deleteTestimonial"
      >
        <p class="text-sm text-neutral-600">
          Apakah Anda yakin ingin menghapus bukti testimoni ini? File screenshot yang bersangkutan akan dihapus dari server. Tindakan ini tidak dapat dibatalkan.
        </p>
      </AdminModal>

      <!-- Lightbox Zoom Modal -->
      <ImagePreview
        v-model="isPreviewOpen"
        :images="previewImages"
        :start-index="previewIndex"
      />

      <!-- Media Picker Modal -->
      <MediaPickerModal
        v-model="isMediaPickerOpen"
        @select="handleMediaSelect"
      />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AdminLayout from '@/components/admin/AdminLayout.vue'
import AdminModal from '@/components/admin/AdminModal.vue'
import ImagePreview from '@/components/admin/ImagePreview.vue'
import MediaPickerModal from '@/components/admin/MediaPickerModal.vue'
import { useToast } from '@/composables/useToast'
import { testimonialService } from '@/services/api/testimonial.service'

const loading = ref(true)
const items = ref([])
const currentPage = ref(1)
const totalPages = ref(1)
const searchTerm = ref('')
const filters = ref({ platform: '', status: '' })

const isModalOpen = ref(false)
const isDeleteModalOpen = ref(false)
const isPreviewOpen = ref(false)
const isMediaPickerOpen = ref(false)
const modalLoading = ref(false)
const modalMode = ref('create')
const formErrors = ref({})
const selectedId = ref(null)

const previewFile = ref(null)
const previewUrl = ref('')

const form = ref({
  client_name: '',
  project_type: '',
  platform: 'whatsapp',
  caption: '',
  sort_order: 0,
  is_featured: true,
  photo: null,
})

const previewIndex = ref(0)
const { success, error } = useToast()

let searchTimeout = null
const handleSearchInput = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    currentPage.value = 1
    loadTestimonials()
  }, 350)
}

const previewImages = computed(() => {
  return items.value.map((item) => ({
    src: getImageUrl(item.screenshot_path || item.photo),
    alt: `${item.client_name || item.name || 'Klien'} — ${item.project_type || item.company || 'Bukti Testimoni'}`
  }))
})

const getImageUrl = (path) => {
  if (!path) return ''
  if (path.startsWith('http') || path.startsWith('data:')) return path
  const apiBase = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'
  return apiBase.replace('/api', '') + path
}

const normalizePlatform = (platform) => {
  if (!platform) return 'whatsapp'
  const p = platform.toLowerCase()
  if (p.includes('wa') || p.includes('whatsapp')) return 'whatsapp'
  if (p.includes('ig') || p.includes('instagram')) return 'instagram'
  if (p.includes('google') || p.includes('review')) return 'google_review'
  return 'foto_lokasi'
}

const getPlatformLabel = (platform) => {
  const norm = normalizePlatform(platform)
  switch (norm) {
    case 'whatsapp':
      return 'Chat WhatsApp'
    case 'instagram':
      return 'DM Instagram'
    case 'google_review':
      return 'Google Review'
    default:
      return 'Foto Serah Terima'
  }
}

const getBadgeStyles = (platform) => {
  const norm = normalizePlatform(platform)
  switch (norm) {
    case 'whatsapp':
      return 'bg-emerald-500/90 text-white border-emerald-400/40'
    case 'instagram':
      return 'bg-gradient-to-r from-purple-600 to-pink-600 text-white border-pink-400/40'
    case 'google_review':
      return 'bg-blue-600/90 text-white border-blue-400/40'
    default:
      return 'bg-amber-600/90 text-white border-amber-400/40'
  }
}

const loadTestimonials = async () => {
  loading.value = true
  try {
    const params = {
      page: currentPage.value,
      per_page: 12,
      search: searchTerm.value || undefined,
      platform: filters.value.platform || undefined,
      is_featured: filters.value.status !== '' ? filters.value.status : undefined
    }
    
    const response = await testimonialService.getAll(params)
    let rawData = response.data?.data
    if (rawData && typeof rawData === 'object' && !Array.isArray(rawData)) {
      rawData = rawData.data || []
    }
    
    items.value = Array.isArray(rawData) ? rawData.filter(i => i && i.id) : []
    totalPages.value = response.data?.meta?.last_page || response.data?.last_page || 1
  } catch (err) {
    console.error('Error loading testimonials:', err)
    error('Gagal memuat data testimoni.')
    items.value = []
  } finally {
    loading.value = false
  }
}

const openCreateModal = () => {
  modalMode.value = 'create'
  form.value = {
    client_name: '',
    project_type: '',
    platform: 'whatsapp',
    caption: '',
    sort_order: 0,
    is_featured: true,
    photo: null,
  }
  previewFile.value = null
  previewUrl.value = ''
  formErrors.value = {}
  isModalOpen.value = true
}

const openEditModal = (item) => {
  if (!item?.id) return
  modalMode.value = 'edit'
  selectedId.value = item.id
  form.value = {
    client_name: item.client_name || item.name || '',
    project_type: item.project_type || item.company || '',
    platform: item.platform || 'whatsapp',
    caption: item.caption || item.content || '',
    sort_order: item.sort_order ?? 0,
    is_featured: item.is_featured !== null ? Boolean(item.is_featured) : Boolean(item.is_active),
    photo: item.screenshot_path || item.photo || null,
  }
  previewFile.value = null
  previewUrl.value = ''
  formErrors.value = {}
  isModalOpen.value = true
}

const handleFileUpload = (e) => {
  const file = e.target.files?.[0]
  if (!file) return

  if (file.size > 3 * 1024 * 1024) {
    error('Ukuran file maksimal 3MB.')
    return
  }

  previewFile.value = file
  previewUrl.value = URL.createObjectURL(file)
  form.value.photo = null
}

const handleMediaSelect = (path) => {
  previewFile.value = null
  previewUrl.value = ''
  form.value.photo = path
}

const clearImage = () => {
  previewFile.value = null
  previewUrl.value = ''
  form.value.photo = null
}

const toggleFeaturedStatus = async (item) => {
  try {
    const res = await testimonialService.toggleFeatured(item.id)
    const updated = res.data?.data || res.data
    item.is_featured = updated.is_featured
    item.is_active = updated.is_active
    success(item.is_featured ? 'Testimoni ditampilkan di Beranda.' : 'Testimoni disembunyikan dari Beranda.')
  } catch (err) {
    console.error('Error toggling featured status:', err)
    error('Gagal mengubah status testimoni.')
  }
}

const saveTestimonial = async () => {
  if (!previewFile.value && !form.value.photo) {
    formErrors.value = { screenshot: 'Gambar screenshot bukti chat wajib diunggah atau dipilih.' }
    return
  }

  modalLoading.value = true
  formErrors.value = {}

  try {
    const formData = new FormData()
    if (previewFile.value) {
      formData.append('screenshot', previewFile.value)
    } else if (form.value.photo) {
      formData.append('screenshot_path', form.value.photo)
      formData.append('photo', form.value.photo)
    }

    formData.append('client_name', form.value.client_name || '')
    formData.append('project_type', form.value.project_type || '')
    formData.append('platform', form.value.platform || 'whatsapp')
    formData.append('caption', form.value.caption || '')
    formData.append('sort_order', form.value.sort_order ?? 0)
    formData.append('is_featured', form.value.is_featured ? '1' : '0')

    if (modalMode.value === 'create') {
      await testimonialService.create(formData)
      success('Bukti testimoni berhasil ditambahkan.')
    } else {
      await testimonialService.update(selectedId.value, formData)
      success('Bukti testimoni berhasil diperbarui.')
    }

    isModalOpen.value = false
    loadTestimonials()
  } catch (err) {
    console.error('Error saving testimonial:', err)
    if (err.response?.data?.errors) {
      formErrors.value = err.response.data.errors
    } else {
      error(err.response?.data?.message || 'Gagal menyimpan testimoni.')
    }
  } finally {
    modalLoading.value = false
  }
}

const confirmDelete = (id) => {
  selectedId.value = id
  isDeleteModalOpen.value = true
}

const deleteTestimonial = async () => {
  if (!selectedId.value) return
  try {
    await testimonialService.delete(selectedId.value)
    success('Bukti testimoni berhasil dihapus.')
    isDeleteModalOpen.value = false
    loadTestimonials()
  } catch (err) {
    console.error('Error deleting testimonial:', err)
    error('Gagal menghapus testimoni.')
  }
}

const openImagePreview = (index) => {
  previewIndex.value = index
  isPreviewOpen.value = true
}

const changePage = (page) => {
  currentPage.value = page
  loadTestimonials()
}

onMounted(() => {
  loadTestimonials()
})
</script>
