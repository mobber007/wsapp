<template>
  <div id="app">
          <loading ref="loading"/>
        <transition name="page" mode="out-in">
          <component v-if="layout" :is="layout"/>
        </transition>
        <notification/>
        <back-to-top :hidden="goTop"/>
        </div>
  </div>
</template>

<script>
import Loading from './Loading'
import Notification from './Notification'
import BackToTop from './BackToTop'

// Load layout components dynamically.
const requireContext = require.context('~/layouts', false, /.*\.vue$/)

const layouts = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)]
  )
  .reduce((components, [name, component]) => {
    components[name] = component.default || component
    return components
  }, {})

export default {
  el: '#app',

  components: {
    Loading, Notification, BackToTop
  },

  data: () => ({
    layout: null,
    defaultLayout: 'default',
    goTop: false
  }),

  metaInfo () {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  },

  mounted () {
    this.$loading = this.$refs.loading
  },
 created () {
   window.addEventListener('scroll', this.handleScroll);
 },
 destroyed () {
   window.removeEventListener('scroll', this.handleScroll);
 },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
     handleScroll (event) {
       this.goTop = window.pageYOffset > window.innerHeight
     },
     handleConnectivityChange(status) {
     console.log(status);
   },

    setLayout (layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
    }
  }
}
</script>
