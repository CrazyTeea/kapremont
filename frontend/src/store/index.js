import Vue from "vue";
import Vuex from "vuex";
import Axios from "axios";
Vue.use(Vuex);

export default new Vuex.Store({
    actions: {
        requestUser(ctx) {
            Axios.post("/rest/system/get-user")
                .then(response => {
                    ctx.commit("updateUser", response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        requestCurrentOrg(ctx) {
            Axios.post("/rest/organizations/current")
                .then(response => {
                    ctx.commit("updateOrg", response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        requestOrg(ctx, { id }) {
            Axios.post("/rest/organizations/by-id", {
                id
            })
                .then(response => {
                    ctx.commit("updateOrg", response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        requestPageData(ctx, { pageName }) {
            Axios.get("/rest/system/get-page", {
                params: {
                    pageName
                    //id_org:document.getElementById('global_id_org').value
                }
            })
                .then(response => {
                    ctx.commit("updatePageData", response.data);
                })
                .catch(err => {
                    console.error(err);
                });
        },
        requestCity(ctx, { id }) {
            Axios.get("/rest/cities/by-id", {
                params: {
                    id
                }
            })
                .then(response => {
                    ctx.commit("updateCities", response.data);
                })
                .catch(err => {
                    console.error(err);
                });
        }
    },
    mutations: {
        updateUser(state, data) {
            state.user = data;
        },
        updateOrg(state, data) {
            state.organization = data;
        },
        updatePageData(state, data) {
            state.pageData = data;
        },
        updateCities(state, data) {
            state.cities = data;
        }
    },
    state: {
        pageData: {},
        user: {},
        organization: {},
        cities: []
    },
    getters: {
        getUser(state) {
            return state.user;
        },
        getOrg(state) {
            if (state.organization && state.organization.org)
                return state.organization.org;
            return null;
        },
        getRegion(state) {
            if (state.organization && state.organization.region)
                return state.organization.region;
            return null;
        },
        getRegions(state) {
            return state.pageData.regionOptions;
        },
        getPageData(state) {
            return state.pageData;
        },
        getCities(state) {
            return state.cities;
        }
    },
    modules: {}
});
