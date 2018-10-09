import store from '~/store'
export default async (to, from, next) => {
  if (!store.state.feature.featured.length) {
      const params = store.state.feature.params
      store.dispatch('feature/fetchFeatured', params)
    next()
  } else {
    next()
  }
}
