import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  featured: [],
  total: 0,
  current_page: 1,
  check: true,
  params:
  {
    filter: 'rel',
    page: 1
  }
}

// getters
export const getters = {
  featured: state => state.featured,
  total: state => state.total,
  current_page: state => state.current_page,
  check: state => state.featured.length < state.total,
  params: state => state.params

}

// mutations
export const mutations = {

  [types.FETCH_FEATURED_SUCCESS] (state, { featured, total, current_page, params }) {
    state.featured = featured
    state.total = total
    state.current_page = current_page
    state.params = params
  },

  [types.FETCH_MORE_FEATURED_SUCCESS] (state, { featured, current_page, params }) {
    state.featured = state.featured.concat(featured)
    state.current_page = current_page
    state.params = params
  },

  [types.FETCH_FEATURED_FAILURE] (state) {
    state.featured = state.featured.concat([])
  }
}

// actions
export const actions = {
  async fetchFeatured ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/feature',
        {
          params: payload
        })

      commit(types.FETCH_FEATURED_SUCCESS, { featured: data.featured.data, total: data.featured.total, current_page: data.featured.current_page, params: payload })
    } catch (e) {
      commit(types.FETCH_FEATURED_FAILURE)
    }
  },

  async fetchMoreFeatured ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/feature',
        {
          params: payload
        })

      commit(types.FETCH_MORE_FEATURED_SUCCESS, { featured: data.featured.data, current_page: data.featured.current_page, params: payload })
    } catch (e) {
      commit(types.FETCH_FEATURED_FAILURE)
    }
  }

}
