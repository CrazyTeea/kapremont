<template>
    <div>
        <h1 class="mt-3">{{ this.items.poname }}</h1>
        <b-table-simple bordered hover class="mt-5">
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
                        <label>{{ this.items.name }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Наименование</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.poname }}</label>
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
                    <b-table-simple bordered hover>
                        <b-thead>
                            <b-tr>
                                <b-th
                                    >Строительные конструкции замена и (или) восстановление
                                    которых планируются при капитальном ремонте</b-th
                                >
                                <b-th>Наличие на объекте</b-th>
                                <b-th>Материал конструкции</b-th>
                                <b-th
                                    >Срок эксплуатации с момента строительства или
                                    предыдущего капитального ремонта</b-th
                                >
                                <b-th>Требуется капитальный ремонт</b-th>
                                <b-th>Обоснование необходимости</b-th>
                            </b-tr>
                        </b-thead>
                        <b-tbody>
                            <b-tr v-for="(item, index) in necessary.labels" :key="index">
                                <b-th>{{ item }}</b-th>
                                <b-th>{{ item.nalichie }}</b-th>

                            </b-tr>
                        </b-tbody>
                    </b-table-simple>
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
                    <b-table-simple bordered hover>
                        <b-thead>
                            <b-tr>
                                <b-th>Цели и задачи</b-th>
                                <b-th>Планируемый показатель</b-th>
                                <b-th>Единица измерения</b-th>
                            </b-tr>
                        </b-thead>
                        <b-tbody>
                            <b-tr v-for="(item, index) in waited.items" :key="index">
                                <b-th class="normal-font-weight-for-sell">{{ item.label }}</b-th>
                                <b-th class="normal-font-weight-for-sell">{{ item.plan }}</b-th>
                                <b-th class="normal-font-weight-for-sell">{{ item.changes }}</b-th>
                            </b-tr>
                        </b-tbody>
                    </b-table-simple>
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
                    <b-table-simple bordered hover>
                        <b-thead>
                            <b-tr>
                                <b-th>Виды рисков</b-th>
                                <b-th>Отрицательные влияния</b-th>
                                <b-th>Способы защиты</b-th>
                            </b-tr>
                        </b-thead>
                        <b-tbody>
                            <b-tr v-for="(item, index) in riscs.fromServer" :key="index">
                                <b-th class="normal-font-weight-for-sell">{{ item.types }}</b-th>
                                <b-th class="normal-font-weight-for-sell">{{ item.poison }}</b-th>
                                <b-th class="normal-font-weight-for-sell">{{ item.protect }}</b-th>
                            </b-tr>
                        </b-tbody>
                    </b-table-simple>
                </b-card-body>
            </b-collapse>
        </b-card>

        <b-card no-body>
            <b-card-header header-tag="header" class="p-1" role="tab">
                <span> <b-icon icon="document-text" scale="1.5" class="mr-2 ml-1"></b-icon>Загруженные документы</span>
            </b-card-header>
            <b-card-body>
                <div v-if="docs.length">
                    <ul>
                        <li v-for="(doc, index) in docs" :key="index">
                            <a :href="`/program/object/download-doc/${obj_id}?id=${doc.id}`">{{ doc.name }}.pdf</a>
                        </li>
                    </ul>
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

            csrf: document.getElementsByName("csrf-token")[0].content,
            items: [],
            obj_id: null,
            user_id: null,
            docs: [],
            docItems:{},
            descriptors:[
                {
                    inv_card: "Инвентарные карточки учета основных средств на объект недвижимого имущества и на земельный участок под указанным объектом",
                },
                {
                    reestr_vip:"Выписка из реестра федерального имущества на объект федерального имущества и на земельный участок под указанным объектом",
                },
                {
                    pravust: "Правоустанавливающие и (или) правоудостоверяющие документы на объект недвижимого имущества и на земельный участок под указанным объектом",
                },
                {
                    tex_kad_docs: "Документы технического и кадастрового учета на объект недвижимого имущества",
                },
                {
                    sit_plan:"Ситуационный план с указанием границ земельного участка, объекта недвижимого имущества и иных объектов (включая незавершенные строительные объекты), принадлежащих третьим лицам, расположенных на указанном земельном участке",
                },
                {
                    tex_acts: "Акт технического осмотра объекта капитального строительства (документ, содержащий сведения о результатах обследования объекта капитального строительства, техническом состоянии строительных конструкций и инженерного оборудования такого объекта и количественной оценке фактических показателей качества строительных конструкций и инженерного оборудования по состоянию на дату обследования, для определения состава, объёмов и сроков работ по капитальному ремонту объекта капитального строительства)"
                },
                {
                    def_ved: "Дефектная ведомость (первичный учётный документ, подготовленный в соответствии с требованиями законодательства Российской Федерации о бухгалтерском учёте по результатам обследования технического состояния объекта капитального строительства и содержащий перечень дефектов строительных конструкций и инженерного оборудования объекта капитального строительства с указанием качественных и количественных характеристик таких дефектов)"
                },
                {
                    obj_photos:
                        "Фотографии объекта, предполагаемого к проведению капитального ремонта (подписанные по 2 шт. на листе А4, но не более 10 шт. на объект недвижимости)",
                },
                {
                    predpis: "Предписания надзорных органов (при наличии)"
                },
                {
                    proekti: "Задание на проектирование (корректировку проектной документации), составленное в соответствии с рекомендациями Минстроя РФ (в случае разработки/корректировки проектной документации и/или направления данной документации на экспертизу)"
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
                fromServer:{},
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
                labels: [
                    "Фундаменты",
                    "Отмостка",
                    "Стены",
                    "Колонны",
                    "Перегородки",
                    "Крыша",
                    "Кровля",
                    "Перекрытия",
                    "Полы",
                    "Окна",
                    "Двери",
                    "Ворота",
                    "Лестницы",
                    "Крыльца",
                    "Балконы/Лоджии",
                    "Внутренняя отделка",
                    "Наружняя отделка",
                    "Система электроснабжения",
                    "Система водоснабжения",
                    "Система водоотведения",
                    "Система газоснабжения",
                    "Система кондиционирования воздуха",
                    "Система вентиляции",
                    "Система отопления",
                    "Система диспетчеризации",
                    "Радиофикация",
                    "Телевидение эфирное",
                    "Система видеонаблюдения",
                    "Система интернет и телефонии",
                    "Система контроля управления доступом",
                    "Пожарная сигнализация",
                    "Охранная сигнализация",
                    "Мусоропроводы",
                    "Лифты"
                ],
                fromServer:{},
                items:[],
            },
            waited: {
                labels: [
                    "Проведение капитального ремонта, общая площадь",
                    "Вовлечение в хозяйственную деятельность за счет проведенного капитального ремонта, общая площадь",
                    "Снижение затрат на эксплуатацию",
                    "Повышение энергоэффективности",
                    "Восстановление (ремонт, реставрация, за исключением реконструкции) объектов культурного наследия",
                ],
                fromServer:{},
                items:[],
            },
            riscs: {
                fromServer:{}
            }
        };
    },
    computed: {
        ...mapGetters(['getUser']),
    },
    async mounted() {
        this.obj_id = this.$route.params.id;
        await this.requestUser();
        this.user_id = this.getUser.organization.id;
        await this.getObject();
        await this.getObject2();
    },
    methods: {
        ...mapActions(['requestUser']),
        getObject2(){
            Axios.get(`/api/get-object/${this.obj_id}`).then(res=>{
                this.svedenia.fromServer = JSON.parse(res.data);
                this.svedenia.fromServer = this.svedenia.fromServer.svedenia;
                let c=0.0, v=0.0,b=0.0;
                this.svedenia.fromServer.forEach((item,index)=>{
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
                })



                // this.necessary.fromServer = JSON.parse(res.data).necessary
                // console.log(this.necessary.fromServer)

                // this.necessary.labels.forEach((item, index)=>{
                //     this.necessary.items.push({
                //         label: item,
                //         nalichie: (index) => {return index}, 
                //     })
                    
                // })
                // console.log(this.necessary.items)


                this.waited.fromServer = JSON.parse(res.data).waited;
                this.waited.fromServer.forEach((item, index) => {
                    if( index > 1 && index < 5 ) {
                        this.waited.items.push({
                            label: this.waited.labels[index] || this.waited.fromServer[index].aim,
                            plan: this.waited.fromServer[index].plan ? 'да' : 'нет',
                            changes: this.waited.fromServer[index].changes
                        })
                    } else {
                        this.waited.items.push({
                            label: this.waited.labels[index] || this.waited.fromServer[index].aim,
                            plan: this.waited.fromServer[index].plan,
                            changes: this.waited.fromServer[index].changes
                        })
                    }
                })
                this.riscs.fromServer = JSON.parse(res.data).risks
            });
        },
        getKeyByElementValue(num) {

        },
        getObject() {
            Axios.post(`/api/object/${this.obj_id}`, null, {
                headers: {
                    "X-CSRF-Token": this.csrf
                }
            }).then(res => {
                this.items = res.data.obj[0];
                this.docs = res.data.docs;

                this.docs.forEach((item, index) => {
                    let descVal = item.descriptor
                    
                });
                this.getValueByDescriptor('sit_plan')    
                console.log(this.docItems)
            });
        },
        getValueByDescriptor(val) {
            for(let item in this.descriptors) {
                if(Object.keys(this.descriptors[item])[0] == val) {
                    console.log(item[val])
                }
                // console.log(Object.keys(this.descriptors[item])[0])
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
        }
    }
};
</script>

<style>
.normal-font-weight-for-sell {
    font-weight: normal !important;
}
</style>