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
        component: require('./components/pages/program/mainPage.vue').default
    },
    {
        path: "/program",
        component: require('./components/pages/program/mainPage.vue').default
    },
    {
        path: "/program/view",
        component:require('./components/pages/program/view/index.vue').default
    },
    {
        path: "/program/org",
        component: StatusView
    },
    {
        path: "/program/object/create",
        component: require('./components/pages/program/form/index.vue').default
    },
    {
        path: "/program/object/update/:id",
        component: require('./components/pages/program/form/index.vue').default
    },
    {
        path: "/organization/info",
        name: "orgInfo",
        component: require('./components/pages/organization/info/index.vue').default
    },
    {
        path: "/error/browser",
        name: "error",
        component: require('./components/pages/error/errorPage.vue').default
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
        component: require('./components/pages/checkMgsu/MainCheckComponent.vue').default
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
