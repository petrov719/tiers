<template>
    <v-container align="center">
      <v-row>
        <v-col cols="1">
          <v-btn
              color="grey"
              to="/making"
          >
              <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <h1 class="main-title" color="blue lighten-2">Создать тирлистирование</h1>
      <v-row>
        <v-col cols="12">
          <v-select :items="tierlists" :input="getitems(tierlist_id)" item-title="name" item-value="id" label="Выбери тирлист" v-model="tierlist_id"></v-select>
        </v-col>
      </v-row>
      <v-row v-if="tierlist_id!=null">
        <v-col cols="12">
          <v-text-field label="Описание" v-model="description"></v-text-field>
        </v-col>
      </v-row>
      <v-xd v-if="tierlist_id!=null" >
        <v-container :key="i" v-for="(item, i) in params">
          <v-row justify="start"  row-height="40">
            <v-col cols="2">
              <v-card
                height="50"
                :color="item.color"
                @click="transform(i)"
              >
                <v-card-title>{{ item.title }}
                </v-card-title>
              </v-card>
            </v-col>
            <v-xd v-for="itemi in tierlist_items[i]" :key="itemi.id" :item="itemi">
              <v-col>
                <v-card
                  height="50"
                  width="70"
                  :class="target_item.id == itemi.id ? 'border-xl' : ''"
                  :color="target_item.id == itemi.id ? 'red' : 'grey'"
                  @click="target(itemi)"
                >
                <v-img :src="imagexd(itemi)" aspect-ratio="1" cover max-width="80"></v-img>
                <v-card-title>
                  <!-- {{ itemi.name }} -->
                </v-card-title>
                </v-card>
              </v-col>
            </v-xd>
          </v-row>
        </v-container>
      </v-xd>
      <v-row v-if="tierlist_id!=null">
        <v-col>
          <v-btn class="button" min-width="200" color="green" @click="save()">Сохранить</v-btn>
        </v-col>
      </v-row>
    </v-container>
</template>
  
<script>
import axios from 'axios'
export default {
    name:"CreateMakingPage",
    data: () => ({
        description:null,
        tierlist_id:null,
        tierlists:[],
        target_item:{id : 0},
        tierlist_items:[[],[],[],[],[],[]],
        params:[{
          color: 'red',
          title: 'S',
        },{
          color: 'orange',
          title: 'A',
        },{
          color: 'yellow',
          title: 'B',
        },{
          color: 'lime',
          title: 'C',
        },{
          color: 'green',
          title: 'D',
        },{
          color: 'black',
          title: '???',
        },]
    }),
    methods: {
      getitems(){
        axios.post('tierlist_item/get', {tierlist_id: this.tierlist_id}).then(response=>{
          console.log(response.data)
          this.tierlist_items = [[],[],[],[],[],[]]
          this.target_item = {id : 0}
          for(let i = 0;i<response.data.length;i++){
            response.data[i].tier = 5
          }
          this.tierlist_items[5] = response.data
        })
      },
      check(){
        console.log(this.tierlist_id)
      },
      save(){
        axios.post('tierlisting/create',{items: this.tierlist_items,user: localStorage.userId,description:this.description, tierlist_id: String(this.tierlist_id)}).then(response=>{
          this.$router.push('/making')
        })
      },
      transform(index){
        if(this.tierlist_items[this.target_item.tier] != undefined){
          let index_item = this.tierlist_items[this.target_item.tier].findIndex(item => item.id == this.target_item.id)
          this.tierlist_items[this.target_item.tier].splice(index_item, 1)
          this.target_item.tier = index
          this.tierlist_items[index].push(this.target_item)
          this.target_item = {id : 0}
        }
      },
      target(item){
        this.target_item = item
      },
      base64ToFile(base64String, fileName, mimeType) {
      const byteString = atob(base64String.split(",")[0]); // Декодируем Base64
      const arrayBuffer = new ArrayBuffer(byteString.length);
      const uint8Array = new Uint8Array(arrayBuffer);
      for (let i = 0; i < byteString.length; i++) {
        uint8Array[i] = byteString.charCodeAt(i);
      }
      const blob = new Blob([uint8Array], { type: mimeType });
      return new File([blob], fileName, { type: mimeType });
    },
      imagexd(item){
        if(item.image_name){
          return `data:image/png;base64,${item.image_base64}`;
        } else {
          return require('@/assets/black.png')
        }
      },
    },
    computed: {
      
    },
    mounted() {
      axios.post('tierlist/get').then(response=>{
            this.tierlists = response.data
        })
    },
}
</script>