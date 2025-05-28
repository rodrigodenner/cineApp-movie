<template>
  <div class="bg-zinc-900 text-white min-h-screen">
    <Navbar />
  <RouterView />
  </div>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
import Navbar from "@/components/navbar/Navbar.vue";
</script>

