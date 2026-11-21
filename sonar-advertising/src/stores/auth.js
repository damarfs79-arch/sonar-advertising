import { defineStore } from 'pinia'
import { ref } from 'vue'
import { authService } from '@/services/api/auth.service'

export const useAuthStore = defineStore('auth', () => {
  const isAuthenticated = ref(false)
  const user = ref(null)
  const token = ref(null)
  const loading = ref(false)

  const login = async (email, password) => {
    loading.value = true
    try {
      const response = await authService.login(email, password)
      token.value = response.data.token
      user.value = response.data.user
      
      localStorage.setItem('token', response.data.token)
      localStorage.setItem('user', JSON.stringify(response.data.user))
      
      isAuthenticated.value = true
      return response.data
    } catch (error) {
      if (error.response?.status !== 422) {
        console.error('Login error:', error)
      }
      throw error
    } finally {
      loading.value = false
    }
  }

  const logout = async () => {
    loading.value = true
    try {
      if (token.value) {
        await authService.logout()
      }
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      token.value = null
      isAuthenticated.value = false
      user.value = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      loading.value = false
    }
  }

  const checkAuth = () => {
    const storedToken = localStorage.getItem('token')
    const storedUser = localStorage.getItem('user')
    
    if (storedToken && storedUser) {
      token.value = storedToken
      user.value = JSON.parse(storedUser)
      isAuthenticated.value = true
    }
  }

  const loadUser = async () => {
    loading.value = true
    try {
      const response = await authService.getUser()
      user.value = response.data
      isAuthenticated.value = true
      return response.data
    } catch (error) {
      console.error('Load user error:', error)
      token.value = null
      isAuthenticated.value = false
      user.value = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      throw error
    } finally {
      loading.value = false
    }
  }

  return {
    isAuthenticated,
    user,
    token,
    loading,
    login,
    logout,
    checkAuth,
    loadUser
  }
})
