import Vue from 'vue';
import VueRouter from 'vue-router';
//import {Year,Month, orgList} from './components/pages'

Vue.use(VueRouter);

const routes = [
    {
        path:'/program',
        component: ()=>import('./components/pages').then(module=>{return module.mainPage;})
    },
    {
        path:'/',
        component: ()=>import('./components/pages').then(module=>{return module.mainPage;})
    },
];

export default new VueRouter({
   mode:'history',
   routes
});