import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  affiliates: [],
  total: 0
}

// getters
export const getters = {
  affiliates: state => state.affiliates,
  total: state => state.total,

}

// mutations
export const mutations = {

  [types.FETCH_AFFILIATE_SUCCESS] (state, { affiliates, total}) {
    state.affiliates = affiliates
    state.total = total
  },
  [types.FETCH_AFFILIATE_FAILURE] (state) {
    state.affiliates = state.affiliates.concat([])
  }
}

// actions
export const actions = {
  async fetchAffiliates ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/affiliate')

      commit(types.FETCH_AFFILIATE_SUCCESS, { affiliates: data.affiliates, total: data.affiliates.length })
    } catch (e) {
      commit(types.FETCH_AFFILIATE_FAILURE)
    }
  }

}
