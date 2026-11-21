import http from './http.js'

export const uploadService = {
    upload(file, directory = 'general') {
        const formData = new FormData()
        formData.append('file', file)
        formData.append('directory', directory)
        
        return http.post('/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
    }
}
