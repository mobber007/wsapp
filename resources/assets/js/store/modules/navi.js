import * as types from '../mutation-types'

// state
export const state = {
  drawer: null,
  loginSheet: false,
  searchDialog: false,
  contactDialog: false,
  init_login: false,
  snackbar: {
    value: false,
    message: 'Salutari din partea WeStore',
    type: 'info',
    mode: 'multi-line',
    avatar: false,
    action: false,
    icon: 'close',
    timeout: 6000
  }
}

// getters
export const getters = {
  drawer: state => state.drawer,
  init_login: state => state.init_login,
  snackbar: state => state.snackbar,
  loginSheet: state => state.loginSheet,
  searchDialog: state => state.searchDialog,
  contactDialog: state => state.contactDialog,
  snackbar: state => state.snackbar
}

// mutations
export const mutations = {
  [types.SET_DRAWER] (state, { drawer }) {
    state.drawer = drawer
  },
  [types.SET_SNACKBAR] (state, { snackbar }) {
    state.snackbar = snackbar
  },
  [types.SET_LOGIN_SHEET] (state, { loginSheet }) {
    state.loginSheet = loginSheet
  },
  [types.SET_SEARCH_DIALOG] (state, { searchDialog }) {
    state.searchDialog = searchDialog
  },
  [types.SET_CONTACT_DIALOG] (state, { contactDialog }) {
    state.contactDialog = contactDialog
  }
}

// actions
export const actions = {
  setDrawer ({ commit, dispatch }, payload) {
    commit(types.SET_DRAWER, { drawer: payload })
  },
  setSnackbar ({ commit, dispatch }, payload) {
    commit(types.SET_SNACKBAR, { snackbar: payload })
  },
  setLoginSheet ({ commit, dispatch }, payload) {
    commit(types.SET_LOGIN_SHEET, { loginSheet: payload })
  },
  setSearcDialog ({ commit, dispatch }, payload) {
    commit(types.SET_SEARCH_DIALOG, { searchDialog: payload })
  },
  setContactDialog ({ commit, dispatch }, payload) {
    commit(types.SET_CONTACT_DIALOG, { contactDialog: payload })
  }
}
