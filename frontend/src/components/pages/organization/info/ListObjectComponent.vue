<template>
    <b-card no-body>
        <b-card-header header-tag="header" class="p-1" role="tab">
            <span>
                <b-icon-gear-wide-connected />Объекты требующие капитального
                ремонта
            </span>
        </b-card-header>
        <b-card-body class="hidden-overflow">
            <b-table-simple bordered hover>
                <b-thead>
                    <b-tr>
                        <b-th>№</b-th>
                        <b-th>Приоритет</b-th>
                        <b-th>Субъект РФ</b-th>
                        <b-th
                            >Наименование объекта, требующего кап. ремонта</b-th
                        >
                        <b-th>Назначение</b-th>
                        <b-th>Площадь кап. ремонта (кв.м)</b-th>
                        <b-th>Адрес объекта</b-th>
                        <b-th>Год постройки</b-th>
                        <b-th>Износ здания</b-th>
                        <b-th
                            >Предписания надзорных органов: МЧС, Роспотребнадзор
                            и т.д. (при наличии)</b-th
                        >
                        <b-th>Вид планируемого мероприятия</b-th>
                        <b-th
                            >Сумма бюджетного финансирования на проведение
                            кап.ремонта (тыс. руб)</b-th
                        >
                        <b-th
                            >Софинансирование из внебюджетных источников (тыс.
                            руб)</b-th
                        >
                        <b-th>Примечание</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr v-for="(item, index) in items" :key="index" @click="goToObj(item.id)">
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ index + 1 }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ item.id_priority }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell cursor-pointer center-text-in-cell" 
                        >
                            <label class="cursor-pointer">{{
                                item.city
                            }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ item.name }}</label>
                        </b-th>
                        <b-th 
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ item.assignment }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ item.square_kap }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ item.address }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ item.year }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ getIznos(item.wear) }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ item.regulation }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer"></label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ item.finance_sum }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label  class="cursor-pointer">{{ item.coFinancing }}</label>
                        </b-th>
                        <b-th
                            class="normal-font-weight-for-sell center-text-in-cell cursor-pointer" 
                        >
                            <label class="cursor-pointer">нет</label>
                        </b-th>
                    </b-tr>
                </b-tbody>
            </b-table-simple>

            <b-pagination
                v-show="currentPage"
                :per-page="perPage"
                v-model="currentPage"
            />
        </b-card-body>
    </b-card>
</template>

<script>
import Axios from "axios";
export default {
    data() {
        return {
            currentPage: 1,
            perPage: 5,
            csrf: document.getElementsByName("csrf-token")[0].content,
            org_id: null,
            items: []
        };
    },
    mounted() {
        this.org_id = this.$route.params.id;
        this.getCurentOrg();
    },
    methods: {
        getCurentOrg() {
            Axios.post(`/api/org-table/${this.org_id}`, null, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                console.log(res.data);
                this.items = res.data;
            });
        },
        getIznos(iznos) {
            let izn = parseInt(iznos);
            if (izn === 0) {
                return "Менее 20%";
            } else if (izn === 1) {
                return "От 20% до 50%";
            } else if (izn === 2) {
                return "От 50% до 70%";
            } else if (izn === 3) {
                return "От 70% до 90%";
            } else if (izn === 4) {
                return "Более 90%";
            }
        },
        goToObj(id) {
            // window.location = '/'
            console.log(id)
        }
    }
};
</script>

<style>
.hidden-overflow {
    overflow: hidden;
    overflow-x: scroll;
}
.normal-font-weight-for-sell {
    font-weight: normal !important;
}
.cursor-pointer {
    cursor: pointer;
}
</style>
