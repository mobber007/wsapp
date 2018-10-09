<template>
  <v-app>
    <Drawer/>
    <Navbar/>
    <Page transition="slide-x-reverse-transition"/>
  </v-app>
</template>

<script>
import Page from '../components/Page'
import Navbar from '../components/Navbar'
import Drawer from '../components/Drawer'

export default {
  name: 'MainLayout',
  components: {
    Navbar, Page, Drawer
  },
  data () {
    return {
      clipped: false,
      fixed: false,
      tabs: null,
      text: 'Adrian Meleanca',
      bottomNav: 3,
      dialog: false,
      notifications: false,
      sound: true,
      widgets: false,
      item:
        {
          action: 'list',
          title: 'Categorii',
          active: false,
          items: [
            { title: 'Barbati' },
            { title: 'Femei' },
            { title: 'Copii' }
          ]
        },

      title: 'WeStore'
    }
  },
  computed: {
    color () {
      switch (this.bottomNav) {
        case 0: return 'blue-grey'
        case 1: return 'teal'
        case 2: return 'brown'
        case 3: return 'indigo'
      }
    }
  },
  watch: {
  },
  mounted () {
  
  },
  methods: {
  }
}
</script>
