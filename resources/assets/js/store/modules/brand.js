import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  brands: [],
  total: 0
}

// getters
export const getters = {
  brands: state => state.brands,
  total: state => state.total,

}

// mutations
export const mutations = {

  [types.FETCH_BRAND_SUCCESS] (state, { brands, total}) {
    state.brands = brands
    state.total = total
  },
  [types.FETCH_BRAND_FAILURE] (state) {
    state.brands = state.brands.concat([])
  }
}

// actions
export const actions = {
  async fetchBrands ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/brand')

      commit(types.FETCH_BRAND_SUCCESS, { brands: data.brands, total: data.brands.length })
    } catch (e) {
      commit(types.FETCH_BRAND_FAILURE)
    }
  }

}
