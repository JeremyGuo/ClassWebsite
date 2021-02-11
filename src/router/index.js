import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Activities from '@/components/Activities'
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
      meta: {
        title: '19图灵班10班-2021春节整活'
      }
    },
    {
      path: '/Activities',
      name: 'Activities',
      component: Activities
    }
  ]
})
