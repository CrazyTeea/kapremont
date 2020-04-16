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

            <template v-slot:cell(pred_zakl)="data">
                <span>{{ data.item.pred_zakl.toFixed(3) }}</span>
            </template>

            <!--<template v-slot:cell(abj_obr)="data">
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
            </template>-->
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
                { key: "id_org", label: "ID ВУЗа" ,sortable:true},
                { key: "region", label: "Субъект",sortable:true },
                { key: "org_name", label: "Наименование ВУЗа" ,sortable:true},
                { key: "pdf_export", label: "Выгрузка PDF",sortable:true },
                { key: "program_status", label: "Статус программы" ,sortable:true},
                { key: "obs_limits", label: "Общие лимиты",sortable:true },
                { key: "obs_reserv", label: "Общий резерв (рассчитывается, когда ДЭП и ДКУ присвоили статус рассмотрено)",sortable:true },
                { key: "pred_zakl", label: "Предварительное отклонение от лимитов",sortable:true },
                { key: "kap_rem", label: "Объем бюджетного финансирования кап.ремонт по программе",sortable:true },
                { key: "obj_all", label: "Объектов всего",sortable:true },
                { key: "abj_obr", label: "Объектов в обработке" ,sortable:true,variant:'secondary'},
                { key: "abj_prog", label: "Объектов на доработке",sortable:true ,variant: 'warning'},
                { key: "abj_nappr", label: "Объектов не рекомендовано к согласованию",sortable:true,variant: 'danger'},
                { key: "abj_appr", label: "Объектов рекомендовано к согласованию",sortable:true,variant: 'success' },
                { key: "abj_dep", label: "Объектов рассмотрено ДЭП" ,sortable:true},
                { key: "cost_pr", label: "Объем бюджетного финансирования по приоритетным объектам рекомендованным к согласованию" ,sortable:true},
                { key: "cost_res", label: "Объем бюджетного финансирования по резервным объектам рекомендованным к согласованию",sortable:true },
                { key: "cost_depPr", label: "Объем бюджетного финансирования по объектам рассмотренным ДЭП" ,sortable:true},
                { key: "cost_depRes", label: "Объем бюджетного финансирования по объектам рассмотренным ДЭП(резерв)" ,sortable:true},
                { key: "dep_status", label: "Статус программы (ДЭП)" ,sortable:true},
                { key: "atz_nb", label: "Объем бюджетного финансирования АТЗ, не более",sortable:true },
                { key: "atz", label: "Объем бюджетного финансирования АТЗ по программе",sortable:true },
                { key: "atz_bud_fin", label: "Согласованный объем бюджетного финансирования АТЗ" ,sortable:true},
                { key: "dku_status", label: "Статус программы (ДКУ)" ,sortable:true}

            ],
            items: []
        };
    },
    methods: {
        getObjects() {
            Axios.get("/shit-table/data").then(response => {
                let pred_zakl =0 ;
                let abj_dep = 0;
                let atz = 0;
                let atz_bud_fin=0;
                response.data.program.forEach(item=>
                {
                    pred_zakl+= parseFloat(item.pred_zakl);
                    abj_dep+= parseFloat(item.abj_dep);
                    atz += parseFloat(item.atz);
                    atz_bud_fin += parseFloat(item.atz_bud_fin);
                });
                console.log(pred_zakl);
                this.items.push({
                    obs_limits:'ИТОГО',
                    pred_zakl:pred_zakl,
                    abj_dep:abj_dep.toFixed(3),
                    atz:atz.toFixed(3),
                    atz_bud_fin:atz_bud_fin.toFixed(3)
                })
                this.items.push(...response.data.program);
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
