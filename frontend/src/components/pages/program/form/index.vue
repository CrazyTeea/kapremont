<!--suppress ALL -->
<template>
    <div class="program_object_form">
        <b-form id="object_form" @submit="onSubmit" @reset="onReset" method="post">
            <div class="row">

                <div class="col-12">
                    <v-user-panel/>
                </div>
            </div>
            <input id="hidden" name="_csrf" v-model="csrf" type='hidden' />
            <div class="row mt-3">
                <div class="col-12">
                    <b-form-group
                            id="fieldset-1"
                            label="Название объекта"
                            label-for="input-1"
                            :invalid-feedback="(feedback('ProgramObjects','name','Название объекта должно быть заполнено'))"
                            :valid-feedback="(feedback('ProgramObjects','name',' '))"
                            :state="feedback('ProgramObjects','name')"
                    >
                        <b-form-input placeholder="Название..."
                                      id="name" name="ProgramObjects[name]"
                                      v-model="formData.name"
                        />
                    </b-form-group>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                       <span class="toggle_button" v-b-toggle.accordion-1>
                           <b-icon-gear-wide-connected />
                           Характеристика объекта
                       </span>
                        </b-card-header>
                        <b-collapse id="accordion-1"  accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <b-form-group>
                                    <b-form-group
                                            label="Тип объекта:"
                                            label-for="type"
                                            :invalid-feedback="(feedback('ProgramObjects','type','Тип объекта должен быть заполнен'))"
                                            :valid-feedback="(feedback('ProgramObjects','type',' '))"
                                            :state="feedback('ProgramObjects','type')"
                                    >
                                        <b-form-input style="display: none" id="type" v-model="formData.type" name="ProgramObjects[type]" />
                                        <v-select2 v-model="formData.type"
                                                   :options="[
                                                   {id:0,type:'Приоритетный'},
                                                   {id:1,type:'Резервный'}
                                               ]"
                                                   :reduce="type => type.id"
                                                   label="type"
                                                   id="type"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Субъект РФ:"
                                            label-for="id_region"
                                            :invalid-feedback="(feedback('ProgramObjects','id_region','Регион должен быть заполнен'))"
                                            :valid-feedback="(feedback('ProgramObjects','id_region',' '))"
                                            :state="feedback('ProgramObjects','id_region')"
                                    >
                                        <b-form-input style="display: none"
                                                      id="id_region"
                                                      v-model="formData.id_region"
                                                      name="ProgramObjects[id_region]" />
                                        <v-select2 v-model="formData.id_region"
                                                   :options="getRegions"
                                                   :reduce="region => region.id"
                                                   label="region"
                                                   id="id_region"
                                                   @input="onChangeRegion({id:formData.id_region})"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Город:"
                                            label-for="id_city"
                                            :invalid-feedback="(feedback('ProgramObjects','id_city','Город должен быть заполнен'))"
                                            :valid-feedback="(feedback('ProgramObjects','id_city',' '))"
                                            :state="feedback('ProgramObjects','id_city')"
                                    >

                                        <b-form-input style="display: none" id="id_city" v-model="formData.id_city" name="ProgramObjects[id_city]" />
                                        <v-select2 v-model="formData.id_city"
                                                   :options="getCities || [{city:'Выберите регион',id:null}]"
                                                   :reduce="city => city.id"
                                                   label="city"
                                                   id="id_city"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Кадастровый номер:"
                                            label-for="kad_number"
                                            :invalid-feedback="(feedback('ProgramObjects','kad_number','Кадастровый номер обязателен для заполнения и должен содержать цифры и :'))"
                                            :valid-feedback="(feedback('ProgramObjects','kad_number',' '))"
                                            :state="(feedback('ProgramObjects','kad_number') && kad_number_validator)"
                                    >
                                        <b-form-input
                                                id="kad_number"
                                                name="ProgramObjects[kad_number]"
                                                v-model="formData.kad_number"
                                                trim
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Год постройки здания:"
                                            label-for="year"
                                            :invalid-feedback="(feedback('ProgramObjects','year','Введите год:'))"
                                            :valid-feedback="(feedback('ProgramObjects','year',' '))"
                                            :state="(feedback('ProgramObjects','year') && con_year_validator)"
                                    >
                                        <b-form-input id="year" name="ProgramObjects[year]" type="number" v-model="formData.year"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Год ввода здания в эксплуатацию:"
                                            label-for="exploit_year"
                                            :invalid-feedback="(feedback('ProgramObjects','exploit_year','Введите год :'))"
                                            :valid-feedback="(feedback('ProgramObjects','exploit_year',' '))"
                                            :state="(feedback('ProgramObjects','exploit_year') && exp_year_validator)"
                                    >
                                        <b-form-input id="exploit_year" name="ProgramObjects[exploit_year]" type="number" v-model="formData.exploit_year"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Наличие предписаний надзорных органов:"
                                            label-for="exist_pred_nadz_orgs"
                                            :invalid-feedback="(feedback('ProgramObjects','exist_pred_nadz_orgs','Введите Наличие предписаний надзорных органов :'))"
                                            :valid-feedback="(feedback('ProgramObjects','exist_pred_nadz_orgs',' '))"
                                            :state="feedback('ProgramObjects','exist_pred_nadz_orgs')"
                                    >
                                        <b-form-input id="exist_pred_nadz_orgs" name="ProgramObjects[exist_pred_nadz_orgs]" v-model="formData.exist_pred_nadz_orgs"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Износ здания (%):"
                                            label-for="wear"
                                            :invalid-feedback="(feedback('ProgramObjects','wear','Износ здания должен быть меньше 100 (%)'))"
                                            :valid-feedback="(feedback('ProgramObjects','wear',' '))"
                                            :state="(feedback('ProgramObjects','wear') && wear_validator)"
                                    >
                                        <b-form-input id="wear" name="ProgramObjects[wear]" :state="wear_validator" type="number" v-model="formData.wear"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Основание для использования здания:"
                                            label-for="osn_isp_zdan"
                                            :invalid-feedback="(feedback('ProgramObjects','osn_isp_zdan','Введите Основание для использования здания'))"
                                            :valid-feedback="(feedback('ProgramObjects','osn_isp_zdan',' '))"
                                            :state="feedback('ProgramObjects','osn_isp_zdan')"
                                    >
                                        <b-form-input id="osn_isp_zdan" name="ProgramObjects[osn_isp_zdan]" v-model="formData.osn_isp_zdan"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Право оперативного управления (рег. запись, номер):"
                                            label-for="prav_oper_upr"
                                            :invalid-feedback="(feedback('ProgramObjects','prav_oper_upr','Введите Право оперативного управления (рег. запись, номер)'))"
                                            :valid-feedback="(feedback('ProgramObjects','prav_oper_upr',' '))"
                                            :state="feedback('ProgramObjects','prav_oper_upr')"
                                    >
                                        <b-form-input id="prav_oper_upr" name="ProgramObjects[prav_oper_upr]" v-model="formData.prav_oper_upr"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Назначение:"
                                            label-for="assignment"
                                            :invalid-feedback="(feedback('ProgramObjects','assignment','Введите Назначение'))"
                                            :valid-feedback="(feedback('ProgramObjects','assignment',' '))"
                                            :state="feedback('ProgramObjects','assignment')"
                                    >
                                        <b-form-input id="assignment" name="ProgramObjects[assignment]" v-model="formData.assignment"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Право собственности:"
                                            label-for="prav_sob"
                                            :invalid-feedback="(feedback('ProgramObjects','prav_sob','Введите Право собственности'))"
                                            :valid-feedback="(feedback('ProgramObjects','prav_sob',' '))"
                                            :state="feedback('ProgramObjects','prav_sob')"
                                    >
                                        <b-form-input id="prav_sob" name="ProgramObjects[prav_sob]" v-model="formData.prav_sob"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Общая площадь здания - всего, кв.м.:"
                                            label-for="square"
                                            :invalid-feedback="(feedback('ProgramObjects','square','Введите Общая площадь здания - всего, кв.м.'))"
                                            :valid-feedback="(feedback('ProgramObjects','square',' '))"
                                            :state="feedback('ProgramObjects','square')"
                                    >
                                        <b-form-input id="square" name="ProgramObjects[square]" type="number" step="0.02" v-model="formData.square"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Общая площадь здания (помещений), планируемого к капитальному ремонту, кв. м.:"
                                            label-for="square_kap"
                                            :invalid-feedback="(feedback('ProgramObjects','square_kap','Введите Общая площадь здания (помещений), планируемого к капитальному ремонту, кв. м.'))"
                                            :valid-feedback="(feedback('ProgramObjects','square_kap',' '))"
                                            :state="feedback('ProgramObjects','square_kap')"
                                    >
                                        <b-form-input id="square_kap" name="ProgramObjects[square_kap]" type="number"  step="0.02" v-model="formData.square_kap"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Используется в уставной деятельности, кв.м.:"
                                            label-for="isp_v_ust_dey"
                                            :invalid-feedback="(feedback('ProgramObjects','isp_v_ust_dey','Введите Используется в уставной деятельности, кв.м.'))"
                                            :valid-feedback="(feedback('ProgramObjects','isp_v_ust_dey',' '))"
                                            :state="feedback('ProgramObjects','isp_v_ust_dey')"
                                    >
                                        <b-form-input id="isp_v_ust_dey" name="ProgramObjects[isp_v_ust_dey]" type="number"  step="0.02" v-model="formData.isp_v_ust_dey"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Не используется в уставной деятельности, кв.м.:"
                                            label-for="n_isp_v_ust_dey"
                                            :invalid-feedback="(feedback('ProgramObjects','n_isp_v_ust_dey','Не используется в уставной деятельности, кв.м.'))"
                                            :valid-feedback="(feedback('ProgramObjects','n_isp_v_ust_dey',' '))"
                                            :state="feedback('ProgramObjects','n_isp_v_ust_dey')"
                                    >
                                        <b-form-input id="n_isp_v_ust_dey" name="ProgramObjects[n_isp_v_ust_dey]" type="number" step="0.02" v-model="formData.n_isp_v_ust_dey"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Предоставлено в аренду, кв.м."
                                            label-for="square_ar"
                                            :invalid-feedback="(feedback('ProgramObjects','square_ar','Введите Предоставлено в аренду, кв.м.'))"
                                            :valid-feedback="(feedback('ProgramObjects','square_ar',' '))"
                                            :state="feedback('ProgramObjects','square_ar')"
                                    >
                                        <b-form-input id="square_ar" name="ProgramObjects[square_ar]" type="number"  step="0.02" v-model="formData.square_ar"/>
                                    </b-form-group>
                                    <b-form-group
                                            label="Примечание:"
                                            label-for="note"
                                            :invalid-feedback="(feedback('ProgramObjects','note','Введите Примечание :'))"
                                            :valid-feedback="(feedback('ProgramObjects','note',' '))"
                                            :state="feedback('ProgramObjects','note')"
                                    >
                                        <b-form-input id="note" name="ProgramObjects[note]" v-model="formData.note"/>
                                    </b-form-group>
                                </b-form-group>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                       <span class="toggle_button" v-b-toggle.accordion-2>
                           <b-icon-gear-wide-connected />
                           Сведения о планируемых мероприятиях</span>
                        </b-card-header>
                        <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <v-svedenia model-name="ProgObjectsEvents" ref="svedenia"/>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                        <span  class="toggle_button" v-b-toggle.accordion-3 >
                            <b-icon-gear-wide-connected />
                            Обоснование необходимости (целесообразности) планируемых мероприятий</span>
                        </b-card-header>
                        <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <v-necessary model-name="ProObjectsNecessary" ref="necessary"/>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                        <span  class="toggle_button" v-b-toggle.accordion-4 >
                            <b-icon-gear-wide-connected />
                            Ожидаемые результаты</span>
                        </b-card-header>
                        <b-collapse id="accordion-4" accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <v-waited model-name="ProgObjectsWaites" ref="waited"/>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                        <span  class="toggle_button" v-b-toggle.accordion-5  >
                            <b-icon-gear-wide-connected />
                            Прогнозируемые риски</span>
                        </b-card-header>
                        <b-collapse id="accordion-5" accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <v-riscs model-name="ProgObjectsRiscs"/>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                       <span  class="toggle_button" v-b-toggle.accordion-6 >
                           <b-icon-gear-wide-connected />
                          Опись прилагаемых документов</span>
                        </b-card-header>
                        <b-collapse id="accordion-6" accordion="my-accordion" role="tabpanel" visible>
                            <b-card-body>
                                <v-uploads />
                            </b-card-body>
                        </b-collapse>
                    </b-card>
            </div>
            </div>
            <b-button type="submit" variant="info">Сохранить</b-button>
            <b-button type="reset" variant="danger">Сброс</b-button>
        </b-form>
    </div>
