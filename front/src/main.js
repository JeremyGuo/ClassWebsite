import Vue from 'vue'

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

import VueRouter from 'vue-router';

import App from './App.vue';
import TimelinePage from './components/Timeline/Timeline.vue';
import SharePage from './components/Share/Share.vue';
import HomePage from './components/Home/Home.vue';
import LoginPage from './components/LoginPage.vue';
import RegisterPage from './components/RegisterPage.vue';

import requests from './stay/requests.js' //引入axios
import { Message } from 'element-ui';

Vue.prototype.$requests = requests;
Vue.prototype.$message = Message;

Vue.config.productionTip = true;
Vue.use(ElementUI);
Vue.use(VueRouter);

const routes = [
    { path: '/timeline', component: TimelinePage },
    { path: '/home', component: HomePage },
    { path: '/share', component: SharePage },
    { path: '/login', component: LoginPage },
    { path: '/logout', component: HomePage },
    { path: '/register', component: RegisterPage},
]

const router = new VueRouter({
    routes,
    mode:'hash'
})

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')
