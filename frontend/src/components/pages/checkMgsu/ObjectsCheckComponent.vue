<template>
    <div>
        <div class="table-overflow-hidden mt-3">
            <b-table-simple bordered hover>
                <b-thead>
                    <b-tr>
                        <b-th>ID Организации</b-th>
                        <b-th>Название организации</b-th>
                        <b-th>ID Объекта</b-th>
                        <b-th>Приоритет</b-th>
                        <b-th>Тип</b-th>
                        <b-th>Название объекта</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr v-for="(item, index) in items" :key="index" @click="goTo(item.po_id)" class="cursor-pointer">
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <label class="cursor-pointer">{{ item.o_id }}</label>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <label class="cursor-pointer">{{ item.o_name }}</label>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell cursor-pointer center-text-in-cell">
                            <label class="cursor-pointer">{{ item.po_id }}</label>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <label class="cursor-pointer">{{ getPriority(item.priority) }}</label>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <label class="cursor-pointer">{{ item.type }}</label>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <label class="cursor-pointer">{{ item.po_name }}</label>
                        </b-th>
                    </b-tr>
                </b-tbody>
            </b-table-simple>
            <b-pagination v-model="currentPage" :total-rows="totalRows[status]" :per-page="perPage" />
        </div>
    </div>
</template>

<script>
import Axios from 'axios';
import {BTableSimple,BTr,BTh,BTbody,BPagination,BThead} from 'bootstrap-vue'
export default {
    components:{
        BTableSimple,
        BTbody,BTr,
        BTh,
        BPagination,
        BThead
    },
    props: ["status"],
    data() {
        return {
            csrf: document.getElementsByName("csrf-token")[0].content,
            items: [],
            currentPage:1,
            totalRows:[],
            perPage: 10
        };
    },
    async mounted() {
        await this.status;
        await this.getObjects();
    },
    watch:{
        currentPage() {
            let offset = (parseInt(this.currentPage) - 1) * 10;
            this.getObjects(offset);
        },
    },
    methods: {
        getPriority(num) {
            let id = parseInt(num);
            if(id == 0) {
                return "Приоритетный"
            } else {
                return "Резервный"
            }
        },
        goTo(id_obj) {
            window.location = `/organization/obj/${id_obj}`;
        },
        async getObjects(offset = 0) {
            let form = new FormData();
            form.append("form", JSON.stringify({ status: this.status }));
            return Axios.post(`/api/mgsu/objects-table/${offset}`, form, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                console.log(res.data);
                this.items = res.data.items;
                this.totalRows[this.status] = res.data.count
            });
        }
    }
};
</script>
