<template>
  <v-container fluid fill-height grid-list-sm>
    <v-layout row wrap>
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
    }
  },
  computed: mapGetters({
    featured: 'feature/featured',
    populars: 'popular/populars'
  }),

  created () {
  },

  methods: {
  }
}
</script>
