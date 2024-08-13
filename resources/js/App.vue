<template>
    <div id="app">
        <!-- <h1>Hello Vue 3 + TypeScript + Laravel + Vite!</h1> -->
        <Navigation />
        <router-view></router-view>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Navigation from "./components/Navigation.vue";

export default {
    name: "App",
    components: {
        Navigation,
    },
};

// export default defineComponent({
//     name: "App",
// });
</script>

<style scoped>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}
</style>
