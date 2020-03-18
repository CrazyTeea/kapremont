import Vue from "vue";
import VueRouter from "vue-router";
import Atz from "./components/pages/program/atz/index.vue";

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
        component: ()=>import("./components/pages").then(module => {
            return module.checkMgsu;
        })
    }
];

export default new VueRouter({
    mode: "history",
    routes
});
