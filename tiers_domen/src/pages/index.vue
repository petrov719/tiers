<template>
  <v-container align="center">
    <h1 class="main-title" color="blue lighten-2">мейн</h1>
    <v-row>
      <v-col>
        <v-btn class="button" min-width="200" color="red" :to="'/creating'">создание</v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-btn class="button" min-width="200" color="red" :to="'/making'">тирлистирование</v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-btn class="button" min-width="200" color="red" @click=check()>хд</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from 'axios'
export default {
  name:'MainPage',
  data: () => ({

  }),
  methods: {
    check(){
      // alert("В ПРОЦЕСЕ")
      // this.$store.dispatch('get_user_id').then(result => {
      //   console.log(result); // здесь будет ваша цифра
      // });
    }
  },
  mounted() {

  },
}
</script>