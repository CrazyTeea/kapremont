import Vue from "vue";
import VueRouter from "vue-router";
import Atz from "./components/pages/program/atz/index.vue";
import ListObject from "./components/pages/organization/info/ListObjectComponent.vue";
import ObjView from "./components/pages/organization/info/ObjectShowComponent.vue";
import ObjectsForKrestiane from "./components/pages/program/ObjectView/ViewComponent.vue";
import FaivAdminComponent from "./components/pages/FaivAdmin/FaivAdminComponent.vue"
import StatusView from "./components/pages/program/view/status.vue"

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: () =>
            import("./components/pages").then(module => {
                return module.mainPage;
            })
    },
    {
        path: "/program",
        component: () =>
            import("./components/pages").then(module => {
                return module.mainPage;
            })
    },
    {
        path: "/program/view",
        component: () =>
            import("./components/pages").then(module => {
                return module.devView;
            })
    },
    {
        path: "/program/org",
        component: StatusView
    },
    {
        path: "/program/object/create",
        component: () =>
            import("./components/pages").then(module => {
                return module.form;
            })
    },
    {
        path: "/program/object/update/:id",
        component: () =>
            import("./components/pages").then(module => {
                return module.form;
            })
    },
    {
        path: "/organization/info",
        name: "orgInfo",
        component: () =>
            import("./components/pages").then(module => {
                return module.orgInfo;
            })
    },
    {
        path: "/error/browser",
        name: "error",
        component: () =>
            import("./components/pages").then(module => {
                return module.errorPage;
            })
    },
    {
        path: "/error/status907",
        name: "error907",
        component: () =>
            import("./components/pages").then(module => {
                return module.status907;
            })
    },
    {
        path: "/program/atz",
        name: "atz",
        component: Atz
    },
    {
        path: "/organization/list",
        name: "MainCheck",
        component: () =>
            import("./components/pages").then(module => {
                return module.checkMgsu;
            })
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
        component: ()=>import('./components/pages').then(module=>module.userInfo),
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
