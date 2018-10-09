import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user'].role !== 'guru') {
    next({ name: 'home' })
  } else {
    next()
  }
}
