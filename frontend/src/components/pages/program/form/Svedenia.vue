<template>
    <div class="hidden">

        <b-table
            bordered
            foot-clone
            class="table"
            hover
            caption-top
            :fields="fields"
            :items="stages"
            >
                <template v-slot:cell(is_nessesary)="row">
                    <v-select
                        class="mt-5"
                        v-model="sved.is_nessesary[row.index]"
                        label="type"
                        :options="[
                            {id:0,type:'Да'},
                            {id:1,type:'Нет'}
                        ]"
                        :reduce = "type => type.type"
                        @input="dfgbv"
                    />
                </template>

                <template v-slot:cell(begin_date)="row">
                    <b-form-datepicker 
                        today-button
                        label-today-button="сегодня"
                        reset-button
                        label-reset-button="сбросить"
                        placeholder="дата"
                        size="sm"
                        v-model="sved.begin_date[row.index]"></b-form-datepicker>
                </template>

                <template v-slot:cell(final_date)="row">
                    <b-form-datepicker
                        today-button
                        label-today-button="сегодня"
                        reset-button
                        label-reset-button="сбросить"
                        size="sm"
                        placeholder="дата"
                        v-model="sved.final_date[row.index]"></b-form-datepicker>
                </template>
                <template v-slot:cell(rc)="row">
                    <b-form-input
                        @input="returnResult()"
                        v-if="row.value" 
                        v-model="sved.realization_cost[row.index]" 
                        placeholder="Цена"
                        min="0"
                        type="number"
                        ></b-form-input>
                        <label v-else>-</label>
                </template>
                <template v-slot:cell(kap_cost)="row">
                    <b-form-input
                        @input="getKapSum()"
                        v-if="row.value" 
                        v-model="sved.kap_cost[row.index]" 
                        placeholder="Цена"
                        min="0"
                        type="number"
                        ></b-form-input>
                        <label v-else>-</label>
                </template>
                <template v-slot:cell(finanse)="row">
                    <b-form-input
                        @input="getFinanseSum()"
                        v-if="row.value" 
                        v-model="sved.finanse[row.index]" 
                        placeholder="Цена"
                        min="0"
                        type="number"
                        ></b-form-input>
                        <label v-else>-</label>
                </template>

                
                <template v-slot:foot(stage)>
                    <span class="font-weight-bold">ИТОГО:</span>
                </template>
                <template v-slot:foot(is_nessesary)>
                    <span class="font-weight-bold"></span>
                </template>
                <template v-slot:foot(begin_date)>
                    <span class="font-weight-bold"></span>
                </template>
                <template v-slot:foot(final_date)>
                    <span class="font-weight-bold"></span>
                </template>
                <template v-slot:foot(rc)>
                    <span class="font-weight-bold">{{ rc_full }}</span>
                </template>
                <template v-slot:foot(kap_cost)>
                    <span class="font-weight-bold">{{ kap_sum }}</span>
                </template>
                <template v-slot:foot(finanse)>
                    <span class="font-weight-bold">{{ finanse_sum }}</span>
                </template>

        </b-table>
    </div>
</template>

<script>
import BootstrapVue from 'bootstrap-vue';
import Multiselect from 'vue-select';

    export default {
        name: "Svedenia",
        components: {
            "v-select": Multiselect,    
        },
        computed: {
            rc_full() {
                var sum = 0
                for(var i=0; i <= this.sved.realization_cost.length-1; i++){
                    sum = sum + parseInt(this.sved.realization_cost[i]);
                }
                if(isNaN(sum)) {
                    sum = 0
                }
                return sum
            }
        },
        data() {
            return {
                options: ['Da', 'Net'],
                fields: [
                    {key: 'stage', label: 'Этап'},
                    {key: 'is_nessesary', label: 'Необходимость выполнения'},
                    {key: 'begin_date', label: 'Дата начала', tdClass: 'date'},
                    {key: 'final_date', label: 'Дата окончания', tdClass: 'date'},
                    {key: 'rc', label: 'Стоимость реализации (тыс.руб)'},
                    {key: 'kap_cost', label: 'Сумма бюджетного финансирования на проведение кап.ремонта (тыс.руб)'},
                    {key: 'finanse', label: 'Софинансирование из внебюджетных источников (тыс.руб)'},
                ],
                stages: [
                    {
                        'stage': 'Проведение тендера и заключение договора на выполнение обследования', 
                        'rc': false,
                        'kap_cost': false,
                        'finanse':  false
                    },
                    {
                        'stage': 'Вполнение обследования, плжготовка и утверждение дефектного акта', 
                        'rc': true,
                        'kap_cost': false,
                        'finanse':  true
                    },
                    {
                        'stage': 'Утверждение задания на проектирование',
                        'rc': false,
                        'kap_cost': false,
                        'finanse':  false
                    },
                    {
                        'stage': 'Проведение тендера и заключение договора на подготовку проектно-сметной документации',
                        'rc': false,
                        'kap_cost': false,
                        'finanse':  false
                    },
                    {
                        'stage': 'Подготовка проектно-сметной документации',
                        'rc': true,
                        'kap_cost': true,
                        'finanse':  true
                    },
                    {
                        'stage': 'Прохождение экспертизы проектно-сметной документации',
                        'rc': true,
                        'kap_cost': true,
                        'finanse':  true
                    },
                    {
                        'stage': 'Проведение тендера и заключение договора на выполнение строительно-монтажных работ',
                        'rc': false,
                        'kap_cost': false,
                        'finanse':  false
                    },
                    {
                        'stage': 'Выполнение строительно-монтажных работ',
                        'rc': true,
                        'kap_cost': true,
                        'finanse':  true
                    },
 
                ],
                sved: {
                    is_nessesary: [],
                    begin_date: [],
                    final_date: [],
                    realization_cost: [],
                    kap_cost: [],
                    finanse:[]
                },
                rc_sum: 0,
                kap_sum: 0,
                finanse_sum: 0
            }
        },
        methods: {
            returnResult() {
                console.log(this.sved.realization_cost)
            },
            updateIsNessesary(id, type) {
                console.log(id, type)
            },
            dfgbv() {
                console.log(this.sved)
            },
            getRcSum(){
                var sum = this.rc_sum
                for(let key in this.sved.realization_cost) {
                    sum += parseInt(this.sved.realization_cost[key]);
                }
                if(isNaN(sum)) {
                    this.rc_sum = 0
                } else {
                    this.rc_sum = sum
                }
            }, 
            getKapSum(){
                var sum = 0;
                for(let key in this.sved.kap_cost) {
                    sum += parseInt(this.sved.kap_cost[key]);
                }
                if(isNaN(sum)) {
                    this.kap_sum = 0
                } else {
                    this.kap_sum = sum
                }
            },
            getFinanseSum(){
                var sum = 0;
                for(let key in this.sved.finanse) {
                    sum += parseInt(this.sved.finanse[key]);
                }
                if(isNaN(sum)) {
                    this.finanse_sum = 0
                } else {
                    this.finanse_sum = sum
                }
            }
        },
        mounted() {

        },
        watch: {

        }
    }
</script>

<style soped>
.nameOfTheClass {
   width: 600px !important;
}
.date {
    width: 500px !important;
}
.table{
    overflow: hidden;
}
.hidden {
    overflow: hidden;
    overflow-x: scroll; 
}
</style>
