import axios from 'axios'
import { useLoadingStore } from '@/stores/loading'

const http = axios.create({
    baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8008/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
})

http.interceptors.request.use(
    (config) => {
        if (!config.skipLoading) {
            try {
                const loadingStore = useLoadingStore()
                loadingStore.startRequest()
            } catch {
                // Pinia might not be initialized yet in rare edge cases
            }
        }

        const token = localStorage.getItem('token')
        if (token) {
            config.headers.Authorization = `Bearer ${token}`
        }
        return config
    },
    (error) => {
        try {
            const loadingStore = useLoadingStore()
            loadingStore.endRequest()
        } catch {}
        return Promise.reject(error)
    }
)

http.interceptors.response.use(
    (response) => {
        if (!response.config?.skipLoading) {
            try {
                const loadingStore = useLoadingStore()
                loadingStore.endRequest()
            } catch {}
        }
        return response
    },
    async (error) => {
        if (!error.config?.skipLoading) {
            try {
                const loadingStore = useLoadingStore()
                loadingStore.endRequest()
            } catch {}
        }

        const originalRequest = error.config
        
        if (error.response?.status === 401 && !originalRequest?._retry) {
            originalRequest._retry = true
            
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            
            if (window.location.pathname !== '/login') {
                window.location.href = '/login'
            }
        }
        
        return Promise.reject(error)
    }
)

export default http
