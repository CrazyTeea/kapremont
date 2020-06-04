<template>
    <div class="program_object_form">
        <b-form enctype="multipart/form-data" id="object_form" @submit="onSubmit" @reset="onReset" method="post">
            <div class="row">
                <div class="col-12">
                    <v-user-panel />
                </div>
            </div>
            <div class="mt-3">
                <div class="row">
                    <div class="col-12">
                        <b-alert v-for="(banner, index) in bannerInfo" :key="index" :show="banner.show" :variant="banner.variant" dismissible fade>{{ banner.message }}</b-alert>
                    </div>
                </div>
            </div>
            <input id="hidden" name="_csrf" v-model="csrf" type="hidden" />
            <div class="row mt-3">
                <div class="col-12">
                    <b-form-group
                            label="Название объекта"
                            label-for="name"
                            :invalid-feedback="feedback('ProgramObjects', 'name', 'Название объекта должно быть заполнено')"
                            :valid-feedback="feedback('ProgramObjects', 'name', ' ')"
                            :state="feedback('ProgramObjects', 'name')"
                    >
                        <b-form-input  placeholder="Название..." id="name" name="ProgramObjects[name]" v-model="formData.name" />
                    </b-form-group>
                    <b-form-group
                            label="Краткое описание планируемых работ по объекту"
                            label-for="object_opis"
                            :invalid-feedback="feedback('ProgramObjects', 'object_opis', 'Краткое описание планируемых работ по объекту должно быть заполнено')"
                            :valid-feedback="feedback('ProgramObjects', 'object_opis', ' ')"
                            :state="feedback('ProgramObjects', 'object_opis')"
                    >
                        <b-form-input placeholder="краткое описание планируемых работ по объекту..." id="object_opis" name="ProgramObjects[object_opis]" v-model="formData.object_opis" />
                    </b-form-group>
                    <b-form-group
                            label="Адрес объекта"
                            label-for="address"
                            :invalid-feedback="feedback('ProgramObjects', 'address', 'адрес объекта должно быть заполнено')"
                            :valid-feedback="feedback('ProgramObjects', 'address', ' ')"
                            :state="feedback('ProgramObjects', 'address')"
                    >
                        <b-form-input  placeholder="адрес..." id="address" name="ProgramObjects[address]" v-model="formData.address" />
                    </b-form-group>
                    <b-form-group
                            label="Вид ремонта"
                            label-for="type_remont"
                            :invalid-feedback="feedback('ProgramObjects', 'type_remont', 'Заполните вид ремонта')"
                            :valid-feedback="feedback('ProgramObjects', 'type_remont', ' ')"
                            :state="feedback('ProgramObjects', 'type_remont')"
                    >
                        <b-form-input  style="display: none" id="type_remont" v-model="formData.type_remont" name="ProgramObjects[type_remont]" />
                        <b-select

                                v-model="formData.type_remont"
                                :options="[
                                { value: 0, text: 'Комплексный' },
                                { value: 1, text: 'Выборочный' }
                            ]"
                        />
                    </b-form-group>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-1>
                                <b-icon-gear-wide-connected />
                                Характеристика объекта
                            </span>
                        </b-card-header>
                        <b-collapse id="accordion-1" accordion="my-accordion" role="tabpanel" visible>
                            <b-card-body>
                                <b-form-group>
                                    <b-form-group
                                            v-can:root
                                            label="Тип объекта"
                                            label-for="type"
                                            :invalid-feedback="feedback('ProgramObjects', 'type', 'Тип объекта должен быть заполнен')"
                                            :valid-feedback="feedback('ProgramObjects', 'type', ' ')"
                                            :state="feedback('ProgramObjects', 'type')"
                                    >
                                        <b-form-input  style="display: none" id="type" v-model="formData.type" name="ProgramObjects[type]" />
                                        <b-select

                                                v-model="formData.type"
                                                :options="[
                                                {
                                                    value: 0,
                                                    text: 'Приоритетный'
                                                },
                                                { value: 1, text: 'Резервный' }
                                            ]"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Приоритет"
                                            label-for="id_priority"
                                            :invalid-feedback="feedback('ProgramObjects', 'id_priority', 'Приоритет объекта должен быть заполнен')"
                                            :valid-feedback="feedback('ProgramObjects', 'id_priority', ' ')"
                                            :state="feedback('ProgramObjects', 'id_priority')"
                                    >
                                        <b-form-input  style="display: none" id="id_priority" v-model="formData.id_priority" name="ProgramObjects[id_priority]" />
                                        <b-select

                                                v-model="formData.id_priority"
                                                :options="[
                                                { value: 1, text: '1' },
                                                { value: 2, text: '2' },
                                                { value: 3, text: '3' }
                                            ]"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Субъект РФ:"
                                            label-for="id_region"
                                            :invalid-feedback="feedback('ProgramObjects', 'id_region', 'Регион должен быть заполнен')"
                                            :valid-feedback="feedback('ProgramObjects', 'id_region', ' ')"
                                            :state="feedback('ProgramObjects', 'id_region')"
                                    >
                                        <b-form-input  style="display: none" id="id_region" v-model="formData.id_region" name="ProgramObjects[id_region]" />
                                        <v-select2

                                                v-model="formData.id_region"
                                                :options="getRegions"
                                                :reduce="region => region.id"
                                                label="region"
                                                @input="
                                                onChangeRegion({
                                                    id: formData.id_region
                                                })
                                            "
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Город:"
                                            label-for="id_city"
                                            :invalid-feedback="feedback('ProgramObjects', 'id_city', 'Город должен быть заполнен')"
                                            :valid-feedback="feedback('ProgramObjects', 'id_city', ' ')"
                                            :state="feedback('ProgramObjects', 'id_city')"
                                    >
                                        <b-form-input  style="display: none" id="id_city" v-model="formData.id_city" name="ProgramObjects[id_city]" />
                                        <v-select2

                                                v-model="formData.id_city"
                                                :options="
                                                getCities || [
                                                    {
                                                        city: 'Выберите регион',
                                                        id: null
                                                    }
                                                ]
                                            "
                                                :reduce="city => city.id"
                                                label="city"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Кадастровый номер:"
                                            label-for="kad_number"
                                            :invalid-feedback="feedback('ProgramObjects', 'kad_number', 'Кадастровый номер обязателен для заполнения и должен содержать цифры и :')"
                                            :valid-feedback="feedback('ProgramObjects', 'kad_number', ' ')"
                                            :state="feedback('ProgramObjects', 'kad_number') && kad_number_validator"
                                    >
                                        <b-form-input  id="kad_number" name="ProgramObjects[kad_number]" v-model="formData.kad_number" trim />
                                    </b-form-group>
                                    <b-form-group
                                            label="Год постройки здания:"
                                            label-for="year"
                                            :invalid-feedback="feedback('ProgramObjects', 'year', 'Введите год:')"
                                            :valid-feedback="feedback('ProgramObjects', 'year', ' ')"
                                            :state="feedback('ProgramObjects', 'year') && con_year_validator"
                                    >
                                        <b-form-input  id="year" name="ProgramObjects[year]" type="number" v-model="formData.year" />
                                    </b-form-group>
                                    <b-form-group
                                            label="Год ввода здания в эксплуатацию:"
                                            label-for="exploit_year"
                                            :invalid-feedback="feedback('ProgramObjects', 'exploit_year', 'Введите год :')"
                                            :valid-feedback="feedback('ProgramObjects', 'exploit_year', ' ')"
                                            :state="feedback('ProgramObjects', 'exploit_year') && exp_year_validator"
                                    >
                                        <b-form-input  id="exploit_year" name="ProgramObjects[exploit_year]" type="number" v-model="formData.exploit_year" />
                                    </b-form-group>

                                    <b-form-group
                                            label="Год проведения последнего капитального ремонта/реконструкции:"
                                            label-for="last_exploit_year"
                                            :invalid-feedback="feedback('ProgramObjects', 'last_exploit_year', 'Введите год проведения последнего капитального ремонта/реконструкции :')"
                                            :valid-feedback="feedback('ProgramObjects', 'last_exploit_year', ' ')"
                                            :state="feedback('ProgramObjects', 'last_exploit_year') && exp_year_validator"
                                    >
                                        <b-form-input  id="last_exploit_year" name="ProgramObjects[last_exploit_year]" type="number" v-model="formData.last_exploit_year" />
                                    </b-form-group>

                                    <b-form-group
                                            label="Наличие предписаний надзорных органов:"
                                            label-for="exist_pred_nadz_orgs"
                                            :invalid-feedback="feedback('ProgramObjects', 'exist_pred_nadz_orgs', 'Введите Наличие предписаний надзорных органов :')"
                                            :valid-feedback="feedback('ProgramObjects', 'exist_pred_nadz_orgs', ' ')"
                                            :state="feedback('ProgramObjects', 'exist_pred_nadz_orgs')"
                                    >
                                        <b-form-input  style="display: none;" id="exist_pred_nadz_orgs" name="ProgramObjects[exist_pred_nadz_orgs]" v-model="formData.exist_pred_nadz_orgs" />

                                        <b-select

                                                v-model="formData.exist_pred_nadz_orgs"
                                                :options="[
                                                { value: 0, text: 'Нет' },
                                                { value: 1, text: 'Да' }
                                            ]"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            v-if="formData.exist_pred_nadz_orgs"
                                            label="Подробности:"
                                            label-for="regulation"
                                            :invalid-feedback="feedback('ProgramObjects', 'regulation', 'Введите подробности')"
                                            :valid-feedback="feedback('ProgramObjects', 'regulation', ' ')"
                                            :state="feedback('ProgramObjects', 'regulation')"
                                    >
                                        <b-form-input  id="regulation" name="ProgramObjects[regulation]" v-model="formData.regulation" />
                                    </b-form-group>
                                    <b-form-group
                                            label="Износ здания (%):"
                                            label-for="wear"
                                            :invalid-feedback="feedback('ProgramObjects', 'wear', 'Износ здания должен быть меньше 0 и больше 100 (%)')"
                                            :valid-feedback="feedback('ProgramObjects', 'wear', ' ')"
                                            :state="feedback('ProgramObjects', 'wear') && wear_validator"
                                    >
                                        <!-- <b-form-input style="display: none" id="type_wear" v-model="formData" name="ProgramObjects[type]" / -->
                                        <b-form-input  style="display: none;" id="wear" min="0" name="ProgramObjects[wear]" :state="wear_validator" type="number" v-model="formData.wear" />

                                        <b-select

                                                v-model="formData.wear"
                                                :options="[
                                                { value: 0, text: 'Менее 20%' },
                                                {
                                                    value: 1,
                                                    text: 'От 20% до 50%'
                                                },
                                                {
                                                    value: 2,
                                                    text: 'От 50% до 70%'
                                                },
                                                {
                                                    value: 3,
                                                    text: 'От 70% до 90%'
                                                },
                                                { value: 4, text: 'Более 90%' }
                                            ]"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Основание для использования здания:"
                                            label-for="osn_isp_zdan"
                                            :invalid-feedback="feedback('ProgramObjects', 'osn_isp_zdan', 'Введите Основание для использования здания')"
                                            :valid-feedback="feedback('ProgramObjects', 'osn_isp_zdan', ' ')"
                                            :state="feedback('ProgramObjects', 'osn_isp_zdan')"
                                    >
                                        <b-form-input  id="osn_isp_zdan" name="ProgramObjects[osn_isp_zdan]" v-model="formData.osn_isp_zdan" />
                                    </b-form-group>
                                    <b-form-group
                                            label="Право оперативного управления (рег. запись, номер):"
                                            label-for="prav_oper_upr"
                                            :invalid-feedback="feedback('ProgramObjects', 'prav_oper_upr', 'Введите Право оперативного управления (рег. запись, номер)')"
                                            :valid-feedback="feedback('ProgramObjects', 'prav_oper_upr', ' ')"
                                            :state="feedback('ProgramObjects', 'prav_oper_upr')"
                                    >
                                        <b-form-input  id="prav_oper_upr" name="ProgramObjects[prav_oper_upr]" v-model="formData.prav_oper_upr" />
                                    </b-form-group>
                                    <b-form-group
                                            label="Назначение:"
                                            label-for="assignment"
                                            :invalid-feedback="feedback('ProgramObjects', 'assignment', 'Введите Назначение')"
                                            :valid-feedback="feedback('ProgramObjects', 'assignment', ' ')"
                                            :state="feedback('ProgramObjects', 'assignment')"
                                    >
                                        <b-form-input  id="assignment" name="ProgramObjects[assignment]" v-model="formData.assignment" />
                                    </b-form-group>
                                    <b-form-group
                                            label="Право собственности:"
                                            label-for="prav_sob"
                                            :invalid-feedback="feedback('ProgramObjects', 'prav_sob', 'Введите Право собственности')"
                                            :valid-feedback="feedback('ProgramObjects', 'prav_sob', ' ')"
                                            :state="feedback('ProgramObjects', 'prav_sob')"
                                    >
                                        <b-form-input  style="display: none;" id="prav_sob" name="ProgramObjects[prav_sob]" v-model="formData.prav_sob" />

                                        <b-select

                                                v-model="formData.prav_sob"
                                                :options="[
                                                {
                                                    value: 'fast',
                                                    text: 'Оперативное управление'
                                                },
                                                {
                                                    value: 'others',
                                                    text: 'Другое'
                                                }
                                            ]"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Общая площадь здания - всего, кв.м.:"
                                            label-for="square"
                                            :invalid-feedback="feedback('ProgramObjects', 'square', 'Введите Общая площадь здания - всего, кв.м.')"
                                            :valid-feedback="feedback('ProgramObjects', 'square', ' ')"
                                            :state="feedback('ProgramObjects', 'square')"
                                    >
                                        <b-form-input  id="square" name="ProgramObjects[square]" type="number" step="0.001" v-model="formData.square" @change="val => setFloat(val, 'square')" />
                                    </b-form-group>
                                    <b-form-group
                                            label="Общая площадь здания (помещений), планируемого к капитальному ремонту, кв. м.:"
                                            label-for="square_kap"
                                            :invalid-feedback="feedback('ProgramObjects', 'square_kap', 'Введите Общая площадь здания (помещений), планируемого к капитальному ремонту, кв. м.')"
                                            :valid-feedback="feedback('ProgramObjects', 'square_kap', ' ')"
                                            :state="feedback('ProgramObjects', 'square_kap')"
                                    >
                                        <b-form-input

                                                id="square_kap"
                                                name="ProgramObjects[square_kap]"
                                                type="number"
                                                step="0.001"
                                                v-model="formData.square_kap"
                                                @change="val => setFloat(val, 'square_kap')"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Используется в уставной деятельности, кв.м.:"
                                            label-for="isp_v_ust_dey"
                                            :invalid-feedback="feedback('ProgramObjects', 'isp_v_ust_dey', 'Введите Используется в уставной деятельности, кв.м.')"
                                            :valid-feedback="feedback('ProgramObjects', 'isp_v_ust_dey', ' ')"
                                            :state="feedback('ProgramObjects', 'isp_v_ust_dey')"
                                    >
                                        <b-form-input

                                                id="isp_v_ust_dey"
                                                name="ProgramObjects[isp_v_ust_dey]"
                                                type="number"
                                                step="0.001"
                                                v-model="formData.isp_v_ust_dey"
                                                @change="val => setFloat(val, 'isp_v_ust_dey')"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Не используется в уставной деятельности, кв.м.:"
                                            label-for="n_isp_v_ust_dey"
                                            :invalid-feedback="feedback('ProgramObjects', 'n_isp_v_ust_dey', 'Не используется в уставной деятельности, кв.м.')"
                                            :valid-feedback="feedback('ProgramObjects', 'n_isp_v_ust_dey', ' ')"
                                            :state="feedback('ProgramObjects', 'n_isp_v_ust_dey')"
                                    >
                                        <b-form-input

                                                id="n_isp_v_ust_dey"
                                                name="ProgramObjects[n_isp_v_ust_dey]"
                                                type="number"
                                                step="0.001"
                                                v-model="formData.n_isp_v_ust_dey"
                                                @change="val => setFloat(val, 'n_isp_v_ust_dey')"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Предоставлено в аренду, кв.м."
                                            label-for="square_ar"
                                            :invalid-feedback="feedback('ProgramObjects', 'square_ar', 'Введите Предоставлено в аренду, кв.м.')"
                                            :valid-feedback="feedback('ProgramObjects', 'square_ar', ' ')"
                                            :state="feedback('ProgramObjects', 'square_ar')"
                                    >
                                        <b-form-input

                                                id="square_ar"
                                                name="ProgramObjects[square_ar]"
                                                type="number"
                                                step="0.001"
                                                v-model="formData.square_ar"
                                                @change="val => setFloat(val, 'square_ar')"
                                        />
                                    </b-form-group>
                                    <b-form-group
                                            label="Примечание:"
                                            label-for="note"
                                            :invalid-feedback="feedback('ProgramObjects', 'note', 'Введите Примечание :')"
                                            :valid-feedback="feedback('ProgramObjects', 'note', ' ')"
                                            :state="feedback('ProgramObjects', 'note')"
                                    >
                                        <b-form-input  id="note" name="ProgramObjects[note]" v-model="formData.note" />
                                    </b-form-group>
                                </b-form-group>
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
                                <v-svedenia model-name="ProgObjectsEvents" ref="svedenia" />
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card v-if="checkFOIV()" no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                                <span class="toggle_button" v-b-toggle.accordion-3>
                                    <b-icon-gear-wide-connected />
                                    Обоснование необходимости (целесообразности) планируемых мероприятий</span
                                >
                        </b-card-header>
                        <b-collapse id="accordion-3" accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <v-necessary model-name="ProObjectsNecessary" ref="necessary" />
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card v-if="checkFOIV()" no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                                <span class="toggle_button" v-b-toggle.accordion-4>
                                    <b-icon-gear-wide-connected />
                                    Ожидаемые результаты</span
                                >
                        </b-card-header>
                        <b-collapse id="accordion-4" accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <v-waited model-name="ProgObjectsWaites" ref="waited" />
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card v-if="checkFOIV()" no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                                <span class="toggle_button" v-b-toggle.accordion-5>
                                    <b-icon-gear-wide-connected />
                                    Прогнозируемые риски</span
                                >
                        </b-card-header>
                        <b-collapse id="accordion-5" accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <v-riscs model-name="ProgObjectsRiscs" ref="riscs" />
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card v-if="checkFOIV()" no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                                <span class="toggle_button" v-b-toggle.accordion-6>
                                    <b-icon-gear-wide-connected />
                                    Опись прилагаемых документов</span
                                >
                        </b-card-header>
                        <b-collapse id="accordion-6" accordion="my-accordion" role="tabpanel">
                            <b-card-body>
                                <v-uploads model-name="Files" ref="files" />
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
    import { userPanel } from "../../../organisms";
    import Multiselect from "vue-select";
    import { mapActions, mapGetters } from "vuex";
    import Svedenia from "./Svedenia.vue";
    import Necessary from "./Necessary.vue";
    import Riscs from "./Riscs.vue";
    import Waited from "./Waited.vue";
    import Uploads from "./Uploads.vue";
    import Axios from "axios";
    import {
        BAlert,
        BButton,
        BCard,
        BCardBody,
        BCardHeader,
        BCollapse,
        BForm,
        BFormGroup,
        BFormInput,
        BFormSelect,
        VBToggle
    } from "bootstrap-vue";


    export default {
        name: "programForm",

        directives:{
            'b-toggle':VBToggle
        },
        components:{
            BAlert,
            BCollapse,
            BCard,
            BCardHeader,
            BCardBody,
            BForm,
            BFormGroup,
            BFormInput,
            BButton,
            "v-svedenia": Svedenia,
            "v-user-panel": userPanel,
            "v-select2": Multiselect,
            "v-necessary": Necessary,
            "v-waited": Waited,
            "v-riscs": Riscs,
            "v-uploads": Uploads,
            'b-select':BFormSelect
        },
        computed: {
            ...mapGetters(["getPageData", "getCities", "getRegions"]),
            kad_number_validator: function() {
                let pattern = /\d+:\d+:\d+:\d+/;
                return pattern.test(this.formData.kad_number);
            },
            con_year_validator: function() {
                let pattern = /^[1-2][0-9]\d{2}/;
                return pattern.test(this.formData.year);
                // return this.formData.year.length===4 && this.formData.year[0]===1
            },
            exp_year_validator: function() {
                let pattern = /^[1-2][0-9]\d{2}/;
                return pattern.test(this.formData.exploit_year);
            },
            wear_validator: function() {
                return this.formData.wear >= 0 && this.formData.wear <= 100;
            }
        },

        data() {
            return {
                permission:window.Permission,
                bannerInfo: [],
                csrf: document.getElementsByName("csrf-token")[0].content,
                formData: {
                    id_org:window.MODEL.base?.id_org || null,
                    status:window.MODEL.base?.status || null,
                    object_opis: window.MODEL.base?.object_opis || null,
                    last_exploit_year: window.MODEL.base?.last_exploit_year || null,
                    type_remont: window.MODEL.base?.type_remont || 0,
                    address: window.MODEL.base?.address || null,
                    type: window.MODEL.base?.type || 0,
                    name: window.MODEL.base?.name || null,
                    id_region: window.MODEL.base?.id_region || null,
                    id_priority: window.MODEL.base?.id_priority || null,
                    id_city: window.MODEL.base?.id_city || null,
                    kad_number: window.MODEL.base?.kad_number || null,
                    year: window.MODEL.base?.year || 0,
                    exploit_year: window.MODEL.base?.exploit_year || 0,
                    wear: window.MODEL.base?.wear || null,
                    exist_pred_nadz_orgs: window.MODEL.base?.exist_pred_nadz_orgs || null,
                    osn_isp_zdan: window.MODEL.base?.osn_isp_zdan || null,
                    regulation: window.MODEL.base?.regulation || null,
                    assignment: window.MODEL.base?.assignment || null,
                    prav_sob: window.MODEL.base?.prav_sob || null,
                    square: window.MODEL.base?.square || null,
                    square_kap: window.MODEL.base?.square_kap || null,
                    isp_v_ust_dey: window.MODEL.base?.isp_v_ust_dey || null,
                    n_isp_v_ust_dey: window.MODEL.base?.n_isp_v_ust_dey || null,
                    square_ar: window.MODEL.base?.square_ar || null,
                    note: window.MODEL.base?.note || null,
                    prav_oper_upr: window.MODEL.base?.prav_oper_upr || null
                },
                errors: {}
            };
        },

        methods: {
            checkFOIV(){
                return !(this.permission === 'faiv_admin' || this.permission === 'faiv_user');
            },
            setBanner(variant, message) {
                this.bannerInfo.unshift({
                    show: true,
                    variant: variant,
                    message: message
                });
                setTimeout(() => {
                    this.resetBanners();
                }, 6500);
            },
            resetBanners() {
                this.bannerInfo.pop();
            },

            ...mapActions(["requestPageData", "requestCity"]),
            setSelected(value) {
                this.formData.id_priority = value;
            },
            setFloat(val, attr) {
                if (val.search(".") != -1) val.replace(".", ",");
                this.formData[attr] = parseFloat(val).toFixed(3);
            },
            feedback(model, value, errorMessage) {
                let val = this.formData[value];
                if (errorMessage) return errorMessage;
                if (!(typeof val != "undefined" && val !== null)) return false;
                return !(this.errors.hasOwnProperty(model) && this.errors[model].hasOwnProperty(value));
            },
            onSubmit(e) {
                e.preventDefault();
                let form = document.getElementById("object_form");
                let formData = new FormData(form);

                // formData.append('dsfsd',document.querySelector('#file_input_0'))
                Axios.post(this.$route.path, formData, {
                    headers: {
                        "X-CSRF-Token": this.csrf
                    }
                }).then(response => {
                    if (response.data.ProgramObjects) {
                        let obj = response.data.ProgramObjects;
                        for (let item in obj) {
                            this.setBanner("danger", obj[item][0]);

                            // this.errorReport(obj[item][0]);
                        }
                    } else {
                        if (response.data?.id) {
                            this.$refs.files.sendFile({ id: response.data.id });
                        }
                        this.errors = response.data;
                    }
                });
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
            },
            onReset() {
                this.formData.id_region = 0;
                this.formData.id_city = 0;
                this.formData.kad_number = "";
                this.formData.year = 0;
                this.formData.exploit_year = 0;
                this.formData.wear = 0;
                this.formData.exist_pred_nadz_orgs = "";
                this.formData.osn_isp_zdan = "";
                this.formData.assignment = "";
                this.formData.prav_sob = "";
                this.formData.note = "";
                this.formData.square = 0;
                this.formData.square_kap = 0;
                this.formData.isp_v_ust_dey = 0;
                this.formData.n_isp_v_ust_dey = 0;
                this.formData.square_ar = 0;
            },
            onChangeRegion({ id }) {
                this.requestCity({ id });
            }
        },
        mounted() {
            this.requestPageData({ pageName: "objectCreate" });
            if (this.formData.id_region) this.requestCity({ id: this.formData.id_region });
            this.permission = window.Permission;
        }
    };
</script>
<style scoped>
    .toggle_button {
        display: block;
        cursor: pointer;
    }
</style>
