<template>
    <div>
        <b-breadcrumb :items="
        [
            {
                text:'Список организаций',
                href:'/organization/list'
            },
            {
                text:'Список объектов',
                href:`/organization/list/${org_id}`
            }
        ]"/>
        <b-card no-body>
            <b-card-header header-tag="header" class="p-1" role="tab">
                <span> <b-icon icon="bookmark-fill" scale="1.5" class="mr-2 ml-1"></b-icon>Подробная информация</span>
            </b-card-header>
            <b-card-body>
                <b-table-simple bordered hover>
                    <b-thead>
                        <b-tr>
                            <b-th
                                >Объем финансового обеспечения на реализацию мероприятий по модернизации инфраструктуры,
                                включая капитальный ремонт объектов и проведение мероприятий по антитеррористической
                                защищенности объектов,тыс. рублей</b-th
                            >
                            <b-th
                                >Из них на реализацию мероприятий по антитеррористической защищенности, не более,тыс.
                                рублей</b-th
                            >
                            <b-th>Предельная стоимость капитального ремонта 1 кв. м. площади, рублей</b-th>
                            <b-th>Ожидаемая площадь капитального ремонта, кв.м.</b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ programm.finance_volume }}</label>
                            </b-th>
                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ programm.finance_events }}</label>
                            </b-th>
                            <b-th class="normal-font-weight-for-sell cursor-pointer center-text-in-cell">
                                <label class="cursor-pointer">{{ programm.cost }}</label>
                            </b-th>
                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ waited_square }}</label>
                            </b-th>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
            </b-card-body>
        </b-card>

        <b-card no-body class="mt-3">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <span> <b-icon icon="bookmark-fill" scale="1.5" class="mr-2 ml-1"></b-icon>Информация</span>
            </b-card-header>
            <b-card-body>
                <b-table-simple bordered hover>
                    <b-thead>
                        <b-tr>
                            <b-th>Объем бюджетного финансирования кап.ремонт</b-th>
                            <b-th colspan="6">Объекты: всего/в обработке / возвращено на доработку/не рекомендуется к согласованию/ рекомендуется к согласованию</b-th>
                            <!-- <b-th>Объем бюджетного финансирования по приоритетным объектам рекомендованным к согласованию</b-th>
                            <b-th>Объем бюджетного финансирования по резервным объектам рекомендованным к согласованию</b-th>
                            <b-th>Объем бюджетного финансирования по объектам рассмотренным ДЭП</b-th>
                            <b-th>Объем бюджетного финансирования по объектам рассмотренным ДЭП (в резерв)</b-th>
                            <b-th>Статус программы (ДЭП) </b-th> -->
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ info.budjet.toFixed(3) }}</label>
                            </b-th>
                                <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                    <label class="cursor-pointer">{{ infoFromServ.countAll }}</label>
                                </b-th>
                                <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                    <label class="cursor-pointer">{{ infoFromServ.vObr }}</label>
                                </b-th>
                                <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                    <label class="cursor-pointer">{{ infoFromServ.recomend }}</label>
                                </b-th>
                                <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                    <label class="cursor-pointer">{{ infoFromServ.notRecomend }}</label>
                                </b-th>
                                <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                    <label class="cursor-pointer">{{ infoFromServ.naDorab }}</label>
                                </b-th>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
            </b-card-body>
        </b-card>


        <b-card no-body class="mt-4">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <span>
                    <b-icon icon="gear-wide-connected" scale="1.5" class="mr-2 ml-1"></b-icon>Объекты требующие
                    капитального ремонта (Приоритетные)
                </span>
            </b-card-header>
            <b-card-body class="hidden-overflow">
                <b-table-simple bordered hover>
                    <b-thead>
                        <b-tr>
                            <b-th>№</b-th>
                            <b-th>Объекты</b-th>
                            <b-th>Уровень приоритета</b-th>
                            <b-th>ID Объекта</b-th>
                            <b-th>Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.) согласно программы ВУЗа</b-th>
                            <b-th>Сумма внебюджетного финансирования на проведение капитального ремонта (тыс. руб.) согласно программы ВУЗа</b-th>
                            <b-th>Статус МГСУ</b-th>
                            <b-th>Статус ДЕП</b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr v-for="(item, index) in prioritet_object" :key="index" @click="goToObj(item.id)">
                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ index + 1 }}</label>
                            </b-th>

                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ item.name }}</label>
                            </b-th>

                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ item.id_priority }}</label>
                            </b-th>

                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ item.id }}</label>
                            </b-th>
                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ item.finance_sum }}</label>
                            </b-th>


                            <b-th class="normal-font-weight-for-sell cursor-pointer center-text-in-cell">
                                <label class="cursor-pointer">{{ item.coFinancing }}</label>
                            </b-th>

                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ item.status }}</label>
                            </b-th>

                             <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ getDepStatus(item.dep_status) }}</label>
                            </b-th>                           

                        </b-tr>
                    </b-tbody>
                </b-table-simple>

                <b-pagination v-show="currentPage" :per-page="perPage" v-model="currentPage" />
            </b-card-body>
        </b-card>

        <b-card no-body class="mt-4">
            <b-card-header header-tag="header" class="p-1" role="tab">
                <span>
                    <b-icon icon="gear-wide-connected" scale="1.5" class="mr-2 ml-1"></b-icon>Объекты требующие
                    капитального ремонта (Резервные)
                </span>
            </b-card-header>
            <b-card-body class="hidden-overflow">
                <b-table-simple bordered hover>
                    <b-thead>
                        <b-tr>
                            <b-th>№</b-th>
                            <b-th>Объекты</b-th>
                            <b-th>Уровень приоритета</b-th>
                            <b-th>ID Объекта</b-th>
                            <b-th>Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.) согласно программы ВУЗа</b-th>
                            <b-th>Сумма внебюджетного финансирования на проведение капитального ремонта (тыс. руб.) согласно программы ВУЗа</b-th>
                            <b-th>Статус МГСУ</b-th>
                            <b-th>Статус ДЕП</b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr v-for="(item, index) in rezerv_object" :key="index" @click="goToObj(item.id)">
                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ index + 1 }}</label>
                            </b-th>

                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ item.name }}</label>
                            </b-th>

                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ item.id_priority }}</label>
                            </b-th>

                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ item.id }}</label>
                            </b-th>
                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ item.finance_sum }}</label>
                            </b-th>


                            <b-th class="normal-font-weight-for-sell cursor-pointer center-text-in-cell">
                                <label class="cursor-pointer">{{ item.coFinancing }}</label>
                            </b-th>

                            <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ item.status }}</label>
                            </b-th>

                             <b-th class="normal-font-weight-for-sell center-text-in-cell cursor-pointer">
                                <label class="cursor-pointer">{{ getDepStatus(item.dep_status) }}</label>
                            </b-th>                           

                        </b-tr>
                    </b-tbody>
                </b-table-simple>

                <b-pagination v-show="currentPage" :per-page="perPage" v-model="currentPage" />
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import Axios from "axios";
import {
    BCard,
    BCardBody,
    BCardHeader, BBreadcrumb,
    BPagination, BTableSimple, BTbody, BTh, BThead, BTr
} from "bootstrap-vue";
export default {
    components:{
        BBreadcrumb,
        BCard,
        BCardHeader,
        BCardBody,
        BTableSimple,
        BThead,
        BTr,
        BTh,
        BTbody,
        BPagination,
    },
    data() {
        return {
            programm: {},
            currentPage: 1,
            perPage: 5,
            csrf: document.getElementsByName("csrf-token")[0].content,
            org_id: null,
            items: [],
            prioritet_object: [],
            rezerv_object: [],
            info: {
                budjet: null,
            }, 
            infoFromServ: null
        };
    },
    async mounted() {
        this.org_id = this.$route.params.id;
        await this.getCurentOrg();
    },
    computed: {
        waited_square() {
            return (
                ((parseFloat(this.programm.finance_volume) - parseFloat(this.programm.finance_events)) * 1000) /
                parseFloat(this.programm.cost)
            ).toFixed(2);
        }
    },
    methods: {

        async getCurentOrg() {
            return Axios.post(`/api/org-table/${this.org_id}`, null, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {

                this.prioritet_object = res.data.objects.filter(obj => {
                    return obj.type == '0'
                })
                this.rezerv_object = res.data.objects.filter(obj => {
                    return obj.type == '1'
                })

                let budjet = 0;

                res.data.objects.forEach(element => {
                    budjet += parseFloat(element.finance_sum)
                });

                this.info.budjet = budjet;
                
                this.infoFromServ = res.data.info

                this.items = res.data.objects;
                console.log(this.items)
                this.programm = res.data.programm;
            });
        },
        getDepStatus(str) {
            if (str === 'not') {
                return "В обработке";
            } else if (str === 'approved') {
                return "Рассмотрено Деп";
            } else if (str === 2) {
                return "Резерв";
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
        goToObj(id) {
            window.location = `/organization/obj/${id}`;
        }
    }
};
</script>

<style scoped>
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
