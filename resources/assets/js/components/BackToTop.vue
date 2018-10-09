<template>
  <v-fab-transition>
              <v-btn
                v-show="hidden"
                color="indigo"
                dark
                fixed
                bottom
                right
                small
                fab
                @click="goTop()"
              >
                <v-icon>keyboard_arrow_up</v-icon>
              </v-btn>
            </v-fab-transition>
</template>

<script>
export default {
  name: 'BackToTop',
  components: {
  },
  props: {
    hidden:
      {
        type: Boolean,
        default: false,
        required: true
      },
  },
  data () {
    return {
      redirecting: false
    }
  },
  methods:{
    goTop()
    {
      window.scroll({ top: 0, left: 0, behavior: 'smooth' })
    }
  }
}
</script>
