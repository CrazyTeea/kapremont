import Vue from 'vue';
import Vuex from 'vuex';
import Axios from "axios";
//import _ from 'lodash';
Vue.use(Vuex);

export default new Vuex.Store({
    actions:{
        requestUser(ctx){
            Axios.post('/rest/system/get-user',
                {login:document.getElementById('global_username').value}).then(response=>{
                    ctx.commit('updateUser',response.data);
            }).catch(error=>{console.error(error);});
        },
        requestCurrentOrg(ctx){
            Axios.post('/rest/organizations/by-username',
                {login:document.getElementById('global_username').value}).then(response=>{
                ctx.commit('updateOrg',response.data);
            }).catch(error=>{console.error(error);});
        },
        requestOrg(ctx){
            Axios.post('/rest/organizations/by-id',
                {id:document.getElementById('global_id_org').value}).then(response=>{
                ctx.commit('updateOrg',response.data);
            }).catch(error=>{console.error(error);});
        },
        requestPageData(ctx,{pageName}){
            Axios.get('/rest/system/get-page',{
                params:{
                    pageName,
                    id_org:document.getElementById('global_id_org').value
                }
            }).then(response=>{
                ctx.commit('updatePageData',response.data);
            }).catch(err=>{console.error(err);});
        }
    },
    mutations:{
        updateUser(state,data){
            state.user = data;
        },
        updateOrg(state,data){
            state.organization = data;
        },
        updatePageData(state,data){
            state.pageData = data;

        }
    },
    state:{
        pageData:{},
        user:{},
        organization:{},
    },
    getters:{
        getUser(state){
            return state.user;
        },
        getOrg(state){
            if (state.organization && state.organization.org)
                return state.organization.org;
            return null;
        },
        getRegion(state){
            if (state.organization && state.organization.region)
                return state.organization.region;
            return null;
        },
        getPageData(state){
            return state.pageData;
        }
    },
    modules:{

    }
});