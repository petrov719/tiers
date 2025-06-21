import { createApp } from 'vue'
import { createStore } from 'vuex'
import axios from 'axios'

// Create a new store instance.
export const store = createStore({
  actions: {
    async get_user_id(){
        try {
          const response = await axios.get('api/user');
          if (response.data && response.data.id !== undefined) {
            return response.data.id;
          } else {
            return null;
          }
        } catch (error) {
          return null;
        }
    }
  }
})

const app = createApp({ /* your root component */ })

// Install the store instance as a plugin
app.use(store)