</template>

<script>
    import {userPanel} from "../../../organisms";
    import Multiselect from "vue-select";
    import {mapActions, mapGetters} from "vuex";
    import Svedenia from './Svedenia.vue';
    import Necessary from './Necessary.vue';
    import Riscs from './Riscs.vue';
    import Waited from './Waited.vue';
    import Uploads from './Uploads.vue'
    import Axios from 'axios'
    export default {
        name: "programForm",
        components:{
            "v-svedenia": Svedenia,
            "v-user-panel":userPanel,
            "v-select2": Multiselect,
            "v-necessary": Necessary,
            "v-waited": Waited,
            "v-riscs": Riscs,
            "v-uploads": Uploads
        },
        computed:{
            ...mapGetters(['getPageData','getCities',"getRegions"]),
            kad_number_validator: function () {
                let pattern = /\d+:\d+:\d+:\d+/;
                return pattern.test(this.formData.kad_number);
            },
            con_year_validator: function () {
                let pattern = /^[1-2][0-9]\d{2}/;
                return pattern.test(this.formData.year)
                // return this.formData.year.length===4 && this.formData.year[0]===1
            },
            exp_year_validator: function () {
                let pattern = /^[1-2][0-9]\d{2}/;
                return pattern.test(this.formData.exploit_year)

            },
            wear_validator: function () {
                return this.formData.wear >= 0 && this.formData.wear <= 100
            },
        },

        data(){
            return {
                csrf: document.getElementsByName('csrf-token')[0].content,
                formData: {

                    name:null,
                    id_region:null,
                    id_city:null,
                    kad_number:null,
                    year:0,
                    exploit_year:0,
                    wear:null,
                    exist_pred_nadz_orgs:null,
                    osn_isp_zdan:null,
                    assignment:null,
                    prav_sob:null,
                    square:null,
                    square_kap:null,
                    isp_v_ust_dey:null,
                    n_isp_v_ust_dey:null,
                    square_ar:null,
                    note:null,
                    prav_oper_upr:null
                },
                errors:{}
            }
        },
        watch:{
            getCities:function () {

                this.formData.id_city = ''
            },
        },
        methods:{
            ...mapActions(['requestPageData','requestCity']),
            feedback(model,value,errorMessage){
                let val = this.formData[value];
                if (errorMessage)
                    return errorMessage
                if (!(typeof(val) != "undefined" && val !== null))
                    return false
                return !(this.errors.hasOwnProperty(model) && this.errors[model].hasOwnProperty(value) )
            },
            onSubmit(e){
                e.preventDefault();
                let form = document.getElementById('object_form');
                let formData = new FormData(form);
                Axios.post('/program/object/create',formData,{
                    headers:
                        {
                            'X-CSRF-Token':this.csrf,
                            'Content-Type':'application/x-www-form-urlencoded'
                        },
                }).then(response=>
                {
                    if (response.data == 'ok')
                        window.location.href = '/program/view';
                    this.errors = response.data;
                })
            },
            onReset(){
                this.formData.id_region=0;
                this.formData.id_city=0;
                this.formData.kad_number= '';
                this.formData.year=0;
                this.formData.exploit_year=0;
                this.formData.wear=0;
                this.formData.exist_pred_nadz_orgs= '';
                this.formData.osn_isp_zdan= '';
                this.formData.assignment= '';
                this.formData.prav_sob= '';
                this.formData.note= '';
                this.formData.square=0;
                this.formData.square_kap=0;
                this.formData.isp_v_ust_dey=0;
                this.formData.n_isp_v_ust_dey=0;
                this.formData.square_ar=0;

            },
            onChangeRegion({id}) {
                this.requestCity({id})

            }
        },
        mounted() {
            this.requestPageData({pageName:"objectCreate"});
        }
    }
</script>
<style scoped>
    .toggle_button {
        display: block;
        cursor: pointer;
    }
</style>