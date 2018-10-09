import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  categories: [],
  total: 0
}

// getters
export const getters = {
  categories: state => state.categories,
  total: state => state.total,

}

// mutations
export const mutations = {

  [types.FETCH_CATEGORY_SUCCESS] (state, { categories, total}) {
    state.categories = categories
    state.total = total
  },
  [types.FETCH_CATEGORY_FAILURE] (state) {
    state.categories = state.categories.concat([])
  }
}

// actions
export const actions = {
  async fetchCategories ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/category')
      commit(types.FETCH_CATEGORY_SUCCESS, { categories: data.categories, total: data.categories.length })
    } catch (e) {
      commit(types.FETCH_CATEGORY_FAILURE)
    }
  }

}
