import http from './http.js'

export const settingsService = {
    getAll() {
        return http.get('/settings')
    },
    
    update(data) {
        return http.put('/settings', data)
    },

    uploadFile(file, key) {
        const formData = new FormData()
        formData.append('file', file)
        formData.append('key', key)
        
        return http.post('/settings/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    }
}
