import store from '~/store'

export default async (to, from, next) => {
  if (!store.getters['auth/check']) {
    store.state.navi.loginSheet = true
    if (from.name) {
      next({ name: from.name })
    } else {
      next({ name: 'home' })
    }
  } else {
    next()
  }
}
