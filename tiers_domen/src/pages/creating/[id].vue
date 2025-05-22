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
      <h1 class="main-title" color="blue lighten-2">Изменение тирлиста</h1>
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
          <v-btn class="button" min-width="200" color="green" @click="edit_tierlist()">Изменить</v-btn>
        </v-col>
      </v-row>
    </v-container>
</template>
  
<script>
import axios from 'axios'
export default {
    name:"EditTierlistId",
    data: () => ({
      name:'',
      description:'',
      tierlist_id:'',
    }),
    methods: {
        edit_tierlist(){
          if (this.name != '' && this.tierlist_id != ''){
            axios.post('api/tierlist/edit',{tierlist_id:String(this.tierlist_id), name:this.name, description:this.description}).then(response => {
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
      axios.post('api/tierlist/index',{tierlist_id: this.$route.params.id}).then(response=>{
        this.tierlist_id = response.data.id
        this.name = response.data.name
        this.description = response.data.description
      })
    },
}
</script>