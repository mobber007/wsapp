<template>
  <v-container fluid fill-height grid-list-sm>
    <v-slide-y-transition mode="out-in">
      <v-layout row wrap>
        <v-flex v-for="(product, index) in promotions" :key="index" xs12 sm6 md4 lg4 xl3>
          <product :product="product" :index="index"/>
        </v-flex>
        <mugen-scroll v-if="check" style="margin: 0 auto; margin-top: 1rem; margin-bottom: 1rem" :handler="fetchMorePromotions" :should-handle="!loading">
          <v-progress-circular
          :size="32"
          color="indigo"
          indeterminate
          ></v-progress-circular>
        </mugen-scroll>
      </v-layout>
    </v-slide-y-transition>
  </v-container>
</template>

<script>
import Product from '../../components/Product'
import MugenScroll from 'vue-mugen-scroll'
import { mapGetters } from 'vuex'
export default {
  name: 'PromotionsIndex',
  components: {
    Product, MugenScroll
  },
  metaInfo () {
    return { title: 'Promotii' }
  },
  data () {
    return {
      loading: false
    }
  },
  computed: mapGetters({
    promotions: 'promotion/promotions',
    total: 'promotion/total',
    check: 'promotion/check',
    current_page: 'promotion/current_page',
    next_page: 'promotion/next_page'
  }),
  methods: {
    async fetchMorePromotions()
    {
      let params = {
        filter: this.$store.state.promotion.params.filter,
        page: this.current_page + 1
      }
      this.loading = true
      this.$store.dispatch('promotion/fetchMorePromotions', params).then(() => {
        this.loading = false
      })
    }

  }
}
</script>
