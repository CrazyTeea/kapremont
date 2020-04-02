import Vue from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import platform from "platform";
import Axios from "axios";
import { IconsPlugin } from 'bootstrap-vue';
import BootstrapVue from 'bootstrap-vue';

// Optionally install the BootstrapVue icon components plugin
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

import "./styles";

Vue.directive("can", {
    bind(el, binding) {
        const roles = binding.arg.split(",");
        if (!roles.includes(window.Permission)) {
            setTimeout(()=>{el.style.display = "none";}, 0.0001)
        }
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
