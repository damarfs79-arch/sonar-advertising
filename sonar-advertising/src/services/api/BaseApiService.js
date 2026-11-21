import http from './http.js'

export class BaseApiService {
    constructor(resource) {
        this.resource = resource
    }

    getAll(params = {}) {
        return http.get(`/${this.resource}`, { params })
    }

    getById(id) {
        return http.get(`/${this.resource}/${id}`)
    }

    create(data) {
        return http.post(`/${this.resource}`, data)
    }

    update(id, data) {
        return http.put(`/${this.resource}/${id}`, data)
    }

    delete(id) {
        return http.delete(`/${this.resource}/${id}`)
    }

    createWithFormData(data) {
        return http.post(`/${this.resource}`, this.buildFormData(data), {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
    }

    updateWithFormData(id, data) {
        const formData = this.buildFormData(data)
        formData.append('_method', 'PUT')
        return http.post(`/${this.resource}/${id}`, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
    }

    buildFormData(data) {
        const formData = new FormData()
        Object.keys(data).forEach(key => {
            if (data[key] instanceof File) {
                formData.append(key, data[key])
            } else if (Array.isArray(data[key])) {
                data[key].forEach((file, index) => {
                    if (file instanceof File) {
                        formData.append(`${key}[${index}]`, file)
                    } else if (file !== null && file !== undefined) {
                        formData.append(`${key}[${index}]`, file)
                    }
                })
            } else if (typeof data[key] === 'boolean') {
                formData.append(key, data[key] ? 1 : 0)
            } else if (data[key] !== null && data[key] !== undefined) {
                formData.append(key, data[key])
            }
        })
        return formData
    }
}
