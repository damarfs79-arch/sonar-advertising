import { BaseApiService } from './BaseApiService.js'
import http from './http.js'

class MessageService extends BaseApiService {
    constructor() {
        super('messages')
    }

    markAsRead(id) {
        return http.put(`/messages/${id}/read`)
    }
}

export const messageService = new MessageService()
