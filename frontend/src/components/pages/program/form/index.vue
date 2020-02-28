<template>
    <div class="program_object_form">
        <b-form @submit="onSubmit">
            <div class="row">
                <div class="col-6">
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                       <span class="toggle_button" v-b-toggle.accordion-1>
                           <b-icon-gear-wide-connected />
                           Характеристика объекта
                       </span>
                        </b-card-header>
                        <b-collapse id="accordion-1" visible accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <b-form-group>
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
                                               name="idCity"
                                    />
                                    <label for="kad_number">Кадастровый номер:</label>
                                    <b-form-input id="kad_number" name="kud_number" :state="kad_number_validator" v-model="formData.kad_number"/>
                                    <label for="construct_object_year">Год постройки здания:</label>
                                    <b-form-input id="construct_object_year" name="construct_object_year" :state="con_year_validator" type="number" v-model="formData.construct_object_year"/>
                                    <label for="exploit_object_year">Год ввода здания в эксплуатацию:</label>
                                    <b-form-input id="exploit_object_year" name="exploit_object_year" :state="exp_year_validator" type="number" v-model="formData.exploit_object_year"/>
                                </b-form-group>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                       <span class="toggle_button" v-b-toggle.accordion-2>
                           <b-icon-gear-wide-connected />
                           Цели и задачи реализации программы</span>
                        </b-card-header>
                        <b-collapse id="accordion-2" accordion="my-accordion" role="tabpanel">
                            <b-card-body>

                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                       <span  class="toggle_button" v-b-toggle.accordion-3 >
                           <b-icon-gear-wide-connected />
                           Потребность в бюджетных ассигнованиях на проведение кап. ремонта приоритетных объектов</span>
                        </b-card-header>
                        <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
                            <b-card-body>

                            </b-card-body>
                        </b-collapse>
                    </b-card>
                </div>

                <div class="col-4 offset-2">
                    <v-user-panel/>
                </div>
            </div>
            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
        </b-form>
    </div>
</template>

<script>
    import {userPanel} from "../../../organisms";
    import Multiselect from "vue-select";
    import {mapActions, mapGetters} from "vuex";
    export default {
        name: "programForm",
        components:{
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
                return this.formData.construct_object_year.length===4
            },
            exp_year_validator(){
                return this.formData.exploit_object_year.length===4
            },
        },

        data(){
            return {
                formData: {
                    idRegion: 0,
                    idCity:0,
                    kad_number: '',
                    construct_object_year:0,
                    exploit_object_year:0

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
                e.preventDefault();
                alert(JSON.stringify(this.formData))
            },
            onChangeRegion({id}){
                this.requestCity({id})

            }
        },
        mounted() {
            this.requestPageData({pageName:"objectForm"});
        }
    }
</script>
<style scoped>
    .toggle_button{
        display: block;
        cursor: pointer;
    }
</style>