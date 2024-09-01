import './bootstrap';
import { createApp } from 'vue';
import App from '../views/App.vue';

import {routerClient, routerAdmin} from '../js/Routers/index.js';
import 'ant-design-vue/dist/reset.css';


const app = createApp(App)
app.use(routerClient)
app.mount('#app')

