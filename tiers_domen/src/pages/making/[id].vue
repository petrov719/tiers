<template>
    <v-container align="center" v-if="user_id == tierlist_user_id">
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
      <h1 class="main-title" color="blue lighten-2">Тирлистирование: {{ tierlist_name }}</h1>
      <v-row>
        <v-col cols="12">
          <v-text-field label="Описание" v-model="description"></v-text-field>
        </v-col>
      </v-row>
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
                :color="target_item.id == itemi.id ? 'red' : 'grey'"
                :class="target_item.id == itemi.id ? 'border-xl' : ''"
                @click="target(itemi)"
              >
                <v-img :src="imagexd(itemi)" aspect-ratio="1" cover max-width="80"></v-img>
                <v-card-title>
                  <!-- {{ itemi.tierlist_item.name }} -->
                </v-card-title>
              </v-card>
            </v-col>
          </v-xd>
        </v-row>
      </v-container>
      <v-row>
        <v-col>
          <v-btn class="button" min-width="200" color="green" @click="save()">Сохранить</v-btn>
        </v-col>
      </v-row>
    </v-container>
</template>
  
<script>
import axios from 'axios'
export default {
    name:'EditMakingPage',
    data: () => ({
        description:null,
        tierlist_name:null,
        user_id:null,
        tierlist:null,
        tierlist_user_id:null,
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
      save(){
        axios.post('api/tierlisting/edit',{items: this.tierlist_items,user: this.user_id,description:this.description, tierlist_id: String(this.tierlist.tierlist.id),old_tierlist_id:String(this.tierlist.id)}).then(response=>{
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
      imagexd(item){
        if(item.tierlist_item.image_name){
          return `data:image/png;base64,${item.tierlist_item.image_base64}`;
        } else {
          return require('@/assets/black.png')
        }
      },
    },
    mounted() {
      this.$store.dispatch('get_user_id').then(result => {
        this.user_id = result;
      });
      axios.post('api/tierlisting/index',{tierlist_id: this.$route.params.id}).then(response=>{
        console.log(response.data)
        this.tierlist = response.data
        this.tierlist_user_id = response.data.user_id
        this.tierlist_name = response.data.tierlist.name
        this.description = response.data.description
        response.data.tierlisted_items.forEach(element => {
            this.tierlist_items[element.tier].push(element)
        });
        })
    },
}
</script>