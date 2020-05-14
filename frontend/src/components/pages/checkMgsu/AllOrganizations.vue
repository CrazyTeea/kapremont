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
                        <b-input-group prepend="ID" class="mb-2">
                            <b-form-input type="number" aria-label="First name" v-model="filters.id"></b-form-input>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.id = null"><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="Субъект" class="mb-2">
                            <b-form-input aria-label="First name" v-model="filters.region"></b-form-input>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.region = null"><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="Организация" class="mb-2">
                            <b-form-input aria-label="First name" v-model="filters.name"></b-form-input>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.name = null"><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="Колличество объектов" class="mb-2">
                            <b-form-select v-model="filters.quantity" :options="options.quantity"></b-form-select>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.quantity = null"><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="Выгрузка PDF" class="mb-2">
                            <b-form-select v-model="filters.file_exist" :options="options.file_exist"></b-form-select>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.file_exist = null"><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="Выгрузка отправлена" class="mb-2">
                            <b-form-select v-model="filters.p_status" :options="options.p_status"></b-form-select>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.p_status = null"><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon></b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </div>
                </b-card-body>
            </b-collapse>
        </b-card>

        <div class="row mt-3">
            <div class="col-12">
                <b-alert v-for="(banner, index) in bannerInfo" :key="index" :show="banner.show" :variant="banner.variant" dismissible fade>{{ banner.message }}</b-alert>
            </div>
        </div>

        <div class="table-overflow-hidden mt-1">
            <b-table-simple bordered hover>
                <b-thead>
                    <b-tr>
                        <b-th>ID</b-th>
                        <b-th>Субъект</b-th>
                        <b-th>Образовательная организация высшего образования</b-th>
                        <b-th>Объектов добавлено</b-th>
                        <b-th>Выгрузка PDF</b-th>
                        <b-th>Выгрузка отправлена</b-th>
                        <b-th v-can:dku,dku_user>Статус программы (ДКУ)</b-th>
                        <b-th v-can:dep,dku,dku_user >Статус программы (ДЭП)</b-th>
                        <b-th v-can:dku,dku_user>Согласованный объем бюджетного финансирования АТЗ</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr v-for="(item, index) in items" :key="index">
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <label>{{ item.id }}</label>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <label>{{ item.region }}</label>
                        </b-th>
                        <b-th v-can:root,mgsu,dep @click="goToRef(item.id)" class="normal-font-weight-for-sell cursor-pointer center-text-in-cell">
                            <label class="cursor-pointer">{{ item.name }}</label>
                        </b-th>
                        <b-th v-can:dku,dku_user class="normal-font-weight-for-sell cursor-pointer center-text-in-cell">
                            <label class="cursor-pointer">{{ item.name }}</label>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <label>{{ item.quantity }}</label>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <a v-if="item.file_exist === '1'" :href="`/program/download-doc/${item.id}`" class="a-decorating"
                                ><b-icon icon="file-earmark-arrow-down" scale="2" vriant="success"></b-icon
                            ></a>
                            <b-icon v-else icon="alert-circle" scale="2"></b-icon>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <b-icon v-if="item.p_status === '1'" icon="check" variant="success" scale="2"></b-icon>
                            <b-icon v-else icon="x-octagon" variant="danger" scale="2"></b-icon>
                        </b-th>
                        <b-th v-can:dku,dku_user class="normal-font-weight-for-sell center-text-in-cell">
                            <b-form-select
                                    v-can:dku
                                @change="setDkuStatus(item)"
                                v-model="item.dku_status"
                                :options="[
                                    {value: 'not', text: 'В обработке'},
                                    {value: 'approved', text: 'Согласовано ДКУ'},
                                    {value: 'rejected', text: 'Резерв'}
                                ]"
                            ></b-form-select>
                            <span v-can:dku_user>{{ getDkuStatus(item.dku_status) }}</span>
                        </b-th>
                        <b-th v-can:dep,dku,dku_user class="normal-font-weight-for-sell center-text-in-cell">
                            <b-form-select
                                    v-can:dep
                                @change="setDepStatus(item)"
                                v-model="item.dep_status"
                                :options="[
                                    {value: 'not', text: 'В обработке'},
                                    {value: 'approved', text: 'Согласовано ДЭП'},
                                    {value: 'rejected', text: 'Резерв'}
                                ]" />
                            <span v-can:dku,dku_user>{{getDepStatus(item.dep_status)}}</span>
                        </b-th>
                        <b-th  v-can:dku,dku_user class="normal-font-weight-for-sell center-text-in-cell">
                            <b-form-input v-can:dku
                                    @change="setDkuAtz(item)"
                                    v-model="item.dku_atz"
                            ></b-form-input>
                            <span v-can:dku_user>{{item.dku_atz}}</span>
                        </b-th>
                    </b-tr>
                </b-tbody>
            </b-table-simple>

            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage"></b-pagination>
        </div>
    </div>
