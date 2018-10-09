<template>
  <div>
    <v-container fluid fill-height>
      <v-slide-y-transition mode="out-in">
        <v-container grid-list-sm>
          <!--<v-carousel hide-delimiters>
            <v-carousel-item
              v-for="(item,i) in items"
              :key="i"
              :src="item.src"
              class="align-center justify-center text-xs-center"
            >
              <span><h1 class="font-weight-thin mb-3">{{item.title}}</h1></span>
            </v-carousel-item>

          </v-carousel>-->
          <v-layout row wrap>
            <v-flex v-for="i in 20" :key="i" xs12 sm6 md4 lg4 xl3>
              <v-card class="mx-2 my-2 elevation-8">
                <v-card-media :src="`https://randomuser.me/api/portraits/women/${i + 20}.jpg`" height="300px"></v-card-media>
                <v-btn fab dark class="left"  small color="error" style="margin-top: -290px">
                  <strong>15%</strong>
                </v-btn>
                <v-card-text>
                  <p class="text-xs-center"><span style="font-size: medium">Accesorii pentru femei</span> <v-spacer></v-spacer><span>100 ron </span><span style="text-decoration: line-through; color: red">200 ron</span></p>
                </v-card-text>
                <v-divider></v-divider>
                <v-list-tile @click="">
                  <v-list-tile-action>
                    <v-icon color="info">store</v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title style="font-size: medium"><strong>bmall.ro</strong></v-list-tile-title>
                  </v-list-tile-content>
                  <v-spacer></v-spacer>

                  <v-divider vertical></v-divider>
                  <v-btn small icon>
                    <v-icon color="error">favorite</v-icon>
                  </v-btn>
                  <v-divider vertical></v-divider>
                  <v-btn  small icon style="margin-right: -0.75em">
                    <v-icon color="indigo">remove_red_eye</v-icon>
                  </v-btn>
                </v-list-tile>


              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
      </v-slide-y-transition>
    </v-container>
  </div>
</template>

<script>
export default {
  name: 'Welcome',
  metaInfo () {
    return { title: 'Welcome' }
  },
  data () {
    return {
      items: [
        {
          title: "Bun venit pe WeStore",
          src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg'
        },
        {
          title: "Bun venit pe WeStore",
          src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg'
        },
        {
          title: "Bun venit pe WeStore",
          src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg'
        },
        {
          title: "Bun venit pe WeStore",
          src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg'
        }
      ]
    }
  },
}
</script>
