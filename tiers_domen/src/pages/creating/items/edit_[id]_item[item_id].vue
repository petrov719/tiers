<template>
    <v-container align="center">
        <v-row>
        <v-col cols="1">
          <v-btn
              color="grey"
              :to='"/creating/items/"+this.$route.params.id'
          >
              <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <h1 class="main-title" color="blue lighten-2">Изменение хз как назвать item короче</h1>
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
          <v-btn class="button" min-width="200" color="green" @click="edit_tierlist_item()">Изменить</v-btn>
        </v-col>
      </v-row>
    </v-container>
</template>
  
<script>
import axios from 'axios'
export default {
    name:"EditItems",
    data: () => ({
      name:'',
      description:'',
      item_id:'',
    }),
    methods: {
        edit_tierlist_item(){
          if (this.name != '' && this.item_id != ''){
            axios.post('tierlist_item/edit',{item_id:String(this.item_id), name:this.name, description:this.description}).then(response => {
              this.$router.push("/creating/items/"+this.$route.params.id)
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
      console.log(this.$route.params)
      axios.post('tierlist_item/index',{item_id: this.$route.params.item_id}).then(response=>{
        // console.log(response.data)
        this.item_id = response.data.id
        this.name = response.data.name
        this.description = response.data.description
      })
    },
}
</script>