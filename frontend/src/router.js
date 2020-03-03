import Vue from 'vue';
import VueRouter from 'vue-router';
//import {Year,Month, orgList} from './components/pages'

Vue.use(VueRouter);

const routes = [
    {
        path:'/',
        number:0,
        component: ()=>import('./components/pages').then(module=>{return module.mainPage;})
    },
    {
        path:'/program',
        number:1,
        component: ()=>import('./components/pages').then(module=>{return module.mainPage;})
    },
    {
        path:'/program/view',
        number:2,
        component: ()=>import('./components/pages').then(module=>{return module.devView;})
    },
    {
        path:'/program/object/create',
        number:3,
        component: ()=>import('./components/pages').then(module=>{return module.form;})
    },
    {
        path:'/program/object/update/:id',
        number:4,
        component: ()=>import('./components/pages').then(module=>{return module.form;})
    },
    {
        path:'/organization/info',
        name:'orgInfo',
        number:5,
        component: ()=>import('./components/pages').then(module=>{return module.orgInfo;})
    },
    {
        path:'/error/browser',
        name: 'error',
        number:6,
        component: ()=>import('./components/pages').then(module=>{return module.errorPage;})
    }

];

export default new VueRouter({
   mode:'history',
   routes
});