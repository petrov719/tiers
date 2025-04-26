import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
import axios from 'axios'
axios.defaults.baseURL = 'https:/tiers/api';
// axios.defaults.baseURL = 'http://tiersxd.pseregde.beget.tech/api';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
loadFonts()
// App.use(Vuetify);
createApp(App)
  .use(router)
  .use(Vuetify)
  .mount('#app')