import { ref } from 'vue'
import { uploadService } from '@/services/api/upload.service'

export function useFileUpload() {
  const uploading = ref(false)
  const progress = ref(0)
  const uploadError = ref(null)

  const uploadFile = async (file, directory = 'general') => {
    uploading.value = true
    uploadError.value = null
    progress.value = 0

    try {
      const response = await uploadService.upload(file, directory)
      progress.value = 100
      return response.data
    } catch (error) {
      uploadError.value = error.response?.data?.message || 'Upload failed'
      throw error
    } finally {
      uploading.value = false
    }
  }

  const validateImage = (file, options = {}) => {
    const { maxSize = 2 * 1024 * 1024, allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'] } = options
    
    if (!allowedTypes.includes(file.type)) {
      return { valid: false, message: 'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau WEBP.' }
    }
    
    if (file.size > maxSize) {
      return { valid: false, message: `Ukuran file maksimal ${maxSize / 1024 / 1024} MB.` }
    }
    
    return { valid: true, message: 'OK' }
  }

  return {
    uploading,
    progress,
    uploadError,
    uploadFile,
    validateImage
  }
}
