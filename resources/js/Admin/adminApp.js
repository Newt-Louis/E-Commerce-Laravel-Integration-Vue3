import '../bootstrap.js';
import { createApp } from 'vue';
import AdminApp from '../../views/AdminApp.vue';
import {routerAdmin} from '../Routers/index.js';
import 'ant-design-vue/dist/reset.css';

const appAdmin = createApp(AdminApp)
appAdmin.use(routerAdmin)
appAdmin.mount('#appAdmin')