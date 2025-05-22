<template>
    <v-container align="center">
      <v-row>
        <v-col cols="1">
          <v-btn
              color="grey"
              to="/creating"
          >
              <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <h1 class="main-title" color="blue lighten-2">Создание тирлиста</h1>
      <v-row>
        <v-col cols="6">
          <v-text-field label="Название" v-model="name"></v-text-field>
        </v-col>
        <v-col cols="6">
          <v-text-field label="Описание" v-model="description"></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-btn class="button" min-width="200" color="green" @click="create_tierlist()">Создать</v-btn>
        </v-col>
      </v-row>
    </v-container>
</template>
  
<script>
import axios from 'axios'
export default {
    name:"CreatingTierlistCreatePage",
    data: () => ({
      name:'',
      user_id: null,
      description:'',
    }),
    methods: {
        create_tierlist(){
          if (this.name != ''){
            axios.post('api/tierlist/create',{name: this.name, description: this.description, user_id: this.user_id}).then(response => {
              this.$router.push('/creating')
            })
          } else {
            alert("НАЗВАНИЕ!")
          }
        },
        check(){
            console.log(this.name)
        },
    },
    mounted() {
      this.$store.dispatch('get_user_id').then(result => {
        this.user_id = result;
      });
    },
}
</script>