<!-- <template>
  <v-app>
    <v-main>
      <router-view/>
    </v-main>
  </v-app>
</template>

<script>

export default {
  name: 'App',

  data: () => ({
    //
  }),
}
</script> -->
<template>
  <div id="app">
    <component :is="layout">
      <router-view></router-view>
    </component>
  </div>
</template>

<script>
import DefaultLayout from "./layouts/default";

export default {
  name: "App",
  components: {
    "DefaultLayout": DefaultLayout,
  },
  data() {
    return {
      layout: "DefaultLayout",
    };
  },
};
</script>