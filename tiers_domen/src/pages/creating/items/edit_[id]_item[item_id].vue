<template>
    <v-container align="center" v-if="user_id==tierlist_user_id">
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
          <FileUpload v-if="render" :maxSize="5" :fileName="fileName" accept="png" :externalFile="file" @file-uploaded="getUploadedData"></FileUpload>
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
import FileUpload from '@/components/FileUpload.vue'
import axios from 'axios'
export default {
    components: {FileUpload},
    name:"EditItems",
    file:null,
    data: () => ({
      render:false,
      name:'',
      fileName:null,
      description:'',
      item:null,
      item_id:'',
      user_id:null,
      tierlist_user_id:null,
    }),
    methods: {
        edit_tierlist_item(){
          if ((this.name != '') && this.item_id != ''){
            if(this.item.tierlist_id == this.$route.params.id){
              const formData = new FormData();
              if (this.file) {
                formData.append("file", this.file.rawFile);
                formData.append("filename", this.file.name);
              }
              formData.append("name", this.name);
              formData.append("description", this.description);
              formData.append("item_id", this.item_id);
              axios.post('api/tierlist_item/edit', formData).then(response => {
                this.$router.push("/creating/items/"+this.$route.params.id)
              })
            } else {
              alert("КЫШ")
            }
          } else {
            alert("НАЗВАНИЕ!")
          }
        },
        getUploadedData(file) {
          this.file = file;
        },
        check(){
            console.log(this.name)
        },
    },
    mounted() {
      this.$store.dispatch('get_user_id').then(result => {
        this.user_id = result;
      });
      axios.post('api/tierlist/index',{tierlist_id: this.$route.params.id}).then(response=>{
          this.tierlist_user_id = response.data.user_id
      })
      axios.post('api/tierlist_item/index',{item_id: this.$route.params.item_id}).then(response=>{
        if (response.data.success == true){
          this.item = response.data.tierlist_item
          this.item_id = response.data.tierlist_item.id
          this.name = response.data.tierlist_item.name
          this.description = response.data.tierlist_item.description ? response.data.tierlist_item.description : ''
          this.file = response.data.file_base64;
          this.fileName = response.data.tierlist_item.image_name;
        } else if (response.data.success == "without_file") {
          this.item = response.data.tierlist_item
          this.item_id = response.data.tierlist_item.id
          this.name = response.data.tierlist_item.name
          this.description = response.data.tierlist_item.description
        } else {
          alert(response.data.data)
        }
        this.render = true
      })
    },
}
</script>