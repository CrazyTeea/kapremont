<template>
    <div class="program_object_form">
        <b-form @submit="onSubmit" @reset="onReset" method="post">
            <input id="hidden" name="_csrf" v-model="getPageData._csrf" type='hidden' />
            <div class="row">
                  <div class="col-12">
                    <v-user-panel/>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
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
                                               name="idRegion"
                                               @input="onChangeRegion({id:formData.idRegion})"
                                    />
                                    <label for="idRegion">Субъект РФ:</label>
                                    <v-select2 v-model="formData.idRegion"
                                               :options="getPageData.regionOptions"
                                               :reduce="region => region.id"
                                               label="region"
                                               id="idRegion"
                                               name="idRegion"
                                               @input="onChangeRegion({id:formData.idRegion})"
                                    />
                                    <label for="idCity">Город:</label>
                                    <v-select2 v-model="formData.idCity"
                                               :options="getCities"
                                               :reduce="city => city.id"
                                               label="city"
                                               id="idCity"
                                               name="idCity"/>
                                    <label for="kad_number">Кадастровый номер:</label>
                                    <b-form-input id="kad_number" name="kud_number" :state="kad_number_validator" v-model="formData.kad_number"/>
                                    <label for="construct_object_year">Год постройки здания:</label>
                                    <b-form-input id="construct_object_year" name="construct_object_year" :state="con_year_validator" type="number" v-model="formData.construct_object_year"/>
                                    <label for="exploit_object_year">Год ввода здания в эксплуатацию:</label>
                                    <b-form-input id="exploit_object_year" name="exploit_object_year" :state="exp_year_validator" type="number" v-model="formData.exploit_object_year"/>
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
                        <b-collapse id="accordion-2" visible accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <v-svedenia />
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

                <!-- <div class="col-4 offset-2">
                    <v-user-panel/>
                </div> -->
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

    export default {
        name: "programForm",
        components:{
            "v-svedenia": Svedenia,
            "v-user-panel":userPanel,
            "v-select2": Multiselect
        },
        computed:{
            ...mapGetters(['getPageData','getCities']),
            kad_number_validator(){
                let pattern = /\d+:\d+:\d+:\d+/;
                return pattern.test(this.formData.kad_number);
            },
            con_year_validator(){
                return this.formData.construct_object_year.length === 4
            },
            exp_year_validator(){
                return this.formData.exploit_object_year.length === 4
            },
            wear_validator(){
                return this.formData.wear >= 0 && this.formData.wear <= 100
            },
        },

        data(){
            return {
                formData: {
                    idRegion: 0,
                    idCity: 0,
                    kad_number: '',
                    construct_object_year: 0,
                    exploit_object_year: 0,
                    wear: 0,
                    exist_pred_nadz_orgs: '',
                    osn_isp_zdan: '',
                    assignment: '',
                    prav_sob: '',
                    square: 0,
                    square_kap: 0,
                    isp_v_ust_dey: 0,
                    n_isp_v_ust_dey: 0,
                    square_ar: 0,
                    note: '',
                },
            }
        },
        watch:{
          getCities:function () {

                this.formData.idCity = ''
          }
        },
        methods:{
            ...mapActions(['requestPageData','requestCity']),
            onSubmit(e){
               // e.preventDefault();
                alert(JSON.stringify(this.formData))    
            },
            onReset(){
                this.formData.idRegion = 0;
                this.formData.idCity = 0;
                this.formData.kad_number = '';
                this.formData.construct_object_year = 0;
                this.formData.exploit_object_year = 0;
                this.formData.wear = 0;
                this.formData.exist_pred_nadz_orgs = '';
                this.formData.osn_isp_zdan = '';
                this.formData.assignment = '';
                this.formData.prav_sob = '';
                this.formData.note = '';
                this.formData.square = 0;
                this.formData.square_kap = 0;
                this.formData.isp_v_ust_dey = 0;
                this.formData.n_isp_v_ust_dey = 0;
                this.formData.square_ar = 0;
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