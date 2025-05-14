<template>
    <v-container align="center" v-if="user_id==tierlist_user_id">
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
          <FileUpload :maxSize="5" accept="png" @file-uploaded="getUploadedData"></FileUpload>
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
import FileUpload from '@/components/FileUpload.vue'
import axios from 'axios'
export default {
    components: {FileUpload},
    name:"CreatingItemsCreate",
    data: () => ({
      name:'',
      description:'',
      tierlist_user_id:null,
      user_id:null,
      file: null,
    }),
    methods: {
      getUploadedData(file) {
        this.file = file;
      },
      create_tierlist_item(){
        if (this.name != ''){
          const formData = new FormData();
          if (this.file) {
            formData.append("file", this.file.rawFile);
          }
          formData.append("name", this.name);
          formData.append("description", this.description ? this.description : '');
          formData.append("tierlist_id", this.$route.params.id);
          axios.post('tierlist_item/create', formData).then(response => {
            this.$router.push('/creating/items/' + this.$route.params.id)
          })
        } else {
          alert("НАЗВАНИЕ!")
        }
      },
      check(){
          console.log(this.name)
      },
      getdata(){
        axios.post('tierlist/index',{tierlist_id: this.$route.params.id}).then(response=>{
            this.tierlist_user_id = response.data.user_id
        })
      }
    },
    mounted() {
      this.user_id = localStorage.userId
      this.getdata()
    },
}
</script>