import {createApp} from 'vue'
import './app-boot'
// import './style.scss'
import {createPinia} from 'pinia'
import {i18n} from "./modules/Core/services/I18nService"
import App from './App.vue'
import router from './router'
import './store'
import './vendor/up-ui/0.11.17/up-ui.css'
import UpUI from "./vendor/up-ui/0.11.17/up-ui.es.js"


/* import font awesome icon component */
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import './fa-icons.ts'

const pinia = createPinia()

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        i18n
    }
}

const oApp = createApp(App)
    .component('fa', FontAwesomeIcon)
    .use(UpUI)
    .use(router)
    .use(pinia)
    .use(i18n)

oApp.mount('#app')
