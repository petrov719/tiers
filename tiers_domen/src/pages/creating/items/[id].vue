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
      <h1 class="main-title" color="blue lighten-2">Менеджмент предметов для тирлистов</h1>
      <v-row justify="end">
        <v-col cols="8">
          <h2>Выбраный тирлист: {{ tierlist_name }}</h2>
        </v-col>
        <v-col cols="4">
          <v-btn
              color="green"
              :to='"/creating/items/create" + this.$route.params.id'
          >
              <v-icon>mdi-plus</v-icon>
          </v-btn>
          <v-btn
              color="blue"
              @click="getdata()"
          >
              <v-icon>mdi-refresh</v-icon>
          </v-btn>
          <v-btn
              v-if="star_permission"
              color="yellow"
              @click="get_clone()"
          >
              <v-icon color="white">mdi-star</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <v-row justify="center" v-if="star_status">
        <v-col cols="6">
          <v-select :items="clone_tierlists" item-title="name" item-value="id" label="Выбери тирлист" v-model="clone_tierlist"></v-select>
        </v-col>
        <v-col cols="6">
          <v-btn v-if="clone_tierlist" color="green" width="150" @click="clone()">Скопировать</v-btn>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-data-table
            :headers="headers"
            :items="items_from_tierlist"
            :loading="loadTable"
            loading-text="Грузим"
            no-data-text="Нет данных"
            no-results-text="Нет результатов"
            hide-default-footer
          >
          <template v-slot:[`item.actions`]="{ item }">
            <v-btn color="blue" @click="edit_tierlist_item(item)"><v-icon>mdi-pen</v-icon></v-btn>
          </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    name:"CreatingItemsId",
    data: () => ({
      star_status:false,
      star_permission:false,
      loadTable:false,
      clone_tierlist:null,
      tierlist_name: null,
      headers:[
        { title: 'Название', align: 'center', key: 'name'},
        { title: 'Описание', align: 'center', key: 'description'},
        { title: 'Действия', align: 'center', key: 'actions'},],
      items_from_tierlist:[],
      clone_tierlists:[],
    }),
    methods: {
      getdata(){
        this.loadTable = true
        axios.post('tierlist/index',{tierlist_id: this.$route.params.id}).then(response=>{
            this.tierlist_name = response.data.name
        })
        axios.post('tierlist_item/get',{tierlist_id: this.$route.params.id}).then(response=>{
          if(response.data.length == 0){
            this.star_permission = true
          } else {
            this.star_permission = false
            this.star_status = false
          }
          this.items_from_tierlist = response.data
          this.loadTable = false
        })
      },
      get_clone(){
        axios.post('tierlist/get').then(response=>{
          this.clone_tierlists = response.data
          this.star_status = true
        })
      },
      edit_tierlist_item(data){
        this.$router.push('/creating/items/edit_'+this.$route.params.id+''+data.id)
      },
      clone(){
        axios.post('tierlist_item/clone',{ot: this.clone_tierlist, to: this.$route.params.id}).then(response=>{
            this.getdata()
        })
      },
      check(){
        console.log(this.clone_tierlist)
      },
      mounted() {
        console.log(this.$route.params.id)
        axios.post('tierlist/index',{tierlist_id: this.$route.params.id}).then(response=>{
            this.tierlist_name = response.data.name
        })
      },
    },
}
</script>
<style scoped>
    .centered-input >>> input {
      text-align: center
    }
</style>