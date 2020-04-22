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
            },
            {
                text:this.items.name,
            },
        ]"/>
        <h1 class="mt-3">{{ this.items.name }}</h1>
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="vertical-horizontal-align">Текущий статус эксперта МОН: <label :class="`text-${status.variant}`">{{ status.label }}</label></h5>
            <h5 class="vertical-horizontal-align">Текущий статус ДЭП: <label :class="`text-${dep_status.color}`">{{ dep_status.label }}</label></h5>
            <h5 class="vertical-horizontal-align">Текущий статус ДКУ: <label :class="`text-${dku_status.color}`">{{ dku_status.label }}</label></h5>

            <b-dropdown v-can:mgsu right text="Изменить статус" id="action" variant="info" class="m-2">
                <b-dropdown-item :href="`/api/set-status/recomend/${obj_id}`" variant="success">Рекомендуется к согласованию</b-dropdown-item>
                <b-dropdown-item :href="`/api/set-status/not-recomend/${obj_id}`" variant="danger">Не рекомендуется к согласованию</b-dropdown-item>
                <b-dropdown-item :href="`/api/set-status/to-work/${obj_id}`" variant="warning">На доработку</b-dropdown-item>
            </b-dropdown>

            <!-- <h5 class="vertical-horizontal-align">Текущий статус ДЭП: <label :class="`text-${dep_status.color}`">{{ dep_status.label }}</label></h5> -->
            <b-dropdown :disabled="!show.dep" v-can:dep right id="action"  text="Изменить статус" variant="info" class="m-2">
                <b-dropdown-item :href="`/api/set-status/approved/dep/${obj_id}`" variant="success">Рассмотрено ДЭП</b-dropdown-item>
                <b-dropdown-item :href="`/api/set-status/rejected/dep/${obj_id}`" variant="warning">Резерв</b-dropdown-item>
            </b-dropdown>

            <!-- <h5 class="vertical-horizontal-align">Текущий статус ДКУ: <label :class="`text-${dku_status.color}`">{{ dku_status.label }}</label></h5> -->
            <b-dropdown :disabled="!show.dku"  v-can:dku right id="action"  text="Изменить статус" variant="info" class="m-2">
                <b-dropdown-item :href="`/api/set-status/approved/dku/${obj_id}`" variant="success">Согласовано ДКУ</b-dropdown-item>
                <b-dropdown-item :href="`/api/set-status/rejected/dku/${obj_id}`" variant="warning">Резерв</b-dropdown-item>
            </b-dropdown>
        </div>

        <v-comments :obj_id="obj_id" />

        <div class="mt-3">
                <div class="row">
                    <div class="col-12">
                        <b-alert v-for="(banner, index) in bannerInfo" :key="index" :show="banner.show" :variant="banner.variant" dismissible fade>{{ banner.message }}</b-alert>
                    </div>
                </div>
            </div>
        <b-table-simple bordered hover class="mt-3">
            <b-tbody>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>ID</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.id }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>ID организации</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ org_id }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Наименование организации</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.org_name }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Наименование</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.name }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Полный адрес объекта</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.address }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Назначение</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.assignment }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Общая площадь здания - всего, кв.м.</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.square }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Год постройки здания</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.year }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Износ</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ getIznos(this.items.wear) }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Примечание</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.note }}</label>
                    </b-th>
                </b-tr>
            </b-tbody>
        </b-table-simple>

        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-s>
                                <b-icon-gear-wide-connected />
                                Сведения два
                            </span>
            </b-card-header>
            <b-collapse id="accordion-s" accordion="my-accordion" role="tabpanel">
                <b-card-body style="overflow: auto">
                    <b-table-simple bordered>
                        <b-thead>
                            <b-tr>
                                <b-th></b-th>
                                <b-th>Этап</b-th>
                                <b-th>Дата начала (план.)</b-th>
                                <b-th>Дата окончания (план.)</b-th>
                                <b-th>Фактическая Стоимость реализации (тыс.руб.)</b-th>
                                <b-th>Фактическая Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.)</b-th>
                                <b-th>Фактическое Софинансирование из внебюджетных источников (тыс. руб.)</b-th>
                                <b-th>Отметка о завершении этапа </b-th>
                                <b-th>Комментарий (текстовое поле Заполняет ВУЗ)</b-th>
                                <b-th>Отметка Эксперта МОН (МГСУ) Принято / не принято</b-th>
                                <b-th>Комментарий эксперта МОН )</b-th>
                            </b-tr>
                        </b-thead>
                        <b-tbody>
                            <b-tr v-for="(item,index) in svedenia2" :key="index">
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    {{item.step + 1}}
                                </b-td>
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-form-input v-if="item.canDelete" v-model="svedenia2[index].step_name" />
                                    <span v-else>{{item.step_name}}</span>
                                </b-td>
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-form-input type="date" v-model="svedenia2[index].date_event_start" />
                                </b-td>
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-form-input type="date" v-model="svedenia2[index].date_event_end" />
                                </b-td>
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-form-input type="number" step=".01"  v-model="svedenia2[index].cost_real" />
                                </b-td>
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-form-input type="number" step=".01"  v-model="svedenia2[index].sum_bud_fin" />
                                </b-td>
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-form-input type="number" step=".01"  v-model="svedenia2[index].fin_vnebud_ist" />
                                </b-td>
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-form-checkbox v-model="svedenia2[index].done" />
                                </b-td>
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-form-input v-model="svedenia2[index].comment" />
                                </b-td>
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-form-checkbox v-model="svedenia2[index].doneExpert" />
                                </b-td>
                                <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-form-input v-model="svedenia2[index].commentExpert" />
                                </b-td>
                                <div v-else>
                                    <b-td>
                                        <b-button variant="danger" @click="deleteRow(index)">Удалить</b-button>
                                    </b-td>
                                    <b-td >
                                        <b-button variant="info" @click="addRow(index)">Добавить</b-button>
                                    </b-td>
                                </div>

                            </b-tr>

                        </b-tbody>

                    </b-table-simple>
                    <b-button @click="sendData">Сохранить</b-button>
                </b-card-body>
            </b-collapse>
        </b-card>

        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-2>
                                <b-icon-gear-wide-connected />
                                Сведения о планируемых мероприятиях</span
                            >
            </b-card-header>
            <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-table bordered :fields="svedenia.fields" :items="svedenia.items" />
                </b-card-body>
            </b-collapse>
        </b-card>
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-3>
                                <b-icon-gear-wide-connected />
                                Обоснование необходимости (целесообразности) планируемых мероприятий</span
                            >
            </b-card-header>
            <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel" visible>
                <b-card-body>
                    <b-table bordered :fields="necessary.fields.one" :items="necessary.items.one" />
                    <b-table bordered :fields="necessary.fields.two" :items="necessary.items.two" />
                </b-card-body>
            </b-collapse>
        </b-card>
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-4>
                                <b-icon-gear-wide-connected />
                                Ожидаемые результаты</span
                            >
            </b-card-header>
            <b-collapse id="accordion-4" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-table bordered :fields="waited.fields" :items="waited.items" />
                </b-card-body>
            </b-collapse>
        </b-card>
        <b-card no-body class="mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-5>
                                <b-icon-gear-wide-connected />
                                Прогнозируемые риски</span
                            >
            </b-card-header>
            <b-collapse id="accordion-5" accordion="my-accordion" role="tabpanel">
                <b-card-body>
                    <b-table bordered :fields="risks.fields" :items="risks.items" />
                </b-card-body>
            </b-collapse>
        </b-card>

        <b-card no-body>
            <b-card-header header-tag="header" class="p-1" role="tab">
                <span> <b-icon icon="document-text" scale="1.5" class="mr-2 ml-1"></b-icon>Загруженные документы</span>
            </b-card-header>
            <b-card-body>
                <div  v-if="docs.length">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Файл</th>
                        </tr>
                        </thead>

                        <tr v-for="(doc, index) in docs" :key="index">
                            <td>{{doc.label}}</td>
                            <td><a :href="`/program/object/download-doc/${obj_id}?id=${doc.id}`">{{doc.name }}.pdf</a></td>
                        </tr>
                    </table>
                    <a class="btn btn-danger" target="_blank" :href="`/program/object/zip/${obj_id}`">Скачать архивом</a>
                </div>
                <div v-else>
                    <label>Документы отсутствуют</label>
                </div>
            </b-card-body>
        </b-card>

    </div>
