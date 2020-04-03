<template>
    <div>
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab" v-b-toggle.accordion-3>
                <span class="toggle_button" >
                    <b-icon icon="filter" scale="1.5" class="mr-2 ml-1"></b-icon>
                    Фильтры</span
                >
            </b-card-header>
            <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <div>
                        <b-input-group prepend="ID Организации" class="mb-2">
                            <b-form-input type="number" aria-label="First name" v-model="filters.id_org"></b-form-input>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.id = null"><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="ID Объекта" class="mb-2">
                            <b-form-input type="number" aria-label="First name" v-model="filters.id"></b-form-input>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.id = null"><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon></b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </div>
                </b-card-body>
            </b-collapse>
        </b-card>
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
import {
    BTableSimple,
    BCard,
    BCardHeader,
    BCollapse,
    BCardBody,
    BInputGroup,
    BFormInput,
    BInputGroupAppend,
    BButton,
    BTr,
    BTh,
    BTbody,
    BPagination,
    BThead,
    VBToggle
} from 'bootstrap-vue'
export default {
    directives:{
        'b-toggle':VBToggle  
    },
    components:{
        BButton,
        BInputGroupAppend,
        BFormInput,
        BInputGroup,
        BCardBody,
        BCollapse,
        BTableSimple,
        BTbody,BTr,
        BTh,
        BPagination,
        BThead,
        BCard,
        BCardHeader
    },
    props: ["status"],
    data() {
        return {
            csrf: document.getElementsByName("csrf-token")[0].content,
            filters: {
                status: null,
                id_org: null,
                id: null
            },
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
        filters: {
            handler() {
                this.getObjects();
            },
            deep: true
        }
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
            this.filters.status = this.status;
            // form.append("form", JSON.stringify({ status: this.status }));
            form.append("form", JSON.stringify(this.filters));
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
