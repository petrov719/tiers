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
      <h1 class="main-title" color="blue lighten-2">Тирлистирование</h1>
      <v-row justify="end">
        <v-col cols="4">
          <v-btn
              color="green"
              to="/making/create"
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
            <v-btn color="blue" @click="edit_tierlist(item)"><v-icon>mdi-pen</v-icon></v-btn>
          </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    name:'MakingIndexPage',
    data: () => ({
      user_id: null,
      loadTable:false,
      headers:[
        { title: 'Название тирлиста', align: 'center', key: 'tierlist.name'},
        { title: 'Описание тирлиста', align: 'center', key: 'tierlist.description'},
        { title: 'Описание тирлистирования', align: 'center', key: 'description'},
        { title: 'Действия', align: 'center', key: 'actions'},],
      tierlists:[],
    }),
    methods: {
      getdata(){
        this.loadTable = true
        axios.post('api/tierlisting/get_by_user_id',{user_id: this.user_id}).then(response=>{
          this.tierlists = response.data
          this.loadTable = false
        })
      },
      edit_tierlist(tierlisting_eidt){
        this.$router.push('/making/'+tierlisting_eidt.id)
      },
    },
    mounted() {
      this.$store.dispatch('get_user_id').then(result => {
        this.user_id = result;
      });
      this.getdata()
    },
}
</script>
<style scoped>
    .centered-input >>> input {
      text-align: center
    }
</style>