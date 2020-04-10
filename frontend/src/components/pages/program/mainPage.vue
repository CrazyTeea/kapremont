<template>

        <div id="program_mi_body">
            <div class="row">
                <div class="col-6">
                    <h4 v-show="getOrg">{{getOrg && getOrg.name}}</h4>
                    <p v-show="getRegion">Субъект РФ:
                        <span class="text-success">{{getRegion && getRegion.region }}</span>
                    </p>
                    <b-table id="program_table"
                             v-if="getPageData"
                             :fields="fields"
                             :items="items"
                             :per-page="perPage"
                             :current-page="currentPage"
                             small bordered
                    />
                    <h3 v-else>
                        <span class="text-danger">Данные о вашей организации отсутствуют в системе</span>
                    </h3>
                    <b-pagination
                            v-show="rows > perPage"
                            v-model="currentPage"
                            :total-rows="rows"
                            :per-page="perPage"
                            aria-controls="my-table"
                    ></b-pagination>
                    <div style="float: right"  v-show="getUser.isAdmin && getPageData">
                        <b-button href="program/view">Заполнить программу модернизации</b-button>
                    </div>
                </div>
                <div class="col-2"></div>

                <div class="col-4">
                    <v-userPanel />
                    <br>
                    <user-info-view />

                </div>
            </div>
        </div>
</template>

<script>
import {userPanel,UserInfoView} from '../../organisms'
import {mapActions, mapGetters} from "vuex";
import {
    BButton,
    BTable,
    BPagination,
    VBToggle,
} from "bootstrap-vue";
// import b_vue from 'bootstrap-vue';
export default {
    directives:{
        'b-toggle':VBToggle
    },
    components:{
        "v-userPanel":userPanel,
        BButton,
        BPagination,
        BTable,
        UserInfoView,
    },
    data(){
        return {
            perPage: 5,
            currentPage:1,
            id_org:null
        }
    },
    computed:{
        ...mapGetters(['getUser','getOrg','getRegion','getPageData']),
        rows() {
            if(this.getPageData && this.getPageData.items)
                return this.getPageData.items.length;
            return 0;
        },
        items(){
            if(this.getPageData && this.getPageData.items)
                return this.getPageData.items;
            return [];
        },
        fields(){
            if(this.getPageData && this.getPageData.fields)
                return this.getPageData.fields;
            return [];
        }

    },
    watch:{
        getUser:function () {
            this.requestOrg({id:this.getUser.organization.id});
            this.id_org = this.getUser.organization.id;
        }
    },
    methods:{
        ...mapActions(['requestProgram','requestOrg','requestPageData','requestUser'])
    },
    async mounted() {
        await this.requestUser();
        await this.requestPageData({pageName:"main"});

        //this.id_org = this.getUser.organization.id;

        //this.requestProgram();


    }
}
</script>

<style scoped>

</style>