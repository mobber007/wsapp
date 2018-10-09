<template>
  <v-toolbar
  tabs
  fixed
  dark
  dense
  app
  color="indigo"
  >
  <v-toolbar-side-icon @click.stop="$store.state.navi.drawer = !$store.state.navi.drawer" dark color="indigo">
    <v-icon>menu</v-icon>
  </v-toolbar-side-icon>
  <v-spacer/>
  <div class="text-xs-center">
    <v-toolbar-title>
      WeStore
    </v-toolbar-title>
  </div>
  <v-spacer/>
<search-dialog/>
<v-tabs
slot="extension"
v-model="tabs"
fixed-tabs
color="transparent"
>
<v-tabs-slider/>
<v-tab :to="{ name: 'home' }" class="primary--text" router>
  <v-icon>home</v-icon>
</v-tab>
<v-tab :to="{name: 'products'}" class="primary--text" router>
  <v-icon>store</v-icon>
</v-tab>

<v-tab :to="{name: 'promotions'}" class="primary--text" router>
  <v-icon>local_offer</v-icon>
</v-tab>
<v-tab :to="{name: 'favorites'}" class="primary--text">
  <v-icon>favorite</v-icon>
</v-tab>
</v-tabs>
</v-toolbar>
</template>

<script>
import { mapGetters } from 'vuex'
import SearchDialog from './SearchDialog'
export default {
  name: 'Navbar',
  components: {
    SearchDialog
  },
  data: () => ({
    title: window.config.appName,
    search: '',
    loading: false,
    tabs: null
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  created ()
  {
    this.search = this.$store.state.product.params.search
  },
  methods: {
    async logout () {

      const snackbar = {
        value: true,
        message: `La revedere ${this.$store.state.auth.user.name}  `,
        type: 'warning',
        avatar: this.$store.state.auth.user.avatar,
        icon: 'close',
        mode: '',
        timeout: 6000
      }
      await this.$store.dispatch('navi/setSnackbar', snackbar)
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>
