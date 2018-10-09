import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  populars: [],
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
  populars: state => state.populars,
  total: state => state.total,
  current_page: state => state.current_page,
  check: state => state.populars.length < state.total,
  params: state => state.params

}

// mutations
export const mutations = {

  [types.FETCH_POPULARS_SUCCESS] (state, { populars, total, current_page, params }) {
    state.populars = populars
    state.total = total
    state.current_page = current_page
    state.params = params
  },

  [types.FETCH_MORE_POPULARS_SUCCESS] (state, { populars, current_page, params }) {
    state.populars = state.populars.concat(populars)
    state.current_page = current_page
    state.params = params
  },

  [types.FETCH_POPULARS_FAILURE] (state) {
    state.populars = state.populars.concat([])
  }
}

// actions
export const actions = {
  async fetchPopulars ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/popular',
        {
          params: payload
        })

      commit(types.FETCH_POPULARS_SUCCESS, { populars: data.populars.data, total: data.populars.total, current_page: data.populars.current_page, params: payload })
    } catch (e) {
      commit(types.FETCH_POPULARS_FAILURE)
    }
  },

  async fetchMorePopulars ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/popular',
        {
          params: payload
        })

      commit(types.FETCH_MORE_POPULARS_SUCCESS, { populars: data.populars.data, current_page: data.populars.current_page, params: payload })
    } catch (e) {
      commit(types.FETCH_POPULARS_FAILURE)
    }
  }

}
