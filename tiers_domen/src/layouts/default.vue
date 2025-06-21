<template>
    <v-app>
        <v-app-bar
        color="red"
        >
            <v-btn @click="authget()"><v-icon>mdi-home</v-icon></v-btn>
            <v-spacer></v-spacer>
            <v-btn @click="logout()" :to="'/login'"><v-icon>mdi-account-off</v-icon></v-btn>
            </v-app-bar>
        <v-main>
            <v-container>
                <router-view />
            </v-container>
        </v-main>
    </v-app>
</template>
<script>
import axios from 'axios'
export default {
    name: 'DefaultLayout',
    data: () => ({
        username:'1',
    }),
    methods: {
        authget(){
            this.$store.dispatch('get_user_id').then(result => {
                if(result!=null){
                    this.$router.push('/')
                }
            });
        },
        logout(){
            axios.post('api/logout',{}).then(response => {
            axios.defaults.headers.common['Authorization'] = '';
            this.$router.push('/login')
          }).catch(error => {
          })
        }
    },
    mounted(){
        this.$store.dispatch('get_user_id').then(result => {
            if(result==null){
                this.$router.push('/login')
            }
        });
    }
}
</script>