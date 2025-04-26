<template>
    <v-container align="center">
      <v-row>
        <v-col cols="1">
          <v-btn
              color="grey"
              :to='"/creating/items/" + this.$route.params.id'
          >
              <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <h1 class="main-title" color="blue lighten-2">Создание предмета</h1>
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
          <v-btn class="button" min-width="200" color="green" @click="create_tierlist_item()">Создать</v-btn>
        </v-col>
      </v-row>
    </v-container>
</template>
  
<script>
import axios from 'axios'
export default {
    name:"CreatingItemsCreate",
    data: () => ({
      name:'',
      description:'',
    }),
    methods: {
      create_tierlist_item(){
          if (this.name != ''){
            axios.post('tierlist_item/create',{name: this.name, description: this.description, tierlist_id: this.$route.params.id}).then(response => {
              this.$router.push('/creating/items/' + this.$route.params.id)
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

    },
}
</script>