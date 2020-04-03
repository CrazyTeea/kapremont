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
            <b-tab title-link-class="text-success" title="Рекомендуется к согласованию">
                <v-objects status="2" />
            </b-tab>
            <b-tab title-link-class="text-danger" title="Не рекомендуется к согласованию">
                <v-objects status="3" />
            </b-tab>
            <!-- <b-tab title-link-class="text-danger" title="Не рекомендуется к согласованию">
                <v-objects status="3" />
            </b-tab>
            <b-tab title-link-class="text-danger" title="Не рекомендуется к согласованию">
                <v-objects status="3" />
            </b-tab> -->
        </b-tabs>
        <a class="btn btn-warning mt-3" href="/organization/export">Статистика по статусам</a>
        <a class="btn btn-warning mt-3" href="/program-objects/export">Статистика по бюджетам</a>
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
        return {};
    },
    methods: {},
    watch: {}
};
</script>

<style></style>
