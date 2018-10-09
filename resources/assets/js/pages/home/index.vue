<template>
  <v-container fluid fill-height grid-list-sm>
    <v-layout row wrap>
      <div v-if="loading_products" class="text-xs-center" style="margin: 0 auto; margin-top: 1rem; margin-bottom: 1rem">
        <v-progress-circular
        :size="32"
        color="indigo"
        indeterminate
        ></v-progress-circular>
      </div>
      <template v-else="">
      <v-flex xs12 class="my-5">
        <div class="text-xs-center">
          <h2 style="font-size: 2em">Alese de staff</h2>
        </div>
      </v-flex>
      <v-flex v-for="(product, index) in featured" :key="index" xs12 sm6 md4 lg4 xl3>
        <product :product="product" :index="index"/>
      </v-flex>
      <v-flex xs12 class="my-5">
        <div class="text-xs-center">
          <h2 style="font-size: 2em">Produse populare</h2>
        </div>
      </v-flex>
      <v-flex v-for="(product, index) in populars" :key="product.id" xs12 sm6 md4 lg4 xl3>
        <product :product="product" :index="index"/>
      </v-flex>
      </template>
    </v-layout>
  </v-container>
</template>

<script>
import Product from '../../components/Product'
import { mapGetters } from 'vuex'
export default {
  name: 'HomeIndex',
  components: {
    Product
  },
  metaInfo () {
    return { title: 'Acasa - Trending' }
  },
  data () {
    return {
      loading_products: false,
    }
  },
  computed: mapGetters({
    featured: 'feature/featured',
    populars: 'popular/populars'
  }),

  created () {
    this.get_products()
  },

  methods: {
    async get_products(){
      this.loading_products = true
      const params = this.$store.state.feature.params
      if(!this.$store.state.feature.featured.length)
      await this.$store.dispatch('feature/fetchFeatured', params)
      const popparams = this.$store.state.popular.params
      if(!this.$store.state.popular.populars.length)
      await this.$store.dispatch('popular/fetchPopulars', popparams)
      this.loading_products = false
    },
  }
}
</script>
