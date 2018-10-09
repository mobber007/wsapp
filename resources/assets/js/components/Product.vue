<template>
    <v-card v-if="product" transition="scale-transition" elevation-10 hover class="mx-1 my-1 rounded-radius">
      <router-link :to="{ name: 'products.single', params: { id: product.slug }}" style="text-decoration: none; color: black">
      <v-img :src="product.thumbnail"
             height="300px" contain class="rounded-radius">
             <v-layout
                   slot="placeholder"
                   fill-height
                   align-center
                   justify-center
                   ma-0
                 >
                   <v-progress-circular indeterminate color="grey darken-1"></v-progress-circular>
                 </v-layout>
      </v-img>
      <v-btn v-if="product.discounted" fab dark class="left" small color="error" style="margin-top: -290px">
        <strong>{{ product.discounted }}%</strong>
      </v-btn>
      <v-card-text class="text-xs-center text-truncate" v-text="product.title">
      </v-card-text>
       <v-card-text class="text-xs-center">
       <p style="font-size: medium"><span>{{ product.price }} ron </span><span v-if="product.discounted" style="text-decoration: line-through; color: red">{{ product.old_price }} ron</span></p>
      </v-card-text>
      </router-link>
      <v-divider/>
      <v-list-tile>
        <v-btn icon style="margin-left: -0.75em" @click="redirectTo(product.event_url)" >
          <v-icon color="info">store</v-icon>
        </v-btn>
        <v-list-tile-content style="margin-left: -0.75em">
          <div style="font-size: medium"><strong @click="redirectTo(product.event_url)">{{ product.affiliate }}</strong></div>
        </v-list-tile-content>
        <v-spacer/>
        <v-icon v-if="!$store.state.auth.user" color="error" @click="$store.state.navi.loginSheet = true" >favorite_border</v-icon>
        <div v-else>
          <favorite :favorited="product.favorited" :product="product" :index="index"/>
        </div>
        <router-link :to="{ name: 'products.single', params: { id: product.slug }}">
        <v-icon  class="mx-1" style="margin-right: -0.75em" color="indigo" @click="">remove_red_eye</v-icon>
        </router-link>
      </v-list-tile>
    </v-card>
</template>

<script>
import Favorite from './Favorite'
export default {
  name: 'Product',
  components: {
    Favorite
  },
  props: {
    product:
      {
        type: Object,
        default: null,
        required: true
      },
    index:
      {
        type: Number,
        default: 0,
        required: true
      }
  },
  data () {
    return {
      redirecting: false
    }
  },
  created () {
    // Fill the form with user data.
  },

  methods: {
    async redirectTo (url) {
      this.redirecting = true
      console.log('Redirecting')
      window.open(url)
      this.redirecting = false
      console.log('Redirected')
    }
  }
}
</script>
