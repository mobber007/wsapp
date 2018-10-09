import store from '~/store'
export default async (to, from, next) => {
  if (!store.state.popular.populars.length) {
      const params = store.state.popular.params
      store.dispatch('popular/fetchPopulars', params)
    next()
  } else {
    next()
  }
}
