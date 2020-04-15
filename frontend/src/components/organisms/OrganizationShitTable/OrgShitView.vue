<template>
    <div style="height: 550px;" id="org-shit-table">
        <div v-if="!items.length" class="text-center">
            Данные загружаются, подождите
            <b-spinner variant="primary" />
        </div>

        <b-table sticky-header select-mode="single" selectable @row-selected="toObjects" hover style="font-size: 10px; min-height: 100%" small bordered :items="items" :fields="fields">
            <template v-slot:cell(pdf_export)="data">
                <div id="icon">
                    <a style="display: block" v-if="data.item.pdf_export" :href="`/program/download-doc/${data.item.id_org}`">
                        <b-icon icon="file-earmark-arrow-down" scale="4" variant="success" />
                    </a>
                </div>
            </template>
            <template v-slot:cell(abj_obr)="data">
                <span class="text-secondary">{{ data.item.abj_obr }}</span>
            </template>
            <template v-slot:cell(abj_prog)="data">
                <span class="text-warning">{{ data.item.abj_prog }}</span>
            </template>
            <template v-slot:cell(abj_nappr)="data">
                <span class="text-danger">{{ data.item.abj_nappr }}</span>
            </template>
            <template v-slot:cell(abj_appr)="data">
                <span class="text-success">{{ data.item.abj_appr }}</span>
            </template>
        </b-table>
    </div>
</template>

<script>
import { BTable, BIcon, BSpinner, BTd } from "bootstrap-vue";
import Axios from "axios";
export default {
    components: {
        BTable,
        BIcon,
        BSpinner,
        BTd
    },
    async mounted() {
        await this.getObjects();
    },
    data() {
        return {
            fields: [
                { key: "id_org", label: "ID ВУЗа" },
                { key: "region", label: "Субъект" },
                { key: "org_name", label: "Наименование ВУЗа" },
                { key: "pdf_export", label: "Выгрузка PDF" },
                { key: "program_status", label: "Статус программы" },
                { key: "obs_limits", label: "Общие лимиты" },
                { key: "obs_reserv", label: "Общий резерв (рассчитывается, когда ДЭП и ДКУ присвоили статус рассмотрено)" },
                { key: "pred_zakl", label: "Предварительное отклонение от лимитов" },
                { key: "kap_rem", label: "Объем бюджетного финансирования кап.ремонт" },
                { key: "obj_all", label: "Объектов всего" },
                { key: "abj_obr", label: "Объектов в обработке" },
                { key: "abj_prog", label: "Объектов на доработке" },
                { key: "abj_nappr", label: "Объектов не утверждено" },
                { key: "abj_appr", label: "Объектов утверждено" },
                { key: "abj_dep", label: "Объектов утверждено ДЭП" },
                { key: "cost_pr", label: "Объем бюджетного финансирования по приоритетным объектам рекомендованным к согласованию" },
                { key: "cost_res", label: "Объем бюджетного финансирования по резервным объектам рекомендованным к согласованию" },
                { key: "cost_depPr", label: "Объем бюджетного финансирования по объектам рассмотренным ДЭП" },
                { key: "cost_depRes", label: "Объем бюджетного финансирования по объектам рассмотренным ДЭП(резерв)" },
                { key: "atz_nb", label: "Объем бюджетного финансирования АТЗ, не более" },
                { key: "atz", label: "Объем бюджетного финансирования АТЗ по программе" },
                { key: "atz_bud_fin", label: "Согласованный объем бюджетного финансирования АТЗ" },
                { key: "dku_status", label: "Статус программы (ДКУ)" }
            ],
            items: []
        };
    },
    methods: {
        getObjects() {
            Axios.get("/shit-table/data").then(response => {
                this.items = response.data.program;
            });
        },
        toObjects(item) {
            //console.log(item);
            window.location = `/organization/list/${item[0].id_org}`;
        }
    }
};
</script>

<style scoped>
#icon {
    margin: 15px auto !important;
    text-align: center;
}
</style>
