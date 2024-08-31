import './bootstrap';
import { createApp } from 'vue';
import App from '../views/App.vue';
import router from '../js/Routers/index.js';

const clientApp = createApp(App)
clientApp.use(router)
clientApp.mount('#app')