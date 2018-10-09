import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  products: [],
  product: null,
  total: 0,
  current_page: 1,
  check: true,
  next_page: '',
  params:
  {
    search: '',
    affiliate: null,
    filter: 'rel',
    brand: null,
    category: null,
    page: 1
  }

}

// getters
export const getters = {
  products: state => state.products,
  product: state => state.product,
  total: state => state.total,
  current_page: state => state.current_page,
  check: state => state.products.length < state.total,
  next_page: state => state.current_page + 1,
  params: state => state.params

}

// mutations
export const mutations = {

  [types.FETCH_PRODUCTS_SUCCESS] (state, { products, total, currentPage, params }) {
    state.products = products
    state.total = total
    state.current_page = currentPage
    state.params = params
  },
  [types.FETCH_PRODUCTS_FAILURE] (state) {
    state.products = null
  },
  [types.FETCH_MORE_PRODUCTS_SUCCESS] (state, { products, currentPage, params }) {
    state.products = state.products.concat(products)
    state.current_page = currentPage
    state.params = params
  },
  [types.FETCH_PRODUCT_SUCCESS] (state, { product }) {
    state.product = product
  },
  [types.FETCH_PRODUCT_FAILURE] (state) {
    state.product = null
  }
}

// actions
export const actions = {
  async fetchProducts ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/product',
        {
          params: payload
        })

      commit(types.FETCH_PRODUCTS_SUCCESS, { products: data.products.data, total: data.products.total, currentPage: data.products.current_page, params: payload })
    } catch (e) {
      commit(types.FETCH_PRODUCTS_FAILURE)
    }
  },
  async fetchProduct ({ commit }, id) {
    try {
      const { data } = await axios.get('/api/product/' + id)

      commit(types.FETCH_PRODUCT_SUCCESS, { product: data.product })
    } catch (e) {
      commit(types.FETCH_PRODUCT_FAILURE)
    }
  },

  async fetchMoreProducts ({ commit }, payload) {
    try {
      const { data } = await axios.get('/api/product',
        {
          params: payload
        })

      commit(types.FETCH_MORE_PRODUCTS_SUCCESS, { products: data.products.data, currentPage: data.products.current_page, params: payload })
    } catch (e) {
      commit(types.FETCH_PRODUCTS_FAILURE)
    }
  }

}
