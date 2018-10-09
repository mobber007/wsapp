import store from '~/store'

export default async (to, from, next) => {
  if (!store.getters['product/products']) {
    store.dispatch('product/fetchProducts')
    next()
  } else {
    next()
  }
}
