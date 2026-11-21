<template>
  <AdminLayout>
    <div class="admin-settings">
      <div class="header">
        <h1>Site Settings</h1>
        <button @click="saveSettings" class="btn-primary" :disabled="saving">
          <span v-if="saving">Saving...</span>
          <span v-else>Save Changes</span>
        </button>
      </div>

      <div v-if="loading" class="loading">Loading settings...</div>

      <div v-else class="settings-content">
        <div class="settings-grid">
          
          <!-- General Information -->
          <div class="settings-section">
            <div class="section-header">
              <h3>General Information</h3>
              <p>Basic information about your website and company.</p>
            </div>
            <div class="section-body">
              <div class="form-group">
                <label>Site Name</label>
                <input v-model="form.site_name" type="text" placeholder="e.g. Sonar Advertising" />
              </div>
              <div class="form-group">
                <label>Site Description (SEO)</label>
                <textarea v-model="form.site_description" rows="3" placeholder="Brief description of your business for search engines"></textarea>
              </div>
              <div class="form-group">
                <label>About Us Summary (Footer)</label>
                <textarea v-model="form.about_summary" rows="4" placeholder="Short description displayed in the footer"></textarea>
              </div>
            </div>
          </div>

          <!-- Contact Details -->
          <div class="settings-section">
            <div class="section-header">
              <h3>Contact Details</h3>
              <p>How customers can reach you.</p>
            </div>
            <div class="section-body">
              <div class="form-group">
                <label>Email Address</label>
                <input v-model="form.contact_email" type="email" placeholder="contact@example.com" />
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                <input v-model="form.contact_phone" type="text" placeholder="+62 812 3456 7890" />
              </div>
              <div class="form-group">
                <label>WhatsApp Number</label>
                <input v-model="form.whatsapp_number" type="text" placeholder="6281234567890 (no plus sign)" />
                <small class="hint">Used for the floating WhatsApp button.</small>
              </div>
              <div class="form-group">
                <label>Office Address</label>
                <textarea v-model="form.contact_address" rows="3" placeholder="Full street address"></textarea>
              </div>
              <div class="form-group">
                <label>Google Maps Embed URL</label>
                <input v-model="form.maps_embed_url" type="text" placeholder="https://www.google.com/maps/embed?pb=..." />
              </div>
            </div>
          </div>

          <!-- Branding & Images -->
          <div class="settings-section">
            <div class="section-header">
              <h3>Branding & Images</h3>
              <p>Upload logos and banner images.</p>
            </div>
            <div class="section-body">
              <div class="image-upload-group">
                <UploadImage
                  label="Site Logo (Header)"
                  :current-image="form.site_logo"
                  @file-selected="(f) => handleFileUpload(f, 'site_logo')"
                  @file-removed="form.site_logo = null"
                />
              </div>
              <div class="image-upload-group mt-4">
                <UploadImage
                  label="Site Favicon"
                  :current-image="form.site_favicon"
                  @file-selected="(f) => handleFileUpload(f, 'site_favicon')"
                  @file-removed="form.site_favicon = null"
                />
              </div>
              <div class="image-upload-group mt-4">
                <UploadImage
                  label="Hero Banner Background"
                  :current-image="form.hero_banner"
                  @file-selected="(f) => handleFileUpload(f, 'hero_banner')"
                  @file-removed="form.hero_banner = null"
                />
              </div>
            </div>
          </div>

          <!-- Social Media Links -->
          <div class="settings-section">
            <div class="section-header">
              <h3>Social Media</h3>
              <p>Links to your social media profiles.</p>
            </div>
            <div class="section-body">
              <div class="form-group">
                <label>Instagram URL</label>
                <input v-model="form.social_instagram" type="text" placeholder="https://instagram.com/..." />
              </div>
              <div class="form-group">
                <label>Facebook URL</label>
                <input v-model="form.social_facebook" type="text" placeholder="https://facebook.com/..." />
              </div>
              <div class="form-group">
                <label>Twitter/X URL</label>
                <input v-model="form.social_twitter" type="text" placeholder="https://twitter.com/..." />
              </div>
              <div class="form-group">
                <label>LinkedIn URL</label>
                <input v-model="form.social_linkedin" type="text" placeholder="https://linkedin.com/..." />
              </div>
              <div class="form-group">
                <label>YouTube URL</label>
                <input v-model="form.social_youtube" type="text" placeholder="https://youtube.com/..." />
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AdminLayout from '@/components/admin/AdminLayout.vue'
import UploadImage from '@/components/admin/UploadImage.vue'
import { useToast } from '@/composables/useToast'
import { settingsService } from '@/services/api/settings.service'

