<template>
  <div>
  <template v-if="single">
    <v-btn
      color="error"
      flat
      value="recent"
      v-if="favorited"
      @click.prevent="unfavorite(product.id)"
    >
    <v-icon color="error">favorite</v-icon>
    </v-btn>
    <v-btn
      v-else=""
      color="error"
      flat
      value="recent"
    @click.prevent="favorite(product.id)"
    >
    <v-icon color="error">favorite_border</v-icon>
    </v-btn>
  </template>
  <template v-else="">
    <v-icon v-if="favorited" color="error" @click.prevent="unfavorite(product.id)">favorite</v-icon>
    <v-icon v-else="" color="error" @click.prevent="favorite(product.id)">favorite_border</v-icon>
  </template>
</div>
</template>

<script>
export default {
  name: 'Favorite',
  props: {
    favorited:
    {
      type: Boolean,
      required: true,
      default: false
    },
    single:
    {
      type: Boolean,
      required: false,
      default: false
    },
    product:
    {
      type: Object,
      required: true,
      default: null
    },
    index:
    {
      type: Number,
      required: false,
      default: 0
    }
  },
  data () {
    return {
    }
  },
  created () {
  },

  methods: {
    async favorite (product) {
      await this.$store.dispatch('favorite/setFavorite', product)
      this.product.favorited = true
      await this.syncFav(product)
      this.$store.state.favorite.favorites.push(this.product)
      const snackbar = {
        value: true,
        message: this.$store.state.favorite.status,
        type: 'indigo',
        avatar: false,
        icon: 'favorite',
        mode: '',
        timeout: 2000
      }
      await this.$store.dispatch('navi/setSnackbar', snackbar)
    },

    async unfavorite (product) {
      await this.$store.dispatch('favorite/unsetFavorite', product)
      this.product.favorited = false
      await this.syncFav(product)
      this.$store.state.favorite.favorites.splice(this.index, 1)
      const snackbar = {
        value: true,
        message: this.$store.state.favorite.status,
        type: 'indigo',
        avatar: false,
        icon: 'favorite_border',
        mode: '',
        timeout: 2000
      }
      await this.$store.dispatch('navi/setSnackbar', snackbar)
    },
    syncFav(product){
      if(this.$store.state.product.products.length)
      {
        var product_index = ''
        this.$store.state.product.products.filter(function(elem, index){
          if(elem.id == product)
          {
            product_index = index
          }
        })
        if(product_index !== '')
        this.$store.state.product.products.splice(product_index, 1, this.product)
      }
      if(this.$store.state.promotion.promotions.length)
      {
        var product_index = ''
        this.$store.state.promotion.promotions.filter(function(elem, index){
          if(elem.id == product)
          {
            product_index = index
          }
        })
      if(product_index !== '')
        this.$store.state.promotion.promotions.splice(product_index, 1, this.product)
      }
      if(this.$store.state.popular.populars.length)
      {
        var product_index = ''
        this.$store.state.popular.populars.filter(function(elem, index){
          if(elem.id == product)
          {
            product_index = index
          }
        })
      if(product_index !== '')
        this.$store.state.popular.populars.splice(product_index, 1, this.product)
      }
      if(this.$store.state.feature.featured.length)
      {
        var product_index = ''
        this.$store.state.feature.featured.filter(function(elem, index){
          if(elem.id == product)
          {
            product_index = index
          }
        })
        if(product_index !== '')
        this.$store.state.feature.featured.splice(product_index, 1, this.product)
      }
    }
  }
}
</script>
