import { ref, computed } from 'vue'

export function useForm(initialData = {}) {
  const form = ref({ ...initialData })
  const errors = ref({})
  const loading = ref(false)

  const hasErrors = computed(() => {
    return Object.keys(errors.value).length > 0
  })

  const clearErrors = () => {
    errors.value = {}
  }

  const setError = (field, message) => {
    errors.value[field] = message
  }

  const reset = () => {
    form.value = { ...initialData }
    clearErrors()
  }

  return {
    form,
    errors,
    loading,
    hasErrors,
    clearErrors,
    setError,
    reset
  }
}
