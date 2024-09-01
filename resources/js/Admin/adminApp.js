import '../bootstrap.js';
import { createApp } from 'vue';
import AdminApp from '../../views/AdminApp.vue';
import {routerAdmin} from '../Routers/index.js';
import 'bootstrap/dist/css/bootstrap.min.css';

const appAdmin = createApp(AdminApp)
appAdmin.use(routerAdmin)
appAdmin.mount('#appAdmin')