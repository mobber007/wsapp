import axios from 'axios'
import store from '~/store'
import router from '~/router'
import swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
  }

  const locale = store.getters['lang/locale']
  if (locale) {
    request.headers.common['Accept-Language'] = locale
  }

  // request.headers['X-Socket-Id'] = Echo.socketId()

  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response
  if (status >= 500) {
    swal({
      type: 'error',
      title: i18n.t('error_alert_title'),
      text: i18n.t('error_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    })
  }

  /*if (status === 401 && store.getters['auth/check']) {
    swal({
      type: 'warning',
      title: i18n.t('token_expired_alert_title'),
      text: i18n.t('token_expired_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    }).then(() => {
      store.commit('auth/LOGOUT')
      store.commit('navi/loginSheet', true)
      router.push({ name: 'home' })
    })
  }*/
  if (status === 401 && store.getters['auth/check']) {
    const snackbar = {
      value: true,
      message: 'Sesiunea de autenticare a expirat. Va rugam sa va logati din nou.',
      type: 'error',
      mode: 'multi-line',
      avatar: false,
      icon: 'close',
      timeout: 6000
    }
    store.commit('auth/LOGOUT')
    store.dispatch('navi/setSnackbar', snackbar)
    store.commit('navi/loginSheet', true)
    router.push({ name: 'home' })
  }
  /*if (status === 422) {
    const snackbar = {
      value: true,
      message: 'Actiunea dvs. nu a putut fi procesata.',
      type: 'error',
      mode: 'multi-line',
      avatar: false,
      icon: 'close',
      timeout: 6000
    }
    store.dispatch('navi/setSnackbar', snackbar)
  }*/

  return Promise.reject(error)
})
