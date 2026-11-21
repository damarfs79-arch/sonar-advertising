import http from './http.js'

export const dashboardService = {
    getStats() {
        return http.get('/dashboard/stats')
    },
    
    getRecentActivity() {
        return http.get('/dashboard/recent-activity')
    }
}
