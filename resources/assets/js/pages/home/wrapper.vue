<template>
  <div>
    <v-parallax
    dark
    src="/storage/graphics/home_header.jpg"
    >
    <v-layout
    align-center
    column
    justify-center
    >
    <h1 class="font-weight-thin mb-3" style="font-size: 4.6em">WeStore</h1>
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
      <a href="https://www.facebook.com/westore.ro/" target="_blank" style="text-decoration: none">
    <img src="/storage/graphics/fb_64x64.png" style="width: 48px;height: 48px"/>
      </a>

    </span>
    <span>
      <a href="https://www.instagram.com/westore.ro/" target="_blank" style="text-decoration: none">
      <img src="/storage/graphics/insta_64x64.png" style="width: 48px;height: 48px"/>
      </a>
    </span>
    <span>
      <a href="https://twitter.com/WeStore2" target="_blank" style="text-decoration: none">
    <img src="/storage/graphics/twitter_64x64.png" style="width: 48px;height: 48px"/>
      </a>
    </span>
    <span>
      <a href="https://www.pinterest.com/westorero/" target="_blank" style="text-decoration: none">
    <img src="/storage/graphics/pinterest_64x64.png" style="width: 48px;height: 48px"/>
      </a>

    </span>
    <span>
      <a href="https://plus.google.com/u/4/116658146234010767725" target="_blank" style="text-decoration: none">
  <img src="/storage/graphics/google_64x64.png" style="width: 48px;height: 48px"/>
      </a>

    </span>
  </div>
</v-layout>
</v-parallax>
<v-tabs fixed-tabs>
  <v-tab :to="{ name: 'home.hot' }">
    Trending
  </v-tab>
  <v-tab :to="{ name: 'home.informations' }">
    Informatii
  </v-tab>
  <v-tab :to="{ name: 'home.confidentiality' }">
    Confidentialitate
  </v-tab>
</v-tabs>
<router-view/>
</div>
</template>

<script>
export default {
  name: 'HomeWrapper',
  metaInfo () {
    return { title: 'Acasa' }
  }
}
</script>
<style type="text/css">
.vue-typer .custom.char {
  color: #ffffff;
  font-size: x-large;
}
</style>