</template>

<script>
import Axios from "axios";
import { CommentComponent } from "../../../organisms";
import {mapActions, mapGetters} from "vuex";
import {
    BAlert,
    BCard,
    BCardHeader,
    BCollapse,
    BCardBody,
    BTableSimple,
    BTr,
    BTh,
    BTd,
    BButton,
    BFormInput,
    BThead,
    BTbody,
    BDropdown,
    BDropdownItem,
    BTable,
    BBreadcrumb,
    BFormCheckbox,
    VBToggle,
} from 'bootstrap-vue'
export default {
    directives:{
        'b-toggle':VBToggle
    },
    components: {
        "v-comments": CommentComponent,
        BAlert,
        BBreadcrumb,
        BCollapse,
        BTableSimple,
        BTr,
        BTh,
        BThead,
        BTbody,
        BDropdown,
        BDropdownItem,
        BTable,
        BCard,
        BButton,
        BCardHeader,
        BFormCheckbox,
        BCardBody,
        BTd,
        BFormInput
    },
    data() {
        return {
            bannerInfo: [],
            status: {
                label: '',
                variant: ''
            },
            dep_status: {
                label: null,
                color: null
            },
            dku_status: {
                label: null,
                color: null
            },
            show: {
                dep: false,
                dku: false
            },
            csrf: document.getElementsByName("csrf-token")[0].content,
            items: [],
            obj_id: null,
            org_id: null,
            user_id: null,
            docs: [],
            fromServer:{},
            svedenia2:[

                    {
                        canDelete:false,
                        step:0,
                        id_event:null,
                        step_name:'Проведение тендера и заключение договора на выполнение обследования',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:true
                    },
                {
                    canDelete:false,
                    step:0.1,
                    id_event:null,
                    step_name:'Внесение пользователем закупки на обследование объекта в план закупок ',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:false
                },
                {
                    canDelete:false,
                    step:0.2,
                    id_event:null,
                    step_name:'Объявление пользователем аукциона на обследование объекта',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:false
                },
                {
                    canDelete:false,
                    step:0.3,
                    id_event:null,
                    step_name:'Определение подрядчика по результату аукциона',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:false
                },
                {
                    canDelete:false,
                    step:0.4,
                    id_event:null,
                    step_name:'Заключение договора с подрядчиком',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:false
                },
                {
                    canDelete:false,
                    button:true,
                    button_name:'Добавить'
                },
                {
                    canDelete:false,
                    step:1,
                    id_event:null,
                    step_name:'Выполнение обследования, подготовка и утверждение дефектного акта (дефектной ведомости). ',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:true
                },
                {
                    canDelete:false,
                    button:true,
                    button_name:'Добавить'
                },
                {
                    canDelete:false,
                    step:2,
                    id_event:null,
                    step_name:'Утверждение задания на проектирование ',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:true
                },
                {
                    canDelete:false,
                    button:true,
                    button_name:'Добавить'
                },
                {
                    canDelete:false,
                    step:3,
                    id_event:null,
                    step_name:'Проведение тендера и заключение договора на подготовку проектно-сметной документации.',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:true
                },
                {
                    canDelete:false,
                    step:3.1,
                    id_event:null,
                    step_name:'Внесение пользователем закупки на обследование объекта в план закупок ',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:false
                },
                {
                    canDelete:false,
                    step:3.2,
                    id_event:null,
                    step_name:'Объявление пользователем аукциона на обследование объекта',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:false
                },
                {
                    canDelete:false,
                    step:3.3,
                    id_event:null,
                    step_name:'Определение подрядчика по результату аукциона',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:false
                },
                {
                    canDelete:false,
                    step:3.4,
                    id_event:null,
                    step_name:'Заключение договора с подрядчиком',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:false
                },
                {
                    canDelete:false,
                    button:true,
                    button_name:'Добавить'
                },
                {
                    canDelete:false,
                    step:4,
                    id_event:null,
                    step_name:'Подготовка проектно-сметной документации.',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:true
                },
                {
                    canDelete:false,
                    button:true,
                    button_name:'Добавить'
                },
                {
                    canDelete:false,
                    step:5,
                    id_event:null,
                    step_name:'Прохождение экспертизы проектно-сметной документации.',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:true
                },
                {
                    canDelete:false,
                    button:true,
                    button_name:'Добавить'
                },
                {
                    canDelete:false,
                    step:6,
                    id_event:null,
                    step_name:'Проведение тендера и заключение договора на выполнение строительно-монтажных работ.',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:true
                },
                {
                    canDelete:false,
                    button:true,
                    button_name:'Добавить'
                },
                {
                    canDelete:false,
                    step:8,
                    id_event:null,
                    step_name:'Выполнение строительно-монтажных работ.',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:true
                },
                {
                    canDelete:false,
                    button:true,
                    button_name:'Добавить'
                }


            ],
            svedenia: {
                labels: [
                    'Проведение тендера и заключение договора на выполнение обследования',
                    'Выполнение обследования, подготовка и утверждение дефектного акта',
                    'Утверждение задания на проектирование',
                    'Проведение тендера и заключение договора на подготовку проектно-сметной документации',
                    'Подготовка проектно-сметной документации',
                    'Прохождение экспертизы проектно-сметной документации',
                    'Проведение тендера и заключение договора на выполнение строительно-монтажных работ',
                    'Выполнение строительно-монтажных работ'
                ],
                items:[],
                fields:[
                    {key:'index',label:'№'},
                    {key:'step',label:'Этап'},
                    {key:'is_nessesary',label:'Необходимость выполнения'},
                    {key:'date_event_start',label:'Дата начала'},
                    {key:'date_event_end',label:'Дата окончания'},
                    {key:'cost_real',label:'Стоимость реализации (тыс.руб)'},
                    {key:'sum_bud_fin',label:'Сумма бюджетного финансирования на проведение кап.ремонта (тыс.руб)'},
                    {key:'fin_vnebud_ist',label:'Софинансирование из внебюджетных источников (тыс.руб)'},
                ]
            },
            necessary: {
                labels:[
                    'Фундаменты',
                    'Отмостка',
                    'Стены ',
                    'Колонны',
                    'Перегородки',
                    'Крыша (покрытия)',
                    'Кровля',
                    'Перекрытия',
                    'Полы',
                    'Окна',
                    'Двери',
                    'Ворота',
                    'Лестницы',
                    'Крыльца',
                    'Балконы/лоджии',
                    'Внутренняя отделка',
                    'Наружная отделка',
                    'Система электроснабжения',
                    'Система водоснабжения',
                    'Система водоотведения',
                    'Система газоснабжения',
                    'Система кондиционирования воздуха',
                    'Система вентиляции',
                    'Система отопления',
                    'Система диспетчеризации',
                    'Радиофикация',
                    'Телевидение эфирное',
                    'Система видеонаблюдения',
                    'Система интернет и телефонии',
                    'Система контроля управления доступом',
                    'Пожарная сигнализация',
                    'Охранная сигнализация',
                    'Мусоропроводы',
                    'Лифты',
                ],
                items:{
                    one:[],
                    two:[]
                },
                fields:{
                    one:[
                        {key:'element',label:'Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте'},
                        {key:'nalichie',label:'Наличие на объекте'},
                        {key:'material',label:'Материал конструкции'},
                        {key:'srok_eks',label:'Срок эксплуатации с момента строительства или предыдущего капитального ремонта'},
                        {key:'kap_remont',label:'Требуется капитальный ремонт'},
                        {key:'obosnovanie',label:'Обоснование необходимости'},
                    ],
                    two:[
                        {key:'element',label:'Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте'},
                        {key:'nalichie',label:'Наличие на объекте'},
                        {key:'srok_eks',label:'Срок эксплуатации с момента строительства или предыдущего капитального ремонта'},
                        {key:'kap_remont',label:'Требуется капитальный ремонт'},
                        {key:'obosnovanie',label:'Обоснование необходимости'},
                    ]
                }
            },
            waited:{
                fields:[
                    {key:'aim',label:'Цели и задачи'},
                    {key:'plan',label:'Планируемый показатель'},
                    {key:'changes',label:'Единица измерения'},
                ],
                items:[]
            },
            risks:{
                fields:[
                    {key:'types',label:'Виды рисков'},
                    {key:'poison',label:'Отрицательные влияния'},
                    {key:'protect',label:'Способы защиты'},
                ],
                items:[]
            }
        };
    },
    computed: {
        ...mapGetters(['getUser']),
    },
    async mounted() {
        this.obj_id = this.$route.params.id;
        await this.requestUser();
        await this.getStatus();
        this.user_id = this.getUser.organization.id;
        await this.getObject();

        let actionElement = document.querySelector('#action');
        actionElement?.addEventListener('click', event => {this.actionHendler(event)})
    },
    methods: {
        ...mapActions(['requestUser']),
        sendData(event){
          let data = JSON.stringify(this.svedenia2);
          Axios.post(`/program/object/send-event/${this.obj_id}`,data,{
              headers: {
                  "X-CSRF-Token": this.csrf
              }
          }).then(response=>console.log(response.data))
        },
        addRow(index){
            this.svedenia2.splice(index,0,{
                step:this.svedenia2[index-1].step+0.1 ,
                id_event:null,
                step_name:'',
                date_event_start: null,
                date_event_end: null,
                cost_real:null,
                sum_bud_fin:null,
                fin_vnebud_ist:null,
                is_nessesary: null,
                done:false,
                doneExpert:false,
                comment:'',
                commentExpert:'',
                parent:false,
                canDelete:true,
            });
        },
        deleteRow(index){
            if (this.svedenia2[index-1].canDelete)
                this.svedenia2.splice(index-1,1);
        },
        actionHendler(event) {
            event.preventDefault();
            if(document.querySelector(`#user_${window.currentUser}`)) {
                window.location = event.target.href
            } else {
                this.setBanner('danger', 'Сначала добавте комментарий!')
            }
        },
        setBanner(variant, message) {
            this.bannerInfo.unshift({
                show: true,
                variant: variant,
                message: message
            });
            setTimeout(() => {
                this.resetBanners();
            }, 1500);
        },
        resetBanners() {
            this.bannerInfo.pop();
        },
        getEl(arr,index){
            let el = null;
            arr.forEach(item=>{
                if (item.element == index) {
                    el = item;
                    return false;
                }
            });
            return el;
        },
        async getStatus() {
            Axios.get(`/api/get-status/${this.obj_id}`).then((res) =>{
                this.status.label = res.data.label;
                
                let dep = res.data.dep_status;
                if(dep === 'not') {
                    this.dep_status.label = 'В обработке';
                    this.dep_status.color = 'secondary'
                } else if(dep === 'approved') {
                    this.dep_status.label = 'Рассмотрено ДЭП';
                    this.dep_status.color = 'success'
                } else if(dep === 'rejected') {
                    this.dep_status.label = 'Резерв';
                    this.dep_status.color = 'warning'
                }

                let dku = res.data.dku_status;
                if(dku === 'not') {
                    this.dku_status.label = 'В обработке';
                    this.dku_status.color = 'secondary'
                } else if(dku === 'approved') {
                    this.dku_status.label = 'Согласовано ДКУ';
                    this.dku_status.color = 'success'
                } else if(dku === 'rejected') {
                    this.dku_status.label = 'Резерв';
                    this.dku_status.color = 'warning'
                }

                if(res.data.id === 2) {
                    this.show.dep = true
                }
                if(res.data.dep_status === 'approved') {
                    this.show.dku = true
                }


                let color = '';
                if(res.data.id == 1) {
                    color = 'secondary'
                } else if (res.data.id == 2) {
                    color = 'success'
                } else if (res.data.id == 3) {
                    color = 'danger'
                } else if (res.data.id == 4) {
                    color = 'warning'
                }
                this.status.variant = color;
            })
        },
        getObject(){
            Axios.get(`/api/get-object/${this.obj_id}`).then(res=>{
                this.fromServer = JSON.parse(res.data);
                console.log(this.fromServer);
                this.items = this.fromServer.object;
                this.items.org_name = this.fromServer.organization.name;
                this.docs = this.fromServer.docs;
                this.org_id = JSON.parse(res.data).org_id;

                let c=0.0, v=0.0,b=0.0;
                this.fromServer.svedenia.forEach((item,index)=>{
                    c+=Number(item.cost_real);
                    v+=Number(item.sum_bud_fin);
                    b+=Number(item.fin_vnebud_ist);
                    this.svedenia.items.push({
                        index:index+1,
                        step:this.svedenia.labels[index],
                        id:item.id,
                        is_nessesary:item.item.is_nessesary ? 'Да' : 'Нет',
                        date_event_start:item.item.date_event_start,
                        date_event_end:item.item.date_event_end,
                        cost_real:item.item.cost_real,
                        sum_bud_fin:item.item.sum_bud_fin,
                        fin_vnebud_ist:item.item.fin_vnebud_ist,
                    })
                });
                this.svedenia.items.push({
                    step:'Готово',
                    cost_real:c.toFixed(3),
                    sum_bud_fin:v.toFixed(3),
                    fin_vnebud_ist:b.toFixed(3),
                });
                this.necessary.labels.forEach((item,index)=>{
                    let el = this.getEl(this.fromServer.necessary,index);
                    if (!el) {
                        if (index < 17) {
                            this.necessary.items.one.push({
                                element: item,
                                nalichie: null,
                                material: null,
                                srok_eks: null,
                                kap_remont: null,
                                obosnovanie: null,
                            })
                        }
                        else{
                            this.necessary.items.two.push({
                                element: item,
                                nalichie: null,
                                srok_eks: null,
                                kap_remont: null,
                                obosnovanie: null,
                            })
                        }
                    }else {
                        if (index < 17) {
                            this.necessary.items.one.push({
                                element: item,
                                nalichie: el.nalichie == '1' ? 'Да' : 'Нет',
                                material: el.nalichie == '1' ? el.material : '',
                                srok_eks: el.nalichie == '1' ? el.srok_eks : '',
                                kap_remont: el.nalichie == '1' ? el.kap_remont ? 'Да' : 'Нет' : '',
                                obosnovanie: el.nalichie == '1' ? el.kap_remont ? item.obosnovanie : '' : '',
                            })

                        } else {
                            this.necessary.items.two.push({
                                element: item,
                                nalichie: el.nalichie == '1' ? 'Да' : 'Нет',
                                srok_eks: el.nalichie == '1' ? el.srok_eks : '',
                                kap_remont: el.nalichie == '1' ? el.kap_remont ? 'Да' : 'Нет' : '',
                                obosnovanie: el.nalichie == '1' ? el.kap_remont ? el.obosnovanie : '' : '',
                            })

                        }
                    }
                });
                let w0 = this.getEl(this.fromServer.waited,0);
                let w1 = this.getEl(this.fromServer.waited,1);
                let w2 = this.getEl(this.fromServer.waited,2);
                let w3 = this.getEl(this.fromServer.waited,3);
                let w4 = this.getEl(this.fromServer.waited,4);
                this.waited.items.push({
                    aim:'Проведение капитального ремонта, общая площадь',
                    plan:w0.plan,
                    changes:'кв.м'
                });
                this.waited.items.push({
                    aim:'Вовлечение в хозяйственную деятельность за счет проведенного капитального ремонта, общая площадь',
                    plan:w1.plan,
                    changes:'кв.м'
                });
                this.waited.items.push({
                    aim:'Снижение затрат на эксплуатацию',
                    plan:w2.plan == '1' ? 'Да' : 'Нет',
                    changes:''
                });
                this.waited.items.push({
                    aim:'Повышение энергоэффективности',
                    plan:w3.plan == '1' ? 'Да' : 'Нет',
                    changes:''
                });
                this.waited.items.push({
                    aim:'Восстановление (ремонт, реставрация, за исключением реконструкции) объектов культурного наследия',
                    plan:w4.plan == '1' ? 'Да' : 'Нет',
                    changes:''
                });
                for (let i = 5; i<this.fromServer.waited.length;i++){
                    let el = this.fromServer.waited[i];
                    this.waited.items.push({
                        aim:el.aim,
                        plan:el.plan,
                        changes:el.changes
                    });
                }
                if (this.fromServer.risks) {
                    this.fromServer.risks.forEach(item => {
                        this.risks.items.push({
                            types: item.types,
                            poison: item.poison,
                            protect: item.protect,
                        });
                    });
                }


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
        }
    }
};
</script>

<style>
.normal-font-weight-for-sell {
    font-weight: normal !important;
}
.vertical-horizontal-align {
    vertical-align: middle !important;
    text-align: center;
}
</style>