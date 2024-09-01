import './bootstrap';
import { createApp } from 'vue';
import App from '../views/App.vue';
import {routerClient} from '../js/Routers/index.js';
import 'bootstrap/dist/css/bootstrap.min.css';

const app = createApp(App)
app.use(routerClient)
app.mount('#app')

