import { BaseApiService } from './BaseApiService.js'

class PortfolioService extends BaseApiService {
    constructor() {
        super('portfolio')
    }

    create(data) {
        return this.createWithFormData(data)
    }

    update(id, data) {
        return this.updateWithFormData(id, data)
    }
}

export const portfolioService = new PortfolioService()
