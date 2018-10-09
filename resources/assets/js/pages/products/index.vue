<template>
  <v-container fluid fill-height grid-list-sm>
    <v-layout row wrap>
      <v-flex v-for="(product, index) in products" :key="index" xs12 sm6 md4 lg4 xl3>
        <product :product="product" :index="index"/>
      </v-flex>
      <mugen-scroll v-if="check" style="margin: 0 auto; margin-top: 1rem; margin-bottom: 1rem" :handler="fetchMoreProducts" :should-handle="!loading">
        <v-progress-circular
        :size="32"
        color="indigo"
        indeterminate
        ></v-progress-circular>
      </mugen-scroll>
      <v-layout v-if="!products.length" align-center justify-center class="text-xs-center">
        <v-flex xs12 sm10 md8 lg6>
          <div style="font-size: 2em; margin-bottom: 2rem;"><span>Nu am gasit rezulate pt cautarea {{ $store.state.product.params.search }}</span></div>
          <v-btn color="indigo" dark round @click.native="$store.state.navi.searchDialog = true">
            Cauta din nou
          </v-btn>
        </v-flex>
      </v-layout>
    </v-layout>
  </v-container>
</template>

<script>
import Product from '../../components/Product'
import MugenScroll from 'vue-mugen-scroll'
import NoResults from '../../components/NoResults'
import { mapGetters } from 'vuex'
export default {
  name: 'ProductsIndex',
  scrollToTop: false,
  components: {
    Product, MugenScroll, NoResults
  },
  metaInfo () {
    return { title: 'Produse' }
  },
  data () {
    return {
      redirecting: false,
      loading: false,
      isLoadingCategories: false,
      category: null,
      items: [],
      model: null,
    }
  },
  computed: mapGetters({
    products: 'product/products',
    check: 'product/check',
    current_page: 'product/current_page',
    next_page: 'product/next_page'
  }),
  watch: {
      category (val) {
        // Items have already been loaded
        if (this.items.length > 0) return

        this.isLoadingCategories = true

        // Lazily load input items
        axios.get('api/category')
          .then(res => {
            this.items = res.data.categories
          })
          .catch(err => {
            console.log(err)
          })
          .finally(() => (this.isLoadingCategories = false))
      }
    },

  created () {
  },

  methods: {
    async fetchMoreProducts()
    {
      let params = {
        search: this.$store.state.product.params.search,
        affiliate: this.$store.state.product.params.affiliate,
        category: this.$store.state.product.params.category,
        brand: this.$store.state.product.params.brand,
        filter: this.$store.state.product.params.filter,
        page: this.current_page + 1
      }
      this.loading = true
      this.$store.dispatch('product/fetchMoreProducts', params).then(() => {
        this.loading = false
      })
    },
    async resetFilters()
    {
      let params = {
        search: '',
        page: 1
      }
      this.$store.dispatch('product/fetchProducts', params).then(() => {
      })
    }

  }
}
</script>
