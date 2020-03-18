<template>
    <div class="table-overflow-hidden">
        <b-table-simple bordered hover>
            <b-thead>
                <b-tr>
                    <b-th>ID</b-th>
                    <b-th>Субъект</b-th>
                    <b-th>Образовательная организация высшего образования</b-th>
                    <b-th>Объектов добавлено</b-th>
                    <b-th>Выгрузка PDF</b-th>
                    <b-th>Выгрузка отправлена</b-th>
                    <b-th>Подробнее</b-th>
                </b-tr>
            </b-thead>
            <b-tbody>
                <b-tr v-for="(item, index) in items" :key="index">
                    <b-th class="normal-font-weight-for-sell">
                        <label>{{ item.id }}</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell">
                        <label>{{ item.name }}</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell">
                        <label>{{ item.region }}</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell">
                        <label>{{ item.count_org }}</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell">
                        скоро
                    </b-th>
                    <b-th class="normal-font-weight-for-sell">
                        скоро
                    </b-th>
                    <b-th class="normal-font-weight-for-sell">
                        скоро
                    </b-th>
                </b-tr>
            </b-tbody>
        </b-table-simple>

        <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
        ></b-pagination>
    </div>
</template>

<script>
import Axios from "axios";
export default {
    data() {
        return {
            csrf: document.getElementsByName("csrf-token")[0].content,
            items: [],
            currentPage: 1,
            perPage: 10,
            totalRows: 1
        };
    },
    mounted() {
        this.getTotalRows();
        this.getTable();
    },
    methods: {
        getTable(offset = 0) {
            Axios.post(`/api/mgsu/main-table/${offset}`, null, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                this.items = res.data;
            });
        },
        getTotalRows() {
            Axios.post("/api/mgsu/count", null, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                this.totalRows = res.data[0].quantity;
            });
        }
    },
    watch: {
        currentPage: function() {
            let offset = parseInt(this.currentPage) * 10;
            this.getTable(offset);
        }
    }
};
</script>

<style>
.table-overflow-hidden {
    overflow: hidden !important;
    overflow-x: scroll !important;
}
.normal-font-weight-for-sell {
    font-weight: normal !important;
}
</style>
