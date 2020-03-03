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


                    <label for="name">Название объекта:</label>
                    <b-form-input id="name" name="name" v-model="formData.name"/>
                    <br>
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
                                    <label for="type">Тип объекта:</label>
                                    <v-select2 v-model="formData.type"
                                               :options="[
                                                   {id:0,type:'Приоритетный'},
                                                   {id:1,type:'Резервный'}
                                               ]"
                                               :reduce="type => type.id"
                                               label="type"
                                               id="type"
                                               name="id_region"
                                               @input="onChangeRegion({id:formData.id_region})"
                                    />
                                    <label for="id_region">Субъект РФ:</label>
                                    <v-select2 v-model="formData.id_region"
                                               :options="getPageData.regionOptions"
                                               :reduce="region => region.id"
                                               label="region"
                                               id="id_region"
                                               name="id_region"
                                               @input="onChangeRegion({id:formData.id_region})"
                                    />
                                    <label for="id_city">Город:</label>
                                    <v-select2 v-model="formData.id_city"
                                               :options="getCities"
                                               :reduce="city => city.id"
                                               label="city"
                                               id="id_city"
                                               name="id_city"
                                    />
                                    <label for="kad_number">Кадастровый номер:</label>
                                    <b-form-input id="kad_number" name="kud_number" :state="kad_number_validator" v-model="formData.kad_number"/>
                                    <label for="year">Год постройки здания:</label>
                                    <b-form-input id="year" name="year" :state="con_year_validator" type="number" v-model="formData.year"/>
                                    <label for="exploit_year">Год ввода здания в эксплуатацию:</label>
                                    <b-form-input id="exploit_year" name="exploit_year" :state="exp_year_validator" type="number" v-model="formData.exploit_year"/>
                                    <label for="exist_pred_nadz_orgs">Наличие предписаний надзорных органов:</label>
                                    <b-form-input id="exist_pred_nadz_orgs" name="exist_pred_nadz_orgs" v-model="formData.exist_pred_nadz_orgs"/>
                                    <label for="wear">Износ здания (%):</label>
                                    <b-form-input id="wear" name="wear" :state="wear_validator" type="number" v-model="formData.wear"/>
                                    <label for="osn_isp_zdan">Основание для использования здания:</label>
                                    <b-form-input id="osn_isp_zdan" name="osn_isp_zdan" v-model="formData.osn_isp_zdan"/>
                                    <label for="prav_oper_upr">Право оперативного управления (рег. запись, номер):</label>
                                    <b-form-input id="prav_oper_upr" name="prav_oper_upr" v-model="formData.prav_oper_upr"/>
                                    <label for="assignment">Назначение:</label>
                                    <b-form-input id="assignment" name="assignment" v-model="formData.assignment"/>
                                    <label for="prav_sob">Право собственности:</label>
                                    <b-form-input id="assignment" name="assignment" v-model="formData.prav_sob"/>
                                    <label for="square">Общая площадь здания - всего, кв.м.:</label>
                                    <b-form-input id="square" name="square" type="number" v-model="formData.square"/>
                                    <label for="square_kap">Общая площадь здания (помещений), планируемого к капитальному ремонту, кв. м.:</label>
                                    <b-form-input id="square_kap" name="square_kap" type="number" v-model="formData.square_kap"/>
                                    <label for="isp_v_ust_dey">Используется в уставной деятельности, кв.м.:</label>
                                    <b-form-input id="isp_v_ust_dey" name="isp_v_ust_dey" type="number" v-model="formData.isp_v_ust_dey"/>
                                    <label for="n_isp_v_ust_dey">Не используется в уставной деятельности, кв.м.:</label>
                                    <b-form-input id="n_isp_v_ust_dey" name="n_isp_v_ust_dey" type="number" v-model="formData.n_isp_v_ust_dey"/>
                                    <label for="square_ar">Предоставлено в аренду, кв.м.:</label>
                                    <b-form-input id="square_ar" name="square_ar" type="number" v-model="formData.square_ar"/>
                                    <label for="note">Примечание::</label>
                                    <b-form-input id="note" name="note" v-model="formData.note"/>
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
                                <v-svedenia ref="svedenia"/>
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
                                <v-necessary />
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

                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                       <span  class="toggle_button" v-b-toggle.accordion-6 >
                           <b-icon-gear-wide-connected />
                          Опись прилагаемых документов</span>
                        </b-card-header>
                        <b-collapse id="accordion-6" accordion="my-accordion" role="tabpanel">
                            <b-card-body>

                            </b-card-body>
                        </b-collapse>
                    </b-card>
            </div>


            </div>
            <b-button type="submit" variant="primary">Сохранить</b-button>
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
    import Axios from 'axios'

    export default {
        name: "programForm",
        components:{
            "v-svedenia": Svedenia,
            "v-user-panel":userPanel,
            "v-select2": Multiselect,
            "v-necessary": Necessary
        },
        computed:{
            ...mapGetters(['getPageData','getCities']),
            kad_number_validator(){
                let pattern = /\d+:\d+:\d+:\d+/;
                return pattern.test(this.formData.kad_number);
            },
            con_year_validator(){
                return this.formData.year.length===4
            },
            exp_year_validator(){
                return this.formData.exploit_year.length===4

            },
            wear_validator(){
                return this.formData.wear >= 0 && this.formData.wear <= 100
            },
        },

        data(){
            return {
                csrf: document.getElementsByName('csrf-token')[0].content,
                formData: {

                    name:'',
                    id_region: 0,
                    id_city:0,
                    kad_number: '',
                    year:0,
                    exploit_year:0,
                    wear:0,
                    exist_pred_nadz_orgs:'',
                    osn_isp_zdan:'',
                    assignment:'',
                    prav_sob:'',
                    square:0,
                    square_kap:0,
                    isp_v_ust_dey:0,
                    n_isp_v_ust_dey:0,
                    square_ar:0,
                    note:'',
                },
            }
        },
        watch:{
          getCities:function () {

                this.formData.id_city = ''
          }
        },
        methods:{
            ...mapActions(['requestPageData','requestCity']),
            onSubmit(e){
                e.preventDefault();

                let formData = new FormData();
                formData.append('_csrf',this.csrf);
                Object.keys(this.formData).forEach(item=>{
                    formData.append(`ProgramObjects[${item}]`,this.formData[item]);
                });
                Object.keys(this.$refs.svedenia.getSved()).forEach(item=>{
                    formData.append(`ProgObjectsEvents[${item}]`,this.$refs.svedenia.getSved()[item]);
                })

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
                }).catch(e=>console.error(e)).finally()
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