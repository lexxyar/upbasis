import {createRouter, createWebHistory, RouteRecordRaw} from "vue-router";

let publicRoutesImport = []
let adminRoutesImport = []
let serverDependentRoutesImport = []

// @ts-ignore
const requireRoute = import.meta.glob('../modules/**/router/*.(ts|js)', {eager: true})

Object.keys(requireRoute).map((filePath) => {
    const fileName = filePath.split('/').pop().split('.').shift().toLowerCase()
    if(fileName === 'admin') {
        adminRoutesImport = [...adminRoutesImport, ...requireRoute[filePath].default]
    }
    else if(fileName === 'public') {
        publicRoutesImport = [...publicRoutesImport, ...requireRoute[filePath].default]
    }
    else if(fileName === 'server') {
        serverDependentRoutesImport = [...serverDependentRoutesImport, ...requireRoute[filePath].default]
    }
})

const adminRoutes: RouteRecordRaw = {
    path: '/admin',
    component: () => import('../modules/Core/layouts/AdminLayout.vue'),
    children: [...adminRoutesImport]
}
const routes = [...publicRoutesImport, ...serverDependentRoutesImport, adminRoutes]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
