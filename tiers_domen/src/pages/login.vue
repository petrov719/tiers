<template>
    <v-container align="center">
      <h1 class="main-title" color="blue lighten-2">Авторизация</h1>
      <v-row>
        <v-col>
          <v-text-field v-model="logindata.mail" label="Почта"></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-text-field v-model="logindata.password" label="Пароль"></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-btn class="button" min-width="200" color="red" @click="Login()">Авторизация</v-btn>
        </v-col>
      </v-row>
    </v-container>
</template>

<script>
import axios from 'axios'
export default {
    name: 'LoginPage',
    data: () => ({
        logindata:{mail:'', password:''},
    }),
    methods: {
        async Login(){
          await axios.get('/sanctum/csrf-cookie');
          axios.post('api/login',{email:this.logindata.mail, password:this.logindata.password}).then(response => {
            console.log(response.data)
            localStorage.currentToken = response.data.token
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.currentToken;
            this.$router.push('/')
          }).catch(error => {
            this.logindata.mail= '',
            this.logindata.password= ''
          })
        },
    },
    mounted() {

    },
}
</script>