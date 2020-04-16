import Vue from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import platform from "platform";
import { IconsPlugin, ModalPlugin } from "bootstrap-vue";
import Axios from "axios";
//import BootstrapVue from 'bootstrap-vue';

// Optionally install the BootstrapVue icon components plugin
Vue.use(ModalPlugin);
Vue.use(IconsPlugin);

//import "./styles";

Vue.directive("can", {
    bind(el, binding,node) {
        const roles = binding.arg.split(",");
        setTimeout(()=>{
            if (!roles.includes(window.Permission)) {
                // console.log(node.child);
                el.style.display = 'none';
                el.childNodes.innerHTML = '';
                node.elm.parentElement.removeChild(node.elm);
                if (node.child) {
                    let e = document.getElementById(node.child.controlledBy);
                    if (e)
                        e.parentElement.removeChild(e);
                }

            }
        }, 1);

        // console.log(window.Permission)
        // if (!roles.includes(window.Permission)) {
        //     console.log(window.Permission)
        //     setTimeout(()=>{el.style.display = "none";}, 0.0001)
        // }
    }
});

const browser = [
    { name: "Chrome", version: 79 },
    { name: "Opera", version: 66 },
    { name: "Microsoft Edge", version: 0 },
    { name: "Safari", version: 11 },
    { name: "Firefox", version: 75 }
];

//Vue.config.productionTip = false;

async function getUser(){
    let user = null;
    let a = Axios.post("/rest/system/get-user")
        .then(response => {
            user = response.data;
        })
        .catch(error => {
            console.error(error);
        });
    let u = await a;
    let access = null;
    let b = Axios.get(`/program/is-approve/${user.organization.id}`).then(response => {
        access = response.data.status907 === "0";
        // console.log(this.user_status);
    });
    let i =  await b;
    return access;
}

router.beforeEach((to, from, next) => {
    if (to.path !== "/error/browser") {
        let access = false;
        console.log(platform);
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
    if (to.path !== '/error/status907'){
        let access = false;
        let user = null;

        getUser().then(value => access=value);

        if (!access){
            next({name:'error907'});
        }
    }
    next();
});

new Vue({
    render: h => h(App),
    store,
    router
}).$mount("#app");
