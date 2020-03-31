import Vue from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import platform from "platform";
import Axios from "axios";

Vue.directive("can", {
    bind(element, binding) {
        let style = element.style.display;
        element.style.display = "none";
        Axios.get("/api/permissions").then(res => {
            if (res.data === binding.arg) {
                element.style.display = style;
            }
        });
    }
});

const browser = [
    { name: "Chrome", version: 79 },
    { name: "Opera", version: 66 },
    { name: "Microsoft Edge", version: 0 },
    { name: "Safari", version: 12 }
];

//Vue.config.productionTip = false;
router.beforeEach((to, from, next) => {
    if (to.path !== "/error/browser") {
        let access = false;
        browser.forEach(item => {
            if (item.name === platform.name) {
                if (platform.hasOwnProperty("version")) {
                    let version = platform.version.split(".")[0];
                    access = version >= item.version;
                }
            }
        });
        if (!access) {
            next({ name: "error" });
        }
    }
    next();
});

new Vue({
    render: h => h(App),
    store,
    router
}).$mount("#app");
