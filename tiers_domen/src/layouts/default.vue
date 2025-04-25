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
export default {
    name: 'DefaultLayout',
    data: () => ({
        username:'1',
    }),
    methods: {
        authget(){
            if(localStorage.currentToken!=null){
                this.$router.push('/')
            }
        },
        logout(){
            localStorage.currentToken = 'null'
        }
    },
    mounted(){
        console.log(localStorage)
        if(localStorage.currentToken=='null' | localStorage.currentToken==null){
            this.$router.push('/login')
        }
    }
}
</script>