</template>

<script>
import Axios from "axios";
import {
    BAlert,
    BCard,
    BCardHeader,
    BInputGroup,
    BFormInput,
    BInputGroupAppend,
    BCollapse,
    BCardBody,
    BButton,
    BFormSelect,
    BTableSimple,
    BThead,
    BTr,
    BTh,
    BTbody,
    BPagination,
    VBToggle
} from "bootstrap-vue";
export default {
    props: ['state'],
    directives: {
        "b-toggle": VBToggle
    },
    components: {
        BAlert,
        BCollapse,
        BCard,
        BCardHeader,
        BCardBody,
        BInputGroup,
        BFormInput,
        BInputGroupAppend,
        BButton,
        BFormSelect,
        BTableSimple,
        BThead,
        BTr,
        BTh,
        BTbody,
        BPagination,
    },
    data() {
        return {
            bannerInfo: [],
            selected:null,
            filters: {
                state: null,
                id: null,
                region: null,
                name: null,
                quantity: null,
                file_exist: null,
                p_status: null,
            },
            options: {
                dku_status:[
                    {value: 'not', text: 'В обработке'},
                    {value: 'approved', text: 'Согласовано ДКУ'},
                    {value: 'rejected', text: 'Резерв'}
                ],
                dep_status:[
                    {value: 'not', text: 'В обработке'},
                    {value: 'approved', text: 'Согласовано ДЭП'},
                    {value: 'rejected', text: 'Резерв'}
                ],
                quantity: [
                    { value: "up", text: "По возрастанию" },
                    { value: "down", text: "По убыванию" }
                ],
                file_exist: [
                    { value: "1", text: "Выгружено" },
                    { value: "0", text: "Не выгружено" }
                ],
                p_status: [
                    { value: "1", text: "Отправлена" },
                    { value: "0", text: "Не отправлена" }
                ],
                status: [
                    { value: "1", text: "В обработке" },
                    { value: "2", text: "Рекомендуется к согласованию" },
                    { value: "3", text: "Не рекомендуется к согласованию" },
                    { value: "4", text: "Возвращено на доработку" }
                ]
            },
            csrf: document.getElementsByName("csrf-token")[0].content,
            items: [],
            currentPage: 1,
            perPage: 10,
            totalRows: 1
        };
    },
    async mounted() {
        this.filters.state = this.state;
        this.getTable();
    },
    methods: {
        getDkuStatus(s){
          return this.options.dku_status.find(item=>item.value == s).text;
        },
        getDepStatus(s){
            return this.options.dep_status.find(item=>item.value == s).text;
        },
        setBanner(variant, message, timeout = 2500) {
            this.bannerInfo.unshift({
                show: true,
                variant: variant,
                message: message
            });
            setTimeout(() => {
                this.bannerInfo.pop();
            }, timeout);
        },
        goToRef(id) {
            window.location = `/organization/list/${id}`;
        },
        getTable(offset = 0) {
            let form = new FormData();
            form.append("form", JSON.stringify(this.filters));
            Axios.post(`/api/mgsu/main-table/${offset}`, form, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                this.items = res.data.rows;
                this.totalRows = res.data.count.quantity;
            });
        },
        setDkuAtz(item) {
            let form = new FormData();
            form.append('dku_atz', item.dku_atz)
            Axios.post(`/api/set-status/dku/${item.id}`, form, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                this.getTable()
                this.setBanner('success', `Данные внесены успешно: ${item.name}`, 3200)
            }).catch(() => {
                this.setBanner("danger", "Что-то пошло не так! Обратитесь в служюу поддержки.")
            })
        },
        setDkuStatus(item) {
            let form = new FormData();
            form.append('dku_status', item.dku_status)
            Axios.post(`/api/set-status/dku/${item.id}`, form, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                this.getTable()
                this.setBanner('success', `Статус успешно изменен: ${item.name}`, 3200)
            }).catch(() => {
                this.setBanner("danger", "Что-то пошло не так! Обратитесь в служюу поддержки.")
            })
        },
        setDepStatus(item) {
            let form = new FormData();
            form.append('dep_status', item.dep_status)
            Axios.post(`/api/set-status/dep/${item.id}`, form, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                this.getTable()
                this.setBanner('success', `Статус успешно изменен: ${item.name}`, 3200)
            }).catch(() => {
                this.setBanner("danger", "Что-то пошло не так! Обратитесь в служюу поддержки.")
            })
        }
    },
    watch: {
        currentPage() {
            let offset = (parseInt(this.currentPage) - 1) * 10;
            this.getTable(offset);
        },
        filters: {
            handler() {
                this.getTable();
            },
            deep: true
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
.center-text-in-cell {
    vertical-align: middle !important;
    text-align: center !important;
}
.cursor-pointer {
    cursor: pointer !important;
}
.a-decorating {
    text-decoration: none !important;
    color: darkgreen !important;
}
</style>
