<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center class="text-xs-center">
      <v-flex xs12 sm10 md8 lg6>
        <div style="font-size: 2em; margin-bottom: 2rem"><span>Pagina inexistenta</span></div>
        <v-btn :to="{ name: 'home' }" color="indigo" dark round>
          Acasa
        </v-btn>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>
