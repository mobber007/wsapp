<template>
  <v-snackbar
    v-model="$store.state.navi.snackbar.value"
    :color="$store.state.navi.snackbar.type"
    :multi-line="$store.state.navi.snackbar.mode"
    :timeout="$store.state.navi.snackbar.timeout"
    bottom
    right
  >
    {{ $store.state.navi.snackbar.message }}
    <v-btn dark v-if="$store.state.navi.snackbar.action"
           small
           @click.native="$store.state.navi.init_login = true"
    >
    Click aici
    </v-btn>
    <template v-else="">
      <v-btn v-if="!$store.state.navi.snackbar.avatar"
             icon
             small
             @click="$store.state.navi.snackbar.value = false"
      >
        <v-icon>{{ $store.state.navi.snackbar.icon }}</v-icon>
      </v-btn>

      <template v-else>
        <v-avatar size="32" class="mx-2">
          <img :src="$store.state.navi.snackbar.avatar">
        </v-avatar>
      </template>
    </template>
  </v-snackbar>
</template>

<script>
export default {
  name: 'Notification'
}
</script>
