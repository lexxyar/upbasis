import axios from "axios"
import Cookies from "js-cookie"

const conf = {apiUrl: 'http://127.0.0.1:8088/api/v1',}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const token = document.head?.querySelector('meta[name="csrf-token"]') as HTMLMetaElement;

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    // console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Content-Type'] = 'application/json'

// @ts-ignore
axios.defaults.baseURL = conf.apiUrl

axios.interceptors.request.use((config) => {
    const accessToken = Cookies.get('accessToken')
    const tokenType = Cookies.get('tokenType')

    if (accessToken) {
        config.headers.Authorization = `${tokenType} ${accessToken}`
    }

    // store.commit('setLoading', true)

    return config
}, () => {
    // store.commit('setError', error)
    // store.commit('setLoading', false)
})
axios.interceptors.response.use(response => {
    // store.commit('setLoading', false)
    return response
}, error => {
    console.log('error', error.response.status)
    if(error.response.status == 401){
        document.location.replace('/login')
    }
    // store.commit('setLoading', false)
    // store.commit('setErrors', error?.response?.data)
    return Promise.reject(error);
})
