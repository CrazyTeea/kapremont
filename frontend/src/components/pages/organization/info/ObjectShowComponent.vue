<template>
    <div>
        <h1 class="mt-3">{{ this.items.name }}</h1>
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="vertcal-gorizontal-align">Текущий статус: <label :class="`text-${status.variant}`">{{ status.label }}</label></h3>
            <b-dropdown id="dropdown-left" right  text="Изменить статус" variant="info" class="m-2">
                <b-dropdown-item :href="`/api/set-status/recomend/${obj_id}`" variant="success">Рекомендуется к согласованию</b-dropdown-item>
                <b-dropdown-item :href="`/api/set-status/not-recomend/${obj_id}`" variant="danger">Не рекомендуется к согласованию</b-dropdown-item>
                <b-dropdown-item :href="`/api/set-status/to-work/${obj_id}`" variant="warning">На доработку</b-dropdown-item>
            </b-dropdown>
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
        <v-comments :obj_id="obj_id" />
    </div>
</template>

<script>
import Axios from "axios";
import { CommentComponent } from "../../../organisms";
import {mapActions, mapGetters} from "vuex";
export default {
    components: {
        "v-comments": CommentComponent
    },
    data() {
        return {
            status: {
                label: '',
                variant: ''
            },
            csrf: document.getElementsByName("csrf-token")[0].content,
            items: [],
            obj_id: null,
            user_id: null,
            docs: [],
            fromServer:{},
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

        // console.log(this.obj_id)
        //await this.getObject2();
    },
    methods: {
        actionStatus() {
            console.log('выбран экшн')
        },
        ...mapActions(['requestUser']),
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
                let color = '';
                if(res.data.id == 1) {
                    color = 'secondary'
                } else if (res.data.id == 2) {
                    color = 'success'
                } else if (res.data.id == 3) {
                    color = 'danger'
                } else if (res.data.id == 4) {
                    color = 'warning '
                }
                this.status.variant = color;
                console.log(res)
            })
        },
        getObject(){
            Axios.get(`/api/get-object/${this.obj_id}`).then(res=>{
                this.fromServer = JSON.parse(res.data);
                this.items = this.fromServer.object;
                this.items.org_name = this.fromServer.organization.name;
                this.docs = this.fromServer.docs;


                let c=0.0, v=0.0,b=0.0;
                this.fromServer.svedenia.forEach((item,index)=>{
                    c+=Number(item.cost_real);
                    v+=Number(item.sum_bud_fin);
                    b+=Number(item.fin_vnebud_ist);
                    this.svedenia.items.push({
                        index:index+1,
                        step:this.svedenia.labels[index],
                        is_nessesary:item.is_nessesary ? 'Да' : 'Нет',
                        date_event_start:item.date_event_start,
                        date_event_end:item.date_event_end,
                        cost_real:item.cost_real,
                        sum_bud_fin:item.sum_bud_fin,
                        fin_vnebud_ist:item.fin_vnebud_ist,
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
.vertcal-gorizontal-align {
    vertical-align: middle !important;
    text-align: center;
}
</style>