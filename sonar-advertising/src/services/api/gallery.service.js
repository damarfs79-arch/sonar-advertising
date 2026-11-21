import { BaseApiService } from './BaseApiService.js'

class GalleryService extends BaseApiService {
    constructor() {
        super('gallery')
    }

    create(data) {
        return this.createWithFormData(data)
    }

    update(id, data) {
        return this.updateWithFormData(id, data)
    }
}

export const galleryService = new GalleryService()
