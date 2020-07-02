<template>

        <div id="program_mi_body">
            <b-modal scrollable id="extraBaner" v-model="extraBaner" cancel-disabled>
                <div class="text-center">Уважаемые коллеги!</div>
                <p>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Департамент экономической политики Минобрнауки России рассмотрел представленные
                    подведомственными образовательными организациями высшего образования программы
                    модернизации инфраструктуры в части осуществления мероприятий по капитальному
                    ремонту объектов недвижимого имущества (далее – организации)
                    и сообщает, что организации могут начинать осуществление закупочных процедур по приоритетным
                    и резервным объектам со статусом «Рассмотрено ДЭП».
                </p>
                <p>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;По вопросам работы в информационно-аналитической системе
                    «Мониторинг» организации могут связаться со службой технической поддержки
                    по телефону: 8-495-989-84-47 доб. 1 (многоканальный) или
                    по адресу электронной почты: ias@mirea.ru.
                </p>
                <p>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;В части проведения мероприятий по антитеррористической защищенности объектов необходимо обращаться в Департамент корпоративного управления Минобрнауки России: Бочарова Елена Владимировна, консультант отдела оформления имущественных прав
                    и ведения реестра федерального имущества, 8-926-623-99-10, bocharovaev@minobrnauki.gov.ru

                </p>
                <template v-slot:modal-footer>
                    <b-button variant="success" @click="extraBaner = false">ОК!</b-button>
                </template>

            </b-modal>

            <b-modal scrollable id="extraBaner2" v-model="extraBaner2" cancel-disabled>
                <p>Уважаемые коллеги!</p>
                <p>Программа модернизации инфраструктуры рассмотрена Департаментом корпоративного управления.</p>
                <p>С суммой к выделению для финансирования мероприятий по АТЗ Вы можете ознакомиться на стартовой странице модуля. </p>
                <p>Она расположена над кнопками "Заполнить программу модернизации" и "Приступить к реализации программы модернизации"</p>

                <template v-slot:modal-footer>
                    <b-button variant="success" @click="extraBaner2 = false">ОК!</b-button>
                </template>

            </b-modal>


            <div class="row">
                <div class="col-6">
                    <h4 v-show="getOrg">{{getOrg && getOrg.name}}</h4>
                    <p v-show="getRegion">Субъект РФ:
                        <span class="text-success">{{getRegion && getRegion.region }}</span>
                    </p>
                    <div v-if="getPageData">
                        <b-table id="program_table"

                                 :fields="fields"
                                 :items="items"
                                 :per-page="perPage"
                                 :current-page="currentPage"
                                 small bordered
                        >
                            <template v-slot:cell(value) = 'data' >
                                <div v-if="!data.index">
                                    <b-form-input @change="setProgramValue('finance_volume',data.item.value)"
                                                  style="min-width: 120px"
                                                  v-model="data.item.value"
                                                  type="number"
                                                  v-can:faiv_user></b-form-input>
                                    <span v-can:user>{{data.item.value}}</span>
                                </div>
                                <span v-else>{{data.item.value}}</span>
                            </template>
                        </b-table>
                        <h5 style="margin-top: 5px">Текущий статус ДКУ: <label :class="`text-${dku_status.color}`">{{ dku_status.label }}</label></h5>
                        <h5 style="margin-top: 5px">Сумма к выделению для финансирования мероприятий по АТЗ (Рублей) <label :class="`text-${dku_status.color}`">{{ dku_status.atz }}</label></h5>

                    </div>

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
                        <b-button href="/program/view">Заполнить программу модернизации</b-button>
                        <b-button class="btn-info mt-2" href="/program/org">Приступить к реализации программы модернизации</b-button>
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
    BFormInput
} from "bootstrap-vue";
import Axios from "axios";
// import b_vue from 'bootstrap-vue';
export default {
    directives:{
        'b-toggle':VBToggle
    },
    components:{
        "v-userPanel":userPanel,
        BFormInput,
        BButton,
        BPagination,
        BTable,
        UserInfoView,
    },
    data(){
        return {
            csrf: document.getElementsByName("csrf-token")[0].content,
            extraBaner:window.Permission === 'user',
            extraBaner2:false,
            perPage: 5,
            currentPage:1,
            id_org:null,
            dku_status:{
                color:'secondary',
                label:'',
                atz:0
            }
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

            let dku = this.getUser.organization.dku_status;
            if(dku == 'not') {
                this.dku_status.label = 'В обработке';

                this.dku_status.color = 'secondary'
            } else if(dku == 'approved') {
                this.dku_status.label = 'Рассмотрено ДКУ';
                this.extraBaner2 = true;
                this.dku_status.color = 'success'
            } else if(dku == 'rejected') {
                this.dku_status.label = 'Резерв';
                this.dku_status.color = 'warning'
            }
            this.dku_status.atz = this.getUser.program.dku_atz;

        }
    },
    methods:{
        ...mapActions(['requestProgram','requestOrg','requestPageData','requestUser']),
        setProgramValue(atr,value){
            if (this.id_org) {
                let data = new FormData();
                data.append('value', atr);
                data.append(atr, value);
                Axios.post(`/program/set-value/${this.id_org}`, data, {
                        headers: {
                            "X-CSRF-Token": this.csrf
                        }
                    }
                ).then(response => {
                    if (!response.data.success)
                        response.data.errors.forEach(item => {
                            this.setBanner('danger', item)
                        })
                })
            }
        }
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