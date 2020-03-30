import Vue from "vue";
import VueRouter from "vue-router";
import Atz from "./components/pages/program/atz/index.vue";
import ListObject from "./components/pages/organization/info/ListObjectComponent.vue";
import ObjView from "./components/pages/organization/info/ObjectShowComponent.vue";
import ObjectsForKrestiane from "./components/pages/program/ObjectView/ViewComponent.vue"
import UserListComponent from "./components/pages/faif/UserListComponent.vue"
import UserFormComponent from "./components/pages/faif/UserFormComponent.vue"

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
        name: "ObjectsForKrestiane",
        component: ObjectsForKrestiane
    },
    {
        path: "/faif/user",
        name: "FaifUser",
        component: UserListComponent
    },
    {
        path: "/faif/user/create",
        name: "FaifUserCreate",
        component: UserFormComponent
    }
];

export default new VueRouter({
    mode: "history",
    routes
});
