import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  widgets: null,

}

// getters
export const getters = {
  widgets: state => state.widgets,

}

// mutations
export const mutations = {

  [types.FETCH_WIDGETS_SUCCESS] (state, { widgets }) {
    state.widgets = widgets
  },
  [types.FETCH_WIDGETS_FAILURE] (state) {
    state.widgets = null
  }
}

// actions
export const actions = {
  async fetchWidgets ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/dashboard')
      commit(types.FETCH_WIDGETS_SUCCESS, { widgets: data })
    } catch (e) {
      commit(types.FETCH_WIDGETS_FAILURE)
    }
  }
}
