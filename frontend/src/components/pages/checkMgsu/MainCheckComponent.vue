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

        <b-tabs align="center" content-class="mt-3">
            <b-tab title-link-class="text-info" title="Организации">
                <v-all-organizations />
            </b-tab>
            <b-tab title-link-class="text-secondary" title="В обработке">
                <v-objects status="1" />
            </b-tab>
            <b-tab title-link-class="text-warning" title="Возвращено на доработку">
                <v-objects status="4" />
            </b-tab>
            <b-tab title-link-class="text-success" title="Рассмотрено">
                <v-objects status="2" />
            </b-tab>
            <b-tab title-link-class="text-danger" title="Не рекомендуется к согласованию">
                <v-objects status="3" />
            </b-tab>

            <b-tab title-link-class="text-success" title="Рассмотрено ДЭП">
                <v-objects status="2" dep_status="approved"/>
            </b-tab>
            <b-tab title-link-class="text-success" title="Рассмотрено ДКУ">
                <v-objects status="2" dep_status="approved" dku_status="approved"/>
            </b-tab>
            <b-tab title-link-class="text-warning" title="Резерв">
                <v-objects status="2" dep_status="rejected" dku_status="rejected" or_where="true" />
            </b-tab>


            <!-- <b-tab title-link-class="text-danger" title="Не рекомендуется к согласованию">
                <v-objects status="3" />
            </b-tab>
            <b-tab title-link-class="text-danger" title="Не рекомендуется к согласованию">
                <v-objects status="3" />
            </b-tab> -->
        </b-tabs>
        <a class="btn btn-warning mt-3" href="/organization/export/1">Статистика по статусам</a>
        <a class="btn btn-warning mt-3" href="/organization/export/2">Статистика по бюджетам (Организация)</a>
        <a class="btn btn-warning mt-3" href="/program-objects/export">Статистика по бюджетам (объект)</a>
    </div>
</template>

<script>
    import AllOrganizations from "./AllOrganizations.vue";
    import ObjectsCheckComponent from "./ObjectsCheckComponent.vue";
    import {BBreadcrumb, BTabs, BTab} from 'bootstrap-vue'
    export default {
        components: {
            BBreadcrumb,
            BTabs,
            BTab,
            "v-all-organizations": AllOrganizations,
            "v-objects": ObjectsCheckComponent
        },
        data() {
            return {
                tab_show:window.show_comp
            };
        },
        methods: {},
        watch: {

        },
        mounted() {
        }
    };
</script>

<style></style>
