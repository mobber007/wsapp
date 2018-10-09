<template>
  <v-container fluid fill-height grid-list-sm>
    <v-slide-y-transition mode="out-in">
      <v-layout v-if="total > 0" row wrap>
        <v-flex v-for="(product, index) in favorites" :key="index" xs12 sm6 md4 lg4 xl3>
          <product :product="product" :index="index"/>
        </v-flex>
        <mugen-scroll v-if="check" style="margin: 0 auto; margin-top: 1rem; margin-bottom: 1rem" :handler="fetchMoreFavorites" :should-handle="!loading">
          <v-progress-circular
          :size="32"
          color="indigo"
          indeterminate
          ></v-progress-circular>
        </mugen-scroll>
      </v-layout>
      <no-results v-else :message="`Nu aveti produse favorite`" :to="{ name: 'Produse', route: 'products'}"/>
    </v-slide-y-transition>
  </v-container>
</template>

<script>
import Product from '../../components/Product'
import MugenScroll from 'vue-mugen-scroll'
import NoResults from '../../components/NoResults'
import { mapGetters } from 'vuex'
export default {
  name: 'FavoritesIndex',
  middleware: 'auth',
  components: {
    Product, NoResults, MugenScroll
  },
  metaInfo () {
    return { title: 'Favorite' }
  },
  data () {
    return {
      loading: false
    }
  },
  computed: mapGetters({
    favorites: 'favorite/favorites',
    total: 'favorite/total',
    check: 'favorite/check',
    current_page: 'favorite/current_page',
    next_page: 'favorite/next_page'
  }),
  methods: {
    async fetchMoreFavorites()
    {
      this.loading = true
      this.$store.dispatch('favorite/fetchMoreFavorites').then(() => {
        this.loading = false
      })
    }

  }
}
</script>
