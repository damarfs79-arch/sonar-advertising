import { BaseApiService } from './BaseApiService.js'
import http from './http.js'

class TestimonialService extends BaseApiService {
    constructor() {
        super('testimonials')
    }

    create(data) {
        if (data instanceof FormData) {
            return http.post('/testimonials', data, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
        }
        return this.createWithFormData(data)
    }

    update(id, data) {
        if (data instanceof FormData) {
            data.append('_method', 'PUT')
            return http.post(`/testimonials/${id}`, data, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
        }
        return this.updateWithFormData(id, data)
    }

    toggleFeatured(id) {
        return http.patch(`/testimonials/${id}/toggle-featured`)
    }
}

export const testimonialService = new TestimonialService()
