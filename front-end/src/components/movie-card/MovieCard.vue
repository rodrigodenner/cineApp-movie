<script setup lang="ts">
defineProps({ movie: Object })
</script>

<template>
  <img
      :src="movie.poster_path"
      :alt="movie.title"
      class="rounded-xl w-36 h-52 object-cover"
  />
</template>

<style scoped>

</style>