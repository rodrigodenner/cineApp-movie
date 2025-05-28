<template>
  <div class="bg-zinc-900 text-white min-h-screen">
    <Navbar/>
    <RouterView/>
    <Footer/>
  </div>
</template>

<script setup lang="ts">
import {RouterView} from 'vue-router'
import Navbar from "@/components/navbar/Navbar.vue";
import Footer from "@/components/footer/Footer.vue";
</script>

