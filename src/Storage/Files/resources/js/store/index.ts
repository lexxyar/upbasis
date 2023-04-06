import {defineStore} from 'pinia'
import Toast from "../modules/Core/models/Toast"

export const useProfileStore = defineStore('profile', {
    state: () => {
        return {
            user: {} as any
        }
    },
    getters: {
        profile:(state)=>state.user,
    },
    actions: {
        fillUser(oUser:any){
            this.user = oUser
        },
    }
})

export const useToastStore = defineStore('toast', {
    state: () => {
        return {
            toasts: [] as any[],
        }
    },
    getters: {
        notifications: (state) => state.toasts,
    },
    actions: {
        addNotification({message, styl}) {
            const id = (Math.random().toString(32) + Date.now().toString(32)).substring(2)
            this.toasts.push(new Toast(id, styl, message))
            setTimeout(() => {
                this.removeNotification(id)
            }, 3000)
        },
        removeNotification(id) {
            const idx = this.toasts.findIndex(e => e.id === id)
            if (idx >= 0) {
                this.toasts.splice(idx, 1)
            }
        },

        notify(oValue) {
            const styl = oValue.styl ?? ''
            const message = oValue.message ?? ''
            this.addNotification({styl, message})
        },

        closeNotification(id) {
            this.removeNotification(id)
        },
    }
})