const loading = ref(true)
const saving = ref(false)

const form = ref({
  site_name: '', site_description: '', about_summary: '',
  contact_email: '', contact_phone: '', whatsapp_number: '', contact_address: '', maps_embed_url: '',
  site_logo: null, site_favicon: null, hero_banner: null,
  social_instagram: '', social_facebook: '', social_twitter: '', social_linkedin: '', social_youtube: ''
})

const fileUploads = ref({}) // track new files to upload

const { success, error } = useToast()

const loadSettings = async () => {
  loading.value = true
  try {
    const response = await settingsService.getAll()
    // merge response data into form
    if (response.data && typeof response.data === 'object') {
      Object.keys(response.data).forEach(key => {
        if (form.value[key] !== undefined) {
          form.value[key] = response.data[key]
        } else {
          form.value[key] = response.data[key] // capture unexpected keys too
        }
      })
    }
  } catch (err) {
    console.error(err)
    error('Failed to load settings')
  } finally {
    loading.value = false
  }
}

const handleFileUpload = (file, key) => {
  fileUploads.value[key] = file
}

const saveSettings = async () => {
  saving.value = true
  try {
    // 1. Upload files first
    const uploadPromises = []
    for (const [key, file] of Object.entries(fileUploads.value)) {
      if (file) {
        uploadPromises.push(
          settingsService.uploadFile(file, key).then(res => {
            form.value[key] = res.data.url
          })
        )
      }
    }
    await Promise.all(uploadPromises)
    fileUploads.value = {} // clear pending files

    // 2. Save text settings
    // Filter out File objects from form payload (already uploaded)
    const payload = {}
    for (const [key, value] of Object.entries(form.value)) {
      if (!(value instanceof File)) {
        payload[key] = value
      }
    }
    await settingsService.update(payload)
    success('Settings saved successfully')
  } catch (err) {
    console.error(err)
    error('Failed to save settings')
  } finally {
    saving.value = false
  }
}

onMounted(() => loadSettings())
</script>

<style scoped>
.admin-settings { padding: 2rem; max-width: 1200px; margin: 0 auto; }
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;   flex-wrap: wrap;
  gap: 1rem;
}
.header h1 { margin: 0; font-size: 1.875rem; font-weight: 600; }
.btn-primary { background: #FF7A00; color: white; padding: 10px 24px; border-radius: 6px; border: none; cursor: pointer; font-weight: 500; transition: background 0.2s; }
.btn-primary:hover:not(:disabled) { background: #ea580c; }
.btn-primary:disabled { opacity: 0.7; cursor: wait; }

.loading { text-align: center; padding: 4rem; color: #6b7280; }

.settings-grid { display: grid; grid-template-columns: 1fr; gap: 2rem; }
@media (min-width: 1024px) {
  .settings-grid { grid-template-columns: 1fr 1fr; }
}

.settings-section { background: white; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; }
.section-header { background: #f9fafb; padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb; }
.section-header h3 { margin: 0 0 0.25rem 0; font-size: 1.125rem; font-weight: 600; color: #111827; }
.section-header p { margin: 0; font-size: 0.875rem; color: #6b7280; }
.section-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem; flex: 1; }

.form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151; font-size: 0.875rem; }
.form-group input, .form-group textarea { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem; transition: border-color 0.2s; }
.form-group input:focus, .form-group textarea:focus { outline: none; border-color: #FF7A00; box-shadow: 0 0 0 3px rgba(255, 122, 0, 0.1); }
.form-group textarea { resize: vertical; }

.hint { display: block; margin-top: 0.25rem; font-size: 0.75rem; color: #6b7280; }

.mt-4 { margin-top: 1rem; }
</style>
