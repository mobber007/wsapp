<template>
  <v-layout align-center justify-center class="text-xs-center">
    <v-flex xs12 sm10 md8 lg6>
      <div style="font-size: 2em; margin-bottom: 2rem;"><span>{{ message }}</span></div>
      <v-btn v-if="to" :to="{ name: to.route }" color="indigo" dark round>
        {{ to.name }}
      </v-btn>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  name: 'NoResults',
  props: {
    message:
      {
        type: String,
        default: 'Nu am gasit niciun rezultat',
        required: true
      },
    to:
      {
        type: Object,
        default: null,
        required: false
      }
  }
}
</script>
