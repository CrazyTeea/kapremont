<template>
    <div id="org_info">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <b-table small bordered class="text-center" :fields="getPageData.fields" :items="getPageData.items"/>
                    <b-button v-show="canChange" variant="info" @click="link" > Редактировать </b-button>
                </div>
                <div class="col-3 offset-3">
                    <user-panel/>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {userPanel} from "../../../organisms";
export default {

    name: "OrgInfo",
    data(){
        return {
            canChange: window.canChange
        }  
    },
    components: {
        userPanel
    },
    computed: {
        ...mapGetters(['getPageData','getUser']),
    },
    methods: {
        link() {
            return window.location.href = `/organization/update/${this.getUser.organization.id}`
        },
        ...mapActions(['requestPageData'])
    },
    mounted() {
        this.requestPageData({pageName:"orgInfo"});
    }
}
</script>

<style scoped>

</style>