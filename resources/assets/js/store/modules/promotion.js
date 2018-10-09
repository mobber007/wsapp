import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  promotions: [],
  total: 0,
  current_page: 1,
  check: true,
  next_page: '',
  params:
  {
    filter: 'rel',
    page: 1
  }

}

// getters
export const getters = {
  promotions: state => state.promotions,
  total: state => state.total,
  current_page: state => state.current_page,
  check: state => state.promotions.length < state.total,
  next_page: state => state.current_page + 1,
  params: state => state.params

}

// mutations
export const mutations = {

  [types.FETCH_PROMOTIONS_SUCCESS] (state, { promotions, total, currentPage, params }) {
    state.promotions = promotions
    state.total = total
    state.current_page = currentPage
    state.params = params
  },

  [types.FETCH_MORE_PROMOTIONS_SUCCESS] (state, { promotions, currentPage, params }) {
    state.promotions = state.promotions.concat(promotions)
    state.current_page = currentPage
    state.params = params
  },

  [types.FETCH_PROMOTIONS_FAILURE] (state) {
    state.promotions = state.promotions.concat([])
  }
}

// actions
export const actions = {
  async fetchPromotions ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/promotion',
        {
          params: payload
        })

      commit(types.FETCH_PROMOTIONS_SUCCESS, { promotions: data.promotions.data, total: data.promotions.total, currentPage: data.promotions.current_page, params: payload })
    } catch (e) {
      commit(types.FETCH_PROMOTIONS_FAILURE)
    }
  },

  async fetchMorePromotions ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/promotion',
        {
          params: payload
        })

      commit(types.FETCH_MORE_PROMOTIONS_SUCCESS, { promotions: data.promotions.data, currentPage: data.promotions.current_page, params: payload })
    } catch (e) {
      commit(types.FETCH_PROMOTIONS_FAILURE)
    }
  }

}
