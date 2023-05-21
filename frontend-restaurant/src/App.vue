<template>
  <div class="h-screen">
    <Header />

    <router-view></router-view>
  </div>
</template>

<script>
import Header from "./components/Header.vue";
export default {
  name: "AppComponent",
  components: {
    Header,
  },
};
</script>
