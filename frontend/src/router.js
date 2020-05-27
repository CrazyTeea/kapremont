import Vue from "vue";
import VueRouter from "vue-router";
import Atz from "./components/pages/program/atz/index.vue";
import ListObject from "./components/pages/organization/info/ListObjectComponent.vue";
import ObjView from "./components/pages/organization/info/ObjectShowComponent.vue";
import FaivAdminComponent from "./components/pages/FaivAdmin/FaivAdminComponent.vue";
import StatusView from "./components/pages/program/view/status.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: require('./components/pages/program/mainPage.vue').default /*() =>
            import("./components/pages").then(module => {
                return module.mainPage;
            })*/
    },
    {
        path: "/program",
        component: require('./components/pages/program/mainPage.vue').default /*() =>
            import("./components/pages").then(module => {
                return module.mainPage;
            })*/
    },
    {
        path: "/program/view",
        component:require('./components/pages/program/view/index.vue').default /*() =>
            import("./components/pages").then(module => {
                return module.devView;
            })*/
    },
    {
        path: "/program/org",
        component: StatusView
    },
    {
        path: "/program/object/create",
        component: require('./components/pages/program/form/index.vue').default/*() =>
            import("./components/pages").then(module => {
                return module.form;
            })*/
    },
    {
        path: "/program/object/update/:id",
        component: require('./components/pages/program/form/index.vue').default /*() =>
            import("./components/pages").then(module => {
                return module.form;
            })*/
    },
    {
        path: "/organization/info",
        name: "orgInfo",
        component: require('./components/pages/organization/info/index.vue').default /*() =>
            import("./components/pages").then(module => {
                return module.orgInfo;
            })*/
    },
    {
        path: "/error/browser",
        name: "error",
        component: require('./components/pages/error/errorPage.vue').default /*() =>
            import("./components/pages").then(module => {
                return module.errorPage;
            })*/
    },
    {
        path: "/error/status907",
        name: "error907",
        component: require('./components/pages/error/status907.vue').default
    },
    {
        path: "/program/atz",
        name: "atz",
        component: Atz
    },
    {
        path: "/organization/list",
        name: "MainCheck",
        component: require('./components/pages/checkMgsu/MainCheckComponent.vue').default/*() =>
            import("./components/pages").then(module => {
                return module.checkMgsu;
            })*/
    },
    {
        path: "/organization/list/:id",
        name: "ObjList",
        component: ListObject
    },
    {
        path: "/organization/obj/:id",
        name: "ObjView",
        component: ObjView
    },
    {
        path: "/program/object/view/:id",
        name: "ObjView",
        component: ObjView
    },
    {
        path: "/organization/user-info/:id_org",
        name: "user-info",
        component:require('./components/pages/organization/userInfo/index.vue').default ,
        /*()=>import('./components/pages').then(module=>module.userInfo)*/
    },
    {
        path: "/admin/faiv",
        name: FaivAdminComponent,
        component: FaivAdminComponent
    }
];

export default new VueRouter({
    mode: "history",
    routes
});
