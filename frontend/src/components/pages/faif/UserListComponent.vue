<template>
    <div class="wrap">
        <div class="col-4">
            <v-user-panel />
        </div>
        <div class="button-block">
            <b-button variant="info" class="mt-3 ml-3" href="/faif/user/create" v-show="!ban">Добавить объект кап. ремонта</b-button>
        </div>
        <div class="obj-block row container">
            <b-card no-body>
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <span> <b-icon-gear-wide-connected />Объекты требующие капитального ремонта </span>
                </b-card-header>
                <b-card-body>
                    <b-card-text>Приоритетные объекты</b-card-text>
                    <b-card-text>Резервные объекты</b-card-text>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
import { userPanel } from "../../organisms";

export default {
    components: {
        "v-user-panel": userPanel
    },
    data() {
        return {
            ban: false
        };
    }
};
</script>
