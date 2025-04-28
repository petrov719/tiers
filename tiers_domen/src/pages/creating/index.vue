<template>
    <v-container align="center">
      <v-row>
        <v-col cols="1">
          <v-btn
              color="grey"
              to="/"
          >
              <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <h1 class="main-title" color="blue lighten-2">Создание тирлистов</h1>
      <v-row justify="end">
        <v-col cols="4">
          <v-btn
              color="green"
              to="/creating/create_tierlist"
          >
              <v-icon>mdi-plus</v-icon>
          </v-btn>
          <v-btn
              color="blue"
              @click="getdata()"
          >
              <v-icon>mdi-refresh</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-data-table
            :headers="headers"
            :items="tierlists"
            :loading="loadTable"
            loading-text="Грузим"
            no-data-text="Нет данных"
            no-results-text="Нет результатов"
          >
          <template v-slot:[`item.actions`]="{ item }">
            <v-btn v-if="item.user_id==user_id" color="blue" @click="edit_tierlist(item)"><v-icon>mdi-pen</v-icon></v-btn>
            <v-btn v-if="item.user_id==user_id" color="purple" @click="manage_items(item)"><v-icon>mdi-package-variant-closed</v-icon></v-btn>
          </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    name:"CreatingMain",
    data: () => ({
      loadTable:false,
      user_id: null,
      headers:[
        { title: 'Название', align: 'center', key: 'name'},
        { title: 'Описание', align: 'center', key: 'description'},
        { title: 'Автор', align: 'center', key: 'user.name'},
        { title: 'Действия', align: 'center', key: 'actions'},],
      tierlists:[],
    }),
    methods: {
      getdata(){
        this.loadTable = true
        axios.post('tierlist/get').then(response=>{
          this.tierlists = response.data
          this.loadTable = false
        })
      },
      manage_items(tierlist){
        axios.post('tierlist/index',{tierlist_id: tierlist.id}).then(response=>{
          this.$router.push('/creating/items/'+tierlist.id)
        })
      },
      edit_tierlist(tierlist){
        this.$router.push('/creating/'+tierlist.id)
      },
    },
    mounted() {
      this.user_id = localStorage.userId
      this.getdata()
    },
}
</script>
<style scoped>
    .centered-input >>> input {
      text-align: center
    }
</style>