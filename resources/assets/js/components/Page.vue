<template>
  <transition name="slide" mode="out-in">
    <slot>
      <v-content>
        <router-view/>
      </v-content>
    </slot>
  </transition>
</template>

<script>
export default {
  name: 'Page'
}
</script>
