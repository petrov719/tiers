import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
import {store} from './stores'
import axios from 'axios'
axios.defaults.baseURL = 'https://tiers';
// axios.defaults.baseURL = 'http://tiersxd.pseregde.beget.tech';
if (localStorage.currentToken) {
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.currentToken;
}
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
loadFonts()
// App.use(Vuetify);
createApp(App)
  .use(router)
  .use(Vuetify)
  .use(store)
  .mount('#app')