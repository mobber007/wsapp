<template>
  <div>
    <v-parallax
    dark
    src="/storage/graphics/home_header.png"
    >
    <v-layout
    align-center
    column
    justify-center
    >
    <h1 class="font-weight-thin mb-3" style="font-size: 4.6em">Admin dashboard</h1>
    <div style="min-height: 100px">
      <vue-typer
      :text='["Cumpara cu spor!","Cauta rapid produse!","Simplu si eficient!","Adauga in wishlist!","Nu pierde reducerile zilnice!"]'
      :repeat='Infinity'
      :shuffle='false'
      :pre-type-delay='70'
      :type-delay='70'
      :pre-erase-delay='1500'
      :erase-delay='200'
      :erase-on-complete='true'
      erase-style='backspace'
      initial-action='typing'
      caret-animation='smooth'
      class="subheading"
      />
    </div>
  </v-layout>
  <v-layout
  align-center
  column
  justify-end
  class="my-3 mx-1"
  >
  <div>
    <span>
      <img src="https://i.imgur.com/36TRHS4.png" style="width: 40px;height: 40px"/>
    </span>
    <span>
      <img src="https://i.imgur.com/7z4kRPa.png?1" style="width: 40px;height: 40px; background-color: transparent"/>
    </span>
  </div>
</v-layout>
</v-parallax>
<v-layout
  column
  wrap
  class="my-5"
  align-center
>
  <v-flex xs12 sm4 class="my-3">
    <div class="text-xs-center">
      <h2 style="font-size: 2em">Statistici interne</h2>
    </div>
  </v-flex>
  <v-flex xs12>
    <v-container grid-list-xl>
      <v-layout row wrap align-center fill-height>
        <v-flex v-for="(widget, index) in widgets" :key="index" xs12 md4 xl-4 lg-4>
          <v-card elevation-10 hover class="transparent" style="border-radius: 1.5rem; min-width: 200px">
            <v-card-text class="text-xs-center">
              <v-icon color="indigo" size="96">{{ widget.icon }}</v-icon>
            </v-card-text>
            <v-card-title primary-title class="layout justify-center">
              <h2>{{ widget.total }}</h2>
            </v-card-title>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-flex>
</v-layout>
</div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'DashboardWrapper',
  middleware: 'admin',
  metaInfo () {
    return { title: 'Dashboard' }
  },
  data () {
    return {
      redirecting: false,
      loading: false
    }
  },
  computed: mapGetters({
    widgets: 'widget/widgets'
  }),
}
</script>
<style type="text/css">
.vue-typer .custom.char {
  color: #ffffff;
  font-size: x-large;
}
</style>
