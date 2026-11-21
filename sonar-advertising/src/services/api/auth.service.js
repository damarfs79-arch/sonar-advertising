import http from './http.js'

export const authService = {
    login(email, password) {
        return http.post('/auth/login', { email, password })
    },
    
    logout() {
        return http.post('/auth/logout')
    },
    
    getUser() {
        return http.get('/auth/user')
    }
}
