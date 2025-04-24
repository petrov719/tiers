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
                :color="target_item.id == itemi.id ? 'red' : 'grey'"
                @click="target(itemi)"
              >
                <v-card-title>{{ itemi.tierlist_item.name }}
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
        tierlist:null,
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
        axios.post('tierlisting/edit',{items: this.tierlist_items,user: localStorage.userId,description:this.description, tierlist_id: String(this.tierlist.tierlist.id),old_tierlist_id:String(this.tierlist.id)}).then(response=>{
          this.$router.push('/making')
        })
      },
      transform(index){
        let index_item = this.tierlist_items[this.target_item.tier].findIndex(item => item.id == this.target_item.id)
        this.tierlist_items[this.target_item.tier].splice(index_item, 1)
        this.target_item.tier = index
        this.tierlist_items[index].push(this.target_item)
        this.target_item = {id : 0}
      },
      target(item){
        this.target_item = item
      }
    },
    mounted() {
      axios.post('tierlisting/index',{tierlist_id: this.$route.params.id}).then(response=>{
            this.tierlist = response.data
            console.log(this.tierlist)
            this.tierlist_name = response.data.tierlist.name
            this.description = response.data.description
            response.data.tierlisted_items.forEach(element => {
                this.tierlist_items[element.tier].push(element)
            });
        })
    },
}
</script>