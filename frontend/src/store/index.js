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
        requestProgram(ctx){
            Axios.post('/rest/program/get-by-id-org',
                {id_org:document.getElementById('global_id_org').value}).then(response=>{
                ctx.commit('updateProgram',response.data);
            }).catch(error=>{console.error(error);});
        }
    },
    mutations:{
        updateUser(state,data){
            state.user = data;
        },
        updateOrg(state,data){
            state.organization = data;
        },
        updateProgram(state,data){
            state.program = data;
            state.program.program.value = ((state.program.program.finance_volume*1000 - state.program.program.finance_events*1000)/state.program.program.cost).toFixed(1);
        },
    },
    state:{
        user:{},
        organization:{},
        program:{}
    },
    getters:{
        getUser(state){
            return state.user;
        },
        getOrg(state){
            return state.organization.org;
        },
        getRegion(state){
            return state.organization.region;
        },
        getProgram(state){
            return state.program.program;
        },
    },
    modules:{

    }
});