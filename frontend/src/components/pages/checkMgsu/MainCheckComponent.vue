<template>
    <div>
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <span class="toggle_button" v-b-toggle.accordion-3>
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
                                <b-button variant="outline-secondary" @click="filters.id = null"
                                    ><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon
                                ></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="Субъект" class="mb-2">
                            <b-form-input aria-label="First name" v-model="filters.region"></b-form-input>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.region = null"
                                    ><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon
                                ></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="Организация" class="mb-2">
                            <b-form-input aria-label="First name" v-model="filters.organization"></b-form-input>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.organization = null"
                                    ><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon
                                ></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="Колличество объектов" class="mb-2">
                            <b-form-select v-model="filters.quantity" :options="options.quantity"></b-form-select>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.quantity = null"
                                    ><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon
                                ></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="Выгрузка PDF" class="mb-2">
                            <b-form-select v-model="filters.file_exist" :options="options.file_exist"></b-form-select>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.file_exist = null"
                                    ><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon
                                ></b-button>
                            </b-input-group-append>
                        </b-input-group>
                        <b-input-group prepend="Выгрузка отправлена" class="mb-2">
                            <b-form-select v-model="filters.status" :options="options.status"></b-form-select>
                            <b-input-group-append>
                                <b-button variant="outline-secondary" @click="filters.status = null"
                                    ><b-icon icon="backspace" variant="danger" scale="1.2"></b-icon
                                ></b-button>
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
                        <b-th>ID</b-th>
                        <b-th>Субъект</b-th>
                        <b-th>Образовательная организация высшего образования</b-th>
                        <b-th>Объектов добавлено</b-th>
                        <b-th>Выгрузка PDF</b-th>
                        <b-th>Выгрузка отправлена</b-th>
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
                        <b-th
                            @click="goToRef(item.id)"
                            class="normal-font-weight-for-sell cursor-pointer center-text-in-cell"
                        >
                            <label class="cursor-pointer">{{ item.name }}</label>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <label>{{ item.quantity }}</label>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <a v-if="item.file_exist === '1'" class="document-item" href="1" filetype="pdf">
                                <span class="fileCorner"></span>
                            </a>
                            <b-icon v-else icon="alert-circle" scale="2"></b-icon>
                        </b-th>
                        <b-th class="normal-font-weight-for-sell center-text-in-cell">
                            <b-icon v-if="item.status === '1'" icon="check" variant="success" scale="2"></b-icon>
                            <b-icon v-else icon="x-octagon" variant="danger" scale="2"></b-icon>
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

export default {
    data() {
        return {
            filters: {
                id: null,
                region: null,
                organization: null,
                quantity: null,
                file_exist: null,
                status: null
            },
            options: {
                quantity: [
                    { value: "up", text: "По возрастанию" },
                    { value: "down", text: "По убыванию" }
                ],
                file_exist: [
                    { value: "1", text: "Выгружено" },
                    { value: "0", text: "Не выгружено" }
                ],
                status: [
                    { value: "1", text: "Отправлена" },
                    { value: "0", text: "Не отправлена" }
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
        this.getTable();
    },
    methods: {
        goToRef(id) {
            window.location = `/organization/list/${id}`;
        },
        getTable(offset = 0) {
            let form = new FormData();
            form.append('form', JSON.stringify(this.filters))
            Axios.post(`/api/mgsu/main-table/${offset}`, form, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                this.items = res.data.rows;
                this.totalRows = res.data.count.quantity;
            });
        },
    },
    watch: {
        currentPage() {
            let offset = (parseInt(this.currentPage) - 1) * 10;
            this.getTable(offset);
        },
        filters: {
            handler() {
                this.getTable()
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
    cursor: pointer;
}
.document-item {
    display: block;
    position: relative;
    color: black;
}
.document-item::before {
    position: absolute;
    width: 29px;
    height: 34px;
    left: 0;
    top: -7px;
    content: "";
    border: solid 2px #920035;
}
.document-item::after {
    content: "file";
    content: attr(filetype);
    left: -4px;
    padding: 0px 2px;
    text-align: right;
    line-height: 1.3;
    position: absolute;
    background-color: #000;
    color: #fff;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    top: 9px;
}
.document-item .fileCorner {
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 11px 0 0 7px;
    border-color: white transparent transparent #920035;
    position: absolute;
    top: -7px;
    left: 22px;
}
</style>
