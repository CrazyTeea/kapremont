<template>
    <div>
        <b-breadcrumb
            :items="[
                {
                    text: 'Список организаций',
                    href: '/organization/list'
                }
            ]"
        />

        <b-tabs content-class="mt-3">
            <b-tab v-can:root,mgsu,dep lazy title-link-class="text-info" title="Сводная таблица">
                <shit-table />
            </b-tab>

            <b-tab lazy title-link-class="text-info" title="Организации" active>
                <v-all-organizations state="all" />
            </b-tab>

            <b-tab lazy v-can:root,mgsu,dep title-link-class="text-secondary" title="В обработке">
                <v-objects status="1" />
            </b-tab>

            <b-tab lazy v-can:root,mgsu,dep title-link-class="text-warning" title="Возвращено на доработку">
                <v-objects status="4" />
            </b-tab>

            <b-tab lazy v-can:root,mgsu,dep title-link-class="text-success" title="Рекомендуется к согласованию">
                <v-objects status="2" />
            </b-tab>

            <b-tab lazy v-can:root,mgsu,dep title-link-class="text-danger" title="Не рекомендуется к согласованию">
                <v-objects status="3" />
            </b-tab>
            <b-tab lazy v-can:root title-link-class="text-danger" title="Реализация">
                <v-objects status="5" />
            </b-tab>

            <b-tab lazy v-can:root,mgsu,dep title-link-class="text-success" title="Рассмотрено ДЭП">
                <v-objects dep_status="approved" />
            </b-tab>

            <b-tab lazy v-can:root,mgsu,dep title-link-class="text-warning" title="Резерв">
                <v-objects status="2" dep_status="rejected" dku_status="rejected" or_where="true" />
            </b-tab>

            <b-tab lazy v-can:root,mgsu,dep title-link-class="text-info" title="Организации иных ФОИВ">
                <v-all-organizations state="other" />
            </b-tab>

            <b-tab lazy v-can:root,mgsu,dep title-link-class="text-dark" title="Объекты на реализации">
                <v-objects status="5"/>
            </b-tab>


        </b-tabs>
        <a v-can:root,mgsu,dep class="btn btn-warning mt-3" href="/organization/export/2">Статистика по статусам</a>
        <a v-can:dku,dku_user class="btn btn-warning mt-3" href="/program/dku-export">Статистика по статусам</a>
        <a v-can:root,mgsu,dep class="btn btn-warning mt-3" href="/organization/export/1">Статистика по бюджетам (Организация)</a>
        <a v-can:root,mgsu,dep class="btn btn-warning mt-3" href="/program-objects/export">Статистика по бюджетам (объект)</a>
    </div>
</template>

<script>
import AllOrganizations from "./AllOrganizations.vue";
import ObjectsCheckComponent from "./ObjectsCheckComponent.vue";
import { ShitTable } from "../../organisms";
import { BBreadcrumb, BTabs, BTab } from "bootstrap-vue";
export default {
    components: {
        BBreadcrumb,
        BTabs,
        BTab,
        ShitTable,
        "v-all-organizations": AllOrganizations,
        "v-objects": ObjectsCheckComponent
    },
    data() {
        return {
            tab_show: window.show_comp
        };
    }
};
</script>

<style></style>
