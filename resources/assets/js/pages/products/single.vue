<template>
  <div v-if="product">
    <v-layout row wrap>
      <v-flex xs12 sm12 md8 lg8 xl8 d-flex>
        <v-card flat>
          <v-carousel flat reverse-transition="fade"
                      transition="fade"
                      style="min-height: 75vh"
                      hide-delimiters
                      light>
            <v-carousel-item
              v-for="(image,index) in product.images"
              :key="index"
              :src="image.url"
              contain
            >
            <v-btn fab dark class="left" small color="dark">
              <strong>{{index + 1}}/{{product.images.length}}</strong>
            </v-btn>
            </v-carousel-item>
          </v-carousel>
        </v-card>
      </v-flex>
      <v-flex xs12 sm12 md4 lg4 xl4 d-flex>
        <v-card elevation-10>
            <v-btn v-if="product.discounted" fab dark class="left" small color="error" style="margin-bottom: -40px">
              <strong>{{ product.discounted }}%</strong>
            </v-btn>
            <a @click="redirectTo(product.event_url)" style="text-decoration: none">
              <v-img :src="product.affiliate_logo" contain height="140" width="100%"/></a>
          <v-card-text style="padding-bottom: 60px">
            <p class="text-xs-center"><span style="font-size: medium">{{ product.title }}</span> <v-spacer/><span>{{ product.price }} ron </span><span v-if="product.discounted" style="text-decoration: line-through; color: red">{{ product.old_price }} ron</span></p>
                    <v-card elevation-5>
                      <v-card-title><h4 style="margin: 0 auto">Informatii</h4></v-card-title>
                      <v-divider></v-divider>
                      <v-list dense>
                        <v-list-tile>
                          <v-list-tile-content>Categorie:</v-list-tile-content>
                          <v-list-tile-content class="align-end"><strong>{{ product.category }}</strong></v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile>
                          <v-list-tile-content>Subcategorie:</v-list-tile-content>
                          <v-list-tile-content class="align-end"><strong>{{ product.subcategory }}</strong></v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile>
                          <v-list-tile-content>Brand:</v-list-tile-content>
                          <v-list-tile-content class="align-end"><strong>{{ product.brand }}</strong></v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile>
                          <v-list-tile-content>Vandut de:</v-list-tile-content>
                          <v-list-tile-content class="align-end"><strong>{{ product.affiliate }}</strong></v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile>
                          <v-list-tile-content>Accesari:</v-list-tile-content>
                          <v-list-tile-content class="align-end"><strong>{{ product.total_views }}</strong></v-list-tile-content>
                        </v-list-tile>
                      </v-list>
                    </v-card>
          </v-card-text>

    <v-bottom-nav
      :active.sync="bottomNav"
      :value="true"
      absolute
      color="transparent"
    >
      <v-btn
        color="indigo"
        flat
        value="recent"
        @click="$router.go(-1)"
      >
        <v-icon>keyboard_arrow_left</v-icon>
      </v-btn>

      <v-btn
        color="error"
        flat
        value="recent"
        v-if="!$store.state.auth.user"
        @click="$store.state.navi.loginSheet = true"
      >
        <v-icon>favorite_border</v-icon>
      </v-btn>
      <template v-else="">
        <favorite :favorited="product.favorited" :product="product" :single="true" style="width: 100%"/>
      </template>

      <v-btn
        color="info"
        flat
        value="recent"
        @click="redirectTo(product.event_url)"
      >
        <v-icon>store</v-icon>
      </v-btn>
    </v-bottom-nav>
        </v-card>
      </v-flex>
    </v-layout>

    <v-container fill-height grid-list-sm>
        <v-layout row wrap>
          <div v-if="loading_similars" class="text-xs-center" style="margin: 0 auto; margin-top: 1rem; margin-bottom: 1rem">
            <v-progress-circular
            :size="32"
            color="indigo"
            indeterminate
            ></v-progress-circular>
          </div>

          <v-flex v-else="" xs12 class="my-5">
            <div class="text-xs-center">
              <h2 v-if="similars" style="font-size: 2em">Produse similare</h2>
              <h2 v-else="" style="font-size: 2em">Nu exista produse similare</h2>
            </div>
          </v-flex>
          <v-flex v-for="(product, index) in similars" :key="index" xs12 sm6 md4 lg4 xl3>
            <product :product="product" :index="index"/>
          </v-flex>
        </v-layout>
    </v-container>
  </div>
</template>

<script>
import Product from '../../components/Product'
import Favorite from '../../components/Favorite'
import { mapGetters } from 'vuex'
import axios from 'axios'
export default {
  name: 'ProductSingle',
  components: {
    Product, Favorite
  },
  data () {
    return {
      description_panel: [true],
      similars: '',
      loading_similars: false,
      bottomNav: 'recent'
    }
  },
  computed: mapGetters({
    product: 'product/product'
  }),
  created: function(){
    this.similars = ''
    this.get_similars()
  },
  watch: {
    'product.id': function(){
      this.similars = ''
      this.get_similars()
    }
  },
  methods: {
    async redirectTo (url) {
      this.redirecting = true
      console.log('Redirecting')
      window.open(url)
      this.redirecting = false
      console.log('Redirected')
    },
    async get_similars()
    {
      this.loading_similars = true
      const data = await axios.get(`/api/similars/${this.product.id}`)
      this.similars = data.data.similars
      this.loading_similars = false
    }
  },
  metaInfo () {
    return { title: this.product.title }
  }
}
</script>
