import { createApp } from 'vue'
import { createStore } from 'vuex'
import axios from 'axios'

// Create a new store instance.
export const store = createStore({
  actions: {
    async get_user_id(){
        const response = await axios.get('api/user');
        return response.data.id
    }
  }
})

const app = createApp({ /* your root component */ })

// Install the store instance as a plugin
app.use(store)