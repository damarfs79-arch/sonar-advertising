import { BaseApiService } from './BaseApiService.js'

class BlogService extends BaseApiService {
    constructor() {
        super('blog')
    }

    buildFormData(data) {
        const formData = new FormData()
        Object.keys(data).forEach(key => {
            if (data[key] instanceof File) {
                formData.append(key, data[key])
            } else if (key === 'tags' && Array.isArray(data[key])) {
                formData.append(key, JSON.stringify(data[key]))
            } else if (typeof data[key] === 'boolean') {
                formData.append(key, data[key] ? 1 : 0)
            } else if (key === 'published_at') {
                formData.append(key, data[key] || '')
            } else if (data[key] !== null && data[key] !== undefined) {
                formData.append(key, data[key])
            }
        })
        return formData
    }

    create(data) {
        return this.createWithFormData(data)
    }

    update(id, data) {
        return this.updateWithFormData(id, data)
    }
}

export const blogService = new BlogService()
