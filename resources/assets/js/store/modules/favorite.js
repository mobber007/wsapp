import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  favorites: [],
  total: 0,
  current_page: 1,
  check: true,
  next_page: '',
  status: ''

}

// getters
export const getters = {
  favorites: state => state.favorites,
  total: state => state.total,
  current_page: state => state.current_page,
  status: state => state.status,
  check: state => state.favorites.length < state.total,
  next_page: state => state.current_page + 1

}

// mutations
export const mutations = {

  [types.FETCH_FAVORITES_SUCCESS] (state, { favorites, total, current_page }) {
    state.favorites = favorites
    state.total = total
    state.current_page = current_page
  },
  [types.FETCH_MORE_FAVORITES_SUCCESS] (state, { favorites, current_page }) {
    state.favorites = state.favorites.concat(favorites)
    state.current_page = current_page
  },
  [types.SET_FAVORITE] (state, { data }) {
    state.total = state.total + 1
    state.status = data.status
  },
  [types.UNSET_FAVORITE] (state, { data }) {
    state.total = state.total - 1
    state.status = data.status
  },
  [types.FETCH_FAVORITES_FAILURE] (state) {
  }
}

// actions
export const actions = {
  async fetchFavorites ({ commit }) {
    try {
      const { data } = await axios.get('/api/favorite')

      commit(types.FETCH_FAVORITES_SUCCESS, { favorites: data.favorites.data, total: data.favorites.total, current_page: data.favorites.current_page })
    } catch (e) {
      commit(types.FETCH_FAVORITES_FAILURE)
    }
  },
  async fetchMoreFavorites ({ commit }) {
    try {
      const { data } = await axios.get('/api/favorite',
        {
          params:
            {
              page: state.current_page + 1
            }
        })

      commit(types.FETCH_MORE_FAVORITES_SUCCESS, { favorites: data.favorites.data, current_page: data.favorites.current_page })
    } catch (e) {
      commit(types.FETCH_FAVORITES_FAILURE)
    }
  },
  async setFavorite ({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/favorite/' + payload)

      commit(types.SET_FAVORITE, { data: data })
    } catch (e) {
      commit(types.FETCH_FAVORITES_FAILURE)
    }
  },

  async unsetFavorite ({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/unfavorite/' + payload)

      commit(types.UNSET_FAVORITE, { data: data })
    } catch (e) {
      commit(types.FETCH_FAVORITES_FAILURE)
    }
  }
}
