import './bootstrap';

import {createApp} from 'vue'

import Router from './page'

import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'


import App from './app/App.vue'
const app = createApp(App)
app.use(ElementPlus)
app.use(Router)
app.mount('#app')
