<template>
    <div class="main_wrapper">
        <div class="row">
            <div class="col-6">
                <h6>{{ orgInfo.name }}</h6>
                <p>
                    <strong>Субъект РФ:</strong>
                    {{ orgInfo.region }}
                </p>
                <b-table-simple bordered>
                    <b-thead>
                        <b-th>№</b-th>
                        <b-th colspan="2">Показатель</b-th>
                        <b-th>Значение</b-th>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <b-td>1</b-td>
                            <b-td colspan="2"
                                >Объем финансового обеспечения на реализацию мероприятий по модернизации инфраструктуры, включая капитальный ремонт объектов и проведение мероприятий по
                                антитеррористической защищенности объектов</b-td
                            >
                            <b-td>Данные</b-td>
                        </b-tr>
                        <b-tr>
                            <b-td rowspan="3">2</b-td>
                            <b-td rowspan="4"
                                >Утвержденная программа модернизации инфраструктуры, включая капитальный ремонт объектов и проведение мероприятий по антитеррористической защищенности объектов (Раздел 2. Антитеррористическая защищенность объектов)</b-td
                            >
                            <b-td>Сумма бюджетного финансирования (руб.)</b-td>
                            <b-td>{{ table2Info.cost_b_full }}</b-td>
                        </b-tr>
                        <b-tr>
                            <b-td>Сумма внебюджетного финансирования (руб.)</b-td>
                            <b-td>{{ table2Info.cost_v_full }}</b-td>
                        </b-tr>
                        <b-tr>
                            <b-td>Общий объем финансирования (руб.)</b-td>
                            <b-td>{{ table2Info.cost_b_full + table2Info.cost_v_full }}</b-td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
                <h4 class="mt-2">Статус:</h4>
            </div>
            <div class="col-5 offset-1">
                <v-userPanel v-can:!dku />
                <br />
                <user-info-view :id_org="id_org" />
            </div>
        </div>
        <div class="row">
            <comments class="col-12" />
        </div>
        <div class="row mt-5">
            <b-card no-body class="mb-1 col-12">
                <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLE2>
                    <span class="toggle_button">Раздел 2. Антитеррористическая защищенность объектов</span>
                </b-card-header>
                <b-collapse id="TABLE2" accordion="TABLE2" role="tabpanel">
                    <b-card-body>
                        <atz-table @getTable2AtzInfo="setTable2Atz" />
                    </b-card-body>
                </b-collapse>
            </b-card>
        </div>

        <div class="row mt-5">
            <b-card no-body class="mb-1 col-12">
                <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLE3>
                    <span class="toggle_button">Таблица 3</span>
                </b-card-header>
                <b-collapse id="TABLE3" accordion="TABLE3" role="tabpanel">
                    <b-card-body>
                        <table3 :passport="passport" :id_org="id_org" />
                    </b-card-body>
                </b-collapse>
            </b-card>
        </div>
        <div class="row mt-5">
            <b-card no-body class="mb-1 col-12">
                <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLE4>
                    <span class="toggle_button">Таблица 4</span>
                </b-card-header>
                <b-collapse id="TABLE4" accordion="TABLE4" role="tabpanel" visible>
                    <b-card-body>
                        <table4 :passport="passport" :id_org="id_org" />
                    </b-card-body>
                </b-collapse>
            </b-card>
        </div>
         <div class="row mt-5">
            <b-card no-body class="mb-1 col-12">
                <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.TABLEDoc>
                    <span class="toggle_button">Документы</span>
                </b-card-header>
                <b-collapse id="TABLEDoc" accordion="TABLEDoc" role="tabpanel">
                    <b-card-body>
                        В разработке...
                    </b-card-body>
                </b-collapse>
            </b-card>
        </div>
    </div>
</template>

<script>
import { userPanel, UserInfoView } from "../../../organisms";
import { AtzCommentComponent } from "../../../organisms/comments/";
import AtzTable from "./index";
import Table3 from "./table3";
import Table4 from "./table4";
import { BButton, BTableSimple, BThead, BTbody, BTh, BTd, BTr, BCollapse, BCard, BCardHeader, BCardBody, VBToggle } from "bootstrap-vue";
import Axios from "axios";
export default {
    directives: {
        BToggle: VBToggle,
    },
    components: {
        "v-userPanel": userPanel,
        "atz-table": AtzTable,
        comments: AtzCommentComponent,
        table3: Table3,
        table4: Table4,
        UserInfoView,
        BButton,
        BTableSimple,
        BThead,
        BTbody,
        BTh,
        BTd,
        BTr,
        BCollapse,
        BCard,
        BCardHeader,
        BCardBody,
    },
    data() {
        return {
            csrf: document.getElementsByName("csrf-token")[0].content,
            orgInfo: {},
            id_org: null,
            table2Info: {},
            passport: [],
        };
    },
    async mounted() {
        await this.init();
        await this.getPassportInfo();
    },
    methods: {
        setTable2Atz(event) {
            this.table2Info = event;
        },
        init() {
            if (window._Organization) this.orgInfo = window._Organization;

            if (window._Region) this.orgInfo.region = window._Region;

            if (this.$route.params.id) this.id_org = this.$route.params.id;

            console.log(this.id_org);
        },
        async getPassportInfo() {
            let data = new FormData();
            data.append("id_org", this.id_org);
            return Axios.post("/app/atz/get-info", data, {
                headers: {
                    "X-CSRF-Token": this.csrf,
                },
            }).then(res => {
              this.passport = res.data;
            });
        },
    },
};
</script>

<style></style>
