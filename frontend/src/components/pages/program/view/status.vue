<template>
    <div id="dev_programme">

        <div class="row">
            <!-- <div class="col-12">
                <b-alert v-show="!user_status" show variant="warning" >
                    Уважаемые пользователи! Просим Вас <a :href="`/organization/user-info/${id_org}`">заполнить форму</a>, предоставив контактные данные сотрудников организации.
                </b-alert>
            </div> -->
            <div class="col-6">
                <b-table
                    :fields="[
                        { key: 'id', label: '№' },
                        { key: 'label', label: 'Показатель' },
                        { key: 'value', label: 'Значение' }
                    ]"
                    :items="[
                        {
                            id: '1',
                            label: 'Полное наименование организации',
                            value: getUser && getUser.organization && getUser.organization.name
                        },
                        {
                            id: '2',
                            label: 'Сокращенное наименование организации',
                            value: getUser && getUser.organization && getUser.organization.short_name
                        }
                    ]"
                    small
                    bordered
                />

                <!-- <b-button class="btn btn-sm" style="float: right" href="/organization/info">Подробнее</b-button> -->
            </div>

            <div class="col-4 offset-2">
                <v-user-panel />
            </div>
        </div>
        <br />
        <br />
        <div class="row">
            <b-card no-body>
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <span> <b-icon-gear-wide-connected />Объекты в стадии реализации</span>
                </b-card-header>
                <b-card-body>

                    <b-table-simple
                        bordered
                        hover
                        >
                            <b-thead>
                                <b-tr>
                                    <b-th>№</b-th>
                                    <b-th>Тип</b-th>
                                    <b-th>Приоритет</b-th>
                                    <b-th>Субъект РФ</b-th>
                                    <b-th>Наименование объекта, требующего кап. ремонт</b-th>
                                    <b-th>Назначение</b-th>
                                    <b-th>Площадь кап. ремонта (кв.м)</b-th>
                                    <b-th>Адрес объекта</b-th>
                                    <b-th>Год постройки</b-th>
                                    <b-th>Износ здания (%)</b-th>
                                    <b-th>Предписание надзорных органов: МЧС, Роспотребнадзор и т.д. (при наличии)</b-th>
                                    <b-th>Вид планируемого мероприятия</b-th>
                                    <b-th>Сумма бюджетного финансирования на проведение кап.ремонта (тыс. руб)</b-th>
                                    <b-th>Софинансирование из внебюджетных источников (тыс. руб)</b-th>
                                    <b-th>Примечание</b-th>
                                </b-tr>
                            </b-thead>
                            <b-tbody>
                                <b-tr v-for="(item, index) in items" :key="index" @click="onRowClick(item)">
                                    <b-th class="normal-text-for-cell">{{ item.id }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ getType(item.type) }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.id_priority }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.region }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.name }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.assignment }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.square }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.address }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.year }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ getIznos(item.wear) }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.podrobnosti }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ getTypeRemont(item.type_remont) }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.finance }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.coFinanse }}</b-th>
                                    <b-th class="normal-text-for-cell">{{ item.note }}</b-th>
                                </b-tr>
                            </b-tbody>
                    </b-table-simple>
                
                </b-card-body>
            </b-card>
        </div>
        <div class="mt-3">
            <div class="row">
                <div class="col-12">
                    <b-alert v-for="(banner, index) in bannerInfo" :key="index" :show="banner.show" :variant="banner.variant" dismissible fade>{{ banner.message }}</b-alert>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { userPanel } from "../../../organisms";
import { mapGetters, mapActions } from "vuex";
import Axios from "axios";
import {
    BButton,
    BCard,
    BCardBody,
    BCardHeader,
    BPagination,
    BAlert,
    BTable,
    BTbody,
    BTd,
    BTfoot,
    BTh,
    BThead,
    BTr,
    BTableSimple,
    BCardText,
    VBToggle,
} from "bootstrap-vue";
export default {
    directives:{
        'b-toggle':VBToggle
    },
    components:{
        BTbody,
        BTd,
        BTfoot,
        BTh,
        BThead,
        BTr,
        BTableSimple,
        BAlert,
        BCard,
        BCardHeader,
        BCardBody,
        BButton,
        BPagination,
        BTable,
        BCardText,
        "v-user-panel": userPanel,
    },
    data() {
        return {
            bannerInfo: [],
            id_org: null,
            csrf: document.getElementsByName("csrf-token")[0].content,
            items: null
        };
    },
    methods: {
        getTypeRemont(item) {
            if(item == '0') {
                return 'Комплексный';
            } else {
                return 'Выборочный';
            }
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
        getType(item) {
            if(item == '1') {
                return 'Резервный';
            } else {
                return 'Приоритетный';
            }
        },
        getObjs() {
            return Axios.post(`/api/get/program-objects/realized/${this.id_org}`, null, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                this.items = res.data
                console.log(this.items)
            })
        },
        ...mapActions(["requestPageData", "requestUser"]),
        onRowClick(item) {
            if (item.id) {
                // window.location.href = `/program/object/view/${item.id}`;
            }
        },
        rowCount(attr) {
            if (attr === "resTable" && this.reservedObjects?.items) {
                return this.reservedObjects.items.length > this.resTable.perPage;
            } else if (attr === "prevTable" && this.priorityObjects?.items) return this.priorityObjects.items.length > this.prevTable.perPage;
            else return false;
        },
        checkExt(ext) {
            if (ext === "application/pdf") {
                return true;
            }
            this.setBanner("danger", "Файл не является документом pdf!");
            return false;
        },
        setBanner(variant, message) {
            this.bannerInfo.unshift({
                show: true,
                variant: variant,
                message: message
            });
            setTimeout(() => {
               this.bannerInfo.pop();
            }, 1400);
        },
        errorReport(message) {
            this.$bvModal.msgBoxOk(message, {
                title: "Ошибка!",
                size: "sm",
                buttonSize: "sm",
                okVariant: "outline-success",
                headerClass: "p-2 border-bottom-0",
                footerClass: "p-2 border-top-0",
                centered: true
            });
        }
    },
    async mounted() {
        this.requestPageData({ pageName: "programView" });
        await this.requestUser();
        this.id_org = this.getUser.organization.id;

        await this.getObjs();
    },
    computed: {
        ...mapGetters(["getUser", "getPageData"]),
        objects() {
            return this.getPageData && this.getPageData.objects;
        },
        fieldsObjects() {
            return this.getPageData && this.getPageData.fieldsObjects;
        },
        priorityObjects() {
            return this.getPageData && this.getPageData.priorityObjects;
        },
        reservedObjects() {
            return this.getPageData && this.getPageData.reservedObjects;
        },
        target() {
            return this.getPageData && this.getPageData.target;
        },
        rowsPrev() {
            return this.getPageData.priorityObjects && this.getPageData.priorityObjects.items.length;
        },
        resPrev() {
            return this.getPageData.reservedObjects && this.getPageData.reservedObjects.items.length;
        }
    }
};
</script>
<style>
.hover {
    cursor: pointer;
}
</style>
<style scoped>
.toggle_button {
    display: block;
    cursor: pointer;
}
.card-body {
    overflow-y: auto;
}
.normal-text-for-cell {
    font-weight: normal;
}
</style>
